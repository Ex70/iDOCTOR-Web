<?php
class Basesdedatosmodel extends CI_Model {

	function Formmodel() {
	// load the parent constructor
	parent::Model();
	}


   function get_campos() {
    	$campos = array();
      $fields = $this->db->list_fields('basesdedatos');
        foreach ($fields as $field)
          {
           $campos[$field] = "";
         }
         return $campos;
    }

    
    function get_basesdedatos_dropdown() {

        $arr = $this->db->query('select id,basededatos from basesdedatos order by id');
	    $servicios = ($arr->result_array());		
		$cli = array();
		foreach ($servicios as $servicio) {
			$cli[$servicio["id"]] = $servicio["basededatos"];
		}
		return $cli;
    }

    function get_basesdedatos() {        
        $arr = $this->db->query('select * from basesdedatos');
        return ($arr->result_array()); 
    }





}
?>