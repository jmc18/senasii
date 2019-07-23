<?php

use yii\helpers\Html;
?>

<div class="panel panel-danger">
    <button class="btn btn-danger pull-right" onclick="MostrarFormularioSeccionInsert(<?= $idseccion ?>, '<?= $nomSeccion ?>')"><span class="fa fa-plus-square"></span> Agregar Campo</button>
    <div class="panel-heading">
        Campos Correspondientes a la Seccion : <b><?= $nomSeccion ?></b>
    </div>
    <div class="panel-body table-responsive">
        <table class="table table-bordered table-condensed table-hover table-striped">
            <thead>
                <tr>
                    <th class="text-center" style="vertical-align: middle">Orden</th>
                    <th class="text-center" style="vertical-align: middle">Etiqueta</th>
                    <th class="text-center" style="vertical-align: middle">Formula</th>
                    <th class="text-center" style="vertical-align: middle">Unidad de Medida</th>
                    <th class="text-center" style="vertical-align: middle">Tipo de Entrada</th>
                    <th class="text-center" style="vertical-align: middle">Campo Requerido</th>
                    <th class="text-center" style="vertical-align: middle">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($detalle_formulario as $formulario) {
                    if ($formulario->idunidad != "") {
                        $unidad = $formulario->idunidad0->nombre . " (" . $formulario->idunidad0->abre . ")";
                    } else {
                        $unidad = '';
                    }

                    if ($formulario->requerido == "SI") {
                        $requerido = '<span class="label label-success">SI</span>';
                    } else {
                        $requerido = '<span class="label label-danger">NO</span>';
                    }
                    ?>
                    <tr>
                        <td class="text-center"><b><?= $formulario->orden ?></b></td>
                        <td class="text-center"><?= $formulario->texto_etiquetas ?></td>
                        <td class="text-center"><?= $formulario->formula ?></td>
                        <td class="text-center"><b><?= $unidad ?></b></td>
                        <td class="text-center"><?= $formulario->tipo_entrada ?></td>
                        <td class="text-center"><?= $requerido ?></td>
                        <td class="text-center">
    <?= Html::a('<span class="fa fa-edit"></span>', 'javascript:void(0);', ['onclick' => 'MostrarFormularioSeccion(' . $idseccion . ', "' . $nombre_seccion . '", ' . $formulario->id_campo . ')', 'title' => "Editar Campo"]) ?>
                        </td>
                    </tr>
    <?php
}
?>
            </tbody>
        </table>
    </div>
</div>