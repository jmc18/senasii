<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\catalogos\models\Ramas */

$this->title = $model->idrama;
$this->params['breadcrumbs'][] = ['label' => 'Ramas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ramas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->idrama], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Borrar', ['delete', 'id' => $model->idrama], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Esta seguro que desea borrar esta rama?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idrama',
            'descrama',
        ],
    ]) ?>

</div>
