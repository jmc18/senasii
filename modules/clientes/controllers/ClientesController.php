<?php

namespace app\modules\clientes\controllers;

use Yii;
use yii\filters\AccessControl;
use app\modules\contactos\models\Contactos;
use app\modules\clientes\models\Clientes;
use app\modules\clientes\models\ClientesSearch;
use app\modules\clientes\models\ClientesContactos;
use app\modules\usuarios\models\Users;
use app\models\User; 


use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * ClientesController implements the CRUD actions for Clientes model.
 */
class ClientesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'vercontactos', 'eliminarctocte'],
                'rules' => [
                    [
                        //El administrador tiene permisos sobre las siguientes acciones
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'vercontactos', 'eliminarctocte'],
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
     * Lists all Clientes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClientesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Clientes model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Clientes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Clientes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Clientes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
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
     * Deletes an existing Clientes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionVercontactos($idCte)
    {
        $model = new ClientesContactos();
       
        if ( $model->load(Yii::$app->request->post()) ) {
            $model->idcte = $idCte;
            if( $model->save() )
            {

            }
        }
        else{

        }

        $model_clientes  = Clientes::findOne($idCte);
        //$model_contactos = Contactos::find()->all();
        $items_contactos = ArrayHelper::map(Contactos::find()->all(),'nocontacto','nombrecon');
        $model_ctesctos  = new ActiveDataProvider(
            ['query' => ClientesContactos::find()->with('nocontacto0')->where(['idcte'=>$idCte])]
        );

        return $this->render('contactoscliente', [
            'model'           => $model,
            'model_clientes'  => $model_clientes,
            'model_ctesctos'  => $model_ctesctos,
            'items_contactos' => $items_contactos,
        ]);
    }

    public function actionEliminarctocte($idcte,$nocontacto)
    {
        $model_ctescto = ClientesContactos::deleteAll('idcte = '.$idcte.' and nocontacto = '.$nocontacto);
        
        $model_clientes  = Clientes::findOne($idcte);
        //$model_contactos = Contactos::find()->all();
        $items_contactos = ArrayHelper::map(Contactos::find()->all(),'nocontacto','nombrecon');
        $model_ctesctos  = new ActiveDataProvider(
            ['query' => ClientesContactos::find()->with('nocontacto0')->where(['idcte'=>$idcte])]
        );

        $model = new ClientesContactos();
        if ( $model->load(Yii::$app->request->post()) ) {
            $model->idcte = $idcte;
            if( $model->save() )
            {

            }
        }
        else{

        }

        return $this->render('contactoscliente', [
            'model'           => $model,
            'model_clientes'  => $model_clientes,
            'model_ctesctos'  => $model_ctesctos,
            'items_contactos' => $items_contactos,
        ]);
    }

    public function actionVerusuarios($idcte)
    {
        $model = new Users();
        $model_cliente  = Clientes::find()->where(['idcte'=>$idcte])->one();
        $items_users = ArrayHelper::map(Users::find()->where(['idcte'=>null, 'role'=>1])->all(),'idusr','username');
        $model_usrscte  = new ActiveDataProvider(
            ['query' => Users::find()->where(['idcte'=>$idcte])]
        );

        if ( $model->load(Yii::$app->request->post()) ) {
            if( !empty($_POST['Users']['idusr']) ){
                $idusr = $_POST['Users']['idusr'];
                $model_usr = Users::find()->where(['idusr'=>$idusr])->one();
                $model_usr->idcte = $idcte;
                if($model_usr->save())
                    Yii::$app->session->setFlash('success', 'El usuario se registró correctamente');
                else
                    Yii::$app->session->setFlash('danger', 'El usuario no se pudo asignar al usuario');
            }
            else
                Yii::$app->session->setFlash('danger', 'Debes seleccionar un usuario!!');               
        }

        return $this->render('usuarioscliente', [
            'model'          => $model,
            'model_cliente'  => $model_cliente,
            'model_usrscte'  => $model_usrscte,
            'items_users'    => $items_users,
        ]);
    }

    public function actionQuitarusuario($idusr,$idcte)
    {
        $model  = Users::find()->where(['idusr'=>$idusr])->one();
        $model->idcte = null;
        if( $model->save() )
            Yii::$app->session->setFlash('success', 'El usuario se quitó correctamente del cliente');
        else
            Yii::$app->session->setFlash('danger', 'El usuario no se pudo quitar del listado del cliente');
        return $this->redirect(['verusuarios','idcte'=>$idcte]);
    }

    public function actionEnviaractivacion($idusr)
    {
        $user = Users::find()->where(["idusr" => $idusr])->one();
        $id = urlencode($user->idusr);
        $accessToken = urlencode($user->accesstoken);
        $authKey = urlencode($user->authkey);

        $user->fechainvitacion = date('Y-m-d');
        if( $user->save() )
        {    
            $subject = "Invitación a usar el Sistema de informacion de SENA";
            //$body = "<h1>Haga click en el siguiente enlace para finalizar tu registro</h1>";
            //$body .= "<a href='http://example01.local/index.php?r=site/confirm&id=".$id."&authKey=".$authKey."'>Confirmar</a>";

            $body="<body style='margin: 0; padding: 0;'>
                        <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                           <tr>
                                <td style='padding: 20px 0 30px 0;'>
                                    <table align='center' border=0 cellpadding='0' cellspacing='0' width='600' style='border-collapse: collapse;'>
                                        <tr>                                                        
                                            <td align='center' bgcolor='#70bbd9' style='padding: 40px 0 30px 0;''>
                                                <img src='http://www.sena.mx/Images/Sena.png' alt='Creating Email Magic' width='160' height='80' style='display: block;'/>
                                                <b style='color: #ffffff; font-family: Arial, sans-serif; font-size: 20px;'>SENA:: Ensayos de Aptitud</b>
                                            </td>
                                        </tr>
                                        <tr>

                                        <td bgcolor='#ffffff' style='color: #153643; font-family: Arial, sans-serif; font-size: 16px; padding: 30px 0 0 10px;'>
                                                <b>Bienvenid@, ".$user->username."!</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='font-family: Arial, sans-serif; font-size: 14px; padding: 25px 0px 30px 20px;'>
                                                    Gracias por unirte a SENA. ¡Estás a solo un paso de crear tu cuenta con nosotros! <strong></strong><br><br>
                                                <center>¡Ahora ve y <b><a href='http://localhost/~isctorres/sena_dev/basic/web/index.php?r=site/confirm&id=".$id."&accessToken=".$accessToken."&authKey=".$authKey."'>Activa tu cuenta</a></b>!
                                                    </center>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='color: #153643; font-family: Arial, sans-serif; font-size: 18px;'>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td bgcolor='#ee4c50' style='padding: 20px 20px 20px 20px;'>
                                                <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                                    <tr>
                                                    <td width='75%' style='color: #ffffff; font-family: Arial, sans-serif; font-size: 12px;'>
                                                                &reg; SENA, Ensayos de Aptitud 2018<br/>
                                                                More text about company
                                                        </td>
                                                        <td align='right'>
                                                            <table border='0' cellpadding='0' cellspacing='0'>
                                                                <tr>
                                                                    <td>
                                                                        <a href='http://www.twitter.com/''>
                                                                            <img src='http://www.elgatoverdeproducciones.com/wp-content/uploads/2015/09/twitter_icon.png' alt='Twitter' width='28' height='28' style='display: block;' border='0' />
                                                                        </a>
                                                                    </td>
                                                                    <td style='font-size: 0; line-height: 0;' width='20'>&nbsp;</td>
                                                                    <td>
                                                                        <a href='http://www.facebook.com/'>
                                                                            <img src='http://www.newdesignfile.com/postpic/2013/04/twitter-facebook-icons-grey_278810.png' alt='Facebook' width='28' height='28' style='display: block;' border='0' />
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </body>";

            //Enviamos el correo
            Yii::$app->mailer->compose()
            ->setTo($user->email)
            ->setFrom([Yii::$app->params["adminEmail"] => Yii::$app->params["title"]])
            ->setSubject($subject)
            ->setHtmlBody($body)
            ->send();

            Yii::$app->session->setFlash('success', 'La invitación para activar la cuenta del cliente ha sido enviada correctamente a su correo!');
        }
        else
            Yii::$app->session->setFlash('danger', 'Ocurrio un error al enviar la invitación intente de nuevo');
          
        return $this->redirect(['verusuarios','idcte'=>$user->idcte]);
    }

    /**
     * Finds the Clientes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Clientes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Clientes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
