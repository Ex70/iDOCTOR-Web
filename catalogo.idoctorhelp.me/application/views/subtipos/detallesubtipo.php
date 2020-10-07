
<?php echo form_open('subtipos/guardar'); 
if ($id!="") 
	echo form_hidden("id",$id);


?>


  <div class="row hei50">

	<div class="six columns">Id: </div><div class="six columns"><?php echo form_input("id",$id);  ?></div>
	
  </div> <!-- row -->
   <div class="row hei50">
    <div class="six columns">Tipo al que pertenece:</div><div class="six columns"><?php 
    if (isset($tipos))
	  echo form_dropdown("tipo",$tipos,$tipo);
	else
       echo $tipo; ?></div>
  </div> <!-- row -->

  <div class="row hei50">
  <div class="six columns">Capacidad:</div>
    <div class="six columns"><?php //echo form_input("estatus",(isset($estatus) ? $estatus : "")); 

	   echo form_input("capacidad",$capacidad);
	   
	   if ($id!="") 
	       echo form_hidden("accion", "u");
		 else
			echo form_hidden("accion", "i");

	?></div>
  </div> <!-- row -->
  
  <div class="row hei50">
    <div align="center"><?php echo form_submit("submit","Enviar","class='button button-primary'"); ?></div>
  </div> <!-- row -->


<?php echo form_close(); 

?>

