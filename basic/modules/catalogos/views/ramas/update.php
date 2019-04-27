<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\catalogos\models\Ramas */

$this->title = 'Actualizar Ramas ';
$this->params['breadcrumbs'][] = ['label' => 'Ramas', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="ramas-update">

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
