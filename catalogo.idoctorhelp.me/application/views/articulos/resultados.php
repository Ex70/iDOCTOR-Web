<script language="javascript">
$('#titulo').html('Resultados de b&uacute;squeda');


function actualizarycerrar(id) {
	top.seleccionararticulo(id);
	window.parent.tb_remove();
}
</script>



<table width="500" id="grid" align="center">
<tr>
<th>ID</th>
<th>Descripci&oacute;n</th>
<th>Compatibilidad</th>
<th>Precio</th>
</tr>

<?php
foreach ($result as $item) {
	echo "<tr>";
	echo "<td>" . $item['id'] . "</td>";
	echo "<td><a href='#' onClick='actualizarycerrar(\"" .  $item['id'] . "\");'>" . $item['descripcion'] . "</a></td>";
	echo "<td>" . $item['clase_compatibilidad'] . "</td>";
	echo "<td>" . number_format($item['precio'],2) . "</td>";
	echo "</tr>";	
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

