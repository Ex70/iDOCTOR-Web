<?php $this->load->helper('form'); 
  
?>
<script language="javascript">

</script>
<div style='height:100px;'></div>
<div align='center'>
<?php echo form_open('servicios/index'); 

	   echo form_dropdown("clase",$clases,"","class='selectgrande'");
?>
<div style='height:70px;'></div>
	
	<div class="row"><?php echo form_submit("submit","Filtrar", "class='button button-primary'"); ?></div>
<div style='height:70px;'></div>
</div>
<?php echo form_close(); ?>

