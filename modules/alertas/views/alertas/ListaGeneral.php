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
                <h3 class="panel-title">Datos del Cliente</h3>
            </div>
            <div class="panel-body">
                <div class="panel-body">                
                    <h5><b>Rama: </b>
                        <?php echo $model_calendario->idrama0->descrama; ?>
                    </h5>
                    <h5><b>Subrama: </b>
                        <?php echo $model_calendario->idsubrama0->descsubrama; ?>
                    </h5>
                    <h5><b>Analito: </b>
                        <?php echo $model_calendario->idanalito0->descparametro; ?>
                    </h5>
                    <h5><b>Referencia: </b>
                        <?php echo $model_calendario->idreferencia0->descreferencia; ?>
                    </h5>
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
                'dataProvider' => $dataAlertasGeneral,
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
                                         ['editaralertageneral', 'idalerta' => $model->idalerta], 
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
                                         ['eliminaralertageneral', 'idalerta' => $model->idalerta, 'idrama' => $model->idrama, 'idsubrama' => $model->idsubrama, 'idanalito' => $model->idanalito, 'idref' => $model->idreferencia, 'idcot' => $model->idcot], 
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
                        <?= Html::a('Agregar Alerta', ['crearalertageneral', 'idrama' => $idrama, 'idsubrama' => $idsubrama, 'idanalito' => $idanalito, 'idref' => $idref,'idcot'=>$idcot], ['class' => 'btn btn-success']) ?>
            
                        <?= Html::a('Regresar', ['/site/index'],['class' => 'btn btn-danger']); ?>
                    </div>        
                </div>
            </div>
</div>