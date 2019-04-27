<?php
//use yii\helpers\Html;
use kartik\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\grid\GridView;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $model app\modules\calendarios\models\CalendarioCalibracion */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Registrar Cotización';
$this->params['breadcrumbs'][] = ['label'=>'Listado de Cotizaciones','url'=>['/cotizaciones/cotizaciones/listado']];
$this->params['breadcrumbs'][] = $this->title;

if( date('Y-m-d') <= $model->fechaexpira || $model->fechaexpira == null )
    $visible = true;
else
    $visible = false;
?>

<?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>

<div class="calendario-calibracion-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="panel panel-primary">
        
        <div class="panel-body">                
            <div class="row">
                <div class="col-md-4 col-xs-12">
                    <?php
                    \yiister\gentelella\widgets\Panel::begin(
                        [
                            'header' => 'Datos del Cliente',
                            'icon' => 'calendar',
                        ]
                    )
                    ?>
                    <h5><b>Nombre de Cliente: </b>
                        <?php echo $model_cte->nomcte; ?>
                    </h5>
                    <h5><b>Email del Cliente: </b>
                        <?php echo $model_cte->email; ?>
                    </h5>
                    <h5><b>Sucursal: </b>
                        <?php echo $model_cte->sucursal; ?>
                    </h5>
                    <?= 
                        $form->field($model, 'nocontacto')->dropDownList($listcontactos, ['id'=>'nocontacto']);
                    ?>
                    <?php \yiister\gentelella\widgets\Panel::end() ?>
                </div>

                <div class="col-md-4 col-xs-12">
                    <?php
                    \yiister\gentelella\widgets\Panel::begin(
                        [
                            'header' => 'Datos de la Cotización',
                            'icon' => 'calendar',
                        ]
                    )
                    ?>
                    <h5><b>Folio de la Cotización: </b>
                        <?php echo $model->idcot; ?>
                    <h5><b>Subtotal : <?= Html::bsLabel(number_format($subtotal,2), Html::TYPE_PRIMARY);?></b>
                    </h5>
                    <h5><b>iva 16% : <?= Html::bsLabel(number_format($subtotal * .16,2), Html::TYPE_PRIMARY);?></b>
                    </h5>
                    <h5><b>Total : <?= Html::bsLabel(number_format($subtotal + ($subtotal*.16),2), Html::TYPE_PRIMARY);?></b>
                    </h5>
                    
                    <?php \yiister\gentelella\widgets\Panel::end() ?>
                </div>

                <div class="col-md-4 col-xs-12">
                    <?php
                    \yiister\gentelella\widgets\Panel::begin(
                        [
                            'header' => 'Acciones',
                            'icon' => 'calendar',
                        ]
                    )
                    ?>
                    <!--<= Html::a('Imprimir Cotización', ['/cotizaciones/cotizaciones/imprimirgeneral','idcot'=>$model->idcot], ['class'=>'btn btn-primary btn-block']) ?>-->
                    <?= Html::a('Regresar', ['/cotizaciones/cotizaciones/listadogeneral'], ['class'=>'btn btn-primary btn-block']) ?>
                    <?php \yiister\gentelella\widgets\Panel::end() ?>
                </div>
            </div>
        </div>
    </div>   

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Listado de Ensayos</h3>
        </div>
        <div class="panel-body">
            <?=
                GridView::widget([
            'dataProvider' => $data_general,
            'columns' => [
            [
                'header' => 'Rama',
                 'value' => 'idrama0.descrama',
            ],
            [
                'header' => 'Subrama',
                'value' => 'idsubrama0.descsubrama',
            ],
            [
                'header' => 'Analito',
                'value' => 'idanalito0.descparametro',
            ],
            [
                'header' => 'Referencia',
                'value' => 'idreferencia0.descreferencia',
            ],
            'periodoini:date',
            'periodofin:date',
            'costo',
            //'fechaentrega:date',
            'fecharesultados:date',
            //'fechafinal:date',
            'intervalo',
            [
                'format'=>'html',
                'header'=> 'Estatus',
                'value' => function ($dataProvider) {

                    switch($dataProvider->idestatus0->idestatus)
                    {
                        case 1: return Html::bsLabel($dataProvider->idestatus0->descestatus, Html::TYPE_PRIMARY);
                        case 2: return Html::bsLabel($dataProvider->idestatus0->descestatus, Html::TYPE_WARNING);
                        case 3: return Html::bsLabel($dataProvider->idestatus0->descestatus, Html::TYPE_DANGER);
                        case 4: return Html::bsLabel($dataProvider->idestatus0->descestatus, Html::TYPE_WARNING);
                        case 5: return Html::bsLabel($dataProvider->idestatus0->descestatus, Html::TYPE_SUCCESS);
                        case 6: return Html::bsLabel($dataProvider->idestatus0->descestatus, Html::TYPE_DANGER);
                    }
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=> 'Acción',
                'visible' => $visible,
                'template' => '{update}',
                'buttons' => [
                    'update' => function($url, $model) use ($model_cte)
                    {
                        if($model->idestatus0->idestatus != 3)
                        {
                            if( $model->idestatus0->idestatus == 2 )
                                $alerta = 'El ensayo ya esta en desarrollo, y al cotizarlo SENA evaluará su factibilidad...';
                            else
                                $alerta = 'Agregar ensayo a la cotización';

                            return Html::a('<span class="glyphicon glyphicon-plus">Agregar</span>',
                                ['agregargeneral', 'idrama' => $model->idrama,'idsubrama' => $model->idsubrama, 'idanalito'=>$model->idanalito, 'idref'=>$model->idreferencia, 'idcte'=>$model_cte->idcte,'costo'=>$model->costo,'estatus'=>$model->idestatus0->idestatus], 
                                [
                                    'data-toggle'=>'tooltip',
                                    'data-placement'=>'bottom',
                                    'title'=> $alerta,
                                    'class'=> 'btn btn-primary btn-xs btn-block',
                                    'data' => [
                                        'method' => 'post',
                                    ],
                                ]
                            );
                        }
                        else
                            return "";
                    },
                ],
            ],
        ],
    ]);
            ?>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Otros Ensayos Cotizados</h3>
        </div>
        <div class="panel-body">

            <?= GridView::widget([
                'dataProvider' => $dataCotGen,
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
                'idrama0.periodoini:date',
                'idrama0.periodofin:date',
                'idrama0.costo',
                //'fechaentrega:date',
                'idrama0.fecharesultados:date',
                'idrama0.fechafinal:date',
                'idrama0.intervalo',
                [
                    'format'=>'html',
                    'header'=> 'Estatus',
                    'value' => function ($dataProvider) {

                        switch($dataProvider->idrama0->idestatus0->idestatus)
                        {
                            case 1: return Html::bsLabel($dataProvider->idrama0->idestatus0->descestatus, Html::TYPE_PRIMARY);
                            case 2: return Html::bsLabel($dataProvider->idrama0->idestatus0->descestatus, Html::TYPE_WARNING);
                            case 3: return Html::bsLabel($dataProvider->idrama0->idestatus0->descestatus, Html::TYPE_DANGER);
                            case 4: return Html::bsLabel($dataProvider->idrama0->idestatus0->descestatus, Html::TYPE_WARNING);
                            case 5: return Html::bsLabel($dataProvider->idarea0->idestatus0->descestatus, Html::TYPE_SUCCESS);
                            case 6: return Html::bsLabel($dataProvider->idarea0->idestatus0->descestatus, Html::TYPE_DANGER);
                        }
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header'=> 'Acción',
                    'visible'=> $visible,
                    'template' => '{eliminar}',
                    'buttons' => [
                        'eliminar' => function($url, $model) use ($model_cte)
                        {
                            if($model->idrama0->idestatus0->idestatus != 3)
                            {
                                return Html::a('<span class="glyphicon glyphicon-trash"> Eliminar</span>',
                                     ['eliminargeneral', 'idrama' => $model->idrama,'idsubrama' => $model->idsubrama, 'idanalito'=>$model->idanalito, 'idref'=>$model->idreferencia, 'idcot'=> $model->idcot,'idcte'=>$model_cte->idcte], 
                                     [
                                        'data-toggle'=>'tooltip',
                                        'data-placement'=>'bottom',
                                        'title'=> 'Eliminar ensayo cotizado',
                                        'class'=> 'btn btn-danger btn-xs btn-block',
                                        'data' => [
                                            'method' => 'post',
                                        ],
                                    ]
                                );
                            }
                            else
                                return "";
                        },
                    ],
                ],
            ],
            ]);
        ?>

        </div>
    </div>

    </div>
</div>

    <?php
        echo $form->field($model, 'idcot', 
            ['options' => [
                'value'=> $model->idcot] ])->hiddenInput()->label(false);
    ?>
    <?php ActiveForm::end(); ?>

</div>