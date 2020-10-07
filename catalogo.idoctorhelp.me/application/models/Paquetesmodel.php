<?php
class Paquetesmodel extends CI_Model {



   function get_campos() {
    	$campos = array();
      
      $fields = $this->db->list_fields('paquetes');
        foreach ($fields as $field)
          {
           $campos[$field] = "";
         }
         $campos['total'] = 0;
         $campos['costo'] = 0;
         $campos['diferencia'] = 0;
         return $campos;
    }

    function get_paquetes_dropdown() {
      $r = array(""=>"Todos", "LIGHT"=>"Light","BASICO"=>"Básico","PLUS"=>"Plus","PREMIUM"=>"Premium");
      return $r;
    }

    function get_superclases() {
      $r = array(""=>"Todos", "IPHONE"=>"iPhone","IPAD"=>"iPad","IPOD"=>"iPod");
      return $r;
    } 


    function get_detalle($id){
      

        $arr =  $this->db->query("select * from paquetes where id='" . $id . "'");
	    $data = $arr->result_array(); 
		$registro = $data[0];
		return $registro;
    }

    function get_paquetes_clase_dropdown($clase) {
      

        $arr = $this->db->query('select id,descripcion from paquetes order by id');
	    $paquetes = ($arr->result_array());		
		$cli = array();
		foreach ($paquetes as $servicio) {
			$cli[$servicio["id"]] = $servicio["descripcion"];
		}
		return $cli;
    }


    function get_paquetes($wh) {
        

       if (is_array($wh))
         $this->db->where($wh);        

        $this->db->order_by("id");

        $arr = $this->db->get('paquetes');
        //echo $this->db->last_query();
        return ($arr->result_array()); 
    }


    function get_paquetes_where_str($wh,$lim="10",$cnt="20") {
        
        $arr = ( $this->db->query('select * from paquetes ' . $wh . ' limit ' . $lim . ',' . $cnt));
        return ($arr->result_array()); 
    }

    function agregar_paquete($p){
       
       $this->db->insert('paquetes',$p);
    }

    function modificar_paquete($id,$p) {
       
       $this->db->where('id', $id);
       $this->db->update('paquetes', $p);      
    }

    function eliminar($id){
       
       $this->db->query("delete from paquetes where id='" . $id . "'");      
    }    


    function guardar($p) {
      $accion = $p['accion'];

      $p = $this->filtra_post_guardar($p);
      $p['total'] = $p['costo'] + $p['diferencia'];

      
      if ($accion=="i")
        $this->db->insert('paquetes',$p);
      else {
         $this->db->where("id",$p['id']);
         $this->db->update("paquetes",$p); 
      }

    }




    function filtra_post_guardar($p) {
        $a = $this->get_campos();
        foreach ($p as $pk=>$pv) {
            $existe = 0;
             foreach ($a as $k=>$v) {
                 if ($pk==$k)
                     $existe = 1;                
             }             
              if (!$existe)
                unset($p[$pk]);
         }
         return $p; 
    }  






}
?>