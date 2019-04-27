<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\catalogos\models\Subramas */

$this->title = $model->idsubrama;
$this->params['breadcrumbs'][] = ['label' => 'Subramas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subramas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->idsubrama], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Borrar', ['delete', 'id' => $model->idsubrama], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Estas seguro que deseas borrar la subrama?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idsubrama',
            'descsubrama',
        ],
    ]) ?>

</div>
