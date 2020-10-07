<?php
class Articulosmodel extends CI_Model {

	function Formmodel() {
	// load the parent constructor
	parent::Model();
	}


   function get_campos() {
    	$campos = array();
            
    	$fields = $this->db->list_fields('catarticulos');
        foreach ($fields as $field)
          {
           $campos[$field] = "";
         }
         return $campos;
    }

    function get_detalle($id){
      
      $arr =  $this->db->query("select * from catarticulos where id='" . $id . "'");
	    $data = $arr->result_array(); 
		  $registro = $data[0];
		  return $registro;
    }

    function get_articulos_dropdown() {
        
        $arr = $this->db->query('select id,descripcion from catarticulos order by id');
	      $articulos = ($arr->result_array());		
		    $cli = array();
		    foreach ($articulos as $articulo) {
			      $cli[$articulo["id"]] = $articulo["descripcion"];
	    	}
		    return $cli;
    }

    function get_articulos_where_str($wh,$lim="10",$cnt="20") {
        
        $arr = $this->db->query('select * from catarticulos ' . $wh . ' limit ' . $lim . ',' . $cnt);
        return $arr->result_array(); 
    }

    function get_articulos_uniqid() {
        return uniqid();
    }

    function agregar_articulo($p) {
      
      $this->db->insert("catarticulos",$p);
      return 1;
    }

    function modificar_articulo($id,$p) {
       
       $this->db->where('id', $id);
       $this->db->update('catarticulos', $p);       
       return 1;
    }

    function get_articulos_para_json(){
       
       $arr =  $this->db->query("select * from articulos order by descripcion");
       return ($arr->result_array());      
    }

    function num_total_articulos() {
       
       $arrtot = $this->db->query('select * from catarticulos');
       return $arrtot->num_rows();
    }


    function get_articulos_por_clase($clase) {
        
        $this->db->like("clase_compatibilidad",$clase);
        $arr = $this->db->get("catarticulos");
        return $arr->result_array(); 
    }    



}
?>