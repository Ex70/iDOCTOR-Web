<script>
  $(function() {
    $("#meses").change(function() {
      top.location.href='/index.php/reportesadministracion/entradassalidaspormes/' + $("#anios").val() + "/" + $("#meses").val() + "/" + $("#sucursal").val();
    });
    $("#anios").change(function() {
      top.location.href='/index.php/reportesadministracion/entradassalidaspormes/' + $("#anios").val() + "/" + $("#meses").val() + "/" + $("#sucursal").val();
    });
    $("#sucursal").change(function() {
      top.location.href='/index.php/reportesadministracion/entradassalidaspormes/' + $("#anios").val() + "/" + $("#meses").val() + "/" + $("#sucursal").val();
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
         <th width='22%'>Fecha/Turno</th>
         <th width='13%'>Efectivo</th>
         <th width='13%'>Tarjeta</th>
         <th width='13%'>Transferencia</th>
         <th width='13%'>Cheque</th>
         <th width='13%'>Reposición de gastos</th>
         <th width='13%'>No especificado</th>
</tr>
</thead>
<tbody>
<?php
/*
fecha date,
    turno smallint,
    e_efectivo float,
    e_tarjeta_d_c float,
    e_transferencia float,
    e_cheque float,
    e_reposicion_gastos float,
    e_no_especificado float,
    s_gastos float,
    s_depositos float
*/

foreach ($movimientos as $item) {
	echo "<tr>";
    echo "<td align='center'>" . $item['fecha'] . "/" . $item['turno'] . "</td>";
    echo "<td align='right'>" . number_format($item['e_efectivo'],2) . "</td>";
    echo "<td align='right'>" . number_format($item['e_tarjeta_d_c'],2) . "</td>";
    echo "<td align='right'>" . number_format($item['e_transferencia'],2) . "</td>";
    echo "<td align='right'>" . number_format($item['e_cheque'],2) . "</td>";
    echo "<td align='right'>" . number_format($item['e_reposicion_gastos'],2) . "</td>";
    echo "<td align='right'>" . number_format($item['e_no_especificado'],2) . "</td>";

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
