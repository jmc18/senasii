<?php

use yii\helpers\Html;
//use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;
?>

<?php
$form = ActiveForm::begin([
            "method" => "post",
            "action" => Url::toRoute("ensayos/registrarsubmuestra"),
            'enableClientValidation' => true
        ]);
foreach ($secciones as $datos) :
?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><?= $datos['nombre']?></h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12">
                <?php
                foreach ($datos['campos'] as $formulario){
                    ?>
                <div class="form-group">
                    <label><?= $formulario['texto_etiquetas']?> <?= $formulario['requerido'] == 'SI' ? '<sup class="text-danger">*</sup>' : '' ?> <?= $formulario['unidad']?></label>
                    <?= Html::input('text', 's_'.$datos['id'].'_c_'.$formulario['idCampo'], '', ['class' => 'form-control', 'required' => 'true']); ?>
                </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php 
endforeach;

echo Html::hiddenInput('idarea', $idarea);
echo Html::hiddenInput('idcot', $idcot);
echo Html::hiddenInput('idref', $idref);
?>

<div>
    <?= Html::submitButton('Agregar Sub Muestra', ['class' => 'btn btn-success btn-block']) ?>
</div>

<?php
ActiveForm::end();
$script = "function validar_entrada(entrada){
        if(entrada == ){
        
}

}";
 
//$this->registerJs($script);
?>

