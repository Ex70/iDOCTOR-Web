<?php
class Tiposclasesequiposmodel extends CI_Model {

	function Formmodel() {
	   // load the parent constructor
	   parent::Model();
	}

   function sincronizar_bds() {
      $arrt  =  $this->db->query("select * from tipos");
      $tipos = $arrt->result_array();

      $arrst  =  $this->db->query("select * from subtipos");
      $stipos = $arrst->result_array();

      $arrcla  =  $this->db->query("select * from clases");
      $clases = $arrcla->result_array();

      $this->load->model("Basesdedatosmodel");
      $bds = $this->Basesdedatosmodel->get_basesdedatos();

      foreach ($bds as $k=>$v) {

              $DBactual = $this->load->database($v['basededatos'], TRUE);
              $DBactual->query('delete from tipos');
              $DBactual->query('delete from subtipos');
              $DBactual->query('delete from clases');

              foreach ($tipos as $k1=>$v1) {
                 $DBactual->insert("tipos",$v1);
              }

              foreach ($stipos as $k2=>$v2) {
                 $DBactual->insert("subtipos",$v2);
              }

              foreach ($clases as $k3=>$v3) {
                 $DBactual->insert("clases",$v3);
              }

      }
   } 

   function get_campos() {
    	$campos = array();
    	$fields = $this->db->list_fields('TIPOS');
        foreach ($fields as $field)
          {
           $campos[strtolower($field)] = "";
         }
         return $campos;
    }

    function get_campos_tipos() {
      return $this->get_campos();
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

    function get_tipos_where_str($wh,$lim="10",$cnt="20") {
        $arr = ( $this->db->query('select * from tipos ' . $wh . ' limit ' . $lim . ',' . $cnt));
        $res = ($arr->result_array()); 
        $res2 = array();
        foreach ($res as $k=>$v) {
             $arrst = $this->db->query("select * from subtipos where tipo='" . $v['tipo'] . "'");
             $resst = ($arrst->result_array()); 
             $v['subtipos'] = $resst;
             $res2[$k] = $v;

             $arrcl = $this->db->query("select * from clases where clase='" . $v['clase'] . "'");
             if ($arrcl->num_rows()>0) {
                $rescl = ($arrcl->result_array()); 
                $v['clase_descripcion'] = $rescl[0]['descripcion'];
             }
             else $v['clase_descripcion'] = 'No asignada';
             $res2[$k] = $v;

        }
        return $res2;
    }

    function agregar_subtipos_y_clases(&$res) {
       $res2 = array();
        foreach ($res as $k=>$v) {
             $arrst = $this->db->query("select * from subtipos where tipo='" . $v['tipo'] . "'");
             $resst = ($arrst->result_array()); 
             $v['subtipos'] = $resst;
             $res2[$k] = $v;

             $arrcl = $this->db->query("select * from clases where clase='" . $v['clase'] . "'");

                $rescl = ($arrcl->result_array()); 
             if (count($rescl)>0) {
                $v['clase_descripcion'] = $rescl[0]['descripcion'];
             }
             else $v['clase_descripcion'] = 'No asignada';
             $res2[$k] = $v;

        }
        $res = $res2;     

    }

    function get_tipos_de_clase($clase) {
      $this->db->where("clase",$clase);
      $this->db->order_by("descripcion");
      $a = $this->db->get("tipos");
      $r = $a->result_array();
      $this->agregar_subtipos_y_clases($r);
      return $r;
    }

    function get_tipos() {
      $this->db->order_by("descripcion");
      $a = $this->db->get("tipos");
      $r = $a->result_array();
      $this->agregar_subtipos_y_clases($r);
      return $r;
    }    

    function get_cnt_tipos_where_str($wh) {
        $arr = ( $this->db->query('select count(*) as cnt from tipos ' . $wh));
        $res = ($arr->result_array());       
        return $res[0]['cnt'];
    }

//---------------  C L A S E S 

    function get_clases_dropdown(){
        $arrt = ( $this->db->query('select * from clases order by clase'));
        $clases = ($arrt->result_array());       
        $c = array();
        foreach ($clases as $cla) {
            $c[$cla["clase"]] = $cla["descripcion"];
        }
        return $c;
    } 

    


}
?>