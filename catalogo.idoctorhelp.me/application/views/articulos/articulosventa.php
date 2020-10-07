<div style="height:27px"></div>
<div align="center"><h3>Detalle de venta</h3></div>
<div style="height:27px"></div>
<table id="grid0" style="width:100%">
<tr>
	<th>Clave</th>
	<th>Descripci&oacute;n</th>
	<th>Precio</th>
</tr>
	<?php
	  foreach ($articulos as $item) {
         echo "<tr>";
         echo "<td>" . $item['articulo_id'] . "</td>";
         echo "<td>" . $item['descripcion'] . "</td>";
         echo "<td>" . number_format($item['precio'],2) . "</td>";
         echo "</tr>";
	  }
    ?>
</table>
<div style="height:27px"></div>
<div class="demo" align="center"><a href="http://localhost/index.php/articulos/notadeventa3/<?php echo $this->uri->segment(3); ?>" target="_blank">Nota de venta</a></div>
