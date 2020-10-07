<?php
class Catalogosmodel extends CI_Model {

	function Formmodel() {
	// load the parent constructor
	parent::Model();
	}

    function get_bitacorasequipo($equipo_id) {
        $arr = ( $this->db->query('select b.proceso,b.ubicacion,b.id,b.estatus,b.fecha,b.hora,b.descripcion,b.fecha_adicional,' .
        	     'b.usuario_id,b.equipo_id,u.usuario,b.mensaje_para_fecha_adicional from bitacoras b ' .
        	     ' inner join usuarios u on b.usuario_id=u.id where b.equipo_id=' . $equipo_id . 
        	     ' order by b.fecha,b.hora,b.id') );
	    $bitacoras = ($arr->result_array());
	    return $bitacoras;

    }

	function get_piezasequipo($equipo_id) {	
        $arr = ( $this->db->query('select * from piezas where equipo_id=' . $equipo_id));
	    $piezas = ($arr->result_array());
	    return $piezas;
	 }   
	
	function get_serviciosequipo($equipo_id) {	
		$arr = $this->db->query('select * from servicios where equipo_id=' . $equipo_id);
	    $servicios = ($arr->result_array());
	    return $servicios;
	 }   
	
	function get_tipos(){
        $arrt = ( $this->db->query('select * from tipos'));
        $tipos = ($arrt->result_array());		
        return $tipos;
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

    function get_cajas($caja_id) {
    	$querycajas = "select * from catcajas where (catcajas.id not in " .
		"(select catcajas.id from catcajas inner join equipos on catcajas.id=equipos.caja_id)) ";
        if ($caja_id!="")
            $querycajas .= " or (catcajas.id=" . $caja_id . ") ";
		$querycajas .= " order by catcajas.descripcion ";

        $arrc  =  $this->db->query($querycajas);

        $cajas =  $arrc->result_array();		

        return $cajas;
    }

    function get_cajas_dropdown($caja_id) {
    	$cajas = $this->get_cajas($caja_id);

    	$caj = array(""=>"");
		foreach ($cajas as $caja) {
			$caj[$caja["id"]] = $caja["descripcion"];
		}

		return $caj;	
    }
		
		
  

    
}
?>