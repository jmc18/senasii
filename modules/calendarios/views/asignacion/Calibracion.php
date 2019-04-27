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
$this->title = 'Asignación Expertos';
$this->params['breadcrumbs'][] = ['label'=>'Tipos de Calendarios','url'=>['/calendarios']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="calendario-calibracion-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Asignación de Expertos</h3>
        </div>
        <div class="panel-body">

    <?=

    GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
            [
                'header'=> 'Area',
                'value' => 'idarea0.descarea'
            ],
            [   
                'header'=> 'Referencia',
                'value' => 'idreferencia0.descreferencia',
            ],
            'intervalo',
            'periodoini:date',
            'peridodfin:date',
            //'fecinicio:date',
            [   
                'format'=>'html',
                'header'=> 'Estatus',
                'value' => function ($dataProvider) {

                    switch($dataProvider->idestatus0->idestatus)
                    {
                        case 1: return Html::bsLabel($dataProvider->idestatus0->descestatus, Html::TYPE_PRIMARY);
                        case 2: return Html::bsLabel($dataProvider->idestatus0->descestatus, Html::TYPE_SUCCESS);
                        case 3: return Html::bsLabel($dataProvider->idestatus0->descestatus, Html::TYPE_DANGER);
                        case 4: return Html::bsLabel($dataProvider->idestatus0->descestatus, Html::TYPE_WARNING);
                    }
                }
            ],
           /* [   
                'format'=>'html',
                'header'=> 'Experto',
                'value' => function ($items) {
                    return Html::activeDropDownList($items, ['id'=>'idrama']);
                }
            ],
           /* [
                'class' => 'yii\grid\ActionColumn',
                'header'=> 'Acciones',
                'template' => '{update}{delete}',
                'buttons' => [
                    'update' => function($url, $model)
                    {
                        return Html::a('<span class="glyphicon glyphicon-edit"></span>',
                             ['editarcalibracion', 'idarea' => $model->idarea, 'idref'=>$model->idreferencia], 
                             [
                             ]
                        );
                    },
                    'delete' => function($url, $model)
                    {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                             ['eliminarcalibracion', 'idarea' => $model->idarea, 'idref'=>$model->idreferencia], 
                             [
                                'class' => '',
                                'data' => [
                                    'confirm' => '¿Deseas borrar el ensayo de este calendario?',
                                    'method' => 'post',
                                ],
                            ]
                        );
                    }
                ],
            ],*/
        ],
    ]); ?>
   
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Guardar Calendario' : 'Actualizar Calendario', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
