<?php
class Movimientosmodel extends CI_Model {



   function get_campos() {
    	$campos = array();
    	$fields = $this->db->list_fields('MOVIMIENTOS');
        foreach ($fields as $field)
          {
           $campos[strtolower($field)] = "";
         }
         return $campos;
    }


    function get_movimientosequipo($equipo_id) {
        $this->db->where("equipo_id",$equipo_id);
        $this->db->order_by("fecha,hora");
        $m = $this->db->get("movimientos");
        $a = $m->result_array();
        if (count($a)>0)
          return $a;
        else return array();
    }    

    function get_remisiones_str($equipo_id) {
       $movs = $this->get_movimientosequipo($equipo_id);
       $rems = "";
       foreach ($movs as $k=>$v) {
          $rems .= $v['numero_remision'] . " ";
       }
       return $rems;
    }

    function get_remisiones_str_link($equipo_id) {
       $movs = $this->get_movimientosequipo($equipo_id);
       $rems = "";
       foreach ($movs as $k=>$v) {
          $rems .= "<a href='/archivos/remisiones/" . $v['archivo_remision'] . "'>" . $v['numero_remision'] . "</a> ";
       }
       return $rems;
    }    

    function get_movimiento_entrega_equipo($equipo_id) {
        $this->db->where("equipo_id",$equipo_id);
        $this->db->where("cta","ENTRADAS");
        $this->db->where("scta","ENTREGA");
        $this->db->order_by("fecha");
        $m = $this->db->get("movimientos");
        $a = $m->result_array();
        if ($m->num_rows()>0)
          return $a[0]; 
        else return 0;     
    }

    function get_movimiento_anticipo_equipo($equipo_id) {
        $this->db->where("equipo_id",$equipo_id);
        $this->db->where("cta","ENTRADAS");
        $this->db->where("scta","ANTICIPO");
        $this->db->order_by("fecha");
        $m = $this->db->get("movimientos");
        $a = $m->result_array();
        if ($m->num_rows()>0)
          return $a[0]; 
        else return 0;     
    }    

    function cancelar_movimiento($id) {
       /* $movimiento = $this->get_detalle($id);
        $movimiento['id_movimiento_original'] = $movimiento['id'];
        $movimiento['fecha_cancelacion'] = fecha_actual_mysql();
        $movimiento['hora_cancelacion'] = hora_actual_mysql();
        $movimiento['usuario_id_cancelo'] = $this->session->userdata('usuario_id');
        $movimiento['usuario_cancelo'] = $this->session->userdata('usuario');

        unset($movimiento['id']);
        $this->db->insert("movimientos_cancelados",$movimiento);*/

        //$li = $this->db->insert_id();
        $this->eliminar($id);

        $q = $this->db->query("select first 1 id from movimientos_cancelados order by id desc");
        $a = $q->result_array();        
        return $a[0]['id'];
    }

    function get_pagos_de_equipo($equipo_id) {
        $this->db->where("equipo_id",$equipo_id);
        $this->db->where("cta","ENTRADAS");
       // $this->db->order_by("fecha");
        $this->db->select_sum('importe');
        $m = $this->db->get("movimientos");
        $a = $m->result_array();
          return $a[0]['importe']; 
    }    

    function get_id_equipo_de_movimiento($movimiento_id) {
        $this->db->where("id",$movimiento_id);
        $q = $this->db->get("movimientos");
        $a = $q->result_array();
        $mov = $a[0];
        return $mov['equipo_id'];
    }

    function tiene_nota_de_venta($movimiento_id) {
        $this->db->where("id",$movimiento_id);
        $q = $this->db->get("movimientos");
        $a = $q->result_array();
        $mov = $a[0];
        if ($mov['archivo_remision']!="") 
            return TRUE;
        else
            return FALSE;
    }

/*  SOLO ADMINISTRADORES */

