<?php
//use yii\helpers\Html;
use kartik\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\grid\GridView;
use kartik\tabs\TabsX;
?>

    <div class="row">
        <?php echo Html::img('@web/images/sena.png', [
                                'class' => 'pull-left img-responsive', 
                                'height'=>'150px', 
                                'width'=>'150px']); ?><br><br>

        <div class="col-md-6 col-xs-12">
            <br><h5 class="text-center"><b>"COTIZACIÓN DE SERVICIOS DE ENSAYOS DE APTITUD”</b></h5>
            <h5 class="text-center"><b>PARA LAS ÁREAS DE <?php echo $titulo?></b></h5>
        </div>
        <table border="0">
            <tr>
                <td style="width:74%"></td>
                <td>No. Cotización:</td>
                <td align="center"><?php echo $model_cot->idcot?></td>
            </tr>
            <tr>
                <td></td>
                <td>Fecha:</td>
                <td><?php echo $model_cot->fecha?></td>
            </tr>
        </table>           
        <div class="col-md-6 col-xs-12">
            <h5><b>Cliente: </b>
                <?php echo $model_cte->nomcte; ?>
            </h5>
            <h5><b>Contacto: </b></h5>
            <h5><b>Dirección: </b>
                <?php echo $model_cte->dircte; ?>
            </h5><br>
        </div>
    </div>

<div class="panel panel-primary">
        
        <div class="panel-body">

            <table style="width:100%; border-collapse: collapse" border="1">
                <thead>
                    <tr>
                        <th>PARTIDA</th>
                        <th>CANTIDAD</th>
                        <th>ACEPTO</th>
                        <th>DESCRIPCIÓN</th>
                        <th>PRECIO</th>
                        <th>IMPORTE</th>
                    </tr>
                </thead>
                <?php
                    $i = 1;
                    $subtotal = 0;
                    foreach ($arrEnsayos as $row) {
                        echo "<tr>";
                            echo "<td align='center'>".$i."</td>";
                            echo "<td>1</td>";
                            echo "<td></td>";
                            echo "<td>Ensayo de aptitud ".$row['descreferencia']."</td>";
                            echo "<td align='right'>".number_format($row['costo'],2)."</td>";
                            echo "<td align='right'>".number_format($row['costo'],2)."</td>";
                        echo "<tr>";
                        $i++;
                        $subtotal += $row['costo'];
                    }
                ?>
                <tr>
                    <td colspan="4" rowspan="3"><p class=MsoNormal style='text-align:justify'><b><span style='font-size:8.0pt;
                        font-family:Arial'>IMPORTANTE: </span></b></p>

                        <p class=MsoNormal style='text-align:justify'><span style='font-size:8.0pt;
                        font-family:Symbol'></span><span style='font-size:8.0pt;font-family:Arial'>
                        Para confirmar la aceptación de los servicios cotizados, así como las
                        condiciones comerciales firme al final de éstas y envíe por correo electrónico
                        a <b>ventas@sena.mx</b> dentro de la fecha de vigencia de la cotización. </span></p>

                        <p class=MsoNormal style='text-align:justify'><span style='font-size:8.0pt;
                        font-family:Symbol'></span><span style='font-size:8.0pt;font-family:Arial'>
                        Vigencia: 15 días naturales a partir de la fecha de cotización. </span></p>

                        <p class=MsoNormal style='text-align:justify'><span style='font-size:8.0pt;
                        font-family:Symbol'></span><span style='font-size:8.0pt;font-family:Arial'>
                        Para efectos de depósitos bancarios se le pide que haga referencia al número de
                        cotización, sin esta referencia su pago será considerado sin efecto.</span></p></td>
                    <td>Subtotal</td>
                    <td align="right"><?= number_format($subtotal,2)?></td>
                </tr>
                <tr>
                    <td>Iva</td>
                    <td align="right"><?= number_format($subtotal*.16,2)?></td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td align="right"><?= number_format($subtotal + $subtotal * .16,2)?></td>
                </tr>
            </table>   
        </div>
    </div>

    <p class=MsoNormal style='text-align:justify'><b><span style='font-size:8.0pt;
font-family:"Times New Roman"'>1. APLICABILIDAD </span></b></p>

