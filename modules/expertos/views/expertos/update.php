<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\expertos\models\Expertos */

$this->title = 'Update Expertos: ' . $model->idexperto;
$this->params['breadcrumbs'][] = ['label' => 'Expertos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idexperto, 'url' => ['view', 'id' => $model->idexperto]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="expertos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