    function get_movimientos_por_mes($sucursal,$anio,$mes) {
        $this->load->model("equipos/Equiposmodel");

      $sql = "select m.id,m.tipo_movimiento,m.fecha,m.hora,m.importe,m.equipo_id,m.concepto,m.usuario_id," .
           "m.num_modificacion,m.cta,m.scta,m.sscta,m.numero_remision,m.archivo_remision,e.num_orden " .
           " from movimientos m left outer join equipos e on (m.equipo_id=e.id) " .
           " where m.sucursal_id='" . $sucursal . "' and extract(YEAR from fecha)=" . $anio . " and extract(MONTH from fecha)=" . $mes . " order by fecha,hora";
      $q = $this->db->query($sql);
        $a = $q->result_array();


        return $a;
    }

  function get_entradas_salidas_por_mes($sucursal,$anio,$mes) {
        $this->load->model("equipos/Equiposmodel");

      $sql = "SELECT * FROM R_MOV_E_S_X_MES('" . $sucursal . "'," . $anio . "," . $mes . ")";
      $q = $this->db->query($sql);
        $a = $q->result_array();


        return $a;
    }    



/* TERMINA ADMINISTRADORES */    

    function get_remisiones_por_mes($anio,$mes) {
        $this->load->model("equipos/Equiposmodel");

      $sql = "select m.id,m.tipo_movimiento,m.fecha,m.hora,m.importe,m.equipo_id,m.concepto,m.usuario_id," .
           "m.num_modificacion,m.cta,m.scta,m.sscta,m.numero_remision,m.archivo_remision,e.num_orden " .
           " from movimientos m left outer join equipos e on (m.equipo_id=e.id) " .
           " where extract(YEAR from fecha)=" . $anio . " and extract(MONTH from fecha)=" . $mes . " order by numero_remision desc";
      $q = $this->db->query($sql);
        $a = $q->result_array();
        $a1 = array();
        $re = array();

        return $a;
    }    

    function get_detalle($id){
        $this->db->where("id",$id);
        $arr =  $this->db->get("movimientos");
	    $data = $arr->result_array(); 
		$registro = $data[0];
		return $registro;
    }

    function agregar_ingreso_por_equipo($equipo_id, $importe,$concepto,$cta,$scta,$sscta) {  

        $p = array("equipo_id"=>$equipo_id,
                   "importe"=>$importe,
                        "fecha" => fecha_actual_mysql(),
                        "hora" => hora_actual_mysql(), 
                        "concepto"=>$concepto,
                        "tipo_movimiento"=>"INGRESO",
                       "usuario_id"=>$this->session->userdata('usuario_id'),
                       "cta"=>$cta,
                       "scta"=>$scta,
                       "sscta"=>$sscta
                   );
        if (($cta=="ENTRADAS") && (($scta=="ANTICIPO") || ($scta=="ENTREGA"))) {
            $this->db->where(array("cta"=>"ENTRADAS","scta"=>$scta, "equipo_id"=>$equipo_id));
            $p["num_modificacion"] = "num_modificacion + 1";
            //unset($p['equipo_id']);
            $this->db->update("movimientos",$p);
            if ($this->db->affected_rows()==0)
               $this->db->insert("movimientos",$p); 
            else {
                $this->db->where(array("concepto"=>"ANTICIPO","equipo_id"=>$equipo_id));
                $this->db->set('num_modificacion', 'num_modificacion + 1', FALSE);
                $this->db->update("movimientos");
            }
        }
         else {
            $this->db->insert("movimientos",$p);
          }
        return 1;
    }

    function get_movimientos_dropdown() {
        $arr = $this->db->query('select id,fecha, hora from movimientos order by fecha,hora');
	    $movs = ($arr->result_array());		
		$cli = array();
		foreach ($movs as $corte) {
			$cli[$corte["id"]] = $corte["fecha"] . " " . $corte["hora"];
		}
		return $cli;
    }

    function eliminar_movimiento_de_entrega_de_equipo($equipo_id) {
        $wh = array("equipo_id"=>$equipo_id,"cta"=>"ENTRADAS","scta"=>"ENTREGA");
        $this->db->where($wh);
        $this->db->delete("movimientos");
        return 1;
   }

    function get_movimientos_count() {
        $arrtot = ( $this->db->query('select * from movimientos'));
        $r = $arrtot->num_rows();
        return $r;
    }

