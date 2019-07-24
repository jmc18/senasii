<?php

namespace app\modules\alertas\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use app\models\User;
use app\modules\alertas\models\AlertaCalibracion;
use app\modules\alertas\models\AlertaGeneral;
use app\modules\calendarios\models\CalendarioCalibracion;
use app\modules\calendarios\models\Calendario;
use app\modules\alertas\models\Analitos;
use app\modules\alertas\models\Areas;
use app\modules\alertas\models\Contactos;
use app\modules\alertas\models\Cotizaciones;
use app\modules\alertas\models\Ramas;
use app\modules\alertas\models\RamasSubramas;
use app\modules\alertas\models\Referencias;
use DateTime;

/**
 * Default controller for the `calendarios` module
 */
class AlertasController extends Controller {

    public function actionCalibracion($idarea, $idref, $idcot) {
        $dataAlertasCalibracion = new ActiveDataProvider([
            'query' => AlertaCalibracion::find()->with('idcot0')->where(['idarea' => $idarea, 'idreferencia' => $idref, 'idcot' => $idcot]),
        ]);

        $model_calibracion = CalendarioCalibracion::find()->with('idarea0', 'idreferencia0', 'idestatus0')->where(['idarea' => $idarea, 'idreferencia' => $idref])->one();

        return $this->render('ListaCalibracion', [
                    'dataAlertasCalibracion' => $dataAlertasCalibracion,
                    'idarea' => $idarea,
                    'idref' => $idref,
                    'idcot' => $idcot,
                    'model_calibracion' => $model_calibracion
        ]);
    }

    public function actionGeneral($idrama, $idsubrama, $idanalito, $idref, $idcot) {
        $dataAlertasGeneral = new ActiveDataProvider([
            'query' => AlertaGeneral::find()->with('idcot0')->where(['idrama' => $idrama, 'idsubrama' => $idsubrama, 'idanalito' => $idanalito, 'idreferencia' => $idref, 'idcot' => $idcot]),
        ]);

        $model_calendario = Calendario::find()->with('idrama0', 'idsubrama0', 'idanalito0', 'idreferencia0', 'idestatus0')->where(['idrama' => $idrama, 'idsubrama' => $idsubrama, 'idanalito' => $idanalito, 'idreferencia' => $idref])->one();

        return $this->render('ListaGeneral', [
                    'dataAlertasGeneral' => $dataAlertasGeneral,
                    'idrama' => $idrama,
                    'idsubrama' => $idsubrama,
                    'idanalito' => $idanalito,
                    'idref' => $idref,
                    'idcot' => $idcot,
                    'model_calendario' => $model_calendario
        ]);
    }

    public function actionCrearalertacalibracion($idarea, $idref, $idcot) {
        $model = new AlertaCalibracion();
        $model_calibracion = CalendarioCalibracion::find()->with('idarea0', 'idreferencia0', 'idestatus0')->where(['idarea' => $idarea, 'idreferencia' => $idref])->one();

        if ($model->load(Yii::$app->request->post())) {


            $fecalerta = new DateTime($_POST['AlertaCalibracion']['fecha']);
            $hoy = new DateTime(date('Y-m-d'));

            if ($fecalerta > $hoy) {
                $model->idarea = $idarea;
                $model->idreferencia = $idref;
                $model->idcot = $idcot;
                $model->fecha = $_POST['AlertaCalibracion']['fecha'];
                $model->msjalerta = $_POST['AlertaCalibracion']['msjalerta'];
                $model->estatus = '0';

                if ($model->save())
                    Yii::$app->session->setFlash('success', 'La alerta se registró correctamente en el ensayo');
                else
                    Yii::$app->session->setFlash('danger', 'Ocurrio un error al registrar la alerta, intente de nuevo ');
            }
            else {
                Yii::$app->session->setFlash('danger', 'La alerta no puede estar programada para una fecha anterior o igual al dia de hoy ');
            }

            return $this->redirect(['calibracion', 'idarea' => $idarea, 'idref' => $idref, 'idcot' => $idcot]);
        } else {
            return $this->render('AlertaCalibracion', [
                        'model' => $model,
                        'model_calibracion' => $model_calibracion,
                        'idarea' => $idarea,
                        'idref' => $idref,
                        'idcot' => $idcot,
            ]);
        }
    }

