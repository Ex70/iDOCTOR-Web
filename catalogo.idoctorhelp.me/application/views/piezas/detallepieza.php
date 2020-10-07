
<?php echo form_open('piezas/guardar'); ?>
<table  class="tabla1">
  <tr>
    <td colspan="4" align="center"><h2>Detalle de pieza</h2></td>
  </tr>
  <tr>
    <td width="15%" colspan="2">ID</td>
    <td width="31%" colspan="2"><?php //echo form_input("estatus",(isset($estatus) ? $estatus : "")); 

	   echo form_input("id",$id);
	   
	   if ($id!="") 
	       echo form_hidden("accion", "u");
		 else
			echo form_hidden("accion", "i");
    if ($id=="") {
    	echo "<div style='font-size:9px;'>Utiliza una abreviación para definir la ID</div>";
    }
	?></td>
  </tr>
  <tr>
    <td colspan="2">Descripci&oacute;n</td>
    <td colspan="2">
    <?php
	$data = array(
              'name'        => 'descripcion',
              'id'          => 'descripcion',
              'value'       => (isset($descripcion) ? $descripcion : ""),
              'size'        => '50'
            );
echo form_input($data);
	?>
    
    </td>
 </tr>
<tr>
</tr>


  <tr>
    <td colspan="2">Clase</td>
    <td colspan="2"><?php 
	
	  //echo form_dropdown("tipo", $catTipo, (isset($tipo) ? $tipo : ""));
	  echo form_dropdown("clase", $clases, (isset($clase) ? $clase : "")); 
	//echo form_input("fecha_recibido",(isset($fecha_recibido) ? $fecha_recibido : "")); ?></td>
      </tr>
  
      <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2"><?php 
    if ($this->session->userdata('nivel')==1) {
      echo "<div>" . form_submit("submit","Enviar","class='button button-primary'") . "</div>";
	}	 ?></td>
  </tr>
</table>

<?php echo form_close(); 

?>

