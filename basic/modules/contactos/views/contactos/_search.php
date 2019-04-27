<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\contactos\models\ContactosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contactos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'nocontacto') ?>

    <?= $form->field($model, 'nombrecon') ?>

    <?= $form->field($model, 'apepatcon') ?>

    <?= $form->field($model, 'apematcon') ?>

    <?= $form->field($model, 'emailcon') ?>

    <?php // echo $form->field($model, 'telcon') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