    public function actionCrearalertageneral($idrama, $idsubrama, $idanalito, $idref, $idcot) {
        $model = new AlertaGeneral();
        $model_calendario = Calendario::find()->with('idrama0', 'idsubrama0', 'idanalito0', 'idreferencia0', 'idestatus0')->where(['idrama' => $idrama, 'idsubrama' => $idsubrama, 'idanalito' => $idanalito, 'idreferencia' => $idref])->one();

        if ($model->load(Yii::$app->request->post())) {
            $fecalerta = new DateTime($_POST['AlertaGeneral']['fecha']);
            $hoy = new DateTime(date('Y-m-d'));

            if ($fecalerta > $hoy) {
                $model->idrama = $idrama;
                $model->idsubrama = $idsubrama;
                $model->idanalito = $idanalito;
                $model->idreferencia = $idref;
                $model->idcot = $idcot;
                $model->fecha = $_POST['AlertaGeneral']['fecha'];
                $model->msjalerta = $_POST['AlertaGeneral']['msjalerta'];
                $model->estatus = '0';

                if ($model->save())
                    Yii::$app->session->setFlash('success', 'La alerta se registró correctamente en el ensayo');
                else
                    Yii::$app->session->setFlash('danger', 'Ocurrio un error al registrar la alerta, intente de nuevo ');
            }
            else {
                Yii::$app->session->setFlash('danger', 'La alerta no puede estar programada para una fecha anterior o igual al dia de hoy ');
            }

            return $this->redirect(['general', 'idrama' => $idrama, 'idsubrama' => $idsubrama, 'idanalito' => $idanalito, 'idref' => $idref, 'idcot' => $idcot]);
        } else {
            return $this->render('AlertaGeneral', [
                        'model' => $model,
                        'model_calendario' => $model_calendario,
                        'idrama' => $idrama,
                        'idsubrama' => $idsubrama,
                        'idanalito' => $idanalito,
                        'idref' => $idref,
                        'idcot' => $idcot,
            ]);
        }
    }

    public function actionEditaralertacalibracion($idalerta) {
        $model = AlertaCalibracion::find()->where(['idalerta' => $idalerta])->one();
        $model_calibracion = CalendarioCalibracion::find()->with('idarea0', 'idreferencia0', 'idestatus0')->where(['idarea' => $model->idarea, 'idreferencia' => $model->idreferencia])->one();

        if ($model->load(Yii::$app->request->post())) {

            $fecalerta = new DateTime($_POST['AlertaCalibracion']['fecha']);
            $hoy = new DateTime(date('Y-m-d'));

            if ($fecalerta > $hoy) {
                $model->fecha = $_POST['AlertaCalibracion']['fecha'];
                $model->msjalerta = $_POST['AlertaCalibracion']['msjalerta'];

                if ($model->save())
                    Yii::$app->session->setFlash('success', 'La alerta se actualizó correctamente en el ensayo');
                else
                    Yii::$app->session->setFlash('danger', 'Ocurrio un error al actualizar la alerta, intente de nuevo ');
            }
            else {
                Yii::$app->session->setFlash('danger', 'La alerta no puede estar programada para una fecha anterior o igual al dia de hoy ');
            }

            return $this->redirect(['calibracion', 'idarea' => $model->idarea, 'idref' => $model->idreferencia, 'idcot' => $model->idcot]);
        } else {
            return $this->render('AlertaCalibracion', [
                        'model' => $model,
                        'model_calibracion' => $model_calibracion,
                        'idarea' => $model->idarea,
                        'idref' => $model->idreferencia,
                        'idcot' => $model->idcot,
            ]);
        }
    }

