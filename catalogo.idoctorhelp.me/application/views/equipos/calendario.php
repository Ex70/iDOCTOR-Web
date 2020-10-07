<style>
	.celdacal A:link {color:#000;text-decoration: none}
    .celdacal A:visited {color:#000;text-decoration: none}
    .celdacal A:active {color:#000;text-decoration: none}
    .celdacal A:hover {text-decoration: underline; color: #fff;}
</style>
<script language="javascript">
$("a#regresar").attr('href', '<?php echo $urlregresar; ?>');
$('#titulo').html('<?php echo $titulo; ?>');
</script>
<div align="center">
<?php
  echo $calendario;
?>
</div>
<div align="center">
<form>
<table width="800" border="0" align="center">
	<tr>
	<td style='background-color: #ff0000;'>
		Diagnosticar
	</td>	
    <td style='background-color: #ffff00;'>
		En espera
	</td>
	<td style='background-color: #00ff00;'>
		Entregar
	</td>	
	<td style='background-color: #0000ff;'>
		En abandono
	</td>			
	<td style='background-color: #cccccc;'>
		Notificar
	</td>
	<td style='background-color: #ffffff;'>
		Reparar
	</td>
    <td style='background-color: #00ffff;'>
		Entrega tentativa
	</td>	
		
	</tr>
	<tr>
	<td style='background-color: #ff0000;text-align:center;'>
		<input type="button" id="diag" value="Ocultar/mostrar">
	</td>	
    <td style='background-color: #ffff00;text-align:center;'>
		<input type="button" id="esp" value="Ocultar/mostrar">
	</td>
	<td style='background-color: #00ff00;text-align:center;'>
		<input type="button" id="ent" value="Ocultar/mostrar">
	</td>	
	<td style='background-color: #0000ff;text-align:center;'>
		<input type="button" id="aban" value="Ocultar/mostrar">
	</td>			
	<td style='background-color: #cccccc;text-align:center;'>
		<input type="button" id="notif" value="Ocultar/mostrar">
	</td>
	<td style='background-color: #ffffff;text-align:center;'>
		<input type="button" id="rep" value="Ocultar/mostrar">
	</td>
    <td style='background-color: #00ffff;text-align:center;'>
		<input type="button" id="enttent" value="Ocultar/mostrar">
	</td>	
		
	</tr>
</table>
</form>
<script>
$("#diag").click(function () {
$(".diagnosticar").toggle("slow");
});

$("#esp").click(function () {
$(".enespera").toggle("slow");
});     

$("#ent").click(function () {
$(".entregar").toggle("slow");
}); 

$("#aban").click(function () {
$(".abandono").toggle("slow");
}); 

$("#notif").click(function () {
$(".notificar").toggle("slow");
}); 

$("#rep").click(function () {
$(".reparar").toggle("slow");
}); 


$("#enttent").click(function () {
$(".entregatentativa").toggle("slow");
}); 
</script>
</div>

