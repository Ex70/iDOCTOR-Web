<script language="javascript">
$('#titulo').html('Cambiar mi contrase&ntilde;a');
</script>
<?php $this->load->helper('form'); 
 
?>
<?php echo form_open('usuarios/guardarcambiopasswd'); ?>

<table  class="tabla1">
  
  <tr style="height:100px;">
  <td>Contrase&ntilde;a actual</td>
    <td><?php 

	   echo form_password("passwd_actual","");
	   
	  
	?></td>
  </tr>
  <tr style="height:30px;">
  <td>Nueva contrase&ntilde;a</td>
  <td><?php echo form_password("passwd1",""); ?></td>
  </tr>
  <tr style="height:30px;">
  <td>Repetir nueva contrase&ntilde;a</td>
  <td><?php echo form_password("passwd2",""); ?></td>
  </tr>

  
   <tr>
  	
    <td colspan="2"><div align="center"><?php echo form_submit("submit","Enviar"); ?></div></td>
  </tr>
</table>

<?php echo form_close(); 

?>

