

<?php echo form_open('articulos/index'); ?>
<div align="center">



<div class="row">
<h4>Buscar por descripción</h4>
</div>



<div class="row">
<div class="four columns" align="right" style="padding-top:10px">Descripci&oacute;n:</div>
<div class="four columns" align="left"><?php echo form_input("busca_nombre",(isset($busca_nombre) ? $busca_nombre : "")); ?></div>
<div class="four columns" align="left"><?php echo form_submit("submit","Filtrar","class='button button-primary'"); ?></div>
</div>


<?php echo form_close(); ?>

<table width="100%" id="grid">
<tr>
<th>ID</th>
<th>Descripci&oacute;n</th>
<th>Clases</th>
<th>Precio</th>
<th>Eliminar</th>
</tr>

<?php
foreach ($result as $item) {
	echo "<tr>";
	echo "<td><a href='/index.php/articulos/modificar/" . $item['id'] . "'>" . $item['id'] . "</a></td>";
	echo "<td><a href='/index.php/articulos/modificar/" . $item['id'] . "'>" . $item['descripcion'] . "</a></td>";
	echo "<td>" . $item['clase_compatibilidad'] . "</td>";
	echo "<td>" . $item['precio'] . "</td>";
	echo "<td align='center'><a href='/index.php/articulos/eliminar/" . $item['id'] . "'><img src='/images/ico_eliminar.png'></a></td>";
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
<div align="center">
<a class="button button-primary" href="/index.php/articulos/agregar">Agregar art&iacute;culo</a>
</div>
</div>

