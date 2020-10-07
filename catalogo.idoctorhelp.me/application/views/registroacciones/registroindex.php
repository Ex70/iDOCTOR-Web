
<div align="center">
	<?php echo form_open("registroacciones/index"); ?>
A&ntilde;o:
		<?php
		   $anios = array();
		   for ($i=2011;$i<=2020;$i++) {
		   	  $anios[$i] = $i;		   
		   }
		     echo form_dropdown("anio",$anios,$anio);
		?>
		<br>
		Mes:
		<?php
          $meses = array("1"=>"Enero",
          	             "2"=>"Febrero",
          	             "3"=>"Marzo",
          	             "4"=>"Abril",
          	             "5"=>"Mayo",
          	             "6"=>"Junio",
          	             "7"=>"Julio",
          	             "8"=>"Agosto",
          	             "9"=>"Septiembre",
          	             "10"=>"Octubre",
          	             "11"=>"Noviembre",
          	             "12"=>"Diciembre");
		     echo form_dropdown("mes",$meses,$mes);
		?>
		D&iacute;a:
		<?php
		   $dias = array();
		   for ($i=1;$i<=31;$i++) {
		   	  $dias[$i] = $i;		   
		   }
		     echo form_dropdown("dia",$dias,$dia);
		?>
<br/>
<?php echo form_submit("enviar","Enviar"); ?>
<?php echo form_close(); ?>
</div>

<div align="center">
<table width="500" id="grid">
<tr>
<th>ID</th>
<th>Usuario</th>
<th>Fecha y hora</th>
<th>Acci&oacute;n</th>
<th>Tabla</th>
<th>Descripci&oacute;n</th>
</tr>

<?php
foreach ($result as $item) {
	echo "<tr>";
	echo "<td>" . $item['id'] . "</td>";
	echo "<td>" . $item['usuario'] . "</td>";
	echo "<td>" . $item['fecha_hora'] . "</td>";
	echo "<td>" . $item['accion'] . "</td>";
	echo "<td>" . $item['tabla'] . "</td>";
	echo "<td>" . $item['detalle'] . "</td>";			
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



