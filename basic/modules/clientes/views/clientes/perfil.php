<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\clientes\models\Clientes */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="clientes-form">

    <div class="row">
        <div class="col-xs-2">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Perfil del Cliente</h3>
                </div>
                <div class="panel-body">
                	<?php echo Html::img('@web/images/user.png', [
                                                'class' => 'pull-left img-responsive', 
                                                'height'=>'150px', 
                                                'width'=>'150px']); ?>
                    <div class="panel-body">                
                    		
                    		
                    </div>
               	</div>
            </div>
        </div>
        <div class="col-xs-5">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Perfil del Cliente</h3>
                    <div class="panel-body">
                        <?= $form->field($model, 'nomcte')->textInput(['maxlength' => true]) ?></h5>
                            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?></h5>
                            <?= $form->field($model, 'telcte1')->textInput(['maxlength' => true]) ?></h5>
                            <?= $form->field($model, 'telcte2')->textInput(['maxlength' => true]) ?></h5>
                            <?= $form->field($model, 'dircte')->textInput(['maxlength' => true]) ?></h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-5">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Perfil del Cliente</h3>
                    <div class="panel-body">
                        <?= $form->field($model, 'edocte')->textInput(['maxlength' => true]) ?></h5>
                            <?= $form->field($model, 'pais')->textInput(['maxlength' => true]) ?></h5>
                            <?= $form->field($model, 'cpcte')->textInput(['maxlength' => true]) ?></h5>
                            <?= $form->field($model, 'sucursal')->textInput(['maxlength' => true]) ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<?php ActiveForm::end(); ?> 