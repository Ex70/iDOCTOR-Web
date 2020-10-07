
<div style="text-align:center; color:#ff0000;"><?php //echo validation_errors(); ?></div>
<?php $this->load->helper('form'); 
 	
?>
<style>
	.ocultar {};
	.imagentipo {};
</style>
<?php 
$att = array('id' => 'formequipos','name' =>'form_equipos');
echo form_open('equipos/validar',$att);

$d = array("style"=>"display:none","name"=>"editimprimir","id"=>"imprimir","value"=>"");
echo form_input($d); 
?>

<script language="javascript">
function actualizaCap() {
	    var t = $("#tipo").val();

      
      if (t.substring(0,5)=="iPhon") {
        $('#ipop').show();
        $('#ipimei').show();
        $('#ipfirmware').show();
      }
      else {
         $('#ipop').hide();
         $('#ipimei').hide();
         $('#ipfirmware').hide();
      }


        $.getJSON('/index.php/tipos/subtiposjson/' + t, null, function(data) {

        var options = '';

        $.each(data, function(key, val) {
            options += '<option value="' + key + '">' + val + '</option>';
			
        });
        
        $('#capacidad').html(options);
		$("#capacidad option[value='']").remove();
    });
    
        $.getJSON('/index.php/tipos/imagenjson/' + t, null, function(data) {
        	 $.each(data, function(key, val) {
        	 if (key=='imagen')
                 $("#imgtipo").attr("src", "/images/tipos/" + val);
		
			 });
		});      
    
} 

function actualizaClientes() {
	    
		
        $.getJSON('/index.php/clientes/clientesjson', null, function(data) {

        var options = '';

        $.each(data, function(key, val) {
            options += '<option value="' + key + '">' + val + '</option>';
			
        });
        
        $('#clienteid').html(options);
		$("#clienteid option[value='']").remove();


    });
} 




</script>
<script>

 $(document).ready(function () {
  
  actualizaCap();

  $('#tel1').bind('keyup', function() { 
      var fvalue = document.getElementById('tel1').value;

      var r = /(\D+)/g,
        npa = '',
        nxx = '',
        last4 = '';
    fvalue = fvalue.replace(r, '');
    npa = fvalue.substr(0, 3);
    nxx = fvalue.substr(3, 3);
    last4 = fvalue.substr(6, 4);
    fvalue = npa + '-' + nxx + '-' + last4;
    document.getElementById('tel1').value = fvalue;
   } );

  $('#tel2').bind('keyup', function() { 
      var fvalue = document.getElementById('tel2').value;

      var r = /(\D+)/g,
        npa = '',
        nxx = '',
        last4 = '';
    fvalue = fvalue.replace(r, '');
    npa = fvalue.substr(0, 3);
    nxx = fvalue.substr(3, 3);
    last4 = fvalue.substr(6, 4);
    fvalue = npa + '-' + nxx + '-' + last4;
    document.getElementById('tel2').value = fvalue;
   } );


  $('#botonenviar').click(function() {
      //$("#target").click();
      $('#botonenviar').attr('disabled', 'disabled');
      $('#botonimprimir').attr('disabled', 'disabled');

      $('#botonenviar').hide(400);      
      $('#formequipos').submit();

   }); 

  $('#botonimprimir').click(function() { 
      //document.form_equipos.elements['imprimir'].value = 'S';
      //document.form_equipos.submit.click();
      //document.form_equipos.submit.disabled = true;
      $('#imprimir').val('S');
      //editimprimir
      $('#botonenviar').attr('disabled', 'disabled');
      $('#botonimprimir').attr('disabled', 'disabled');

      $('#botonenviar').hide(400);      
      $('#formequipos').submit();
  });

<?php
/*
  if (($this->uri->segment(2)!="agregar")  && ($estatus=="")) {  
     echo "tb_show('Por favor agrega el dato','/index.php/bitacoras/agregar/" . $id . "?keepThis=true&TB_iframe=true&height=350&width=700');\n";
  }
  */
?>
});
 
 
 window.onload = function() {
	 
} 

