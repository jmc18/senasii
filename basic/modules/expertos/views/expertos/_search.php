<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\expertos\models\ExpertosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="expertos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idexperto') ?>

    <?= $form->field($model, 'nomexperto') ?>

    <?= $form->field($model, 'apepat') ?>

    <?= $form->field($model, 'apemat') ?>

    <?= $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'telexperto') ?>

    <?php // echo $form->field($model, 'nacionalidad') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
