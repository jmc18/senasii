<?php

use yii\helpers\Html;
use app\modules\catalogos\models\areas\DetalleFormularioSeccion;

$this->title = "Configurar Formulario Para: " . $model_area->descarea;
$this->params['breadcrumbs'][] = ['label' => 'Áreas', 'url' => ['/catalogos/areas']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title">Configuración de Formulario para el Área: <b class="text-danger"><?= $model_area->descarea ?></b></h3>
    </div>
    <div class="panel-body">
        <div class="col-md-6 col-sm-12 col-xs-12 table-responsive">
            <?= Html::a("Agregar Nueva Sección", ["areas/agregar-seccion-area", "idarea" => $idarea, "nomArea" => $model_area->descarea], ["class" => "btn btn-warning btn-block"]) ?>
            <table class="table table-condensed table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">Orden</th>
                        <th class="text-center">Concepto de la Sección</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($secciones_area as $secciones) {
                        ?>
                        <tr>
                            <td class="text-center"><b><?= $secciones->orden ?></b></td>
                            <td class="text-center"><b><?= $secciones->nombre ?></b></td>
                            <td class="text-center">
                                <?= Html::a('<span class="fa fa-plus text-success"></span>', 'javascript:void(0);', ['onclick' => 'GetCamposSeccion(' . $secciones->idseccion . ', "' . $secciones->nombre . '")']) ?>
                                <?= Html::a('<span class="fa fa-edit"></span>', ["editar-seccion-area", "idseccion" => $secciones->idseccion, "idarea" => $secciones->idarea]) ?>
                                <?php
                                    $cont_form = DetalleFormularioSeccion::find()
                                            ->where(["idseccion" => $secciones->idseccion])
                                            ->count();
                                    if ($cont_form == 0)
                                        echo Html::a('<span class="fa fa-trash text-danger"></span>', ["eliminar-seccion-area", "idseccion" => $secciones->idseccion, "idarea" => $secciones->idarea], ["id" => "Link_" . $secciones->idseccion]);
                                    ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12" id="table_post"></div>
    </div>
</div>
<div id="modal_post"></div>
<script>
    function GetCamposSeccion(IdSeccion, nomSeccion) {
        $.ajax({
            url: 'obtener-campos-seccion',
            type: 'get',
            data: "id=" + IdSeccion + "&nomSeccion=" + nomSeccion,
            beforeSend: function () {

            },
            success: function (response) {
                $("#table_post").html(response);
            }
        });
    }

    function MostrarFormularioSeccion(IdSeccion, nomSeccion, idcampo) {
        $.ajax({
            url: "formulario-campo-resultados",
            type: 'get',
            data: "idseccion=" + IdSeccion + "&nombre_seccion=" + nomSeccion + "&idCampo=" + idcampo,
            beforeSend: function () {

            },
            success: function (response) {
                $("#modal_post").html(response);
                $("#modal_formulario_campo").modal('show');
            }
        });
    }
    
    function MostrarFormularioSeccionInsert(IdSeccion, nomSeccion){
        $.ajax({
            url: "agregar-campo-formulario-resultados",
            type: 'get',
            data: "idseccion=" + IdSeccion + "&nombre_seccion=" + nomSeccion,
            beforeSend: function () {

            },
            success: function (response) {
                $("#modal_post").html(response);
                $("#modal_formulario_campo_insert").modal('show');
            }
        });
    }

    function enviar(form, data, hasError) {
        if (!hasError) {
            str = $("#form").serialize();
            $.ajax({
                type: "POST",
                url: "registro/nivel",
                data: str,
                beforeSend: function () {
                    $("#login").attr("disabled", true);
                },
                success: function (data) {
                    document.getElementById("respuesta").innerHTML = data;
                    $("#login").attr("disabled", false);
                },
                error: function (data) { // if error occured
                    document.getElementById("respuesta").innerHTML = "Error occured.please try again" + data;
                    $("#login").attr("disabled", false);
                }
            });
        }
        return false;
    }

    function EditarCampoFormulario(IdSeccion, nomSeccion) {

        if ($("#detalleformularioseccion-req_bol").is(":checked")) {
            $("#bol_requerido").val("SI");
        } else {
            $("#bol_requerido").val("NO");
        }

        $.ajax({
            url: "editar-campo-formulario",
            type: "POST",
            data: $("#form_EditarCampoFormulario").serialize(),
            beforeSend: function () {

            },
            success: function (response) {
                $("#modal_formulario_campo").modal("hide");
                GetCamposSeccion(IdSeccion, nomSeccion);
            }
        });
    }
    
    function RegistrarCampoFormulario(IdSeccion, nomSeccion) {

        if ($("#detalleformularioseccion-req_bol").is(":checked")) {
            $("#bol_requerido").val("SI");
        } else {
            $("#bol_requerido").val("NO");
        }

        $.ajax({
            url: "agregar-campo-formulario-resultados",
            type: "POST",
            data: $("#form_RegistrarCampoFormulario").serialize(),
            beforeSend: function () {

            },
            success: function (response) {
                $("#modal_formulario_campo_insert").modal("hide");
                var arrResponse = response.split(",");
                if(arrResponse[0] == "No"){
                    alert("Ocurrio un error al registrar el campo");
                } else {
                    $("#Link_" + arrResponse[2]).remove();
                    GetCamposSeccion(IdSeccion, nomSeccion);
                }
            }
        });
    }
</script>

