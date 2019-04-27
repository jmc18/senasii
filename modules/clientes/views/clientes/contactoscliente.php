<?php

//use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use kartik\select2\Select2;
use kartik\helpers\Html;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\clientes\models\ClientesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Listado de Clientes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clientes-index">

   <div class="row">
		<div class="col-xs-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
				    <h3 class="panel-title">Datos del Cliente</h3>
				</div>
				<div class="panel-body">	    		
					<h5><b>Nombre del Cliente: </b>
						<?php echo $model_clientes->nomcte; ?>
					</h5>
					<h5><b>Email del Cliente: </b>
						<?php echo $model_clientes->email; ?>
					</h5>
					<h5><b>Sucursal: </b>
						<?php echo $model_clientes->sucursal; ?>
					</h5>
				</div>
		  	</div><!-- panel-body -->
		</div>
		<div class="col-xs-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
				    <h3 class="panel-title">Agregar Contacto al Cliente</h3>
				</div>

 				<?php $form = ActiveForm::begin(); ?>

				<div class="panel-body">	    		
					<?=
					/*Select2::widget([
						'model'=> $model,
					    'name' => 'idcontactos',
					    'data' => $items_contactos,
					    'size' => Select2::MEDIUM,
					    'addon' => [
					        'prepend' => [
					            'content' => Html::icon('plus')
					        ],
					    ]
					]);*/

						$form->field($model, 'nocontacto')->widget(Select2::classname(), [
						    'data' => $items_contactos,
						    'options' => ['placeholder' => 'Selecciona un contacto ...'],
						    'pluginOptions' => [
						        'allowClear' => true
						    ],
						    'addon' => [
						        'prepend' => [
						            'content' => Html::icon('plus')
						        ],
					    	]
						]);
					?>

					<div class="form-group">
        				<?= Html::submitButton($model->isNewRecord ? 'Asignar Contacto' : 'Asignar Contacto', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success∫	']) ?>
    				</div>
				</div>

				<?php ActiveForm::end(); ?>

		  	</div><!-- panel-body -->
		</div>	
		<div class="col-xs-12">
			<div class="panel panel-primary">
			  	<div class="panel-heading">
			    	<h3 class="panel-title">Lista de Contactos del Cliente</h3>
			  	</div>
			  	<div class="panel-body">
			  		<?= 
        				GridView::widget([
				            'dataProvider' => $model_ctesctos,
				            'columns' => [
				            	[
				            		'header' => 'Nombre del Contacto',
				            		'value'  => 'nocontacto0.nombrecon'
				            	],
				            	[
				            		'header' => 'Apellido Paterno',
				            		'value'  => 'nocontacto0.apepatcon'
				            	],
				            	[
				            		'header' => 'Apellido Materno',
				            		'value'  => 'nocontacto0.apematcon'
				            	],
				            	[
				            		'class' => 'yii\grid\ActionColumn',
                					'header'=> 'Acciones',
                					'template' => '{delete}',
					                'buttons' => [
					                    'delete' => function($url, $model_ctesctos)
					                    {
					                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',
					                             ['eliminarctocte', 'idcte' => $model_ctesctos->idcte, 'nocontacto'=>$model_ctesctos->nocontacto], 
					                             [
					                                'class' => '',
					                                'data' => [
					                                    'confirm' => '¿Deseas eliminar este contacto del cliente actual?',
					                                    'method' => 'post',
					                                ],
					                            ]
					                        );
					                    }
				            		],
				            	],	
				         	],
    					]); ?>
			  	</div>
			</div>
		</div>
	</div>

</div>