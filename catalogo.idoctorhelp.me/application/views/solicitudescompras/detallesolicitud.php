<script language="javascript">
$("a#regresar").attr('href', '/index.php/solicitudescompras/index');
$('#titulo').html('Solicitud de Compra');
</script>
<?php $this->load->helper('form'); 
   
?>
<?php echo form_open('solicitudescompras/guardar'); ?>
<table  class="tabla1">
  <tr>
    <?php
    if (isset($id)) {
		//echo "<tr><td colspan=2>Id: " . $id . "</td></tr>";
	}
  ?>
    <td width="50%">Nombre</td>
    <td width="50%"><?php  

	   echo form_input("nombre",$nombre);
	   
	   if ($id!="") {
	       echo form_hidden("accion", "u");
		   echo form_hidden("id",$id);
	   }  
		 else
			echo form_hidden("accion", "i");

	?></td>
  </tr>
  <tr>
    <td width="50%">Categor&iacute;a</td>
    <td width="50%"><?php  
	   echo form_input("categoria",$categoria);
	   	?></td>
  </tr>
  <tr>
    <td colspan="2">Asunto<br />
    <?php
	$data = array(
              'name'        => 'asunto',
              'id'          => 'asunto',
              'value'       => (isset($asunto) ? $asunto : ""),
              'rows'   => '7',
              'cols'        => '30',
              'style'       => 'width:100%',
            );

echo form_textarea($data);
	?>
    
    </td>
 </tr>
<tr>
<td>Tel&eacute;fono</td>
<td><?php echo form_input("telefono", $telefono); ?></td>
</tr>

<tr>
<td>Correo electr&oacute;nico</td>
<td><?php echo form_input("correo_electronico", $correo_electronico); ?></td>
</tr>

<tr>
<td>Checado</td>
<td><?php echo form_dropdown("checado", array("N"=>"No","S"=>"Si"),$checado); ?></td>
</tr>

    <td>&nbsp;</td>
    <td><?php echo form_submit("submit","Enviar"); ?></td>
  </tr>
</table>

<?php echo form_close(); 

?>

