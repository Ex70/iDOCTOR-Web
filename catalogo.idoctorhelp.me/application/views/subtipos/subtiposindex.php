<script language="javascript">
$("a#regresar").attr('href', '/index.php/tipos/modificar/<?php echo $tipo;?>');
$('#titulo').html('Lista de Subtipos de Dispositivos (capacidades)');
</script>
<div class="row" align="center">
<h5>Capacidades para el tipo:<br><strong> <?php echo $tipo; ?></strong></h5>	
</div>
<div align="center" class="row">
<table style="height:100%"	id="grid">
<tr>
<th>Id</th>
<th>Capacidad</th>
<?php
 if ($this->session->userdata('nivel')==1) 	
	echo "<th>Eliminar</th>";		
?>

</tr>

<?php
foreach ($result as $item) {
	echo "<tr>";
	echo "<td><a href='/index.php/subtipos/modificar/" . $item['id'] . "'>" . $item['id'] . "</td>";
	echo "<td>" . $item['capacidad'] . "</td>";
 if ($this->session->userdata('nivel')==1) 	
	echo "<td align='center'><a href='/index.php/subtipos/eliminar/" . $item['tipo'] . "/" . $item['capacidad'] . "'><img src='/images/ico_eliminar.png'></a></td>";		

	echo "</tr>";	
}
//print_r($result); 
?>
</table>
<div class="paginate" align="center">
<?php

//echo $this->pagination->create_links();		
		
?>
</div>
</div>
<div class="row" align="center">
<a class="button button-primary" href="/index.php/subtipos/agregar/<?php echo $tipo; ?>">Agregar subtipo</a>
</div>

