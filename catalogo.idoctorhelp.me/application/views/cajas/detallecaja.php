<script language="javascript">
$('#titulo').html('Detalle de Caja para Guardar Dispositivo');
</script>
<?php $this->load->helper('form'); 
 
?>
<?php echo form_open('cajas/guardar'); ?>

<table  class="tabla1">
  
  <tr style="height:100px;">
  <td>Descripci&oacute;n:</td>
    <td><?php //echo form_input("estatus",(isset($estatus) ? $estatus : "")); 

	   echo form_input("descripcion",$descripcion);
	   
	   if ($id!="") { 
	       echo form_hidden("accion", "u");
		   echo form_hidden("id",$id);
	   }
		 else {
			echo form_hidden("accion", "i");
			 
		 }

	?></td>
  </tr>
  <tr style="height:30px;">
  <td>Localizaci&oacute;n:</td>
  <td><?php echo form_input("localizacion",$localizacion); ?></td>
  </tr>
  <?php if ($codigoqr!="") {
  	?>
  <tr>
  	<td>C&oacute;digo QR para localización</td>
  	<td><img src="<?php echo $codigoqr; ?>"></td>
  </tr>
  <?php } ?>
  
   <tr>
  	
    <td colspan="2"><div align="center"><?php echo form_submit("submit","Enviar"); ?></div></td>
  </tr>
</table>

<?php echo form_close(); 

?>

