<div align="center"><h2>Piezas usadas por d&iacute;a</h2></div>

<?php if (is_array($piezas)) {
	?>
<div align="center">

<div align="center">
	<form>
		<table style="border:none;width:400px;">
			<tr>
				<td>
		A&ntilde;o:
		<?php
		   $anio = array();
		   for ($i=2011;$i<=2020;$i++) {
		   	  $anio[$i] = $i;		   
		   }
		     echo form_dropdown("anio",$anio,$this->uri->segment(3,date("Y")),"id='anio'");
		?>
		</td><td>
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
        </td><td>
		D&iacute;a:
		<?php
		     $dias = array();
             for($i=1;$i<32;$i++) 
             	$dias[$i] = $i;
		     echo form_dropdown("dia",$dias,$this->uri->segment(5,date("d")),"id='dia'");		   
		?>
	</td></tr></table>
</form>
</div>

<table width="500" id="grid">
<tr>
<th>No. orden</th>
<th>Tipo</th>
<th>Clave</th>
<th>Pieza</th>
<th>Hora</th>

</tr>

<?php
foreach ($piezas as $item) {
	echo "<tr>";
	echo "<td align='center'><a href='/index.php/equipos/modificar/" . $item['id'] . "'>" . $item['num_orden'] . "</a></td>";
	echo "<td align='center'>" . $item['tipo_pieza'] . "</td>";
	echo "<td align='center'>" . $item['pieza_id'] . "</td>";
	echo "<td align='center'>" . $item['pieza_id'] . "&nbsp;" . $item['descripcion'] .  "</td>";
	echo "<td align='center'>" . $item['hora'] . "</td>";
	echo "</tr>";
	
}
//print_r($result);

} // IF ISARRAY 
?>
</table>

</div>


<script type="text/javascript" charset="utf-8">
            $(function()
            {
				$('#anio').change(function() {
  					mes = $("#mes").val();
  					anio = $("#anio").val();
  					dia = $("#dia").val();
  					top.location.href="/index.php/piezas/usadaspordia/" + anio + "/" + mes + "/" + dia;
				});            
				$('#mes').change(function() {
  					mes = $("#mes").val();
  					anio = $("#anio").val();
  					dia = $("#dia").val();
  					top.location.href="/index.php/piezas/usadaspordia/" + anio + "/" + mes + "/" + dia;
				});            
				$('#dia').change(function() {
  					mes = $("#mes").val();
  					anio = $("#anio").val();
  					dia = $("#dia").val();
  					top.location.href="/index.php/piezas/usadaspordia/" + anio + "/" + mes + "/" + dia;
				});            


			});
		</script>


