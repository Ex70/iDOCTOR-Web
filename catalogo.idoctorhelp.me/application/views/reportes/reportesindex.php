<div style="height:60px"></div>
<?php echo form_open("reportes/detallereporte"); ?>
	<div align="center" style="height:40px;">Escoja un reporte a modificar:</div>
	<div align="center" style="height:40px;">
	<?php
	  echo form_dropdown("reporte",$listareportes,"");
	?>
	</div>
	<div align="center" class="demo" style="height:80px;"><?php echo form_submit("enviar","Enviar"); ?></div>
<?php echo form_close(); ?>