$("a#regresar").attr('href', '/index.php/inicio/iniciar');
$('#titulo').html('<?php echo $titulo; ?>');


function seleccionarcliente(id,nombre) {
$("#clienteid").val(id);
$("#nombrecliente").val(nombre);
$(".ocultar").hide();

}

</script>


<table class="tabla1">
  <tr>
    <td colspan="4"><h2>Recepci&oacute;n de equipo</h2></td>
  </tr>
  <tr>
    <td>Nombre</td>
    <td colspan="3"><?php //echo form_input("cliente_id",(isset($cliente_id) ? $cliente_id : "")); $js = 'id="clienteid"';
		$ar1=array("name" => "cliente_id", "id"=>"clienteid", "size"=>4,"readonly"=>"readonly",
		           "value" => (isset($cliente_id) ? $cliente_id : ""));
		echo form_input($ar1);

	    $arn = array("name"=>"nombrecliente","id"=>"nombrecliente","size"=>"50",
					  // "readonly"    => "readonly",
             "placeholder"=>"Por favor escribe el nombre",
					   "value" => (isset($nombrecliente) ? $nombrecliente : ""));
	    echo form_input($arn);

		echo form_hidden("accion","i");
	  //  echo  form_dropdown("cliente_id", $clientes, (isset($cliente_id) ? $cliente_id : ""),$js);
	  // <a href='/index.php/clientes/agregardesdeequipos?keepThis=true&amp;TB_iframe=true&amp;height=200&amp;width=800' title='Agregar' class='thickbox'><strong>+</strong></a>
	?>
    <a href='/index.php/clientes/buscar?keepThis=true&amp;TB_iframe=true&amp;height=300&amp;width=800' title='Buscar' class='thickbox'><strong><img src="/images/ico_lupa.gif"></strong></a></td>
  </tr>

 <tr>
    <td><div class="ocultar">Domicilio</div></td>
    <td colspan="3">
      <div class="ocultar">
      <?php
    $t1 = array("name"=>"direccion","size"=>30,"maxlength"=>200,"value"=>$direccion,"placeholder"=>"Direcci&oacute;n");
    $t2 = array("name"=>"colonia","size"=>20,"maxlength"=>50,"value"=>$colonia,"placeholder"=>"Colonia");
      echo "<span>" . form_input($t1) . "</span><span>" . form_input($t2) . "</span>"; 
  ?></div>
  </td>
  </tr>

 <tr>
    <td><div class="ocultar"></div></td>
    <td colspan="3">
      <div class="ocultar">
      <?php
    $t3 = array("name"=>"cp","size"=>20,"maxlength"=>6,"value"=>$cp,"placeholder"=>"C.P.");
    $t4 = array("name"=>"ciudad","size"=>20,"maxlength"=>50,"value"=>$ciudad,"placeholder"=>"Ciudad");
    $t5 = array("name"=>"estado","size"=>20,"maxlength"=>50,"value"=>$estado,"placeholder"=>"Estado");
    
      echo "<span>" . 
           form_input($t3) .  "</span><span>" . 
           form_input($t4) . "</span><span>" . 
           form_input($t5) . "</span>";
  ?></div>
  </td>
  </tr>


 <tr>
    <td><div class="ocultar">Tel&eacute;fono</div></td>
    <td colspan="3">
    	<div class="ocultar">
    	<?php
   $t1 = array("name"=>"telefono1","size"=>20,"maxlength"=>12,"value"=>$telefono1,"id"=>"tel1");           
  echo "<span>" . form_input($t1) . "</span>";   
	?></div>
	</td>
  </tr>
