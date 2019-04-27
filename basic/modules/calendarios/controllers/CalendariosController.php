<?php

namespace app\modules\calendarios\controllers;

use Yii;
use yii\filters\AccessControl;
use app\modules\calendarios\models\LineamientosCalibracion;
use app\modules\calendarios\models\LineamientosGeneral;
use app\modules\calendarios\models\CalendarioCalibracion;
use app\modules\calendarios\models\Calendario;
use app\modules\catalogos\models\Areas;
use app\modules\catalogos\models\Subramas;
use app\modules\catalogos\models\Referencias;
use app\modules\catalogos\models\Analitos;
use app\modules\catalogos\models\Ramas;
use app\modules\catalogos\models\Estatus;

use yii\web\Controller;     
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use app\models\User; 


class CalendariosController extends Controller
{
	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['calibracion', 'agregarcalibracion', 'internacional', 'calendario', 'agregargeneral', 'editarcalibracion', 'eliminarcalibracion', 'editarcalendario', 'eliminarcalendario'],
                'rules' => [
                    [
                        //El administrador tiene permisos sobre las siguientes acciones
                        'actions' => ['calibracion', 'agregarcalibracion', 'internacional', 'calendario', 'agregargeneral', 'editarcalibracion', 'eliminarcalibracion', 'editarcalendario', 'eliminarcalendario'],
                        //Esta propiedad establece que tiene permisos
                        'allow' => true,
                        //Usuarios autenticados, el signo ? es para invitados
                        'roles' => ['@'],
                        //Este método nos permite crear un filtro sobre la identidad del usuario
                        //y así establecer si tiene permisos o no
                        'matchCallback' => function ($rule, $action) {
                            //Llamada al método que comprueba si es un administrador, en caso contrario llama al metodo denyAccess() y redirige al login
                            return User::isUserAdmin(Yii::$app->user->identity->id);
                        },
                    ],
                ],
            ],

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

	public function actionCalibracion()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => CalendarioCalibracion::find()->with('idarea0','idreferencia0','idestatus0'),
        ]);

        $items   = ArrayHelper::map(Areas::find()->all(),'idarea','descarea');
        $itemsref= ArrayHelper::map(Referencias::find()->all(),'idreferencia','descreferencia');
        $itemsstt= ArrayHelper::map(Estatus::find()->all(),'idestatus','descestatus');

        return $this->render('Calibracion', [
            //'model'         => $model,
            'items'         => $items,
            'itemsref'      => $itemsref,
            'itemsstt'      => $itemsstt,
            'dataProvider'  => $dataProvider
        ]);
    }

    public function actionAgregarcalibracion()
    {
        $model = new CalendarioCalibracion();
        $items   = ArrayHelper::map(Areas::find()->all(),'idarea','descarea');
        $itemsref= ArrayHelper::map(Referencias::find()->all(),'idreferencia','descreferencia');
        $itemsstt= ArrayHelper::map(Estatus::find()->all(),'idestatus','descestatus');
        
        if( $model->load(Yii::$app->request->post()) ){
            if( $model->save() ){
                Yii::$app->session->setFlash('success', 'El ensayo se registró correctamente en el ensayo');
                return $this->redirect(['calibracion']);
            }
            else
                Yii::$app->session->setFlash('danger', 'Ocurrió un error al registrar el ensayo, intende de nuevo...');
        }

        return $this->render('AgregarCalibracion', [
            'model'         => $model,
            'items'         => $items,
            'itemsref'      => $itemsref,
            'itemsstt'      => $itemsstt,
        ]);
    }

    public function actionInternacional()
    {
        $model = new CalendarioCalibracion();
        $model_areas = new Areas();
        $model_referencia = new Referencias();

        $dataProvider = new ActiveDataProvider([
            'query' => CalendarioCalibracion::find()->with('idarea0','idreferencia0','idestatus0'),
        ]);

        $items   = ArrayHelper::map(Areas::find()->all(),'idarea','descarea');
        $itemsref= ArrayHelper::map(Referencias::find()->all(),'idreferencia','descreferencia');
        $itemsstt= ArrayHelper::map(Estatus::find()->all(),'idestatus','descestatus');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {          
            Yii::$app->session->setFlash('success', 'El ensayo se registró correctamente en el ensayo');
        } 
        //else {
            return $this->render('Calibracion', [
                'model'         => $model,
                'items'         => $items,
                'itemsref'      => $itemsref,
                'itemsstt'      => $itemsstt,
                'dataProvider'  => $dataProvider
            ]);
        //}
    }

    public function actionCalendario($norama)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Calendario::find()->with('idrama0','idsubrama0','idanalito0','idreferencia0','idestatus0')->where(['idrama'=>$norama]),
        ]);

        return $this->render('Calendarios', [
            'dataProvider'  => $dataProvider,
            'norama'        => $norama,
        ]);
    }

    public function actionAgregargeneral($norama)
    {
        $model    = new Calendario();
        $itemsA   = ArrayHelper::map(Ramas::find()->all(),'idrama','descrama');
        $itemsS   = ArrayHelper::map(Subramas::find()->all(),'idsubrama','descsubrama');
        $itemsN   = ArrayHelper::map(Analitos::find()->all(),'idanalito','descparametro');
        $itemsR   = ArrayHelper::map(Referencias::find()->all(),'idreferencia','descreferencia');
        $itemsSt  = ArrayHelper::map(Estatus::find()->all(),'idestatus','descestatus');

        if( $model->load(Yii::$app->request->post()) ){
            if( $model->save() ){
                Yii::$app->session->setFlash('success', 'El ensayo se registró correctamente en el ensayo');
                return $this->redirect(['calendario',"norama"=>$norama]);
            }
            else
                Yii::$app->session->setFlash('danger', 'Ocurrió un error al registrar el ensayo, intende de nuevo...');
        }

        return $this->render('AgregarGeneral', [
            'model'         => $model,
            'itemsA'        => $itemsA,
            'itemsS'        => $itemsS,
            'itemsN'        => $itemsN,
            'itemsR'        => $itemsR,
            'itemsSt'       => $itemsSt,
        ]);
    }


    public function actionEditarcalibracion($idarea,$idref)
    {
        $model = CalendarioCalibracion::find()->where(['idarea'=>$idarea,'idreferencia'=>$idref])->one();
    
        $dataProvider = new ActiveDataProvider([
            'query' => CalendarioCalibracion::find()->with('idarea0','idreferencia0','idestatus0')->where(['idarea'=>$idarea,'idreferencia'=>$idref]),
        ]);

        $items   = ArrayHelper::map(Areas::find()->all(),'idarea','descarea');
        $itemsref= ArrayHelper::map(Referencias::find()->all(),'idreferencia','descreferencia');
        $itemsstt= ArrayHelper::map(Estatus::find()->all(),'idestatus','descestatus');

        // Almacenamos las variables para cuando se haga el post revisar si estos valores cambiaron, de ser asi
        // entonces se deberá cambiar el estatus del ensayo a 4 (reprogramado)
        $periodoini = $model->periodoini;
        $periodofin = $model->peridodfin;
        if ($model->load(Yii::$app->request->post()) ) {

            // Revisamos las variables para determinar si se reprogramó el ensayo
            if( $model->periodoini != $periodoini || $model->peridodfin != $periodofin )
                $model->idestatus = 4;

            if( $model->save() )
            {
                ////////////////////////////*************************************
                Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/assets/';
                $image = UploadedFile::getInstance($model, 'image');
                if( !empty($image) )
                {
                    // store the source file name
                    $model->file_linea = $image->name;
                    $ext = end((explode(".", $image->name)));

                    // generate a unique file name
                    $model->hash_linea = Yii::$app->security->generateRandomString().".{$ext}";
                  
                    // the path to save file, you can set an uploadPath
                    // in Yii::$app->params (as used in example below)
                    $path = Yii::$app->params['uploadPath'] . $model->hash_linea;

                    if($model->save(false)){
                        $image->saveAs($path);
                        Yii::$app->session->setFlash('success', 'El ensayo se actualizó correctamente en el calendario');
                    } else {
                         echo 'error in saving model';
                    }
                }
                else
                {
                    if($model->save(false)){
                        Yii::$app->session->setFlash('success', 'El ensayo se actualizó correctamente en el calendario');
                    } else {
                        echo 'error in saving model';
                    }
                }
                ////////////////////////////*************************************
            }

            return $this->redirect(['calibracion']);
        }

         return $this->render('AgregarCalibracion', [
            'model'         => $model,
            'items'         => $items,
            'itemsref'      => $itemsref,
            'itemsstt'      => $itemsstt,
            'dataProvider'  => $dataProvider
        ]);
    }

    public function actionEliminarcalibracion($idarea,$idref)
    {
        $model_calibracion = CalendarioCalibracion::deleteAll('idarea = '.$idarea.' and idreferencia = '.$idref);
        Yii::$app->session->setFlash('success', 'El ensayo se eliminó correctamente del calendario');
        return $this->redirect(['calibracion']);
    }

    public function actionEditarcalendario($idrama,$idsubrama,$idanalito,$idref)
    {
        $model = Calendario::find()->where(['idrama'=>$idrama,'idsubrama'=>$idsubrama,'idanalito'=>$idanalito,'idreferencia'=>$idref])->one();
    
        $model_Ramas      = new Ramas();
        $model_subramas   = new Subramas();
        $model_analitos   = new Analitos();
        $model_referencia = new Referencias();

        $dataProvider = new ActiveDataProvider([
            'query' => Calendario::find()->with('idrama0','idsubrama0','idanalito0','idreferencia0','idestatus0')->where(['idrama'=>$idrama,'idsubrama'=>$idsubrama,'idanalito'=>$idanalito,'idreferencia'=>$idref]),
        ]);

        $itemsA   = ArrayHelper::map(Ramas::find()->all(),'idrama','descrama');
        $itemsS   = ArrayHelper::map(Subramas::find()->all(),'idsubrama','descsubrama');
        $itemsN   = ArrayHelper::map(Analitos::find()->all(),'idanalito','descparametro');
        $itemsR   = ArrayHelper::map(Referencias::find()->all(),'idreferencia','descreferencia');
        $itemsSt  = ArrayHelper::map(Estatus::find()->all(),'idestatus','descestatus');

        // Almacenamos las variables para cuando se haga el post revisar si estos valores cambiaron, de ser asi
        // entonces se deberá cambiar el estatus del ensayo a 4 (reprogramado)
        $periodoini = $model->periodoini;
        $periodofin = $model->periodofin;

        if ( $model->load(Yii::$app->request->post()) ) {    

            // Revisamos las variables para determinar si se reprogramó el ensayo
            if( $model->periodoini != $periodoini || $model->periodofin != $periodofin )
                $model->idestatus = 4;

            if( $model->save() )
            { 
                ////////////////////////////*************************************
                Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/assets/';
                $image = UploadedFile::getInstance($model, 'image');
                if( !empty($image) )
                {
                    // store the source file name
                    $model->file_linea = $image->name;
                    $ext = end((explode(".", $image->name)));

                    // generate a unique file name
                    $model->hash_linea = Yii::$app->security->generateRandomString().".{$ext}";
                  
                    // the path to save file, you can set an uploadPath
                    // in Yii::$app->params (as used in example below)
                    $path = Yii::$app->params['uploadPath'] . $model->hash_linea;

                    if($model->save(false)){
                        $image->saveAs($path);
                        Yii::$app->session->setFlash('success', 'El ensayo se actualizó correctamente en el calendario');
                    } else {
                         echo 'error in saving model';
                    }
                }
                else
                {
                    if($model->save(false)){
                        Yii::$app->session->setFlash('success', 'El ensayo se actualizó correctamente en el calendario');
                    } else {
                        echo 'error in saving model';
                    }
                }
                ////////////////////////////*************************************
            }            
            return $this->redirect(['calendario','norama'=>$idrama]);
        }

         return $this->render('AgregarGeneral', [
            'model'         => $model,
            'itemsA'        => $itemsA,
            'itemsS'        => $itemsS,
            'itemsN'        => $itemsN,
            'itemsR'        => $itemsR,
            'itemsSt'       => $itemsSt,
            'dataProvider'  => $dataProvider
        ]);
    }

    public function actionEliminarcalendario($idrama,$idsubrama,$idanalito,$idref)
    {
        $model_calendario = Calendario::deleteAll('idrama = '.$idrama.' and idsubrama = '.$idsubrama.' and idanalito = '.$idanalito.' and idreferencia = '.$idref);
        Yii::$app->session->setFlash('success', 'El ensayo se eliminó correctamente del calendario');
        return $this->redirect(['calendario','norama'=>$idrama]);
    }

    public function actionLineamientocalibracion( $idarea = null, $idreferencia = null ){
        
        $model = new LineamientosCalibracion();
        $dataProvider = new ActiveDataProvider([
            'query' => LineamientosCalibracion::find()->where(['idarea'=>$idarea,'idreferencia'=>$idreferencia]),
        ]);

        if ( $model->load(Yii::$app->request->post()) ) {
            $model->idarea = $idarea;
            $model->idreferencia = $idreferencia;
            if( $model->save() )
                $this->subirArchivo($model);
            else
                Yii::$app->session->setFlash('danger', 'Ocurrio un problema, al intentar la acción, intente de nuevo!!!');
 
            return $this->redirect(['calibracion']);
        }
        
        return $this->renderAjax('LineamientosCalibracion',[
            'model'         => $model,
            'dataProvider'  => $dataProvider
            ]);
    }

    public function actionLineamientogeneral( $idrama = null, $idsubrama = null, $idanalito = null, $idreferencia = null )
    {
        $model = new LineamientosGeneral();
        $dataProvider = new ActiveDataProvider([
            'query' => LineamientosGeneral::find()->where(['idrama'=>$idrama,'idsubrama'=>$idsubrama,'idanalito'=>$idanalito,'idreferencia'=>$idreferencia]),
        ]);

        if ($model->load(Yii::$app->request->post())) {
            $model->idrama       = $idrama;
            $model->idsubrama    = $idsubrama;
            $model->idanalito    = $idanalito;
            $model->idreferencia = $idreferencia;
    
            if( $model->save() )
                $this->subirArchivo($model);
            else
                 Yii::$app->session->setFlash('danger', 'Ocurrio un problema, al intentar la acción, intente de nuevo!!!');
        
            return $this->redirect(['calendario','norama'=>$idrama]);
        }
        
        return $this->renderAjax('LineamientosGeneral',[
            'model'         => $model,
            'dataProvider'  => $dataProvider
            ]);
    }

    public function actionEliminarlineamientocal($idlineamiento){
        $model = LineamientosCalibracion::find()->where(['idlineamiento'=>$idlineamiento])->one();
        $nomFile = $model->hash_linea;
        if( $model->delete() ){
            // AL BORRAR EL LINEAMIENTO SE BORRA TAMBIEN EL ARCHIVO
            $path = Yii::$app->basePath . '/assets/' . $nomFile;
            unlink($path);
            Yii::$app->session->setFlash('success', 'El lineamiento se eliminó correctamente del ensayo');
        }else
            Yii::$app->session->setFlash('danger', 'El lineamiento no se pudo eliminar, intente de nuevo');
        return $this->redirect(['calibracion']);
    }

    public function actionEliminarlineamientogen($idlineamiento, $norama){
        $model = LineamientosGeneral::find()->where(['idlineamiento'=>$idlineamiento])->one();
        $nomFile = $model->hash_linea;
        if( $model->delete() ){
            // AL BORRAR EL LINEAMIENTO SE BORRA TAMBIEN EL ARCHIVO
            $path = Yii::$app->basePath . '/assets/' . $nomFile;
            unlink($path);
            Yii::$app->session->setFlash('success', 'El lineamiento se eliminó correctamente del ensayo');
        }else
            Yii::$app->session->setFlash('danger', 'El lineamiento no se pudo eliminar, intente de nuevo');
        return $this->redirect(['calendario','norama'=>$norama]);
    }

    public function subirArchivo($model){
        Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/assets/';
        if ($model->load(Yii::$app->request->post())) {
            $image = UploadedFile::getInstance($model, 'image');

            if( !empty($image->name) ){
                // store the source file name
                $model->file_linea = $image->name;
                $ext = end((explode(".", $image->name)));

                // generate a unique file name
                $model->hash_linea = Yii::$app->security->generateRandomString().".{$ext}";
              
                // the path to save file, you can set an uploadPath
                // in Yii::$app->params (as used in example below)
                $path = Yii::$app->params['uploadPath'] . $model->hash_linea;

                if($model->save(false)){
                    $image->saveAs($path);
                    Yii::$app->session->setFlash('success', 'El lineamiento se registró correctamente en el calendario');
                    //return $this->redirect(['seguimientogeneral', 'idarea' => $idarea, 'idref' => $idref, 'idcte' => $idcte]);
                } else {
                     echo 'error in saving model';
                }
            }
        }
        ////////////////////////////*************************************           

        //return $this->redirect(['calibracion']);
    }
}
?>