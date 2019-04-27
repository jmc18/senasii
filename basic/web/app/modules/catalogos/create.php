<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\catalogos\models\Analitos */

$this->title = 'Create Analitos';
$this->params['breadcrumbs'][] = ['label' => 'Analitos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="analitos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
