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
            "action" => Url::toRoute("ensayos/registrarsubmuestrageneral"),
            'enableClientValidation' => true
        ]);
?>

<?=
$form->field($model, 'idunidad')->widget(Select2::classname(), [
    'data' => $unidades,
    'language' => 'es',
    'options' => ['placeholder' => 'Elegir Unidad de Medida'],
    'pluginOptions' => ['allowClear' => true],
])->label("Unidad de Medida");
?>

<?= $form->field($model, 'resultado')->textInput(['maxlength' => 50, 'value' => $model->resultado]) ?>
<?= $form->field($model, 'parametro')->textInput(['maxlength' => 50, 'value' => $model->parametro]) ?>

<?php
echo $form->field($model, 'idrama', ['options' => [
        'id' => 'idrama']])->hiddenInput()->label(false);

echo $form->field($model, 'idsubrama', ['options' => [
        'id' => 'idsubrama']])->hiddenInput()->label(false);

echo $form->field($model, 'idanalito', ['options' => [
        'id' => 'idanalito']])->hiddenInput()->label(false);

echo $form->field($model, 'idreferencia', ['options' => [
        'id' => 'idreferencia']])->hiddenInput()->label(false);

echo $form->field($model, 'idcot', ['options' => [
        'id' => 'idcot']])->hiddenInput()->label(false);
?>


<div>
    <?= Html::submitButton('Agregar Sub Muestra', ['class' => 'btn btn-success btn-block']) ?>
</div>

<?php
ActiveForm::end();
?>

<script>
    $("#cabecera").text("Agregar Sub Muestra");
    $("#resultadossubmuestrasgeneral-idrama").val($("#seguimientogeneral-idrama").val());
    $("#resultadossubmuestrasgeneral-idsubrama").val($("#seguimientogeneral-idsubrama").val());
    $("#resultadossubmuestrasgeneral-idanalito").val($("#seguimientogeneral-idanalito").val());
    $("#resultadossubmuestrasgeneral-idreferencia").val($("#seguimientogeneral-idreferencia").val());
    $("#resultadossubmuestrasgeneral-idcot").val($("#seguimientogeneral-idcot").val());
</script>

