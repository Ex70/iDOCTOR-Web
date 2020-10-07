<script language="javascript">
$("a#regresar").attr('href', '/index.php/inicio/iniciar');
$('#titulo').html('B&uacute;squeda de Equipos');
</script>
<div align="center" class="demo">
<?php 
   echo form_open('equipos/index'); ?>
<table class="buscar">
<tr>
<th colspan="6">Buscar</th>
</tr>
<tr>
<td>Nombre cliente</td><td><?php echo form_input("busca_nombre",(isset($busca_nombre) ? $busca_nombre : "" )); ?></td>
<td>Num. de orden</td><td><?php echo form_input("busca_numorden",(isset($busca_numorden) ? $busca_numorden : "")); ?></td>
<td>Num. de serie</td><td><?php echo form_input("busca_numserie",(isset($busca_numserie) ? $busca_numserie : "")); ?></td>
</tr>
<tr>
<td colspan=6"><div align="center"><?php echo form_submit("submit","Filtrar"); ?></div></td>
</tr>
</table>
<?php echo form_close(); ?>
</div>