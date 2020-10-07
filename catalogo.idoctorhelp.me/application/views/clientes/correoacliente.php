<script language="javascript">
$("a#regresar").attr('href', '/index.php/clientes');
$('#titulo').html('Correo a Cliente');
</script>
<?php $this->load->helper('form'); ?>
<?php echo form_open('clientes/correoenviar'); 
?>
<table class="tabla1">
  <tr>
    <td width="35%">Nombre</td>
    <td width="65%"><div class="inputfake"><?php
    	echo form_hidden("id",$id); 
    echo $nombre; ?></div></td>
  </tr>
  <tr>
    <td>Tel&eacute;fono 1</td>
    <td><div class="inputfake"><?php echo $telefono1; ?></div></td>
  </tr>
  <tr>
    <td>Tel&eacute;fono 2</td>
    <td><div class="inputfake"><?php echo $telefono2; ?></div></td>
  </tr>
  <tr>
    <td>Dirección</td>
    <td><div class="inputfake"><?php echo $direccion; ?></div></td>
  </tr>
  <tr>
    <td>Correo electrónico</td>
    <td><div class="inputfake"><?php echo $correo_electronico; ?></div></td>
  </tr>
   <tr>
    <td colspan="2">Mensaje<br>
    <?php
 	$data = array(
              'name'        => 'mensaje',
              'id'          => 'mensaje',
              'value'       => "",
              'rows'   => '9',
              'cols'        => '30',
              'style'       => 'width:100%',
            );

   echo form_textarea($data);     	
    ?>	
    </td>
    
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo form_submit("enviardatos","Enviar"); ?></td>
  </tr>
</table>
<?php echo form_close(); ?>
