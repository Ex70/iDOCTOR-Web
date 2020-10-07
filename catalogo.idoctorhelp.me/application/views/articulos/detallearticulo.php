

<?php echo form_open('articulos/guardar'); 

         if ($id!="") {
	       echo form_hidden("accion", "u");
		   echo form_hidden("id",$id);
		 }
		 else
			echo form_hidden("accion", "i");
			
?>
<table class="tabla1">
  <tr>
    <td colspan="2"><h4>Detalle de artículo</h4></td>
  </tr>
  
  <tr>
    <td>Id</td>
    <td><?php echo form_input("id",$id); ?></td>
  </tr>

  <tr>
    <td width="35%">Nombre</td>
    <td width="65%"><?php
    	$data = array(
              'name'        => 'descripcion',
              'id'          => 'descripcion',
              'value'       => $descripcion,
              'maxlength'   => '100',
              'size'        => '45',
              'style'       => 'color:#660000;font-weight:bold;font-size:1.4em;',
            );  
    echo form_input($data); ?></td>
  </tr>
 <?php if ($id!="") {
 	?> 
  
  <?php } 
else {
  ?>
  
  
  <?php
    }
?>
  <tr>
    <td>Clases de compatibilidad</td>
    <td><?php echo form_input("clase_compatibilidad",$clase_compatibilidad); ?></td>
  </tr>
  <tr>
    <td>Precio</td>
    <td><?php echo form_input("precio",$precio); ?></td>
  </tr>

  <tr>
    <td>&nbsp;</td>
    <td><?php echo form_submit("enviardatos","Enviar","class='button button-primary'"); ?></td>
  </tr>
</table>
<?php echo form_close(); ?>
