<?php
namespace app\modules\ensayos\controllers;

use Yii;
use app\modules\ensayos\models\SeguimientoCalibracion;
use app\modules\ensayos\models\SeguimientoGeneral;
use app\modules\calendarios\models\CalendarioCalibracion;
use app\modules\calendarios\models\Calendario;
use app\modules\ensayos\models\EvidenciaCalibracion;
use app\modules\ensayos\models\EvidenciaGeneral;
use app\modules\clientes\models\Clientes;
use app\modules\clientes\models\ClientesContactos;
use app\modules\catalogos\models\Areas;
use app\modules\catalogos\models\Referencias;
use app\modules\catalogos\models\Ramas;
use app\modules\catalogos\models\Subramas;
use app\modules\catalogos\models\Analitos;
use app\modules\cotizaciones\models\Cotizaciones;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;

class ValidacionesController extends Controller
{
	public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionOrdencompra()
    {
        $areas = ArrayHelper::map(Areas::find()->all(),'idarea','descarea');
        $ramas = ArrayHelper::map(Ramas::find()->all(),'idrama','descrama');

        $idarea = null;
        $idrama = null;

        if( Yii::$app->request->post() && !empty($_POST['idarea']))
        {
            $idarea = $_POST['idarea'];
            $dataEnsayosCalibracion = new ActiveDataProvider([
                'query' => SeguimientoCalibracion::find()
                            ->with('idcot0')
                            ->where(['not',['termina_odec'=>null]])
                            ->andWhere(['idarea'=>$idarea]),
                            'sort' => [
                                        'defaultOrder'=>[
                                            'idarea' => 'SORT_ASC',
                                        ]
                            ],
                'pagination' => [
                    'pageSize' => 25,
                ],
            ]);
        }
        else
        {
            $dataEnsayosCalibracion = new ActiveDataProvider([
                'query' => SeguimientoCalibracion::find()
                            ->with('idcot0')
                            ->where(['not',['termina_odec'=>null]]),
                            'sort' => [
                                        'defaultOrder'=>[
                                            'idarea' => 'SORT_ASC',
                                        ]
                            ],
                'pagination' => [
                    'pageSize' => 25,
                ],
            ]);
        }

        if( Yii::$app->request->post() && !empty($_POST['idrama']))
        {
            $idrama = $_POST['idrama'];
            $dataEnsayosGenerales = new ActiveDataProvider([
                'query' => SeguimientoGeneral::find()
                            ->with('idcot0')
                            ->where(['not',['termina_odec'=>null]])
                            ->andWhere(['idrama'=>$idrama]),
                            'sort' => [
                                        'defaultOrder'=>[
                                            'idrama' => 'SORT_ASC',
                                        ]
                            ],
                'pagination' => [
                    'pageSize' => 25,
                ],
            ]);
        }
        else
        {
            $dataEnsayosGenerales = new ActiveDataProvider([
                'query' => SeguimientoGeneral::find()
                            ->with('idcot0')
                            ->where(['not',['termina_odec'=>null]]),
                            'sort' => [
                                        'defaultOrder'=>[
                                            'idrama' => 'SORT_ASC',
                                        ]
                            ],
                'pagination' => [
                    'pageSize' => 25,
                ],
            ]);
        }

        return $this->render('Ordencompra', [
            'dataEnsayosCalibracion' => $dataEnsayosCalibracion,
            'dataEnsayosGenerales'   => $dataEnsayosGenerales,
            'areas' => $areas,
            'ramas' => $ramas,
            'idrama'=> $idrama,
            'idarea'=> $idarea,
        ]);
    }

