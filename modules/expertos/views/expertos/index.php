<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\expertos\models\ExpertosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Expertos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expertos-index">

  <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Administración de Expertos</h3>
        </div>
        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idexperto',
            'nomexperto',
            'apepat',
            'apemat',
            'email:email',
            // 'telexperto',
            // 'nacionalidad',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <p>
        <?= Html::a('Crear Experto', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

</div>
</div>
</div>
