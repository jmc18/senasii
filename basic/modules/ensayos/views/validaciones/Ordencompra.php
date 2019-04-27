<?php
use kartik\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\calendarios\models\CalendarioCalibracion */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Ordenes de Compra';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>

<div class="calendario-calibracion-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h1 class="panel-title">Validar Orden de Compra / Cotización</h1>
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
                                        ]) ?>
                <br>                      

                <?=
                GridView::widget([
                'dataProvider' => $dataEnsayosCalibracion,
                'columns' => [
                        [
                            'format'=> 'html',
                            'header'=> '¿Validado?',
                            'value' => function ($dataEnsayosCalibracion) {

                                if($dataEnsayosCalibracion->valida_odec != null)
                                    return Html::bsLabel('VALIDADO', Html::TYPE_SUCCESS);
                                else
                                    return Html::bsLabel('SIN VALIDAR', Html::TYPE_DANGER);
                            }
                        ],
                        [
                            'header'=> 'Area',
                            'value' => 'idcot0.idarea0.idarea0.descarea',
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
                        /*[
                            'attribute'=>'image',
                            'format'=>'raw',
                            'header'=>'Evidencia',
                            'value'=>function($model)
                            {
                                //return Yii::$app->basePath.'/assets/cpvJHDx2WkmawUjMQss_Pcwg_hCLadP_.png';
                                //return Html::bsLabel($model->idarea0->idestatus0->descestatus, Html::TYPE_PRIMARY);
                                return Html::img(Yii::$app->getUrlManager()->getBaseUrl().'/assets/cpvJHDx2WkmawUjMQss_Pcwg_hCLadP_.png', [
                                            'height'=>'30', 
                                            'width'=>'30']);
                            }
                        ],*/
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header'=> 'Ver Evidencias',
                            'template' => '{ver}',
                            'buttons' => [
                                'ver' => function($url, $model)
                                {
                                    return Html::a('<span class="glyphicon glyphicon-check"></span> Ver Archivos',
                                         ['listararchivos', 'idarea' => $model->idarea, 'idref'=>$model->idreferencia, 'idcot'=>$model->idcot, 'idetapa'=>1], 
                                         [
                                            'class'=>'btn btn-default btn-xs btn-block',
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
                                    ]) ?>
            <br>                      
            
            <?=
            GridView::widget([
                    'dataProvider' => $dataEnsayosGenerales,
                    'columns' => [
                        [
                            'format'=> 'html',
                            'header'=> '¿Validado?',
                            'value' => function ($dataEnsayosGenerales) {

                                if($dataEnsayosGenerales->valida_odec != null)
                                    return Html::bsLabel('VALIDADO', Html::TYPE_SUCCESS);
                                else
                                    return Html::bsLabel('SIN VALIDAR', Html::TYPE_DANGER);
                            }
                        ],
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
                            'class' => 'yii\grid\ActionColumn',
                            'header'=> 'Ver Evidencias',
                            'template' => '{ver}',
                            'buttons' => [
                                'ver' => function($url, $model)
                                {
                                    return Html::a('<span class="glyphicon glyphicon-check"></span> Ver Archivos',
                                         ['listararchivosgen', 'idrama' => $model->idrama,'idsubrama' => $model->idsubrama, 'idanalito'=>$model->idanalito, 'idref'=>$model->idreferencia, 'idcot'=>$model->idcot, 'idetapa'=>1], 
                                         [
                                            'class'=>'btn btn-default btn-xs btn-block',
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
    <div class="form-group">
        <?= Html::a('Cancelar y Regresar', 
            ['/site/index'],
            ['class' => 'btn btn-danger']); ?>
    </div>

    <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>