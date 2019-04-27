<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\expertos\models\Expertos */

$this->title = $model->idexperto;
$this->params['breadcrumbs'][] = ['label' => 'Expertos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expertos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idexperto], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idexperto], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idexperto',
            'nomexperto',
            'apepat',
            'apemat',
            'email:email',
            'telexperto',
            'nacionalidad',
        ],
    ]) ?>

</div>
