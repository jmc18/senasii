<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\catalogos\models\AnalitosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lista de Analitos';
$this->params['breadcrumbs'][] = ['label'=>'Catálogos','url'=>['/site/about']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="analitos-index">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Administración de Analitos</h3>
        </div>
        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'descparametro',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <p>
        <?= Html::a('Crear Analito', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
        </div>
    </div>
</div>
