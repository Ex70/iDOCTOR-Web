<?php 

$this->load->helper('form');
foreach ($catestatus as $k=>$v) {
	 $catest[$v['id']] = $v['siguiente_estatus'];
}
$catestatus=$catest;
?>


<?php echo form_open('bitacoras/guardar'); ?>
<table  class="tablaiframe" border="0">
	<tr><td style="height:8px;" colspan="2"></td></tr>
  <tr>
    <td colspan="2" align="center"><h3>Agregar status en Bit&aacute;cora de Proceso</h3></td>
  </tr>
  <tr>
    
    <td width="30%">Estatus</td>
    <td width="70%"><?php //echo form_input("estatus",(isset($estatus) ? $estatus : "")); 
  //print_r($catestatus); die();
  
  $js = "id='estatusid' onChange='actualizamensaje();'";
	   echo form_dropdown("estatus_id", $catestatus, (($estatus!="") ? $estatus : "Recibido"),$js);
	   
	   if (($estatus!="")) {
	       echo form_hidden("accion", "u");
		   echo form_hidden("id",$id);
		   echo form_hidden("equipo_id",  $equipo_id);
	   }
		 else {
			    echo form_hidden("accion", "i");
				echo form_hidden("equipo_id",  $this->uri->segment(3));
				
		       }
		 
	  if ($estatusactual=='Recibido') {
	    
	    $js = "onClick='location.href=\"/index.php/piezas/consultarexistencias/"  . $clase . "/" .
	          $this->uri->segment(3) . "\";'";

       echo form_button('mybutton', 'Verificar existencia de piezas', $js);	 
	  }
	?></td>
  
  </tr>
  <tr>
  <td><div id="mensaje">Fecha adicional</div>
  </td>
  <td>
  <?php 
	$val = "";
	if ($fecha_adicional!="") 
		$val = $fecha_adicional;
	else
	   $val = date("Y-m-d");
	
	
	
	$dat = array(
              'name'        => 'fecha_adicional',
              'id'          => 'fechaadicional',
              'value'       => $val,
              'maxlength'   => '20',
              'size'        => '15',
              'class'       => 'date-pick'
            );  
	echo form_input($dat);
	?>
  </td>
  
  </tr>
<?php
  if ($estatus!="") 
    {
?>
  <tr>
    <td>Fecha</td>
    <td><?php 
	$dat = array(
              'name'        => 'fecha',
              'id'          => 'fecha',
              'value'       => (($estatus!="") ? $fecha :  date("Y-m-d")),
              'maxlength'   => '20',
              'size'        => '15',
              'class'       => 'date-pick'
            );  
	echo form_input($dat);
	//echo form_input("fecha_recibido",(isset($fecha_recibido) ? $fecha_recibido : "")); ?></td>
    <td>Hora</td>
    <td><?php echo form_input("hora",(($estatus!="") ? $hora : date("H:m:s"))); ?></td>
  </tr>
<?php } ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Descripci&oacute;n<br />
    <?php
	$data = array(
              'name'        => 'descripcion',
              'id'          => 'descripcion',
              'value'       => (isset($descripcion) ? $descripcion : ""),
              'rows'   => '4',
              'cols'        => '30',
              'style'       => 'width:100%',
            );

   echo form_textarea($data);
	?>
    
    </td>
    </tr>
    <tr>
    <td colspan="2" class="demo" align="center"><?php echo form_submit("submit","Enviar"); ?></td>
  </tr>
</table>

<?php echo form_close(); 

?>



<script language="javascript">
function actualizamensaje() {
	    
		estatusid = $('#estatusid').val();
		
        $.getJSON('/index.php/bitacoras/obtenermensajedeestatusjson/' + estatusid, null, function(data) {

        var options = '';

        $.each(data, function(key, val) {
          $('#mensaje').html(val);	
        });
             
        
		

    });
} 



actualizamensaje();
</script>
<div align="center">
<table style="border-width:1px solid;border-color444;width:700px;background-color: #eee;font-size:0.8em;">
<tr>
<td rowspan="3">
	<img src="/images/ico_usuarios.gif">
</td>	
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