    public function actionPagos()
    {
        $areas = ArrayHelper::map(Areas::find()->all(),'idarea','descarea');
        $ramas = ArrayHelper::map(Ramas::find()->all(),'idrama','descrama');

        $idarea = null;
        $idrama = null;

        if( Yii::$app->request->post() && !empty($_POST['idarea']))
        {
            $idarea = $_POST['idarea'];
            $dataEnsayosCalibracion = new ActiveDataProvider([
                'query' => SeguimientoCalibracion::find()
                            ->with('idcot0')
                            ->where(['not',['termina_pago'=>null]])
                            ->andWhere(['idarea'=>$idarea]),
                            'sort' => [
                                        'defaultOrder'=>[
                                            'idarea' => 'SORT_ASC',
                                        ]
                            ],
                'pagination' => [
                    'pageSize' => 25,
                ],
            ]);
        }
        else
        {
            $dataEnsayosCalibracion = new ActiveDataProvider([
                'query' => SeguimientoCalibracion::find()
                            ->with('idcot0')
                            ->where(['not',['termina_pago'=>null]]),
                            'sort' => [
                                        'defaultOrder'=>[
                                            'idarea' => 'SORT_ASC',
                                        ]
                            ],
                'pagination' => [
                    'pageSize' => 25,
                ],
            ]);
        }

        if( Yii::$app->request->post() && !empty($_POST['idrama']))
        {
            $idrama = $_POST['idrama'];
            $dataEnsayosGenerales = new ActiveDataProvider([
                'query' => SeguimientoGeneral::find()
                            ->with('idcot0')
                            ->where(['not',['termina_pago'=>null]])
                            ->andWhere(['idrama'=>$idrama]),
                            'sort' => [
                                        'defaultOrder'=>[
                                            'idrama' => 'SORT_ASC',
                                        ]
                            ],
                'pagination' => [
                    'pageSize' => 25,
                ],
            ]);
        }
        else
        {
            $dataEnsayosGenerales = new ActiveDataProvider([
                'query' => SeguimientoGeneral::find()
                            ->with('idcot0')
                            ->where(['not',['termina_pago'=>null]]),
                            'sort' => [
                                        'defaultOrder'=>[
                                            'idrama' => 'SORT_ASC',
                                        ]
                            ],
                'pagination' => [
                    'pageSize' => 25,
                ],
            ]);
        }

        return $this->render('Pagos', [
            'dataEnsayosCalibracion' => $dataEnsayosCalibracion,
            'dataEnsayosGenerales'   => $dataEnsayosGenerales,
            'areas' => $areas,
            'ramas' => $ramas,
            'idrama'=>$idrama,
            'idarea'=>$idarea
        ]);
    }

    public function actionAceptados()
    {
        $areas = ArrayHelper::map(Areas::find()->all(),'idarea','descarea');
        $ramas = ArrayHelper::map(Ramas::find()->all(),'idrama','descrama');
        
        $idarea = null;
        $idrama = null;

        if( Yii::$app->request->post() && !empty($_POST['idarea']))
        {
            $idarea = $_POST['idarea'];
            $dataEnsayosCalibracion = new ActiveDataProvider([
                'query' => SeguimientoCalibracion::find()
                            ->with('idcot0')
                            ->where(['not',['termina_aceptacion'=>null]])
                            ->andWhere(['idarea'=>$idarea]),
                            'sort' => [
                                        'defaultOrder'=>[
                                            'idarea' => 'SORT_ASC',
                                        ]
                            ],
                            //->andWhere(['valida_aceptacion'=>null])
                            //->andWhere(['termina_recepcion'=>null])
                            //->andWhere(['termina_entrega'=>null]),
                'pagination' => [
                    'pageSize' => 25,
                ],
            ]);
        }
        else
        {
            $dataEnsayosCalibracion = new ActiveDataProvider([
                'query' => SeguimientoCalibracion::find()
                            ->with('idcot0')
                            ->where(['not',['termina_aceptacion'=>null]]),
                            'sort' => [
                                        'defaultOrder'=>[
                                            'idarea' => 'SORT_ASC',
                                        ]
                            ],
                            //->andWhere(['valida_aceptacion'=>null])
                            //->andWhere(['termina_recepcion'=>null])
                            //->andWhere(['termina_entrega'=>null]),
                'pagination' => [
                    'pageSize' => 25,
                ],
            ]);
        }

        if( Yii::$app->request->post() && !empty($_POST['idrama']))
        {
            $idrama = $_POST['idrama'];
            $dataEnsayosGenerales = new ActiveDataProvider([
                'query' => SeguimientoGeneral::find()
                            ->with('idcot0')
                            ->where(['not',['termina_aceptacion'=>null]])
                            ->andWhere(['idrama'=>$idrama]),
                            'sort' => [
                                        'defaultOrder'=>[
                                            'idrama' => 'SORT_ASC',
                                        ]
                            ],
                'pagination' => [
                    'pageSize' => 25,
                ],
            ]);
        }
        else
        {
            $dataEnsayosGenerales = new ActiveDataProvider([
                'query' => SeguimientoGeneral::find()
                            ->with('idcot0')
                             ->where(['not',['termina_aceptacion'=>null]]),
                             'sort' => [
                                        'defaultOrder'=>[
                                            'idrama' => 'SORT_ASC',
                                        ]
                            ],
                'pagination' => [
                    'pageSize' => 25,
                ],
            ]);
        }

        return $this->render('Aceptados', [
            'dataEnsayosCalibracion' => $dataEnsayosCalibracion,
            'dataEnsayosGenerales'   => $dataEnsayosGenerales,
            'areas' => $areas,
            'ramas' => $ramas,
            'idrama'=> $idrama,
            'idarea'=> $idarea
        ]);
    }

