<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\expertos\models\Expertos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="expertos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nomexperto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apepat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apemat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telexperto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nacionalidad')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
