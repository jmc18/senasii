<?php
use kartik\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\modules\calendarios\models\CalendarioCalibracion */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Calibración';
$this->params['breadcrumbs'][] = ['label'=>'Tipos de Calendarios','url'=>['/calendarios']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>

<?php
            
    Modal::begin([
            'header' => '<h4>Lineamientos del Ensayo</h4>',
            'id'     => 'modal',
            'size'   => 'modal-lg',
    ]);
    
    echo "<div id='modalContent'></div>";
    
    Modal::end();
            
?>

<div class="calendario-calibracion-form">

    <?php
        $form = ActiveForm::begin([
            'action' => ['calendarios/agregarcalibracion']
        ]);
    ?>

<div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Calendario Anual de Ensayos de Calibración</h3>
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
            'fecinicio:date',
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
                'header'=> 'Acciones',
                'template' => '{update}{delete}',
                'buttons' => [
                    'update' => function($url, $model)
                    {
                        return Html::a('<span class="glyphicon glyphicon-edit"> </span>',
                             ['editarcalibracion', 'idarea' => $model->idarea, 'idref'=>$model->idreferencia], 
                             [ 
                                'data-toggle'=>'tooltip',
                                'data-placement'=>'bottom',
                                'title'=>'Editar Ensayo',
                                'class' => 'btn btn-primary btn-sm',
                             ]
                        );
                    },
                    'delete' => function($url, $model)
                    {
                        return Html::a('<span class="glyphicon glyphicon-trash"> </span>',
                             ['eliminarcalibracion', 'idarea' => $model->idarea, 'idref'=>$model->idreferencia], 
                             [
                                'data-toggle'=>'tooltip',
                                'data-placement'=>'bottom',
                                'title'=>'Eliminar ensayo',
                                'class' => 'btn btn-danger btn-sm',
                                'data' => [
                                    'confirm' => '¿Deseas borrar el ensayo de este calendario?',
                                    'method' => 'post',
                                ],
                            ]
                        );
                    },
                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'options'=>['class'=>'action-column'],
                'template'=>'{update}',
                'buttons'=>[
                'update' => function($url,$model,$key){
                        $btn = Html::button("Lineamientos",[
                            'value'=>Yii::$app->urlManager->createUrl(["calendarios/calendarios/lineamientocalibracion","idarea"=>$model->idarea,"idreferencia"=>$model->idreferencia]), //<---- here is where you define the action that handles the ajax request
                            'class'=>'update-modal-click btn btn-primary btn-sm',
                            'data-toggle'=>'tooltip',
                            'data-placement'=>'bottom',
                            'title'=>'Gestionar Lineamientos'
                        ]);
                        return $btn;
                    }
                ]
            ],
        ],
    ]); ?>
   
    <div class="form-group">
        <?= Html::submitButton('Agregar Ensayo al Calendario' , ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Regresar', ['/calendarios'],['class' => 'btn btn-danger']); ?>
    </div>


    <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
