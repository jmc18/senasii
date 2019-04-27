<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\catalogos\models\RamasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Listar Ramas';
$this->params['breadcrumbs'][] = ['label'=>'Catálogos','url'=>['/site/about']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ramas-index">

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Administración de Ramas</h3>
        </div>
        <div class="panel-body">
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'descrama',
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=> 'Opciones',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function($url, $model)
                    {
                        return Html::a('<span class="glyphicon glyphicon-edit"></span>',
                            ['update', 'id' => $model->idrama], 
                            [ 
                                'data-toggle'=>'tooltip',
                                'data-placement'=>'bottom',
                                'title'=>'Editar Rama',
                                'class' => 'btn btn-primary btn-sm',
                            ]
                        );
                    },
                    'delete' => function($url, $model)
                    {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                             ['delete', 'id' => $model->idrama], 
                             [
                                'data-toggle'=>'tooltip',
                                'data-placement'=>'bottom',
                                'title'=>'Eliminar Rama',
                                'class' => 'btn btn-danger btn-sm',
                                'data' => [
                                    'confirm' => '¿Deseas borrar la rama?',
                                    'method' => 'post',
                                ],
                            ]
                        );
                    }
                ],
            ],
        ],
    ]); ?>
    <p>
        <?= Html::a('Crear Rama', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>
</div>
</div>
