<?php
use kartik\widgets\FileInput;
use kartik\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

?>

<div class="calendario-calibracion-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Datos del Lineamiento</h3>
        </div>
        <div class="panel-body">

		<?= 
        $form->field($model, 'fecinilinea')->widget(DatePicker::classname(), 
                [
                    'options' => ['placeholder' => 'Introduce la fecha inicial en la cual se puede descargar el archivo'],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd',
                    ]
                ]);
    	?>

    	<?= 
        $form->field($model, 'fecfinlinea')->widget(DatePicker::classname(), 
                [
                    'options' => ['placeholder' => 'Introduce la fecha final en la cual se puede descargar el archivo'],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd',
                    ]
                ]);
    	?>

    	<?=
        \yiister\gentelella\widgets\Timeline::widget(
        [
            'items' => [
                [
                    //'title' => 'Lineamientos del Ensayo',
                    'byline' => '<span>En este sección podrás cargar el archivo en formato PDF con los lineamientos a seguir por el cliente para este ensayo</a>',
                    'content' => 
                            $form->field($model, 'image')->widget(FileInput::classname(), [
                                    'options' => ['accept' => ['applicaction/pdf']],
                                    'pluginOptions'=>[
                                        /*'initialPreview'=>[
                                            //Yii::getAlias('@app').'/assets/'.$model->hash_linea,
                                            '/Users/office/Sites/sena_dev/basic/assets/7VC_-_RptQ0F4iGxS-fZLcFPXfaPfSYm.pdf',
                                        ],*/
                                        'initialPreviewAsData'=>true,
                                        'allowedFileExtensions'=>['pdf'],
                                        'showUpload' => true,
                                    ]
                            ])
                ],
            ]
        ]);    
    	?>

        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Lineamientos del Ensayo</h3>
        </div>
        <div class="panel-body" id="idgrid">
            <?php Pjax::begin(['id' => 'lineamientos', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]) ?>
        	<?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'header'=> 'Archivo',
                            'value' => 'file_linea'
                        ],
                        [
                            'header'=> 'Disponibilidad',
                            'value' => 'fecfinlinea'
                        ],
                        /*[
                            'class' => 'yii\grid\ActionColumn',
                            'header'=>'Lineamientos',
                            'template'=>'{ver}',
                            'buttons'=>[
                                'ver'=>function($url,$model)
                                {
                                    if( !empty($model->file_linea) ){
                                        return Html::a('Ver Lineamiento',
                                            ['/ensayos/ensayos/verarchivo', 'file'=>$model->file_linea, 'hash'=>$model->hash_linea], 
                                            [
                                                 'target' => '_blank',
                                            ]
                                        );
                                    }
                                    else{
                                        return Html::bsLabel("No se ha registrado el lineamiento para este ensayo.", Html::TYPE_DANGER);
                                    }
                                }
                            ],
                        ],*/
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header'=> 'Acciones',
                            'template' => '{delete}',
                            'buttons' => [
                                'delete' => function($url, $model)
                                {
                                    return Html::a('<span class="glyphicon glyphicon-trash"> </span>',
                                        ['eliminarlineamientocal', 'idlineamiento' => $model->idlineamiento], 
                                        [
                                            'class' => 'btn btn-danger btn-sm',
                                            'data' => [
                                                'confirm' => '¿Deseas borrar el lineamiento de este ensayo?',
                                                'method' => 'post',
                                            ],
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
    <?php Pjax::end(); ?>
   
    <?php 
        //$this->registerJS('$.pjax.reload("#lineamientos", {timeout : false})');
    ?>

    <?php ActiveForm::end(); ?>
    
</div>