<div align="center">
	<form>A&ntilde;o:
		<?php
		   $anio = array();
		   for ($i=2011;$i<=2020;$i++) {
		   	  $anio[$i] = $i;		   
		   }
		     echo form_dropdown("anio",$anio,$this->uri->segment(3,date("Y")),"id='anio'");
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
		     echo form_dropdown("mes",$meses,$this->uri->segment(4,date("m")),"id='mes'");
		?>
</form>
</div>
<div align="center">
<table width="500" id="grid">
<tr>
<th>Fecha</th>
<th>Pieza</th>
<th>Movimiento</th>
<th>Cantidad</th>
<th>Num. orden</th>
</tr>

<?php


foreach ($movimientos as $item) {
	echo "<tr>";
	echo "<td>" . $item['fecha'] . " " . $item['hora'] . "</td>";
	echo "<td>" . $item['pieza_id'] . " " . $item['descripcion'] . "</td>";
	echo "<td align=center>" . $item['tipo_movimiento'] . "</td>";
	echo "<td align=center>" . $item['cantidad'] . "</td>";
	echo "<td align=center>" . $item['num_orden'] . "</td>";
	echo "</tr>";	

}

?>
</table>
</div>
<div align="center"><?php echo $this->pagination->create_links(); ?></div>

<script type="text/javascript" charset="utf-8">
            $(function()
            {
				$('#anio').change(function() {
  					mes = $("#mes").val();
  					anio = $("#anio").val();
  					top.location.href="/index.php/piezas/consultamovimientos/" + anio + "/" + mes;
				});            
				$('#mes').change(function() {
  					mes = $("#mes").val();
  					anio = $("#anio").val();
  					top.location.href="/index.php/piezas/consultamovimientos/" + anio + "/" + mes;
				});            

			});
		</script>
