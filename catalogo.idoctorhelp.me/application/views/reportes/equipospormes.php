<script language="javascript">
$('#titulo').html('Exportar ordenes de equipos a Excel');
</script>

<form>
<div align="center">
		
<table class="buscar">
<th colspan="3">Exportaci&oacute;n a Excel de &oacute;rdenes</th>
	
<tr>
<td>A&ntilde;o:</td>
<td><?php 
	for($i=2011;$i<=2020;$i++) {
		$opcion[$i] = $i;
	}
	echo form_dropdown("anio",$opcion,date("Y"),"id='anio'")
	?></td>
<td>&nbsp;</td>	
</tr>
<tr>
<td>Mes</td>
<td>
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
</td>
<td><div align="center" class="demo"><input type="button" value="Enviar" onClick="enviar();"></div></td>
</tr>
</table>
</form>
<script>
  function enviar() {
  	mes = $("#mes").val();
  					anio = $("#anio").val();
  					top.location.href="/index.php/equipos/exportarequipos/" + anio + "/" + mes;
  }
</script>
