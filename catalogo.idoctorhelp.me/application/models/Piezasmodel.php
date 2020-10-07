<?php
class Piezasmodel extends CI_Model {

	function Formmodel() {
	// load the parent constructor
	parent::Model();
	}


   function get_campos() {
    	$campos = array();
    	$fields = $this->db->list_fields('catpiezas');
        foreach ($fields as $field)
          {
           $campos[$field] = "";
         }
         return $campos;
    }

    function get_detalle($id){
        $arr =  $this->db->query("select * from catpiezas where id='" . $id . "'");
	    $data = $arr->result_array(); 
		$registro = $data[0];
    $registro['descripcion'] = substitute_encoding($registro['descripcion']);
		return $registro;
    }

    function get_piezas_dropdown() {
        $arr = $this->db->query('select id,descripcion from catpiezas order by id');
	    $piezas = ($arr->result_array());		
		$cli = array();
		foreach ($piezas as $pieza) {
			$cli[$pieza["id"]] = $pieza["descripcion"];
		}
		return $cli;
    }

    function get_piezas_where_str($wh,$lim="",$cnt="") {
        if ($lim!="")
           $limite = " limit " . $lim . "," . $cnt;
        else $limite = ""; 
        $arr = ( $this->db->query('select * from catpiezas ' . $wh . $limite));
        return ($arr->result_array()); 
    }

    function get_piezas_uniqid() {
        return uniqid();
    }

    function agregar_pieza($p) {
      $this->db->insert('catpiezas',$p);
      

    }

    function modificar_pieza($id,$p) {
       $this->db->where('id', $id);

       $p['descripcion'] = substitute_encoding($p['descripcion']);

       $this->db->update('catpiezas', $p);


    }

    function eliminar_pieza($id) {
      $this->db->query("delete from catpiezas where id='" . $id . "'");      

      $this->load->model("Basesdedatosmodel");
      $bds = $this->Basesdedatosmodel->get_basesdedatos();
      foreach ($bds as $k=>$v) {
              $DBactual = $this->load->database($v['basededatos'], TRUE);
              $DBactual->query("delete from catpiezas where id='" . $id . "'");      
      }

    }

    function get_piezas() {
      $arr = ( $this->db->query('select * from catpiezas'));
      return ($arr->result_array());
    }



    function num_piezas($id="") {
      if ($id!="")
          $wh = " where id='" . $id . "'";
        else $wh = "";
      $arrt = ( $this->db->query("select * from catpiezas " . $wh));
      return $arrt->num_rows;
    }

    function num_piezas_clase($clase) {
      $arrtot = $this->db->query("select * from catpiezas  where clase='" . $clase . "'");
      return $arrtot->num_rows();
    }

    function get_piezas_clase($clase,$lim,$cnt) {
        $arr = ( $this->db->query("select * from catpiezas where clase='" . $clase . "' order by id limit " 
              . $lim . ',' . $cnt));
        return ($arr->result_array());       
    }

    function get_piezas_por_clase($clase) {     
     $this->db->where("clase",$clase);
     $arr = $this->db->get("catpiezas");
     return ($arr->result_array());
   
    }      



  




}
?>