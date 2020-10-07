<script language="javascript">
$("a#regresar").attr('href', '/index.php/inicio/articulos');
$('#titulo').html('Venta de articulos');

function actualizaClientes() {
	    
		$("#clienteid").val(id);
        ponerdatoscliente(id);
} 


function ponerdatoscliente(id) {
        $.getJSON('/index.php/clientes/nombreclientejson/' + id, null, function(data) {
																		  
		$.each(data, function(k, v) {
          $('#nombrecliente').val(v);	
        });
	});
 }


function seleccionarcliente(id,nombre) {
$("#clienteid").val(id);
$("#nombrecliente").val(nombre);
$(".ocultar").hide();

}

function seleccionararticulo(id) {
	var data = "";
    $.get('/index.php/articulos/ajax_tr_articulo/' + id + '/<?php echo $uniqid; ?>' , function(data){
    content= data;
    $('#grid > tbody').append(content);
  });	

 }

 function eliminararticulo(id) {
 	$.get('/index.php/articulos/ajax_tr_eliminar_articulo/' + id , function(){
 	$("#row" + id).remove();
  });	
 }


</script>
<?php echo form_open("articulos/guardarventa"); ?>
<?php echo form_hidden("uniqid",$uniqid); ?>
<!-- CLIENTE     -->
<div align="center">
<table>
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
  <td>Forma de pago</td>
  <td colspan="3">
          <?php 
      $opciones = array("Efectivo"=>"Efectivo",
        "Tarjeta de crédito/débito"=>"Tarjeta de crédito/débito",
        "Transferencia bancaria"=>"Transferencia bancaria",
        "Cheque"=>"Cheque");
      echo form_dropdown("forma_de_pago",$opciones,"");
      ?>
</td>
</tr>


</table>
</div>

<!-- FIN CLIENTE -->

<div align="center">
    <a href='/index.php/articulos/buscar?keepThis=true&amp;TB_iframe=true&amp;height=300&amp;width=800' title='Buscar' class='thickbox'><div class="botones">Agregar art&iacute;culo</div></a></td>	
</div>



<table width="500" id="grid">
<tr>
<th>ID</th>
<th>Descripci&oacute;n</th>
<th>Clases</th>
<th>Precio</th>
<th>Eliminar</th>
</tr>

<?php
/*
foreach ($result as $item) {
	echo "<tr>";
	echo "<td><a href='/index.php/articulos/modificar/" . $item['id'] . "'>" . $item['id'] . "</a></td>";
	echo "<td><a href='/index.php/articulos/modificar/" . $item['id'] . "'>" . $item['descripcion'] . "</a></td>";
	echo "<td>" . $item['clase_compatibilidad'] . "</td>";
	echo "<td>" . $item['precio'] . "</td>";
	echo "<td align='center'><a href='/index.php/articulos/eliminar/" . $item['id'] . "'><img src='/images/ico_eliminar.png'></a></td>";
	echo "</tr>";	
}
*/
?>
</table>
</div>
<div align="center" class="demo"><?php echo form_submit("Enviar","Enviar"); ?></div>
<?php
echo form_close();
?>
<script>
$(document).ready(function () {
  
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

});
</script>
