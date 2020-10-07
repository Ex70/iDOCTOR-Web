<script language="javascript">
$('#titulo').html('Seleccionar tipo de orden');

$(document).ready(function () {
     $('.equipocheck').change(function() {
     	ee = $("#equipoenciende").val();
     	em = $("#equipomojado").val();

     	if ((ee=="SI") && (em=="NO"))
     		 $(".checklist").show(1000);
     	else
     		 $(".checklist").hide(1000);
      });
  
});
 

</script>
<div align="center" class="demo">
	<?php echo form_open("equipos/recibir"); ?>
<table class="buscar" style="height:350px;">

	<?php 
  $o = array("SI"=>"Si","NO"=>"No","NV"=>"No se pudo verificar");
 ?>
 <tr><td><h3>El equipo enciende</h3></td><td><?php 
   $opciones = array("SI"=>"Si","NO"=>"No");
   echo form_dropdown("equipo_enciende",$opciones,"SI","id='equipoenciende' class='equipocheck'");

 ?></td></tr>
<tr><td><h3>El equipo se recibe mojado</h3></td><td><?php 
   $opciones = array("SI"=>"Si","NO"=>"No");
   echo form_dropdown("equipo_mojado",$opciones,"NO","id='equipomojado' class='equipocheck'");


  $cl="49cdd1";

 ?></td></tr>



<tr class="checklist"><td style="background-color:#<?php echo $cl;?>">a. Sensor de centro de carga activado.</td><td style="background-color:#<?php echo $cl;?>"><?php echo form_dropdown("chlst_rec_sensor_centro",$o,"NO"); ?></td></tr>
<tr class="checklist"><td>b. Sensor de humedad de entrada de auriculares activado. </td><td><?php echo form_dropdown("chlst_rec_sensor_humedad",$o,"NO"); ?></td></tr>
<tr class="checklist"><td style="background-color:#<?php echo $cl;?>">c. Falla recepci&oacute;n de carga de corriente. </td><td style="background-color:#<?php echo $cl;?>"><?php echo form_dropdown("chlst_rec_falla_carga",$o,"NO"); ?></td></tr>
<tr class="checklist"><td>d. Falla detecci&oacute;n en computadora. </td><td><?php echo form_dropdown("chlst_rec_falla_deteccion",$o,"NO"); ?></td></tr>
<tr class="checklist"><td style="background-color:#<?php echo $cl;?>">e. Falla recepci&oacute;n de se&ntilde;al telef&oacute;nica. </td><td style="background-color:#<?php echo $cl;?>"><?php echo form_dropdown("chlst_rec_falla_senal",$o,"NO"); ?></td></tr>
<tr class="checklist"><td>f.	Falla recepci&oacute;n de se&ntilde;al wifi y bluetooth. </td><td><?php echo form_dropdown("chlst_rec_falla_wifi",$o,"NO"); ?></td></tr>
<tr class="checklist"><td style="background-color:#<?php echo $cl;?>">g. Falla visualizaci&oacute;n correcta del pantalla. </td><td style="background-color:#<?php echo $cl;?>"><?php echo form_dropdown("chlst_rec_falla_visualizacion",$o,"NO"); ?></td></tr>
<tr class="checklist"><td>h. Falla detecci&oacute;n de comandos de touch.</td><td><?php echo form_dropdown("chlst_rec_falla_com_touch",$o,"NO"); ?></td></tr>
<tr class="checklist"><td style="background-color:#<?php echo $cl;?>">i.	Falla detecci&oacute;n de comandos rueda. </td><td style="background-color:#<?php echo $cl;?>"><?php echo form_dropdown("chlst_rec_falla_com_rueda",$o,"NO"); ?></td></tr>
<tr class="checklist"><td>j.	Falla funci&oacute;n de la bocina altavoz. </td><td><?php echo form_dropdown("chlst_rec_func_boc_altavoz",$o,"NO"); ?></td></tr>
<tr class="checklist"><td style="background-color:#<?php echo $cl;?>">k. Falla funci&oacute;n de la bocina auricular. </td><td style="background-color:#<?php echo $cl;?>"><?php echo form_dropdown("chlst_rec_func_boc_auricular",$o,"NO"); ?></td></tr>
<tr class="checklist"><td>l.	Falla funci&oacute;n de la entrada de auriculares. </td><td><?php echo form_dropdown("chlst_rec_func_ent_auriculares",$o,"NO"); ?></td></tr>
<tr class="checklist"><td style="background-color:#<?php echo $cl;?>">m. Falla funci&oacute;n del micr&oacute;fono.</td><td style="background-color:#<?php echo $cl;?>"><?php echo form_dropdown("chlst_rec_func_microfono",$o,"NO"); ?></td></tr>
<tr class="checklist"><td>n. Falla funci&oacute;n del bot&oacute;n home. </td><td><?php echo form_dropdown("chlst_rec_func_bot_home",$o,"NO"); ?></td></tr>
<tr class="checklist"><td style="background-color:#<?php echo $cl;?>">o. Falla funci&oacute;n del bot&oacute;n de encendido o hold. </td><td style="background-color:#<?php echo $cl;?>"><?php echo form_dropdown("chlst_rec_func_bot_encendido",$o,"NO"); ?></td></tr>
<tr class="checklist"><td>p. Falla funci&oacute;n del bot&oacute;n de silencio. </td><td><?php echo form_dropdown("chlst_rec_func_bot_silencio",$o,"NO"); ?></td></tr>
<tr class="checklist"><td style="background-color:#<?php echo $cl;?>">q. Falla funci&oacute;n de los botones de volumen. </td><td style="background-color:#<?php echo $cl;?>"><?php echo form_dropdown("chlst_rec_func_bot_volumen",$o,"NO"); ?></td></tr>
<tr class="checklist"><td>r.	Falla bandeja SIM.</td><td><?php echo form_dropdown("chlst_rec_falla_bandeja_sim",$o,"NO"); ?></td></tr>
<tr><td colspan="2">
  <div style="height:20px;"></div>
  Otras observaciones<br>
  <?php 
  $d = array("name"=>"otras_observaciones_rec","cols"=>"40","rows"=>"3","style"=>"width:100%");
  echo form_textarea($d); ?>
</td></tr>
<tr><td style="text-align:center;height:80px;"><?php echo form_submit("enviar","Enviar"); ?></td></tr>

</table>
<?php echo form_close(); ?>
</div>

 
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
   
  