    public function actionRecepciones()
    {
        $areas = ArrayHelper::map(Areas::find()->all(),'idarea','descarea');
        $ramas = ArrayHelper::map(Ramas::find()->all(),'idrama','descrama');
        
        $idarea = null;
        $idrama = null;

        if( Yii::$app->request->post() && !empty($_POST['idarea']))
        {
            $idarea = $_POST['idarea'];
            $dataEnsayosCalibracion = new ActiveDataProvider([
                'query' => SeguimientoCalibracion::find()
                            ->with('idcot0')
                            ->where(['not',['termina_recepcion'=>null]])
                            ->andWhere(['idarea'=>$idarea]),
                            'sort' => [
                                        'defaultOrder'=>[
                                            'idarea' => 'SORT_ASC',
                                        ]
                            ],
                            //->andWhere(['valida_recepcion'=>null])
                            //->andWhere(['termina_entrega'=>null]),
                'pagination' => [
                    'pageSize' => 25,
                ],
            ]);
        }
        else
        {
            $dataEnsayosCalibracion = new ActiveDataProvider([
                'query' => SeguimientoCalibracion::find()
                            ->with('idcot0')
                            ->where(['not',['termina_recepcion'=>null]]),
                            'sort' => [
                                        'defaultOrder'=>[
                                            'idarea' => 'SORT_ASC',
                                        ]
                            ],
                            //->andWhere(['valida_recepcion'=>null])
                            //->andWhere(['termina_entrega'=>null]),
                'pagination' => [
                    'pageSize' => 25,
                ],
            ]);
        }

        if( Yii::$app->request->post() && !empty($_POST['idrama']))
        {
            $idrama = $_POST['idrama'];
            $dataEnsayosGenerales = new ActiveDataProvider([
                'query' => SeguimientoGeneral::find()
                            ->with('idcot0')
                            ->where(['not',['termina_recepcion'=>null]])
                            ->andWhere(['idrama'=>$idrama]),
                            'sort' => [
                                        'defaultOrder'=>[
                                            'idrama' => 'SORT_ASC',
                                        ]
                            ],
                            //->andWhere(['valida_recepcion'=>null])
                            //->andWhere(['termina_entrega'=>null]),
                'pagination' => [
                    'pageSize' => 25,
                ],
            ]);
        }
        else
        {
            $dataEnsayosGenerales = new ActiveDataProvider([
                'query' => SeguimientoGeneral::find()
                            ->with('idcot0')
                             ->where(['not',['termina_recepcion'=>null]]),
                             'sort' => [
                                        'defaultOrder'=>[
                                            'idrama' => 'SORT_ASC',
                                        ]
                            ],
                            //->andWhere(['valida_recepcion'=>null])
                            //->andWhere(['termina_entrega'=>null]),
                'pagination' => [
                    'pageSize' => 25,
                ],
            ]);
        }

        return $this->render('Recepciones', [
            'dataEnsayosCalibracion' => $dataEnsayosCalibracion,
            'dataEnsayosGenerales'   => $dataEnsayosGenerales,
            'areas' => $areas,
            'ramas' => $ramas,
            'idrama'=> $idrama,
            'idarea'=> $idarea
        ]);
    }

