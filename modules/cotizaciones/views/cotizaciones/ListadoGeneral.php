<?php

//use yii\helpers\Html;
use kartik\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\modules\calendarios\models\CalendarioCalibracion */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Listado de Cotizaciones Calibración';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>
      
<div class="calendario-calibracion-form">

    <?php
        $form = ActiveForm::begin([
            'action' => ['cotizaciones/creargeneral']
        ]);
    ?>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Listado de Otras Cotizaciones Realizadas</h3>
        </div>
        <div class="panel-body">

    <?= 
        GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
            [
                'header' => 'No Cotización',
                'value' => 'idcot',
            ],
            'fecha:date',
            [
                'header' => 'Expira',
                'format' => 'date',
                'value' => 'fechaexpira',
            ],
            /*'intervalo',
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
            ],*/
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=> 'Acciones',
                'visible'=> ( date('Y-m-d') <= 'fechaexpira' ) ? true : false,
                'template' => '{update}',
                'buttons' => [
                    'update' => function($url, $model)
                    {
                        return Html::a('<span class="glyphicon glyphicon-edit"> Editar</span>',
                             ['editargeneral', 'idcot' => $model->idcot, 'idcte' => $model->idcte], 
                             [
                                'data-toggle'=>'tooltip',
                                'data-placement'=>'bottom',
                                'title'=>'Editar cotización',
                                //'class' => 'btn btn-danger btn-sm',
                                'class' => 'btn btn-primary btn-sm btn-block',
                                'data' => [
                                ],
                            ]
                        );
                    },
                ]
            ],
            /*[
                'class' => 'yii\grid\ActionColumn',
                'header'=> 'Acciones',
                'visible'=> ( date('Y-m-d') <= 'fechaexpira' ) ? true : false,
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function($url, $model)
                    {
                        return Html::a('<span class="glyphicon glyphicon-trash"> Borrar</span>',
                             ['eliminargeneral', 'idcot' => $model->idcot, 'idcte' => $model->idcte], 
                             [
                                'data-toggle'=>'tooltip',
                                'data-placement'=>'bottom',
                                'title'=>'Eliminar cotización',
                                //'class' => 'btn btn-danger btn-sm',
                                'class' => 'btn btn-danger btn-sm btn-block',
                                'data' => [
                                    'confirm' => '¿Deseas borrar la cotización y todos sus ensayos?',
                                    'method' => 'post',
                                ],
                            ]
                        );
                    },
                ]
            ],*/
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=> 'Acciones',
                'template' => '{imprimir}',
                'buttons' => [
                    'imprimir' => function($url, $model)
                    {
                        return Html::a('<span class="glyphicon glyphicon-print"> Imprimir</span>',
                             ['imprimirgeneral', 'idcot' => $model->idcot], 
                             [
                                'data-toggle'=>'tooltip',
                                'data-placement'=>'bottom',
                                'title'=>'Imprimir cotización',
                                //'class' => 'btn btn-danger btn-sm',
                                'class' => 'btn btn-primary btn-sm btn-block',
                                'data' => [
                                    'method' => 'post',
                                ],
                             ]
                        );
                    }
                ],
            ],
        ],
    ]); ?>
   
    <div class="form-group">
        <?= Html::submitButton('Nueva Cotización' , ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Regresar', ['/site/index'],['class' => 'btn btn-danger']); ?>
    </div>

    <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
