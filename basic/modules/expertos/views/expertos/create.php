<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\expertos\models\Expertos */

$this->title = 'Create Expertos';
$this->params['breadcrumbs'][] = ['label' => 'Expertos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expertos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
