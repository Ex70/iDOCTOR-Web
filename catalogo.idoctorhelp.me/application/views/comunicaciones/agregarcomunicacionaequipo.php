<?php $this->load->helper('form'); 
?>


<?php echo form_open('comunicaciones/guardaraequipo');   
			    echo form_hidden("accion", "i");
				echo form_hidden("equipo_id",  $this->uri->segment(3));
				echo form_hidden("usuario_id",$usuario_id);
?>
<table  class="tablaiframe">
	<tr><td colspan="2" style="height:10px;"></td></tr>
  <tr>
    <td colspan="2" align="center"><h3>Agregar comunicaci&oacute;n</h3></td>
  </tr>
 <tr><td>Fecha</td><td><?php echo $fecha; ?></td></tr>
 <tr><td>Asunto</td><td><?php 
     $d=array("name"=>"asunto","value"=>$asunto,"size"=>"50");
    echo form_input($d); ?></td></tr>
 <tr><td>Notas</td><td>
 <?php
    $d = array("name"=>"notas","rows"=>"4","cols"=>"30","style"=>"width:100%","value"=>$notas);
	echo form_textarea($d);
 ?>
 </td></tr>
 
      <tr>
    
    <td colspan="2" class="demo" align="center"><?php echo form_submit("submit","Enviar"); ?></td>
  </tr>  
</table>

<?php echo form_close(); 

?>
<div align="center">
<table style="border-width:1px solid;border-color444;width:700px;background-color: #eee;font-size:0.8em;">
<tr>
<td rowspan="3">
  <img src="/images/ico_usuarios.gif">
</td> 
<td>Cliente:</td><td><?php echo $cliente['nombre']; ?></td> 
</tr> 

<tr>
<td>Tel&eacute;fono:</td><td><?php echo $cliente['telefono1'] . "  " . $cliente['telefono2']; ?></td> 
</tr>
<tr>
<td>Correo electr&oacute;nico:</td><td><?php echo $cliente['correo_electronico']; ?></td> 
</tr> 

</table>
</div>

