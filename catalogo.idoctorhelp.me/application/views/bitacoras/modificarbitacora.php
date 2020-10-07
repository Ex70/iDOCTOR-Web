<?php 

$this->load->helper('form');
?>
<div style="height:40px"></div>

<?php echo form_open('bitacoras/guardarmodificacion');
  echo form_hidden("id",$id);
 ?>
<table  class="tablaiframe2">
  <tr>
  </tr>
  <tr>
    
    <td width="50%">Estatus</td>
    <td width="50%"><?php 
    
    echo $estatus;
  
	?></td>
  
  </tr>
  <tr>
  <td><div id="mensaje"><?php 
	echo $mensaje_para_fecha_adicional;
	?></div>
  </td>
  <td>

    <?php 
  $val = "";
  
  $dat = array(
              'name'        => 'fecha_adicional',
              'id'          => 'fechaadicional',
              'value'       => $fecha_adicional,
              'maxlength'   => '20',
              'size'        => '15'
            );  
   
        $dat['class'] = 'date-pick';
    
          
      
  echo form_input($dat);
  
  ?>
  </td>
  
  </tr>
  <tr>
    <td>Fecha</td>
    <td><?php 
	echo $fecha;
	?>
</tr>
<tr>
    <td>Hora</td>
    <td><?php echo $hora ?></td>
  </tr>
  
  <tr>
    <td colspan="2">Descripci&oacute;n<br />
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
    <td>&nbsp;</td>
    <td><div class="demo"><?php echo form_submit("submit","Enviar"); ?></div></td>
  </tr>
</table>

<?php echo form_close(); 

?>

<div align="center">
<table style="border-width:1px solid;border-color444;width:700px;background-color: #eee;font-size:0.8em;">
<tr>
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
