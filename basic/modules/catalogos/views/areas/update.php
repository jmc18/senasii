<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\catalogos\models\Areas */

$this->title = 'Actualizar Areas';
$this->params['breadcrumbs'][] = ['label' => 'Areas', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="areas-update">

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
