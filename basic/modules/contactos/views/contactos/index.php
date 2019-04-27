<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\contactos\models\ContactosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Contactos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contactos-index">
    
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Administración de Contactos</h3>
        </div>
        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nombrecon',
            'apepatcon',
            'apematcon',
            'emailcon:email',
            'telcon',

            [
                'class' => 'yii\grid\ActionColumn',
                'header'=> 'Acciones',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function($url, $model)
                    {
                        return Html::a('<span class="glyphicon glyphicon-edit"> </span>',
                             ['update', 'id' => $model->nocontacto], 
                             [
                                'data-toggle'=>'tooltip',
                                'data-placement'=>'bottom',
                                'title'=>'Editar Contacto',
                                'class' => 'btn btn-primary btn-sm',
                             ]
                        );
                    },
                    'delete' => function($url, $model)
                    {
                        return Html::a('<span class="glyphicon glyphicon-trash"> </span>',
                             ['delete', 'id' => $model->nocontacto], 
                             [
                                'data-toggle'=>'tooltip',
                                'data-placement'=>'bottom',
                                'title'=>'Eliminar Contacto',
                                'class' => 'btn btn-danger btn-sm',
                                'data' => [
                                    'confirm' => '¿Deseas borrar el contacto?',
                                    'method' => 'post',
                                ],
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>

    <p>
        <?= Html::a('Crear Contacto', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>
</div>
</div>
