
<?php echo form_open('movimientos/guardar'); 

/*         if ($id!="") {
	       echo form_hidden("accion", "u");
		   echo form_hidden("id",$id);
		 }
		 else {
			echo form_hidden("accion", "i");
      echo form_hidden("id","");
      }
      */
    echo form_hidden("id",$id);
    echo form_hidden("cta",$cta);
			

?>


  <div class="row">
    <div class="three columns">Fecha</div>
    <div class="nine columns"><?php
    	$data = array(
              'name'        => 'fecha',
              'id'          => 'fecha',
              'value'       => $fecha,
              'maxlength'   => '20',
              'style'       => 'width:200px'
            );  
    echo form_input($data); ?></div>
  </div><!-- row -->

  <div class="hora">
    <div class="three columns">Hora</div>
    <div class="nine columns"><?php
      $data = array(
              'name'        => 'hora',
              'id'          => 'hora',
              'value'       => $hora,
              'maxlength'   => '20',
              'style'       => 'width:200px'
            );  
    echo form_input($data); ?></div>
  </div><!-- row -->

  <div class="row">
    <div class="three columns">Tipo</div>
    <div class="nine columns"><?php
    echo form_dropdown("scta",$sctas,$scta); ?>
    </div>

  </div><!-- row -->

  <div class="row">
    <div class="three columns">Pago hecho con</div>
    <div class="nine columns"><?php
    echo form_dropdown("sscta",$ssctas,$sscta); ?>
    </div>

  </div><!-- row -->


  <div class="row">
    <div class="three columns">Concepto</div>
    <div class="nine columns"><?php
    echo form_input("concepto",$concepto,"style='width:400px'"); ?>
    </div>

  </div><!-- row -->


  <div class="row">
    <div class="three columns">Importe</div>
    <div class="nine columns"><?php
      $data = array(
              'name'        => 'importe',
              'id'          => 'importe',
              'value'       => $importe,
              'maxlength'   => '20',
              'style'       => 'width:250px;text-align:right'
            );  
    echo form_input($data); ?></div>
  </div><!-- row -->

  <div class="row">
    <div class="three columns">Número de cuenta bancaria</div>
    <div class="nine columns"><?php
    echo form_input("numero_cuenta_bancaria",$numero_cuenta_bancaria,"style='width:300px'"); ?>
    </div>

  </div><!-- row -->


  
  <div class="row">
    <div class="three columns">&nbsp;</div>
    <div class="three columns"><?php echo form_submit("enviardatos","Guardar","class='button button-primary'"); ?></div>
    <div class="six columns">
     <?php if (($id!="") && ($this->session->userdata('nivel')==1)) { ?> 
      <a href="#" onclick='eliminar()' class="button">Eliminar</a>
     <?php } ?> 
    </div>
  </div><!-- row -->

<?php echo form_close(); ?>

<script>

 function eliminar() {
    if (confirm('¿Eliminar este movimiento?')) {
      top.location.href='/index.php/movimientos/eliminar/<?php echo $id; ?>';
    }
 }

 $(document).ready(function () {

       $( "#fecha" ).datepicker({ dateFormat: 'yy-mm-dd' });




  }); 

</script>
