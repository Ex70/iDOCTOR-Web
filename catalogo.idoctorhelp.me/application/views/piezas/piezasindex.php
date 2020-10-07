


<?php echo form_open('piezas/index'); ?>







<?php if (isset($clases)) { ?>

<div class="row">
<h4>Buscar por descripción</h4>
</div>

<div class="row">	

<div class="four columns" align="left">Clase:</div>
<div class="eight columns" align="left"><?php  echo form_dropdown("clase",$clases,$clase); ?></div>


</div>

<div class="row">
<div class="four columns" align="left">Descripci&oacute;n:</div>
<div class="four columns" align="left"><?php echo form_input("busca_descripcion",(isset($busca_descripcion) ? $busca_descripcion : "")); ?></div>
<div class="four columns" align="left"><?php echo form_submit("submit","Filtrar","class='button button-primary'"); ?></div>
</div>


<?php } ?>


<?php echo form_close(); ?>




<?php 

if (isset($_POST['modificar'])) {
   if ($_POST['modificar']=='S')
   	    $modificar = 1;

   if ($_POST['modificar']=='R')
   	    $modificar = 2;
}

else $modificar = 0;


?>




<div class="row" align="center">
<?php echo form_open('piezas/guardarmodificacionespiezas'); ?>
<table width="100%" id="grid" style="border:1px solid;">
<tr>
<th width="80">ID</th>
<th>Descripci&oacute;n</th>


<th>Clase</th>
     	<th>Eliminar</th>

</tr>

<?php

$j = 0; 

foreach ($result as $item) {
	echo "<tr>";
 if (($this->session->userdata('nivel')==1) && ($modificar==1)) 	
	echo "<td><a href='/index.php/piezas/modificar/" . $item['id'] . "'>" . $item['id'] . "</td>";
 else echo "<td>" . $item['id'];
 echo form_hidden("id" . $j, $item['id']);
 echo "</td>";
 $desc = $item['descripcion'];
$desc = str_replace('Ã', 'í', $desc);
$desc = str_replace('í¡', 'á', $desc);
$desc = str_replace('í³', 'ó', $desc);
$desc = str_replace('Ã±', 'ñ', $desc);





	echo "<td><strong>" . $desc . "</strong></td>";



	echo "<td>" . $item['clase'] . "</td>";

	   echo "<td align='center'><a href='/index.php/piezas/eliminar/" . $item['id'] . "'><img src='/images/ico_eliminar.png'></a></td>";		

	echo "</tr>";	
	
	
	$j++;
}
 
?>
</table>
</div>




<div align="center"><a class='button button-primary' href="/index.php/piezas/agregar<?php if ($clase!="") echo "/" . $clase; ?>">Agregar pieza</a></div>

<?php echo form_close(); ?>

