<?php
class Calendariomodel extends CI_Model {

	function Formmodel() {
	// load the parent constructor
	parent::Model();
	}

  
    function procesocalendario(){
            // PRIMERO ELIMINAR LOS REGISTROS
        
        $this->db->query("delete from reportecalendario");

         $sucursal_id = $this->session->sucursal_id;
           //$wh = " where (equipos.sucursal_id='" . $sucursal_id . "') ";  
           
        $qry1 = "select id from estados where estatus_de_entrega='S'";
        $arr1 = ( $this->db->query($qry1));
        $res1 = ($arr1->result_array());
        $es   = "";
        foreach ($res1 as $k) {
            $es .= $k['id'] . ",";
        }
         $es .= "-1";
        
        // echo $es; die();
        $qry = "select ";
        $qry .= "equipos.num_orden,";
        $qry .= "equipos.id as equipo_id,";
        $qry .= "equipos.estatus,";
        $qry .= "equipos.tipo,";
       // $qry .= "equipos.situacion,";
       // $qry .= "equipos.fecha_de_entrega,";
        //$qry .= "equipos.capacidad,";
        //$qry .= "equipos.software,";
        //$qry .= "equipos.fecha_recibido,";
        //$qry .= "equipos.hora_recibido,";
        $qry .= "equipos.cliente_id,";
        $qry .= "clientes.id as cliente_id,";
        $qry .= "clientes.nombre,";
        $qry .= "clientes.telefono1,";
        $qry .= "clientes.telefono2,";
        $qry .= "clientes.correo_electronico,";
        //$qry .= "bitacoras.fecha,";
        //$qry .= "bitacoras.hora,";
        $qry .= "bitacoras.estatus_id,";
        $qry .= "bitacoras.mensaje_para_fecha_adicional,";
        $qry .= "bitacoras.fecha_adicional ";
        $qry .= "from equipos inner join clientes on equipos.cliente_id=clientes.id ";
        $qry .= " inner join bitacoras on equipos.estatus_id=bitacoras.estatus_id  and equipos.id=bitacoras.equipo_id ";
        $qry1 = $qry . " where equipos.estatus_id in (" . $es . ") order by bitacoras.fecha,bitacoras.hora";
        //echo $queryprincipal;
        $lim = $this->uri->segment(3,'0');
        $arr = ( $this->db->query($qry1));
        $datos = ($arr->result_array());
                
        foreach ($datos as $datodet) {
            $datodet['recordatorio_de'] = "Entregar";
            $datodet['fecha_hora'] = date ("Y-m-d H:i:s");
         $this->db->insert('reportecalendario',$datodet);
        }   

        


        // POR NOTIIFCAR
        $qry1 = "select id from estados where estatus_por_notificar='S'";
        $arr1 = ( $this->db->query($qry1));
        $res1 = ($arr1->result_array());
        $es   = "";
        foreach ($res1 as $k) {
            $es .= $k['id'] . ",";
        }
         $es .= "-1";       
        
        $qry2 = $qry . " where equipos.estatus_id in (" . $es . ") order by bitacoras.fecha,bitacoras.hora";
        //echo $queryprincipal;
        $lim = $this->uri->segment(3,'0');
        $arr = ( $this->db->query($qry2));
        $datos = ($arr->result_array());
                
        foreach ($datos as $datodet) {
            $datodet['recordatorio_de'] = "Notificar";
            $datodet['fecha_hora'] = date ("Y-m-d H:i:s");
         $this->db->insert('reportecalendario',$datodet);
        }       
        
        
        // POR DIAGNOSTICAR
        $qry1 = "select id from estados where estatus_por_diagnosticar='S'";
        $arr1 = ( $this->db->query($qry1));
        $res1 = ($arr1->result_array());
        $es   = "";
        foreach ($res1 as $k) {
            $es .= $k['id'] . ",";
        }
         $es .= "-1";       
        
        $qry2 = $qry . " where equipos.estatus_id in (" . $es . ") order by bitacoras.fecha,bitacoras.hora";
        //echo $queryprincipal;
        $lim = $this->uri->segment(3,'0');
        $arr = ( $this->db->query($qry2));
        $datos = ($arr->result_array());
                
        foreach ($datos as $datodet) {
            $datodet['recordatorio_de'] = "Diagnosticar";
            $datodet['fecha_hora'] = date ("Y-m-d H:i:s");
         $this->db->insert('reportecalendario',$datodet);
        }       
        
        
        // POR REPARAR
        $qry1 = "select id from estados where estatus_por_reparar='S'";
        $arr1 = ( $this->db->query($qry1));
        $res1 = ($arr1->result_array());
        $es   = "";
        foreach ($res1 as $k) {
            $es .= $k['id'] . ",";
        }
         $es .= "-1";       
        
        $qry2 = $qry . " where equipos.estatus_id in (" . $es . ") order by bitacoras.fecha,bitacoras.hora";
        //echo $queryprincipal;
        $lim = $this->uri->segment(3,'0');
        $arr = ( $this->db->query($qry2));
        $datos = ($arr->result_array());
                
        foreach ($datos as $datodet) {
            $datodet['recordatorio_de'] = "Reparar";
            $datodet['fecha_hora'] = date ("Y-m-d H:i:s");
         $this->db->insert('reportecalendario',$datodet);
        }   
        
        
        
        // EN ESPERA
        $qry1 = "select id from estados where estatus_en_espera='S'";
        $arr1 = ( $this->db->query($qry1));
        $res1 = ($arr1->result_array());
        $es   = "";
        foreach ($res1 as $k) {
            $es .= $k['id'] . ",";
        }
         $es .= "-1";       
        
        $qry2 = $qry . " where equipos.estatus_id in (" . $es . ") order by bitacoras.fecha,bitacoras.hora";
        //echo $queryprincipal;
        $lim = $this->uri->segment(3,'0');
        $arr = ( $this->db->query($qry2));
        $datos = ($arr->result_array());
                
        foreach ($datos as $datodet) {
            $datodet['recordatorio_de'] = "En espera";
            $datodet['fecha_hora'] = date ("Y-m-d H:i:s");
         $this->db->insert('reportecalendario',$datodet);
        }   
        
        // FECHAS DE ENTREGA TENTATIVA
        $qryfet  = "select equipos.num_orden,equipos.id as equipo_id,equipos.estatus,equipos.tipo,";
        $qryfet .= "equipos.fecha_de_entrega as fecha_adicional,equipos.cliente_id,clientes.id as cliente_id,clientes.nombre,clientes.telefono1,";
        $qryfet .= "clientes.telefono2,clientes.correo_electronico,bitacoras.estatus_id ";
        $qryfet .= "from equipos inner join clientes on equipos.cliente_id=clientes.id ";
        $qryfet .= "inner join bitacoras on equipos.estatus_id=bitacoras.estatus_id  and equipos.id=bitacoras.equipo_id "; 
        $qryfet .= "where equipos.situacion='A'";
        
    //  $qry2 = $qry . " where equipos.situacion='A'";
        
        $arr = ( $this->db->query($qryfet));
        $datos = ($arr->result_array());
                
        foreach ($datos as $datodet) {
            $datodet['recordatorio_de'] = "Entrega Tentativa";
            $datodet['fecha_hora'] = date ("Y-m-d H:i:s");
            $datodet['mensaje_para_fecha_adicional'] = 'Entrega tentativa programada';
         $this->db->insert('reportecalendario',$datodet);
        }       
     
       return 1;   
            
            
    }


