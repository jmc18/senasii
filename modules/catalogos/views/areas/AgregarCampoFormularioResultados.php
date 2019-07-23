<?php

use yii\bootstrap\Modal;
use kartik\select2\Select2;
use yii\helpers\Url;
use kartik\widgets\SwitchInput;
use kartik\form\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin(['action' => '#!',
            'enableAjaxValidation' => true, 'validateOnSubmit' => false,
            'options' => ['onsubmit' => 'RegistrarCampoFormulario(' . $model_formulario->idseccion . ', "' . $nombre_seccion . '"); return false;', 'id' => 'form_RegistrarCampoFormulario']]);

Modal::begin([
    'header' => '<h4>Editar Campo</h4>',
    'id' => 'modal_formulario_campo_insert',
    'size' => 'modal-lg',
]);

echo $form->field($model_formulario, 'texto_etiquetas');

echo $form->field($model_formulario, 'formula');

echo $form->field($model_formulario, 'idunidad')->widget(Select2::classname(), [
    'data' => $unidades,
    'options' => ['placeholder' => 'Seleccionar Unidad'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label('Unidad de Medida');


$model_formulario->req_bol = false;

echo $form->field($model_formulario, 'req_bol')->widget(SwitchInput::classname(), ["value" => 1,
    'pluginOptions' => [
        'onText' => '<i class="glyphicon glyphicon-ok"></i>',
        'offText' => '<i class="glyphicon glyphicon-remove"></i>',
        'onColor' => 'success',
        'offColor' => 'danger',
]])->label("El Campo es Requerido");

$list = ['alfanumérico' => 'Alfanumérico', 'numérico' => 'Numérico', 'enteros' => 'Enteros'];

echo $form->field($model_formulario, 'tipo_entrada')->radioList($list, ['inline' => true], ["unselect"])->label("Valores Aceptados");


echo $form->field($model_formulario, 'idseccion')->hiddenInput()->label(false);

echo $form->field($model_formulario, 'rec_bol_insert')->hiddenInput(["id" => "bol_requerido"])->label(false);
?>

<div class="modal-footer">
    <?= Html::submitButton('<span clas="fa fa-save"></span> Registra Campo', ['class' => 'btn btn-success btn-block']) ?>
</div>

<?php
Modal::end();

ActiveForm::end();
?>