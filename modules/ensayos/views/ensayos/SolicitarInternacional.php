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
$this->title = 'Solicitar Ensayo de Calibración Internacional';
$this->params['breadcrumbs'][] = ['label'=>'Seleccionar Ensayos','url'=>['ensayos/']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="calendario-calibracion-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Selección de Ensayos Internacionales</h3>
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
            [   
                'class' => 'yii\grid\ActionColumn',
                'header'=> 'Solicitar',
                'template' => '{select}',
                'buttons' => [
                    'select' => function($url, $model) use ($idcte)
                    {
                        return Html::a('<span class="glyphicon glyphicon-ok"></span>',
                             ['guardarensayocalibracion', 'idarea' => $model->idarea, 'idref'=>$model->idreferencia, 'idcte'=>$idcte], 
                             [
                                'class'=>'btn btn-default btn-xs btn-block',
                             ]
                        );
                    }
                ],
            ]
        ],
    ]); ?>
   
    <div class="form-group">
        <!--<= Html::submitButton($model->isNewRecord ? 'Guardar Calendario' : 'Actualizar Calendario', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>-->
    </div>

    <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>