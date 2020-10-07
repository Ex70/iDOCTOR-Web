<script language="javascript">
$("a#regresar").attr('href', '/index.php/piezas/index');
$('#titulo').html('Agregar m&uacute;ltiples piezas');
</script>
<?php $this->load->helper('form'); 
 
?>
<?php echo form_open('piezas/guardarpiezas'); ?>
<table  class="tabla1">
<tr>
	<td style="font-size:12px;">Id</td>
	<td style="font-size:12px;">Descripci&oacute;n</td>
	<td style="font-size:12px;">$ Nuevas</td>
	<td style="font-size:12px;">$ Usadas</td>
	<td style="font-size:12px;">$ Recicladas</td>
    <td style="font-size:12px;">Cant. Nuevas</td>
    <td style="font-size:12px;">Cant. Usadas</td>
    <td style="font-size:12px;">Cant. Recicladas</td>
    <td style="font-size:12px;">Min. Nuevas</td>
    <td style="font-size:12px;">Min. Usadas</td>
    <td style="font-size:12px;">Min. Recicladas</td>
    <td style="font-size:12px;">Clase</td>

</tr>
<?php 
   for ($j=0;$j<=20;$j++) {
   	
?>   
  <tr>
    <td><?php //echo form_input("estatus",(isset($estatus) ? $estatus : "")); 

	   echo form_input(array("name"=>"id" . $j,"size"=>"6","maxlengtd"=>"10"));
	   ?>
	</td><td>
    <?php
	$data = array(
              'name'        => 'descripcion' . $j,
              'id'          => 'descripcion',
              'value'       => '',
              'rows'   => '4',
              'cols'        => '10',
              'style'       => 'widtd:100%',
            );

//echo form_textarea($data);
echo form_input(array("name"=>"descripcion" . $j,"size"=>"20","maxlengtd"=>"100"));
	?>
    
    </td>
<td><?php echo form_input(array("name"=>"precio_nuevas" . $j,"size"=>"4","value"=>"0")); ?></td>
<td><?php echo form_input(array("name"=>"cant_nuevas" . $j,"size"=>"4","value"=>"0")); ?></td>
<td><?php echo form_input(array("name"=>"minimo_nuevas" . $j,"size"=>"4","value"=>"0")); ?></td>
<td><?php 
	
	  //echo form_dropdown("tipo", $catTipo, (isset($tipo) ? $tipo : ""));
	  echo form_dropdown("clase" . $j, $clases,""); 
	//echo form_input("fecha_recibido",(isset($fecha_recibido) ? $fecha_recibido : "")); ?></td>
      </tr>
  <?php
  }
?>
      <tr>
    <td colspan="11" align="center"><?php 
      echo form_submit("submit","Enviar");
		 ?></td>
  </tr>
</table>

<?php echo form_close(); 

?>