    public function actionEditaralertageneral($idalerta) {
        $model = AlertaGeneral::find()->where(['idalerta' => $idalerta])->one();
        $model_calendario = Calendario::find()->with('idrama0', 'idsubrama0', 'idanalito0', 'idreferencia0', 'idestatus0')->where(['idrama' => $model->idrama, 'idsubrama' => $model->idsubrama, 'idanalito' => $model->idanalito, 'idreferencia' => $model->idreferencia])->one();

        if ($model->load(Yii::$app->request->post())) {

            $fecalerta = new DateTime($_POST['AlertaGeneral']['fecha']);
            $hoy = new DateTime(date('Y-m-d'));

            if ($fecalerta > $hoy) {
                $model->fecha = $_POST['AlertaGeneral']['fecha'];
                $model->msjalerta = $_POST['AlertaGeneral']['msjalerta'];

                if ($model->save())
                    Yii::$app->session->setFlash('success', 'La alerta se actualizó correctamente en el ensayo');
                else
                    Yii::$app->session->setFlash('danger', 'Ocurrio un error al actualizar la alerta, intente de nuevo ');
            }
            else {
                Yii::$app->session->setFlash('danger', 'La alerta no puede estar programada para una fecha anterior o igual al dia de hoy ');
            }

            return $this->redirect(['general', 'idrama' => $model->idrama, 'idsubrama' => $model->idsubrama, 'idanalito' => $model->idanalito, 'idref' => $model->idreferencia, 'idcot' => $model->idcot]);
        } else {
            return $this->render('AlertaGeneral', [
                        'model' => $model,
                        'model_calendario' => $model_calendario,
                        'idrama' => $model->idrama,
                        'idsubrama' => $model->idsubrama,
                        'idanalito' => $model->idanalito,
                        'idref' => $model->idreferencia,
                        'idcot' => $model->idcot,
            ]);
        }
    }

    public function actionEliminaralertacalibracion($idalerta, $idarea, $idref, $idcot) {
        $model_alerta = AlertaCalibracion::deleteAll('idalerta = ' . $idalerta);
        Yii::$app->session->setFlash('success', 'La alerta programada se eliminó correctamente del ensayo');
        return $this->redirect(['calibracion', 'idarea' => $idarea, 'idref' => $idref, 'idcot' => $idcot]);
    }

    public function actionEliminaralertageneral($idalerta, $idrama, $idsubrama, $idanalito, $idref, $idcot) {
        $model_alerta = AlertaGeneral::deleteAll('idalerta = ' . $idalerta);
        Yii::$app->session->setFlash('success', 'La alerta programada se eliminó correctamente del ensayo');
        return $this->redirect(['general', 'idrama' => $idrama, 'idsubrama' => $idsubrama, 'idanalito' => $idanalito, 'idref' => $idref, 'idcot' => $idcot]);
    }