    public function actionEntregados()
    {
        $areas = ArrayHelper::map(Areas::find()->all(),'idarea','descarea');
        $ramas = ArrayHelper::map(Ramas::find()->all(),'idrama','descrama');

        $idarea = null;
        $idrama = null;

        if( Yii::$app->request->post() && !empty($_POST['idarea']))
        {
            $idarea = $_POST['idarea'];
            $dataEnsayosCalibracion = new ActiveDataProvider([
                'query' => SeguimientoCalibracion::find()
                            ->with('idcot0')
                            ->where(['not',['termina_entrega'=>null]])
                            ->andWhere(['idarea'=>$idarea]),
                            'sort' => [
                                        'defaultOrder'=>[
                                            'idarea' => 'SORT_ASC',
                                        ]
                            ],
                            //->andWhere(['valida_entrega'=>null]),
                'pagination' => [
                    'pageSize' => 25,
                ],
            ]);    
        }
        else
        {
            $dataEnsayosCalibracion = new ActiveDataProvider([
                'query' => SeguimientoCalibracion::find()
                            ->with('idcot0')
                            ->where(['not',['termina_entrega'=>null]]),
                            'sort' => [
                                        'defaultOrder'=>[
                                            'idarea' => 'SORT_ASC',
                                        ]
                            ],
                            //->andWhere(['valida_entrega'=>null]),
                'pagination' => [
                    'pageSize' => 25,
                ],
            ]);
        }

        if( Yii::$app->request->post() && !empty($_POST['idrama']))
        {
            $idrama = $_POST['idrama'];
            $dataEnsayosGenerales = new ActiveDataProvider([
                'query' => SeguimientoGeneral::find()
                            ->with('idcot0')
                            ->where(['not',['termina_entrega'=>null]])
                            ->andWhere(['idrama'=>$idrama]),
                            'sort' => [
                                        'defaultOrder'=>[
                                            'idrama' => 'SORT_ASC',
                                        ]
                            ],
                            //->andWhere(['valida_entrega'=>null]),
                'pagination' => [
                    'pageSize' => 25,
                ],
            ]);
        }
        else
        {
            $dataEnsayosGenerales = new ActiveDataProvider([
                'query' => SeguimientoGeneral::find()
                            ->with('idcot0')
                            ->where(['not',['termina_entrega'=>null]]),
                            'sort' => [
                                        'defaultOrder'=>[
                                            'idrama' => 'SORT_ASC',
                                        ]
                            ],
                            //->andWhere(['valida_entrega'=>null]),
                'pagination' => [
                    'pageSize' => 25,
                ],
            ]);
        }

        return $this->render('Entregas', [
            'dataEnsayosCalibracion' => $dataEnsayosCalibracion,
            'dataEnsayosGenerales'   => $dataEnsayosGenerales,
            'areas' => $areas,
            'ramas' => $ramas,
            'idrama'=> $idrama,
            'idarea'=> $idarea
        ]);
    }

    public function actionCompletados()
    {
        $dataEnsayosCalibracion = new ActiveDataProvider([
            'query' => SeguimientoCalibracion::find()
                        ->with('idcot0')
                        ->where(['not',['file_aceptacion'=>null]])
                        ->andWhere(['valida_aceptacion'=>null])
                        ->andWhere(['file_recepcion'=>null]),
            'pagination' => [
                'pageSize' => 25,
            ],
        ]);

        $dataEnsayosGenerales = new ActiveDataProvider([
            'query' => SeguimientoCalibracion::find()
                        ->with('idcot0')
                         ->where(['not',['file_aceptacion'=>null]])
                        ->andWhere(['valida_aceptacion'=>null])
                        ->andWhere(['file_recepcion'=>null]),
            'pagination' => [
                'pageSize' => 25,
            ],
        ]);

        return $this->render('Completados', [
            'dataEnsayosCalibracion' => $dataEnsayosCalibracion,
            'dataEnsayosGenerales'   => $dataEnsayosGenerales,
            'areas' => $areas,
            'ramas' => $ramas,
        ]);
    }

