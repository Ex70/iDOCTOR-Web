<?php
class Serviciosequiposmodel extends CI_Model {

	function Formmodel() {
	// load the parent constructor
	parent::Model();
	}


   function get_campos() {
    	$campos = array();
    	$fields = $this->db->list_fields('servicios');
        foreach ($fields as $field)
          {
           $campos[$field] = "";
         }
         return $campos;
    }

    function get_detalle($id){
        $arr =  $this->db->query("select * from servicios where id='" . $id . "'");
	    $data = $arr->result_array(); 
		  $registro = $data[0];
		  return $registro;
    }

    function get_servicios_equipo_dropdown($equipoid) {
        $arr = $this->db->query('select id,descripcion from catservicios where equipo_id=' . $equipoid . ' order by id');
	    $servicios = ($arr->result_array());		
		$cli = array();
		foreach ($servicios as $servicio) {
			$cli[$servicio["id"]] = $servicio["descripcion"];
		}
		return $cli;
    }

    function get_servicios_equipo_where($wh="where 1=1") {        
        $arr = $this->db->query('select * from servicios  ' . $wh );
        return ($arr->result_array()); 
    }


    function get_servicios_equipo_where_str($wh,$lim="10",$cnt="20") {
        $arr = ( $this->db->query('select * from servicios ' . $wh . ' limit ' . $lim . ',' . $cnt));
        return ($arr->result_array()); 
    }

    function agregar_servicio_equipo($p){
       $this->db->insert('servicios',$p);
    }

    function modificar_servicio_equipo($id,$p) {
       $this->db->where('id', $id);
       $this->db->update('servicios', $p);      
    }

    function eliminar_servicio_equipo($id){
      $this->db->query("delete from servicios where id='" . $id . "'");      
    }    




}
?>