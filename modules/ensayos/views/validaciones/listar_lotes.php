<?php
include_once '../controlador/validar-sesiones.php';
include_once '../controlador/validar_permiso.php';
include_once '../modelo/conexion.php';
include_once '../modelo/lote.php';
$modelo_lote = new lote();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>SILAB | SIASA</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="../css/te/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="../css/te/_all-skins.min.css">
        <!-- iCheck for checkboxes and radio inputs -->
        <link rel="stylesheet" href="../plugins/iCheck/all.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="../css/te/iCheck/flat/blue.css">
        <!-- Morris chart -->   
        <link rel="stylesheet" href="../css/te/morris.css">
        <!-- jvectormap -->
        <link rel="stylesheet" href="../css/te/jquery-jvectormap-1.2.2.css">

        <!-- Bootstrap Color Picker -->
        <link rel="stylesheet" href="../plugins/colorpicker/bootstrap-colorpicker.min.css">
        <!-- Bootstrap time Picker -->
        <link rel="stxylesheet" href="../plugins/timepicker/bootstrap-timepicker.min.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="../plugins/select2/select2.min.css">


        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
        <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
    </head>
    <body class="hold-transition skin-blue sidebar-mini fixed"  data-spy="scroll" data-target="#scrollspy">
        <div class="wrapper">
            <?php include_once '../vista/header.php'; ?>
            <!-- Left side column. contains the logo and sidebar -->
            <?php include_once '../vista/side_bar_permisos.php'; ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <?php
                if (isset($_GET['r'])) {
                    ?>
                    <div class="callout callout-danger">
                        <h4>Acceso Denegado</h4>
                        <p><?= $_GET['r'] ?></p>
                    </div>
                    <?php
                }
                ?>
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Listado de Lotes
                        <small>SIASA</small>
                    </h1>
                </section>

                <!-- Main content -->
                <section class="content" id="contenedor_gral" >
                    <form id="form_recepcion" name="form_recepcion" onsubmit="agregar_lote(); return false;">
                        <div class="box box-default">
                            <!--<div class="box-header with-border pull-right">
                                <button type="submit" id="btnAgregarLote" name="btnAgregarLote" class="btn btn-primary" ><i class="fa fa-plus-circle"></i> Agregar Lote</button>
                            </div>-->
                            <!-- /.box-header -->
                            

                            <div class="box">
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <table id="tblClientes" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th style="width: 5px">Acciones</th>
                                                <th>No. Lote</th>
                                                <th>Cliente</th>
                                                <th>Fecha Rec.</th>
                                                <th>Entregó</th>
                                                <th>Estatus</th>
                                                <th style="width: 10px">Validar</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbLotes">
                                            <?php
                                            $noRows = 0;
                                            $rs = $modelo_lote->listar_lotes();
                                            while (!$rs->EOF) {
                                                $tag = ( $rs->fields[7] != null ) ? 'success' : 'warning';
                                                $msj = ( $rs->fields[7] != null ) ? 'Terminado' : 'Pendiente';

                                                $icon = (!is_null($rs->fields[8]) ) ? 'fa-check-square-o' : 'fa-remove';
                                                $strval = (!is_null($rs->fields[8]) ) ? 'Lote Validado' : 'Lote sin Validar';
                                                ?>
                                                <tr id="tr-<?php echo $rs->fields[0] ?>">
                                                    <td><a href="javascript:void(0);" onclick="consultar_lote(<?php echo $rs->fields[0]; ?>)" title="Editar Lote"><i class="fa fa-edit"></i></a>&nbsp;
                                                        <a href="../formatos-pdf/recepcion.php?idlote=<?php echo $rs->fields[0] ?>" target="_blank" title="Imprimir Reporte"><i class="fa fa-print"></i></a></td>
                                                    <td class="text-center">
                                                        <?php echo $rs->fields[0]; ?>
                                                    </td>
                                                    <td><?php echo utf8_decode($rs->fields[10]) ?></td>
                                                    <td><?php echo utf8_decode($rs->fields[1]) ?></td>
                                                    <td><?php echo utf8_decode($rs->fields[3]) ?></td>
                                                    <td><span class="label label-<?php echo $tag ?>"><?php echo $msj ?></span></td>
                                                    <td><a href="javascript:void(0);" onclick="valida_lote('<?php echo $rs->fields[0] ?>')"><i class="icon fa <?php echo $icon ?>" title="<?php echo $strval ?>"></i></a></td>
                                                </tr>
                                                <?php
                                                $rs->MoveNext();
                                                $noRows++;
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                    </form>
                </section>
                <!-- End Main content-->
            </div>
            <div id="ModalCargando" class="modal fade" data-keyboard="false" data-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Cargando...</h4>
                        </div>
                        <div class="modal-body">
                            <p>Espere un momento, ya que los datos están siendo procesados.</p>
                            <div class="progress progress-striped active">
                                <div class="bar progress-bar progress-bar-success" style="width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="respuesta_post"></div>
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 1.1
                </div>
                <strong>Copyright &copy; 2017 <a href="#">SIASA - SERVICIO INTEGRAL A LA AGROINDUSTRIA S.A. DE C.V</a>.</strong> Todos los Derechos Reservados.
            </footer>

            <!-- Control Sidebar -->

            <!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed
                 immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper -->

        <!-- jQuery 2.2.3 -->
        <script src="../js/te/jquery-2.2.3.min.js"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
                                                    //$.widget.bridge('uibutton', $.ui.button);
        </script>
        <!-- Bootstrap 3.3.6 -->
        <script src="../js/bootstrap.min.js"></script>
        <script src="../plugins/select2/select2.full.min.js"></script>
        <!-- morrisris.js charts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="../js/te/morris.min.js"></script>
        <!-- Sparkline -->
        <script src="../js/te/jquery.sparkline.min.js"></script>
        <!-- jvectormap -->
        <script src="../js/te/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="../js/te/jquery-jvectormap-world-mill-en.js"></script>
        <!-- jQuery Knob Chart -->
        <script src="../js/te/jquery.knob.js"></script>
        <!-- daterangepicker -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
        <!--<script src="../../js/te/daterangepicker.js"></script>-->
        <!-- datepicker -->
        <script src="../plugins/datepicker/bootstrap-datepicker.js"></script>
        <!-- bootstrap color picker -->
        <script src="../plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
        <!-- bootstrap time picker -->
        <script src="../plugins/timepicker/bootstrap-timepicker.min.js"></script>

        <!-- Bootstrap WYSIHTML5 -->
        <script src="../js/te/bootstrap3-wysihtml5.all.min.js"></script>
        <!-- Slimscroll -->
        <script src="../js/te/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="../js/te/fastclick.min.js"></script>
        <!-- AdminLTE App -->
        <script src="../js/te/app.min.js"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="../js/te/dashboard.js"></script>
        <!-- AdminLTE for demo purposes 
        <script src="../../js/te/demo.js"></script>-->
        <script src="../js/recepcion.js"></script>
        <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
        <script src="../plugins/iCheck/icheck.min.js"></script>
        <!-- bootstrap datepicker -->
        <script src="../plugins/datepicker/bootstrap-datepicker.js"></script>

        <script>
                                                    $("#tblClientes").DataTable(
                                                            {
                                                                "lengthMenu": [[7, 15, 20], [7, 15, 20]]
                                                            });

                                                    var btnG = document.getElementById('btnAgregarLote');
                                                    btnG.addEventListener('click', function () {
                                                        location.href = 'recepcion.php';
                                                    }, false);

                                                    $("#msjAlert").hide();
                                                    $("#msjDanger").hide();
        </script>
        <?php
        if (isset($categoria_open)) {
            ?>
            <script>
                $("#list_permiso_" + <?= $categoria_open ?>).addClass('active');
            </script>
            <?php
        }
        ?>
    </body>
</html>
