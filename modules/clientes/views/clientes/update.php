<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\clientes\models\Clientes */

$this->title = 'Update Clientes: ' . $model->idcte;
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idcte, 'url' => ['view', 'id' => $model->idcte]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="clientes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