    // ACCCIÓN QUE PERMITE OBTENER EL LISTADO DE TODOS LOS ARCHIVOS QUE SE REGISTRARON PARA UNA DETERMINADA ETAPA Y PODER
    // REALIZAR SU VALIDACIÓN, Y AL MISMO TIEMPO PODER ELEGIR A QUIEN DE LOS CONTACTOS SE ENVÍA LA NOTIFICACIÓN
    public function actionListararchivos($idarea,$idref,$idcot,$idetapa)
    {
        // SE CONSULTAN LOS ARCHIVOS QUE SE TIENEN REGISTRADOS PARA UNA DETERMINADA ETAPA PARA UN DETERMINADO CLIENTE
        $data = new ActiveDataProvider([
            'query' => EvidenciaCalibracion::find()->with('idcot0')->where(['idarea'=>$idarea,'idreferencia'=>$idref,'idcot'=>$idcot,'idetapa'=>$idetapa])]);
    
        // CONSULTAMOS LOS DATOS DEL CLIENTE
        $model_cot = Cotizaciones::find()->where(['idcot'=>$idcot])->one();
        $model_cte = Clientes::find()->where(['idcte'=>$model_cot->idcte])->one();
        // OBTENEMOS LOS CORREOS ELECTRONICOS A LOS QUE SE LES PODRA ENVIAR LA NOTIFICACIÓN DEL RESULTADO DE LA EVALUACION
        $listcontactos   = ArrayHelper::map(ClientesContactos::find()->with('nocontacto0')->where(['idcte'=>$model_cot->idcte])->all(),'nocontacto0.emailcon','nocontacto0.emailcon');

        // CONSULTAMOS LOS DATOS DEL ENSAYO SELECCIONADO
        $model_calibracion = CalendarioCalibracion::find()->with('idarea0','idreferencia0','idestatus0')->where(['idarea'=>$idarea,'idreferencia'=>$idref])->one();
    
        // CONSULTAS PARA OBTENER LOS DATOS GENERALES DEL ENSAYO QUE SE VA A REVISAR
        $model_area = Areas::find()->where(['idarea'=>$idarea])->one();
        $model_ref  = Referencias::find()->where(['idreferencia'=>$idref])->one();

        switch($idetapa)
        {
            case 1:
                $etapa = "ORDEN DE COMPRA / COTIZACIÓN";
                break;
            case 2:
                $etapa = "CONFIRMACIÓN DE PAGO";
                break;
            case 3:
                $etapa = "ACEPTACIÓN DE LINEAMIENTOS";
                break;
            case 5:
                $etapa = "RECEPCIÓN DEL ELEMENTO DE ENSAYO";
                break;
            case 6:
                $etapa = "ENTREGA DEL ELEMENTO DE ENSAYO";
        }

        $texto  = "Las evidencias de ".$etapa." enviadas para el ensayo de: <br><br> AREA: ".$model_area->descarea."<br> REFERENCIA: ".$model_ref->descreferencia."<br><br> Fueron evaluadas y aceptadas, por lo cual puedes continuar con el proceso";

        return $this->render('Evidencias', [
            'data' => $data,
            'model_cte' => $model_cte,
            'model_calibracion' => $model_calibracion,
            'listcontactos' => $listcontactos,
            'texto'   => $texto,
            'idarea'  => $idarea,
            'idref'   => $idref,
            'idcot'   => $idcot,
            'idetapa' => $idetapa
        ]);
    }

