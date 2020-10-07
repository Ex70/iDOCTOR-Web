
<?php echo form_open('Proveedores/guardar'); ?>
<table  class="tabla1">
  <tr>
    <td colspan="4" align="center"><h2>Registrar Proveedor</h2></td>
  </tr>
  <tr>
    <td width="15%" colspan="2">CLAVE</td>
    <td width="31%" colspan="2"><?php echo form_input("clave_proveedor");?></td>
  </tr>
  <tr>
    <td colspan="2">NOMBRE DEL PROVEEDOR</td>
    <td colspan="2"><?php echo form_input("nombre_proveedor");?></td>
 </tr>
<tr>
</tr>

      <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2"><?php 
    if ($this->session->userdata('nivel')==1) {
      echo "<div>" . form_submit("submit","Registrar","class='button button-primary'") . "</div>";
	}	 ?></td>
  </tr>
</table>

<?php echo form_close(); 

?>