    function get_movimientos_where_str($wh,$lim="10",$cnt="20") {
        $arr = ( $this->db->query('select * from movimientos ' . $wh . ' limit ' . $lim . ',' . $cnt));
        return ($arr->result_array()); 
    }    

    function guardar($data) {



      $this->load->model("Catcuentasmodel");
      $data = $this->filtra_post_guardar($data);

      $data['importe'] = str_replace(",", "", $data['importe']);

   

      if (!isset($data['cta']))
         $data['cta'] = $this->Catcuentasmodel->cta_de_scta($data['scta']);

      if (!isset($data['fecha']))
            $data['fecha'] = fecha_actual_mysql();
      if (!isset($data['hora']))
            $data['hora'] = hora_actual_mysql();



       if (($data['id']=="") || ($data['id']==0)) {
            unset($data['id']);

            if ($data['cta'] == "SALIDAS")
              $data['tipo_movimiento'] = "EGRESO";
            if ($data['cta'] == "ENTRADAS")
              $data['tipo_movimiento'] = "INGRESO";

           
            $this->db->insert("movimientos",$data);
            $q = $this->db->query("select first 1 id from movimientos order by fecha desc,hora desc");
            $a = $q->result_array();
               
            return $a[0]['id'];
           
           }
        else {
            $this->db->where("id",$data['id']);
            $this->db->update("movimientos",$data); 
            return $data['id'];

            }
    }


    function eliminar($id) {
      $this->db->where("id",$id);
      $this->db->delete("movimientos");
      return 1;
    }


   function set_numero_remision_a_movimiento($movimiento_id) {
    $this->load->model("Equiposmodel");
        $numero_remision = $this->Equiposmodel->get_numremision_incrementar();
        $this->db->where('id',$movimiento_id);
        $p = array("numero_remision"=>$numero_remision);
        $this->db->update('movimientos',$p);
        // EN MOVIMIENTOS

        return $numero_remision;
   }

   function get_nombre_de_remision($movimiento_id) {
     $this->load->model("Equiposmodel");
     $movimiento = $this->get_detalle($movimiento_id);
     $equipo_id = $this->get_id_equipo_de_movimiento($movimiento_id);
     $equipo = $this->Equiposmodel->get_detalle($equipo_id);
     $nombre = 'Notavta-' . $movimiento['numero_remision'] . '-' . $equipo['num_orden'] . '.pdf';
     return $nombre;
   }

   function set_archivo_remision($movimiento_id,$nombre_archivo_remision) {
     $this->db->where("id",$movimiento_id);
     $u = array("archivo_remision"=>$nombre_archivo_remision);
     $this->db->update("movimientos",$u);
     return 1;
   }



    function filtra_post_guardar($p) {
        $a = $this->get_campos();
        foreach ($p as $pk=>$pv) {
            $existe = 0;
             foreach ($a as $k=>$v) {
                 if ($pk==$k)
                     $existe = 1;                
             }             
              if (!$existe)
                unset($p[$pk]);
         }
         return $p; 
    }    


    function actualizar_movimientos_con_equipos() {
      $this->db->where("archivo_remision <>",'');
      $q = $this->db->get("equipos");
      $a = $q->result_array();
      foreach ($a as $k=>$v) {
        if ($v['archivo_remision']!="") {
         $this->db->where("numero_remision",$v['numero_remision']);
         $d = array("archivo_remision"=>$v['archivo_remision']);
         $this->db->update("movimientos",$d);
        } 
      }
      $this->db->where("archivo_remision_anticipo <>",'');
      $q = $this->db->get("equipos");
      $a = $q->result_array();
      foreach ($a as $k=>$v) {
        if ($v['archivo_remision_anticipo']!="") {
         $this->db->where("numero_remision",$v['numero_remision_anticipo']);
         $d = array("archivo_remision"=>$v['archivo_remision_anticipo']);
         $this->db->update("movimientos",$d);
        } 
      }


      $this->db->query("update movimientos set archivo_remision=NULL where numero_remision is null");
      return $a;
    }






}

?>