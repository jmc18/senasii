<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\contactos\models\Contactos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contactos-form">

    <?php $form = ActiveForm::begin(); ?>

    <!--<= $form->field($model, 'nocontacto')->textInput() ?>-->

    <?= $form->field($model, 'nombrecon')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apepatcon')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apematcon')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emailcon')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telcon')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Regresar', ['/contactos/contactos'],['class' => 'btn btn-danger']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