<p class=MsoNormal style='text-align:justify;text-indent:21.3pt'><span
style='font-size:8.0pt;font-family:"Times New Roman"'>1.1. Estas condiciones
comerciales de venta aplican a todas las ventas de MA. GENOVEVA MORENO RAMÍREZ
(SENA). </span></p>

<p class=MsoNormal style='text-align:justify'><b><span style='font-size:8.0pt;
font-family:"Times New Roman"'>2. PRECIOS Y CONDICIONES DE PAGO </span></b></p>

<p class=MsoNormal style='margin-left:35.4pt;text-align:justify;text-indent:
-14.1pt'><span style='font-size:8.0pt;font-family:"Times New Roman"'>2.3 El
precio incluye IVA sólo para el mercado nacional y no considera cualquier otro
impuesto aplicable. En ningún caso el cliente podrá retener el pago de una
factura sin justificación. </span></p>

<p class=MsoNormal style='margin-left:35.4pt;text-align:justify;text-indent:
-14.1pt'><span style='font-size:8.0pt;font-family:"Times New Roman"'>2.4 El
pago se realizará en dólares (USD) para el mercado extranjero de acuerdo con
los precios de la propuesta comercial. En ningœn caso el cliente podrá retener
el pago de una factura sin justificación. </span></p>

<p class=MsoNormal style='margin-left:35.4pt;text-align:justify;text-indent:
-14.1pt'><span style='font-size:8.0pt;font-family:"Times New Roman"'>2.5 En
caso de falta de pago de cualquier factura MA. GENOVEVA MORENO RAMÍREZ (SENA),
se reserva el derecho de modificar unilateralmente las condiciones de pago
acordadas, previamente y podrá tomar las acciones legales pertinentes que le
correspondan. </span></p>

<p class=MsoNormal style='margin-left:35.4pt;text-align:justify;text-indent:
-14.1pt'><span style='font-size:8.0pt;font-family:"Times New Roman"'>2.6 Si el
cliente requiere alguna adenda requiere indicarlo desde el principio de la
solicitud de la cotización, de no hacerlo se realizará un cobro extra por dicha
adenda.</span></p>

<p class=MsoNormal style='text-align:justify;text-indent:21.3pt'><span
style='font-size:8.0pt;font-family:"Times New Roman"'>2.7 Cualquier retraso en
los pagos podrá generar intereses por mora del 3 % mensual. </span></p>

<p class=MsoNormal style='margin-left:21.3pt'><span style='font-size:8.0pt;
font-family:"Times New Roman"'>2.8 Se considerará como inscrito al ensayo de
aptitud una vez que envíe su comprobante de pago al correo electrónico
ventas@sena.mx indicando como referencia el número de la cotización para pronta
identificación del mismo. </span></p>

<p class=MsoNormal><b><span style='font-size:8.0pt;font-family:"Times New Roman"'>3
PROPUESTA </span></b></p>

<p class=MsoNormal style='margin-left:21.3pt'><span style='font-size:8.0pt;
font-family:"Times New Roman"'>3.1 Las propuestas formuladas por MA. GENOVEVA
MORENO RAMÍREZ (SENA), independientemente de la forma en la que se hagan,
estarán sujetas a confirmación y aceptación del cliente mediante la orden de
compra, pedido, contrato o cotización acompañada de las condiciones comerciales
con firma de aceptación.</span></p>

<p class=MsoNormal style='margin-left:21.3pt'><span style='font-size:8.0pt;
font-family:"Times New Roman"'>3.2 No se le proporcionará al cliente el formato
de inscripción al ensayo de aptitud técnica en tanto no acepte la cotización a
través de la firma de las condiciones de aceptación del servicio y éste sea
pagado. </span></p>

<p class=MsoNormal><b><span style='font-size:8.0pt;font-family:"Times New Roman"'>4
PLAZO DE ENTREGA DEL SERVICIO </span></b></p>

<p class=MsoNormal style='margin-left:21.3pt'><span style='font-size:8.0pt;
font-family:"Times New Roman"'>4.1 Los plazos y fechas de entrega serán
exigibles sólo después de la confirmación por escrito de la aceptación de su
orden de compra o pedido, contrato o cotización acompañada de las condiciones
comerciales con firma de aceptación. </span></p>

