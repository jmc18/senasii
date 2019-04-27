<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\contactos\models\Contactos */

$this->title = 'Update Contactos';
$this->params['breadcrumbs'][] = ['label' => 'Contactos', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="contactos-update">

	<div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="panel-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    	</div>
    </div>

</div>
