<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Alert;

/* @var $this yii\web\View */
/* @var $model app\modules\clientes\models\Clientes */

$this->title = 'Registrar Cliente';
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
echo Alert::widget([
    'type' => Alert::TYPE_WARNING,
    'title' => 'BIENVENIDO A SPEA!',
    'icon' => 'glyphicon glyphicon-ok-sign',
    'body' => 'Para finalizar con el registro es necesario que nos proporciones los siguientes datos.',
    'showSeparator' => true,
    'delay' => 5000
]);

?>
<div class="clientes-form">

     <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Registro de Clientes</h3>
        </div>
        <div class="panel-body">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nomcte')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telcte1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telcte2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dircte')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'edocte')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pais')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cpcte')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sucursal')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Registrar Cliente' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?> 
         </div>
    </div>
</div>