<tr>
    <td><div class="ocultar">M&oacute;vil</div></td>
    <td colspan="3"><div class="ocultar"><?php 

   $t2 = array("name"=>"telefono2","size"=>20,"maxlength"=>12,"value"=>$telefono1,"id"=>"tel2");           
  echo "<span>" . form_input($t2) . "</span>";   


	?></div>
	</td>
  </tr>
 <tr>
    <td><div class="ocultar">Correo electr&oacute;nico</div></td>
    <td colspan="3"><div class="ocultar"><?php //echo form_input("cliente_id",(isset($cliente_id) ? $cliente_id : "")); $js = 'id="clienteid"';
		
	    echo form_input("correo_electronico",$correo_electronico);
	?></div>
	</td>
  </tr>


  <tr>
    <td>C&oacute;mo te enteraste de nosotros</td>
    <td colspan="3"><?php
	/*$data = array(
              'name'        => 'como_te_enteraste',
              'id'          => 'comoteenteraste',
              'value'       => (isset($como_te_enteraste) ? $como_te_enteraste : ""),
              'rows'   => '3',
              'cols'        => '30',
              'style'       => 'width:100%',
            );
	echo form_textarea($data);*/

	$comoent = array("CORREO ELECTRONICO"=>"Correo electr&oacute;nico",
					 "ESPECTACULAR"=>"Espectacular",
					 "MEDALLON"=>"Medall&oacute;n auto/autobus",
					 "OTRO NEGOCIO"=>"Otro negocio",
					 "PUBLICACION"=>"Publicaci&oacute;n (diario/revista)",
					 "RECOMENDACION"=>"Recomendaci&oacute;n",
					 "REDES SOCIALES"=>"Redes sociales",
					 "SITIO WEB"=>"Sitio web",
					 "VISTE EL LOCAL"=>"Viste el local");
					 
    echo form_dropdown('como_te_enteraste',$comoent);
	?></td>
  </tr>
  <tr>
    <td>&iquest;Deseas recibir nuestras promociones en tu correo?</td>
    <td colspan="3">
    <?php
	  $sino = array("S"=>"Si","N"=>"No");
	  $sinonada = array(""=>"","S"=>"Si","N"=>"No");
	  
	     echo form_dropdown('desea_recibir_promociones',$sino);
	  
	//
    ?></td>
  </tr>
  <tr>
    <td>1. &iquest;Qu&eacute; producto traes a reparar?</td>
    <td colspan="2"><?php 
	 $js = 'id="tipo" onChange="actualizaCap();"';
	echo  form_dropdown("tipo", $tipos, (isset($tipo) ? $tipo : ""),$js); ?></td>
	<td rowspan="3">
		<img class="imagentipo" id="imgtipo" src="/images/tipos/ipod_shuffle1.png">
	</td>
  </tr>
  <tr>
    <td>Capacidad</td>
    <td colspan="2"><?php
	   $js = 'id="capacidad"';
	   echo form_dropdown("capacidad",array(),(isset($capacidad) ? $capacidad : ""),$js); 
	   ?></td>
  </tr>
  <!--<tr>
    <td>Modelo</td>
    <td colspan="3"><?php echo form_input("modelo",(isset($modelo) ? $modelo : "")); ?></td>
  </tr> -->
  <tr>
    <td>No. Serie</td>
    <td colspan="2"><?php echo form_input("num_serie",(isset($num_serie) ? $num_serie : "")); ?></td>
  </tr>
   <tr>
    <td>Color</td>
    <td colspan="2"><?php echo form_input("color",(isset($color) ? $color : "")); ?></td>
  </tr>
  <tr style="display:none" id="ipop">
    <td>Operador (s&oacute;lo iPhone)</td>
    <td colspan="2"><?php echo form_input("operador",(isset($operador) ? $operador : "")); ?></td>
  </tr>


  <tr style="display:none" id="ipimei">
    <td>IMEI (s&oacute;lo iPhone)</td>
    <td colspan="2"><?php echo form_input("iphone_imei",(isset($iphone_imei) ? $iphone_imei : "")); ?></td>
  </tr>

  <tr style="display:none" id="ipfirmware">
    <td>Firmware del modem (s&oacute;lo iPhone)</td>
    <td colspan="2"><?php echo form_input("iphone_firmware_modem",(isset($iphone_firmware_modem) ? $iphone_firmware_modem : "")); ?></td>
  </tr>

  <tr>
    <td>Versi&oacute;n del IOS</td>
    <td colspan="2"><?php echo form_input("ios_version",(isset($ios_version) ? $ios_version : "")); ?></td>
  </tr>


  <tr>
    <td class="tdnivel2">2. &iquest;Tu equipo a&uacute;n est&aacute; dentro del plazo de garant&iacute;a ofrecido por Apple?</td>
    <td colspan="3"><?php
	  $sino = array("S"=>"Si","N"=>"No");
	     echo form_dropdown('equipo_en_garantia',$sinonada);
	  
	//
    ?></td>
  </tr>
  <tr>
    <td class="tdnivel2">3. Alguien m&aacute;s intent&oacute; reparar tu equipo antes de venir con nosotros?</td>
    <td colspan="3"><?php
	  $sino = array("S"=>"Si","N"=>"No");
	     echo form_dropdown('intentaron_repararlo',$sinonada);
	  
	//
    ?></td>
  </tr>
  <tr>
    <td class="tdnivel2">4. El producto estuvo en contacto directo con agua o vapores de alg&uacute;n tipo?</td>
    <td colspan="3"><?php
	  $sino = array("S"=>"Si","N"=>"No");
	     echo form_dropdown('en_contacto_con_agua_vap',$sinonada);
	  
	//
    ?></td>
  </tr>
  <tr>
    <td class="tdnivel2">5. Adquiriste tu equipo dentro del pa&iacute;s? (s&oacute;lo aplica para iPhone)</td>
    <td colspan="3"><?php
	  $sino = array("S"=>"Si","N"=>"No");
	     echo form_dropdown('iphone_comprado_en_pais',$sinonada);
	  
	//
    ?></td>
  </tr>
  <tr>
    <td class="tdnivel2">6. En este momento, tu equipo tiene jailbreak o cydia?</td>
    <td colspan="3"><?php
	  $sino = array("S"=>"Si","N"=>"No");
	     echo form_dropdown('tiene_jailbreak_o_cydia',$sinonada);
	  
	//
    ?></td>
  </tr>
  <tr>
    <td class="tdnivel2">7. &iquest;El equipo tiene desbloqueo?</td>
    <td colspan="3"><?php
       $desbloqueo = array("NO"=>"No","SOFTWARE"=>"Software","SIM"=>"SIM","IMEI"=>"IMEI");
       echo form_dropdown('equipo_tiene_desbloqueo',$desbloqueo);
    
  //
    ?></td>
  </tr>


  <tr>
    <td>7. Describe con detalle qu&eacute; problema(s) presenta tu equipo &nbsp;<span style="color:#ff0000;font-size:1.4em;">!</span><div class='error'><?php echo form_error('descripcion_problema'); ?></div></td>
    <td colspan="3"><?php
	$data = array(
              'name'        => 'descripcion_problema',
              'id'          => 'descproblema',
              'value'       => (isset($descripcion_problema) ? $descripcion_problema : ""),
              'rows'   => '7',
              'cols'        => '30',
              'style'       => 'width:100%',
            );

