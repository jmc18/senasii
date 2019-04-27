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
$this->title = 'Historial de Ensayos';
$this->params['breadcrumbs'][] = $this->title;
?>

 <?php $form = ActiveForm::begin(); ?>

<div class="calendario-calibracion-form">

    <div class="panel panel-primary">  
        <div class="panel-heading">
            <h3 class="panel-title">Historial</h3>
        </div>
        <div class="panel-body">

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Ensayos de Calibración</h3>
                </div>
                <div class="panel-body">

                <?=
                GridView::widget([
                'dataProvider' => $dataEnsayosCalibracion,
                'columns' => [
                        [
                            'header' => 'Cotización',
                            'value' => 'idcot' 
                        ],
                        [
                            'header'=> 'Area',
                            'value' => 'idarea0.idarea0.descarea'
                        ],
                        [   
                            'header'=> 'Referencia',
                            'value' => 'idarea0.idreferencia0.descreferencia',
                        ],
                        'idarea0.intervalo',
                        'idarea0.periodoini:date',
                        'idarea0.peridodfin:date',
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
                            'format'=>'html',
                            'header'=> 'Estatus Pago',
                            'value' => function ($dataEnsayosCalibracion) {

                                if($dataEnsayosCalibracion->seguimiento0->valida_pago == null)
                                    return Html::bsLabel('PENDIENTE DE PAGO', Html::TYPE_DANGER);
                                else
                                    return Html::bsLabel('PAGADO', Html::TYPE_SUCCESS);
                            }
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header'=> 'Seguimiento',
                            'template' => '{update}',
                            'buttons' => [
                                'update' => function($url, $model)
                                {
                                    return Html::a('<span class="glyphicon glyphicon-sort-by-attributes"></span> Ver',
                                         ['seguimientocalibracion', 'idarea' => $model->idarea, 'idref'=>$model->idreferencia, 'idcot'=>$model->idcot], 
                                         [
                                            'class'=>'btn btn-default btn-xs btn-block',
                                         ]
                                    );
                                },
                            ],
                        ],
                    ],
                ]);
                ?>
                </div>
            </div>

<div class="calendario-calibracion-form">

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Otros Ensayos</h3>
        </div>
        <div class="panel-body">


   <?=
   GridView::widget([
            'dataProvider' => $dataEnsayosGenerales,
            'columns' => [
            [
                'header' => 'Cotización',
                'value' => 'idcot' 
            ],
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
            //'idrama0.periodoini:date',
            //'idrama0.periodofin:date',
            'idrama0.costo',
            //'fechaentrega:date',
            //'idrama0.fecharesultados:date',
            //'idrama0.fechafinal:date',
            'idrama0.intervalo',
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
                'format'=>'html',
                'header'=> 'Estatus Pago',
                'value' => function ($dataEnsayosGenerales) {

                    if($dataEnsayosGenerales->seguimiento0->valida_pago == null)
                        return Html::bsLabel('PENDIENTE DE PAGO', Html::TYPE_DANGER);
                    else
                        return Html::bsLabel('PAGADO', Html::TYPE_SUCCESS);
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=> 'Seguimiento',
                'template' => '{update}',
                'buttons' => [
                    'update' => function($url, $model)
                    {
                        return Html::a('<span class="glyphicon glyphicon-sort-by-attributes"></span> Ver',
                             ['seguimientogeneral', 'idrama' => $model->idrama,'idsubrama' => $model->idsubrama, 'idanalito'=>$model->idanalito, 'idref'=>$model->idreferencia, 'idcot'=>$model->idcot], 
                             [
                                'class'=>'btn btn-default btn-xs btn-block',
                             ]
                        );
                    },
                ],
            ],
        ],
    ]);
   ?>
    </div>
    </div>

    <div class="form-group">
        <?= Html::a('Regresar', ['/site/index'],['class' => 'btn btn-danger']); ?>
        <!--<= Html::submitButton($model->isNewRecord ? 'Guardar Calendario' : 'Actualizar Calendario', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>-->
    </div>

   
        </div>
    </div>
</div>

 <?php ActiveForm::end(); ?>