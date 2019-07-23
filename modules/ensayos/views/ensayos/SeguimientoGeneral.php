<?php

use kartik\helpers\Html;
use kartik\widgets\FileInput;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\calendarios\models\CalendarioCalibracion */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Seguimiento del Ensayo';
$this->params['breadcrumbs'][] = ['label' => 'Historial de Ensayos', 'url' => ['ensayos/historial']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>

<div class="calendario-calibracion-form">

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Seguimiento de ensayo generales</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Datos del Ensayo</h3>
                        </div>
                        <div class="panel-body">	    		
                            <h5><b>Rama: </b>
                                <?php echo $model_calendario->idrama0->descrama; ?>
                            </h5>
                            <h5><b>Subrama: </b>
                                <?php echo $model_calendario->idsubrama0->descsubrama; ?>
                            </h5>
                            <h5><b>Analito: </b>
                                <?php echo $model_calendario->idanalito0->descparametro; ?>
                            </h5>
                            <h5><b>Referencia: </b>
                                <?php echo $model_calendario->idreferencia0->descreferencia; ?>
                            </h5>
                            <h5><b>Intervalo: </b>
                                <?php echo $model_calendario->intervalo; ?>
                            </h5>

                        </div>
                    </div><!-- panel-body -->
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Estatus del Ensayo</h3>
                        </div>
                        <div class="panel-body">

                            <?php
                            if ($model->valida_odec == null) {
                                $form = ActiveForm::begin([
                                            'action' => ['ensayos/subirevidenciagen', 'idetapa' => 1],
                                            'options' => ['enctype' => 'multipart/form-data']
                                ]);

                                if ($model->termina_odec == null) {
                                    echo \yiister\gentelella\widgets\Timeline::widget(
                                            [
                                                'items' => [
                                                    [
                                                        'title' => 'Estatus 1: Orden de Compra / Cotización',
                                                        'byline' => '<span>Para continuar con el proceso de ensayo deberas subir la orden de compra o cotización, la cual será validada por SENA en breve</a>',
                                                        'content' => '<h4>LINEAMIENTOS DEL ENSAYO</h4>'
                                                        /* .Html::a('GENERALIDADES', 
                                                          ['vergeneralidadesgen', 'idrama' => $model->idrama, 'idsubrama' => $model->idsubrama, 'idanalito'=>$model->idanalito, 'idref' => $model->idreferencia],
                                                          ['class'=>'btn btn-success btn-block','target' => '_blank']) */
                                                        . GridView::widget([
                                                            'dataProvider' => $dataLinea,
                                                            'columns' => [
                                                                [
                                                                    'header' => 'Archivo',
                                                                    'value' => 'file_linea'
                                                                ],
                                                                [
                                                                    'class' => 'yii\grid\ActionColumn',
                                                                    'header' => 'Acción',
                                                                    'template' => '{download}',
                                                                    'buttons' => [
                                                                        'download' => function($url, $model) use ($cotGeneral) {
                                                                            date_default_timezone_set('America/Monterrey');
                                                                            $hoy = date('Y-m-d');
                                                                            $fecini = $model->fecinilinea;
                                                                            $fecfin = $model->fecfinlinea;
                                                                            if (( $hoy >= $fecini && $hoy <= $fecfin ) && $cotGeneral->descargar)
                                                                                return Html::a('<span class="glyphicon glyphicon-download-alt"> Descargar</span>', ['verlineamientosgen', 'idLinea' => $model->idlineamiento], [
                                                                                            'data-toggle' => 'tooltip',
                                                                                            'data-placement' => 'bottom',
                                                                                            'title' => 'Descargar Lineamiento',
                                                                                            'class' => 'btn btn-primary btn-sm',
                                                                                            'data' => [
                                                                                                'method' => 'post',
                                                                                            ],
                                                                                                ]
                                                                                );
                                                                            else
                                                                                return '<h5>' . Html::bsLabel("No disponible", Html::TYPE_DANGER) . '</h5>';
                                                                        },
                                                                    ],
                                                                ],
                                                            ],
                                                        ])
                                                        . $form->field($model_evidencia, 'image')->widget(FileInput::classname(), [
                                                            'options' => ['accept' => ['image/*', 'applicaction/pdf']],
                                                            'pluginOptions' => ['allowedFileExtensions' => ['jpg', 'gif', 'png', 'pdf']]])
                                                        . Html::submitButton(
                                                                $model_evidencia->isNewRecord ? 'Subir Orden de Compra' : 'Subir Orden de Compra', ['class' => $model_evidencia->isNewRecord ? 'btn btn-primary' : 'btn btn-primary'])
                                                        . Html::a('Terminar Captura de Evidencia', ['ensayos/terminaretapagen',
                                                            'idrama' => $model->idrama,
                                                            'idsubrama' => $model->idsubrama,
                                                            'idanalito' => $model->idanalito,
                                                            'idref' => $model->idreferencia,
                                                            'idcot' => $model->idcot,
                                                            'idetapa' => 1], ['class' => 'btn btn-primary',
                                                            'data' => [
                                                                'confirm' => "¿Deseas terminar la captura de evidencias en esta etapa?",
                                                                'method' => 'post',
                                                            ],
                                                        ])
                                                        . GridView::widget([
                                                            'dataProvider' => $dataOdeC,
                                                            'columns' => [
                                                                [
                                                                    'header' => 'Archivo',
                                                                    'value' => 'file'
                                                                ],
                                                                [
                                                                    'header' => 'Fecha Captura',
                                                                    'value' => 'fecha'
                                                                ],
                                                                [
                                                                    'header' => 'Fecha Validación',
                                                                    'value' => 'validado'
                                                                ],
                                                            ],
                                                        ]),
                                                    ],
                                                ]
                                    ]);
                                }
                                else {
                                    echo \yiister\gentelella\widgets\Timeline::widget(
                                            [
                                                'items' => [
                                                    [
                                                        'title' => 'Estatus 1: Orden de Compra / Cotización',
                                                        'byline' => '<span>El archivo esta en proceso de validación y en breve deberá estaras recibiendo un correo con el resultado de dicha validación</a>',
                                                        'content' => GridView::widget([
                                                            'dataProvider' => $dataOdeC,
                                                            'columns' => [
                                                                [
                                                                    'header' => 'Archivo',
                                                                    'value' => 'file'
                                                                ],
                                                                [
                                                                    'header' => 'Fecha Captura',
                                                                    'value' => 'fecha'
                                                                ],
                                                                [
                                                                    'header' => 'Fecha Validación',
                                                                    'value' => 'validado'
                                                                ],
                                                            ],
                                                        ]),
                                                    ],
                                                ]
                                    ]);
                                }
                            } else {
                                if ($model->valida_pago == null && $model->credito == '0') {
                                    $form = ActiveForm::begin([
                                                'action' => ['ensayos/subirevidenciagen', 'idetapa' => 2],
                                                'options' => ['enctype' => 'multipart/form-data']
                                    ]);

                                    if ($model->termina_pago === null) {
                                        echo \yiister\gentelella\widgets\Timeline::widget(
                                                [
                                                    'items' => [
                                                        [
                                                            'title' => 'Estatus 1: Orden de Compra / Cotización',
                                                            'byline' => '<span>La orden de compra fue verificada y aceptada</a>',
                                                            'content' => GridView::widget([
                                                                'dataProvider' => $dataOdeC,
                                                                'columns' => [
                                                                    [
                                                                        'header' => 'Archivo',
                                                                        'value' => 'file'
                                                                    ],
                                                                    [
                                                                        'header' => 'Fecha Captura',
                                                                        'value' => 'fecha'
                                                                    ],
                                                                    [
                                                                        'header' => 'Fecha Validación',
                                                                        'value' => 'validado'
                                                                    ],
                                                                ],
                                                            ]),
                                                        ],
                                                        [
                                                            'title' => 'Estatus 2: Subir Comprobante de Pago',
                                                            'byline' => '<span>Envia tu comprobante de pago para que puedas seguir con el siguiente paso, una vez validado dicho pago (Este proceso puede tardar un tiempo considerado).</a>',
                                                            'content' => $form->field($model_evidencia, 'image')->widget(FileInput::classname(), [
                                                                'options' => ['accept' => ['image/*', 'applicaction/pdf']],
                                                                'pluginOptions' => ['allowedFileExtensions' => ['jpg', 'gif', 'png', 'pdf']],
                                                            ]) . Html::submitButton($model_evidencia->isNewRecord ? 'Subir Comprobante de Pago' : 'Subir Comprobante de Pago', ['class' => $model_evidencia->isNewRecord ? 'btn btn-primary' : 'btn btn-primary'])
                                                            . Html::a('Terminar Captura de Evidencia', ['ensayos/terminaretapagen',
                                                                'idrama' => $model->idrama,
                                                                'idsubrama' => $model->idsubrama,
                                                                'idanalito' => $model->idanalito,
                                                                'idref' => $model->idreferencia,
                                                                'idcot' => $model->idcot,
                                                                'idetapa' => 2], ['class' => 'btn btn-primary',
                                                                'data' => [
                                                                    'confirm' => "¿Deseas terminar la captura de evidencias en esta etapa?",
                                                                    'method' => 'post',
                                                                ],
                                                            ])
                                                            . GridView::widget([
                                                                'dataProvider' => $dataPago,
                                                                'columns' => [
                                                                    [
                                                                        'header' => 'Archivo',
                                                                        'value' => 'file'
                                                                    ],
                                                                    [
                                                                        'header' => 'Fecha Captura',
                                                                        'value' => 'fecha'
                                                                    ],
                                                                    [
                                                                        'header' => 'Fecha Validación',
                                                                        'value' => 'validado'
                                                                    ],
                                                                ],
                                                            ]),
                                                        ],
                                                    ]
                                        ]);
                                    } else {
                                        echo \yiister\gentelella\widgets\Timeline::widget(
                                                [
                                                    'items' => [
                                                        [
                                                            'title' => 'Estatus 1: Orden de Compra / Cotización',
                                                            'byline' => '<span>La orden de compra fue verificada y aceptada</a>',
                                                            'content' => GridView::widget([
                                                                'dataProvider' => $dataOdeC,
                                                                'columns' => [
                                                                    [
                                                                        'header' => 'Archivo',
                                                                        'value' => 'file'
                                                                    ],
                                                                    [
                                                                        'header' => 'Fecha Captura',
                                                                        'value' => 'fecha'
                                                                    ],
                                                                    [
                                                                        'header' => 'Fecha Validación',
                                                                        'value' => 'validado'
                                                                    ],
                                                                ],
                                                            ]),
                                                        ],
                                                        [
                                                            'title' => 'Estatus 2: Subir Comprobante de Pago',
                                                            'byline' => '<span>El archivo esta en proceso de validación y en breve deberá estar recibiendo un correo con el resultado de dicha validación</a>',
                                                            'content' => GridView::widget([
                                                                'dataProvider' => $dataPago,
                                                                'columns' => [
                                                                    [
                                                                        'header' => 'Archivo',
                                                                        'value' => 'file'
                                                                    ],
                                                                    [
                                                                        'header' => 'Fecha Captura',
                                                                        'value' => 'fecha'
                                                                    ],
                                                                    [
                                                                        'header' => 'Fecha Validación',
                                                                        'value' => 'validado'
                                                                    ],
                                                                ],
                                                            ]),
                                                        ],
                                                    ]
                                        ]);
                                    }
                                } else {
                                    if ($model->valida_aceptacion == null) {
                                        $credito = ( $model->credito == '1' ) ? '<h4>' . Html::bsLabel("Este ensayo se ha etiquetado como PENDIENTE DE PAGO", Html::TYPE_DANGER) . '</h4>' : "";

                                        $form = ActiveForm::begin([
                                                    'action' => ['ensayos/subirevidenciagen', 'idetapa' => 3],
                                                    'options' => ['enctype' => 'multipart/form-data']
                                        ]);

                                        if ($model->termina_aceptacion == null) {
                                            echo \yiister\gentelella\widgets\Timeline::widget(
                                                    [
                                                        'items' => [
                                                            [
                                                                'title' => 'Estatus 1: Orden de Compra / Cotización',
                                                                'byline' => '<span>La orden de compra fue verificada y aceptada</a>',
                                                                'content' => GridView::widget([
                                                                    'dataProvider' => $dataOdeC,
                                                                    'columns' => [
                                                                        [
                                                                            'header' => 'Archivo',
                                                                            'value' => 'file'
                                                                        ],
                                                                        [
                                                                            'header' => 'Fecha Captura',
                                                                            'value' => 'fecha'
                                                                        ],
                                                                        [
                                                                            'header' => 'Fecha Validación',
                                                                            'value' => 'validado'
                                                                        ],
                                                                    ],
                                                                ]),
                                                            ],
                                                            [
                                                                'title' => 'Estatus 2: Comprobante de Pago',
                                                                'byline' => '<span>El comprobante de pago fue verificado y aceptado</a>',
                                                                'content' => $credito .
                                                                GridView::widget([
                                                                    'dataProvider' => $dataPago,
                                                                    'columns' => [
                                                                        [
                                                                            'header' => 'Archivo',
                                                                            'value' => 'file'
                                                                        ],
                                                                        [
                                                                            'header' => 'Fecha Captura',
                                                                            'value' => 'fecha'
                                                                        ],
                                                                        [
                                                                            'header' => 'Fecha Validación',
                                                                            'value' => 'validado'
                                                                        ],
                                                                    ],
                                                                ]),
                                                            ],
                                                            [
                                                                'title' => 'Estatus 3: Descargar Protocolos / Subir Carta de Aceptación',
                                                                'byline' => '<span>En este paso deberas descargar los protocolos a seguir para realizar el ensayo y subir el formato de aceptación de dichos protocolos</a>',
                                                                'content' => '<h4>DESCARGAS</h4>'
                                                                . Html::a('PROTOCOLOS DEL ENSAYO SELECCIONADO', ['/attributes/index', 'id' => 1], ['class' => 'btn btn-success btn-block'])
                                                                . Html::a('CARTA DE ACEPTACIÓN', ['vercarta'], ['class' => 'btn btn-success btn-block'])
                                                                . '<br>' . $form->field($model_evidencia, 'image')->widget(FileInput::classname(), [
                                                                    'options' => ['accept' => ['image/*', 'applicaction/pdf']],
                                                                    'pluginOptions' => ['allowedFileExtensions' => ['jpg', 'gif', 'png', 'pdf']],
                                                                ]) . Html::submitButton($model_evidencia->isNewRecord ? 'Subir Carta de Aceptación' : 'Subir Carta de Aceptación', ['class' => $model_evidencia->isNewRecord ? 'btn btn-primary' : 'btn btn-primary'])
                                                                . Html::a('Terminar Captura de Evidencia', ['ensayos/terminaretapagen',
                                                                    'idrama' => $model->idrama,
                                                                    'idsubrama' => $model->idsubrama,
                                                                    'idanalito' => $model->idanalito,
                                                                    'idref' => $model->idreferencia,
                                                                    'idcot' => $model->idcot,
                                                                    'idetapa' => 3], ['class' => 'btn btn-primary',
                                                                    'data' => [
                                                                        'confirm' => "¿Deseas terminar la captura de evidencias en esta etapa?",
                                                                        'method' => 'post',
                                                                    ],
                                                                ])
                                                                . GridView::widget([
                                                                    'dataProvider' => $dataAceptacion,
                                                                    'columns' => [
                                                                        [
                                                                            'header' => 'Archivo',
                                                                            'value' => 'file'
                                                                        ],
                                                                        [
                                                                            'header' => 'Fecha Captura',
                                                                            'value' => 'fecha'
                                                                        ],
                                                                        [
                                                                            'header' => 'Fecha Validación',
                                                                            'value' => 'validado'
                                                                        ],
                                                                    ],
                                                                ]),
                                                            ],
                                                        ]
                                                    ]
                                            );
                                        } else {
                                            echo \yiister\gentelella\widgets\Timeline::widget(
                                                    [
                                                        'items' => [
                                                            [
                                                                'title' => 'Estatus 1: Orden de Compra / Cotización',
                                                                'byline' => '<span>La orden de compra fue verificada y aceptada</a>',
                                                                'content' => GridView::widget([
                                                                    'dataProvider' => $dataOdeC,
                                                                    'columns' => [
                                                                        [
                                                                            'header' => 'Archivo',
                                                                            'value' => 'file'
                                                                        ],
                                                                        [
                                                                            'header' => 'Fecha Captura',
                                                                            'value' => 'fecha'
                                                                        ],
                                                                        [
                                                                            'header' => 'Fecha Validación',
                                                                            'value' => 'validado'
                                                                        ],
                                                                    ],
                                                                ]),
                                                            ],
                                                            [
                                                                'title' => 'Estatus 2: Comprobante de Pago',
                                                                'byline' => '<span>El comprobante de pago fue verificada y aceptada</a>',
                                                                'content' => GridView::widget([
                                                                    'dataProvider' => $dataPago,
                                                                    'columns' => [
                                                                        [
                                                                            'header' => 'Archivo',
                                                                            'value' => 'file'
                                                                        ],
                                                                        [
                                                                            'header' => 'Fecha Captura',
                                                                            'value' => 'fecha'
                                                                        ],
                                                                        [
                                                                            'header' => 'Fecha Validación',
                                                                            'value' => 'validado'
                                                                        ],
                                                                    ],
                                                                ]),
                                                            ],
                                                            [
                                                                'title' => 'Estatus 3: Descargar Protocolos / Subir Carta de Aceptación',
                                                                'byline' => '<span>El archivo esta en proceso de validación y en breve deberá estar recibiendo un correo con el resultado de dicha validación</a>',
                                                                'content' => GridView::widget([
                                                                    'dataProvider' => $dataAceptacion,
                                                                    'columns' => [
                                                                        [
                                                                            'header' => 'Archivo',
                                                                            'value' => 'file'
                                                                        ],
                                                                        [
                                                                            'header' => 'Fecha Captura',
                                                                            'value' => 'fecha'
                                                                        ],
                                                                        [
                                                                            'header' => 'Fecha Validación',
                                                                            'value' => 'validado'
                                                                        ],
                                                                    ],
                                                                ]),
                                                            ],
                                                        ]
                                                    ]
                                            );
                                        }
                                    } else {
                                        if ($model->valida_recepcion == null) {
                                            $form = ActiveForm::begin([
                                                        'action' => ['ensayos/subirevidenciagen', 'idetapa' => 5],
                                                        'options' => ['enctype' => 'multipart/form-data']
                                            ]);

                                            if ($model->termina_recepcion == null) {
                                                echo \yiister\gentelella\widgets\Timeline::widget(
                                                        [
                                                            'items' => [
                                                                [
                                                                    'title' => 'Estatus 1: Orden de Compra / Cotización',
                                                                    'byline' => '<span>La orden de compra fue verificada y aceptada</a>',
                                                                    'content' => GridView::widget([
                                                                        'dataProvider' => $dataOdeC,
                                                                        'columns' => [
                                                                            [
                                                                                'header' => 'Archivo',
                                                                                'value' => 'file'
                                                                            ],
                                                                            [
                                                                                'header' => 'Fecha Captura',
                                                                                'value' => 'fecha'
                                                                            ],
                                                                            [
                                                                                'header' => 'Fecha Validación',
                                                                                'value' => 'validado'
                                                                            ],
                                                                        ],
                                                                    ]),
                                                                ],
                                                                [
                                                                    'title' => 'Estatus 2: Comprobante de Pago',
                                                                    'byline' => '<span>El comprobante de pago fue verificada y aceptada</a>',
                                                                    'content' => GridView::widget([
                                                                        'dataProvider' => $dataPago,
                                                                        'columns' => [
                                                                            [
                                                                                'header' => 'Archivo',
                                                                                'value' => 'file'
                                                                            ],
                                                                            [
                                                                                'header' => 'Fecha Captura',
                                                                                'value' => 'fecha'
                                                                            ],
                                                                            [
                                                                                'header' => 'Fecha Validación',
                                                                                'value' => 'validado'
                                                                            ],
                                                                        ],
                                                                    ]),
                                                                ],
                                                                [
                                                                    'title' => 'Estatus 3: Carta de Aceptación de Lineamientos',
                                                                    'byline' => '<span>La carta de aceptación fue verificada y aceptada</a>',
                                                                    'content' => GridView::widget([
                                                                        'dataProvider' => $dataAceptacion,
                                                                        'columns' => [
                                                                            [
                                                                                'header' => 'Archivo',
                                                                                'value' => 'file'
                                                                            ],
                                                                            [
                                                                                'header' => 'Fecha Captura',
                                                                                'value' => 'fecha'
                                                                            ],
                                                                            [
                                                                                'header' => 'Fecha Validación',
                                                                                'value' => 'validado'
                                                                            ],
                                                                        ],
                                                                    ]),
                                                                ],
                                                                [
                                                                    'title' => 'Estatus 4: Codigo de Identificación del Ensayo',
                                                                    'byline' => '<span>El siguiente código te permitirá identificar tu ensayo durante el proceso </a>',
                                                                    'content' => '<h3>CÓDIGO: ' . $model->codigo . '</h3>',
                                                                ],
                                                                [
                                                                    'title' => 'Estatus 5: Evidencia de Recepción del Elemento de Ensayo',
                                                                    'byline' => '<span>En este paso deberás subir la evidencia de la recepción del elemento de ensayo</a>',
                                                                    'content' => $form->field($model_evidencia, 'image')->widget(FileInput::classname(), [
                                                                        'options' => ['accept' => ['image/*', 'applicaction/pdf']],
                                                                        'pluginOptions' => ['allowedFileExtensions' => ['jpg', 'gif', 'png', 'pdf']],
                                                                    ]) . Html::submitButton($model_evidencia->isNewRecord ? 'Subir Evidencia Recepción' : 'Subir Evidencia Recepción', ['class' => $model_evidencia->isNewRecord ? 'btn btn-primary' : 'btn btn-primary'])
                                                                    . Html::a('Terminar Captura de Evidencia', ['ensayos/terminaretapagen',
                                                                        'idrama' => $model->idrama,
                                                                        'idsubrama' => $model->idsubrama,
                                                                        'idanalito' => $model->idanalito,
                                                                        'idref' => $model->idreferencia,
                                                                        'idcot' => $model->idcot,
                                                                        'idetapa' => 5], ['class' => 'btn btn-primary',
                                                                        'data' => [
                                                                            'confirm' => "¿Deseas terminar la captura de evidencias en esta etapa?",
                                                                            'method' => 'post',
                                                                        ],
                                                                    ])
                                                                    . GridView::widget([
                                                                        'dataProvider' => $dataRecepcion,
                                                                        'columns' => [
                                                                            [
                                                                                'header' => 'Archivo',
                                                                                'value' => 'file'
                                                                            ],
                                                                            [
                                                                                'header' => 'Fecha Captura',
                                                                                'value' => 'fecha'
                                                                            ],
                                                                            [
                                                                                'header' => 'Fecha Validación',
                                                                                'value' => 'validado'
                                                                            ],
                                                                        ],
                                                                    ]),
                                                                ],
                                                            ]
                                                        ]
                                                );
                                            } else {
                                                echo \yiister\gentelella\widgets\Timeline::widget(
                                                        [
                                                            'items' => [
                                                                [
                                                                    'title' => 'Estatus 1: Orden de Compra / Cotización',
                                                                    'byline' => '<span>La orden de compra fue verificada y aceptada</a>',
                                                                    'content' => GridView::widget([
                                                                        'dataProvider' => $dataOdeC,
                                                                        'columns' => [
                                                                            [
                                                                                'header' => 'Archivo',
                                                                                'value' => 'file'
                                                                            ],
                                                                            [
                                                                                'header' => 'Fecha Captura',
                                                                                'value' => 'fecha'
                                                                            ],
                                                                            [
                                                                                'header' => 'Fecha Validación',
                                                                                'value' => 'validado'
                                                                            ],
                                                                        ],
                                                                    ]),
                                                                ],
                                                                [
                                                                    'title' => 'Estatus 2: Comprobante de Pago',
                                                                    'byline' => '<span>El comprobante de pago fue verificada y aceptada</a>',
                                                                    'content' => GridView::widget([
                                                                        'dataProvider' => $dataPago,
                                                                        'columns' => [
                                                                            [
                                                                                'header' => 'Archivo',
                                                                                'value' => 'file'
                                                                            ],
                                                                            [
                                                                                'header' => 'Fecha Captura',
                                                                                'value' => 'fecha'
                                                                            ],
                                                                            [
                                                                                'header' => 'Fecha Validación',
                                                                                'value' => 'validado'
                                                                            ],
                                                                        ],
                                                                    ]),
                                                                ],
                                                                [
                                                                    'title' => 'Estatus 3: Carta de Aceptación de Lineamientos',
                                                                    'byline' => '<span>La carta de aceptación fue verificada y aceptada</a>',
                                                                    'content' => GridView::widget([
                                                                        'dataProvider' => $dataAceptacion,
                                                                        'columns' => [
                                                                            [
                                                                                'header' => 'Archivo',
                                                                                'value' => 'file'
                                                                            ],
                                                                            [
                                                                                'header' => 'Fecha Captura',
                                                                                'value' => 'fecha'
                                                                            ],
                                                                            [
                                                                                'header' => 'Fecha Validación',
                                                                                'value' => 'validado'
                                                                            ],
                                                                        ],
                                                                    ]),
                                                                ],
                                                                [
                                                                    'title' => 'Estatus 4: Codigo de Identificación del Ensayo',
                                                                    'byline' => '<span>El siguiente código te permitirá identificar tu ensayo durante el proceso </a>',
                                                                    'content' => '<h3>CÓDIGO: ' . $model->codigo . '</h3>',
                                                                ],
                                                                [
                                                                    'title' => 'Estatus 5: Evidencia de Recepción del Elemento de Ensayo',
                                                                    'byline' => '<span>El archivo esta en proceso de validación y en breve deberá estar recibiendo un correo con el resultado de dicha validación</a>',
                                                                    'content' => GridView::widget([
                                                                        'dataProvider' => $dataRecepcion,
                                                                        'columns' => [
                                                                            [
                                                                                'header' => 'Archivo',
                                                                                'value' => 'file'
                                                                            ],
                                                                            [
                                                                                'header' => 'Fecha Captura',
                                                                                'value' => 'fecha'
                                                                            ],
                                                                            [
                                                                                'header' => 'Fecha Validación',
                                                                                'value' => 'validado'
                                                                            ],
                                                                        ],
                                                                    ]),
                                                                ],
                                                            ]
                                                        ]
                                                );
                                            }
                                        } else {
                                            if ($model->valida_entrega == null) {
                                                $form = ActiveForm::begin([
                                                            'action' => ['ensayos/subirevidenciagen', 'idetapa' => 6],
                                                            'options' => ['enctype' => 'multipart/form-data']
                                                ]);

                                                if ($model->termina_entrega == null) {
                                                    echo \yiister\gentelella\widgets\Timeline::widget(
                                                            [
                                                                'items' => [
                                                                    [
                                                                        'title' => 'Estatus 1: Orden de Compra / Cotización',
                                                                        'byline' => '<span>La orden de compra fue verificada y aceptada</a>',
                                                                        'content' => GridView::widget([
                                                                            'dataProvider' => $dataOdeC,
                                                                            'columns' => [
                                                                                [
                                                                                    'header' => 'Archivo',
                                                                                    'value' => 'file'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Fecha Captura',
                                                                                    'value' => 'fecha'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Fecha Validación',
                                                                                    'value' => 'validado'
                                                                                ],
                                                                            ],
                                                                        ]),
                                                                    ],
                                                                    [
                                                                        'title' => 'Estatus 2: Comprobante de Pago',
                                                                        'byline' => '<span>El comprobante de pago fue verificada y aceptada</a>',
                                                                        'content' => GridView::widget([
                                                                            'dataProvider' => $dataPago,
                                                                            'columns' => [
                                                                                [
                                                                                    'header' => 'Archivo',
                                                                                    'value' => 'file'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Fecha Captura',
                                                                                    'value' => 'fecha'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Fecha Validación',
                                                                                    'value' => 'validado'
                                                                                ],
                                                                            ],
                                                                        ]),
                                                                    ],
                                                                    [
                                                                        'title' => 'Estatus 3: Carta de Aceptación de Lineamientos',
                                                                        'byline' => '<span>La carta de aceptación fue verificada y aceptada</a>',
                                                                        'content' => GridView::widget([
                                                                            'dataProvider' => $dataAceptacion,
                                                                            'columns' => [
                                                                                [
                                                                                    'header' => 'Archivo',
                                                                                    'value' => 'file'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Fecha Captura',
                                                                                    'value' => 'fecha'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Fecha Validación',
                                                                                    'value' => 'validado'
                                                                                ],
                                                                            ],
                                                                        ]),
                                                                    ],
                                                                    [
                                                                        'title' => 'Estatus 4: Codigo de Identificación del Ensayo',
                                                                        'byline' => '<span>El siguiente código te permitirá identificar tu ensayo durante el proceso </a>',
                                                                        'content' => '<h3>CÓDIGO: ' . $model->codigo . '</h3>',
                                                                    ],
                                                                    [
                                                                        'title' => 'Estatus 5: Evidencias de Recepción de Elemento de Ensayo',
                                                                        'byline' => '<span>La carta de aceptación fue verificada y aceptada</a>',
                                                                        'content' => GridView::widget([
                                                                            'dataProvider' => $dataRecepcion,
                                                                            'columns' => [
                                                                                [
                                                                                    'header' => 'Archivo',
                                                                                    'value' => 'file'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Fecha Captura',
                                                                                    'value' => 'fecha'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Fecha Validación',
                                                                                    'value' => 'validado'
                                                                                ],
                                                                            ],
                                                                        ]),
                                                                    ],
                                                                    [
                                                                        'title' => 'Estatus 6: Evidencia de Entrega del Elemento de Ensayo',
                                                                        'byline' => '<span>En este paso deberás subir la evidencia de la entrega del elemento de ensayo</a>',
                                                                        'content' => $form->field($model_evidencia, 'image')->widget(FileInput::classname(), [
                                                                            'options' => ['accept' => ['image/*', 'applicaction/pdf']],
                                                                            'pluginOptions' => ['allowedFileExtensions' => ['jpg', 'gif', 'png', 'pdf']],
                                                                        ]) . Html::submitButton($model_evidencia->isNewRecord ? 'Subir Evidencia Entrega' : 'Subir Evidencia Entrega', ['class' => $model_evidencia->isNewRecord ? 'btn btn-primary' : 'btn btn-primary'])
                                                                        . Html::a('Terminar Captura de Evidencia', ['ensayos/terminaretapagen',
                                                                            'idrama' => $model->idrama,
                                                                            'idsubrama' => $model->idsubrama,
                                                                            'idanalito' => $model->idanalito,
                                                                            'idref' => $model->idreferencia,
                                                                            'idcot' => $model->idcot,
                                                                            'idetapa' => 6], ['class' => 'btn btn-primary',
                                                                            'data' => [
                                                                                'confirm' => "¿Deseas terminar la captura de evidencias en esta etapa?",
                                                                                'method' => 'post',
                                                                            ],
                                                                        ])
                                                                        . GridView::widget([
                                                                            'dataProvider' => $dataEntrega,
                                                                            'columns' => [
                                                                                [
                                                                                    'header' => 'Archivo',
                                                                                    'value' => 'file'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Fecha Captura',
                                                                                    'value' => 'fecha'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Fecha Validación',
                                                                                    'value' => 'validado'
                                                                                ],
                                                                            ],
                                                                        ]),
                                                                    ],
                                                                ]
                                                            ]
                                                    );
                                                } else {
                                                    echo \yiister\gentelella\widgets\Timeline::widget(
                                                            [
                                                                'items' => [
                                                                    [
                                                                        'title' => 'Estatus 1: Orden de Compra / Cotización',
                                                                        'byline' => '<span>La orden de compra fue verificada y aceptada</a>',
                                                                        'content' => GridView::widget([
                                                                            'dataProvider' => $dataOdeC,
                                                                            'columns' => [
                                                                                [
                                                                                    'header' => 'Archivo',
                                                                                    'value' => 'file'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Fecha Captura',
                                                                                    'value' => 'fecha'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Fecha Validación',
                                                                                    'value' => 'validado'
                                                                                ],
                                                                            ],
                                                                        ]),
                                                                    ],
                                                                    [
                                                                        'title' => 'Estatus 2: Comprobante de Pago',
                                                                        'byline' => '<span>El comprobante de pago fue verificada y aceptada</a>',
                                                                        'content' => GridView::widget([
                                                                            'dataProvider' => $dataPago,
                                                                            'columns' => [
                                                                                [
                                                                                    'header' => 'Archivo',
                                                                                    'value' => 'file'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Fecha Captura',
                                                                                    'value' => 'fecha'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Fecha Validación',
                                                                                    'value' => 'validado'
                                                                                ],
                                                                            ],
                                                                        ]),
                                                                    ],
                                                                    [
                                                                        'title' => 'Estatus 3: Carta de Aceptación de Lineamientos',
                                                                        'byline' => '<span>La carta de aceptación fue verificada y aceptada</a>',
                                                                        'content' => GridView::widget([
                                                                            'dataProvider' => $dataAceptacion,
                                                                            'columns' => [
                                                                                [
                                                                                    'header' => 'Archivo',
                                                                                    'value' => 'file'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Fecha Captura',
                                                                                    'value' => 'fecha'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Fecha Validación',
                                                                                    'value' => 'validado'
                                                                                ],
                                                                            ],
                                                                        ]),
                                                                    ],
                                                                    [
                                                                        'title' => 'Estatus 4: Codigo de Identificación del Ensayo',
                                                                        'byline' => '<span>El siguiente código te permitirá identificar tu ensayo durante el proceso </a>',
                                                                        'content' => '<h3>CÓDIGO: ' . $model->codigo . '</h3>',
                                                                    ],
                                                                    [
                                                                        'title' => 'Estatus 5: Evidencias de Recepción de Elemento de Ensayo',
                                                                        'byline' => '<span>La evidencia de recepción del elemento de ensayo fue verificada y aceptada</a>',
                                                                        'content' => GridView::widget([
                                                                            'dataProvider' => $dataRecepcion,
                                                                            'columns' => [
                                                                                [
                                                                                    'header' => 'Archivo',
                                                                                    'value' => 'file'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Fecha Captura',
                                                                                    'value' => 'fecha'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Fecha Validación',
                                                                                    'value' => 'validado'
                                                                                ],
                                                                            ],
                                                                        ]),
                                                                    ],
                                                                    [
                                                                        'title' => 'Estatus 6: Evidencia de Entrega del Elemento de Ensayo',
                                                                        'byline' => '<span>El archivo esta en proceso de validación y en breve deberá estar recibiendo un correo con el resultado de dicha validación</a>',
                                                                        'content' => GridView::widget([
                                                                            'dataProvider' => $dataEntrega,
                                                                            'columns' => [
                                                                                [
                                                                                    'header' => 'Archivo',
                                                                                    'value' => 'file'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Fecha Captura',
                                                                                    'value' => 'fecha'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Fecha Validación',
                                                                                    'value' => 'validado'
                                                                                ],
                                                                            ],
                                                                        ]),
                                                                    ],
                                                                ]
                                                            ]
                                                    );
                                                }
                                            } else {
                                                if ($model->termina_resultados == null) {

                                                    $form = ActiveForm::begin([
                                                                'action' => ['ensayos/subirevidenciagen', 'idetapa' => 7],
                                                                'options' => ['enctype' => 'multipart/form-data']
                                                    ]);

                                                    if ($model->valida_resultados == null) {
                                                        echo \yiister\gentelella\widgets\Timeline::widget(
                                                                [
                                                                    'items' => [
                                                                        [
                                                                            'title' => 'Estatus 1: Orden de Compra / Cotización',
                                                                            'byline' => '<span>La orden de compra fue verificada y aceptada</a>',
                                                                            'content' => GridView::widget([
                                                                                'dataProvider' => $dataOdeC,
                                                                                'columns' => [
                                                                                    [
                                                                                        'header' => 'Archivo',
                                                                                        'value' => 'file'
                                                                                    ],
                                                                                    [
                                                                                        'header' => 'Fecha Captura',
                                                                                        'value' => 'fecha'
                                                                                    ],
                                                                                    [
                                                                                        'header' => 'Fecha Validación',
                                                                                        'value' => 'validado'
                                                                                    ],
                                                                                    [
                                                                                        'class' => 'yii\grid\ActionColumn',
                                                                                        'header' => 'Evidencia',
                                                                                        'template' => '{ver}',
                                                                                        'buttons' => [
                                                                                            'ver' => function($url, $model) {
                                                                                                return Html::a('Ver Evidencia', ['verarchivo', 'file' => $model->file, 'hash' => $model->hash], []
                                                                                                );
                                                                                            }
                                                                                        ],
                                                                                    ],
                                                                                ],
                                                                            ]),
                                                                        ],
                                                                        [
                                                                            'title' => 'Estatus 2: Comprobante de Pago',
                                                                            'byline' => '<span>El comprobante de pago fue verificada y aceptada</a>',
                                                                            'content' => GridView::widget([
                                                                                'dataProvider' => $dataPago,
                                                                                'columns' => [
                                                                                    [
                                                                                        'header' => 'Archivo',
                                                                                        'value' => 'file'
                                                                                    ],
                                                                                    [
                                                                                        'header' => 'Fecha Captura',
                                                                                        'value' => 'fecha'
                                                                                    ],
                                                                                    [
                                                                                        'header' => 'Fecha Validación',
                                                                                        'value' => 'validado'
                                                                                    ],
                                                                                    [
                                                                                        'class' => 'yii\grid\ActionColumn',
                                                                                        'header' => 'Evidencia',
                                                                                        'template' => '{ver}',
                                                                                        'buttons' => [
                                                                                            'ver' => function($url, $model) {
                                                                                                return Html::a('Ver Evidencia', ['verarchivo', 'file' => $model->file, 'hash' => $model->hash], []
                                                                                                );
                                                                                            }
                                                                                        ],
                                                                                    ],
                                                                                ],
                                                                            ]),
                                                                        ],
                                                                        [
                                                                            'title' => 'Estatus 3: Carta de Aceptación de Lineamientos',
                                                                            'byline' => '<span>La carta de aceptación fue verificada y aceptada</a>',
                                                                            'content' => GridView::widget([
                                                                                'dataProvider' => $dataAceptacion,
                                                                                'columns' => [
                                                                                    [
                                                                                        'header' => 'Archivo',
                                                                                        'value' => 'file'
                                                                                    ],
                                                                                    [
                                                                                        'header' => 'Fecha Captura',
                                                                                        'value' => 'fecha'
                                                                                    ],
                                                                                    [
                                                                                        'header' => 'Fecha Validación',
                                                                                        'value' => 'validado'
                                                                                    ],
                                                                                    [
                                                                                        'class' => 'yii\grid\ActionColumn',
                                                                                        'header' => 'Evidencia',
                                                                                        'template' => '{ver}',
                                                                                        'buttons' => [
                                                                                            'ver' => function($url, $model) {
                                                                                                return Html::a('Ver Evidencia', ['verarchivo', 'file' => $model->file, 'hash' => $model->hash], []
                                                                                                );
                                                                                            }
                                                                                        ],
                                                                                    ],
                                                                                ],
                                                                            ]),
                                                                        ],
                                                                        [
                                                                            'title' => 'Estatus 4: Codigo de Identificación del Ensayo',
                                                                            'byline' => '<span>El siguiente código te permitirá identificar tu ensayo durante el proceso </a>',
                                                                            'content' => '<h3>CÓDIGO: ' . $model->codigo . '</h3>',
                                                                        ],
                                                                        [
                                                                            'title' => 'Estatus 5: Evidencias de Recepción de Elemento de Ensayo',
                                                                            'byline' => '<span>La evidencia de recepción del elemento de ensayo fue verificada y aceptada</a>',
                                                                            'content' => GridView::widget([
                                                                                'dataProvider' => $dataRecepcion,
                                                                                'columns' => [
                                                                                    [
                                                                                        'header' => 'Archivo',
                                                                                        'value' => 'file'
                                                                                    ],
                                                                                    [
                                                                                        'header' => 'Fecha Captura',
                                                                                        'value' => 'fecha'
                                                                                    ],
                                                                                    [
                                                                                        'header' => 'Fecha Validación',
                                                                                        'value' => 'validado'
                                                                                    ],
                                                                                    [
                                                                                        'class' => 'yii\grid\ActionColumn',
                                                                                        'header' => 'Evidencia',
                                                                                        'template' => '{ver}',
                                                                                        'buttons' => [
                                                                                            'ver' => function($url, $model) {
                                                                                                return Html::a('Ver Evidencia', ['verarchivo', 'file' => $model->file, 'hash' => $model->hash], []
                                                                                                );
                                                                                            }
                                                                                        ],
                                                                                    ],
                                                                                ],
                                                                            ]),
                                                                        ],
                                                                        [
                                                                            'title' => 'Estatus 6: Evidencia de Entrega del Elemento de Ensayo',
                                                                            'byline' => '<span>El archivo esta en proceso de validación y en breve deberá estar recibiendo un correo con el resultado de dicha validación</a>',
                                                                            'content' => GridView::widget([
                                                                                'dataProvider' => $dataEntrega,
                                                                                'columns' => [
                                                                                    [
                                                                                        'header' => 'Archivo',
                                                                                        'value' => 'file'
                                                                                    ],
                                                                                    [
                                                                                        'header' => 'Fecha Captura',
                                                                                        'value' => 'fecha'
                                                                                    ],
                                                                                    [
                                                                                        'header' => 'Fecha Validación',
                                                                                        'value' => 'validado'
                                                                                    ],
                                                                                    [
                                                                                        'class' => 'yii\grid\ActionColumn',
                                                                                        'header' => 'Evidencia',
                                                                                        'template' => '{ver}',
                                                                                        'buttons' => [
                                                                                            'ver' => function($url, $model) {
                                                                                                return Html::a('Ver Evidencia', ['verarchivo', 'file' => $model->file, 'hash' => $model->hash], []
                                                                                                );
                                                                                            }
                                                                                        ],
                                                                                    ],
                                                                                ],
                                                                            ]),
                                                                        ],
                                                                        [
                                                                            'title' => 'Estatus 7: Captura de Resultados del Ensayo',
                                                                            'byline' => '<span>Para finalizar el proceso del ensayo, deberás registrar los resultados del mismo</a>',
                                                                            'content' =>
                                                                            Html::button('Agregar Sub Muestra', ['value' => Url::to('index.php?r=ensayos/ensayos/capturarsubmuestrageneral'), 'class' => 'btn btn-primary', 'id' => 'botonModalResultados'])
                                                                            . GridView::widget([
                                                                                'dataProvider' => $dataResultados,
                                                                                'columns' => [
                                                                                    [
                                                                                        'header' => 'Sub Muestra',
                                                                                        'value' => 'no_submuestra'
                                                                                    ],
                                                                                    [
                                                                                        'header' => 'Resultado',
                                                                                        'value' => 'resultado'
                                                                                    ],
                                                                                    [
                                                                                        'header' => 'Unidad',
                                                                                        'value' => 'idunidad0.nombre'
                                                                                    ],
                                                                                    [
                                                                                        'header' => 'Parametro',
                                                                                        'value' => 'parametro'
                                                                                    ],
                                                                                    [
                                                                                        'header' => 'Fecha de Captura',
                                                                                        'value' => 'fecha_captura'
                                                                                    ],
                                                                                    [
                                                                                        'header' => 'Fecha de Validación',
                                                                                        'value' => 'fecha_validacion'
                                                                                    ],
                                                                                    [
                                                                                        'class' => 'yii\grid\ActionColumn',
                                                                                        'header' => 'Editar Sub Muestra',
                                                                                        'template' => '{editar}',
                                                                                        'buttons' => [
                                                                                            'editar' => function($url, $model, $dataResultados) {
                                                                                                return Html::button('Editar Sub Muestra', ['value' => Url::to(['actualizarsubmuestrageneral',
                                                                                                                'idrama' => $model->idrama,
                                                                                                                'idsubrama' => $model->idsubrama,
                                                                                                                'idanalito' => $model->idanalito,
                                                                                                                'idref' => $model->idreferencia,
                                                                                                                'idcot' => $model->idcot,
                                                                                                                'no_submuestra' => $dataResultados['no_submuestra']]), 'class' => 'btn btn-primary btn-xs btnModificarSub'], []
                                                                                                );
                                                                                            }
                                                                                        ],
                                                                                    ],
                                                                                ],
                                                                            ]) . $form->field($model_evidencia, 'excel')->widget(FileInput::classname(), [
                                                                                'options' => ['accept' => ['application/vnd.ms-excel']],
                                                                                'pluginOptions' => ['allowedFileExtensions' => ['xlsx', 'xls'], 'showUpload' => true,],
                                                                            ])->label("Documento de Evidencia")
                                                                            . Html::submitButton('Subir Evidencia Entrega', ['class' => $cantSubMuestra < 5 ? 'btn btn-success hidden' : 'btn btn-success'])
                                                                            . Html::a('Terminar Captura de Evidencia', ['ensayos/terminaretapagen',
                                                                                'idrama' => $model->idrama,
                                                                                'idsubrama' => $model->idsubrama,
                                                                                'idanalito' => $model->idanalito,
                                                                                'idref' => $model->idreferencia,
                                                                                'idcot' => $model->idcot,
                                                                                'idetapa' => 7], ['class' => $cantSubMuestra < 5 ? 'btn btn-primary hidden' : 'btn btn-primary',
                                                                                'data' => [
                                                                                    'confirm' => "¿Deseas terminar la captura de evidencias y resultados en esta etapa?",
                                                                                ],
                                                                            ])
                                                                            . GridView::widget([
                                                                                'dataProvider' => $filesResultado,
                                                                                'columns' => [
                                                                                    [
                                                                                        'header' => 'Archivo',
                                                                                        'value' => 'file'
                                                                                    ],
                                                                                    [
                                                                                        'header' => 'Fecha Captura',
                                                                                        'value' => 'fecha'
                                                                                    ],
                                                                                    [
                                                                                        'class' => 'yii\grid\ActionColumn',
                                                                                        'header' => 'Evidencia',
                                                                                        'template' => '{ver}',
                                                                                        'buttons' => [
                                                                                            'ver' => function($url, $model) {
                                                                                                return Html::a('Ver Evidencia', ['verarchivo', 'file' => $model->file, 'hash' => $model->hash], []
                                                                                                );
                                                                                            }
                                                                                        ],
                                                                                    ],
                                                                                ],
                                                                            ]),
                                                                        ],
                                                                    ]
                                                                ]
                                                        );
                                                    } else {
                                                        echo \yiister\gentelella\widgets\Timeline::widget(
                                                                [
                                                                    'items' => [
                                                                        [
                                                                            'title' => 'Estatus 1: Orden de Compra / Cotización',
                                                                            'byline' => '<span>La orden de compra fue verificada y aceptada</a>',
                                                                            'content' => GridView::widget([
                                                                                'dataProvider' => $dataOdeC,
                                                                                'columns' => [
                                                                                    [
                                                                                        'header' => 'Archivo',
                                                                                        'value' => 'file'
                                                                                    ],
                                                                                    [
                                                                                        'header' => 'Fecha Captura',
                                                                                        'value' => 'fecha'
                                                                                    ],
                                                                                    [
                                                                                        'header' => 'Fecha Validación',
                                                                                        'value' => 'validado'
                                                                                    ],
                                                                                    [
                                                                                        'class' => 'yii\grid\ActionColumn',
                                                                                        'header' => 'Evidencia',
                                                                                        'template' => '{ver}',
                                                                                        'buttons' => [
                                                                                            'ver' => function($url, $model) {
                                                                                                return Html::a('Ver Evidencia', ['verarchivo', 'file' => $model->file, 'hash' => $model->hash], []
                                                                                                );
                                                                                            }
                                                                                        ],
                                                                                    ],
                                                                                ],
                                                                            ]),
                                                                        ],
                                                                        [
                                                                            'title' => 'Estatus 2: Comprobante de Pago',
                                                                            'byline' => '<span>El comprobante de pago fue verificada y aceptada</a>',
                                                                            'content' => GridView::widget([
                                                                                'dataProvider' => $dataPago,
                                                                                'columns' => [
                                                                                    [
                                                                                        'header' => 'Archivo',
                                                                                        'value' => 'file'
                                                                                    ],
                                                                                    [
                                                                                        'header' => 'Fecha Captura',
                                                                                        'value' => 'fecha'
                                                                                    ],
                                                                                    [
                                                                                        'header' => 'Fecha Validación',
                                                                                        'value' => 'validado'
                                                                                    ],
                                                                                    [
                                                                                        'class' => 'yii\grid\ActionColumn',
                                                                                        'header' => 'Evidencia',
                                                                                        'template' => '{ver}',
                                                                                        'buttons' => [
                                                                                            'ver' => function($url, $model) {
                                                                                                return Html::a('Ver Evidencia', ['verarchivo', 'file' => $model->file, 'hash' => $model->hash], []
                                                                                                );
                                                                                            }
                                                                                        ],
                                                                                    ],
                                                                                ],
                                                                            ]),
                                                                        ],
                                                                        [
                                                                            'title' => 'Estatus 3: Carta de Aceptación de Lineamientos',
                                                                            'byline' => '<span>La carta de aceptación fue verificada y aceptada</a>',
                                                                            'content' => GridView::widget([
                                                                                'dataProvider' => $dataAceptacion,
                                                                                'columns' => [
                                                                                    [
                                                                                        'header' => 'Archivo',
                                                                                        'value' => 'file'
                                                                                    ],
                                                                                    [
                                                                                        'header' => 'Fecha Captura',
                                                                                        'value' => 'fecha'
                                                                                    ],
                                                                                    [
                                                                                        'header' => 'Fecha Validación',
                                                                                        'value' => 'validado'
                                                                                    ],
                                                                                    [
                                                                                        'class' => 'yii\grid\ActionColumn',
                                                                                        'header' => 'Evidencia',
                                                                                        'template' => '{ver}',
                                                                                        'buttons' => [
                                                                                            'ver' => function($url, $model) {
                                                                                                return Html::a('Ver Evidencia', ['verarchivo', 'file' => $model->file, 'hash' => $model->hash], []
                                                                                                );
                                                                                            }
                                                                                        ],
                                                                                    ],
                                                                                ],
                                                                            ]),
                                                                        ],
                                                                        [
                                                                            'title' => 'Estatus 4: Codigo de Identificación del Ensayo',
                                                                            'byline' => '<span>El siguiente código te permitirá identificar tu ensayo durante el proceso </a>',
                                                                            'content' => '<h3>CÓDIGO: ' . $model->codigo . '</h3>',
                                                                        ],
                                                                        [
                                                                            'title' => 'Estatus 5: Evidencias de Recepción de Elemento de Ensayo',
                                                                            'byline' => '<span>La evidencia de recepción del elemento de ensayo fue verificada y aceptada</a>',
                                                                            'content' => GridView::widget([
                                                                                'dataProvider' => $dataRecepcion,
                                                                                'columns' => [
                                                                                    [
                                                                                        'header' => 'Archivo',
                                                                                        'value' => 'file'
                                                                                    ],
                                                                                    [
                                                                                        'header' => 'Fecha Captura',
                                                                                        'value' => 'fecha'
                                                                                    ],
                                                                                    [
                                                                                        'header' => 'Fecha Validación',
                                                                                        'value' => 'validado'
                                                                                    ],
                                                                                    [
                                                                                        'class' => 'yii\grid\ActionColumn',
                                                                                        'header' => 'Evidencia',
                                                                                        'template' => '{ver}',
                                                                                        'buttons' => [
                                                                                            'ver' => function($url, $model) {
                                                                                                return Html::a('Ver Evidencia', ['verarchivo', 'file' => $model->file, 'hash' => $model->hash], []
                                                                                                );
                                                                                            }
                                                                                        ],
                                                                                    ],
                                                                                ],
                                                                            ]),
                                                                        ],
                                                                        [
                                                                            'title' => 'Estatus 6: Evidencia de Entrega del Elemento de Ensayo',
                                                                            'byline' => '<span>El archivo esta en proceso de validación y en breve deberá estar recibiendo un correo con el resultado de dicha validación</a>',
                                                                            'content' => GridView::widget([
                                                                                'dataProvider' => $dataEntrega,
                                                                                'columns' => [
                                                                                    [
                                                                                        'header' => 'Archivo',
                                                                                        'value' => 'file'
                                                                                    ],
                                                                                    [
                                                                                        'header' => 'Fecha Captura',
                                                                                        'value' => 'fecha'
                                                                                    ],
                                                                                    [
                                                                                        'header' => 'Fecha Validación',
                                                                                        'value' => 'validado'
                                                                                    ],
                                                                                    [
                                                                                        'class' => 'yii\grid\ActionColumn',
                                                                                        'header' => 'Evidencia',
                                                                                        'template' => '{ver}',
                                                                                        'buttons' => [
                                                                                            'ver' => function($url, $model) {
                                                                                                return Html::a('Ver Evidencia', ['verarchivo', 'file' => $model->file, 'hash' => $model->hash], []
                                                                                                );
                                                                                            }
                                                                                        ],
                                                                                    ],
                                                                                ],
                                                                            ]),
                                                                        ],
                                                                        [
                                                                            'title' => 'Estatus 7: Captura de Resultados del Ensayo',
                                                                            'byline' => '<span>Los resultados fueron ingresados y en breve serán validados.</a>',
                                                                            'content' =>
                                                                            GridView::widget([
                                                                                'dataProvider' => $dataResultados,
                                                                                'columns' => [
                                                                                    [
                                                                                        'header' => 'Sub Muestra',
                                                                                        'value' => 'no_submuestra'
                                                                                    ],
                                                                                    [
                                                                                        'header' => 'Resultado',
                                                                                        'value' => 'resultado'
                                                                                    ],
                                                                                    [
                                                                                        'header' => 'Unidad',
                                                                                        'value' => 'idunidad0.nombre'
                                                                                    ],
                                                                                    [
                                                                                        'header' => 'Parametro',
                                                                                        'value' => 'parametro'
                                                                                    ],
                                                                                    [
                                                                                        'header' => 'Fecha de Captura',
                                                                                        'value' => 'fecha_captura'
                                                                                    ],
                                                                                    [
                                                                                        'header' => 'Fecha de Validación',
                                                                                        'value' => 'fecha_validacion'
                                                                                    ],
                                                                                ],
                                                                            ])
                                                                            . GridView::widget([
                                                                                'dataProvider' => $filesResultado,
                                                                                'columns' => [
                                                                                    [
                                                                                        'header' => 'Archivo',
                                                                                        'value' => 'file'
                                                                                    ],
                                                                                    [
                                                                                        'header' => 'Fecha Captura',
                                                                                        'value' => 'fecha'
                                                                                    ],
                                                                                    [
                                                                                        'class' => 'yii\grid\ActionColumn',
                                                                                        'header' => 'Evidencia',
                                                                                        'template' => '{ver}',
                                                                                        'buttons' => [
                                                                                            'ver' => function($url, $model) {
                                                                                                return Html::a('Ver Evidencia', ['verarchivo', 'file' => $model->file, 'hash' => $model->hash], []
                                                                                                );
                                                                                            }
                                                                                        ],
                                                                                    ],
                                                                                ],
                                                                            ]),
                                                                        ],
                                                                    ]
                                                                ]
                                                        );
                                                    }
                                                } else {
                                                    echo \yiister\gentelella\widgets\Timeline::widget(
                                                            [
                                                                'items' => [
                                                                    [
                                                                        'title' => 'Estatus 1: Orden de Compra / Cotización',
                                                                        'byline' => '<span>La orden de compra fue verificada y aceptada</a>',
                                                                        'content' => GridView::widget([
                                                                            'dataProvider' => $dataOdeC,
                                                                            'columns' => [
                                                                                [
                                                                                    'header' => 'Archivo',
                                                                                    'value' => 'file'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Fecha Captura',
                                                                                    'value' => 'fecha'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Fecha Validación',
                                                                                    'value' => 'validado'
                                                                                ],
                                                                                [
                                                                                    'class' => 'yii\grid\ActionColumn',
                                                                                    'header' => 'Evidencia',
                                                                                    'template' => '{ver}',
                                                                                    'buttons' => [
                                                                                        'ver' => function($url, $model) {
                                                                                            return Html::a('Ver Evidencia', ['verarchivo', 'file' => $model->file, 'hash' => $model->hash], []
                                                                                            );
                                                                                        }
                                                                                    ],
                                                                                ],
                                                                            ],
                                                                        ]),
                                                                    ],
                                                                    [
                                                                        'title' => 'Estatus 2: Comprobante de Pago',
                                                                        'byline' => '<span>El comprobante de pago fue verificada y aceptada</a>',
                                                                        'content' => GridView::widget([
                                                                            'dataProvider' => $dataPago,
                                                                            'columns' => [
                                                                                [
                                                                                    'header' => 'Archivo',
                                                                                    'value' => 'file'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Fecha Captura',
                                                                                    'value' => 'fecha'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Fecha Validación',
                                                                                    'value' => 'validado'
                                                                                ],
                                                                                [
                                                                                    'class' => 'yii\grid\ActionColumn',
                                                                                    'header' => 'Evidencia',
                                                                                    'template' => '{ver}',
                                                                                    'buttons' => [
                                                                                        'ver' => function($url, $model) {
                                                                                            return Html::a('Ver Evidencia', ['verarchivo', 'file' => $model->file, 'hash' => $model->hash], []
                                                                                            );
                                                                                        }
                                                                                    ],
                                                                                ],
                                                                            ],
                                                                        ]),
                                                                    ],
                                                                    [
                                                                        'title' => 'Estatus 3: Carta de Aceptación de Lineamientos',
                                                                        'byline' => '<span>La carta de aceptación fue verificada y aceptada</a>',
                                                                        'content' => GridView::widget([
                                                                            'dataProvider' => $dataAceptacion,
                                                                            'columns' => [
                                                                                [
                                                                                    'header' => 'Archivo',
                                                                                    'value' => 'file'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Fecha Captura',
                                                                                    'value' => 'fecha'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Fecha Validación',
                                                                                    'value' => 'validado'
                                                                                ],
                                                                                [
                                                                                    'class' => 'yii\grid\ActionColumn',
                                                                                    'header' => 'Evidencia',
                                                                                    'template' => '{ver}',
                                                                                    'buttons' => [
                                                                                        'ver' => function($url, $model) {
                                                                                            return Html::a('Ver Evidencia', ['verarchivo', 'file' => $model->file, 'hash' => $model->hash], []
                                                                                            );
                                                                                        }
                                                                                    ],
                                                                                ],
                                                                            ],
                                                                        ]),
                                                                    ],
                                                                    [
                                                                        'title' => 'Estatus 4: Codigo de Identificación del Ensayo',
                                                                        'byline' => '<span>El siguiente código te permitirá identificar tu ensayo durante el proceso </a>',
                                                                        'content' => '<h3>CÓDIGO: ' . $model->codigo . '</h3>',
                                                                    ],
                                                                    [
                                                                        'title' => 'Estatus 5: Evidencias de Recepción de Elemento de Ensayo',
                                                                        'byline' => '<span>La evidencia de recepción del elemento de ensayo fue verificada y aceptada</a>',
                                                                        'content' => GridView::widget([
                                                                            'dataProvider' => $dataRecepcion,
                                                                            'columns' => [
                                                                                [
                                                                                    'header' => 'Archivo',
                                                                                    'value' => 'file'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Fecha Captura',
                                                                                    'value' => 'fecha'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Fecha Validación',
                                                                                    'value' => 'validado'
                                                                                ],
                                                                                [
                                                                                    'class' => 'yii\grid\ActionColumn',
                                                                                    'header' => 'Evidencia',
                                                                                    'template' => '{ver}',
                                                                                    'buttons' => [
                                                                                        'ver' => function($url, $model) {
                                                                                            return Html::a('Ver Evidencia', ['verarchivo', 'file' => $model->file, 'hash' => $model->hash], []
                                                                                            );
                                                                                        }
                                                                                    ],
                                                                                ],
                                                                            ],
                                                                        ]),
                                                                    ],
                                                                    [
                                                                        'title' => 'Estatus 6: Evidencia de Entrega del Elemento de Ensayo',
                                                                        'byline' => '<span>El archivo esta en proceso de validación y en breve deberá estar recibiendo un correo con el resultado de dicha validación</a>',
                                                                        'content' => GridView::widget([
                                                                            'dataProvider' => $dataEntrega,
                                                                            'columns' => [
                                                                                [
                                                                                    'header' => 'Archivo',
                                                                                    'value' => 'file'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Fecha Captura',
                                                                                    'value' => 'fecha'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Fecha Validación',
                                                                                    'value' => 'validado'
                                                                                ],
                                                                                [
                                                                                    'class' => 'yii\grid\ActionColumn',
                                                                                    'header' => 'Evidencia',
                                                                                    'template' => '{ver}',
                                                                                    'buttons' => [
                                                                                        'ver' => function($url, $model) {
                                                                                            return Html::a('Ver Evidencia', ['verarchivo', 'file' => $model->file, 'hash' => $model->hash], []
                                                                                            );
                                                                                        }
                                                                                    ],
                                                                                ],
                                                                            ],
                                                                        ]),
                                                                    ],
                                                                    [
                                                                        'title' => 'Estatus 7: Captura de Resultados del Ensayo',
                                                                        'byline' => '<span>Los resultados fueron validados.</a>',
                                                                        'content' =>
                                                                        GridView::widget([
                                                                            'dataProvider' => $dataResultados,
                                                                            'columns' => [
                                                                                [
                                                                                    'header' => 'Sub Muestra',
                                                                                    'value' => 'no_submuestra'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Resultado',
                                                                                    'value' => 'resultado'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Unidad',
                                                                                    'value' => 'idunidad0.nombre'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Parametro',
                                                                                    'value' => 'parametro'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Fecha de Captura',
                                                                                    'value' => 'fecha_captura'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Fecha de Validación',
                                                                                    'value' => 'fecha_validacion'
                                                                                ],
                                                                            ],
                                                                        ])
                                                                        . GridView::widget([
                                                                            'dataProvider' => $filesResultado,
                                                                            'columns' => [
                                                                                [
                                                                                    'header' => 'Archivo',
                                                                                    'value' => 'file'
                                                                                ],
                                                                                [
                                                                                    'header' => 'Fecha Captura',
                                                                                    'value' => 'fecha'
                                                                                ],
                                                                                [
                                                                                    'class' => 'yii\grid\ActionColumn',
                                                                                    'header' => 'Evidencia',
                                                                                    'template' => '{ver}',
                                                                                    'buttons' => [
                                                                                        'ver' => function($url, $model) {
                                                                                            return Html::a('Ver Evidencia', ['verarchivo', 'file' => $model->file, 'hash' => $model->hash], []
                                                                                            );
                                                                                        }
                                                                                    ],
                                                                                ],
                                                                            ],
                                                                        ]),
                                                                    ],
                                                                ]
                                                            ]
                                                    );
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            if ($cantSubMuestra > 4 && $model->termina_resultados == null) {
                                ?>
                                <script>
                                    var elem = document.getElementById("botonModalResultados");
                                    elem.parentNode.removeChild(elem);
                                </script>
                                <?php
                            }
                            Modal::begin([
                                'header' => '<h3 id="cabecera"></h3>',
                                'id' => 'modal_SubMuestras',
                                'size' => 'modal-md'
                            ]);

                            echo "<div id='modalContent'></div>";

                            Modal::end();

                            Modal::begin([
                                'header' => '<h3 id="cabecera_edit">Modificar Sub Muestra</h3>',
                                'id' => 'modal_EditarSubMuestras',
                                'size' => 'modal-md'
                            ]);

                            echo "<div id='modalContenteditar'></div>";

                            Modal::end();
                            ?>   


                            <?php
                            if ($model->termina_resultados == null) {
                                echo $form->field($model, 'idrama', ['options' => [
                                        'value' => $model->idrama]])->hiddenInput()->label(false);

                                echo $form->field($model, 'idsubrama', ['options' => [
                                        'value' => $model->idsubrama]])->hiddenInput()->label(false);

                                echo $form->field($model, 'idanalito', ['options' => [
                                        'value' => $model->idanalito]])->hiddenInput()->label(false);

                                echo $form->field($model, 'idreferencia', ['options' => [
                                        'value' => $model->idreferencia]])->hiddenInput()->label(false);

                                echo $form->field($model, 'idcot', ['options' => [
                                        'value' => $model->idcot]])->hiddenInput()->label(false);
                                ?>

                                <?php
                                ActiveForm::end();
                            }
                            ?>

                        </div>
                    </div><!-- panel-body -->
                </div>
            </div>
        </div>
    </div>

</div>