echo form_textarea($data);
	?></td>
  </tr>
  <tr>
    <td>8. Condiciones en las que se recibe el equipo&nbsp;<span style="color:#ff0000;font-size:1.4em;">!</span><div class='error'><?php echo form_error('condiciones_recepcion_eq'); ?></div></td>
    <td colspan="3"><?php
	$data = array(
              'name'        => 'condiciones_recepcion_eq',
              'id'          => 'condreceq',
              'value'       => (isset($condiciones_recepcion_eq) ? $condiciones_recepcion_eq : ""),
              'rows'   => '4',
              'cols'        => '30',
              'style'       => 'width:100%',
            );

echo form_textarea($data);
	?></td>
  </tr>
  <tr>
    <td width="32%">Contrase&ntilde;a</td>
    <td width="14%"><?php echo form_input("contrasenia",$contrasenia); 

	?></td>
    <td width="25%">&nbsp;</td>
    <td width="29%">&nbsp;</td>
  </tr>
  
  <tr>
    <td>No. de orden</td><td><?php 
    $dat = array(
              'name'        => 'num_orden',
              'id'          => 'numorden',
              'value'       => $num_orden,
              'maxlength'   => '20',
              'size'        => '12',
              'style'       => 'color:#660000;font-weight:bold;font-size:1.4em;',
            );  
			
	if ($this->session->userdata('nivel')!=1)
	    $dat['readonly'] = 'readonly';		
        
    echo form_input($dat); ?>
  </td>
    <td colspan="2"><div style="font-size:0.7em;margin:8px;"><?php 
    if ($this->session->userdata('nivel')==1)
	   echo "Puedes modificar el siguiente n&uacute;mero de orden en la <a href='/index.php/inicio/administracion'>secci&oacute;n de administraci&oacute;n.</a><br>"
    	 ?>
       <strong>Nota:</strong> El n&uacute;mero de orden puede cambiar en caso de que se agregue otra orden antes de terminar de agregar esta.
      </div>&nbsp;</td>
  </tr>
  <tr>
    <td>Fecha de recibido</td>
    <td colspan="3"><?php 
	$val = "";
	if ($fecha_recibido!="") 
		$val = $fecha_recibido;
	else
	   $val = date("Y-m-d");
	
	
	
	$dat = array(
              'name'        => 'fecha_recibido',
              'id'          => 'fechaRecibido',
              'value'       => $val,
              'maxlength'   => '20',
              'size'        => '15'
            );  
   if ($this->session->userdata('nivel')!=1)
	    $dat['readonly'] = 'readonly';	
   else 
        $dat['class'] = 'date-pick';
   	
    			
			
	echo form_input($dat);
	//echo form_input("fecha_recibido",(isset($fecha_recibido) ? $fecha_recibido : "")); ?></td>
	</tr>
	<tr>
    <td>Hora de recibido</td>
    <td colspan="3"><?php 

     /*  $timeInMinutes = time() - 60*60;
       $timenew = date("H:i:s",$timeInMinutes);*/


        $dat = array(
              'name'        => 'hora_recibido',
              'id'          => 'horaRecibido',
             'value'       => (($hora_recibido!="") ? $hora_recibido : date("H:i:s")),
   //           'value'       => (($hora_recibido!="") ? $hora_recibido : $timenew),
              'maxlength'   => '20',
              'size'        => '15'
            );  
   if ($this->session->userdata('nivel')!=1)
	    $dat['readonly'] = 'readonly';	 
      
       echo form_input($dat); ?></td>
  </tr> 
  <tr>
    <td>Fecha de entrega</td>
    <td colspan="3"><?php 
	$val = "";
	
	$dat = array(
              'name'        => 'fecha_de_entrega',
              'id'          => 'fechaEntrega',
              'value'       => $fecha_de_entrega,
              'maxlength'   => '20',
              'size'        => '15'
            );  
   
        $dat['class'] = 'date-pick';
   	
    			
			
	echo form_input($dat);
	
	?>
	</tr>

