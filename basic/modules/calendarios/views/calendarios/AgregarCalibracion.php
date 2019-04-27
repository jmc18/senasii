<?php
use kartik\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\modules\calendarios\models\CalendarioCalibracion */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Calibración';
$this->params['breadcrumbs'][] = ['label'=>'Tipos de Calendarios','url'=>['/calendarios']];
$this->params['breadcrumbs'][] = ['label'=>'Calendario Calibración','url'=>['/calendarios/calendarios/calibracion']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="calendario-calibracion-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Registro de Ensayo en el Calendario</h3>
        </div>
        <div class="panel-body">

    <?= 
        $form->field($model, 'idarea')->dropDownList($items, ['id'=>'idarea']);
    ?>

    <?= 
        $form->field($model, 'idreferencia')->dropDownList($itemsref, ['id'=>'idreferencia']);
    ?>

    <?= $form->field($model, 'intervalo')->textInput(['maxlength' => true]) ?>

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
        $form->field($model, 'peridodfin')->widget(DatePicker::classname(), 
                [
                    'options' => ['placeholder' => 'Introduce la fecha final del periodo de ensayo'],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd',
                    ]
                ]);
    ?>

    <?= 
        $form->field($model, 'fecinicio')->widget(DatePicker::classname(), 
                [
                    'options' => ['placeholder' => 'Introduce la fecha de inicio de los ensayos'],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd',
                    ]
                ]);
    ?>

    <?= 
        $form->field($model, 'idestatus')->dropDownList($itemsstt, ['id'=>'idestatus']);
    ?>

    <?= $form->field($model, 'costo')->textInput(['maxlength' => true]) ?>
 
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Guardar Calendario' : 'Actualizar Calendario', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Regresar', ['/calendarios/calendarios/calibracion'],['class' => 'btn btn-danger']); ?>
    </div>

    <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>