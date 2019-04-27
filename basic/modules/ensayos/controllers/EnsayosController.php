<?php

namespace app\modules\ensayos\controllers;

use Yii;
use app\modules\calendarios\models\CalendarioCalibracion;
use app\modules\ensayos\models\SeguimientoCalibracion;
use app\modules\ensayos\models\CalendarioClientes;
use app\modules\ensayos\models\EvidenciaCalibracion;
use app\modules\ensayos\models\EvidenciaGeneral;
use app\modules\calendarios\models\Calendario;
use app\modules\catalogos\models\Areas;
use app\modules\catalogos\models\Subramas;
use app\modules\catalogos\models\Referencias;
use app\modules\catalogos\models\Analitos;
use app\modules\catalogos\models\Ramas;
use app\modules\catalogos\models\Estatus;
use app\modules\cotizaciones\models\CotizacionCalibracion;
use app\modules\cotizaciones\models\CotizacionGeneral;
use app\modules\ensayos\models\SeguimientoGeneral;
use app\modules\calendarios\models\LineamientosCalibracion;
use app\modules\calendarios\models\LineamientosGeneral;
use app\modules\ensayos\models\ResultadosSubmuestrasCalibracion;
use app\modules\ensayos\models\ResultadosSubmuestrasGeneral;
use app\modules\ensayos\models\UnidadesResultados;
use app\modules\ensayos\models\FormCargaSubmuestra;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;
use yii\web\Response;

