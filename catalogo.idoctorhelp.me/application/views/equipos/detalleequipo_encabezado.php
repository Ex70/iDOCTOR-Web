
<?php $this->load->helper('form'); 
 	
?>

<?php 
$att = array('id' => 'form_equipos');

echo form_open('equipos/guardar',$att); ?>

<script language="javascript">
function actualizaCap() {
	    var t = $("#tipo").val();
		
        $.getJSON('/index.php/tipos/subtiposjson/' + t, null, function(data) {

        var options = '';

        $.each(data, function(key, val) {
            options += '<option value="' + key + '">' + val + '</option>';
			
        });
        
        $('#capacidad').html(options);
		$("#capacidad option[value='']").remove();
		


    });
} 

function actualizaClientes() {
	    
		$("#clienteid").val(id);
        ponerdatoscliente(id);
		/*
        $.getJSON('/index.php/clientes/clientesjson', null, function(data) {

        var options = '';

        $.each(data, function(key, val) {
            options += '<option value="' + key + '">' + val + '</option>';
			
        });
        
        $('#clienteid').html(options);
		$("#clienteid option[value='']").remove();
        

    });   */
} 


function ponerdatoscliente(id) {
        $.getJSON('/index.php/clientes/nombreclientejson/' + id, null, function(data) {
																		  
		$.each(data, function(k, v) {
          $('#nombrecliente').val(v);	
        });
	});
 }


</script>
<script>
 $(document).ready(function () {
  
  actualizaCap();
<?php

  if (($this->uri->segment(2)!="agregar")  && ($estatus=="")) {  
     echo "tb_show('Por favor agrega el dato','/index.php/bitacoras/agregar/" . $id . "?keepThis=true&TB_iframe=true&height=350&width=700');\n";
  }
?>
});
 
 
 window.onload = function() {
	 $("#capacidad").val('<?php echo $capacidad?>');
	 ponerdatoscliente(<?php echo $cliente_id; ?>)
} 

$("a#regresar").attr('href', '/index.php/equipos');
$('#titulo').html('<?php echo $titulo; ?>');


function seleccionarcliente(id) {
$("#clienteid").val(id);
ponerdatoscliente(id);
}





</script>