<script>
  $(function() {
    $("#meses").change(function() {
      top.location.href='/index.php/movimientos/index/' + $("#anios").val() + "/" + $("#meses").val();
    });
    $("#anios").change(function() {
      top.location.href='/index.php/movimientos/index/' + $("#anios").val() + "/" + $("#meses").val();
    });

  })
</script>

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
         <th width='5%'>Orden</th>
         <th width='8%'>Fecha</th>
         <th width='8%'>Hora</th>
         <th width='8%'>Tipo</th>
         <th width='10%'>SCuenta</th>
         <th width='40%'>Concepto</th>
         <th width='20%'>Importe</th>
                  
         <th>Remisión</th>
</tr>
</thead>
<tbody>
<?php


foreach ($movimientos as $item) {
    echo "<tr>";
    echo "<td>";
    /*
    if (($item['scta']=='ENTREGA') || ($item['scta']=="ANTICIPO"))
        echo $item['id'];
    else
        echo "<a href='/index.php/movimientos/modificar/" . $item['id'] . "'>" . $item['id'] . "</a>";
        */
    echo "<a href='/index.php/equipos/detalle/ver/" . $item['equipo_id'] . "'>" . $item['num_orden'] . "</a>";
    echo "</td>";
    echo "<td>" . $item['fecha'] . "</td>";
    echo "<td>" . $item['hora'] . "</td>";
    echo "<td>" . $item['cta'] . "</td>";
    echo "<td>" . $item['scta'] . "</td>";
//    echo "<td>" . $item['numero_cuenta_bancaria'] . "</td>";
    echo "<td>" . $item['concepto'] . ($item['sscta']!="" ? " (" . strtolower($item['sscta']) . ")" : "" ) ."</td>";
    
    echo "<td align='right'>" . number_format($item['importe'], 2, '.', ',')  . "</td>";
   
echo "<td><a href='/archivos/remisiones/" . $item['archivo_remision'] . "'>" . $item['numero_remision'] . "</a></td>";


    echo "</tr>";

}
?>
</tbody>
</table>



</div>

<div align="center" class="row"><a href="/index.php/movimientos/agregar" class="button button-primary">Agregar movimiento</a></div>


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
