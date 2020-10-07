<?php $this->load->helper('form'); 
  
?>
<script language="javascript">
$("a#regresar").attr('href', '/index.php/inicio/administracion');
$('#titulo').html('Cambiar siguiente n&uacute;mero de &oacute;rden');
</script>
<?php echo form_open('equipos/guardarnumorden'); ?>
<table  class="tabla1">
 

  <tr>
    <td>Serie<br />
    <?php
$data = array(
              'name'        => 'serie',
              'id'          => 'serie',
              'value'       => $serie,
              'maxlength'   => '1',
              'size'        => '4',
              'style'       => 'color:#660000;font-weight:bold;font-size:1.4em;',
            );  
    echo form_input($data);
	?>
    
    </td>
    <td>N&uacute;mero de &oacute;rden<br />
    <?php
$data = array(
              'name'        => 'numero_orden',
              'id'          => 'numeroorden',
              'value'       => $numero_orden,
              'maxlength'   => '10',
              'size'        => '20',
              'style'       => 'color:#660000;font-weight:bold;font-size:1.4em;',
            );  
    echo form_input($data);
	?>
    
    </td>   
 </tr>
 <tr>
    <td>
      <div style="height:50px;"></div>
    </td>
    <td><div style="height:50px;"></div>
      N&uacute;mero de remisi&oacute;n (nota de venta)<br />
    <?php
$data = array(
              'name'        => 'numero_remision',
              'id'          => 'numeroremision',
              'value'       => $numero_remision,
              'maxlength'   => '10',
              'size'        => '20',
              'style'       => 'color:#660000;font-weight:bold;font-size:1.4em;',
            );  
    echo form_input($data);
  ?>
    
    </td>   
 </tr>
 
  
  
      <tr>
    <td><p style="minheight:50px;"></p>&nbsp;</td>
    <td><div class="demo"><?php echo form_submit("submit","Enviar"); ?></div></td>
  </tr>
</table>

<?php echo form_close(); 

?>

