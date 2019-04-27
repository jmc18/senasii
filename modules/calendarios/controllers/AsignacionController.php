<?php
namespace app\modules\calendarios\controllers;

use Yii;
use app\modules\calendarios\models\CalendarioCalibracion;
use app\modules\catalogos\models\Areas;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;

class AsignacionController extends Controller
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

    public function actionCalibracion()
    {
        $model = new CalendarioCalibracion();
        $dataProvider = new ActiveDataProvider([
            'query' => CalendarioCalibracion::find()->with('idarea0','idreferencia0','idestatus0'),
        ]);

        $items   = ArrayHelper::map(Areas::find()->all(),'idarea','descarea');
        
        return $this->render('Calibracion', [
            'model'         => $model,
            'items'         => $items,
            'dataProvider'  => $dataProvider
        ]);
    }

    public function actionGenerales()
    {
        
    }   
}
?>