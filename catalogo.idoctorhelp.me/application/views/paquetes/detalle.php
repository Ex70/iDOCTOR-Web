
<?php echo form_open('paquetes/guardar'); ?>
<?php 

     echo form_hidden("id",$id);
     
     if ($id!="") 
         echo form_hidden("accion", "u");
     else
      echo form_hidden("accion", "i");

  ?>

  <div class="row">
    <h4>Detalle de id</h4>
  </div><!-- row -->

  <div class="row">
  <div class="six columns">Paquete</div>
  <div class="six columns"><?php echo form_dropdown("paquete",$paquetes,$paquete); ?></div>
  </div><!-- row -->
  <div class="row">
  <div class="six columns">Clase</div>
  <div class="six columns"><?php 
  echo form_dropdown("clase",$clases,$clase,"id='clase'");
?></div>
  </div><!-- row -->

  <div class="row">
  <div class="six columns">Servicio</div>
  <div class="six columns"><?php echo form_dropdown("servicio_id",$servicios,$servicio_id,"id='servicio'"); ?></div>
  </div><!-- row -->  

  <div class="row">
  <div class="six columns">Descripción</div>
  <div class="six columns"><?php echo form_input("descripcion",$descripcion); ?></div>
  </div><!-- row -->  

  <div class="row">
  <div class="six columns">Costo</div>
  <div class="six columns"><?php echo form_input("costo",number_format($costo,2),"style='text-align:right' id='costo'"); ?></div>
  </div><!-- row -->    
  
  <div class="row">
  <div class="six columns">Diferencia</div>
  <div class="six columns"><?php echo form_input("diferencia",number_format($diferencia,2),"style='text-align:right'"); ?></div>
  </div><!-- row -->  
<?php if ($id!="") { ?>
  <div class="row">
  <div class="six columns">Total</div>
  <div class="six columns"><?php echo form_input("total",number_format($total,2),"style='text-align:right' id='total'"); ?></div>
  </div><!-- row -->  
<?php } ?>
  
  <div class="row">
  <div class="six columns">Observaciones</div>
  <div class="six columns"><?php 
    $d = array("name"=>"observaciones","id"=>"observaciones","rows"=>"5","cols"=>"20","style"=>"width:100%","value"=>$observaciones);

  echo form_textarea($d); ?></div>
  </div><!-- row -->  


  <div class="row" align="center">
  	
    <?php echo form_submit("submit","Enviar","class='button button-primary'"); ?>
  </div><!-- row -->


<?php echo form_close(); 

?>
<script>

$(function () {
  $( "#clase" ).change(function() {
    actualizaServicios();
   });

  $("#servicio").change(function() {
    actualizaCosto();
  });

  $('#total').attr('readonly', 'readonly');

});


function actualizaServicios() {
      var t = $("#clase").val();
    
        $.getJSON('/index.php/servicios/serviciosclasejson/' + t, null, function(data) {

        var options = '';

        $.each(data, function(key, val) {
            options += '<option value="' + key + '">' + val + '</option>';
      
        });
        
        $('#servicio').html(options);
   // $("#capacidad option[value='']").remove();
    
    });

 }


function actualizaCosto() {

   var t = $("#servicio").val();

$.getJSON( "/index.php/servicios/detalleserviciojson/" + t, function( data ) {
//var items = [];
  costo = data['costo'];
$("#costo").val(costo);  
  
});
}       

</script>

