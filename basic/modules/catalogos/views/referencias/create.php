<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\catalogos\models\Referencias */

$this->title = 'Crear Referencias';
$this->params['breadcrumbs'][] = ['label' => 'Referencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="referencias-create">

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
