<?php
class Registroaccionesmodel extends CI_Model {

	function Formmodel() {
	// load the parent constructor
	parent::Model();
	}

   function get_campos() {
    	$campos = array();
    	$fields = $this->db->list_fields('registroacciones');
        foreach ($fields as $field)
          {
           $campos[$field] = "";
         }
         return $campos;
    }

   function registrar($accion,$tabla,$detalle) { 
          $registroacc = array(
                       "usuario" => $this->session->userdata('usuario'),
                       "usuario_id" => $this->session->userdata('usuario_id'),
                       "fecha_hora" => date ("Y-m-d H:i:s"),
                       "accion"  => $accion,
                       "tabla"   => $tabla,
                       "detalle" => $detalle);
          $this->db->insert('registroacciones',$registroacc);    
          return 1;
   }    

    function get_detalle($tipo_id){
        $arrt = ( $this->db->query("select * from tipos where tipo='" . $tipo_id . "'"));
        $clasetipo = ($arrt->result_array());
        $registro = $clasetipo[0];
		return $registro;
    }

    function get_tipos_dropdown(){
        $arrt = ( $this->db->query('select * from tipos'));
        $tipos = ($arrt->result_array());       
        $tip = array();
        foreach ($tipos as $tipo) {
            $tip[$tipo["tipo"]] = $tipo["descripcion"];
        }
        return $tip;
    }      


    function consulta_por_dia($a = 0, $m = 0, $d =0 ) {
      $arr = $this->db->query("select * from registroacciones where  YEAR(fecha_hora)=" . $a . 
            " and MONTH(fecha_hora)=" . $m . " and DAY(fecha_hora)=" . $d);
      return $arr->result_array(); 
    }



    


}
?>