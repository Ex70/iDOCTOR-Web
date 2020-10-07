<script>
	function guardar(id) {
		tipo = $("#tipo" + id).val();
		tabla = $("#tabla" + id).val();
	    campo = $("#campo" + id).val();
	    fontname = $("#fontname" + id).val();
	    fontsize = $("#fontsize" + id).val();
	    valormarca = $("#valormarca" + id).val();
	    x = $("#x" + id).val();
	    y = $("#y" + id).val();
	    w = $("#w" + id).val();
	    h = $("#h" + id).val();
	    texto = $("#texto" + id).val();

		$.post("/index.php/reportes/guardarreporte", { id: id, 
			                                           tipo: tipo, 
			                                           tabla:tabla,
			                                           campo:campo,
			                                           fontname:fontname,
			                                           fontsize:fontsize,
			                                           valormarca:valormarca,
			                                           x:x,
			                                           y:y,
			                                           w:w,
			                                           h:h,
			                                           texto:texto },
		  function(data) {
   alert("Data Loaded: " + data);
 } );
		
	}
</script>

<div style="height:400px">
	<div align="center"><h2><?php echo $elementos[0]->reporte; ?></h2></div>
	<?php echo form_open('reportes/guardar'); ?>
<table style="width:100%;border:1px solid;font-size:0.8em;" class="grid0">
	<tr>
		<th>Tipo</th>
		<th>Tabla</th>
		<th>Campo</th>
		<th>Tipo de letra</th>
		<th>Tama&ntilde;o de letra</th>
		<th>Valor marca</th>
		<th>x</th>
		<th>y</th>
		<th>w</th>
		<th>h</th>
		<th>Texto o ruta</th>
		<th>Guardar</th>
	</tr>
<?php 
$fonts=array("Verdana"=>"Verdana","Helvetica"=>"Helvetica","Arial"=>"Arial","Tahoma"=>"Tahoma");
foreach ($elementos as $item){
	echo "<tr>";
	echo "<td align='center' style='border:1px solid'>";
	echo form_dropdown("tipo" . $item->id,$tipos,$item->tipo,"id='tipo" . $item->id . "'") . "</td>";
	$dtabla = array("name"=>"tabla","value"=>$item->tabla,"id"=>"tabla" . $item->id);
	echo "<td align='center' style='border:1px solid'>" . form_input($dtabla) . "</td>";
	$dcampo = array("name"=>"campo","value"=>$item->campo,"id"=>"campo" . $item->id);
	echo "<td align='center' style='border:1px solid'>" . form_input($dcampo) . "</td>";
	echo "<td align='center' style='border:1px solid'>" . form_dropdown("fontname",$fonts,$item->fontname,"id='fontname" . $item->id . "'") . "</td>";
	$dfontsize = array("name"=>"fontsize","value"=>$item->fontsize,"size"=>4,"id"=>"fontsize" . $item->id);
	echo "<td align='center' style='border:1px solid'>" . form_input($dfontsize) . "</td>";
	$dvalormarca = array("name"=>"valormarca","value"=>$item->valormarca,"id"=>"valormarca" . $item->id);
	echo "<td align='center' style='border:1px solid'>" . form_input($dvalormarca) . "</td>";

	$d_x = array("name"=>"x","value"=>$item->x,"size"=>3,"id"=>"x" . $item->id);
	$d_y = array("name"=>"y","value"=>$item->y,"size"=>3,"id"=>"y" . $item->id);
	$d_w = array("name"=>"w","value"=>$item->w,"size"=>3,"id"=>"w" . $item->id);
	$d_h = array("name"=>"h","value"=>$item->h,"size"=>3,"id"=>"h" . $item->id);
	
	echo "<td align='center' style='border:1px solid'>" . form_input($d_x) . "</td>";
	echo "<td align='center' style='border:1px solid'>" . form_input($d_y) . "</td>";
	echo "<td align='center' style='border:1px solid'>" . form_input($d_w) . "</td>";
	echo "<td align='center' style='border:1px solid'>" . form_input($d_h) . "</td>";
	$d_txt = array("name"=>"texto","value"=>$item->texto,"cols"=>"10","rows"=>"3","style"=>"width:100%","id"=>"texto" . $item->id);
	echo "<td align='center' style='border:1px solid'>" . form_textarea($d_txt) . "</td>";
	echo "<td align='center'><input type='button' value='Guardar' onClick='guardar(\"" . $item->id . "\");'></td>";
	echo "</tr>";
}	
?>	
</table>
<?php echo form_close(); ?>
</div>
<div id="respuesta"></div>
