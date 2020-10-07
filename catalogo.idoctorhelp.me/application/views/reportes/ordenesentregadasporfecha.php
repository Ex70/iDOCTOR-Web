<script language="javascript">
$('#titulo').html('Ordenes entregadas por fechas');
</script>

<?php echo form_open('reportes/ordenesentregadasporfecha'); ?>
<div align="center">
		
<table class="buscar">
<th colspan="3">Especificar fechas</th>
	
<tr>
<td>Fecha inicial:</td>
<td><?php 
	$val = "";
	
	$dat = array(
              'name'        => 'fechaini',
              'id'          => 'fechaini',
              'value'       =>  date("Y-m-d", strtotime(date("Y") . "-01-01	")),
              'maxlength'   => '20',
              'size'        => '15',
              'class'       => 'date-pick'
            );  
   echo form_input($dat);
	
	?></td>
<td>&nbsp;</td>	
</tr>
<tr>
<td>Fecha final</td>
<td>
<?php 
	$val = "";
	
	$dat = array(
              'name'        => 'fechafin',
              'id'          => 'fechafin	',
              'value'       => date('Y-m-d'),
              'maxlength'   => '20',
              'size'        => '15',
              'class'       => 'date-pick'
            );  
   echo form_input($dat);
	
	?>	
</td>
<td><div align="center"><?php echo form_submit("submit","Filtrar"); ?></div></td>
</tr>
</table>
<?php echo form_close(); ?>
<?php if (is_array($result)) {
	?>
<div align="center">

<table width="500" id="grid">
<tr>
<th>No. orden</th>
<th>Tipo</th>
<th>Cliente</th>
<th>Fecha entregado</th>

</tr>

<?php
foreach ($result as $item) {
	echo "<tr>";
	echo "<td align='center'><a href='/index.php/equipos/modificar/" . $item['id'] . "'>" . $item['num_orden'] . "</a></td>";
	echo "<td align='center'>" . $item['tipo'] . "</td>";
	echo "<td align='center'>" . $item['nombre'] . "</td>";
	echo "<td align='center'>" . $item['fecha'] . "</td>";
	echo "</tr>";
	
}
//print_r($result);

} // IF ISARRAY 
?>
</table>

</div>



