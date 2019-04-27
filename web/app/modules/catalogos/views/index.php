<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\catalogos\models\AnalitosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Analitos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="analitos-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Analitos', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idanalito',
            'descparametro',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
