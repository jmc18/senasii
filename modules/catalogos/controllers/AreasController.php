<?php

namespace app\modules\catalogos\controllers;

use Yii;
use yii\filters\AccessControl;
use app\modules\catalogos\models\Areas;
use app\modules\catalogos\models\AreasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\User;
use app\modules\catalogos\models\areas\SeccionesFormularioCalibracion;
use app\modules\catalogos\models\areas\DetalleFormularioSeccion;
use app\modules\catalogos\models\areas\UnidadesResultado;
use app\modules\catalogos\models\areas\CamposFormulariosCalibracion;

/**
 * AreasController implements the CRUD actions for Areas model.
 */
class AreasController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                        [
                        //El administrador tiene permisos sobre las siguientes acciones
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
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
                /* [
                  //Los usuarios simples tienen permisos sobre las siguientes acciones
                  'actions' => ['logout', 'user'],
                  //Esta propiedad establece que tiene permisos
                  'allow' => true,
                  //Usuarios autenticados, el signo ? es para invitados
                  'roles' => ['@'],
                  //Este método nos permite crear un filtro sobre la identidad del usuario
                  //y así establecer si tiene permisos o no
                  'matchCallback' => function ($rule, $action) {
                  //Llamada al método que comprueba si es un usuario simple, en caso contrario llama al metodo denyAccess() y redirige al login
                  return User::isUserSimple(Yii::$app->user->identity->id);
                  },
                  ], */
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

    /**
     * Lists all Areas models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AreasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Areas model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Areas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Areas();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Areas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Areas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionGenerarFormulario($id) {
        
    }

    /**
     * Finds the Areas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Areas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Areas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionConfigurarFormulario($id) {
        $model_area = Areas::find()->where(['idarea' => $id])->one();
        $secciones_area = SeccionesFormularioCalibracion::find()->where(['idarea' => $id])->orderBy(['orden' => SORT_ASC])->all();
        return $this->render('ConfiguraFormulario', ['model_area' => $model_area, "secciones_area" => $secciones_area, "idarea" => $id]);
    }

    public function actionObtenerCamposSeccion($id, $nomSeccion) {
        $detalle_formulario = DetalleFormularioSeccion::find()
                ->with('idunidad0')
                ->where(['idseccion' => $id])
                ->andWhere(['status' => 1])
                ->orderBy(['orden' => SORT_ASC])
                ->all();
        return $this->renderAjax('ObtenerCamposSeccion', ['detalle_formulario' => $detalle_formulario, 'nomSeccion' => $nomSeccion, 'idseccion' => $id, 'nombre_seccion' => $nomSeccion]);
    }

    public function actionFormularioCampoResultados($idCampo, $nombre_seccion, $idseccion) {
        $model_formulario = new DetalleFormularioSeccion();
        $detalle_formulario = DetalleFormularioSeccion::find()
                ->where(['id_campo' => $idCampo])
                ->andWhere(['idseccion' => $idseccion])
                ->one();
        $model_formulario->id_campo = $idCampo;
        $model_formulario->idseccion = $idseccion;
        $model_formulario->idunidad = $detalle_formulario->idunidad;
        $model_formulario->formula = $detalle_formulario->formula;
        $model_formulario->texto_etiquetas = $detalle_formulario->texto_etiquetas;
        $model_formulario->tipo_entrada = $detalle_formulario->tipo_entrada;
        $model_formulario->requerido = $detalle_formulario->requerido;
        $model_formulario->orden = $detalle_formulario->orden;
        $unidades = ArrayHelper::map(UnidadesResultado::find()->all(), 'idunidad', 'nombre');
        $posiciones = ArrayHelper::map(DetalleFormularioSeccion::find()
                                ->with('idunidad0')
                                ->where(['idseccion' => $idCampo, 'idseccion' => $idseccion])
                                ->andWhere(['not', ['orden' => $detalle_formulario->orden]])
                                ->all(), 'orden', 'orden');
        return $this->renderAjax('FormularioCampoResultados', ['model_formulario' => $model_formulario, 'unidades' => $unidades, 'posiciones' => $posiciones, 'nombre_seccion' => $nombre_seccion]);
    }

    public function actionAgregarCampoFormularioResultados() {
        $model_formulario = new DetalleFormularioSeccion();
        if ($model_formulario->load(Yii::$app->request->post())) {
            $detalle_formulario = DetalleFormularioSeccion::find()
                    ->andWhere(['idseccion' => $model_formulario->idseccion])
                    ->count("orden");
            $model_formulario->orden = $detalle_formulario + 1;
            $model_formulario->requerido = $model_formulario->rec_bol_insert;
            $area = SeccionesFormularioCalibracion::find()->where(["idseccion" => $model_formulario->idseccion])->one();
            $model_campos = new CamposFormulariosCalibracion();
            $model_campos->concepto = $model_formulario->texto_etiquetas;
            $model_campos->save();
            $model_formulario->id_campo = $model_campos->id_campo;
            if ($model_formulario->save()) {
                return "Ok," . $area->idarea . "," . $model_formulario->idseccion;
            } else {
                return "No," . $area->idarea . "," . $model_formulario->idseccion;
            }
        } else {
            $idseccion = $_GET['idseccion'];
            $nombre_seccion = $_GET['nombre_seccion'];
            $unidades = ArrayHelper::map(UnidadesResultado::find()->all(), 'idunidad', 'nombre');
            $model_formulario->idseccion = $idseccion;
            return $this->renderAjax("AgregarCampoFormularioResultados", ["model_formulario" => $model_formulario, "nombre_seccion" => $nombre_seccion, "unidades" => $unidades]);
        }
    }

    public function actionEditarCampoFormulario() {
        $model = new DetalleFormularioSeccion();
        if ($model->load(Yii::$app->request->post())) {

            $table_update = DetalleFormularioSeccion::find()
                    ->where(['id_campo' => $model->id_campo, 'idseccion' => $model->idseccion])
                    ->one();
            if ($model->new_orden !== "") {
                $this->ActualizarOrden($model->new_orden, $model->idseccion, $table_update->orden);
                $table_update->orden = $model->new_orden;
            }
            $table_update->texto_etiquetas = $model->texto_etiquetas;
            $table_update->formula = $model->formula;
            $table_update->idunidad = $model->idunidad;
            $table_update->requerido = $model->rec_bol_insert;
            $table_update->tipo_entrada = $model->tipo_entrada;

            if ($table_update->update()) {
                $detalle_formulario = DetalleFormularioSeccion::find()
                        ->where(['id_campo' => $model->id_campo, 'idseccion' => $model->idseccion])
                        ->one();
                $nomseccion = SeccionesFormularioCalibracion::find()->where(["idseccion" => $model->idseccion])->one();
                //return $this->renderAjax('ObtenerCamposSeccion', ['detalle_formulario' => $detalle_formulario, 'nomSeccion' => $nomseccion->nombre, 'idseccion' => $model->idseccion, 'nombre_seccion' => $nomseccion->nombre]);
            }
        } else {
            //return $this->redirect("areas");
        }
    }

    public function actionAgregarSeccionArea($idarea, $nomArea) {
        $model = new SeccionesFormularioCalibracion();
        if ($model->load(Yii::$app->request->post())) {
            $model->orden = SeccionesFormularioCalibracion::find()->where(["idarea" => $model->idarea])->max('orden') + 1;
            if ($model->save()) {
                return $this->redirect(['configurar-formulario', "id" => $model->idarea]);
            }
        }
        $model->idarea = $idarea;
        return $this->render("AgregarSeccionArea", ["model" => $model, "idarea" => $idarea, "nomArea" => $nomArea]);
    }

    public function actionEditarSeccionArea($idseccion, $idarea) {
        $model_seccion = new SeccionesFormularioCalibracion();
        $model_seccion_filtro = SeccionesFormularioCalibracion::find()->where(["idseccion" => $idseccion, "idarea" => $idarea])->one();
        if ($model_seccion->load(Yii::$app->request->post())) {
            if ($model_seccion->newOrden != '') {
                $orden_new = SeccionesFormularioCalibracion::find()->where(["orden" => $model_seccion->newOrden, "idarea" => $idarea])->one();
                Yii::$app->db->createCommand("update secciones_formulario_calibracion set orden = :orden_new where idseccion = :idseccion AND idarea = :idArea")
                        ->bindValue(':idseccion', $orden_new->idseccion)
                        ->bindValue(':idArea', $idarea)
                        ->bindValue(':orden_new', $model_seccion_filtro->orden)
                        ->execute();

                $model_seccion_filtro->orden = $model_seccion->newOrden;
            }

            $model_seccion_filtro->nombre = $model_seccion->nombre;

            $model_seccion_filtro->update();

            return $this->redirect(['configurar-formulario', "id" => $model_seccion->idarea]);
        }
        $area_model = \app\modules\catalogos\models\areas\Areas::find()->where(["idarea" => $idarea])->one();
        $newOrden = ArrayHelper::map(SeccionesFormularioCalibracion::find()
                                ->where(["idarea" => $idarea])
                                ->andWhere(['not', ['orden' => $model_seccion_filtro->orden]])
                                ->orderBy(['orden' => SORT_ASC])->all(), 'orden', 'orden');
        return $this->render("EditarSeccionArea", ["model" => $model_seccion_filtro, "nomArea" => $area_model->descarea, "newOrdenlist" => $newOrden]);
    }

    private function ActualizarOrden($NewOrden, $idseccion, $ordencambio) {

        $table = DetalleFormularioSeccion::find()
                ->where(['orden' => $NewOrden, 'idseccion' => $idseccion])
                ->one();

        Yii::$app->db->createCommand("update detalle_formulario_seccion set orden = :orden_new where idseccion = :idseccion AND id_campo = :idCampo")
                ->bindValue(':idseccion', $idseccion)
                ->bindValue(':idCampo', $table->id_campo)
                ->bindValue(':orden_new', $ordencambio)
                ->execute();
    }

    public function actionEliminarSeccionArea($idseccion, $idarea) {
        $seccionArea = SeccionesFormularioCalibracion::find()->where(['idarea' => $idarea, 'idseccion' => $idseccion])->one();
        $seccionArea->delete();
        $model_seccion = SeccionesFormularioCalibracion::find()->where(["idarea" => $idarea])->all();
        $cont = 1;
        foreach ($model_seccion as $seccion) {
            $model_seccion_new_orden = SeccionesFormularioCalibracion::find()->where(["idseccion" => $seccion->idseccion, "idarea" => $idarea])->one();
            $model_seccion_new_orden->orden = $cont;
            $model_seccion_new_orden->update();
            $cont++;
        }
        return $this->redirect(['configurar-formulario', "id" => $idarea]);
    }

}
