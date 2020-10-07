<?php
class Usuariosmodel extends CI_Model {


   function get_campos() {
    	$campos = array();
      $fields = $this->db->list_fields('USUARIOS');
        foreach ($fields as $field)
          {
          $campos[strtolower($field)] = "";
         }
         return $campos;
    }

    function get_lista_usuarios() {
      $q = $this->db->query("select * from lista_usuarios");
      $a = $q->result_array();
      return $a;
    }

    function get_detalle($id){
        $arr =  $this->db->query("select * from usuarios where id=" . $id );
	    $data = $arr->result_array(); 
		$registro = $data[0];
		return $registro;
    }

    function get_detalle_usuario($usuario){
        $arr =  $this->db->query("select first 1 * from usuarios where usuario='" . $usuario . "' order by passwd desc");
      $data = $arr->result_array(); 
      $arrsuc = $this->db->query("select distinct sucursal_id,nivel from usuarios where usuario='" . $usuario . "' and nivel<>-1 order by nivel,sucursal_id");
      $dsuc = $arrsuc->result_array();
    $registro = $data[0];
    $dsuc2 = array();
      foreach ($dsuc as $k=>$v) {
        $v['nombre_nivel'] = $this->get_nivel($v['nivel']);
        $dsuc2[$k] = $v;
      }
      $registro['sucursales'] = $dsuc2; 
    return $registro;
    }

   function get_usuarios_de_sucursal() {
    $sucursal_id = $this->session->sucursal_id;       
    $arr = $this->db->query("select * from usuarios where sucursal_id='" . $sucursal_id . "' and (nivel<>-1) and (passwd<>'') order by nivel,sucursal_id");    
    return $arr->result_array();
   }

   function es_super_administrador($usuario) {
     $this->db->where("usuario",$usuario);
     $this->db->where("nivel",0);
     $g = $this->db->get("usuarios");
     $ag = $g->result_array();
     if (count($ag)>0)
        return TRUE;
     else return FALSE;
   }

   function crear_super_administrador($usuario) {
     $this->db->where("usuario",$usuario);
     $us = $this->db->get("usuarios");
     $arrus = $us->result_array();
     $arrus0 = $arrus[0];
     $arrus0['sucursal_id'] = 'Todas';
     $arrus0['nivel'] = 0;
     unset($arrus0['id']);
     $this->db->insert("usuarios",$arrus0);
     return 1;
   }

   function quitar_super_administrador($usuario) {
     $this->db->where("usuario",$usuario);
     $this->db->where("nivel",0);
     $this->db->delete("usuarios");
     return 1;
   }   

   function get_niveles() {
    $niveles = array("0"=>"Super administrador", "1"=>"Administrador","2"=>"Tecnico","3"=>"Solo lectura");
    return $niveles;
   }

   function get_nivel($nivel) {
     if ($nivel!=-1) {
       $niveles = array(0=>"Super administrador", 1=>"Administrador",2=>"Tecnico",3=>"Solo lectura");
       return $niveles[$nivel];
     }
     else return "Suspendido";  

   }

   function guardar($p) {

        unset($p['submit']);
    
    
        $accion = $p['accion'];
       
        unset($p['accion']);
        unset($p['nivel']);
       
    
    if ($accion=="i") {
       $this->db->insert('usuarios',$p);
       redirect('/usuarios/'); 
    }
    else {
       $this->db->where('id', $p["id"]);
       $this->db->update('usuarios', $p); 
       $usr = $p['usuario'];
       unset ($p['id']);
       unset ($p['usuario']);
       unset ($p['sucursal_id']);
       unset ($p['nivel']);
       $this->db->where('usuario',$usr);
       $this->db->update('usuarios', $p); 


      } 
    
   }

 function eliminar($usuario) {
       $this->db->where('usuario', $usuario);

       $au = array("passwd"=>"","nivel"=>"-1");
     $this->db->update('usuarios',$au); 
     redirect('/usuarios/');    
    } 


    function cambiar_password($usuario,$nuevopassword) {
      $this->db->where("usuario",$usuario);
      $a = array("passwd"=>$nuevopassword);
      $this->db->update("usuarios",$a);
      return 1;
    }

}
?>