<p class=MsoNormal style='margin-left:21.3pt'><span style='font-size:8.0pt;
font-family:"Times New Roman"'>4.2 El plazo de entrega se cuenta desde la fecha
de confirmación por escrito de la aceptación de su orden de compra o pedido,
contrato o cotización acompañada de las condiciones comerciales con firma de
aceptación, hasta la fecha de envío del informe. Por lo tanto, el pago
realizado por concepto de anticipos no indica el inicio del periodo estipulado
de entrega. </span></p>

<p class=MsoNormal style='margin-left:21.3pt'><span style='font-size:8.0pt;
font-family:"Times New Roman"'>4.3 MA. GENOVEVA MORENO RAMÍREZ (SENA), no se
hace responsable de retraso en la entrega del informe debido a casos fortuitos
o causa mayor, situaciones imprevistas del laboratorio de referencia o
cualquier análogo o condición fuera del control de MA. GENOVEVA MORENO RAMÍREZ
(SENA), sin embargo, el cumplimiento del envío en la fecha prevista se reserva
el derecho de posponer la fecha de entrega hasta que las condiciones sean
propicias para el cumplimiento. </span></p>

<p class=MsoNormal style='text-indent:21.3pt'><span style='font-size:8.0pt;
font-family:"Times New Roman"'>4.4 MA. GENOVEVA MORENO RAMÍREZ (SENA), no hace
entrega de informes parciales y/o preliminares. </span></p>

<p class=MsoNormal style='margin-left:21.3pt'><span style='font-size:8.0pt;
font-family:"Times New Roman"'>4.5 El envío del informe se establece en el
protocolo y para los clientes en el extranjero su cumplimiento estará en
función de los trámites aduanales, por lo que se podrá modificar la fecha de
entrega sin perjuicio para MA. GENOVEVA MORENO RAMÍREZ (SENA) </span></p>

<p class=MsoNormal><b><span style='font-size:8.0pt;font-family:"Times New Roman"'>5
MODIFICACIÓN DE LA ENTREGA DE SERVICIO </span></b></p>

<p class=MsoNormal style='margin-left:21.3pt'><span style='font-size:8.0pt;
font-family:"Times New Roman"'>5.1 Si el cliente solicita la modificación de su
participación en el ensayo de aptitud, las condiciones de costos y plazo de
entrega podrán variar en proporción al cambio solicitado. </span></p>

<p class=MsoNormal><b><span style='font-size:8.0pt;font-family:"Times New Roman"'>6
LUGAR DE ENTREGA, ENVÍO Y SEGURO DE ENVÍO DEL O LOS ELEMENTO(S) DE ENSAYO </span></b></p>

<p class=MsoNormal style='margin-left:21.3pt'><span style='font-size:8.0pt;
font-family:"Times New Roman"'>6.1 Todos los costos serán por cuenta del
cliente a menos que se haya acordado algo diferente, lo cual deberá estar
confirmado por escrito por parte de MA. GENOVEVA MORENO RAMÍREZ (SENA) mediante
una carta o en el protocolo. </span></p>

<p class=MsoNormal style='margin-left:21.3pt'><span style='font-size:8.0pt;
font-family:"Times New Roman"'>6.2 El cliente es responsable de asegurar el o
los elementos(s) de ensayo con la compañía de mensajería, considerando el costo
del seguro indicado en el protocolo. </span></p>

<p class=MsoNormal><b><span style='font-size:8.0pt;font-family:"Times New Roman"'>7
INSPECCIîN Y ACEPTACIÓN DE ENTREGA </span></b></p>

<p class=MsoNormal style='margin-left:21.3pt'><span style='font-size:8.0pt;
font-family:"Times New Roman"'>7.1 En el momento del envío o recepción es
obligación del cliente inspeccionar el o los elemento(s) de ensayo y
cerciorarse de que son entregados de acuerdo a lo indicado en el protocolo. </span></p>

<p class=MsoNormal><b><span style='font-size:8.0pt;font-family:"Times New Roman"'>8
GARANTÍA DEL SERVICIO </span></b></p>

<p class=MsoNormal style='margin-left:21.3pt'><span style='font-size:8.0pt;
font-family:"Times New Roman"'>8.1 MA. GENOVEVA MORENO RAMÍREZ (SENA), declara
que en el servicio tiene garantía de calidad, sin embargo; en caso de algún
cambio al informe se podrá emitir otro en su modalidad de modificado. </span></p>

<p class=MsoNormal><b><span style='font-size:8.0pt;font-family:"Times New Roman"'>9
DE LA REVISIîN DE DOCUMENTOS DEL ENSAYO DE APTITUD </span></b></p>

