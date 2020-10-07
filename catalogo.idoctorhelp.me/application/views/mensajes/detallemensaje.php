<?php
  echo form_open("mensajes/guardar");
?>
<div align="center">
<table style="width:600px;border:none">
	<tr>
		<td>Enviar a:</td>
		<td><?php echo form_dropdown("usuario_destinatario_id",$usuarios,"");
		?></td>
	<tr>
		<td>Titulo</td>
		<td><?php echo form_input("titulo",""); ?></td>
	</tr>
	<tr>
		<td>Mensaje</td>
		<td><?php 
	$d = array("name"=>"mensaje","cols"=>"30","rows"=>"5");
	echo form_textarea($d); ?></td>
	</tr>
	<tr>
		<td colspan="2">
			<div style="padding:0px;width:800px;float:right;text-align:center" class="demo">

			<?php echo form_submit("enviar","Enviar"); ?></td>

		</div>
	</tr>
</table>
</div>


<?php
  echo form_close();
?>