    public function actionListararchivosgen($idrama,$idsubrama,$idanalito,$idref,$idcot,$idetapa)
    {
        $data = new ActiveDataProvider([
            'query' => EvidenciaGeneral::find()->with('idcot0')->where(['idrama'=>$idrama,'idsubrama'=>$idsubrama,'idanalito'=>$idanalito,'idreferencia'=>$idref,'idcot'=>$idcot,'idetapa'=>$idetapa])]);
    
        // CONSULTAMOS LOS DATOS DEL CLIENTE
        $model_cot = Cotizaciones::find()->where(['idcot'=>$idcot])->one();
        $model_cte = Clientes::find()->where(['idcte'=>$model_cot->idcte])->one();
        // OBTENEMOS LOS CORREOS ELECTRONICOS A LOS QUE SE LES PODRA ENVIAR LA NOTIFICACIÓN DEL RESULTADO DE LA EVALUACION
        $listcontactos   = ArrayHelper::map(ClientesContactos::find()->with('nocontacto0')->where(['idcte'=>$model_cot->idcte])->all(),'nocontacto0.emailcon','nocontacto0.emailcon');
        
        // CONTSULTAMOS LOS DATOS DEL ENSAYO PARA PASAR EL MODELO A LA VISTA Y VISUALIZAR DICHOS DATOS
        $model_calendario = Calendario::find()->with('idrama0','idsubrama0','idanalito0','idreferencia0','idestatus0')->where(['idrama'=>$idrama,'idsubrama'=>$idsubrama,'idanalito'=>$idanalito,'idreferencia'=>$idref])->one();

        // CONSULTAS PARA OBTENER LOS DATOS GENERALES DEL ENSAYO QUE SE VA A REVISAR
        $model_rama    = Ramas::find()->where(['idrama'=>$idrama])->one();
        $model_subrama = Subramas::find()->where(['idsubrama'=>$idsubrama])->one();
        $model_analito = Analitos::find()->where(['idanalito'=>$idanalito])->one();
        $model_ref = Referencias::find()->where(['idreferencia'=>$idref])->one();
        $model_cte = Clientes::find()->where(['idcte'=>$model_cot->idcte])->one();
        
        switch($idetapa)
        {
            case 1:
                $etapa = "ORDEN DE COMPRA / COTIZACIÓN";
                break;
            case 2:
                $etapa = "CONFIRMACIÓN DE PAGO";
                break;
            case 3:
                $etapa = "ACEPTACIÓN DE LINEAMIENTOS";
                break;
            case 5:
                $etapa = "RECEPCIÓN DEL ELEMENTO DE ENSAYO";
                break;
            case 6:
                $etapa = "ENTREGA DEL ELEMENTO DE ENSAYO";
        }
        
        $texto  = "Las evidencias de ".$etapa." enviadas para el ensayo de: <br><br> RAMA: ".$model_rama->descrama."<br> SUBRAMA: ".$model_subrama->descsubrama."<br> ANALITO: ".$model_analito->descparametro."<br> REFERENCIA: ".$model_ref->descreferencia."<br><br> Fueron evaluadas y aceptadas, por lo cual puedes continuar con el proceso";

        return $this->render('Evidenciasgen', [
            'data'      => $data,
            'model_cte' => $model_cte,
            'model_calendario' => $model_calendario,
            'listcontactos' => $listcontactos,
            'texto'     => $texto,
            'idrama'    => $idrama,
            'idsubrama' => $idsubrama,
            'idanalito' => $idanalito,
            'idref'     => $idref,
            'idcot'     => $idcot,
            'idetapa'   => $idetapa,
        ]);
    }

