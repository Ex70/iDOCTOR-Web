<?php
class Clientesmodel extends CI_Model {

	function Formmodel() {
	// load the parent constructor
	parent::Model();
	}

   function get_campos() {
    	$campos = array();
    	$fields = $this->db->list_fields('clientes');
        foreach ($fields as $field)
          {
           $campos[$field] = "";
         }
         return $campos;
    }

    function get_detalle($id){
        $arr =  $this->db->query('select * from clientes where id=' . $id);
	    $data = $arr->result_array(); 
		$registro = $data[0];
		$registro["desdeequipo"] = "N";    	
		return $registro;
    }

    function get_clientes_dropdown() {
        $arr = $this->db->query('select id,nombre from clientes order by nombre');
	    $clientes = ($arr->result_array());		
		$cli = array();
		foreach ($clientes as $cliente) {
			$cli[$cliente["id"]] = $cliente["nombre"];
		}
		return $cli;
    }

    function activar_cliente($id) {
        $this->db->where("id",$id);
        $data = array("estatus"=>"ACTIVO");
        $this->db->update("clientes",$data);
        return 1;
    }

    function agregar_nuevo_cliente_nueva_orden($datos) {
        $arrcli = array('nombre' => $datos['nombrecliente'],
                            'telefono1' => $datos['telefono1'],
                            'telefono2' => $datos['telefono2'],
                            'correo_electronico' => $datos['correo_electronico'],
                            'direccion' => $datos['direccion'],
                            'colonia' => $datos['colonia'],
                            'cp' => $datos['cp'],
                            'ciudad' => $datos['ciudad'],
                            'estado' => $datos['estado'],
                            'agregado_por'=>$this->session->userdata('username'),
                            'fechaalta'=>date("Y-m-d H:i:s"),
                            'estatus'=>"ACTIVO"
                            );
        $this->db->insert('clientes',$arrcli);
        return $this->db->insert_id();        
    }

    function get_clientes_where_str($wh,$lim="10",$cnt="20") {
        $arr = ( $this->db->query('select * from clientes ' . $wh . ' limit ' . $lim . ',' . $cnt));
        return ($arr->result_array()); 
    }

    function get_cliente_de_equipo($equipo_id) {
            $arr =  $this->db->query("select clientes.id,clientes.nombre,clientes.telefono1,clientes.telefono2, " .
              "clientes.direccion, clientes.correo_electronico, clientes.colonia, clientes.cp, " .
              "clientes.ciudad, clientes.estado from clientes inner join equipos " .
              "on clientes.id=equipos.cliente_id where equipos.id=" .  $equipo_id);
            $data = $arr->result_array(); 
            $cliente = $data[0]; 
            return $cliente;        
    }
    


}
?>