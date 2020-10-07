
<div style='height:100px;'></div>
<div align='center'>
<?php echo form_open('piezas/index'); 
    //$options = array("size"=>8);
	   echo form_dropdown("clase",$clases,"");

  if ($this->session->userdata('nivel')==1) 	{

	   
	   echo "<p>";
	   echo form_checkbox('modificar','S');
	   echo "&nbsp;Permitir la modificaci&oacute;n";


	}
?>
<div style='height:70px;'></div>
	
	<div style="align:center"><?php echo form_submit("submit","Filtrar","class='button button-primary'"); ?></div>
<div style='height:70px;'></div>
</div>
<?php echo form_close(); ?>

