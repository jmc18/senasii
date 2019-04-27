<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\usuarios\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuarios-form">

<div class="expertos-index">

  <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Registro de Usuarios</h3>
        </div>
        <div class="panel-body">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, "password")->input("password") ?>   
            
    <?= $form->field($model, "email")->input("email") ?>   

    <?= $form->field($model, 'activate')->dropDownList(
                                            [0 => 'Inactivo', 1 => 'Activo'], 
                                            ['prompt' => 'Selecciona un estatus para la cuenta del usuario' ]);
    ?>
        
    <?= $form->field($model, 'role')->dropDownList(
                                            [1 => 'Usuario', 2 => 'Administrador'],
                                            ['prompt' => 'Selecciona un rol para la cuenta del usuario' ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

        </div>
    </div>

</div>