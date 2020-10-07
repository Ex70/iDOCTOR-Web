<?php
class Bitacorasmodel extends CI_Model {

	function Formmodel() {
	// load the parent constructor
	parent::Model();
	}

    function get_bitacorasequipo($equipo_id) {
        $arr = ( $this->db->query('select b.id,b.estatus,b.fecha,b.hora,b.descripcion,b.fecha_adicional,' .
        	     'b.usuario_id,b.equipo_id,u.usuario,b.mensaje_para_fecha_adicional from bitacoras b ' .
        	     ' inner join usuarios u on b.usuario_id=u.id where b.equipo_id=' . $equipo_id . 
        	     ' order by b.fecha,b.hora,b.id') );
	    $bitacoras = ($arr->result_array());
	    return $bitacoras;

    }

   function get_campos() {
    	$campos = array();
    	$fields = $this->db->list_fields('bitacoras');
        foreach ($fields as $field)
          {
           $campos[$field] = "";
         }
         return $campos;
    }

    function get_ultima_bitacora_equipo($equipo_id) {
    	$arr =  $this->db->query("select * from bitacoras where equipo_id=" .  $equipo_id . " order by fecha desc, hora desc limit 1");
	    $data = ($arr->result_array());
	    return $data;
    }

    function get_estatus_recibido() {
        $arrestatus =  $this->db->query("select distinct id,estatus as siguiente_estatus from estados where estatus='Recibido' limit 1");
	    $dataestatus = ($arrestatus->result_array());	
        return $dataestatus;
    }

    function get_siguiente_estatus($estatus_actual) {
		$arrestatus =  $this->db->query("select id_siguiente_estatus as id ,siguiente_estatus from estados where estatus='" . $estatus_actual . "'");
	    $dataestatus = ($arrestatus->result_array());
	    return $dataestatus;
	 }   

    function get_siguiente_estatus_compat($estatus_actual) {
        $arrestatus =  $this->db->query("select id_siguiente_estatus as id ,siguiente_estatus from estados_compat where estatus='" . $estatus_actual . "'");
        $dataestatus = ($arrestatus->result_array());
        return $dataestatus;
     }   

    function get_detalle_bitacora($id) {
    	$arr  = $this->db->query('select * from bitacoras where id=' . $id);
	    $data = $arr->result_array();
	    return $data;
    }

    function eliminar_bitacora($id) {
    	 $arrd = $this->db->query('delete from bitacoras where id=' . $id);
    }

	function get_estatus_tabla_equipos($equipo_id) {
        $arreq =  $this->db->query("select id,estatus,estatus_id from equipos where id=" . $equipo_id);
	    $dataeq = ($arreq->result_array());
	    return $dataeq;
	}	

	function get_estado($id){
        $arrest =  $this->db->query("select * from estados where id=" . $id . " limit 1");
        if ($arrest->num_rows()>0) {
	       $dataest = ($arrest->result_array()); 
		   $registroest = $dataest[0];	
        }	
        else
        {
            //echo $id; die();
            $arrest = $this->db->query("select * from estados_compat where id=" . $id . " limit 1");
            $dataest = ($arrest->result_array()); 
           $registroest = $dataest[0];  
           $registroest['proceso'] = "N/A (Version ant.)";
                     $registroest['ubicacion'] = "N/A (Version ant.)";
        }
		return $registroest;
	}

    function get_fecha_diagnostico($equipo_id) {
        $arrest =  $this->db->query("select * from estados where estatus='Recibido'");
        $dataest = ($arrest->result_array()); 
        $registroest = $dataest[0];     
        $id_recibido = $registroest['id'];
//print_r($dataest); die(); 
        //echo $equipo_id; die();
        $arrest2 =  $this->db->query("select * from bitacoras where equipo_id=" . $equipo_id . " and estatus_id=" . $id_recibido);
        $dataest2 = ($arrest2->result_array()); 

        if (count($dataest2)==0) {
                $arrest2 =  $this->db->query("select * from bitacoras where equipo_id=" . $equipo_id . " and estatus='Recibido'");
                $dataest2 = ($arrest2->result_array()); 
        }

        //print_r($dataest2);die();

        $fecha_a_diagnosticar = $dataest2[0]['fecha_adicional'];

        return $fecha_a_diagnosticar;
    }
  

    
}
?>