<tr>
    <td>Fecha de diagn&oacute;stico</td>
    <td colspan="3"><?php 
  $val = "";
  
  $dat = array(
              'name'        => 'fecha_de_diagnostico',
              'id'          => 'fechadediagnostico',
              'value'       => date('Y-m-d', strtotime(' +3 day')),
              'maxlength'   => '20',
              'size'        => '15'
            );  
   
        $dat['class'] = 'date-pick';
    
          
      
  echo form_input($dat);
  
  ?>
  </tr>
  

	<tr></tr> 
	
<?php 
  // MOSTRAR CHECKLIST ANTERIOR SOLO SI NO EXISTE EL ACTUAL

  if (!isset($_POST['chlst_rec_sensor_centro'])) {
?>
<tr>
  	<td valign="top">Checklist</td>
  	<td colspan="3">
<div style="font-size:12px;">
<table>
<tr><td><?php echo form_checkbox("chlst_encendido","S",$chlst_encendido); ?></td><td>Encendido (conexión a corriente y carga de batería)</td></tr>
<tr><td><?php echo form_checkbox("chlst_lcd","S",$chlst_lcd); ?></td><td>LCD</td></tr>
<tr><td><?php echo form_checkbox("chlst_digitalizador","S",$chlst_digitalizador); ?></td><td>Digitalizador/Rueda</td></tr>
<tr><td><?php echo form_checkbox("chlst_conector","S",$chlst_conector); ?></td><td>Conector de centro de carga</td></tr>
<tr><td><?php echo form_checkbox("chlst_sonido","S",$chlst_sonido); ?></td><td>Sonido (audífono, bocina, auricular)</td></tr>
<tr><td><?php echo form_checkbox("chlst_camara","S",$chlst_camara); ?></td><td>Cámara (frontal y trasera)</td></tr>
<tr><td><?php echo form_checkbox("chlst_conexiones","S",$chlst_conexiones); ?></td><td>Conexiones (wifi, bluetooth, antena telefónica)</td></tr>
<tr><td><?php echo form_checkbox("chlst_botones","S",$chlst_botones); ?></td><td>Botones (encendido, volumen, silencio, home)</td></tr>
<tr><td><?php echo form_checkbox("chlst_sim","S",$chlst_sim); ?></td><td>SIM (bandeja y lectura)</td></tr>
<tr><td><?php echo form_checkbox("chlst_software","S",$chlst_software); ?></td><td>Software (firmware, baseband, aplicaciones y jailbreak)</td></tr>
<tr><td><?php echo form_checkbox("chlst_carcasa","S",$chlst_carcasa); ?></td><td>Carcasa (golpes, roturas y rayones)</td></tr>
<tr><td><?php echo form_checkbox("chlst_sensores","S",$chlst_sensores); ?></td><td>Sensores de humedad</td></tr>
</table>
</div>
</td>
  </tr>	
	<?php
  }

  else {

      echo "<tr><td>Equipo enciende</td><td colspan='3'>" . $equipo_enciende . "</td></tr>";
      echo "<tr><td>Equipo mojado</td><td colspan='3'>" . $equipo_mojado . "</td></tr>";

      echo form_hidden("equipo_enciende",$equipo_enciende);
      echo form_hidden("equipo_mojado",$equipo_mojado);

      if ($equipo_enciende=="NO") {
        echo "<tr><td></td><td colspan='3'>El equipo no encendi&oacute; durante la recepci&oacute;n, por lo cual no fue posible realizarse las comprobaciones de rutina.</td></tr>";
      }
      if ($equipo_mojado=="SI") {
        echo "<tr><td></td><td colspan='3'>Debido a las condiciones de humedad en las que se recibe el equipo, se omitir&aacute; la comprobaci&oacute;n de rutina a fin de evitar mayores da&ntilde;os al dispositivo.</td></tr>";
      }

      if (($equipo_enciende=="SI") && ($equipo_mojado=="NO")) {
      echo "<tr><td valign='top'>Checklist</td>";
      echo "<td colspan='3'><div style='font-size:12px;'>";
      echo "<table>";
      foreach ($checklist as $k=>$v) {
         echo "<tr><td>" . $v . "</td><td>" . $_POST[$k];
         echo form_hidden($k,$_POST[$k]);
         echo "</td></tr>";
      }
      echo "</table>";
      echo "</div></td></tr>";
      }
  }
  ?>
<tr><td>Otras observaciones en la recepci&oacute;n:</td>
  <td colspan="3"><?php echo $_POST['otras_observaciones_rec'];
         echo form_hidden("otras_observaciones_rec",$_POST['otras_observaciones_rec']);
         ?></td></tr>

   <tr>
    <td colspan="2" style="height:100px;" align="center"><div class="demo"><input type='button' value='Imprimir' name='boton_imprimir' id='botonimprimir'></div></td>
    <td colspan="2"><div class="demo">
<input type='button' value='Enviar' name='botonenviar' id='botonenviar'>      
      <?php //echo form_submit("submit","Enviar"); ?></div></td>
  </tr>
  
</table>

<?php echo form_close(); 

?>
