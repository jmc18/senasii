<?php

use yii\helpers\Html;
//use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;
?>

<?php
$form = ActiveForm::begin([
            "method" => "post",
            "action" => Url::toRoute("ensayos/actualizarsubmuestraenvio"),
            'enableClientValidation' => true
        ]);
?>

<?=
$form->field($model, 'idunidad')->widget(Select2::classname(), [
    'data' => $unidades,
    'language' => 'en',
    'options' => ['placeholder' => 'Elegir Unidad de Medida'],
    'pluginOptions' => ['allowClear' => true],
])->label("Unidad de Medida");
?>

<?= $form->field($model, 'resultado')->textInput(['maxlength' => 50]) ?>
<?= $form->field($model, 'parametro')->textInput(['maxlength' => 50]) ?>

<?php
echo $form->field($model, 'idarea', ['options' => [
        'value' => $model->idarea]])->hiddenInput()->label(false);

echo $form->field($model, 'idreferencia', ['options' => [
        'value' => $model->idreferencia]])->hiddenInput()->label(false);

echo $form->field($model, 'idcot', ['options' => [
        'value' => $model->idcot]])->hiddenInput()->label(false);

echo $form->field($model, 'no_submuestra', ['options' => [
        'value' => $model->no_submuestra]])->hiddenInput()->label(false);
?>

    <div>
        <?= Html::submitButton('Modificar Sub Muestra', ['class' => 'btn btn-primary btn-block']) ?>
    </div>

<?php
ActiveForm::end();
?>

