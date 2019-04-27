<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\clientes\models\ClientesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Listado de Clientes';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>

<div class="clientes-index">

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Administración de Clientes</h3>
        </div>
        <div class="panel-body">
    <?php //print_r($dataProvider); die(); ?>

    <?= 
        GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'nomcte',
            'email:email',
            'telcte1',
            //'telcte2',
            'sucursal',
            //'username',
            [
                'label' => 'Ver',
                'attribute'=>'username',
                'format' => 'html',
                'value' => function($model) {
                    $username = array();
                    foreach ($model->users as $usuario) {
                        $username[] = $usuario->username;
                    }
                    //return implode(PHP_EOL, $username);
                    //if( count($username) != 0 )
                    //        return implode(PHP_EOL, $username);
                    //    else
                    return Html::a('<span class="glyphicon glyphicon-user"></span> Usuarios',
                         ['/clientes/clientes/verusuarios','idcte'=>$model->idcte], 
                         [
                            'class'=>'btn btn-default btn-xs btn-block btn-danger',
                         ]
                    );
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=> 'Ver',
                'template' => '{verctos}',
                'buttons' => [
                    'verctos' => function($url, $model)
                    {
                        return Html::a('<span class="glyphicon glyphicon-user"></span> Contactos',
                             ['vercontactos', 'idCte' => $model->idcte], 
                             [
                                'class'=>'btn btn-default btn-xs',
                                'data' => [
                                    'method' => 'post',
                                ],
                            ]
                        );
                    }
                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=> 'Acciones',
                'template' => '{contactos}{update}{delete}',
                'buttons' => [
                    'update' => function($url, $model)
                    {
                        return Html::a('<span class="glyphicon glyphicon-edit"> </span> Editar',
                             ['update', 'id' => $model->idcte], 
                             [
                                'data-toggle'=>'tooltip',
                                'data-placement'=>'bottom',
                                'title'=>'Editar Cliente',
                                'class' => 'btn btn-primary btn-xs',
                             ]
                        );
                    },
                    'delete' => function($url, $model)
                    {
                        return Html::a('<span class="glyphicon glyphicon-trash"> </span> Borrar',
                             ['delete', 'id' => $model->idcte], 
                             [
                                'data-toggle'=>'tooltip',
                                'data-placement'=>'bottom',
                                'title'=>'Eliminar Cliente',
                                'class' => 'btn btn-danger btn-xs',
                                'data' => [
                                    'confirm' => '¿Deseas borrar el cliente?',
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
        <?= Html::a('Agregar Cliente', ['create'], ['class' => 'btn btn-success']) ?>
    </p>    
    </div>
  </div>
</div>