class EnsayosController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex() {
        $this->layout = '@app/views/layouts/customer';
        return $this->render('index');
    }

    public function actionHistorial() {
        $this->layout = '@app/views/layouts/customer';
        $idcte = Yii::$app->user->identity->idcte;

        $dataEnsayosCalibracion = new ActiveDataProvider([
            'query' => CotizacionCalibracion::find()
                    ->innerJoinWith(['idcot0'])
                    ->andWhere(['idcte' => $idcte])
                    ->andWhere(['not', ['aceptado' => null]])
                    ->with('idarea0')
                    ->innerJoinWith('seguimiento0'),
            'sort' => [
                'defaultOrder' => [
                    'idcot' => 'SORT_DESC',
                ]
            ],
            'pagination' => [
                'pageSize' => 25,
            ],
        ]);

        /* new ActiveDataProvider([
          'query' => SeguimientoCalibracion::find()->with('idcot0'),
          ]); */

        $dataEnsayosGenerales = new ActiveDataProvider([
            'query' => CotizacionGeneral::find()
                    ->innerJoinWith(['idcot0'])
                    ->andWhere(['idcte' => $idcte])
                    ->andWhere(['not', ['aceptado' => null]])
                    ->with('idrama0')
                    ->innerJoinWith('seguimiento0'),
            'sort' => [
                'defaultOrder' => [
                    'idcot' => 'SORT_DESC',
                ]
            ],
            'pagination' => [
                'pageSize' => 25,
            ],
        ]);
        /* new ActiveDataProvider([
          'query' => CalendarioClientes::find()->with('idrama0','idcte0'),
          ]); */

        return $this->render('Historial', [
                    'dataEnsayosCalibracion' => $dataEnsayosCalibracion,
                    'dataEnsayosGenerales' => $dataEnsayosGenerales
        ]);
    }

    // REVISADO
    public function actionSubirevidencia($idetapa) {
        Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/assets/';
        //Yii::$app->params['uploadPath'] = Yii::$app->request->baseUrl . '/assets/';

        $idarea = $_POST['SeguimientoCalibracion']['idarea'];
        $idref = $_POST['SeguimientoCalibracion']['idreferencia'];
        $idcot = $_POST['SeguimientoCalibracion']['idcot'];

        $nofiles = EvidenciaCalibracion::find()->where(['idarea' => $idarea, 'idreferencia' => $idref, 'idcot' => $idcot])->count();
        $model = new EvidenciaCalibracion();
        $model->idarea = $idarea;
        $model->idreferencia = $idref;
        $model->idcot = $idcot;
        $model->nofiles = $nofiles;
        $model->fecha = date('Y-m-d');

        if ($model->load(Yii::$app->request->post())) {
            // get the uploaded file instance. for multiple file uploads
            // the following data will return an array
            if ($idetapa == 7) {
                $image = UploadedFile::getInstance($model, 'excel');
            } else {
                $image = UploadedFile::getInstance($model, 'image');
            }

            if (!empty($image)) {
                // store the source file name
                $model->file = $image->name;
                $ext = end((explode(".", $image->name)));

                // generate a unique file name
                $model->hash = Yii::$app->security->generateRandomString() . ".{$ext}";
                $model->idetapa = $idetapa;

                // the path to save file, you can set an uploadPath
                // in Yii::$app->params (as used in example below)
                $path = Yii::$app->params['uploadPath'] . $model->hash;

                if ($model->save(false)) {
                    $image->saveAs($path);
                    Yii::$app->session->setFlash('success', 'El archivo con la evidencia fue registrada exitosamente');
                } else {
                    Yii::$app->session->setFlash('danger', 'Ocurrio un error al intentar subir el archivo, intente de nuevo');
                }
            } else
                Yii::$app->session->setFlash('danger', 'Debes seleccionar un archivo');
        }

        return $this->redirect(['seguimientocalibracion', 'idarea' => $idarea, 'idref' => $idref, 'idcot' => $idcot]);
    }

    // REVISADO IDCTE -> IDCOT
    public function actionTerminarordencompra($idarea, $idref, $idcot) {
        $nofiles = EvidenciaCalibracion::find()->where(['idarea' => $idarea, 'idreferencia' => $idref, 'idcot' => $idcot, 'idetapa' => 1])->count();
        if ($nofiles > 0) {
            $model = SeguimientoCalibracion::find()->where(['idarea' => $idarea, 'idreferencia' => $idref, 'idcot' => $idcot])->one();
            $model->termina_odec = date('Y-m-d');
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'El envio de evidencia de la Orden de Compra / Cotización fue terminada exitosamente');
            }
        } else
            Yii::$app->session->setFlash('danger', 'No se puede terminar la etapa sin haber enviado evidencias de la orden de compra o cotización');

        return $this->redirect(['seguimientocalibracion', 'idarea' => $idarea, 'idref' => $idref, 'idcot' => $idcot]);
    }

    // REVISADO
    public function actionTerminarpago($idarea, $idref, $idcot) {
        $nofiles = EvidenciaCalibracion::find()->where(['idarea' => $idarea, 'idreferencia' => $idref, 'idcot' => $idcot, 'idetapa' => 2])->count();
        if ($nofiles > 0) {
            $model = SeguimientoCalibracion::find()->where(['idarea' => $idarea, 'idreferencia' => $idref, 'idcot' => $idcot])->one();
            $model->termina_pago = date('Y-m-d');
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'El envio de la evidencia de pago fue terminada exitosamente');
            }
        } else
            Yii::$app->session->setFlash('danger', 'No se puede terminar la etapa sin haber enviado evidencias del pago');

        return $this->redirect(['seguimientocalibracion', 'idarea' => $idarea, 'idref' => $idref, 'idcot' => $idcot]);
    }

    // REVISADO
    public function actionTerminaraceptacion($idarea, $idref, $idcot) {
        $nofiles = EvidenciaCalibracion::find()->where(['idarea' => $idarea, 'idreferencia' => $idref, 'idcot' => $idcot, 'idetapa' => 3])->count();
        if ($nofiles > 0) {
            $model = SeguimientoCalibracion::find()->where(['idarea' => $idarea, 'idreferencia' => $idref, 'idcot' => $idcot])->one();
            $model->termina_aceptacion = date('Y-m-d');
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'El envio de la evidencia de aceptación de los lineamientos del ensayo fue terminada exitosamente');
            }
        } else
            Yii::$app->session->setFlash('danger', 'No se puede terminar la etapa sin haber enviado evidencias de la aceptación de los lineamientos del ensayo');

        return $this->redirect(['seguimientocalibracion', 'idarea' => $idarea, 'idref' => $idref, 'idcot' => $idcot]);
    }

    // REVISADO
    public function actionTerminarrecepcion($idarea, $idref, $idcot) {
        $nofiles = EvidenciaCalibracion::find()->where(['idarea' => $idarea, 'idreferencia' => $idref, 'idcot' => $idcot, 'idetapa' => 5])->count();
        if ($nofiles > 0) {
            $model = SeguimientoCalibracion::find()->where(['idarea' => $idarea, 'idreferencia' => $idref, 'idcot' => $idcot])->one();
            $model->termina_recepcion = date('Y-m-d');
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'El envio de la evidencia de la recepcion del elemento de ensayo fue terminada exitosamente');
            }
        } else
            Yii::$app->session->setFlash('danger', 'No se puede terminar la etapa sin haber enviado evidencias de la recepción del elemento de ensayo');

        return $this->redirect(['seguimientocalibracion', 'idarea' => $idarea, 'idref' => $idref, 'idcot' => $idcot]);
    }

    // REVISADO
    public function actionTerminarentrega($idarea, $idref, $idcot) {
        $nofiles = EvidenciaCalibracion::find()->where(['idarea' => $idarea, 'idreferencia' => $idref, 'idcot' => $idcot, 'idetapa' => 6])->count();
        if ($nofiles > 0) {
            $model = SeguimientoCalibracion::find()->where(['idarea' => $idarea, 'idreferencia' => $idref, 'idcot' => $idcot])->one();
            $model->termina_entrega = date('Y-m-d');
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'El envio de la evidencia de la entrega del elemento de ensayo fue terminada exitosamente');
            }
        } else
            Yii::$app->session->setFlash('danger', 'No se puede terminar la etapa sin haber enviado evidencias de la entrega del elemento de ensayo');

        return $this->redirect(['seguimientocalibracion', 'idarea' => $idarea, 'idref' => $idref, 'idcot' => $idcot]);
    }

    public function actionTerminaresultados($idarea, $idref, $idcot) {
        $nofiles = EvidenciaCalibracion::find()->where(['idarea' => $idarea, 'idreferencia' => $idref, 'idcot' => $idcot, 'idetapa' => 7])->count();
        if ($nofiles > 0) {
            $model = SeguimientoCalibracion::find()->where(['idarea' => $idarea, 'idreferencia' => $idref, 'idcot' => $idcot])->one();
            $model->termina_resultados = date('Y-m-d');
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'El envio de la evidencia de la entrega del elemento de ensayo fue terminada exitosamente');
            }
        } else
            Yii::$app->session->setFlash('danger', 'No se puede terminar la etapa sin haber enviado evidencias de la entrega del elemento de ensayo');

        return $this->redirect(['seguimientocalibracion', 'idarea' => $idarea, 'idref' => $idref, 'idcot' => $idcot]);
    }

    // REVISADO
    public function actionSeguimientocalibracion($idarea, $idref, $idcot) {
        $this->layout = '@app/views/layouts/customer';

        $model = SeguimientoCalibracion::find()->where(['idarea' => $idarea, 'idreferencia' => $idref, 'idcot' => $idcot])->one();
        $model_calibracion = CalendarioCalibracion::find()->with('idarea0', 'idreferencia0', 'idestatus0')->where(['idarea' => $idarea, 'idreferencia' => $idref])->one();
        $model_evidencia = new EvidenciaCalibracion();
        $model_resultados_calibracion = new ResultadosSubmuestrasCalibracion();

        $dataOdeC = new ActiveDataProvider([
            'query' => EvidenciaCalibracion::find()->with('idcot0')->where(['idarea' => $idarea, 'idreferencia' => $idref, 'idcot' => $idcot, 'idetapa' => 1]),
        ]);

        $dataPago = new ActiveDataProvider([
            'query' => EvidenciaCalibracion::find()->with('idcot0')->where(['idarea' => $idarea, 'idreferencia' => $idref, 'idcot' => $idcot, 'idetapa' => 2]),
        ]);

        $dataAceptacion = new ActiveDataProvider([
            'query' => EvidenciaCalibracion::find()->with('idcot0')->where(['idarea' => $idarea, 'idreferencia' => $idref, 'idcot' => $idcot, 'idetapa' => 3]),
        ]);

        $dataRecepcion = new ActiveDataProvider([
            'query' => EvidenciaCalibracion::find()->with('idcot0')->where(['idarea' => $idarea, 'idreferencia' => $idref, 'idcot' => $idcot, 'idetapa' => 5]),
        ]);

        $dataEntrega = new ActiveDataProvider([
            'query' => EvidenciaCalibracion::find()->with('idcot0')->where(['idarea' => $idarea, 'idreferencia' => $idref, 'idcot' => $idcot, 'idetapa' => 6]),
        ]);

        $filesResultado = new ActiveDataProvider([
            'query' => EvidenciaCalibracion::find()->with('idcot0')->where(['idarea' => $idarea, 'idreferencia' => $idref, 'idcot' => $idcot, 'idetapa' => 7]),
        ]);

        $dataLinea = new ActiveDataProvider([
            'query' => LineamientosCalibracion::find()->where(['idarea' => $idarea, 'idreferencia' => $idref]),
        ]);

        $cotCalibracion = CotizacionCalibracion::find()->where(['idarea' => $idarea, 'idreferencia' => $idref, 'idcot' => $idcot])->one();

        $dataResultados = new ActiveDataProvider([
            'query' => ResultadosSubmuestrasCalibracion::find()->with('idunidad0')->where(['idarea' => $idarea, 'idreferencia' => $idref, 'idcot' => $idcot]),
        ]);

        $cantSubMuestra = ResultadosSubmuestrasCalibracion::find()->where(['idarea' => $idarea, 'idreferencia' => $idref, 'idcot' => $idcot])->count();

        //$model_area = Areas::find()->where(['idarea'=>$idarea])->one();
        //$model_refe = Referencias::find()->where(['idreferencia'=>$idref])->one();

        return $this->render('SeguimientoCalibracion', [
                    'model' => $model,
                    'model_calibracion' => $model_calibracion,
                    'model_evidencia' => $model_evidencia,
                    'dataOdeC' => $dataOdeC,
                    'dataPago' => $dataPago,
                    'dataAceptacion' => $dataAceptacion,
                    'dataRecepcion' => $dataRecepcion,
                    'dataEntrega' => $dataEntrega,
                    'dataLinea' => $dataLinea,
                    'cotCalibracion' => $cotCalibracion,
                    'dataResultados' => $dataResultados,
                    'cantSubMuestra' => $cantSubMuestra,
                    'model_resultados_calibracion' => $model_resultados_calibracion,
                    'idarea' => $idarea,
                    'idref' => $idref,
                    'idcot' => $idcot,
                    'filesResultado' => $filesResultado,
                        //'model_area' => $model_area,
                        //'model_ref'  => $model_refe           
        ]);
    }

    // REVISADO
    public function actionSeguimientogeneral($idrama, $idsubrama, $idanalito, $idref, $idcot) {
        $this->layout = '@app/views/layouts/customer';

        $model = SeguimientoGeneral::find()->where(['idrama' => $idrama, 'idsubrama' => $idsubrama, 'idanalito' => $idanalito, 'idreferencia' => $idref, 'idcot' => $idcot])->one();
        $model_calendario = Calendario::find()->with('idrama0', 'idsubrama0', 'idanalito0', 'idreferencia0', 'idestatus0')->where(['idrama' => $idrama, 'idsubrama' => $idsubrama, 'idanalito' => $idanalito, 'idreferencia' => $idref])->one();
        $model_evidencia = new EvidenciaGeneral();
        $model_resultados_general = new ResultadosSubmuestrasGeneral();

        $dataOdeC = new ActiveDataProvider([
            'query' => EvidenciaGeneral::find()->where(['idrama' => $idrama, 'idsubrama' => $idsubrama, 'idanalito' => $idanalito, 'idreferencia' => $idref, 'idcot' => $idcot, 'idetapa' => 1]),
        ]);

        $dataPago = new ActiveDataProvider([
            'query' => EvidenciaGeneral::find()->where(['idrama' => $idrama, 'idsubrama' => $idsubrama, 'idanalito' => $idanalito, 'idreferencia' => $idref, 'idcot' => $idcot, 'idetapa' => 2]),
        ]);

        $dataAceptacion = new ActiveDataProvider([
            'query' => EvidenciaGeneral::find()->where(['idrama' => $idrama, 'idsubrama' => $idsubrama, 'idanalito' => $idanalito, 'idreferencia' => $idref, 'idcot' => $idcot, 'idetapa' => 3]),
        ]);

        $dataRecepcion = new ActiveDataProvider([
            'query' => EvidenciaGeneral::find()->where(['idrama' => $idrama, 'idsubrama' => $idsubrama, 'idanalito' => $idanalito, 'idreferencia' => $idref, 'idcot' => $idcot, 'idetapa' => 5]),
        ]);

        $dataEntrega = new ActiveDataProvider([
            'query' => EvidenciaGeneral::find()->where(['idrama' => $idrama, 'idsubrama' => $idsubrama, 'idanalito' => $idanalito, 'idreferencia' => $idref, 'idcot' => $idcot, 'idetapa' => 6]),
        ]);

        $filesResultado = new ActiveDataProvider([
            'query' => EvidenciaGeneral::find()->with('idcot0')->where(['idrama' => $idrama, 'idreferencia' => $idref, 'idcot' => $idcot, 'idetapa' => 7]),
        ]);

        $dataLinea = new ActiveDataProvider([
            'query' => LineamientosGeneral::find()->where(['idrama' => $idrama, 'idsubrama' => $idsubrama, 'idanalito' => $idanalito, 'idreferencia' => $idref]),
        ]);

        $cotGeneral = CotizacionGeneral::find()->where(['idrama' => $idrama, 'idsubrama' => $idsubrama, 'idanalito' => $idanalito, 'idreferencia' => $idref, 'idcot' => $idcot])->one();

        $dataResultados = new ActiveDataProvider([
            'query' => ResultadosSubmuestrasGeneral::find()->with('idunidad0')->where(['idrama' => $idrama, 'idsubrama' => $idsubrama, 'idanalito' => $idanalito, 'idreferencia' => $idref, 'idcot' => $idcot]),
        ]);

        $cantSubMuestra = ResultadosSubmuestrasGeneral::find()->where(['idrama' => $idrama, 'idsubrama' => $idsubrama, 'idanalito' => $idanalito, 'idreferencia' => $idref, 'idcot' => $idcot])->count();

        return $this->render('SeguimientoGeneral', [
                    'model' => $model,
                    'model_calendario' => $model_calendario,
                    'model_evidencia' => $model_evidencia,
                    'dataOdeC' => $dataOdeC,
                    'dataPago' => $dataPago,
                    'dataAceptacion' => $dataAceptacion,
                    'dataRecepcion' => $dataRecepcion,
                    'dataEntrega' => $dataEntrega,
                    'dataLinea' => $dataLinea,
                    'cotGeneral' => $cotGeneral,
                    'dataResultados' => $dataResultados,
                    'cantSubMuestra' => $cantSubMuestra,
                    'model_resultados_general' => $model_resultados_general,
                    'idrama' => $idrama,
                    'idsubrama' => $idsubrama,
                    'idanalito' => $idanalito,
                    'idreferencia' => $idref,
                    'idcot' => $idcot,
                    'filesResultado' => $filesResultado,
                        //'model_area' => $model_area,
                        //'model_ref'  => $model_refe           
        ]);
    }

    // REVISADO
    public function actionSubirevidenciagen($idetapa) {
        Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/assets/';

        $idrama = $_POST['SeguimientoGeneral']['idrama'];
        $idsubrama = $_POST['SeguimientoGeneral']['idsubrama'];
        $idanalito = $_POST['SeguimientoGeneral']['idanalito'];
        $idref = $_POST['SeguimientoGeneral']['idreferencia'];
        $idcot = $_POST['SeguimientoGeneral']['idcot'];

        $nofiles = EvidenciaGeneral::find()->where(['idrama' => $idrama, 'idsubrama' => $idsubrama, 'idanalito' => $idanalito, 'idreferencia' => $idref, 'idcot' => $idcot])->count();
        $model = new EvidenciaGeneral();
        $model->idrama = $idrama;
        $model->idsubrama = $idsubrama;
        $model->idanalito = $idanalito;
        $model->idreferencia = $idref;
        $model->idcot = $idcot;
        $model->nofiles = $nofiles;
        $model->fecha = date('Y-m-d');

        if ($model->load(Yii::$app->request->post())) {
            // get the uploaded file instance. for multiple file uploads
            // the following data will return an array
            if ($idetapa == 7) {
                $image = UploadedFile::getInstance($model, 'excel');
            } else {
                $image = UploadedFile::getInstance($model, 'image');
            }

            if (!empty($image)) {
                // store the source file name
                $model->file = $image->name;
                $ext = end((explode(".", $image->name)));

                // generate a unique file name
                $model->hash = Yii::$app->security->generateRandomString() . ".{$ext}";
                $model->idetapa = $idetapa;

                // the path to save file, you can set an uploadPath
                // in Yii::$app->params (as used in example below)
                $path = Yii::$app->params['uploadPath'] . $model->hash;

                if ($model->save()) {
                    $image->saveAs($path);
                    Yii::$app->session->setFlash('success', 'El archivo con la evidencia fue registrada exitosamente');
                } else {
                    Yii::$app->session->setFlash('danger', 'Ocurrio un error al intentar subir el archivo, intente de nuevo');
                }
            } else
                Yii::$app->session->setFlash('danger', 'Debes seleccionar un archivo');
        }
        return $this->redirect(['seguimientogeneral', 'idrama' => $idrama, 'idsubrama' => $idsubrama, 'idanalito' => $idanalito, 'idref' => $idref, 'idcot' => $idcot]);
    }

    // REVISADO
    public function actionTerminaretapagen($idrama, $idsubrama, $idanalito, $idref, $idcot, $idetapa) {
        $nofiles = EvidenciaGeneral::find()->where(['idrama' => $idrama, 'idsubrama' => $idsubrama, 'idanalito' => $idanalito, 'idreferencia' => $idref, 'idcot' => $idcot, 'idetapa' => $idetapa])->count();
        if ($nofiles > 0) {
            $model = SeguimientoGeneral::find()->where(['idrama' => $idrama, 'idsubrama' => $idsubrama, 'idanalito' => $idanalito, 'idreferencia' => $idref, 'idcot' => $idcot])->one();
            switch ($idetapa) {
                case 1:
                    $model->termina_odec = date('Y-m-d');
                    break;
                case 2:
                    $model->termina_pago = date('Y-m-d');
                    break;
                case 3:
                    $model->termina_aceptacion = date('Y-m-d');
                    break;
                case 5:
                    $model->termina_recepcion = date('Y-m-d');
                    break;
                case 6:
                    $model->termina_entrega = date('Y-m-d');
                    break;
                case 7:
                    $model->termina_resultados = date('Y-m-d');
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'El envio de la evidencia fue terminada exitosamente');
            }
        } else {
            Yii::$app->session->setFlash('danger', 'No se puede terminar la etapa sin haber enviado las evidencias necesarias, envie al menos una evidencia');
        }

        return $this->redirect(['seguimientogeneral', 'idrama' => $idrama, 'idsubrama' => $idsubrama, 'idanalito' => $idanalito, 'idref' => $idref, 'idcot' => $idcot]);
    }

    // FUNCIÓN PARA ETIQUETAR EL ENSAYO COMO DE CRÉDITO A LOS ENSAYOS DE CALIBRACIÓN
    public function actionCredito($idarea, $idref, $idcot, $credito) {
        $model = SeguimientoCalibracion::find()->where(['idarea' => $idarea, 'idreferencia' => $idref, 'idcot' => $idcot])->one();
        $aceptacion = EvidenciaCalibracion::find()->where(['idarea' => $idarea, 'idreferencia' => $idref, 'idcot' => $idcot, 'idetapa' => 3])->count();

        if ($model->valida_odec != null && $aceptacion == 0) {
            $model->credito = $credito;
            if ($model->save())
                $mensaje = 'El ensayo se ha marcado como pago a crédito correctamente';
            $tipo = 'success';
        }
        else {
            $mensaje = 'No se puede marcar el ensayo como de crédito sino se ha validado la Orden de Compra o si ya se ha enviado la Carta de Aceptación';
            $tipo = 'danger';
        }

        // Enviamos el mensaje de alerta dependiendo de la acción realizada
        $this->Alerta($mensaje, $tipo);
        $this->redirect(['/site']);
    }

    // FUNCIÓN PARA ETIQUETAR EL ENSAYO COMO DE CRÉDITO A LOS ENSAYOS GENERALES
    public function actionCreditogen($idrama, $idsubrama, $idanalito, $idref, $idcot, $credito) {
        $model = SeguimientoGeneral::find()->where(['idrama' => $idrama, 'idsubrama' => $idsubrama, 'idanalito' => $idanalito, 'idreferencia' => $idref, 'idcot' => $idcot])->one();
        $aceptacion = EvidenciaGeneral::find()->where(['idrama' => $idrama, 'idsubrama' => $idsubrama, 'idanalito' => $idanalito, 'idreferencia' => $idref, 'idcot' => $idcot, 'idetapa' => 3])->count();
        if ($model->valida_odec != null && $aceptacion == 0) {
            $model->credito = $credito;
            if ($model->save()) {
                $mensaje = 'El tipo de pago del ensayo se ha actualizado correctamente!!!';
                $tipo = 'success';
            }
        } else {
            $mensaje = 'No se puede marcar el ensayo como de crédito sino se ha validado la Orden de Compra o si ya se ha enviado la Carta de Aceptación';
            $tipo = 'danger';
        }

        // Enviamos el mensaje de alerta dependiendo de la acción realizada
        $this->Alerta($mensaje, $tipo);
        $this->redirect(['/site']);
    }

    // ACCIÓN PARA PODER VISUALIZAR LOS LINEAMIENTOS DE UN DETERMINADO ENSAYO DE CALIBRACIÓN
    public function actionVerlineamientoscal($idLinea) {
        $linea = LineamientosCalibracion::find()->where(['idlineamiento' => $idLinea])->one();
        $this->actionVerarchivo($linea->file_linea, $linea->hash_linea);
    }

    // ACCIÓN PARA PODER VISUALIZAR LOS LINEAMIENTOS DE UN DETERMINADO ENSAYO DE CALIBRACIÓN
    public function actionVerlineamientosgen($idLinea) {
        $ensayo = LineamientosGeneral::find()->where(['idlineamiento' => $idLinea])->one();
        $this->actionVerarchivo($ensayo->file_linea, $ensayo->hash_linea);
    }

    // FUNCION PARA DESPLEGAR EL ARCHIVO DE GENERALIDADES
    public function actionVercarta() {
        //$filePath = Yii::getAlias('@app').'/assets/49vgQrU12yEzKEUugnsCRN2vHJr8duSY.pdf';
        $filePath = Yii::getAlias('@app') . '/web/docs/ACEPTACION_PROTOCOLO_M-05-2017.docx';

        //return Yii::$app->response->sendFile($filePath, $model->fileName);
        return Yii::$app->response->sendFile($filePath, "Generalidades.docx", ['inline' => true]);
    }

    public function actionVerarchivo($file, $hash) {
        $filePath = Yii::getAlias('@app') . '/assets/' . $hash;
        return Yii::$app->response->sendFile($filePath, $file, ['inline' => true]);
    }

    private function Alerta($mensaje, $tipo) {
        Yii::$app->getSession()->setFlash('success', [
            'type' => $tipo,
            'duration' => 5000,
            'icon' => 'fa fa-flag',
            'message' => $mensaje,
            'title' => 'Notificación del Sistema',
            'positonY' => 'top',
            'positonX' => 'right'
        ]);
    }

    public function actionCapturarsubmuestras() {
        $model = new ResultadosSubmuestrasCalibracion();
        $unidades = ArrayHelper::map(UnidadesResultados::find()->all(), 'idunidad', 'nombre');
        return $this->renderAjax('capturarsubmuestra', ['model' => $model, 'unidades' => $unidades]);
    }

    public function actionCapturarsubmuestrageneral() {
        $model = new ResultadosSubmuestrasGeneral();
        $unidades = ArrayHelper::map(UnidadesResultados::find()->all(), 'idunidad', 'nombre');
        return $this->renderAjax('capturarsubmuestrageneral', ['model' => $model, 'unidades' => $unidades]);
    }

    public function actionActualizarsubmuestra() {
        $model = new ResultadosSubmuestrasCalibracion();
        $model->idarea = $_GET['idarea'];
        $model->idreferencia = $_GET['idref'];
        $model->idcot = $_GET['idcot'];
        $model->no_submuestra = $_GET['no_submuestra'];
        $model->parametro = $_GET['parametro'];
        $dataResultado = ResultadosSubmuestrasCalibracion::find()->where(['idarea' => $model->idarea, 'idreferencia' => $model->idreferencia, 'idcot' => $model->idcot, 'no_submuestra' => $model->no_submuestra])->one();
        $model->idunidad = $dataResultado->idunidad;
        $model->resultado = $dataResultado->resultado;
        $unidades = ArrayHelper::map(UnidadesResultados::find()->all(), 'idunidad', 'nombre');
        return $this->renderAjax('actualizarsubmuestra', ['model' => $model, 'unidades' => $unidades]);
    }

    public function actionActualizarsubmuestrageneral() {
        $model = new ResultadosSubmuestrasGeneral();
        $model->idrama = $_GET['idrama'];
        $model->idsubrama = $_GET['idsubrama'];
        $model->idreferencia = $_GET['idref'];
        $model->idanalito = $_GET['idanalito'];
        $model->idcot = $_GET['idcot'];
        $model->no_submuestra = $_GET['no_submuestra'];
        $model->parametro = $_GET['parametro'];
        $dataResultado = ResultadosSubmuestrasGeneral::find()->where(['idrama' => $model->idrama, 'idsubrama' => $model->idsubrama, 'idanalito' => $model->idanalito, 'idreferencia' => $model->idreferencia, 'idcot' => $model->idcot])->one();
        $model->idunidad = $dataResultado->idunidad;
        $model->resultado = $dataResultado->resultado;
        $unidades = ArrayHelper::map(UnidadesResultados::find()->all(), 'idunidad', 'nombre');
        return $this->renderAjax('actualizarsubmuestrageneral', ['model' => $model, 'unidades' => $unidades]);
    }

    public function actionRegistrarsubmuestra() {
        $model = new ResultadosSubmuestrasCalibracion();
        if ($model->load(Yii::$app->request->post())) {
            $model->no_submuestra = ResultadosSubmuestrasCalibracion::find()->where(['idarea' => $model->idarea, 'idreferencia' => $model->idreferencia, 'idcot' => $model->idcot])->count() + 1;
            $model->fecha_captura = date('Y-m-d');
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'La Sub Muestra fue resgistrada correctamente');
            } else {
                Yii::$app->session->setFlash('danger', 'Ocurrio un error al registrar la Sub Muestra');
            }
            return $this->redirect(["seguimientocalibracion", 'idarea' => $model->idarea, 'idref' => $model->idreferencia, 'idcot' => $model->idcot]);
        } else {
            Yii::$app->session->setFlash('danger', 'No se enviaron datos');
            return $this->redirect(["site/index"]);
        }
    }

    public function actionRegistrarsubmuestrageneral() {
        $model = new ResultadosSubmuestrasGeneral();
        if ($model->load(Yii::$app->request->post())) {
            $model->no_submuestra = ResultadosSubmuestrasGeneral::find()->where(['idrama' => $model->idrama, 'idsubrama' => $model->idsubrama, 'idanalito' => $model->idanalito, 'idreferencia' => $model->idreferencia, 'idcot' => $model->idcot])->count() + 1;
            $model->fecha_captura = date('Y-m-d');
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'La Sub Muestra fue resgistrada correctamente');
            } else {
                Yii::$app->session->setFlash('danger', 'Ocurrio un error al registrar la Sub Muestra');
            }
            return $this->redirect(["seguimientogeneral", 'idrama' => $model->idrama, 'idsubrama' => $model->idsubrama, 'idanalito' => $model->idanalito, 'idref' => $model->idreferencia, 'idcot' => $model->idcot]);
        } else {
            Yii::$app->session->setFlash('danger', 'No se enviaron datos');
            return $this->redirect(["site/index"]);
        }
    }

    public function actionActualizarsubmuestraenvio() {
        $model = new ResultadosSubmuestrasCalibracion();
        if ($model->load(Yii::$app->request->post())) {
            $table = ResultadosSubmuestrasCalibracion::find()->where(['idarea' => $model->idarea, 'idreferencia' => $model->idreferencia, 'idcot' => $model->idcot, 'no_submuestra' => $model->no_submuestra])->one();
            if ($table) {
                $table->resultado = $model->resultado;
                $table->idunidad = $model->idunidad;
                if ($table->update()) {
                    Yii::$app->session->setFlash('success', 'La Sub Muestra fue resgistrada correctamente');
                } else {
                    Yii::$app->session->setFlash('danger', 'Ocurrio un error al registrar la Sub Muestra');
                }
                return $this->redirect(["seguimientocalibracion", 'idarea' => $model->idarea, 'idref' => $model->idreferencia, 'idcot' => $model->idcot]);
            } else {
                return $this->redirect(["seguimientocalibracion", 'idarea' => $model->idarea, 'idref' => $model->idreferencia, 'idcot' => $model->idcot]);
            }
        } else {
            Yii::$app->session->setFlash('danger', 'No se enviaron datos');
            return $this->redirect(["site/index"]);
        }
    }

    public function actionActualizarsubmuestraenviogeneral() {
        $model = new ResultadosSubmuestrasGeneral();
        if ($model->load(Yii::$app->request->post())) {
            $table = ResultadosSubmuestrasGeneral::find()->where(['idrama' => $model->idrama, 'idsubrama' => $model->idsubrama, 'idanalito' => $model->idanalito, 'idreferencia' => $model->idreferencia, 'idcot' => $model->idcot])->one();
            if ($table) {
                $table->resultado = $model->resultado;
                $table->idunidad = $model->idunidad;
                if ($table->update()) {
                    Yii::$app->session->setFlash('success', 'La Sub Muestra fue resgistrada correctamente');
                } else {
                    Yii::$app->session->setFlash('danger', 'Ocurrio un error al registrar la Sub Muestra');
                }
                return $this->redirect(["seguimientogeneral", 'idrama' => $model->idrama, 'idsubrama' => $model->idsubrama, 'idanalito' => $model->idanalito, 'idref' => $model->idreferencia, 'idcot' => $model->idcot]);
            } else {
                return $this->redirect(["seguimientogeneral", 'idrama' => $model->idrama, 'idsubrama' => $model->idsubrama, 'idanalito' => $model->idanalito, 'idref' => $model->idreferencia, 'idcot' => $model->idcot]);
            }
        } else {
            Yii::$app->session->setFlash('danger', 'No se enviaron datos');
            return $this->redirect(["site/index"]);
        }
    }

}

?>