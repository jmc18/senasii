<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\clientes\models\ClientesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clientes-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idcte') ?>

    <?= $form->field($model, 'nomcte') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'telcte1') ?>

    <?= $form->field($model, 'telcte2') ?>

    <?php // echo $form->field($model, 'dircte') ?>

    <?php // echo $form->field($model, 'edocte') ?>

    <?php // echo $form->field($model, 'pais') ?>

    <?php // echo $form->field($model, 'cpcte') ?>

    <?php // echo $form->field($model, 'sucursal') ?>

    <?php // echo $form->field($model, 'usrcte') ?>

    <?php // echo $form->field($model, 'pwdcte') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
