<script language="javascript">
$("a#regresar").attr('href', '/index.php/clientes');
$('#titulo').html('Cliente');
</script>
<?php $this->load->helper('form'); ?>
<?php echo form_open('clientes/guardar'); 

         if ($id!="") {
	       echo form_hidden("accion", "u");
		   echo form_hidden("id",$id);
		 }
		 else
			echo form_hidden("accion", "i");
			
		 echo form_hidden("desdeequipo",$desdeequipo);	

?>
<table class="tabla1">
  <tr>
    <td colspan="2"><h2>Detalle de cliente</h2></td>
  </tr>
  <tr>
    <td width="35%">Nombre</td>
    <td width="65%"><?php
    	$data = array(
              'name'        => 'nombre',
              'id'          => 'nombre',
              'value'       => $nombre,
              'maxlength'   => '100',
              'size'        => '45',
              'style'       => 'color:#660000;font-weight:bold;font-size:1.4em;',
            );  
    echo form_input($data); ?></td>
  </tr>
 <?php if ($id!="") {
 	?> 
  <tr>
    <td>Tel&eacute;fono</td>
    <td><?php echo form_input("telefono1",$telefono1); ?></td>
  </tr>
  <tr>
    <td>M&oacute;vil</td>
    <td><?php echo form_input("telefono2",$telefono2); ?></td>
  </tr>
  <?php } 
else {
  ?>
  <tr>
    <td>Tel&eacute;fono</td>
    <td><?php $t1 = array("name"=>"telefono1a","size"=>5,"maxlength"=>3);
		$t2 = array("name"=>"telefono1b","size"=>7,"maxlength"=>3);
		$t3 = array("name"=>"telefono1c","size"=>7,"maxlength"=>4);
		
	    echo "<span>" . form_input($t1) . "</span><span>" . form_input($t2) . "</span><span>" . 
	         form_input($t3) . "</span>"; ?></td>
  </tr>
  <tr>
    <td>M&oacute;vil</td>
    <td><?php
    	 $t1 = array("name"=>"telefono2a","size"=>5,"maxlength"=>3);
		$t2 = array("name"=>"telefono2b","size"=>7,"maxlength"=>3);
		$t3 = array("name"=>"telefono2c","size"=>7,"maxlength"=>4);
		
	    echo "<span>" . form_input($t1) . "</span><span>" . form_input($t2) . "</span><span>" . 
	         form_input($t3) . "</span>"; 
     ?></td>
  </tr>
  
  
  <?php
    }
?>
  <tr>
    <td>Dirección</td>
    <td><?php echo form_input("direccion",$direccion); ?></td>
  </tr>
  <tr>
    <td>Colonia</td>
    <td><?php echo form_input("colonia",$colonia); ?></td>
  </tr>
  <tr>
    <td>C.P.</td>
    <td><?php echo form_input("cp",$cp); ?></td>
  </tr>
  <tr>
    <td>Ciudad</td>
    <td><?php echo form_input("ciudad",$ciudad); ?></td>
  </tr>
  <tr>
    <td>Estado</td>
    <td><?php echo form_input("estado",$estado); ?></td>
  </tr>



  <tr>
    <td>Correo electrónico</td>
    <td><?php
    	$data = array(
              'name'        => 'correo_electronico',
              'id'          => 'correoelectronico',
              'value'       => $correo_electronico,
              'maxlength'   => '100',
              'size'        => '35',
              'style'       => 'color:#660000;font-weight:bold;',
            ); 
       echo form_input($data); ?>
    	<?php if (($id!="") && ($correo_electronico!=""))
    	        {
    		?>
    	<input type="button" value="Enviar correo" 
    	  onClick="top.location.href='/index.php/clientes/enviarcorreo/<?php echo $id;?>';">
    	  <?php } ?>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo form_submit("enviardatos","Enviar"); ?></td>
  </tr>
</table>
<?php echo form_close(); ?>
