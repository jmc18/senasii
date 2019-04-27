<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\catalogos\models\Subramas */

$this->title = 'Crear Subramas';
$this->params['breadcrumbs'][] = ['label' => 'Subramas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subramas-create">

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
