<?php

//use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use kartik\select2\Select2;
use kartik\helpers\Html;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\clientes\models\ClientesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios del Cliente';
$this->params['breadcrumbs'][] = ['label'=>'Listado de Clientes','url'=>['/clientes/clientes']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>

<div class="clientes-index">

   <div class="row">
		<div class="col-xs-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
				    <h3 class="panel-title">Datos del Cliente</h3>
				</div>
				<div class="panel-body">	    		
					<h5><b>Nombre del Cliente: </b>
						<?php echo $model_cliente->nomcte; ?>
					</h5>
					<h5><b>Email del Cliente: </b>
						<?php echo $model_cliente->email; ?>
					</h5>
					<h5><b>Sucursal: </b>
						<?php echo $model_cliente->sucursal; ?>
					</h5>
				</div>
		  	</div><!-- panel-body -->
		</div>
		<div class="col-xs-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
				    <h3 class="panel-title">Asignar Usuario al Cliente</h3>
				</div>

 				<?php $form = ActiveForm::begin(); ?>

				<div class="panel-body">	    		
					<?=
						$form->field($model, 'idusr')->widget(Select2::classname(), [
						    'data' => $items_users,
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
        				<?= Html::submitButton($model->isNewRecord ? 'Asignar Usuario' : 'Asignar Usuario', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success∫	']) ?>
    				</div>
				</div>

				<?php ActiveForm::end(); ?>

		  	</div><!-- panel-body -->
		</div>	
		<div class="col-xs-12">
			<div class="panel panel-primary">
			  	<div class="panel-heading">
			    	<h3 class="panel-title">Lista de Usuarios Asignados al Cliente</h3>
			  	</div>
			  	<div class="panel-body">
			  		<?= 
        				GridView::widget([
				            'dataProvider' => $model_usrscte,
				            'columns' => [
				            	[
				            		'header' => 'Nombre de Usuario',
				            		'value'  => 'username'
				            	],
				            	[
				            		'header' => 'Fecha Invitación',
				            		'value'  => 'fechainvitacion'
				            	],
				            	[
					                'format'=> 'html',
					                'header'=> 'Estatus',
					                'value' => function ($dataProvider) {

					                    if($dataProvider->activate == 1)
					                        return Html::bsLabel('CUENTA ACTIVA', 
					                        			Html::TYPE_SUCCESS
					                        			);
					                    else
					                    	return Html::a('<span class="glyphicon glyphicon-envelope"></span> Enviar Invitación',
					                             ['enviaractivacion', 'idusr'=>$dataProvider->idusr], 
					                             [
					                                'class'=>'btn btn-default btn-xs btn-block btn-primary',
                    	    						'data' => [
					                                    'method' => 'post',
					                                ],
					                            ]
					                        );
					                        //return Html::bsLabel('CUENTA INACTIVA', Html::TYPE_DANGER);
					                }
					            ],
					            /*[
				            		'class' => 'yii\grid\ActionColumn',
                					'header'=> 'Invitar',
                					'template' => '{invitar}',
					                'buttons' => [
					                    'invitar' => function($url, $model)
					                    {

					                        
					                    }
				            		],
				            	],	*/
				            	[
				            		'class' => 'yii\grid\ActionColumn',
                					'header'=> 'Acciones',
                					'template' => '{delete}',
					                'buttons' => [
					                    'delete' => function($url, $model)
					                    {
					                        return Html::a('<span class="glyphicon glyphicon-trash"></span> Quitar Usuario',
					                             ['quitarusuario', 'idcte' => $model->idcte, 'idusr'=>$model->idusr], 
					                             [
					                                'class'=>'btn btn-default btn-xs btn-block btn-danger',
                    	    						'data' => [
					                                    'confirm' => '¿Deseas quitar este usuario del cliente actual?',
					                                    'method' => 'post',
					                                ],
					                            ]
					                        );
					                    }
				            		],
				            	],	
				         	],
    					]); ?>
				<?= Html::a('Cancelar y Regresar', ['/clientes/clientes'],['class' => 'btn btn-danger']); ?>
			  	</div>

			</div>
		</div>
	</div>

</div>