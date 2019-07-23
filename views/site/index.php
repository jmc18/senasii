<?php

/* @var $this yii\web\View */

//use yii\helpers\Html;
use kartik\helpers\Html;
use app\models\User; 
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\web\view; 

$this->title = 'SENA :: Sistema Integral de Información';
?>

<?php foreach (Yii::$app->session->getAllFlashes() as $message):; ?>
<?php
    echo \kartik\widgets\Growl::widget([
        'type' => (!empty($message['type'])) ? $message['type'] : 'danger',
        'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
        'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
        'body' => (!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
        'showSeparator' => true,
        'delay' => 1, //This delay is how long before the message shows
        'pluginOptions' => [
            'delay' => (!empty($message['duration'])) ? $message['duration'] : 3000, //This delay is how long the message shows for
            'showProgressbar' => true,
            'placement' => [
                'from' => (!empty($message['positonY'])) ? $message['positonY'] : 'top',
                'align' => (!empty($message['positonX'])) ? $message['positonX'] : 'right',
            ]
        ]
    ]);
    ?>
<?php endforeach; ?>

<div class="site-index">
 <?php $form = ActiveForm::begin(); ?>

    <?php
        if( !User::isUserAdmin(Yii::$app->user->identity->id) )
        {
    ?>       

    <div class="row">
        <div class="col-xs-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Bienvenido :: Servicios de Ensayos de Aptitud</h3>
                </div>
                <div class="panel-body">
                    <?php echo Html::img('@web/images/user.png', [
                                        'class' => 'pull-left img-responsive', 
                                        'height'=>'150px', 
                                        'width'=>'150px']); ?>
                    <div class="panel-body">                
                            <h5><b>Nombre de Cliente: </b>
                                <?php echo $model_cte->nomcte; ?>
                            </h5>
                            <h5><b>Email del Cliente: </b>
                                <?php echo $model_cte->email; ?>
                            </h5>
                            <h5><b>Sucursal: </b>
                                <?php echo $model_cte->sucursal; ?>
                            </h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Acciones</h3>
            </div>
           
            <div class="panel-body">
                <div class="row">
                    
                    <div class="col-md-4">
                        <?php
                        \yiister\gentelella\widgets\Panel::begin(
                            [
                                'header' => 'Cotizar',
                                'icon' => 'calendar',
                            ]
                        )
                        ?>
                        <?= Html::a('Calibración', ['/cotizaciones/cotizaciones/listado'], ['class'=>'btn btn-primary btn-block']) ?>
                        <?= Html::a('Otros Ensayos', ['/cotizaciones/cotizaciones/listadogeneral'], ['class'=>'btn btn-primary btn-block']) ?>
                        <?php \yiister\gentelella\widgets\Panel::end() ?>
                    </div>

                    <div class="col-md-4">
                        <?php
                        \yiister\gentelella\widgets\Panel::begin(
                            [
                                'header' => 'Ensayos Aceptados',
                                'icon' => 'calendar',
                            ]
                        )
                        ?>
                        <?= Html::a('Ver Historial', ['/ensayos/ensayos/historial'], ['class'=>'btn btn-primary btn-block']) ?>
                        <?php \yiister\gentelella\widgets\Panel::end() ?>
                    </div>

                   <!-- <div class="col-md-4">
                        ?php
                        \yiister\gentelella\widgets\Panel::begin(
                            [
                                'header' => 'Registrar Ensayo',
                                'icon' => 'calendar',
                            ]
                        )
                        ?>
                        <= Html::a('Ver Calendarios', ['/ensayos/ensayos/index'], ['class'=>'btn btn-primary btn-block']) ?>
                        <php \yiister\gentelella\widgets\Panel::end() ?>
                    </div>-->

                </div>
            </div>
        </div>
        </div>

    </div>    
    
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Ensayos de Calibracion Cotizados</h3>
        </div>
        <div class="panel-body">
            <?=
                GridView::widget([
                'dataProvider' => $dataCotCalibracion,
                'columns' => [
                        [
                            'header'=> 'Cotización',
                            'value' => 'idcot0.idcot'
                        ],
                        [
                            'header'=> 'Fecha',
                            'value' => 'idcot0.fecha'
                        ],
                        [
                            'header'=> 'Area',
                            'value' => 'idarea0.idarea0.descarea'
                        ],
                        [   
                            'header'=> 'Referencia',
                            'value' => 'idarea0.idreferencia0.descreferencia',
                        ],
                        [
                            'header'=> 'Costo',
                            'value' => 'costo'
                        ],
                        [   
                            'format'=>'html',
                            'header'=> 'Estatus',
                            'value' => function ($dataCotCalibracion) {

                                switch($dataCotCalibracion->idarea0->idestatus0->idestatus)
                                {
                                    case 1: return Html::bsLabel($dataCotCalibracion->idarea0->idestatus0->descestatus, Html::TYPE_PRIMARY);
                                    case 2: return Html::bsLabel($dataCotCalibracion->idarea0->idestatus0->descestatus, Html::TYPE_WARNING);
                                    case 3: return Html::bsLabel($dataCotCalibracion->idarea0->idestatus0->descestatus, Html::TYPE_DANGER);
                                    case 4: return Html::bsLabel($dataCotCalibracion->idarea0->idestatus0->descestatus, Html::TYPE_WARNING);
                                    case 5: return Html::bsLabel($dataCotCalibracion->idarea0->idestatus0->descestatus, Html::TYPE_SUCCESS);
                                    case 6: return Html::bsLabel($dataCotCalibracion->idarea0->idestatus0->descestatus, Html::TYPE_DANGER);
                                }
                            }
                        ],
                        /*[
                            'class'=>'kartik\grid\BooleanColumn',
                            'attribute'=>'credito', 
                            'vAlign'=>'middle',
                        ],*/
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header'=> '',
                            'template' => '{ver}',
                            'buttons' => [
                                'ver' => function($url, $model)
                                {
                                    if( $model->aceptado == null ){
                                        if( $model->idarea0->idestatus0->idestatus == 2 )
                                            $alerta = 'El ensayo ya esta en desarrollo, y al cotizarlo SENA evaluará su factibilidad...';
                                        else
                                            $alerta = 'Agregar ensayo a la cotización';

                                        return Html::a('<span class="glyphicon glyphicon-ok-circle"></span> Solicitar',
                                             ['/cotizaciones/cotizaciones/aceptar', 'idarea' => $model->idarea, 'idref'=>$model->idreferencia, 'idcot'=>$model->idcot0->idcot, 'estatus'=>$model->idarea0->idestatus0->idestatus], 
                                             [
                                                'data-toggle'=>'tooltip',
                                                'data-placement'=>'bottom',
                                                'title'=>$alerta,
                                                'class'=>'btn btn-primary btn-xs btn-block',
                                             ]
                                        );
                                    }
                                    else
                                        return Html::a('<span class="glyphicon glyphicon-remove-circle"></span> Declinar',
                                             ['/cotizaciones/cotizaciones/declinar', 'idarea' => $model->idarea, 'idref'=>$model->idreferencia, 'idcot'=>$model->idcot0->idcot], 
                                             [
                                                'data-toggle'=>'tooltip',
                                                'data-placement'=>'bottom',
                                                'title'=>'De click si ya no desea este ensayo...',
                                                'class'=>'btn btn-primary btn-xs btn-block',
                                             ]
                                        );
                                },
                            ],
                        ],
                    ],
                ]);
                ?>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Otros Ensayos Cotizados</h3>
        </div>
        <div class="panel-body">
            <?=
                GridView::widget([
                'dataProvider' => $dataCotGeneral,
                'columns' => [
                        [
                            'header'=> 'Cotización',
                            'value' => 'idcot0.idcot'
                        ],
                        [
                            'header'=> 'Fecha',
                            'value' => 'idcot0.fecha'
                        ],
                        [
                            'header'=> 'Rama',
                            'value' => 'idrama0.idrama0.descrama'
                        ],
                        [   
                            'header'=> 'Subrama',
                            'value' => 'idrama0.idsubrama0.descsubrama',
                        ],
                        [   
                            'header'=> 'Analito',
                            'value' => 'idrama0.idanalito0.descparametro',
                        ],
                        [   
                            'header'=> 'Referencia',
                            'value' => 'idrama0.idreferencia0.descreferencia',
                        ],
                        [
                            'header'=> 'Costo',
                            'value' => 'costo'
                        ],
                        [   
                            'format'=>'html',
                            'header'=> 'Estatus',
                            'value' => function ($dataCotCalibracion) {

                                switch($dataCotCalibracion->idrama0->idestatus0->idestatus)
                                {
                                    case 1: return Html::bsLabel($dataCotCalibracion->idrama0->idestatus0->descestatus, Html::TYPE_PRIMARY);
                                    case 2: return Html::bsLabel($dataCotCalibracion->idrama0->idestatus0->descestatus, Html::TYPE_WARNING);
                                    case 3: return Html::bsLabel($dataCotCalibracion->idrama0->idestatus0->descestatus, Html::TYPE_DANGER);
                                    case 4: return Html::bsLabel($dataCotCalibracion->idrama0->idestatus0->descestatus, Html::TYPE_WARNING);
                                    case 5: return Html::bsLabel($dataCotCalibracion->idrama0->idestatus0->descestatus, Html::TYPE_SUCCESS);
                                    case 6: return Html::bsLabel($dataCotCalibracion->idrama0->idestatus0->descestatus, Html::TYPE_DANGER);
                                }
                            }
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header'=> '',
                            'template' => '{ver}',
                            'buttons' => [
                                'ver' => function($url, $model)
                                {
                                    if( $model->aceptado == null ){
                                        if( $model->idrama0->idestatus0->idestatus == 2 )
                                            $alerta = 'El ensayo ya esta en desarrollo, y al cotizarlo SENA evaluará su factibilidad...';
                                        else
                                            $alerta = 'Agregar ensayo a la cotización';
                                        
                                        return Html::a('<span class="glyphicon glyphicon-ok-circle"></span> Solicitar',
                                             ['/cotizaciones/cotizaciones/aceptargen', 'idrama'=>$model->idrama, 'idsubrama'=>$model->idsubrama, 'idanalito'=>$model->idanalito, 'idref' =>$model->idreferencia, 'idcot'=>$model->idcot0->idcot,'estatus'=>$model->idrama0->idestatus0->idestatus], 
                                             [
                                                'data-toggle'=>'tooltip',
                                                'data-placement'=>'bottom',
                                                'title'=>$alerta,
                                                'class'=>'btn btn-primary btn-xs btn-block',
                                             ]
                                        );
                                    }
                                    else
                                        return Html::a('<span class="glyphicon glyphicon-remove-circle"></span> Declinar',
                                             ['/cotizaciones/cotizaciones/declinargen', 'idrama'=>$model->idrama, 'idsubrama'=>$model->idsubrama, 'idanalito'=>$model->idanalito, 'idref' =>$model->idreferencia, 'idcot'=>$model->idcot0->idcot], 
                                             [
                                                'data-toggle'=>'tooltip',
                                                'data-placement'=>'bottom',
                                                'title'=>'De click si ya no desea este ensayo...',
                                                'class'=>'btn btn-primary btn-xs btn-block',
                                             ]
                                        );
                                },
                            ],
                        ],
                    ],
                ]);
                ?>
        </div>
    </div>

    <?php
        }

        if( User::isUserAdmin(Yii::$app->user->identity->id) )
        {
    ?>

    <div class="body-content">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Estadisticas</h3>
            </div>
            
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-md-2">
                        <?=
                        \yiister\gentelella\widgets\StatsTile::widget(
                            [
                                'icon' => 'shopping-cart',
                                'header' => 'Ordenes', 
                                'text' => '',
                                'number' => $cant_odec,
                            ]
                        )
                        ?>
                        <?= Html::a('Validar Ordenes', ['/ensayos/validaciones/ordencompra'], ['class'=>'btn btn-primary btn-block']) ?>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <?=
                        \yiister\gentelella\widgets\StatsTile::widget(
                            [
                                'icon' => 'usd',
                                'header' => 'Pagados',
                                'text' => '',
                                'number' => $cant_pago,
                            ]
                        )
                        ?>
                        <?= Html::a('Validar Pagos', ['/ensayos/validaciones/pagos'], ['class'=>'btn btn-primary btn-block']) ?>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <?=
                        \yiister\gentelella\widgets\StatsTile::widget(
                            [
                                'icon' => 'check',
                                'header' => 'Aceptados',
                                'text' => '',
                               'number' => $cant_acep,
                            ]
                        )
                        ?>
                        <?= Html::a('Validar Aceptados', ['/ensayos/validaciones/aceptados'], ['class'=>'btn btn-primary btn-block']) ?>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <?=
                        \yiister\gentelella\widgets\StatsTile::widget(
                            [
                                'icon' => 'resize-small',
                                'header' => 'Recepciones',
                                'text' => '',
                                'number' => $cant_rece,
                            ]
                        )
                        ?>
                        <?= Html::a('Validar Recepciones', ['/ensayos/validaciones/recepciones'], ['class'=>'btn btn-primary btn-block']) ?>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <?=
                        \yiister\gentelella\widgets\StatsTile::widget(
                            [
                                'icon' => 'share',
                                'header' => 'Entregas',
                                'text' => '',
                                'number' => $cant_entr,
                            ]
                        )
                        ?>
                        <?= Html::a('Validar Entregas', ['/ensayos/validaciones/entregados'], ['class'=>'btn btn-primary btn-block']) ?>
                    </div>
                    <div class="col-xs-12 col-md-2">
                        <?=
                        \yiister\gentelella\widgets\StatsTile::widget(
                            [
                                'icon' => 'star',
                                'header' => 'Completados',
                                'text' => '',
                                'number' => $cant_comp,
                            ]
                        )
                        ?>
                        <?= Html::a('Validar Completados', ['/ensayos/validaciones/completados'], ['class'=>'btn btn-primary btn-block']) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-primary">
        <div class="panel-heading">
            <h1 class="panel-title">Listado de Ensayos</h1>
        </div>
        <div class="panel-body">
    
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Ensayos de Calibración</h3>
                </div>
                <div class="panel-body">

                <?= Html::dropDownList('idarea', 
                                        $idarea, 
                                        $areas,
                                        [
                                            'prompt' => 'Selecciona el area para filtrar los ensayos',
                                            'class'=>'form-control',
                                            'onchange'=>'this.form.submit()',
                                        ])?>
                <br>

                <?=
                GridView::widget([
                'dataProvider' => $dataEnsayosCalibracion,
                'columns' => [
                        [
                            'header' => 'Cotización',
                            'value' => 'idcot' 
                        ],
                        [
                            'header'=> 'Area',
                            'value' => 'idcot0.idarea0.idarea0.descarea'
                        ],
                        [   
                            'header'=> 'Referencia',
                            'value' => 'idcot0.idarea0.idreferencia0.descreferencia',
                        ],
                        'idcot0.idarea0.intervalo',
                        'idcot0.idcot0.idcte0.nomcte',
                        //'fecinicio:date',
                        [   
                            'format'=>'html',
                            'header'=> 'Estatus',
                            'value' => function ($dataEnsayosCalibracion) {

                                switch($dataEnsayosCalibracion->idcot0->idarea0->idestatus0->idestatus)
                                {
                                    case 1: return Html::bsLabel($dataEnsayosCalibracion->idcot0->idarea0->idestatus0->descestatus, Html::TYPE_PRIMARY);
                                    case 2: return Html::bsLabel($dataEnsayosCalibracion->idcot0->idarea0->idestatus0->descestatus, Html::TYPE_SUCCESS);
                                    case 3: return Html::bsLabel($dataEnsayosCalibracion->idcot0->idarea0->idestatus0->descestatus, Html::TYPE_DANGER);
                                    case 4: return Html::bsLabel($dataEnsayosCalibracion->idcot0->idarea0->idestatus0->descestatus, Html::TYPE_WARNING);
                                }
                            }
                        ],
                        [
                            'class'=>'kartik\grid\BooleanColumn',
                            'attribute'=>'credito', 
                            'vAlign'=>'middle',
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header'=> 'Alertas',
                            'template' => '{ver}',
                            'buttons' => [
                                'ver' => function($url, $model)
                                {
                                    return Html::a('<span class="glyphicon glyphicon-bell"></span> Ver',
                                         ['/alertas/alertas/calibracion', 'idarea' => $model->idarea, 'idref'=>$model->idreferencia, 'idcot'=>$model->idcot, 'idetapa'=>3], 
                                         [
                                            'class'=>'btn btn-default btn-xs btn-block',
                                         ]
                                    );
                                },
                            ],
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header'=> 'Cambiar Pago',
                            'template' => '{credito}',
                            'buttons' => [
                                'credito' => function($url, $model)
                                {
                                    switch( $model->credito){
                                        case '0':
                                        
                                        return Html::a('<span class="glyphicon glyphicon-usd"></span> Crédito',
                                             ['/ensayos/ensayos/credito', 'idarea' => $model->idarea, 'idref'=>$model->idreferencia, 'idcot'=>$model->idcot, 'credito' => '1'], 
                                             [
                                                'class'=>'btn btn-default btn-xs btn-block',
                                                'data' => [
                                                    //'confirm' => '¿Deseas borrar la alerta programa para este ensayo?',
                                                    'method' => 'post',
                                                ],
                                             ]
                                        );
                                        case '1':
                                        return Html::a('<span class="glyphicon glyphicon-usd"></span> Normal',
                                             ['/ensayos/ensayos/credito', 'idarea' => $model->idarea, 'idref'=>$model->idreferencia, 'idcot'=>$model->idcot, 'credito' => '0'], 
                                             [
                                                'class'=>'btn btn-default btn-xs btn-block',
                                                'data' => [
                                                    //'confirm' => '¿Deseas borrar la alerta programa para este ensayo?',
                                                    'method' => 'post',
                                                ],
                                             ]
                                        );
                                    }
                                },
                            ],
                        ],
                        /*[
                            'class' => 'yii\grid\ActionColumn',
                            'header'=> 'Asignar',
                            'template' => '{experto}',
                            'buttons' => [
                                'experto' => function($url, $model)
                                {
                                    
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span> Experto',
                                     ['/ensayos/ensayos/credito', 'idarea' => $model->idarea, 'idref'=>$model->idreferencia, 'idcte'=>$model->idcte, 'credito' => '0'], 
                                     [
                                        'class'=>'btn btn-default btn-xs btn-block',
                                        'data' => [
                                            //'confirm' => '¿Deseas borrar la alerta programa para este ensayo?',
                                            'method' => 'post',
                                        ],
                                     ]);
                                },
                            ],
                        ],*/
                    ],
                ]);
                ?>

                </div>
            </div>

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Otros Ensayos</h3>
                </div>
                <div class="panel-body">

                <?= Html::dropDownList('idrama', 
                                        $idrama, 
                                        $ramas,
                                        [
                                            'prompt' => 'Selecciona el area para filtrar los ensayos',
                                            'class'=>'form-control',
                                            'onchange'=>'this.form.submit()',
                                        ])?>
                <br>

                <?=
                GridView::widget([
                        'dataProvider' => $dataEnsayosGenerales,
                        'columns' => [
                        [
                            'header' => 'Rama',
                             'value' => 'idcot0.idrama0.idrama0.descrama',
                        ],
                        [
                            'header' => 'Subrama',
                            'value' => 'idcot0.idrama0.idsubrama0.descsubrama',
                        ],
                        [
                            'header' => 'Analito',
                            'value' => 'idcot0.idrama0.idanalito0.descparametro',
                        ],
                        [
                            'header' => 'Referencia',
                            'value' => 'idcot0.idrama0.idreferencia0.descreferencia',
                        ],
                        'idcot0.idrama0.intervalo',
                        'idcot0.idcot0.idcte0.nomcte',
                        [
                            'format'=>'html',
                            'header'=> 'Estatus',
                            'value' => function ($dataEnsayosGenerales) {

                                switch($dataEnsayosGenerales->idcot0->idrama0->idestatus0->idestatus)
                                {
                                    case 1: return Html::bsLabel($dataEnsayosGenerales->idcot0->idrama0->idestatus0->descestatus, Html::TYPE_PRIMARY);
                                    case 2: return Html::bsLabel($dataEnsayosGenerales->idcot0->idrama0->idestatus0->descestatus, Html::TYPE_SUCCESS);
                                    case 3: return Html::bsLabel($dataEnsayosGenerales->idcot0->idrama0->idestatus0->descestatus, Html::TYPE_DANGER);
                                    case 4: return Html::bsLabel($dataEnsayosGenerales->idcot0->idrama0->idestatus0->descestatus, Html::TYPE_WARNING);
                                }
                            }
                        ],
                        [
                            'class'=>'kartik\grid\BooleanColumn',
                            'attribute'=>'credito', 
                            'vAlign'=>'middle',
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header'=> 'Alertas',
                            'template' => '{ver}',
                            'buttons' => [
                                'ver' => function($url, $model)
                                {
                                    return Html::a('<span class="glyphicon glyphicon-bell"></span> Ver',
                                         ['/alertas/alertas/general', 'idrama' => $model->idrama,'idsubrama' => $model->idsubrama, 'idanalito'=>$model->idanalito, 'idref'=>$model->idreferencia, 'idcot'=>$model->idcot, 'idetapa'=>3], 
                                         [
                                            'class'=>'btn btn-default btn-xs btn-block',
                                            'data' => [
                                                //'confirm' => '¿Deseas borrar la alerta programa para este ensayo?',
                                                'method' => 'post',
                                            ],
                                         ]
                                    );
                                },
                            ],
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header'=> 'Cambiar Pago',
                            'template' => '{credito}',
                            'buttons' => [
                                'credito' => function($url, $model)
                                {
                                    switch( $model->credito){
                                        case '0':
                                        
                                        return Html::a('<span class="glyphicon glyphicon-usd"></span> Crédito',
                                             ['/ensayos/ensayos/creditogen', 'idrama' => $model->idrama, 'idsubrama' => $model->idsubrama, 'idanalito' => $model->idanalito, 'idref'=>$model->idreferencia, 'idcot'=>$model->idcot, 'credito'=>'1'], 
                                             [
                                                'class'=>'btn btn-default btn-xs btn-block',
                                                'data' => [
                                                    //'confirm' => '¿Deseas borrar la alerta programa para este ensayo?',
                                                    'method' => 'post',
                                                ],
                                             ]
                                        );
                                        case '1':
                                        return Html::a('<span class="glyphicon glyphicon-usd"></span> Normal',
                                             ['/ensayos/ensayos/creditogen', 'idrama' => $model->idrama, 'idsubrama' => $model->idsubrama, 'idanalito' => $model->idanalito, 'idref'=>$model->idreferencia, 'idcot'=>$model->idcot, 'credito'=>'0'], 
                                             [
                                                'class'=>'btn btn-default btn-xs btn-block',
                                                'data' => [
                                                    //'confirm' => '¿Deseas borrar la alerta programa para este ensayo?',
                                                    'method' => 'post',
                                                ],
                                             ]
                                        );
                                    }
                                },
                            ],
                        ],
                        /*[
                            'class' => 'yii\grid\ActionColumn',
                            'header'=> 'Asignar',
                            'template' => '{experto}',
                            'buttons' => [
                                'experto' => function($url, $model)
                                {
                                    
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span> Experto',
                                     ['/ensayos/ensayos/credito', 'idrama' => $model->idrama, 'idsubrama'=>$model->idsubrama, 'idanalito'=>$model->idanalito, 'idref'=>$model->idreferencia, 'idcte'=>$model->idcte], 
                                     [
                                        'class'=>'btn btn-default btn-xs btn-block',
                                        'data' => [
                                            //'confirm' => '¿Deseas borrar la alerta programa para este ensayo?',
                                            'method' => 'post',
                                        ],
                                     ]);
                                },
                            ],
                        ],*/
                    ],
                ]);
               ?>
                </div>
            </div>

 
        <?php
            }

        ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>
<?php
$script = "setTimeout(function(){
   window.location.reload(1);
}, 20000);";
 
$this->registerJs($script, View::POS_END, 'my-options');
?>