    public function actionSendNotificationCalibracion() {
        $ToDay = date("Y-m-d");

        /* Envio de alertas para elementos de ensayo correspondientes a Calibración. */
        $AlertasCalibracion = AlertaCalibracion::find()->where(["fecha" => $ToDay, "estatus" => 0])->all();

        foreach ($AlertasCalibracion as $DetalleAlertas) {
            $idcot = $DetalleAlertas->idcot;
            $idarea = $DetalleAlertas->idarea;
            $idreferencia = $DetalleAlertas->idreferencia;
            $ContactoCzo = Cotizaciones::find()->where(['idcot' => $idcot])->one();
            $DataArea = Areas::find()->where(["idarea" => $idarea])->one();
            $DataReferencia = Referencias::find()->where(["idreferencia" => $idreferencia])->one();
            
            if ($ContactoCzo->nocontacto != NULL) {
                $connection = Yii::$app->db;
                $connection->createCommand()->update('alerta_calibracion', ['estatus' => 1], 'idalerta ='. $DetalleAlertas->idalerta)->execute();   
                $DataContacto = Contactos::find()->where(["nocontacto" => $ContactoCzo->nocontacto])->one();
                try {
                    Yii::$app->mailer->compose()
                            ->setFrom('sistemas@sena.mx')
                            ->setTo($DataContacto->emailcon)
                            ->setSubject("Alertas SENA")
                            ->setHtmlBody("<h1>Alertas SENA</h1>"
                                    . "<br>"
                                    . "<p>Hola <b>" . $DataContacto->nombrecon . " " . $DataContacto->apepatcon . " " . $DataContacto->apematcon . "</b></p>"
                                    . "<br>"
                                    . "<p>El presente correo corresponde al elemento de ensayo:<br>"
                                    . "Área: <b>" . $DataArea->descarea . "</b><br>"
                                    . "Referencia: <b>" . $DataReferencia->descreferencia . "</b><br>"
                                    . "Cotización: <b>" . $idcot . "</b></p><br>" . $DetalleAlertas->msjalerta)
                            ->send();
                } catch (Exception $ex) {
                    Yii::$app->mailer->compose()
                            ->setFrom('sistemas@sena.mx')
                            ->setTo('sistemas@sena.mx')
                            ->setSubject("Alertas SENA")
                            ->setHtmlBody("<h1>Alertas SENA</h1>"
                                    . "<br>"
                                    . "<p>Hola <b>" . $DataContacto->nombrecon . " " . $DataContacto->apepatcon . " " . $DataContacto->apematcon . "</b></p>"
                                    . "<br>"
                                    . "<p>El presente correo corresponde al elemento de ensayo:<br>"
                                    . "Área: <b>" . $DataArea->descarea . "</b><br>"
                                    . "Referencia: <b>" . $DataReferencia->descreferencia . "</b><br>"
                                    . "Cotización: <b>" . $idcot . "</b></p><br>"
                                    . "<h3>No fue enviado</h3><br>" . $ex)
                            ->send();
                }
            } else {
                Yii::$app->mailer->compose()
                        ->setFrom('sistemas@sena.mx')
                        ->setTo('sistemas@sena.mx')
                        ->setSubject("Cotización sin Contacto")
                        ->setHtmlBody("<h1>Alertas SENA</h1>"
                                . "<br>"
                                . "<p>Hola <b>" . $DataContacto->nombrecon . " " . $DataContacto->apepatcon . " " . $DataContacto->apematcon . "</b></p>"
                                . "<br>"
                                . "<p>El presente correo corresponde al elemento de ensayo:<br>"
                                . "Área: <b>" . $DataArea->descarea . "</b><br>"
                                . "Referencia: <b>" . $DataReferencia->descreferencia . "</b><br>"
                                . "Cotización: <b>" . $idcot . "</b></p><br>"
                                . "<h3>No cuenta con un contacto asignado, por tal motivo no se puede enviar la alerta</h3><br>")
                        ->send();
            }
        }
    }

