<div style="padding:20px;font-size:1.3em" id="principal1">
<div class="row">
	<div style="text-align:center"><h4>Vas a realizar un pago a la orden <?php echo $equipo['num_orden']; ?></h4></div>
	<div align="center">
	<table class='tablapagos'>
		<tr><td>Tipo de pago:</td><td><?php echo $this->uri->segment(4); ?></td></tr>
		<tr><td>Importe total de servicios:</td><td  style='text-align:right'><?php echo number_format($equipo['importe_servicios'],2); ?></td></tr>
		<tr><td>Pagos realizados:</td><td  style='text-align:right'><?php echo number_format($equipo['pagos'],2); ?></td></tr>
		<tr><td>Resta:</td><td  style='text-align:right'><?php echo number_format($equipo['importe_servicios']-$equipo['pagos'],2); ?></td></tr>
	</table>
    </div>
</div>
<div style="height:20px"></div>
<div class="row" style="height:40px">
    <div class="three columns">Importe del pago</div>
    <div class="nine columns"><?php 
      if ($this->uri->segment(4,'')=="ENTREGA")
          $valor = number_format($equipo['importe_servicios']-$equipo['pagos'],2);
      else $valor = "0.00";
      echo form_input("pago",$valor,"style='width:200px;text-align:right' id='importe'"); ?></div>    
</div>
<div class="row" style="height:40px">
    <div class="three columns">Forma de pago</div>
    <div class="nine columns">
    <?php
        $opciones = array("NOESP"=>"No especificada","EFECTIVO"=>"Efectivo",
        "TARJETA"=>"Tarjeta de crédito/débito",
        "TRANSFERENCIA"=>"Transferencia bancaria",
        "CHEQUE"=>"Cheque"); 
       echo form_dropdown("sscta",$opciones,"NOESP","id='forma'");
       ?>

    </div>    
</div>
<div class="row" style="height:40px">
    <div class="three columns">Concepto u observación</div>
    <div class="nine columns">
    <?php
       $d = array("name"=>"concepto","rows"=>3,"cols"=>20,"id"=>"concepto");
       echo form_textarea($d);
       ?>

    </div>    
</div>

<div class="row" style="text-align:center" id='botones'>
    <div class="six columns"><a href="#" onclick='cancelar();' class="button" style='width:200px;height:100px;background-color:#ccc'>Cancelar</a></div>
    <div class="six columns"><a href="#" onclick='aplicarPago();' class="button" style='width:200px;height:100px;background-color:#0f0'>Aplicar el pago</a></div>    
</div>
<div id='aaa'></div>


</div>

<script>
   function aplicarPago() {

   	            $.ajax({
                    url:'/index.php/movimientos/guardarpagoaequipo',
                    type:'POST',
                    data: {cta: 'ENTRADAS',
                    	   scta: '<?php echo $this->uri->segment(4); ?>',
                           sscta: $("#forma").val(),
                           importe: $("#importe").val(),
                           concepto: $("#concepto").val(),
                           equipo_id: '<?php echo $equipo['id']; ?>',
                           id: '0' // para indicar que agrega un pago
                           },

                    success:function(result){
                        //$("#response").text(result);
                        
                        if (result!='') {
                           $("#aaa").html('/index.php/equipos/reportes/notadeventamovimiento/' + result);
                           
                            parent.ActualizarMovimientosConRetardo();
                            parent.RedimensionarTBWindow();
                            $("#principal1").hide(300);
                            $('body').css('height', '1000px');
                            $('body').html('');
                            setTimeout(function() {
                               self.location.href = '/index.php/equipos/reportes/notadeventamovimiento/' + result; 
                            },1500);


                        }


                    }

            });


   }

   function cancelar() {
     parent.ActualizarYCerrarMovimientos();
   }
</script>
