<?php

/* @var $this yii\web\View */

//use yii\helpers\Html;
use kartik\helpers\Html;
use app\models\User; 
use kartik\grid\GridView;
use yii\widgets\ActiveForm;

$this->title = 'Alertas Programadas';
$this->params['breadcrumbs'][] = $this->title;

?>

<?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>

    <div class="site-index">        

        <div class="panel panel-primary">
    
            <div class="panel-heading">
                <h3 class="panel-title">Datos del Ensayo</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="panel panel-primary">
                            <div class="panel-body">                
                                <h5><b>Area: </b>
                                    <?php echo $model_calibracion->idarea0->descarea; ?>
                                </h5>
                                <h5><b>Referencia: </b>
                                    <?php echo $model_calibracion->idreferencia0->descreferencia; ?>
                                </h5>
                                <h5><b>Intervalo: </b>
                                    <?php echo $model_calibracion->intervalo; ?>
                                </h5>
                            </div>
                        </div><!-- panel-body -->
                    </div>
                </div>
            </div>
        </div>
        
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Alertas Programadas</h3>
                </div>
                <div class="panel-body">

                <?=
                GridView::widget([
                'dataProvider' => $dataAlertasCalibracion,
                'columns' => [
                        'fecha:date',
                        [   
                            'format'=>'html',
                            'header'=> 'Estatus',
                            'value' => function ($dataEnsayosCalibracion) {

                                switch($dataEnsayosCalibracion->estatus)
                                {
                                    case '0': return Html::bsLabel("PENDIENTE DE ENVIAR", Html::TYPE_DANGER);
                                    case '1': return Html::bsLabel("ENVIADA", Html::TYPE_SUCCESS);
                                }
                            }
                        ],
                        'msjalerta',
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header'=> 'Opciones',
                            'template' => '{update}   {delete}',
                            'buttons' => [
                                'update' => function($url, $model)
                                {
                                    return Html::a('<span class="glyphicon glyphicon-edit"></span>',
                                         ['editaralertacalibracion', 'idalerta' => $model->idalerta], 
                                         [
                                            'class' => '',
                                            'data' => [
                                            ],
                                        ]
                                    );
                                },
                                'delete' => function($url, $model)
                                {
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                                         ['eliminaralertacalibracion', 'idalerta' => $model->idalerta, 'idarea'=>$model->idarea, 'idref'=>$model->idreferencia, 'idcot'=>$model->idcot], 
                                         [
                                            'class' => '',
                                            'data' => [
                                                'confirm' => '¿Deseas borrar la alerta programa para este ensayo?',
                                                'method' => 'post',
                                            ],
                                        ]
                                    );
                                }
                            ],
                        ],
                    ],
                ]);
                ?>
                
                    <div class="form-group">
                        <?= Html::a('Agregar Alerta', ['crearalertacalibracion', 'idarea' => $idarea, 'idref'=>$idref, 'idcot'=>$idcot], ['class' => 'btn btn-success']) ?>
            
                        <?= Html::a('Regresar', ['/site/index'],['class' => 'btn btn-danger']); ?>
                    </div>        
                </div>
            </div>
</div>