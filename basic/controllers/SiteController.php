<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\widgets\ActiveForm;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\helpers\Html;
use yii\helpers\Url;

use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use app\models\FormRegister;
use app\models\Users;
use app\models\User; 

use app\modules\clientes\models\Clientes;
use app\modules\ensayos\models\SeguimientoCalibracion;
use app\modules\ensayos\models\SeguimientoGeneral;
use app\modules\cotizaciones\models\Cotizaciones;
use app\modules\cotizaciones\models\CotizacionCalibracion;
use app\modules\cotizaciones\models\CotizacionGeneral;
use app\modules\catalogos\models\Areas;
use app\modules\catalogos\models\Ramas;


class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        /*return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];*/

        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'user', 'admin', 'view', 'update', 'delete'],
                'rules' => [
                    [
                        //El administrador tiene permisos sobre las siguientes acciones
                        'actions' => ['logout', 'admin', 'view', 'update', 'delete'],
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
                    [
                       //Los usuarios simples tienen permisos sobre las siguientes acciones
                       'actions' => ['logout', 'user', 'cliente'],
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
                   ],
                ],
            ],

             //Controla el modo en que se accede a las acciones, en este ejemplo a la acción logout
             //sólo se puede acceder a través del método post
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (empty(Yii::$app->user->identity->id)) 
        {
            $this->layout = '@app/views/layouts/login';
            return $this->redirect(["site/login"]);
        }
        else
        {
            if( Yii::$app->user->identity->role == 1)
                $this->layout = '@app/views/layouts/customer';

            $model_cte = Clientes::find()->where(['idcte'=>Yii::$app->user->identity->idcte])->one();
            $cant_odec = SeguimientoCalibracion::find()->where(['not',['termina_odec'=>null]])
                                                              ->andWhere(['valida_odec'=>null])->count();
            $cant_pago = SeguimientoCalibracion::find()->where(['not',['termina_pago'=>null]])
                                                              ->andWhere(['valida_pago'=>null])->count();
            $cant_acep = SeguimientoCalibracion::find()->where(['not',['termina_aceptacion'=>null]])
                                                              ->andWhere(['valida_aceptacion'=>null])->count();
            $cant_rece = SeguimientoCalibracion::find()->where(['not',['termina_recepcion'=>null]])
                                                              ->andWhere(['valida_recepcion'=>null])->count();
            $cant_entr = SeguimientoCalibracion::find()->where(['not',['termina_entrega'=>null]])
                                                              ->andWhere(['valida_entrega'=>null])->count();
            $cant_comp = SeguimientoCalibracion::find()->where(['not',['termina_odec'=>null]])
                                                              ->andWhere(['not',['termina_pago'=>null]])
                                                              ->andWhere(['not',['termina_aceptacion'=>null]])
                                                              ->andWhere(['not',['termina_recepcion'=>null]])
                                                              ->andWhere(['not',['termina_entrega'=>null]])->count();
           
            $cant_odec_gen = SeguimientoGeneral::find()->where(['not',['termina_odec'=>null]])
                                                       ->andWhere(['valida_odec'=>null])->count();
            $cant_pago_gen = SeguimientoGeneral::find()->where(['not',['termina_pago'=>null]])
                                                       ->andWhere(['valida_pago'=>null])->count();
            $cant_acep_gen = SeguimientoGeneral::find()->where(['not',['termina_aceptacion'=>null]])
                                                       ->andWhere(['valida_aceptacion'=>null])->count();
            $cant_rece_gen = SeguimientoGeneral::find()->where(['not',['termina_recepcion'=>null]])
                                                       ->andWhere(['valida_recepcion'=>null])->count();
            $cant_entr_gen = SeguimientoGeneral::find()->where(['not',['termina_entrega'=>null]])
                                                        ->andWhere(['valida_entrega'=>null])->count();
            $cant_comp_gen = SeguimientoGeneral::find()->where(['not',['termina_odec'=>null]])
                                                       ->andWhere(['not',['termina_pago'=>null]])
                                                       ->andWhere(['not',['termina_aceptacion'=>null]])
                                                       ->andWhere(['not',['termina_recepcion'=>null]])
                                                       ->andWhere(['not',['termina_entrega'=>null]])->count();

            /*if (User::isUserAdmin(Yii::$app->user->identity->id))
            {
                return $this->redirect(["site/admin"]);
            }
            else
            {
                return $this->redirect(["site/user"]);
            }*/

            $idarea = null;
            $idrama = null;
            $areas = ArrayHelper::map(Areas::find()->all(),'idarea','descarea');
            $ramas = ArrayHelper::map(Ramas::find()->all(),'idrama','descrama');
            
            if( Yii::$app->request->post() && !empty($_POST['idarea']))
            {
                $idarea = $_POST['idarea'];
                $dataEnsayosCalibracion = new ActiveDataProvider([
                'query' => SeguimientoCalibracion::find()
                            ->with('idcot0')
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
                                ->with('idcot0'),
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
                                ->with('idcot0'),
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



                /*$dataCotCalibracion = new ActiveDataProvider([
                    'query' => Cotizaciones::find()
                    ->innerJoinWith('cotizacionCalibracion', 'Cotizaciones.idcot = cotizacionCalibracion.idcot'),
                    //->andWhere(['T.productFeatureValueId' => ''])
                    //->innerJoinWith('calendarioCalibracion', 'CotizacionCalibracion.idarea = CalendarioCalibracion.idarea and CotizacionCalibracion.idreferencia = CalendarioCalibracion.idreferencia')
                    //->andWhere(['T1.productFeatureValueId' => '5'])
                    //->all(),
                    'sort' => [
                                            'defaultOrder'=>[
                                                'idcot' => 'SORT_DESC',
                                            ]
                                ],
                    'pagination' => [
                        'pageSize' => 25,
                    ],
                ]);*/


//print_r($model);
//die();

            $dataCotCalibracion = new ActiveDataProvider([
                    'query' => CotizacionCalibracion::find()
                                ->innerJoinWith(['idcot0'])
                                ->andWhere(['idcte'=>Yii::$app->user->identity->idcte])
                                ->with('idarea0'),
                                'sort' => [
                                            'defaultOrder'=>[
                                                'idcot' => 'SORT_DESC',
                                            ]
                                ],
                    'pagination' => [
                        'pageSize' => 25,
                    ],
                ]);

            $dataCotGeneral = new ActiveDataProvider([
                    'query' => CotizacionGeneral::find()
                                ->innerJoinWith(['idcot0'])
                                ->andWhere(['idcte'=>Yii::$app->user->identity->idcte])
                                ->with('idrama0'),
                                'sort' => [
                                            'defaultOrder'=>[
                                                'idcot' => 'SORT_DESC',
                                            ]
                                ],
                    'pagination' => [
                        'pageSize' => 25,
                    ],
                ]);

            return $this->render('index',[
                    'model_cte' => $model_cte,
                    'cant_odec' => $cant_odec + $cant_odec_gen,
                    'cant_pago' => $cant_pago + $cant_pago_gen,
                    'cant_acep' => $cant_acep + $cant_acep_gen,
                    'cant_rece' => $cant_rece + $cant_rece_gen,
                    'cant_entr' => $cant_entr + $cant_entr_gen,
                    'cant_comp' => $cant_comp + $cant_comp_gen,
                    'areas'     => $areas,
                    'ramas'     => $ramas,
                    'idarea'    => $idarea,
                    'idrama'    => $idrama,
                    'dataEnsayosCalibracion' => $dataEnsayosCalibracion,
                    'dataEnsayosGenerales'   => $dataEnsayosGenerales,
                    'dataCotCalibracion'     => $dataCotCalibracion,
                    'dataCotGeneral'         => $dataCotGeneral
                ]);
        }

    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $this->layout = '@app/views/layouts/login';

        /*if (!Yii::$app->user->isGuest) {
            //return $this->goHome();
            # establece la redirección
            if (User::isUserAdmin(Yii::$app->user->identity->id))
            {
                return $this->redirect(["site/admin"]);
            }
            else
            {
                return $this->redirect(["site/user"]);
            }
        }*/

        /*$model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);*/

        # Verifica cuando inicia sesión el usuario y lo redirige a una página específica
        # Estas páginas sólo son de ejemplo, sirven para ver el comportamiento de tipo de usuario
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //if (User::isUserAdmin(Yii::$app->user->identity->id))
            if( (Yii::$app->user->identity->idcte != null || Yii::$app->user->identity->role == 2) && Yii::$app->user->identity->activate == 1 )
                return $this->redirect(["site/index"]);
            else{
                //echo "nuevo usuarios";
                //echo Yii::$app->user->identity->id;
                //die();
                return $this->redirect(["site/cliente"]);
            }
        } 
        else 
        {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    # Lista de los usuarios con búsqueda (sin Gii)
    public function actionView()
    {
        $table = new Users;
        $model = $table->find()->all();

        # Búsqueda en la lista de usuarios
        $form = new FormSearch;
        $search = null;
        if($form->load(Yii::$app->request->get()))
        {
            if ($form->validate())
            {
                $search = Html::encode($form->q);
                $table = Users::find()
                    ->where(["like", "id", $search])
                    ->orWhere(["like", "username", $search])
                    ->orWhere(["like", "email", $search]);
                $model = $table->all();
            }
            else
            {
                $form->getErrors();
            }
        }
        return $this->render("view", ["model" => $model, "form" => $form, "search" => $search]);
    }

    // Funcion para capturar los datos del cliente al que asociaremos el usuario
    public function actionCliente()
    {
        $model = new Clientes();

        if ( $model->load(Yii::$app->request->post()) ) {
             $model_user = Users::find()->where(['idusr'=>Yii::$app->user->identity->id])->one();

            if( $model->save() ){
                $model_user->idcte = $model->attributes['idcte'];
                if( $model_user->save() )
                    return $this->redirect(['index']);
            }

        } else {
            return $this->render('cliente', [
                'model' => $model,
            ]);
        }
    }



    # Borra usuarios
    public function actionDelete()
    {
        if(Yii::$app->request->post())
        {
            $id_user = Html::encode($_POST["id"]);
            if((int) $id_user)
            {
                if(Users::deleteAll("id=:id", [":id" => $id_user]))
                {
                    echo "Usuario con ID $id_user eliminado con éxito, redireccionando ...";
                    echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("site/view")."'>";
                }
                else
                {
                    echo "Ha ocurrido un error al eliminar el usuario, redireccionando ...";
                    echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("site/view")."'>"; 
                }
            }
            else
            {
                echo "Ha ocurrido un error al eliminar el usuario, redireccionando ...";
                echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("site/view")."'>";
            }
        }
        else
        {
            return $this->redirect(["site/view"]);
        }
    }

    # Actualiza usuarios
    public function actionUpdate()
    {
        $model = new FormUpdate;  //Validación de datos
        $msg = null;
        
        if($model->load(Yii::$app->request->post()))
        {
            if($model->validate())
            {
                $table = Users::findOne($model->id);
                if($table)
                {
                    $table->username = $model->username;
                    $table->email = $model->email;
                    $table->activate = $model->activate;
                    $table->role = $model->role;
                    if ($table->update())
                    {
                        $msg = "<h4 style='color: #0000ff'>Usuario actualizado correctamente</h4>";
                        echo "<meta http-equiv='refresh' content='2; ".Url::toRoute("site/view")."'>";
                    }
                    else
                    {
                        $msg = "<h4 style='color: #ff0000'>No se realizaron cambios</h4>";
                        echo "<meta http-equiv='refresh' content='2; ".Url::toRoute("site/view")."'>";
                    }
                }
                else
                {
                    $msg = "<h4 style='color: #ff0000'>El usuario seleccionado no ha sido encontrado</h4>";
                    echo "<meta http-equiv='refresh' content='2; ".Url::toRoute("site/view")."'>";
                }
            }
            else
            {
                $model->getErrors();
            }
        }

        if (Yii::$app->request->get("id"))
        {
            $id = Html::encode($_GET["id"]);
            if ((int) $id)
            {
                $table = Users::findOne($id);
                if($table)
                {
                    $model->id = $table->id;
                    $model->username = $table->username;
                    $model->email = $table->email;
                    $model->activate = $table->activate;
                    $model->role = $table->role;
                }
                else
                {
                    return $this->redirect(["site/view"]);
                }
            }
            else
            {
                return $this->redirect(["site/view"]);
            }
        }
        else
        {
            return $this->redirect(["site/view"]);
        }
        return $this->render("update", ["model" => $model, "msg" => $msg]);
    }

    # Páginas que muestran el control de roles de acceso
    #Estas páginas sólo son de ejemplo, sirven para ver el redireccionamiento dependiendo del tipo de usuario que inicio sesión, no es necesario crearlas
    public function actionUser()
    {
        return $this->render("userpage");  
    }

    public function actionAdmin()
    {
        return $this->render("adminpage");
    }

    # Generador de claves aleatorias para las columnas authKey y accessToken 
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

    # Permitirá activar al usuario cuando haga clic en el enlace adjunto en el correo electrónico
    public function actionConfirm()
    {
        $table = new Users;
        if (Yii::$app->request->get())
        {
            //Obtenemos el valor de los parámetros get
            $id = Html::encode($_GET["id"]);
            $accessToken = Html::encode($_GET["accessToken"]);
            $authKey = $_GET["authKey"];
        
            if ((int) $id)
            {
                //Realizamos la consulta para obtener el registro
                $model = $table
                ->find()
                ->where("idusr=:id", [":id" => $id])
                ->andWhere("accesstoken=:accessToken", [":accessToken" => $accessToken])
                ->andWhere("authkey=:authKey", [":authKey" => $authKey]);
     
                //Si el registro existe
                if ($model->count() == 1)
                {
                    $activar = Users::findOne($id);
                    $activar->activate = 1;
                    if ($activar->update())
                    {
                        echo "¡Registro exitoso! Espera un poco, te estamos redireccionando ...";
                        echo "<meta http-equiv='refresh' content='5; ".Url::toRoute("site/login")."'>";
                    }
                    else
                    {
                        echo "Ha ocurrido un error durante el registro, redireccionando ...";
                        echo "<meta http-equiv='refresh' content='5; ".Url::toRoute("site/login")."'>";
                    }
                 }
                else //Si no existe redireccionamos a login
                {
                    return $this->redirect(["site/login"]);
                }
            }
            else //Si id no es un número entero redireccionamos a login
            {
                return $this->redirect(["site/login"]);
            }
        }
    }
 
    # Registro de usuarios
    public function actionRegister()
    {
        $this->layout = '@app/views/layouts/login';
        //Creamos la instancia con el model de validación
        $model = new FormRegister;
       
        //Mostrará un mensaje en la vista cuando el usuario se haya registrado
        $msg = null;
       
        //Validación mediante ajax
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
       
        //Validación cuando el formulario es enviado vía post
        //Esto sucede cuando la validación ajax se ha llevado a cabo correctamente
        //También previene por si el usuario tiene desactivado javascript y la
        //validación mediante ajax no puede ser llevada a cabo
        if ($model->load(Yii::$app->request->post()))
        {
            if($model->validate())
            {
                //Preparamos la consulta para guardar el usuario
                $table = new Users;
                $table->username = $model->username;
                $table->email = $model->email;
                $table->fechainvitacion = date('Y-m-d');
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
                    //Nueva consulta para obtener el id del usuario
                    //Para confirmar al usuario se requiere su id y su authKey
                    $user = $table->find()->where(["email" => $model->email])->one();
                    $id = urlencode($user->idusr);
                    $accessToken = urlencode($user->accesstoken);
                    $authKey = urlencode($user->authkey);

                     $subject = "Confirmar registro";
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
                                                        <b>Bienvenid@, ".$table->username."!</b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='font-family: Arial, sans-serif; font-size: 14px; padding: 25px 0px 30px 20px;'>
                                                            Gracias por unirte a SENA. ¡Estás a solo un paso de crear tu cuenta con nosotros! <strong></strong><br><br>
                                                        <center>¡Ahora ve y <b><a href='https://sena.mx/senasii/web/index.php?r=site/confirm&id=".$id."&accessToken=".$accessToken."&authKey=".$authKey."'>Activa tu cuenta</a></b>!
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
                     
                    $model->username = null;
                    $model->email = null;
                    $model->password = null;
                    $model->password_repeat = null;
                     
                    Yii::$app->session->setFlash('success', 'El usuario se registró correctamente, ahora sólo falta que confirmes tu registro en tu cuenta de correo!');
                    //$msg = "<h4 style='color: #0000ff'>¡Enhorabuena, ahora sólo falta que confirmes tu registro en tu cuenta de correo!";
                }
                else
                {
                    Yii::$app->session->setFlash('danger', 'Ha ocurrido un error al llevar a cabo tu registro');
                    //$msg = "<h4 style='color: #ff0000'>Ha ocurrido un error al llevar a cabo tu registro";
                }
            }
            else
            {
                $model->getErrors();
            }
        }   
        return $this->render("register", ["model" => $model, "msg" => $msg]);
    }

    # Recuperar contraseña
    public function actionRecoverpass()
    {
        //Instancia para validar el formulario
        $model = new FormRecoverPass;
  
        //Mensaje que será mostrado al usuario en la vista
        $msg = null;
          
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->validate())
            {
                //Buscar al usuario a través del email
                $table = Users::find()->where("email=:email", [":email" => $model->email]);
            
                //Si el usuario existe
                if ($table->count() == 1)
                {
                    //Crear variables de sesión para limitar el tiempo de restablecido del password
                    //hasta que el navegador se cierre
                    $session = new Session;
                    $session->open();
     
                    //Esta clave aleatoria se cargará en un campo oculto del formulario de reseteado
                    $session["recover"] = $this->randKey("abcdef0123456789", 200);
                    $recover = $session["recover"];
     
                    //También almacenaremos el id del usuario y el email en una variable de sesión
                    //El id del usuario es requerido para generar la consulta a la tabla users y 
                    //restablecer el password del usuario
                    $table = Users::find()->where("email=:email", [":email" => $model->email])->one();
                    $session["id_recover"] = $table->id;
                    $session["email"] = $table->email;
                     
                    //Esta variable contiene un número hexadecimal que será enviado en el correo al usuario 
                    //para que lo introduzca en un campo del formulario de reseteado
                    //Es guardada en el registro correspondiente de la tabla users
                    $verification_code = $this->randKey("abcdef0123456789", 8);
                    //Columna verification_code
                    $table->verification_code = $verification_code;
                    //Se guarda en la variable de sesion vcode el código de verificación 
                    $session["vcode"] = $verification_code;
                    //Guardamos los cambios en la tabla users
                    $table->save();
                     
                    //Creamos el mensaje que será enviado a la cuenta de correo del usuario
                    $subject = "Recuperar contraseña";
                    //$body = "<p>Copie el siguiente código de verificación para restablecer su password ";
                    //$body .= "<strong>".$verification_code."</strong></p>";
                    //$body .= "<p><a href='http://example01.local/index.php?r=site/resetpass'>Recuperar password</a></p>";
                    $body = "<body style='margin: 0; padding: 0;'>
                                <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                   <tr>
                                        <td style='padding: 20px 0 30px 0;'>
                                            <table align='center' border=0 cellpadding='0' cellspacing='0' width='600' style='border-collapse: collapse;'>
                                                <tr>                                                        
                                                    <td align='center' bgcolor='#70bbd9' style='padding: 40px 0 30px 0;''>
                                                        <img src='http://icons.iconarchive.com/icons/graphicloads/100-flat-2/256/email-icon.png' alt='Creating Email Magic' width='80' height='80' style='display: block;'/>
                                                        <b style='color: #ffffff; font-family: Arial, sans-serif; font-size: 20px;'>My Company</b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td bgcolor='#ffffff' style='color: #153643; font-family: Arial, sans-serif; font-size: 16px; padding: 30px 0 0 10px;'>
                                                        <b>Hola, ".$table->username."!</b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='font-family: Arial, sans-serif; font-size: 14px; padding: 25px 0px 30px 20px;'>
                                                            Copia el siguiente código de verificación para poder restablecer tu contraseña <strong>".$verification_code."</strong><br><br>
                                                        <center>¡Ahora ve y <b><a href='http://example01.local/index.php?r=site/resetpass'>Recupera tu contraseña</a></b>!
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
                                                                        &reg; Someone, somewhere 2013<br/>
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
                    ->setTo($model->email)
                    ->setFrom([Yii::$app->params["adminEmail"] => Yii::$app->params["title"]])
                    ->setSubject($subject)
                    ->setHtmlBody($body)
                    ->send();
                     
                    //Vaciar el campo del formulario
                    $model->email = null;
                     
                    //Mostrar el mensaje al usuario
                    $msg = "<h4 style='color: #0000ff'>Hemos enviado un mensaje a tu cuenta de correo <b>".$session["email"]."</b> para restablecer tu contraseña";
                }
                else //El usuario no existe
                {
                    $msg = "<h4 style='color: #ff0000'>El email no está registrado";
                }
            }
            else
            {
                $model->getErrors();
            }
        }
        return $this->render("recoverpass", ["model" => $model, "msg" => $msg]);
    }

    public function actionResetpass()
    {
        //Instancia para validar el formulario
        $model = new FormResetPass;

        //Mensaje que será mostrado al usuario
        $msg = null;
      
        //Abrimos la sesión
        $session = new Session;
        $session->open();
      
        //Si no existen las variables de sesión requeridas lo expulsamos a la página de inicio
        if (empty($session["recover"]) || empty($session["id_recover"]) || empty($session["email"]))
        {
            return $this->redirect(["site/index"]);
        }
        else
        {
            $recover = $session["recover"];
            //El valor de esta variable de sesión la cargamos en el campo recover del formulario
            $model->recover = $recover;
           
            //Esta variable contiene el id del usuario que solicitó al restablecer el password
            //La utilizaremos para realizar la consulta a la tabla users
            $id_recover = $session["id_recover"];

            //Tambien llenamos los campos de email (campo oculto) y codigo de verificación para comodidad del usuario
            $email = $session["email"];
            $model->email = $email;
            $verification_code = $session["vcode"];
            $model->verification_code = $verification_code;
            //echo "EMAIL".$email;
            //exit;
        }

        //Si el formulario es enviado para resetear el password
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->validate())
            {
                //Si el valor de la variable de sesión recover y el código de verificación que se introdujo es igual al de la BD es correcto
                if ($recover == $model->recover && $verification_code == $model->verification_code)
                {
                    /*echo "EMAIL".$email;
                    echo "PASS".$model->password;
                    echo "VERIF".$model->verification_code;
                    exit;*/
                    //Preparamos la consulta para resetear el password, requerimos el email, el id 
                    //del usuario que fueron guardados en una variable de session y el código de verificación
                    //que fue enviado en el correo al usuario y que fue guardado en el registro
                    $table = Users::findOne(["email" => $email, "id" => $id_recover, "verification_code" => $model->verification_code]);
                    
                    //Encriptar el password
                    $table->password = crypt($model->password, Yii::$app->params["salt"]);
                     
                    //Si la actualización se lleva a cabo correctamente
                    if ($table->save())
                    {
                        //Destruir las variables de sesión (id, email, recover)
                        $session->destroy();
      
                        //Vaciar los campos del formulario
                        $model->email = null;
                        $model->password = null;
                        $model->password_repeat = null;
                        $model->recover = null;
                        $model->verification_code = null;
      
                        $msg = "<h4 style='color: #0000ff'>¡Contraseña restablecida correctamente! Ahora puedes iniciar sesión ...";
                        $msg .= "<meta http-equiv='refresh' content='5; ".Url::toRoute("site/login")."'>";
                    }
                    else
                    {
                        $msg = "<h4 style='color: #ff0000'>Ha ocurrido un error, reintenta restablecer la contraseña";
                    }
     
                }
                else
                {
                    $msg = "<h4 style='color: #ff0000'>Ha ocurrido un error, revisa el código de verificación";
                    $model->getErrors();
                }
            }
        }
  
        return $this->render("resetpass", ["model" => $model, "msg" => $msg]); 
    }
}
