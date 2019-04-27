<?php

use kartik\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\expertos\models\ExpertosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>

<div class="expertos-index">

  <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Administración de Usuarios</h3>
        </div>
        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'format'=> 'html',
                'header'=> 'Estatus',
                'value' => function ($dataProvider) {

                    if($dataProvider->activate == 1)
                        return Html::bsLabel('CUENTA ACTIVA', Html::TYPE_SUCCESS);
                    else
                        return Html::bsLabel('CUENTA INACTIVA', Html::TYPE_DANGER);
                }
            ],
            [
                'format'=> 'html',
                'header'=> 'Rol',
                'value' => function ($dataProvider) {

                    if($dataProvider->role == 1)
                        return Html::bsLabel('USUARIO', Html::TYPE_SUCCESS);
                    else
                        return Html::bsLabel('ADMINISTRADOR', Html::TYPE_DANGER);
                }
            ],
            'username',
            'idcte0.nomcte',
            /*[
                'class' => 'yii\grid\ActionColumn',
                'header'=> 'Nombre del Cliente',
                'template' => '{asignar}',
                'buttons' => [
                    'asignar' => function($url, $model)
                    {
                        if( $model->idcte != null)
                            return 'idcte0.nomcte';
                        else
                            return Html::a('<span class="glyphicon glyphicon-user"></span> Asignar Cliente',
                                 ['/alertas/alertas/calibracion', 'idusr' => $model->idusr], 
                                 [
                                    'class'=>'btn btn-default btn-xs btn-block',
                                 ]
                            );
                    },
                ],
            ],*/
            'email:email',
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=> 'Acciones',
                'template' => '{update}{delete}',
                'buttons' => [
                    'update' => function($url, $model)
                    {
                        return Html::a('<span class="glyphicon glyphicon-edit"> </span> Editar',
                             ['update', 'id' => $model->idusr], 
                             [
                                'data-toggle'=>'tooltip',
                                'data-placement'=>'bottom',
                                'title'=>'Editar Usuario',
                                'class' => 'btn btn-primary btn-xs',
                                //'class'=>'btn btn-default btn-xs'
                             ]
                        );
                    },
                    'delete' => function($url, $model)
                    {
                        return Html::a('<span class="glyphicon glyphicon-trash"> </span> Borrar',
                             ['delete', 'id' => $model->idusr], 
                             [
                                'data-toggle'=>'tooltip',
                                'data-placement'=>'bottom',
                                'title'=>'Editar Usuario',
                                'class' => 'btn btn-danger btn-xs',
                                'data' => [
                                    'confirm' => '¿Deseas borrar el usuario?',
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
        <?= Html::a('Crear Usuario', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

</div>
</div>
</div>
