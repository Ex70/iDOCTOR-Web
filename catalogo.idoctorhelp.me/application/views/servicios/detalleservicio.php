
<?php echo form_open('servicios/guardar'); ?>
<div class="row">
 
    <?php
    if (isset($estatus)) {
		echo "<div>Id: " . $id . "</div>";
	}
  ?>
    <div class='three columns'>ID</div>
    <div class="nine columns"><?php //echo form_input("estatus",(isset($estatus) ? $estatus : "")); 

	   echo form_input("id",$id);
	   
	   if ($id!="") {
	       echo form_hidden("accion", "u");
		   //echo form_hidden("id",$id);
	   }
		 else {
			    echo form_hidden("accion", "i");
				
		       }
	?></div>
  
  </div><!-- row -->
  <div class="row">
    <div class="three columns">Descripci&oacute;n</div>
    <div class="nine columns">
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
    
    </div>
 </div><!-- row -->
 <div class="row">

  
    <div class="three columns">Costo</div>
    <div class="nine columns"><?php 

	   echo form_input("costo",sprintf("%01.2f", $costo));
	   
	   
	?></div>
  
  </div> <!-- row -->
  
 <div class="row">

  
    <div class="three columns">Clase</div>
    <div class="nine columns"><?php 
$pos = strpos($clase," ");
if ($pos===false)
	   echo form_dropdown("clase",$clases,$clase);
else {
     $d = array("name"=>"clase","value"=>$clase,"size"=>"70");
     echo form_input($d);
  }   
	   
	   
	?></div>
  
  </div>  
  
  
      <div class="row" align="center">
    <?php echo form_submit("submit","Enviar","class='button button-primary'"); ?>
  </div>

  <div class="row" align="center">
    <a href="/index.php/servicios/clase/<?php echo $clase; ?>">Regresar a la clase</a>
  </div>



<?php echo form_close(); 

?>

