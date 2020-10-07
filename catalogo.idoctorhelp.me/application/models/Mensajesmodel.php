<?php
class Mensajesmodel extends CI_Model {

	function Formmodel() {
	// load the parent constructor
	parent::Model();
	}


   function get_campos() {
    	$campos = array();
    	$fields = $this->db->list_fields('mensajes');
        foreach ($fields as $field)
          {
           $campos[$field] = "";
         }
         return $campos;
    }

    function get_detalle($id){
         $sql = "select m.id,m.usuario_id,m.fecha,m.hora,m.mensaje, " .
               " m.titulo,u.nombre,u.usuario,m.usuario_destinatario_id,m.leido_destinatario from mensajes m inner join  " .
               " usuarios u on m.usuario_id=u.id ";

        $arr =  $this->db->query($sql . " where m.id='" . $id . "'");
	    $data = $arr->result_array(); 
		$registro = $data[0];
		return $registro;
    }

    function get_mensajes_dropdown() {
        $arr = $this->db->query('select id,titulo from mensajes order by id');
	    $mensajes = ($arr->result_array());		
		$cli = array();
		foreach ($mensajes as $mensaje) {
			$cli[$mensaje["id"]] = $mensaje["descripcion"];
		}
		return $cli;
    }



    function get_mensajes_where_str($wh,$lim="0",$cnt="10") {
        $sql = "select m.id,m.usuario_id,m.fecha,m.hora,m.mensaje, " .
               " m.titulo,u.nombre,u.usuario from mensajes m inner join  " .
               " usuarios u on m.usuario_id=u.id ";

        $arr = ( $this->db->query($sql . $wh . ' order by id desc limit ' . $lim . ',' . $cnt));
        return ($arr->result_array()); 
    }

    function get_mensajes_de_usuario($lim="0",$cnt="10") {
        $sql = "select m.id,m.usuario_id,m.fecha,m.hora,m.mensaje, " .
               " m.titulo,u.nombre,u.usuario,m.usuario_destinatario_id,m.leido_destinatario from mensajes m inner join  " .
               " usuarios u on m.usuario_id=u.id " .
               " where (usuario_destinatario_id=0) or (usuario_destinatario_id=" . $this->session->userdata('usuario_id') . ") ";

        $arr = ( $this->db->query($sql . ' order by id desc limit ' . $lim . ',' . $cnt));
        $result = ($arr->result_array()); 
        $result2 = array();
        foreach ($result as $k=>$v) {
            $u = $this->db->query("select * from usuarios where id=" . $v['usuario_destinatario_id']);
            $ru = $u->result_array();
            if ($u->num_rows()>0) {
                $v['usuario_destinatario'] = $ru[0]['usuario'];
                $v['usuario_destinatario_nombre'] = $ru[0]['nombre'];
            }
            else {
                $v['usuario_destinatario'] = "Todos";
                $v['usuario_destinatario_nombre'] = "Todos";
              }
           $result2[$k] = $v;
        }
        return $result2;
    }

   function set_leido($id) {
      $this->db->query("update mensajes set leido_destinatario='S' where id=" . $id);
      return 1;
   }

    function get_mensajes_uniqid() {
        return uniqid();
    }

    function get_cnt_where_str($wh) {
        $arr = ( $this->db->query('select count(*) as cnt from mensajes ' . $wh));
        $res = ($arr->result_array());       
        return $res[0]['cnt'];
    }

    

}
?>