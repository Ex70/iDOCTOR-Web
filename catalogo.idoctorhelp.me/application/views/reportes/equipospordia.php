
<?php echo form_open("reportes/equipospordia"); ?>
<div align="center">
		
<table class="buscar">
  <tr>
<th colspan="2">Equipos recibidos y entregados por d&iacute;a</th>
	</tr>
<tr>
  <td>Fecha:</td>
  <td><?php 
    $d = array("name"=>"fecha","value"=>date("Y-m-d"),"class"=>"date-pick","id"=>"fecha1");
  echo form_input($d); ?></td>
</td>
</tr>
<td colspan="2"><div align="center" class="demo"><?php echo form_submit("enviar","Enviar"); ?></div></td>
</tr>
</table>
<?php echo form_close(); ?>


<?php if (isset($equipos)) {

  ?>
<script>
   $("#fecha1").val('<?php echo $_POST['fecha']; ?>');
</script>  
<table class="classgrid">
<th colspan="9">Equipos</th>
<tr>
<th>Num. orden</th>
<th>Cliente</th>
<th>Tipo</th>
<th>Recibido</th>
<th>Entregado</th>
<th>Estatus</th>
</tr>


  <?php

foreach ($equipos as $item) {
  echo "<tr>";
    echo "<td align='center'><a href='/index.php/equipos/modificar/" . $item['id'] . "'>" . $item['num_orden'] . "</td>"; 
  echo "<td>" . $item['cliente']['nombre'] . "</td>";
  echo "<td><b>" . $item['tipo'] . "</b><br><div style='font-size:0.7em;'>" . $item['clase'] . "</div></td>";

  if ($_POST['fecha']==$item['fecha_recibido'])
      $s = " style='font-weight:bold' ";
  else $s = "";

  echo "<td " . $s . ">" . $item['fecha_recibido'] . "</td>";

  if ($_POST['fecha']==$item['fecha_de_entrega'])
      $s = " style='font-weight:bold' ";
  else $s = "";

  echo "<td " . $s . ">" . $item['fecha_de_entrega'] . "</td>";

    if (($item['numero_remision']!="") && ($item['numero_remision']!=0))
       $numrem = " (N.Vta: " . $item['numero_remision'] . ")";
    else $numrem = "";

  echo "<td>" . $item['estatus'] . $numrem . "</td>";
//  echo "<td>" . $item['fecha_recibido'] . "<br>" . $item['hora_recibido'] . "</td>";  
//if ($this->session->userdata('nivel')==1)
  //echo "<td align='center'><a href='/index.php/equipos/eliminar/" . $item['id'] . "/" . $item['num_orden'] . "'><img src='/images/ico_eliminar.png'></a></td>";
  echo "</tr>";
  //$i++; 
}
?>
</table>

<?php



}
  ?>
