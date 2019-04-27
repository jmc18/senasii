<?php
//use yii\helpers\Html;
use kartik\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\grid\GridView;
use kartik\markdown\MarkdownEditor;

/* @var $this yii\web\View */
/* @var $model app\modules\calendarios\models\CalendarioCalibracion */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Ensayos Aceptados';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>

<div class="calendario-calibracion-form">

    <div class="row">
        <div class="col-md-6 col-xs-12">

        	<div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Datos del Cliente</h3>
                </div>
                <div class="panel-body">
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

        <div class="col-md-6 col-xs-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Datos del Ensayo</h3>
                </div>
                <div class="panel-body">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Validar Evidencias</h3>
        </div>
        <div class="panel-body">

       <?= GridView::widget([
			'dataProvider' => $data,
			'columns' => [
				[
					'header'=> 'Archivo',
					'value' => 'file'
				],
				[
					'header'=> 'Fecha Captura',
					'value' => 'fecha'
				],
				[
					'header'=> 'Fecha Validación',
					'value' => 'validado'
				],
				[
                    'class' => 'yii\grid\ActionColumn',
                    'header'=> 'Validar',
                    'template' => '{validar}',
                    'buttons' => [
                        'validar' => function($url, $model)
                        {   
                            if( $model->validado == null ){
                                return Html::a('<span class="glyphicon glyphicon-check"></span> Aceptar',
                                    ['aceptarevidenciagen', 'idrama' => $model->idrama, 'idsubrama'=>$model->idsubrama, 'idanalito'=>$model->idanalito, 'idref'=>$model->idreferencia, 'idcot'=>$model->idcot, 'idetapa'=>$model->idetapa, 'nofiles'=>$model->nofiles], 
                                    [
                                        'class'=>'btn btn-default btn-xs btn-block',
                                    ]
                                );
                            }
                            else{
                                return Html::bsLabel("Archivo Validado", Html::TYPE_SUCCESS);
                            }
                        },
                    ],
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header'=>'Evidencia',
                    'template'=>'{ver}',
                    'buttons'=>[
                        'ver'=>function($url,$model)
                        {
                            return Html::a('Ver Evidencia',
                                    ['/ensayos/ensayos/verarchivo', 'file'=>$model->file, 'hash'=>$model->hash], 
                                    [
                                        'class'=>'btn btn-default btn-xs btn-block',
                                    ]
                                    );

                        }
                    ],
                ],  
			  ],
			]);
		?>

		</div>
	</div>

	<?php
    	$form = ActiveForm::begin([
			'action' => ['enviaremailgen','idrama'=>$idrama, 'idsubrama'=>$idsubrama, 'idanalito'=>$idanalito , 'idref'=>$idref, 'idcot'=>$idcot, 'idetapa'=>$idetapa],
		]);
    ?>

	<div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Enviar Notificación de los Resultados de la Validación</h3>
        </div>

        <div class="panel-body">

           <?=
        		'<h3>'.Html::bsLabel("Recuerda enviar la notificación al cliente para finalizar con la revisión de esta etapa, en caso de no enviarla, el cliente no podrá seguir con el proceso", Html::TYPE_DANGER).'</h3>';
        	?>

            <br><h5><b>Contacto a enviar la notificación: </b></h5>
            <?= 
				Html::dropDownList('email', 
                                    null, 
                                    $listcontactos, 
                                    [
                                        'id'=>'listcontactos.nocontacto0.emailcon',
                                        'prompt' => 'Selecciona un contacto para enviar la notificación',
                                        'class'=>'form-control',
                                    ]
                );
			?>
	
            <div class="panel-body">                
        		<?=
    					 MarkdownEditor::widget([
    						'name' => 'emailcontacto', 
						    'value' => $texto,
						    'smarty' => true,
						    'height'=>100,
						]);
    				?>
            </div>
   			<div class="form-group">
        		<?= Html::submitButton('Enviar Email de Notificación' , ['class' => 'btn btn-primary']) ?>
    		</div>
        </div>
    </div>

	<?php ActiveForm::end(); ?>
</div>