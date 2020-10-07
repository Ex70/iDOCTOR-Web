<script>
  $(function() {
    $("#meses").change(function() {
      top.location.href='/index.php/reportesadministracion/listadoremisiones/' + $("#anios").val() + "/" + $("#meses").val() + "/" + $("#sucursal").val();
    });
    $("#anios").change(function() {
      top.location.href='/index.php/reportesadministracion/listadoremisiones/' + $("#anios").val() + "/" + $("#meses").val() + "/" + $("#sucursal").val();
    });
    $("#sucursal").change(function() {
      top.location.href='/index.php/reportesadministracion/listadoremisiones/' + $("#anios").val() + "/" + $("#meses").val() + "/" + $("#sucursal").val();
    });


  })
</script>

<div class="row">
    <div class="three columns" style="text-align:right">
        Sucursal:
    </div>
    <div class="three columns">
        <?php
          
           echo form_dropdown("sucursal",$sucursales,$this->uri->segment(5),"id='sucursal'");
           ?>
    </div>
    <div class="six columns"></div>
   
</div>

<div class="row">
    <div class="three columns" style="text-align:right">
        Mes:
    </div>
    <div class="three columns">
        <?php
           $meses = meses_array();
           $mes = $this->uri->segment(4,date('n'));
           echo form_dropdown("mes",$meses,$mes,"id='meses'");
           ?>
    </div>
    <div class="three columns" style="text-align:right">
        Año:
    </div>
    <div class="three columns">
       
        <?php
           $anios =  anios_array(2015,2020);
           $anio = $this->uri->segment(3,date("Y"));
           echo form_dropdown("anios",$anios,$anio,"id='anios'");
           ?>        
    </div>
</div>


<div align="center">
<table width="100%" id="datatabla" class="cell-border stripe compact hover">
	<thead>
<tr>
         <th width='15%'>Fecha</th>
         <th width='15%'>Hora</th>
         <th width='15%'>Tipo</th>
         <th width='40%'>Concepto</th>
         <th width='20%'>Importe</th>
                  <th>Orden</th>
         <th>Remisión</th>
</tr>
</thead>
<tbody>
<?php


foreach ($movimientos as $item) {
	echo "<tr>";
    echo "<td>" . $item['fecha'] . "</td>";
    echo "<td>" . $item['hora'] . "</td>";
    echo "<td>" . ucfirst(strtolower($item['scta'])) . "</td>";
    echo "<td>" . $item['concepto'] . ($item['sscta']!="" ? " (" . strtolower($item['sscta']) . ")" : "" ) ."</td>";
	
	echo "<td align='right'>" . number_format($item['importe'], 2, '.', ',')  . "</td>";
	echo "<td>" . $item['num_orden'] . "</td>";
echo "<td><a href='http://" . $this->uri->segment(6) . ".idoctorhelp.me/archivos/remisiones/" . $item['archivo_remision'] . "'>". $item['numero_remision'] . "</a></td>";


    echo "</tr>";

}
?>
</tbody>
</table>


</div>


<script>
$(document).ready(function() {
    $('#datatabla').DataTable( {
    	paging:true,
    	searching:false,
    	ordering:false,
    	info: "",
    	iDisplayLength: 25,
language:
{
    "emptyTable":     "No data available in table",
    "info":           "Showing _START_ to _END_ of _TOTAL_ entries",
    "infoEmpty":      "Showing 0 to 0 of 0 entries",
    "infoFiltered":   "(filtered from _MAX_ total entries)",
    "infoPostFix":    "",
    "thousands":      ",",
    "lengthMenu":     "Mostrar _MENU_ registros",
    "loadingRecords": "Loading...",
    "processing":     "Processing...",
    "search":         "Search:",
    "zeroRecords":    "No matching records found",
    "paginate": {
        "first":      "Primero",
        "last":       "Ultimo",
        "next":       "Siguiente",
        "previous":   "Anterior"
    },
    "aria": {
        "sortAscending":  ": activate to sort column ascending",
        "sortDescending": ": activate to sort column descending"
    }
}    	    	
     });
} );
</script>