    function get_dias_calendario($anio,$mes) {
            
        $qry = "SELECT DAY(fecha_adicional) as dia,num_orden,recordatorio_de," .
               "mensaje_para_fecha_adicional,fecha_adicional,equipo_id " .
               " FROM reportecalendario WHERE YEAR(fecha_adicional) = " . $anio .
               " AND MONTH(fecha_adicional) = " . $mes;
               //echo $qry;die();
               
        $arr = ( $this->db->query($qry));     
        $result = ($arr->result_array());
        /*
        $result2 = array(); 
        foreach ($result as $k=>$v) {
              $result2[$v['dia']] = $v;
          }        
        */
        return $result;  
    }

public function calendar($date,$dias)
         {
         if($date == null)
            $date = getDate();

         $day = $date["mday"];
         $month = $date["mon"];
         $meses = array(1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',
                        7=>'Julio',8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre');
         $month_name = $meses[$date['mon']];
         $year = $date["year"];

         $this_month = getDate(mktime(0, 0, 0, $month, 1, $year));
         $next_month = getDate(mktime(0, 0, 0, $month + 1, 1, $year));

         //Find out when this month starts and ends.
         $first_week_day = $this_month["wday"];
         $days_in_this_month = round(($next_month[0] - $this_month[0]) / (60 * 60 * 24));

         $calendar_html = "<table class='calendarioeventos'>";

         if ($month==1) {
            $anioant = $year - 1;
            $mesant  = 12;
            $aniosig = $year;
            $messig  = 2;
         }
         else if ($month==12) {
            $anioant = $year;
            $mesant  = 11;
            $aniosig = $year + 1;
            $messig  = 1;           
         }
         else {
            $anioant = $year;
            $mesant  = $month - 1;
            $aniosig = $year;
            $messig  = $month + 1;          
         }
         
         $calendar_html .= "<tr>";
         $calendar_html .= "<td align=center><a href='/index.php/equipos/calendario/" . 
                            $anioant . "/" . $mesant . "'>[Anterior]</a></td>";
         $calendar_html .= "<td colspan=\"5\" align=\"center\" style=\"background-color:9999cc; color:000000;font-size:1.6em;\">" .
                           $month_name . " " . $year;
         $calendar_html .= "<td align=center><a href='/index.php/equipos/calendario/" . 
                            $aniosig . "/" . $messig . "'>[Siguiente]</a></td>";
         $calendar_html .= "</td></tr>";

         $calendar_html .= "<tr><th class='thcalendarioeventos'>Domingo</th>" .
                               "<th  class='thcalendarioeventos'>Lunes</th>" .
                               "<th  class='thcalendarioeventos'>Martes</th>" .
                               "<th  class='thcalendarioeventos'>Mi&eacute;rcoles</th>" . 
                               "<th  class='thcalendarioeventos'>Jueves</th>" .
                               "<th  class='thcalendarioeventos'>Viernes</th>" .
                               "<th  class='thcalendarioeventos'>S&aacute;bado</th></tr>";

         $calendar_html .= "<tr>";

         //Fill the first week of the month with the appropriate number of blanks.
         for($week_day = 0; $week_day < $first_week_day; $week_day++)
            {
            $calendar_html .= "<td style=\"background-color:9999cc; color:000000;\"> </td>";
            }

         $week_day = $first_week_day;
         
         for($day_counter = 1; $day_counter <= $days_in_this_month; $day_counter++)
            {
            $week_day %= 7;

            if($week_day == 0)
               $calendar_html .= "<td colspan='7'></td></tr><tr>";

            //Do something different for the current day.
       
               $calendar_html .= "<td class=\"celdacal\" align=\"center\"><b>";
               if (($day == $day_counter) && ($month==date('n')))
                  $calendar_html .= "<div style='font-size:1.3em;background-color:#fff;color:#f00;'>" . $day_counter . "</div><br>";
               else
                  $calendar_html .= $day_counter . "<br>";

               foreach ($dias as $k=>$v) {
                if ($v['dia']==$day_counter) {
                  switch ($v['recordatorio_de' ]) {
                    case "Notificar":
                    $col = "#cccccc";
                    $class="notificar";
                    break;
                    case "Entregar":
                    $col = "#00ff00";
                    $class="entregar";
                    break;
                    case "En espera":
                    $col = "#ffff00";
                    $class = "enespera";
                    break;
                    case "Diagnosticar":
                    $col = "#ff0000";
                    $class="diagnosticar";
                    break;
                    case "Reparar":
                    $col = "#ffffff";
                    $class="reparar";
                    break;
                    case "Entrega Tentativa":
                    $col = "#00ffff";
                    $class = "entregatentativa";
                    break;
                    default:
                    $col = "#ffffff";
                    $class="otro";
                    break;
                    }
                $calendar_html .= "<div class='" . $class . "' style='background-color:" . $col . "';>" . substr($v['recordatorio_de'],0,1) . 
                      ":&nbsp;" . "<a href='/index.php/equipos/modificar/" . $v['equipo_id'] . "'>" . $v['num_orden'] . "</a></div><br>";
                }   
               }
               //if (isset($dias[$day_counter]))
                // $calendar_html .= 'aaa';
               $calendar_html .= "</b></td>";
         //   else
          //     $calendar_html .= "<td align=\"center\" style=\"background-color:9999cc; color:000000;\">&nbsp;" .
            //                     $day_counter . " </td>";

            $week_day++;
            }

         $calendar_html .= "</tr>";
         $calendar_html .= "</table>";

         return($calendar_html);
         }    

    


}
?>