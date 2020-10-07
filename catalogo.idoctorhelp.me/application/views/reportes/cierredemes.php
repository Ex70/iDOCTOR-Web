<div class="row">
  <div align="center">
    <table width="100%" id="datatabla" class="cell-border stripe compact hover">
      <thead>
        <tr>
          <th width='5%'>Suc</th>
          <th width='10%'>Tipo</th>
          <th width='10%'>Periodo</th>
          <th width='10%'>Fecha</th>
          <th width='10%'>Nota</th>
          <th width='5%'>Orden</th>
          <th width='10%'>Importe</th>
          <th width='10%'>Equipo</th>
          <th width='10%'>Servicio/producto</th>
          <th width='10%'>Forma de pago</th> 
          <th width='10%'>Observaciones</th>         
        </tr>
      </thead>
    <tbody>
        <?php
          foreach ($cierredemes as $item) {
            echo "<tr>";
            if(substr($item['num_orden'], 0, 2) === "VH"){
              echo "<td>VM2</td>";	
            }else{
              echo "<td>" . substr($item['num_orden'], 0, 2) . 1 . "</td>";
            }
            echo "<td>" . $item['descripcion_tipo'] . "</td>";
            echo "<td>" . $item['periodo'] . "</td>";
            echo "<td>" . $item['fecha'] . "</td>";
            echo "<td>" . $item['numero_remision'] . "</td>";
            echo "<td>" . $item['num_orden'] . "</td>";
            echo "<td style='text-align:right'>" . number_format($item['importe'],2) . "</td>";
            echo "<td>" . $item['descripcion_tipo'] . "</td>";
            echo "<td>" . $item['descripcion_servicios'] . "</td>";
            echo "<td>" . ucfirst(strtolower($item['forma_de_pago'])) . "</td>";    
            echo "<td>" . $item['observaciones'] . "</td>";    
            echo "</tr>";
          }
        ?>
      </tbody>
    </table>
  </div>
</div>
<!--<div class="row" style="float:right">
    <a href="/index.php/reportes/exportarcierredemes/<?php// echo $this->uri->segment(3) . "/" . $this->uri->segment(4) . "/" . $this->uri->segment(5); ?>" 
        class="button button-primary">Exportar a Excel</a>
</div>-->

<script>
$(document).ready(function() {
    $('#datatabla').DataTable( {
        paging:true,
        searching:false,
        ordering:true,
        info: "",
        iDisplayLength: 100,
language:
{
    "emptyTable":     "No existen valores en la tabla",
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
