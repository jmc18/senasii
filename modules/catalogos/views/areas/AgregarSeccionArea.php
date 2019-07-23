<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">Agregar Sección Para el Área: <b class="text-danger"><?= $nomArea ?></b></h3>
    </div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'nombre')->label("Nombre de la sección") ?>

        <?= $form->field($model, 'idarea')->hiddenInput()->label(false) ?>

        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
            <?= Html::a("Cancelar", ["areas/configurar-formulario", "id" => $model->idarea], ['class' => 'btn btn-danger'])?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>