<div align="center">
<?php echo form_open('piezas/index'); ?>
<div align="center">
<table class="buscar">
<th colspan="3">Consulta de existencias</th>
<tr>
<td>Clase:</td>
<td><?php  echo $clase; ?></td>

<td class="demo"><a href="/index.php/bitacoras/agregar/<?php echo $this->uri->segment(4); ?>">Regresar</a></td>	
</tr>
<tr>
</table>
<?php echo form_close(); ?>
<?php echo form_open('piezas/guardarmodificacionespiezas'); ?>
<table width="700" id="grid0">
<tr>
<th>ID</th>
<th>Descripci&oacute;n</th>
<th>Cant. nuevas</th>
<th>Cant. usadas</th>
<th>Cant. recicladas</th>
</tr>

<?php
if ((isset($_POST['modificar'])) && ($_POST['modificar']=='S'))
    $modificar = 1;
else $modificar = 0;

$j = 0;

foreach ($result as $item) {
	echo "<tr>";
    echo "<td>" . $item['id'] . "</td>";
	echo "<td>" . $item['descripcion'] . "</td>";
	echo "<td align='right'>";
	if ($modificar) echo form_hidden('id' . $j, $item['id']);

	if ($modificar) echo form_input(array('name'=>'cant_nuevas' . $j,'value'=>$item['cant_nuevas'],'size'=>6)); else echo $item['cant_nuevas'];
	echo "</td>";
	echo "<td align='right'>";
	if ($modificar) echo form_input(array('name'=>'cant_usadas' . $j,'value'=>$item['cant_usadas'],'size'=>6)); else echo $item['cant_nuevas'];
	echo "</td>";
	echo "<td align='right'>";
	if ($modificar) echo form_input(array('name'=>'cant_recicladas' . $j,'value'=>$item['cant_recicladas'],'size'=>6)); else echo $item['cant_nuevas'];
	echo "</td>";
 	
	echo "</tr>";	
	
	
	
	$j++;
}
//print_r($result); 
?>
</table>

<div class="paginate" align="center">
<?php
echo $this->pagination->create_links();		
		
?>
</div>

</div>

<?php echo form_close(); ?>

