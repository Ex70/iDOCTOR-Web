<?php
class Articulosventasmodel extends CI_Model {

	function Formmodel() {
	// load the parent constructor
	parent::Model();
	}


   function get_campos() {
    	$campos = array();
    	$fields = $this->db->list_fields('articulos');
        foreach ($fields as $field)
          {
           $campos[$field] = "";
         }
         return $campos;
    }

    function get_detalle($id){
        $arr =  $this->db->query("select * from articulos where id=" . $id);
	    $data = $arr->result_array(); 
		$registro = $data[0];
		return $registro;
    }

    function get_articulos_dropdown() {
        $arr = $this->db->query('select id,descripcion from articulos order by id');
	    $articulos = ($arr->result_array());		
		$cli = array();
		foreach ($articulos as $articulo) {
			$cli[$articulo["id"]] = $articulo["descripcion"];
		}
		return $cli;
    }

  
    function get_articulos_where_str($wh,$lim="10",$cnt="20") {
        $arr = ( $this->db->query('select * from articulos ' . $wh . ' limit ' . $lim . ',' . $cnt));
        return ($arr->result_array()); 
    }

    function get_articulos_uniqid() {
        return uniqid();
    }

    function consulta_ventas_por_mes($a = 0, $m = 0 ) {

      $sql =  "select  c.nombre, a.cliente_id,a.fecha,a.numero_remision,sum(precio) as total from articulos a ";
      $sql .= "inner join clientes c ";
      $sql .= "on c.id=a.cliente_id ";
      $sql .= "where a.numero_remision is not null ";
      $sql .= "and YEAR(a.fecha)=" . $a . " and MONTH(a.fecha)=" . $m . " ";
      $sql .= "group by a.fecha,a.numero_remision ";
      $sql .= "order by a.numero_remision";      

      $arr = $this->db->query($sql);
      return $arr->result_array(); 
    }

    function get_articulos_numero_remision($nr) {
        $arr = $this->db->query("select * from articulos where numero_remision=" . $nr);
        return ($arr->result_array()); 
    }

    function agregar_articulo_venta($p) {
        $this->db->insert("articulos",$p);   
        $insertid = $this->db->insert_id();   
        return $insertid;
    }

    function eliminar_articulo_venta($id) {
        $this->db->where("id",$id);
        $this->db->delete("articulos");
    }

    function num_total_articulos(){
      $arr = $this->db->query("select * from catarticulos");
      return $arr->num_rows();
    }

  /*  function get_articulo_de_equipo($equipo_id) {
            $arr =  $this->db->query("select articulos.id,articulos.nombre,articulos.telefono1,articulos.telefono2, " .
              "articulos.direccion, articulos.correo_electronico, articulos.colonia, articulos.cp, " .
              "articulos.ciudad, articulos.estado from articulos inner join equipos " .
              "on articulos.id=equipos.articulo_id where equipos.id=" .  $equipo_id);
            $data = $arr->result_array(); 
            $articulo = $data[0]; 
            return $articulo;        
    }
    */


}
?>