    public function actionAceptarevidencia($idarea,$idref,$idcot,$idetapa,$nofiles)
    {
        $model = EvidenciaCalibracion::find()->where(['idarea'=>$idarea,'idreferencia'=>$idref,'idcot'=>$idcot,'nofiles'=>$nofiles, 'idetapa'=>$idetapa])->one();
        $model->validado = date('Y-m-d');
       
        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'La validación fue registrada correctamente');
        }

        return $this->redirect(['listararchivos','idarea'=>$idarea,'idref'=>$idref,'idcot'=>$idcot,'idetapa'=>$idetapa]);
    }

    public function actionAceptarevidenciagen($idrama,$idsubrama,$idanalito,$idref,$idcot,$idetapa,$nofiles)
    {
        $model = EvidenciaGeneral::find()->where(['idrama'=>$idrama,'idsubrama'=>$idsubrama,'idanalito'=>$idanalito,'idreferencia'=>$idref,'idcot'=>$idcot,'idetapa'=>$idetapa,'nofiles'=>$nofiles])->one();
        $model->validado = date('Y-m-d');
        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'La evidencia fue aceptada');
        }

        return $this->redirect(['listararchivosgen','idrama'=>$idrama,'idsubrama'=>$idsubrama,'idanalito'=>$idanalito,'idref'=>$idref,'idcot'=>$idcot,'idetapa'=>$idetapa]);
    }

    public function actionEnviaremail($idarea,$idref,$idcot,$idetapa)
    {
        $cant_files = EvidenciaCalibracion::find()->where(['validado'=>null])
                                                      ->andWhere(['idarea'=>$idarea])
                                                      ->andWhere(['idreferencia'=>$idref])
                                                      ->andWhere(['idcot'=>$idcot])
                                                      ->andWhere(['idetapa'=>$idetapa])->count();
        if( $cant_files == 0 )
        {
            ///////////////////////////////////////////////////////////////////////////////////////////////////
            $asunto = "SENA:: Aviso del resultado de la evaluación de Evidencias";
            $texto = utf8_decode(Yii::$app->request->post('emailcontacto', 0));
            $email = Yii::$app->request->post('email', 0);

            Yii::$app->mailer->compose()
            ->setFrom('sistemas@sena.mx')
            ->setTo($email)
            ->setSubject($asunto)
            ->setHtmlBody($texto)
            ->send();
            ///////////////////////////////////////////////////////////////////////////////////////////////////

            $model_calibracion = SeguimientoCalibracion::find()->where(['idarea'=>$idarea,'idreferencia'=>$idref,'idcot'=>$idcot])->one();
            switch($idetapa)
            {
                case 1: $model_calibracion->valida_odec = date('Y-m-d');
                    break;
                case 2: $model_calibracion->valida_pago = date('Y-m-d');
                    break;
                case 3: $model_calibracion->valida_aceptacion = date('Y-m-d');
                        $model_calibracion->codigo = $this->getCodigoEnsayo();
                    break;
                case 5: $model_calibracion->valida_recepcion = date('Y-m-d');
                    break;
                case 6: $model_calibracion->valida_entrega = date('Y-m-d');
            }

            if( $model_calibracion->save())
                Yii::$app->session->setFlash('success', 'El correo de notificación se envio correctamente');
        }  
        else
            Yii::$app->session->setFlash('danger', 'No se pudo completar la acción porque aun faltan evidencias por validar');
        
        switch($idetapa)
        {
            case 1: return $this->redirect(['ordencompra']);    break;
            case 2: return $this->redirect(['pagos']);          break;
            case 3: return $this->redirect(['aceptados']);      break;
            case 5: return $this->redirect(['recepciones']);    break;
            case 6: return $this->redirect(['entregados']);     break;
        }
    }

    public function actionEnviaremailgen($idrama,$idsubrama,$idanalito,$idref,$idcot,$idetapa)
    {
        $cant_files = EvidenciaGeneral::find()->where(['validado'=>null])
                                                      ->andWhere(['idrama'=>$idrama])
                                                      ->andWhere(['idsubrama'=>$idsubrama])
                                                      ->andWhere(['idanalito'=>$idanalito])
                                                      ->andWhere(['idreferencia'=>$idref])
                                                      ->andWhere(['idcot'=>$idcot])
                                                      ->andWhere(['idetapa'=>$idetapa])->count();
        
        if( $cant_files == 0 )
        {
            $asunto = "SENA:: Aviso del resultado de la evaluación de Evidencias";
            $texto = utf8_decode(Yii::$app->request->post('emailcontacto', 0));
            $email = Yii::$app->request->post('email', 0);

            Yii::$app->mailer->compose()
            ->setFrom('sistemas@sena.mx')
            ->setTo($email)
            ->setSubject($asunto)
            ->setHtmlBody($texto)
            ->send();

            $model_calibracion = SeguimientoGeneral::find()->where(['idrama'=>$idrama,'idsubrama'=>$idsubrama,'idanalito'=>$idanalito,'idreferencia'=>$idref,'idcot'=>$idcot])->one();
            switch($idetapa)
            {
                case 1: $model_calibracion->valida_odec = date('Y-m-d');
                    break;
                case 2: $model_calibracion->valida_pago = date('Y-m-d');
                    break;
                case 3: $model_calibracion->valida_aceptacion = date('Y-m-d');
                        $model_calibracion->codigo = $this->getCodigoEnsayo();
                    break;
                case 5: $model_calibracion->valida_recepcion = date('Y-m-d');
                    break;
                case 6: $model_calibracion->valida_entrega = date('Y-m-d');
            }

            if( $model_calibracion->save())
                Yii::$app->session->setFlash('success', 'El correo de notificación se envio correctamente');
        }
        else
            Yii::$app->session->setFlash('danger', 'No se pudo completar la acción pg_port()que aun faltan evidencias por validar');

        switch($idetapa)
        {
            case 1: return $this->redirect(['ordencompra']);    break;
            case 2: return $this->redirect(['pagos']);          break;
            case 3: return $this->redirect(['aceptados']);      break;
            case 5: return $this->redirect(['recepciones']);    break;
            case 6: return $this->redirect(['entregados']);     break;
        }
    }


    public function getCodigoEnsayo()
    {
         return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
    }

}
?>