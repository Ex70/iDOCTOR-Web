
<?php 
$aid = array("id"=>"form1");

echo form_open('equipos/entregar',$aid); ?>
<!--<table  class="tablaiframe2">
<tr><td colspan="4" style="height:10px;"></td></tr>
<tr><td colspan="4" align="center"><h2>Entrega de equipo</h2></td></tr>
</table>-->
<div style="height:430px;">
<div id="accordion">

<h3><a href="#">Datos de la Entrega</a></h3>
<div style="font-size:0.8em;">
<table class="tablaiframe2">
  <tr><td>Forma de pago</td>
    <td>

      <?php 
      $opciones = array("Efectivo"=>"Efectivo",
        "Tarjeta de crédito/débito"=>"Tarjeta de crédito/débito",
        "Transferencia bancaria"=>"Transferencia bancaria",
        "Cheque"=>"Cheque");
      echo form_dropdown("forma_de_pago",$opciones,"");
      ?>
     </td>
  </tr>
  <tr>
  	<td>Calificaci&oacute;n del servicio</td>
  	
  	<td><?php
  		  $calif = array(""=>"Especificar",
  		  "1"=>"1",
  		  "2"=>"2",
  		  "3"=>"3",
  		  "4"=>"4",
  		  "5"=>"5"
		  ); 
  	      echo form_dropdown("calificacion_servicio",$calif,"","id='calificacion'");
		  echo form_hidden("equipo_id",$equipo_id);
  	      ?>
  	      </td>
</tr>
<tr>
  	<td>N&uacute;mero de remisi&oacute;n</td>
  	<td><?php
  		   //echo form_input("numero_remision","");
    echo "Nota: El n&uacute;mero de remisi&oacute;n se asigna autom&aacute;ticamente al imprimir la nota.";
  		   ?></td>
  </tr>
 </table>

  <table width="100%" border="0">
    <tr>
      <td width="20%">Diagn&oacute;stico:</td>
      <td width="80%"><strong><?php echo $equipo['diagnostico']; ?></strong></td>
    </tr>
  </table>
  
<?php 
   echo "<table class='servicios'>";
    
       echo "<tr>";
     echo "<th width='15%'>Fecha</th>";
     echo "<th width='40%'>Descripci&oacute;n</th>";
     echo "<th width='20%'>Costo</th>";
     echo "<th>Descuento</th>";
       echo "<th>Subtotal</th>";
       echo "</tr>";    

  $total = 0;
         $cl = "#ffffff";
 foreach ($servicios as $servicio) {
       echo "<tr>";
     echo "<td width='15%' style='background-color:" . $cl . "'>" . $servicio['fecha']  . "</td>";
    // echo "<td><a href='/index.php/piezas/modificardeequipo/" . $servicio['id'] ."?keepThis=true&TB_iframe=true&height=300&width=700' title='Modificar' class='thickbox'>" . $servicio['servicio_id'] . "</a></td>";
     echo "<td style='background-color:" . $cl . "'>" . $servicio['descripcion'] . "</td>"; 
     echo "<td align='right' style='background-color:" . $cl . "'>" . number_format($servicio['costo'], 2, '.', ',') . "</td>";
     echo "<td align='right' style='background-color:" . $cl . "'>" . $servicio['descuento'] . "</td>";
     echo "<td align='right' style='background-color:" . $cl . "'>" .  number_format($servicio['subtotal'], 2, '.', ',') . "</td>";
     echo "</tr>";
     $total += $servicio['subtotal'];
      if ($cl=="#ffffff") $cl="#49cdd1"; else $cl="#ffffff";
      }     
    echo "<td colspan=3></td><td align=right>Total:</td><td  align='right'>$" . number_format($total, 2, '.', ',') . "</td>";
    echo "</table>";
?>  
  

</div>
<h3><a href="#">Actualizar datos del cliente</a></h3>
<div  style="font-size:0.8em;">
 <table> 
  <tr>
  <td>Nombre</td>
  <td><?php
  echo form_hidden("cliente_id", $cliente['id']); 
  echo form_input("nombre",$cliente['nombre']); ?></td>
  </tr>
  <tr>
  <td>Tel&eacute;fono</td>
  <td><?php echo form_input("telefono1",$cliente['telefono1']); ?></td>
  </tr>
  <tr>
  <td>M&oacute;vil</td>
  <td><?php echo form_input("telefono2",$cliente['telefono2']); ?></td>
  </tr>
  <tr>
  <td>Direcci&oacute;n</td>
  <td><?php echo form_input("direccion",$cliente['direccion']); ?></td>
  </tr>
<tr>
  <td>Colonia</td>
  <td><?php echo form_input("colonia",$cliente['colonia']); ?></td>
  </tr>
<tr>
  <td>C.P.</td>
  <td><?php echo form_input("cp",$cliente['cp']); ?></td>
  </tr>
<tr>
  <td>Ciudad</td>
  <td><?php echo form_input("ciudad",$cliente['ciudad']); ?></td>
  </tr>
