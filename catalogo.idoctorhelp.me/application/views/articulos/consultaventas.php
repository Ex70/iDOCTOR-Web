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
<th>No. remisi&oacute;n</th>
<th>Cliente</th>
<th>Fecha</th>
<th>Total</th>

</tr>

<?php

foreach ($ventas as $item) {
	echo "<tr>";
	echo "<td width=50><a href='/index.php/articulos/articulosventa/" . $item['numero_remision'] . "?keepThis=true&TB_iframe=true' title='Agregar' class='thickbox'>" 
	   . $item['numero_remision'] . "</a></td>";
	echo "<td>" . $item['nombre'] . "</td>";
	echo "<td align=center>" . $item['fecha'] . "</td>";
	echo "<td align=center>" . number_format($item['total'],2) . "</td>";
	echo "</tr>";	

}

?>
</table>
</div>

<script type="text/javascript" charset="utf-8">
            $(function()
            {
				$('#anio').change(function() {
  					mes = $("#mes").val();
  					anio = $("#anio").val();
  					top.location.href="/index.php/articulos/consultaventas/" + anio + "/" + mes;
				});            
				$('#mes').change(function() {
  					mes = $("#mes").val();
  					anio = $("#anio").val();
  					top.location.href="/index.php/articulos/consultaventas/" + anio + "/" + mes;
				});            

			});
		</script>
