<script>
$("a#regresar").attr('href', '/index.php/usuarios');
$('#titulo').html('<?php echo $titulo; ?>');
</script>


<?php $this->load->helper('form'); ?>
<?php echo form_open('usuarios/guardar'); 
    if ($id!="") {
		echo form_hidden("id",$id);
	}
	
    if ($id!="") 
	       echo form_hidden("accion", "u");
		 else
		   echo form_hidden("accion", "i");
			 


?>
<table class="tabla1">
  <tr>
    <td colspan="2"><h2>Detalle de usuario</h2></td>
  </tr>
  <tr>
    <td width="35%">Nombre</td>
    <td width="65%"><?php echo form_input("nombre",$nombre); ?></td>
  </tr>
  <tr>
    <td>Tel&eacute;fono 1</td>
    <td><?php echo form_input("telefono1",$telefono1); ?></td>
  </tr>
  <tr>
    <td>Tel&eacute;fono 2</td>
    <td><?php echo form_input("telefono2",$telefono2); ?></td>
  </tr>
  <tr>
    <td>Usuario</td>
    <td><?php echo form_input("usuario",$usuario); ?></td>
  </tr>
  <tr>
    <td>Contrase&ntilde;a</td>
    <td><?php echo form_password("passwd",$passwd); ?></td>
  </tr>
  <tr>
    <td>Correo</td>
    <td><?php echo form_input("correo_electronico",$correo_electronico); ?></td>
  </tr>

<?php if ($this->uri->segment(2)!="agregar") { ?>
  <tr>
    <td valign="top">
      <div style="height:80px">Sucursales donde puede acceder</div>
  <?php if ((!isset($es_super_administrador) && (!$es_super_administrador))) { ?>
<div align="center"><a href="/index.php/usuarios/convertirensuperadmin/<?php echo $this->uri->segment(3,''); ?>" class="button" style="background-color:#ff0">Convertir en Super Administrador</a></div>
  <?php } else { 
  ?>
  <div align="center"><a href="/index.php/usuarios/convertirensuperadmin/<?php echo $this->uri->segment(3,''); ?>" class="button" style="background-color:#ff0">Convertir en Super Administrador</a></div>
<div align="center"><a href="/index.php/usuarios/quitarsuperadmin/<?php echo $this->uri->segment(3,''); ?>" class="button" style="background-color:#faa">Quitar Super Administrador</a></div>

  <?php } ?>
    </td>
    <td>

<table class="sucursales">
  <th>Sucursal</th>
  <th>Nivel</th>
  <th></th>
<?php foreach ($sucursales as $item) { 
   echo "<tr>";
   echo "<td>" . $item['sucursal_id'] . "</td>";
   echo "<td>" . $item['nivel'] . "</td>";
   echo "<td>" . $item['nombre_nivel'] . "</td>";
   echo "</tr>";

 } ?>
</table>
    </td>
  </tr>    

<?php } ?>
    
  <tr>
    <td>&nbsp;</td>
    <td><?php echo form_submit("submit","Enviar","class='button button-primary'"); ?></td>
  </tr>
</table>
<?php echo form_close(); ?>
<style>
.sucursales {
   border: 1px solid #666;
   width:100%;
   border-collapse: collapse;
}
.sucursales td {
border: 1px solid #666;
padding: 5px;
}
</style>