<tr>
  <td>Estado</td>
  <td><?php echo form_input("estado",$cliente['estado']); ?></td>
  </tr>
  <tr>
  <td>Correo</td>
  <td><?php echo form_input("correo_electronico",$cliente['correo_electronico']); ?></td>
  </tr>


 </table>
 </div>
 
 
<h3><a href="#">Checklist de entrega</a></h3>
<div style="font-size:0.6em;">
<?php $opciones=  array("SI"=>"Si","NO"=>"No","NV"=>"No pudo verif.");
 ?>
<table width="100%" border="0">
<tr><td>&nbsp;a. Sensor de centro de carga activado.</td><td><?php echo form_dropdown("chlst_ent_sensor_centro",$opciones,"NO"); ?></td>
<td>&nbsp;j.  Falla funci&oacute;n de la bocina altavoz.</td><td><?php echo form_dropdown("chlst_ent_func_boc_altavoz",$opciones,"NO"); ?></td></tr>
<tr><td>&nbsp;b. Sensor de humedad de entrada de auriculares activado.</td><td><?php echo form_dropdown("chlst_ent_sensor_humedad",$opciones,"NO"); ?></td>
<td>&nbsp;k. Falla funci&oacute;n de la bocina auricular.</td><td><?php echo form_dropdown("chlst_ent_func_boc_auricular",$opciones,"NO"); ?></td></tr>
<tr><td>&nbsp;c. Falla recepci&oacute;n de carga de corriente.</td><td><?php echo form_dropdown("chlst_ent_falla_carga",$opciones,"NO"); ?></td>
<td>&nbsp;l.  Falla funci&oacute;n de la entrada de auriculares.</td><td><?php echo form_dropdown("chlst_ent_func_ent_auriculares",$opciones,"NO"); ?></td></tr>
<tr><td>&nbsp;d. Falla detecci&oacute;n en computadora.</td><td><?php echo form_dropdown("chlst_ent_falla_deteccion",$opciones,"NO"); ?></td>
<td>&nbsp;m. Falla funci&oacute;n del micr&oacute;fono.</td><td><?php echo form_dropdown("chlst_ent_func_microfono",$opciones,"NO"); ?></td></tr>
<tr><td>&nbsp;e. Falla recepci&oacute;n de se&ntilde;al telef&oacute;nica.</td><td><?php echo form_dropdown("chlst_ent_falla_senal",$opciones,"NO"); ?></td>
<td>&nbsp;n. Falla funci&oacute;n del bot&oacute;n home.</td><td><?php echo form_dropdown("chlst_ent_func_bot_home",$opciones,"NO"); ?></td></tr>
<tr><td>&nbsp;f.  Falla recepci&oacute;n de se&ntilde;al wifi y bluetooth.</td><td><?php echo form_dropdown("chlst_ent_falla_wifi",$opciones,"NO"); ?></td>
<td>&nbsp;o. Falla funci&oacute;n del bot&oacute;n de encendido o hold.</td><td><?php echo form_dropdown("chlst_ent_func_bot_encendido",$opciones,"NO"); ?></td></tr>

<tr><td>&nbsp;g. Falla visualizaci&oacute;n correcta del pantalla.</td><td><?php echo form_dropdown("chlst_ent_falla_visualizacion",$opciones,"NO"); ?></td>
<td>&nbsp;p. Falla funci&oacute;n del bot&oacute;n de silencio.</td><td><?php echo form_dropdown("chlst_ent_func_bot_silencio",$opciones,"NO"); ?></td></tr>
<tr><td>&nbsp;h. Falla detecci&oacute;n de comandos de touch.</td><td><?php echo form_dropdown("chlst_ent_falla_com_touch",$opciones,"NO"); ?></td>
<td>&nbsp;q. Falla funci&oacute;n de los botones de volumen.</td><td><?php echo form_dropdown("chlst_ent_func_bot_volumen",$opciones,"NO"); ?></td></tr>
<tr><td>&nbsp;i.  Falla detecci&oacute;n de comandos rueda.</td><td><?php echo form_dropdown("chlst_ent_falla_com_rueda",$opciones,"NO"); ?></td>
<td>&nbsp;r.  Falla bandeja SIM.</td><td><?php echo form_dropdown("chlst_ent_falla_bandeja_sim",$opciones,"NO"); ?></td></tr>


</table>  

<?php //echo form_checkbox("checklist","S");?>
 </div>
</div><!-- fin del acordion -->
</div><!-- fin div define height -->
 
 <script language="JavaScript">
 	function formsubmit() {
       cal = $("#calificacion").val();
       if (cal=="")
          alert("Por favor indica la calificación del servicio.");
       else
       document.getElementById("form1").submit();

// 		   alert('Por favor revisa los elementos del checklist y verifica la casilla.');
 	}
 </script>
 <div class="ui-widget-content" style="height:80px;" align="center"><?php //echo form_submit("submit","Enviar"); ?>
 	<div class="demo"><input type='button' onClick="formsubmit()" value="Enviar"></demo>
 </div>
 <?php echo form_close();?>
 