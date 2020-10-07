<?php echo form_open('clientes/resultados'); ?>
<div align="center">
<table class="buscar">
<th colspan="3">Buscar por nombre</th>
<tr>
<td>Nombre:</td>
<td><?php echo form_input("busca_nombre",(isset($busca_nombre) ? $busca_nombre : "")); ?></td>
<td><div align="center"><?php echo form_submit("submit","Filtrar"); ?></div></td>
</tr>
</table>
<?php echo form_close(); ?>