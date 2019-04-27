<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>

<div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Registro de usuarios</h3>
        </div>
        <div class="panel-body">

			<?php $form = ActiveForm::begin([
			    'method' => 'post',
			 	'id' => 'formulario',
			 	//'enableClientValidation' => false,
			 	//'enableAjaxValidation' => true,
				]);	
			?>

			<div class="form-group">
			 <?= $form->field($model, "username")->input("text") ?>   
			</div>

			<div class="form-group">
			 <?= $form->field($model, "email")->input("email") ?>   
			</div>

			<div class="form-group">
			 <?= $form->field($model, "password")->input("password") ?>   
			</div>

			<div class="form-group">
			 <?= $form->field($model, "password_repeat")->input("password") ?>   
			</div>

			<?= Html::submitButton("Registrar", ["class" => "btn btn-primary"]) ?>

			<?php $form->end() ?>

		</div>
</div>