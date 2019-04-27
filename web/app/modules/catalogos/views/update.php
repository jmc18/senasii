<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\catalogos\models\Analitos */

$this->title = 'Update Analitos: ' . $model->idanalito;
$this->params['breadcrumbs'][] = ['label' => 'Analitos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idanalito, 'url' => ['view', 'id' => $model->idanalito]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="analitos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