<p class=MsoNormal style='margin-left:21.3pt'><span style='font-size:8.0pt;
font-family:"Times New Roman"'>9.1 Es obligación del cliente revisar el
protocolo y el informe y enviar la carta de aceptación del primero para evitar
desacuerdos, así mismo cumplir con sus tiempos, por ningœn motivo el cliente
podrá quedarse por más tiempo el elemento e ensayo o modificar la logística del
ensayo.</span></p>

<p class=MsoNormal><b><span style='font-size:8.0pt;font-family:"Times New Roman"'>10
CANCELACIÓN </span></b></p>

<p class=MsoNormal style='margin-left:21.3pt'><span style='font-size:8.0pt;
font-family:"Times New Roman"'>10.1 Ninguna orden de compra, pedido, contrato o
cotización acompañada de las condiciones comerciales con firma de aceptación,
podrá ser cancelada por el cliente una vez notificada la confirmación de
participación a través del formato de inscripción. </span></p>

<p class=MsoNormal><b><span style='font-size:8.0pt;font-family:"Times New Roman"'>11
PENALIZACIÓN </span></b></p>

<p class=MsoNormal style='margin-left:21.3pt'><span style='font-size:8.0pt;
font-family:"Times New Roman"'>11.1 Si una vez inscrito al ensayo de aptitud el
laboratorio decide cancelar su participación antes del inicio del mismo, tendrá
una penalización del 30 % del costo total del ensayo y se reembolsará solo la
cantidad restante. </span></p>

<p class=MsoNormal style='text-indent:21.3pt'><span style='font-size:8.0pt;
font-family:"Times New Roman"'>11.2 Una vez iniciado el ensayo y en el caso de
que el laboratorio participante deseé cancelar su participación no se hará
reembolso alguno. </span></p>

<p class=MsoNormal><b><span style='font-size:8.0pt;font-family:"Times New Roman"'>12
TRANSFERENCIA DE RIESGOS </span></b></p>

<p class=MsoNormal style='margin-left:21.3pt'><span style='font-size:8.0pt;
font-family:"Times New Roman"'>12.1 La transferencia de riesgo al cliente será
efectiva en el momento en el que los elementos de ensayo sean entregados,
independientemente del destino final a menos que el transporte de estos sea
realizado por personal de MA. GENOVEVA MORENO RAMÍREZ (SENA), y entonces será
efectiva al momento de la entrega. </span></p>

<p class=MsoNormal><b><span style='font-size:8.0pt;font-family:"Times New Roman"'>13
DISPOSICIONES GENERALES </span></b></p>

<p class=MsoNormal style='margin-left:21.3pt'><span style='font-size:8.0pt;
font-family:"Times New Roman"'>13.1 Las presentes condiciones contienen la
totalidad de la intensión de venta y compra entre las partes y sólo podrá ser
modificado por escrito y aceptado por ambas partes. La tolerancia de las partes
para el cabal cumplimiento de los dispuesto en las presentes declaraciones,
constituyen mera liberalidad y no implican novación o modificación de los
términos o condiciones que se acuerden. </span></p>

<p class=MsoNormal style='margin-left:21.3pt'><span style='font-size:8.0pt;
font-family:"Times New Roman"'>13.2 Si por alguna razón un cliente tiene
adeudos anteriores y solicitará un nuevo servicio, este le será cotizado y solo
se le podrá proporcionar si cubre el adeudo pendiente en su totalidad. </span></p>

<p class=MsoNormal><b><span style='font-size:8.0pt;font-family:"Times New Roman"'>14
JURISDICCIÓN Y LEY </span></b></p>

<p class=MsoNormal style='margin-left:21.3pt'><span style='font-size:8.0pt;
font-family:"Times New Roman"'>14.1 La interpretación y cumplimiento de estas
condiciones están sujetas a las leyes de los estados Unidos mexicanos.
Cualquier controversia que surja con motivo de estas condiciones ser‡ sometida
a los tribunales competentes del Estado de Querétaro, independientemente de
cualquier otro fuero que pudiese corresponderles en razón a su domicilio
presente o futuro.</span></p>

<p class=MsoNormal style='margin-left:35.4pt;text-align:justify;text-indent:
35.4pt'><span style='font-size:8.0pt'>&nbsp;</span></p>


