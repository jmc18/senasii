<?php

use kartik\widgets\FileInput;
use kartik\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\modules\calendarios\models\CalendarioCalibracion */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Calendarios';
$this->params['breadcrumbs'][] = ['label'=>'Tipos de Calendarios','url'=>['/calendarios']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>
      
<div class="calendario-calibracion-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Calendario Anual de Ensayos de Agua/Alimentos</h3>
        </div>
        <div class="panel-body">

    <?= 
        $form->field($model, 'idrama')->dropDownList($itemsA, ['id'=>'idrama']);
    ?>

    <?= 
        $form->field($model, 'idsubrama')->dropDownList($itemsS, ['id'=>'idsubrama']);
    ?>

    <?= 
        $form->field($model, 'idanalito')->dropDownList($itemsN, ['id'=>'idanalito']);
    ?>

    <?= 
        $form->field($model, 'idreferencia')->dropDownList($itemsR, ['id'=>'idreferencia']);
    ?>
    
    <?= 
        $form->field($model, 'periodoini')->widget(DatePicker::classname(),
                [
                    'options' => ['placeholder' => 'Introduce la fecha de inicio del periodo de ensayo'],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd',
                    ]
                ]);
    ?>

    <?= 
        $form->field($model, 'periodofin')->widget(DatePicker::classname(), 
                [
                    'options' => ['placeholder' => 'Introduce la fecha final del periodo de ensayo'],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd',
                    ]
                ]);
    ?>

    <?= $form->field($model, 'costo')->textInput(['maxlength' => true]) ?>
    
    <?= 
        $form->field($model, 'fechaentrega')->widget(DatePicker::classname(), 
                [
                    'options' => ['placeholder' => 'Introduce la fecha de de entrega del elemento de ensayo'],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd',
                    ]
                ]);
    ?>

    <?= 
        $form->field($model, 'fecharesultados')->widget(DatePicker::classname(), 
                [
                    'options' => ['placeholder' => 'Introduce la fecha de entrega de resultados'],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd',
                    ]
                ]);
    ?>

    <?= 
        $form->field($model, 'fechafinal')->widget(DatePicker::classname(), 
                [
                    'options' => ['placeholder' => 'Introduce la fecha de entrega de reporte final'],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd',
                    ]
                ]);
    ?>
    
    <?= $form->field($model, 'intervalo')->textInput(['maxlength' => true]) ?>  
    
    <?= 
        $form->field($model, 'idestatus')->dropDownList($itemsSt, ['id'=>'idestatus']);
    ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Guardar Calendario' : 'Actualizar Calendario', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Regresar', ['/calendarios/calendarios/calibracion'],['class' => 'btn btn-danger']); ?>
    </div>

    <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