    public function actionSendNotificationGeneral() {
        $ToDay = date("Y-m-d");

        /* Envio de alertas para elementos de ensayo correspondientes a Calibración. */
        $AlertasGeneral = AlertaGeneral::find()->where(["fecha" => $ToDay, "estatus" => 0])->all();
        

        foreach ($AlertasGeneral as $DetalleAlertas) {
            $idcot = $DetalleAlertas->idcot;
            $idrama = $DetalleAlertas->idrama;
            $idsubrama = $DetalleAlertas->idsubrama;
            $idanalito = $DetalleAlertas->idanalito;
            $idreferencia = $DetalleAlertas->idreferencia;
            $ContactoCzo = Cotizaciones::find()->where(['idcot' => $idcot])->one();
            $DataRama = Ramas::find()->where(["idrama" => $idrama])->one();
            $DataSubRama = RamasSubramas::find()->where(["idsubrama" => $idsubrama])->one();
            $DataAnalitos = Analitos::find()->where(["idanalito" => $idanalito])->one();
            $DataReferencia = Referencias::find()->where(["idreferencia" => $idreferencia])->one();
            if ($ContactoCzo->nocontacto != NULL) {
                $connection = Yii::$app->db;
                $connection->createCommand()->update('alerta_general', ['estatus' => 1], 'idalerta ='. $DetalleAlertas->idalerta)->execute(); 
                $DataContacto = Contactos::find()->where(["nocontacto" => $ContactoCzo->nocontacto])->one();
                try {
                    Yii::$app->mailer->compose()
                            ->setFrom('sistemas@sena.mx')
                            ->setTo($DataContacto->emailcon)
                            ->setSubject("Alertas SENA")
                            ->setHtmlBody("<h1>Alertas SENA</h1>"
                                    . "<br>"
                                    . "<p>Hola <b>" . $DataContacto->nombrecon . " " . $DataContacto->apepatcon . " " . $DataContacto->apematcon . "</b></p>"
                                    . "<br>"
                                    . "<p>El presente correo corresponde al elemento de ensayo:<br>"
                                    . "Rama: <b>" . $DataRama->descrama . "</b><br>"
                                    . "Sub-Rama: <b>" . $DataSubRama->descsubrama . "</b>"
                                    . "Analito: <b>" . $DataAnalitos->descparametro . "</b>"
                                    . "Referencia: <b>" . $DataReferencia->descreferencia . "</b><br>"
                                    . "Cotización: <b>" . $idcot . "</b></p><br>" . $DetalleAlertas->msjalerta)
                            ->send();
                } catch (Exception $ex) {
                    Yii::$app->mailer->compose()
                            ->setFrom('sistemas@sena.mx')
                            ->setTo('sistemas@sena.mx')
                            ->setSubject("Alertas SENA")
                            ->setHtmlBody("<h1>Alertas SENA</h1>"
                                    . "<br>"
                                    . "<p>Hola <b>" . $DataContacto->nombrecon . " " . $DataContacto->apepatcon . " " . $DataContacto->apematcon . "</b></p>"
                                    . "<br>"
                                    . "<p>El presente correo corresponde al elemento de ensayo:<br>"
                                    . "Rama: <b>" . $DataRama->descrama . "</b><br>"
                                    . "Sub-Rama: <b>" . $DataSubRama->descsubrama . "</b>"
                                    . "Analito: <b>" . $DataAnalitos->descparametro . "</b>"
                                    . "Referencia: <b>" . $DataReferencia->descreferencia . "</b><br>"
                                    . "Cotización: <b>" . $idcot . "</b></p><br>" . $ex)
                            ->send();
                }
            } else {
                Yii::$app->mailer->compose()
                        ->setFrom('sistemas@sena.mx')
                        ->setTo('sistemas@sena.mx')
                        ->setSubject("Cotización sin Contacto")
                        ->setHtmlBody("<h1>Alertas SENA</h1>"
                                    . "<br>"
                                    . "<p>Hola <b>" . $DataContacto->nombrecon . " " . $DataContacto->apepatcon . " " . $DataContacto->apematcon . "</b></p>"
                                    . "<br>"
                                    . "<p>El presente correo corresponde al elemento de ensayo:<br>"
                                    . "Rama: <b>" . $DataRama->descrama . "</b><br>"
                                    . "Sub-Rama: <b>" . $DataSubRama->descsubrama . "</b>"
                                    . "Analito: <b>" . $DataAnalitos->descparametro . "</b>"
                                    . "Referencia: <b>" . $DataReferencia->descreferencia . "</b><br>"
                                    . "Cotización: <b>" . $idcot . "</b></p><br>"
                                . "<h3>No cuenta con un contacto asignado, por tal motivo no se puede enviar la alerta</h3><br>")
                        ->send();
            }
        }
    }

}
