<?php

use yii\helpers\Html;
use kartik\markdown\MarkdownEditor;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;


/* @var $this yii\web\View */
/* @var $model app\modules\catalogos\models\Analitos */

$this->title = 'Agregar Alerta';
$this->params['breadcrumbs'][] = ['label' => 'Alertas Programadas', 
                                    'url' => ['calibracion', 
                                                'idarea'=> $idarea, 
                                                'idref' => $idref,
                                                'idcot' => $idcot]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="analitos-create">

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Datos del Ensayo</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12">
                    <div class="panel panel-primary">
                        <div class="panel-body">                
                            <h5><b>Area: </b>
                                <?php echo $model_calibracion->idarea0->descarea; ?>
                            </h5>
                            <h5><b>Referencia: </b>
                                <?php echo $model_calibracion->idreferencia0->descreferencia; ?>
                            </h5>
                            <h5><b>Intervalo: </b>
                                <?php echo $model_calibracion->intervalo; ?>
                            </h5>
                        </div>
                    </div><!-- panel-body -->
                </div>
            </div>
        </div>
    </div>

    <?php
        //$form = ActiveForm::begin([
        //    'action' => ['enviaremail','idarea'=>$idarea, 'idref'=>$idref, 'idcte'=>$idcte, 'idetapa'=>$idetapa],
        //]);
        $form = ActiveForm::begin();
    ?>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="panel-body">

            <?= 
                $form->field($model, 'fecha')->widget(DatePicker::classname(),
                [
                    'options' => ['placeholder' => 'Introduce la fecha en que se enviará la alerta'],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd',
                    ]
                ]);
            ?>

            <div class="panel-body">                
                <?=
                    MarkdownEditor::widget([
                        'model' => $model,
                        'attribute' => 'msjalerta',
                        //'value' => "",
                        'smarty' => true,
                        'height'=>100,
                    ]);
                ?>
            </div>

            <div class="form-group">
                <?= Html::submitButton('Guardar Alerta' , ['class' => 'btn btn-primary']) ?>
            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
