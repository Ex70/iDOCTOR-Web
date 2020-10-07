






<div class="row">
  <label>Filtrar por clave o tipo</label>
  <input type="text" id="myInput" onkeyup="filtrarPorSucuarsal()" placeholder="Filtrar por clave de sucursal.." title="Type in a name">
  
  <input type="text" id="myInputTipo" onkeyup="filtrarPorTipo()" placeholder="Filtrar por tipo.." title="Type in a name">

  <label>Filtrar por rango de días</label><br>
  <div class ="row">
  <input type="checkbox" name="efectivo" value="efectivo" id="efectivo">  Efectivo 
  <input type="checkbox" name="tarjeta" value="tarjeta" id="tarjeta">      Tarjeta 
  <input type="checkbox" name="transferencia" value="transferencia" id="transferencia">      Transferencia
  <input type="checkbox" name="sinespecificar" value="sinespecificar" id="sinespecificar">      Sin especificar
  </div>
  
  <input type="number" id="dia1" name="dia1" placeholder="Desde.."  min="1" max="31" >
  
  <input type="number" id="dia2" name="dia2" placeholder="Hasta.." min="1" max="31">
  
  <input type="button" onclick="filtrarPorFecha()" value="Filtrar"  style="background-color:#047c79; color:#FFFFFF;"> 

  

<div class="row">
<div align="center">
<table width="100%" id="datatabla" class="cell-border stripe compact hover">
    <thead>
<tr>
         <th width='5%'>Suc</th>
         <th width='8%'>Tipo</th>
         <th width='8%'>Periodo</th>
         <th width='8%'>Fecha</th>
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
    
    //echo "<td>" . $item['sucursal_id'] . "</td>";
    //print_r($item);
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
        paging:false,
        searching:false,
        ordering:false,
        info: "",
        iDisplayLength: 100,
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

function filtrarPorSucuarsal() {
  var input, filter, table, tr, td, i, td2;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();

  input = document.getElementById("myInputTipo");
  filterTipo = input.value.toUpperCase();
  table = document.getElementById("datatabla");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    td2 = tr[i].getElementsByTagName("td")[1];
    if (td || td2) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1 && td2.innerHTML.toUpperCase().indexOf(filterTipo) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}

function filtrarPorTipo() {
  var input, filter, table, tr, td, i, td2;
  input = document.getElementById("myInputTipo");
  filter = input.value.toUpperCase();
  input = document.getElementById("myInput");
  filterSucursal = input.value.toUpperCase();
  table = document.getElementById("datatabla");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td2 = tr[i].getElementsByTagName("td")[0];//Sucursal
    td = tr[i].getElementsByTagName("td")[1]; // Tipo
    if (td || td2) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1 && td2.innerHTML.toUpperCase().indexOf(filterSucursal) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}

function filtrarPorFecha(){ ///ES UN RESPALDO DEL METODO
  var dia1 = $("#dia1").val();
  var dia2 = $("#dia2").val();
  if(dia1.length == 1){
    dia1 = 0+dia1;
  }

  if(dia2.length == 1){
    dia2 = 0+dia2;
  }

  if(dia1 == "" && dia2 == ""){
    dia1 = 1;
    dia2 = 33;
  }

  if(dia1 == "" || dia2 == ""){
    alert("Llenar desde y hasta...");
  }else{
    if(dia2 >= dia1){
      var mes = $("#meses").val();
      var anio = $("#anios").val();
      var table = document.getElementById("datatabla");
      var tr = table.getElementsByTagName("tr");

      if(!$('#tarjeta').prop('checked') && !$('#efectivo').prop('checked') && !$('#transferencia').prop('checked') 
        && !$('#sinespecificar').prop('checked')){

        for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[3]; //Fecha
        if (td) {
          var str = td.innerHTML;
          if(parseInt(str.substr(8, str.length-0)) >= dia1 && parseInt(str.substr(8, str.length-0)) <= dia2){
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }       
      }//Cierre del for

      }else{

         for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[3]; //Fecha
        td2 = tr[i].getElementsByTagName("td")[9]; //Forma de pago
        if (td) {
          var str = td.innerHTML;
         var str2 = td2.innerHTML;
          if(parseInt(str.substr(8, str.length-0)) >= dia1 && parseInt(str.substr(8, str.length-0)) <= dia2 
            && (  (str2 === "Tarjeta" && $('#tarjeta').prop('checked')) ||
             (str2 == "Efectivo" && $('#efectivo').prop('checked')) ||
              (str2 == "Transferencia" && $('#transferencia').prop('checked')) ||
              (str2 == "Noesp" && $('#sinespecificar').prop('checked')) )){
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }       
      } //Cierre del for
      }



     

    }else{
      //dia 1 > que dia 2
      alert("Hasta no puede ser menor que desde");
    }
  }
}

/*function filtrarPorFecha(){ ///ES UN RESPALDO DEL METODO
  var dia1 = $("#dia1").val();
  var dia2 = $("#dia2").val();
  if(dia1.length == 1){
    dia1 = 0+dia1;
  }

  if(dia2.length == 1){
    dia2 = 0+dia2;
  }

  if(dia1 == "" || dia2 == ""){
    alert("Llenar desde y hasta...");
  }else{
    if(dia2 >= dia1){
      var mes = $("#meses").val();
      var anio = $("#anios").val();
      var table = document.getElementById("datatabla");
      var tr = table.getElementsByTagName("tr");

      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[3];
        if (td) {
          var str = td.innerHTML;
          if(parseInt(str.substr(8, str.length-0)) >= dia1 && parseInt(str.substr(8, str.length-0)) <= dia2){
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }       
      }

    }else{
      //dia 1 > que dia 2
      alert("Hasta no puede ser menor que desde");
    }
  }
}*/




function prueba(){
  var dia1 = $("#dia1").val();
  var dia2 = $("#dia2").val();
  if(dia1.length == 1){
    dia1 = 0+dia1;
  }

  if(dia2.length == 1){
    dia2 = 0+dia2;
  }

  if(dia1 == "" || dia2 == ""){
    alert("Llenar desde y hasta...");
  }else{
    if(dia2 >= dia1){
      var mes = $("#meses").val();
      var anio = $("#anios").val();

      //alert(anio + "-" + mes + "-");

      var table = document.getElementById("datatabla");
      var tr = table.getElementsByTagName("tr");
      //alert(str);
      //Se extraen los ultimos numeros de la fecha
      //alert(str.substr(8, str.length-0));
      //if(dia1 >= str.substr(8, str.length-0) && dia2 <= str.substr(8, str.length-0)){
       // tr[1].style.display = "";
      //}

      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[3];
        if (td) {
          var str = td.innerHTML;
          //alert("lle");
            //alert(str.substr(8, str.length-0));
          if(parseInt(str.substr(8, str.length-0)) >= dia1 && parseInt(str.substr(8, str.length-0)) <= dia2){
            //alert("entra");
            tr[i].style.display = "";
          } else {
             //alert("entra2");
            tr[i].style.display = "none";
          }
        }       
      }

    }else{
      //dia 1 > que dia 2
      alert("Hasta no puede ser menor que desde");
    }
  }
  
}




function marcarComoFacturado(id) {
    if (confirm('¿Marcar como facturado?')) {
        $.get( "/index.php/equipos/detalle/marcarcomofacturado/" + id, function( data ) {            
            $('#f' + id).html(data);
        });        
    }
    //alert(id);
}

$("#tarjeta").change(function () {
  if( $('#tarjeta').prop('checked') ) {
       
  }
});

</script>
