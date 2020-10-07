<?php
class Comunicacionesmodel extends CI_Model {

	function Formmodel() {
	// load the parent constructor
	parent::Model();
	}


	function get_comunicaciones($equipo_id) {	
        $sqc  = "SELECT comunicaciones.id,comunicaciones.fecha,comunicaciones.usuario_id,comunicaciones.asunto,";
        $sqc .= "comunicaciones.notas,usuarios.usuario ";
        $sqc .= "FROM comunicaciones INNER JOIN usuarios ON (comunicaciones.usuario_id = usuarios.id) " .
                " where equipo_id=" . $equipo_id . " order by comunicaciones.fecha,comunicaciones.id";	

        $arrc = $this->db->query($sqc);
        $comunicaciones = $arrc->result_array();
        return $comunicaciones;				
	}
		
		
  

    
}
?>