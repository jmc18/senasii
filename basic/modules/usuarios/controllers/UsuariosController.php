<?php

namespace app\modules\usuarios\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use app\models\User; 
use app\modules\usuarios\models\Users; 


/**
 * Default controller for the `calendarios` module
 */
class UsuariosController extends Controller
{
	public function behaviors()
    {
        return [

            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        //El administrador tiene permisos sobre las siguientes acciones
                        'actions' => ['index'],
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
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
    	$dataProvider = new ActiveDataProvider([
            'query' => Users::find()->with('idcte0'),
        ]);

        return $this->render('index', [
        	'dataProvider' => $dataProvider 
        ]);
    }

    public function actionCreate()
    {
    	$model = new Users();
    	if ( $model->load(Yii::$app->request->post()) ) {

    		if($model->validate())
            {
                //Preparamos la consulta para guardar el usuario
                $table = new Users;
                $table->username = $model->username;
                $table->email    = $model->email;
                $table->activate = $model->activate;
                //Encriptamos el password
                $table->password = crypt($model->password, Yii::$app->params["salt"]);
                //Creamos una cookie para autenticar al usuario cuando decida recordar la sesión, esta misma
                 //clave será utilizada para activar el usuario
                $table->authkey = $this->randKey("abcdef0123456789", 150);
                //Creamos un token de acceso único para el usuario
                $table->accesstoken = $this->randKey("abcdef0123456789", 150);

                //Si el registro es guardado correctamente
                if ($table->insert())
                {
                	Yii::$app->session->setFlash('success', 'El usuario se registró correctamente');
                	return $this->redirect(['index']);
                }
                else
                {
                	Yii::$app->session->setFlash('danger', 'El usuario no se registró correctamente, intente de nuevo');
                	return $this->redirect(['create']);
                }
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {	
     	$model = Users::find()->where(['idusr'=>$id])->one();
    
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        	Yii::$app->session->setFlash('success', 'El usuario se actualizó correctamente');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
		$model = Users::find()->where(['idusr'=>$id])->one();
		if( $model->delete() )
		{
	        Yii::$app->session->setFlash('success', 'El usuario se eliminó correctamente');
		}
		else
		{
			Yii::$app->session->setFlash('success', 'El usuario no se pudo eliminar, intente de nuevo');
		}
		return $this->redirect(['index']);
    }

    private function randKey($str='', $long=0)
    {
        $key = null;
        $str = str_split($str);
        $start = 0;
        $limit = count($str)-1;
        for($x=0; $x<$long; $x++)
        {
            $key .= $str[rand($start, $limit)];
        }
        return $key;
    }
}
