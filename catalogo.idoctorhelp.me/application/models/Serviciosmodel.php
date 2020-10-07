<?php
class Serviciosmodel extends CI_Model {

	function Formmodel() {
	// load the parent constructor
	parent::Model();
	}


   function get_campos() {
    	$campos = array();
      
      $fields = $this->db->list_fields('catservicios');
        foreach ($fields as $field)
          {
           $campos[$field] = "";
         }
         return $campos;
    }

    function get_detalle($id){
      

        $arr =  $this->db->query("select * from catservicios where id='" . $id . "'");
	    $data = $arr->result_array(); 
		$registro = $data[0];
		return $registro;
    }

    function get_servicios_dropdown() {
      

        $arr = $this->db->query('select id,descripcion from catservicios order by id');
	    $servicios = ($arr->result_array());		
		$cli = array();
		foreach ($servicios as $servicio) {
			$cli[$servicio["id"]] = $servicio["descripcion"];
		}
		return $cli;
    }

    function get_servicios_dd_clase($clase) {
      

        $arr = $this->db->query("select id,descripcion from catservicios where clase like'%" . $clase . "%' order by id");
      $servicios = ($arr->result_array());    
    $cli = array();
    foreach ($servicios as $servicio) {
      $cli[$servicio["id"]] = substr($servicio["descripcion"], 0,60);
    }
    return $cli;
    }


    function get_servicios_por_clase($clase) {        
        
        $this->db->order_by("id");
        $this->db->like("clase",$clase);

        $arr = $this->db->get('catservicios');
        return ($arr->result_array()); 
    }    

    function get_servicios_where($wh="where 1=1") {        
        
        $this->db->order_by("id");

        $arr = $this->db->query('select * from catservicios  ' . $wh );
        return ($arr->result_array()); 
    }


    function get_servicios_where_str($wh,$lim="10",$cnt="20") {
        
        $arr = ( $this->db->query('select * from catservicios ' . $wh . ' limit ' . $lim . ',' . $cnt));
        return ($arr->result_array()); 
    }

    function agregar_servicio($p){
       
       $this->db->insert('catservicios',$p);
    }

    function modificar_servicio($id,$p) {
       
       $this->db->where('id', $id);
       $this->db->update('catservicios', $p);      
    }

    function eliminar_servicio($id){
       
       $this->db->query("delete from catservicios where id='" . $id . "'");      
    }    

    function get_servicios_clase($clase) {
       
       $arr = $this->db->query("select * from catservicios where  ((clase='" . $clase . "') or (clase like '%" . $clase . " %'))");
       $result = ($arr->result_array());
       return $result;
    }

    function get_siguiente_id($clase) {
       
       $arr = $this->db->query("select id from catservicios where clase='" . $clase . "' limit 1");
       $result = ($arr->result_array());      
       if ($arr->num_rows()>0) {

       }
       else {

       }
    }



}
?>