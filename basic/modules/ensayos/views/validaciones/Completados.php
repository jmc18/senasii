<?php
//use yii\helpers\Html;
use kartik\helpers\Html;
use yii\widgets\ActiveForm;
//use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\modules\calendarios\models\CalendarioCalibracion */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Ensayos Completados';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>

<div class="calendario-calibracion-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Validar Ensayos Completados</h3>
        </div>
        <div class="panel-body">

    <?=
   GridView::widget([
    'dataProvider' => $dataEnsayosCalibracion,
    'columns' => [
            [
                'header'=> 'Area',
                'value' => 'idarea0.idarea0.descarea'
            ],
            [   
                'header'=> 'Referencia',
                'value' => 'idarea0.idreferencia0.descreferencia',
            ],
            'idarea0.intervalo',
            'idcte0.nomcte',
            //'fecinicio:date',
            [   
                'format'=>'html',
                'header'=> 'Estatus',
                'value' => function ($dataEnsayosCalibracion) {

                    switch($dataEnsayosCalibracion->idarea0->idestatus0->idestatus)
                    {
                        case 1: return Html::bsLabel($dataEnsayosCalibracion->idarea0->idestatus0->descestatus, Html::TYPE_PRIMARY);
                        case 2: return Html::bsLabel($dataEnsayosCalibracion->idarea0->idestatus0->descestatus, Html::TYPE_SUCCESS);
                        case 3: return Html::bsLabel($dataEnsayosCalibracion->idarea0->idestatus0->descestatus, Html::TYPE_DANGER);
                        case 4: return Html::bsLabel($dataEnsayosCalibracion->idarea0->idestatus0->descestatus, Html::TYPE_WARNING);
                    }
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=> 'Evidencias',
                'template' => '{ver}',
                'buttons' => [
                    'ver' => function($url, $model)
                    {
                        return Html::a('<span class="glyphicon glyphicon-check"></span> Ver Archivos',
                             ['listararchivos', 'idarea' => $model->idarea, 'idref'=>$model->idreferencia, 'idcte'=>$model->idcte, 'idetapa'=>1], 
                             [
                             ]
                        );
                    },
                ],
            ],
        ],
    ]);
    ?>


   <?=
   GridView::widget([
            'dataProvider' => $dataEnsayosGenerales,
            'columns' => [
            [
                'header' => 'Rama',
                 'value' => 'idrama0.idrama0.descrama',
            ],
            [
                'header' => 'Rubrama',
                'value' => 'idrama0.idsubrama0.descsubrama',
            ],
            [
                'header' => 'Analito',
                'value' => 'idrama0.idanalito0.descparametro',
            ],
            [
                'header' => 'Referencia',
                'value' => 'idrama0.idreferencia0.descreferencia',
            ],
            'idrama0.intervalo',
            'idcte0.nomcte',
            [
                'format'=>'html',
                'header'=> 'Estatus',
                'value' => function ($dataEnsayosGenerales) {

                    switch($dataEnsayosGenerales->idrama0->idestatus0->idestatus)
                    {
                        case 1: return Html::bsLabel($dataEnsayosGenerales->idrama0->idestatus0->descestatus, Html::TYPE_PRIMARY);
                        case 2: return Html::bsLabel($dataEnsayosGenerales->idrama0->idestatus0->descestatus, Html::TYPE_SUCCESS);
                        case 3: return Html::bsLabel($dataEnsayosGenerales->idrama0->idestatus0->descestatus, Html::TYPE_DANGER);
                        case 4: return Html::bsLabel($dataEnsayosGenerales->idrama0->idestatus0->descestatus, Html::TYPE_WARNING);
                    }
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=> 'Validar',
                'template' => '{update}',
                'buttons' => [
                    'update' => function($url, $model)
                    {
                        return Html::a('<span class="glyphicon glyphicon-check"></span>',
                             ['aceptarpagogeneral', 'idrama' => $model->idrama,'idsubrama' => $model->idsubrama, 'idanalito'=>$model->idanalito, 'idref'=>$model->idreferencia, 'idcte'=>$model->idcte], 
                             [
                             ]
                        );
                    },
                ],
            ],
        ],
    ]);
   ?>

    <div class="form-group">
        <!--<= Html::submitButton($model->isNewRecord ? 'Guardar Calendario' : 'Actualizar Calendario', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>-->
    </div>

    <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>