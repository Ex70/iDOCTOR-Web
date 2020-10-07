<script language="javascript">
$("a#regresar").attr('href', '/index.php/piezas/index');
$('#titulo').html('Pieza');
</script>
<?php $this->load->helper('form'); 
    $catEstatus = array("Recibido"=>"Recibido","Diagnosticado"=>"Diagnosticado",
								 "Notificado"=>"Notificado","En reparacion"=>"En reparacion","Reparado"=>"Reparado",
								 "Entregado"=>"Entregado","Donado a Rec"=>"Donado a Rec","Reciclaje x olv"=>"Reciclaje x olv");	

?>
<?php echo form_open('piezas/guardar'); ?>
<table  class="tabla1">
  <tr>
    <td colspan="4"><h2>Detalle de pieza</h2></td>
  </tr>
  <tr>
    <?php
    if (isset($estatus)) {
		echo "<tr><td colspan=4>Id: " . $id . "</td></tr>";
	}
  ?>
    <td width="15%">ID</td>
    <td width="31%"><?php //echo form_input("estatus",(isset($estatus) ? $estatus : "")); 

	   echo form_input("id",$id);
	   
	   if ($id!="") 
	       echo form_hidden("accion", "u");
		 else
			echo form_hidden("accion", "i");

	?></td>
    <td width="25%">&nbsp;</td>
    <td width="29%">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">Descripci&oacute;n<br />
    <?php
	$data = array(
              'name'        => 'descripcion',
              'id'          => 'descripcion',
              'value'       => (isset($descripcion) ? $descripcion : ""),
              'rows'   => '7',
              'cols'        => '30',
              'style'       => 'width:100%',
            );

echo form_textarea($data);
	?>
    
    </td>
 </tr>
<tr>
<td>Cantidad nuevas</td><td><?php echo form_input("cant_nuevas",$cant_nuevas); ?></td>
<td>Cantidad usadas</td><td><?php echo form_input("cant_usadas",$cant_usadas); ?></td>

</tr>
<tr>
<td>M&iacute;nimo nuevas</td><td><?php echo form_input("minimo_nuevas",$minimo_nuevas); ?></td>
<td>M&iacute;nimo usadas</td><td><?php echo form_input("minimo_usadas",$minimo_usadas); ?></td>

</tr>
  <tr>
    <td>Tipo</td>
    <td><?php 
	
	  //echo form_dropdown("tipo", $catTipo, (isset($tipo) ? $tipo : ""));
	  echo form_dropdown("tipo", $tipos, (isset($tipo) ? $tipo : "")); 
	//echo form_input("fecha_recibido",(isset($fecha_recibido) ? $fecha_recibido : "")); ?></td>
    <td></td>
    <td></td>
  </tr>
  
      <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2"><?php echo form_submit("submit","Enviar"); ?></td>
  </tr>
</table>

<?php echo form_close(); 

?>

