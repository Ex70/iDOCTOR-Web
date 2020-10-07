<?php
class Cortescajasmodel extends CI_Model {

	function Formmodel() {
	// load the parent constructor
	parent::Model();
	}

   function get_campos() {
    	$campos = array();
    	$fields = $this->db->list_fields('cortescajas');
        foreach ($fields as $field)
          {
           $campos[$field] = "";
         }
         return $campos;
    }

    function get_detalle($id){
        $arr =  $this->db->query('select * from cortescajas where id=' . $id);
	    $data = $arr->result_array(); 
		$registro = $data[0];
		return $registro;
    }

    function get_cortescajas_dropdown() {
        $arr = $this->db->query('select id,fecha, hora from cortescajas order by fecha,hora');
	    $cortes = ($arr->result_array());		
		$cli = array();
		foreach ($cortes as $corte) {
			$cli[$corte["id"]] = $corte["fecha"] . " " . $corte["hora"];
		}
		return $cli;
    }

    function get_cortescajas_where_str($wh,$lim="10",$cnt="20") {
        $arr = ( $this->db->query('select * from cortescajas ' . $wh . ' limit ' . $lim . ',' . $cnt));
        return ($arr->result_array()); 
    }    

    function guardar($data) {
         unset($data['enviar']);
         unset($data['submit']);

         $data['usuario_id'] = $this->session->userdata('usuario_id');
       if ($data['id']=="") {
            $this->db->insert("cortescajas",$data);
      //     return "i";
           }
        else {
            $this->db->where("id",$data['id']);
            $this->db->update("cortescajas",$data); 
        //    return "u";
            }

    }

    function fecha_turno_mas_reciente() {
        $arr = $this->db->query('select fecha,turno,saldo_en_caja_comprobacion from cortescajas order by fecha desc, turno desc limit 1');
        $res = $arr->result_array();
        if ($arr->num_rows()>0) {
            return $res[0];
        } 
        else return array("fecha"=>"","turno"=>"","saldo_en_caja_comprobacion"=>0);
    }

    function fecha_turno_saldo_nuevo() {
        $arr = $this->db->query('select fecha,turno,saldo_en_caja_comprobacion from cortescajas order by fecha desc, turno desc limit 1');
        $res = $arr->result_array();
        if ($arr->num_rows()>0) {
            $turno = $res[0]['turno'];
            if ($turno==1) {
                $res[0]['turno'] = 2;
            }
            else {
                $res[0]['turno'] = 1;
                $date = $res[0]['fecha'];
                $newdate = strtotime ( '+1 day' , strtotime ( $date ) ) ;
                $newdate = date ( 'Y-m-d' , $newdate );                
                $res[0]['fecha'] = $newdate;
            }

            return $res[0];
        } 
        else return array("fecha"=>date("Y-m-d"),"turno"=>"1","saldo_en_caja_comprobacion"=>0);        
    }




}
?>