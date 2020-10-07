<?php echo form_open('articulos/resultados'); ?>
<div align="center">
<table class="buscar">
<th colspan="3">Buscar por descripci&oacute;n</th>
<tr>
<td>Nombre:</td>
<td><?php echo form_input("busca_descripcion",(isset($busca_descripcion) ? $busca_descripcion : "")); ?></td>
<td><div align="center"><?php echo form_submit("submit","Filtrar"); ?></div></td>
</tr>
</table>
<?php echo form_close(); ?>