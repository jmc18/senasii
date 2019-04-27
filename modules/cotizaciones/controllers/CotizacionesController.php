<?php

namespace app\modules\cotizaciones\controllers;

use app\modules\cotizaciones\models\Cotizaciones;
use app\modules\clientes\models\ClientesContactos;
use app\modules\clientes\models\Clientes;
use app\modules\calendarios\models\CalendarioCalibracion;
use app\modules\calendarios\models\Calendario;
use app\modules\cotizaciones\models\CotizacionCalibracion;
use app\modules\cotizaciones\models\CotizacionGeneral;
use app\modules\ensayos\models\SeguimientoCalibracion;
use app\modules\ensayos\models\SeguimientoGeneral;


use Yii;
use yii\web\Controller;     
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use kartik\mpdf\Pdf;

class CotizacionesController extends Controller
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

    public function actionListado()
    {
        $this->layout = '@app/views/layouts/customer';
        
        $idcte = Yii::$app->user->identity->idcte;
        $dataProvider = new ActiveDataProvider([
            'query' => Cotizaciones::find()
                        ->innerJoinWith(['cotizacionCalibracion'])
                        ->where(['idcte'=>$idcte]),
        ]);

        return $this->render('listado', [
            'dataProvider'  => $dataProvider,
        ]);
    }

    public function actionListadogeneral()
    {
        $this->layout = '@app/views/layouts/customer';
        
        $idcte = Yii::$app->user->identity->idcte;
        $dataProvider = new ActiveDataProvider([
            'query' => Cotizaciones::find()
                        ->innerJoinWith(['cotizacionGeneral'])
                        ->where(['idcte'=>$idcte]),
        ]);

        return $this->render('ListadoGeneral', [
            'dataProvider'  => $dataProvider,
        ]);
    }

    public function actionCrear()
    {
        $this->layout = '@app/views/layouts/customer';
    	$idcte = Yii::$app->user->identity->idcte;

        $model = new Cotizaciones();
    	$model_cte = Clientes::find()->where(['idcte'=>$idcte])->one();
		$listcontactos = ArrayHelper::map(ClientesContactos::find()->with('nocontacto0')->where(['idcte'=>$idcte])->all(),'nocontacto0.nocontacto','nocontacto0.nombrecon');
     	
        $data_calibracion = new ActiveDataProvider([
            'query' => CalendarioCalibracion::find()->with('idarea0','idreferencia0','idestatus0'),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        $dataCotCal = new ActiveDataProvider([
            'query' => CotizacionCalibracion::find()->with('idarea0','idcot0')->where(['idcot'=>'0']),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

     	return $this->render('crear', [
            'model'         => $model,
            'model_cte'     => $model_cte,
            'listcontactos' => $listcontactos,
            'data_calibracion' => $data_calibracion,
            'dataCotCal'    => $dataCotCal,
            'subtotal'      => 0,
        ]);
    }

    public function actionCreargeneral(){
        $this->layout = '@app/views/layouts/customer';
        $idcte = Yii::$app->user->identity->idcte;

        $model = new Cotizaciones();
        $model_cte = Clientes::find()->where(['idcte'=>$idcte])->one();
        $listcontactos = ArrayHelper::map(ClientesContactos::find()->with('nocontacto0')->where(['idcte'=>$idcte])->all(),'nocontacto0.nocontacto','nocontacto0.nombrecon');
        
        $data_general = new ActiveDataProvider([
            'query' => Calendario::find()->with('idrama0','idsubrama0','idanalito0','idreferencia0','idestatus0'),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        $dataCotGen = new ActiveDataProvider([
            'query' => CotizacionGeneral::find()->with('idrama0','idcot0')->where(['idcot'=>'0']),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        return $this->render('CrearGeneral', [
            'model'         => $model,
            'model_cte'     => $model_cte,
            'listcontactos' => $listcontactos,
            'data_general'  => $data_general,
            'dataCotGen'    => $dataCotGen,
            'subtotal'      => 0,
        ]);
    }

    public function actionEditar($idcot,$idcte)
    {
        $this->layout = '@app/views/layouts/customer';
        
        $idcte = Yii::$app->user->identity->idcte;
        $model = Cotizaciones::find()->where(['idcot'=>$idcot,'idcte'=>$idcte])->one();
        $model_cte = Clientes::find()->where(['idcte'=>$idcte])->one();
        $listcontactos = ArrayHelper::map(ClientesContactos::find()->with('nocontacto0')->where(['idcte'=>$idcte])->all(),'nocontacto0.nocontacto','nocontacto0.nombrecon');
        
        $data_calibracion = new ActiveDataProvider([
            'query' => CalendarioCalibracion::find()->with('idarea0','idreferencia0','idestatus0'),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        $data_general = new ActiveDataProvider([
            'query' => Calendario::find()->with('idrama0','idsubrama0','idanalito0','idreferencia0','idestatus0'),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);    

        $dataCotCal = new ActiveDataProvider([
            'query' => CotizacionCalibracion::find()->with('idarea0','idcot0')->where(['idcot'=>$idcot]),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        $dataCotGen = new ActiveDataProvider([
            'query' => CotizacionGeneral::find()->with('idrama0','idcot0')->where(['idcot'=>$idcot]),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        $subCal = CotizacionCalibracion::find()-> where(['idcot'=>$idcot])->sum('costo');
        $subGen = CotizacionGeneral::find()-> where(['idcot'=>$idcot])->sum('costo');
        $subtotal = $subCal + $subGen;

        return $this->render('crear', [
            'model'         => $model,
            'model_cte'     => $model_cte,
            'listcontactos' => $listcontactos,
            'data_calibracion' => $data_calibracion,
            'data_general'  => $data_general,
            'dataCotCal'    => $dataCotCal,
            'dataCotGen'    => $dataCotGen,
            'subtotal'      => $subtotal,
       ]);
    }

    public function actionEditargeneral($idcot,$idcte)
    {
        $this->layout = '@app/views/layouts/customer';
        
        $idcte = Yii::$app->user->identity->idcte;
        $model = Cotizaciones::find()->where(['idcot'=>$idcot,'idcte'=>$idcte])->one();
        $model_cte = Clientes::find()->where(['idcte'=>$idcte])->one();
        $listcontactos = ArrayHelper::map(ClientesContactos::find()->with('nocontacto0')->where(['idcte'=>$idcte])->all(),'nocontacto0.nocontacto','nocontacto0.nombrecon');
        
        $data_general = new ActiveDataProvider([
            'query' => Calendario::find()->with('idrama0','idsubrama0','idanalito0','idreferencia0','idestatus0'),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);    

        $dataCotGen = new ActiveDataProvider([
            'query' => CotizacionGeneral::find()->with('idrama0','idcot0')->where(['idcot'=>$idcot]),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        $subGen = CotizacionGeneral::find()-> where(['idcot'=>$idcot])->sum('costo');
        //$subtotal = $subCal + $subGen;

        return $this->render('CrearGeneral', [
            'model'         => $model,
            'model_cte'     => $model_cte,
            'listcontactos' => $listcontactos,
            'data_general'  => $data_general,
            'dataCotGen'    => $dataCotGen,
            'subtotal'      => $subGen,
       ]);
    }

    public function actionEliminarcalibracion($idcot,$idcte)
    {
        $idcte = Yii::$app->user->identity->idcte;
        $idcte = Yii::$app->user->identity->idcte;
        CotizacionCalibracion::deleteAll('idcot = \''.$idcot.'\'');
        //CotizacionGeneral::deleteAll('idcot = \''.$idcot.'\'');
        Cotizaciones::deleteAll('idcot = \''.$idcot.'\' and idcte = '.$idcte);
        Yii::$app->session->setFlash('success', 'La cotización fue eliminada correctamente');
 
        return $this->redirect(['listado']);
    }

    public function actionEliminargeneral($idcot,$idcte)
    {
        $idcte = Yii::$app->user->identity->idcte;
        $idcte = Yii::$app->user->identity->idcte;
        //CotizacionCalibracion::deleteAll('idcot = \''.$idcot.'\'');
        CotizacionGeneral::deleteAll('idcot = \''.$idcot.'\'');
        Cotizaciones::deleteAll('idcot = \''.$idcot.'\' and idcte = '.$idcte);
        Yii::$app->session->setFlash('success', 'La cotización fue eliminada correctamente');
 
        return $this->redirect(['listadogeneral']);
    }

    public function actionAgregarcalibracion($idarea,$idref,$idcte,$costo,$estatus)
    {
        $idcte = Yii::$app->user->identity->idcte;
        $cotizacion = new Cotizaciones();
        if( empty($_POST['Cotizaciones']['idcot']) )
        {
            $mes   = date('m');
            $anio  = date('Y');
            $nocot = $this->getNoCot($anio,$mes);
            $folio = 'COT-'.date('y').'-'.$mes.($nocot);

            $cotizacion->idcte = $idcte;
            $cotizacion->fecha = date('Y-m-d');
            $cotizacion->fechaexpira = date("Y-m-d",strtotime(date('Y-m-d')."+ 15 days"));
            $cotizacion->idcot = $folio;
            $cotizacion->anio  = date('Y');
            $cotizacion->mes   = $mes;
            $cotizacion->nocot = $nocot;

            if ($cotizacion->save()) {
                $idcot = $cotizacion->idcot;
            }
        }
        else
        {
            $idcot = $_POST['Cotizaciones']['idcot'];
            $cotizacion = Cotizaciones::find()->where(['idcot'=>$idcot,'idcte'=>$idcte])->one();
        }

        if( !empty($idcot) )
        {
            $model_cotcal = new CotizacionCalibracion();
            $model_cotcal->idcot        = $idcot;
            $model_cotcal->idarea       = $idarea;
            $model_cotcal->idreferencia = $idref;
            $model_cotcal->costo        = $costo;
            
            if( $estatus == 2 ){
                $msj = "El ensayo se agregó correctamente, pero al estar ya esta en desarrollo, SENA evaluará su factibilidad...";
                $model_cotcal->descargar = false;
            }else
                $msj = "El ensayo se agregó correctamente a la cotización";

            if( $model_cotcal->save() )
                Yii::$app->session->setFlash('success', $msj);
        }
        else
            Yii::$app->session->setFlash('danger', 'Ocurrio un error al agregar el ensayo en la cotización');
        
        $model_cte = Clientes::find()->where(['idcte'=>$idcte])->one();
        $listcontactos = ArrayHelper::map(ClientesContactos::find()->with('nocontacto0')->where(['idcte'=>$idcte])->all(),'nocontacto0.nocontacto','nocontacto0.nombrecon');
    
        $data_calibracion = new ActiveDataProvider([
            'query' => CalendarioCalibracion::find()->with('idarea0','idreferencia0','idestatus0'),
        ]);

        //$model = CotizacionCalibracion::find()->where(['idarea'=>$idarea,'idreferencia'=>$idref])->one();
        $dataCotCal = new ActiveDataProvider([
            'query' => CotizacionCalibracion::find()->with('idarea0','idcot0')->where(['idcot'=>$idcot]),
        ]);

        $subCal = CotizacionCalibracion::find()-> where(['idcot'=>$idcot])->sum('costo');
        //$subGen = CotizacionGeneral::find()-> where(['idcot'=>$idcot])->sum('costo');
        //$subtotal = $subCal + $subGen;

        return $this->render('crear', [
            'model'         => $cotizacion,
            'model_cte'     => $model_cte,
            'listcontactos' => $listcontactos,
            'data_calibracion' => $data_calibracion,
            //'data_general'  => $data_general,
            'dataCotCal'    => $dataCotCal,
            //'dataCotGen'    => $dataCotGen,
            'subtotal'      => $subCal,
        ]);
    }

    public function actionAgregargeneral($idrama,$idsubrama,$idanalito,$idref,$idcte,$costo,$estatus)
    {
        $idcte = Yii::$app->user->identity->idcte;
        $cotizacion = new Cotizaciones();
        if( empty($_POST['Cotizaciones']['idcot']) )
        {
            $mes   = date('m');
            $anio  = date('Y');
            $nocot = $this->getNoCot($anio,$mes);
            $folio = 'COT-'.date('y').'-'.$mes.($nocot);

            $cotizacion->idcte = $idcte;
            $cotizacion->fecha = date('Y-m-d');
            $cotizacion->fechaexpira = date("Y-m-d",strtotime(date('Y-m-d')."+ 15 days"));
            $cotizacion->idcot = $folio;
            $cotizacion->anio  = date('Y');
            $cotizacion->mes   = $mes;
            $cotizacion->nocot = $nocot;

            if ($cotizacion->save()) {
                $idcot = $cotizacion->idcot;
            }
        }
        else
        {
            $idcot = $_POST['Cotizaciones']['idcot'];
            $cotizacion = Cotizaciones::find()->where(['idcot'=>$idcot,'idcte'=>$idcte])->one();
        }

        if( !empty($idcot) )
        {
            $model_cotcal = new CotizacionGeneral();
            $model_cotcal->idcot        = $idcot;
            $model_cotcal->idrama       = $idrama;
            $model_cotcal->idsubrama    = $idsubrama;
            $model_cotcal->idanalito    = $idanalito;
            $model_cotcal->idreferencia = $idref;
            $model_cotcal->costo        = $costo;
            
            if( $estatus == 2 ){
                $msj = "El ensayo se agregó correctamente, pero al estar ya esta en desarrollo, SENA evaluará su factibilidad...";
                $model_cotcal->descargar = false;
            }else
                $msj = "El ensayo se agregó correctamente a la cotización";

            if( $model_cotcal->save() )
                Yii::$app->session->setFlash('success', $msj);
        }
        else
            Yii::$app->session->setFlash('danger', 'Ocurrio un error al agregar el ensayo en la cotización');
 
        $model_cte = Clientes::find()->where(['idcte'=>$idcte])->one();
        $listcontactos = ArrayHelper::map(ClientesContactos::find()->with('nocontacto0')->where(['idcte'=>$idcte])->all(),'nocontacto0.nocontacto','nocontacto0.nombrecon');
    
        /*$data_calibracion = new ActiveDataProvider([
            'query' => CalendarioCalibracion::find()->with('idarea0','idreferencia0','idestatus0'),
        ]);*/

        $data_general = new ActiveDataProvider([
            'query' => Calendario::find()->with('idrama0','idsubrama0','idanalito0','idreferencia0','idestatus0'),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        /*$dataCotCal = new ActiveDataProvider([
            'query' => CotizacionCalibracion::find()->with('idarea0','idcot0')->where(['idcot'=>$idcot]),
        ]);*/

        $dataCotGen = new ActiveDataProvider([
            'query' => CotizacionGeneral::find()->with('idrama0','idcot0')->where(['idcot'=>$idcot]),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        //$subCal = CotizacionCalibracion::find()-> where(['idcot'=>$idcot])->sum('costo');
        $subGen = CotizacionGeneral::find()-> where(['idcot'=>$idcot])->sum('costo');
        //$subtotal = $subCal + $subGen;

        return $this->render('CrearGeneral', [
            'model'         => $cotizacion,
            'model_cte'     => $model_cte,
            'listcontactos' => $listcontactos,
            //'data_calibracion' => $data_calibracion,
            'data_general'  => $data_general,
            //'dataCotCal'    => $dataCotCal,
            'dataCotGen'    => $dataCotGen,
            'subtotal'      => $subGen,
        ]);
    }

    public function actionEliminarensayocalibracion($idarea,$idref,$idcot,$idcte)
    {
        $idcte = Yii::$app->user->identity->idcte;
        $model = CotizacionCalibracion::deleteAll('idcot = \''.$idcot.'\' and idarea = '.$idarea.' and idreferencia = '.$idref);
        Yii::$app->session->setFlash('success', 'El ensayo se eliminó correctamente de la cotización');
        return $this->redirect(['editar','idcot'=>$idcot, 'idcte'=>$idcte]);
    }

    public function actionEliminarensayogeneral($idrama,$idsubrama,$idanalito,$idref,$idcot,$idcte)
    {
        $idcte = Yii::$app->user->identity->idcte;
        $model = CotizacionGeneral::deleteAll('idcot = \''.$idcot.'\' and idrama = '.$idrama.' and idsubrama = '.$idsubrama.' and idanalito = '.$idanalito.' and idreferencia = '.$idref);
        Yii::$app->session->setFlash('success', 'El ensayo se eliminó correctamente de la cotización');
        return $this->redirect(['editargeneral','idcot'=>$idcot, 'idcte'=>$idcte]);
    }

    public function actionAceptar($idarea,$idref,$idcot,$estatus){
        $model_segcal1 = SeguimientoCalibracion::find()->where(['idcot'=>$idcot,'idarea'=>$idarea,'idreferencia'=>$idref])->one();
        if( $model_segcal1 == null )
        {
            $model_segcal = new SeguimientoCalibracion();
            $model_segcal->idcot = $idcot;
            $model_segcal->idarea = $idarea;
            $model_segcal->idreferencia = $idref;
            $model_segcal->fecha = date('Y-m-d');
            if( $model_segcal->save() )
            {
                $model_cotcal = CotizacionCalibracion::find()->where(['idcot'=>$idcot,'idarea'=>$idarea,'idreferencia'=>$idref])->one();
                $model_cotcal->aceptado = date('Y-m-d');
                if( $model_cotcal->save() )
                {
                    if( $estatus == 2 ){
                        $mensaje = "El ensayo se ha sido aceptado, pero al estar ya esta en desarrollo, SENA evaluará su factibilidad...";
                        $tipo = 'warning';
                    }
                    else{
                        $mensaje = "El ensayo ha sido aceptado, apartir de ahora podra darle seguimiento";
                        $tipo = 'success';
                    }
                }
                else{
                    $mensaje = 'Ocurrió un error al intentar aceptar el ensayo cotizado';
                    $tipo = 'danger';
                }
            }
            else{
                $mensaje = 'Ocurrió un error al intentar aceptar el ensayo cotizado';
                $tipo = 'danger';
            }
        }
        else{
            $model_cotcal = CotizacionCalibracion::find()->where(['idcot'=>$idcot,'idarea'=>$idarea,'idreferencia'=>$idref])->one();
            $model_cotcal->aceptado = date('Y-m-d');
            if( $model_cotcal->save() )
            {
                if( $estatus == 2 ){
                    $mensaje = "El ensayo se ha sido aceptado, pero al estar ya esta en desarrollo, SENA evaluará su factibilidad...";
                    $tipo = 'warning';
                }
                else{
                    $mensaje = "El ensayo ha sido aceptado, apartir de ahora podra darle seguimiento";
                    $tipo = 'success';
                }
            }
            else{
                $mensaje = 'Ocurrió un error al intentar aceptar el ensayo cotizado';
                $tipo = 'danger';
            }
        }
        // Enviamos el mensaje de alerta dependiendo de la acción realizada
        $this->Alerta($mensaje, $tipo);
        $this->redirect(['/site']);
    }

    public function actionDeclinar($idarea,$idref,$idcot){
        
        $model_cotcal = CotizacionCalibracion::find()->where(['idcot'=>$idcot,'idarea'=>$idarea,'idreferencia'=>$idref])->one();
        $model_cotcal->aceptado = null;
        if( $model_cotcal->save() )
        {
            $mensaje = 'El ensayo cotizado ha sido declinado, a menos que lo vuelvas a aceptar podras darle seguimiento';
            $tipo = 'success';
        }
        else{
            $mensaje = 'Ocurrió un error al intentar declinar del ensayo cotizado';
            $tipo = 'danger';
        }
    
        // Enviamos el mensaje de alerta dependiendo de la acción realizada
        $this->Alerta($mensaje, $tipo);
        $this->redirect(['/site']);
    }

    public function actionAceptargen($idrama,$idsubrama,$idanalito,$idref,$idcot,$estatus){
        $model_cotgen1 = SeguimientoGeneral::find()->where(['idcot'=>$idcot,'idrama'=>$idrama,'idsubrama'=>$idsubrama,'idanalito'=>$idanalito,'idreferencia'=>$idref])->one();
        if( $model_cotgen1 == null )
        {
            $model_seggen = new SeguimientoGeneral();
            $model_seggen->idcot = $idcot;
            $model_seggen->idrama = $idrama;
            $model_seggen->idsubrama = $idsubrama;
            $model_seggen->idanalito = $idanalito;
            $model_seggen->idreferencia = $idref;
            $model_seggen->fecha = date('Y-m-d');
            if( $model_seggen->save() )
            {
                $model_cotgen = CotizacionGeneral::find()->where(['idcot'=>$idcot,'idrama'=>$idrama,'idsubrama'=>$idsubrama,'idanalito'=>$idanalito,'idreferencia'=>$idref])->one();
                $model_cotgen->aceptado = date('Y-m-d');
                if( $model_cotgen->save() )
                {
                    if( $estatus == 2 ){
                        $mensaje = "El ensayo se ha sido aceptado, pero al estar ya esta en desarrollo, SENA evaluará su factibilidad...";
                        $tipo = 'warning';
                    }
                    else{
                        $mensaje = "El ensayo ha sido aceptado, apartir de ahora podra darle seguimiento";
                        $tipo = 'success';
                    }
                }
                else{
                    $mensaje = 'Ocurrió un error al intentar aceptar el ensayo cotizado';
                    $tipo = 'danger';
                }
            }
            else{
                $mensaje = 'Ocurrió un error al intentar aceptar el ensayo cotizado';
                $tipo = 'danger';
            }
        }
        else{
            $model_cotgen = CotizacionGeneral::find()->where(['idcot'=>$idcot,'idrama'=>$idrama,'idsubrama'=>$idsubrama,'idanalito'=>$idanalito,'idreferencia'=>$idref])->one();
            $model_cotgen->aceptado = date('Y-m-d');
            if( $model_cotgen->save() )
            {
                if( $estatus == 2 ){
                    $mensaje = "El ensayo se ha sido aceptado, pero al estar ya esta en desarrollo, SENA evaluará su factibilidad...";
                    $tipo = 'warning';
                }
                else{
                    $mensaje = "El ensayo ha sido aceptado, apartir de ahora podra darle seguimiento";
                    $tipo = 'success';
                }
            }
            else{
                $mensaje = 'Ocurrió un error al intentar aceptar el ensayo cotizado';
                $tipo = 'danger';
            }
        }
        // Enviamos el mensaje de alerta dependiendo de la acción realizada
        $this->Alerta($mensaje, $tipo);
        $this->redirect(['/site']);
    }

    public function actionDeclinargen($idrama,$idsubrama,$idanalito,$idref,$idcot){
        
        $model_cotgen = CotizacionGeneral::find()->where(['idcot'=>$idcot,'idrama'=>$idrama,'idsubrama'=>$idsubrama,'idanalito'=>$idanalito,'idreferencia'=>$idref])->one();
        $model_cotgen->aceptado = null;
        if( $model_cotgen->save() )
        {
            $mensaje = 'El ensayo cotizado ha sido declinado, a menos que lo vuelvas a aceptar podras darle seguimiento';
            $tipo = 'success';
        }
        else{
            $mensaje = 'Ocurrió un error al intentar declinar del ensayo cotizado';
            $tipo = 'danger';
        }
    
        // Enviamos el mensaje de alerta dependiendo de la acción realizada
        $this->Alerta($mensaje, $tipo);
        $this->redirect(['/site']);
    }

    private function getNoCot($anio,$mes)
    {
        $query = "SELECT max(nocot) as cantidad FROM cotizaciones WHERE YEAR(fecha)=".date('Y')." AND MONTH(fecha)=".$mes;
        $cant = Yii::$app->db->createCommand($query)
           ->queryOne();
 
        return $cant['cantidad']+1;
    }

    public function actionReport($idcot) {
        $idcte = Yii::$app->user->identity->idcte;

        $model_cte = Clientes::find()->where(['idcte'=>$idcte])->one();
        $model_cot = Cotizaciones::find()->where(['idcot'=>$idcot,'idcte'=>$idcte])->one();
            
        ////////////////////////////////////////////////////////////////////////////////////////////
        //SE REALIZA LA UNION DE LAS CONSULTAS QUE OBTIENEN LOS REGISTROS DE LOS ENSAYOS COTIZADOS
        $query1 = (new \yii\db\Query())
        ->select("descreferencia, costo")
        ->from('cotizacion_calibracion')
        ->join('INNER JOIN', 'referencias', 'referencias.idreferencia = cotizacion_calibracion.idreferencia')
        ->where(['idcot' => $idcot]);

        /*$query2 = (new \yii\db\Query())
        ->select("descreferencia, costo")
        ->from('cotizacion_general')
        ->join('INNER JOIN', 'referencias', 'referencias.idreferencia = cotizacion_general.idreferencia')
        ->where(['idcot' => $idcot]);*/
     
        /*$unionQuery = (new \yii\db\Query())
        ->from(['cot_ensayos' => $query1->union($query2)]);*/
        //->orderBy(['a_id' => SORT_ASC, 'name' => SORT_ASC]);

        $provider = new ActiveDataProvider([
            //'query' => $unionQuery,
            'query' => $query1,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        $arrEnsayos = $provider->getModels();
        ////////////////////////////////////////////////////////////////////////////////////////////
        // Obtenmos los nombres de las areas que se encuentran cotizadas para formar el titulo de la cotización
        $qryAreas = (new \yii\db\Query())
                ->select("descarea")
                ->from('cotizacion_calibracion')
                ->join('INNER JOIN', 'areas', 'cotizacion_calibracion.idarea = areas.idarea')
                ->where(['idcot' => $idcot])
                ->groupBy(['descarea']);

        $provArea = new ActiveDataProvider([
            'query' => $qryAreas,
        ]);

        $areas = $provArea->getModels();

        $titulo = "";
        foreach ($areas as $row) {
            $titulo .= $row['descarea'].', ';
        }  
        $titulo = substr($titulo,0,strlen($titulo)-2);
        ////////////////////////////////////////////////////////////////////////////////////////////
        // Obtenmos los nombres de las ramas que se encuentran cotizadas para formar el titulo de la cotización
        /*$qryRamas = (new \yii\db\Query())
                ->select("descrama")
                ->from('cotizacion_general')
                ->join('INNER JOIN', 'ramas', 'cotizacion_general.idrama = ramas.idrama')
                ->where(['idcot' => $idcot])
                ->groupBy(['descrama']);

        $provRamas = new ActiveDataProvider([
            'query' => $qryRamas,
        ]);

        $ramas = $provRamas->getModels();*/
        ////////////////////////////////////////////////////////////////////////////////////////////

        $content = $this->renderPartial('imprimir', 
                ['model_cte' => $model_cte,
                 'model_cot' => $model_cot,
                 'provider' => $provider,
                 'titulo' => $titulo,
                 'arrEnsayos' => $arrEnsayos]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE, 
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER, 
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}', 
             // set mPDF properties on the fly
            'options' => ['title' => 'Cotización de Ensayos'],
             // call mPDF methods on the fly
            'methods' => [ 
                'SetHeader'=>['SENA:: Ensayos de Aptitud'], 
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);
     
        // return the pdf output as per the destination setting
        return $pdf->render(); 
    }

    public function actionImprimirgeneral($idcot) {
        $idcte = Yii::$app->user->identity->idcte;

        $model_cte = Clientes::find()->where(['idcte'=>$idcte])->one();
        $model_cot = Cotizaciones::find()->where(['idcot'=>$idcot,'idcte'=>$idcte])->one();
            
        ////////////////////////////////////////////////////////////////////////////////////////////
        //SE REALIZA LA UNION DE LAS CONSULTAS QUE OBTIENEN LOS REGISTROS DE LOS ENSAYOS COTIZADOS
        /*$query1 = (new \yii\db\Query())
        ->select("descreferencia, costo")
        ->from('cotizacion_calibracion')
        ->join('INNER JOIN', 'referencias', 'referencias.idreferencia = cotizacion_calibracion.idreferencia')
        ->where(['idcot' => $idcot]);*/

        $query2 = (new \yii\db\Query())
        ->select("descreferencia, costo")
        ->from('cotizacion_general')
        ->join('INNER JOIN', 'referencias', 'referencias.idreferencia = cotizacion_general.idreferencia')
        ->where(['idcot' => $idcot]);
     
        /*$unionQuery = (new \yii\db\Query())
        ->from(['cot_ensayos' => $query1->union($query2)]);*/
        //->orderBy(['a_id' => SORT_ASC, 'name' => SORT_ASC]);

        $provider = new ActiveDataProvider([
            //'query' => $unionQuery,
            'query' => $query2,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        $arrEnsayos = $provider->getModels();
        ////////////////////////////////////////////////////////////////////////////////////////////
        // Obtenmos los nombres de las areas que se encuentran cotizadas para formar el titulo de la cotización
        /*$qryAreas = (new \yii\db\Query())
                ->select("descarea")
                ->from('cotizacion_calibracion')
                ->join('INNER JOIN', 'areas', 'cotizacion_calibracion.idarea = areas.idarea')
                ->where(['idcot' => $idcot])
                ->groupBy(['descarea']);

        $provArea = new ActiveDataProvider([
            'query' => $qryAreas,
        ]);

        $areas = $provArea->getModels();

        $titulo = "";
        foreach ($areas as $row) {
            $titulo .= $row['descarea'].', ';
        }  
        $titulo = substr($titulo,0,strlen($titulo)-2);*/
        ////////////////////////////////////////////////////////////////////////////////////////////
        // Obtenmos los nombres de las ramas que se encuentran cotizadas para formar el titulo de la cotización
        $qryRamas = (new \yii\db\Query())
                ->select("descrama")
                ->from('cotizacion_general')
                ->join('INNER JOIN', 'ramas', 'cotizacion_general.idrama = ramas.idrama')
                ->where(['idcot' => $idcot])
                ->groupBy(['descrama']);

        $provRamas = new ActiveDataProvider([
            'query' => $qryRamas,
        ]);

        $ramas = $provRamas->getModels();

        $titulo = "";
        foreach ($ramas as $row) {
            $titulo .= $row['descrama'].', ';
        }  
        $titulo = substr($titulo,0,strlen($titulo)-2);
        ////////////////////////////////////////////////////////////////////////////////////////////

        $content = $this->renderPartial('ImprimirGeneral', 
                ['model_cte' => $model_cte,
                 'model_cot' => $model_cot,
                 'provider' => $provider,
                 'titulo' => $titulo,
                 'arrEnsayos' => $arrEnsayos]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE, 
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER, 
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}', 
             // set mPDF properties on the fly
            'options' => ['title' => 'Cotización de Ensayos'],
             // call mPDF methods on the fly
            'methods' => [ 
                'SetHeader'=>['SENA:: Ensayos de Aptitud'], 
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);
     
        // return the pdf output as per the destination setting
        return $pdf->render(); 
    }


    private function Alerta($mensaje, $tipo){
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
}