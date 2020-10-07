<?php
class Equiposmodel extends CI_Model {

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

    function get_equipos_where_str($wh,$lim="0",$cnt="900000") {
        $this->load->model("Clientesmodel");
        $arr = $this->db->query('select * from equipos ' . $wh . ' limit ' . $lim . ',' . $cnt);
        $res2 = array();

        if ($arr->num_rows()>0) {
           $res = $arr->result_array();
           foreach ($res as $k=>$v) {
              $cliente = $this->Clientesmodel->get_detalle($v['cliente_id']);
              $v['cliente'] = $cliente;
              $res2[$k] = $v;
           }
        }

        return $res2; 
    }


 function get_sqldesdebusqueda($usarlim = 1,$tipoorden = "") 
       {
		
		//$wh = " where (estatus not in ('Entregado','Donado a Rec','Reciclaje x olv'))";
		$wh = " where (1=1) ";
		$pendientes = "S";
		$busca_numorden = "";
		$busca_numserie = "";
		// $busca_numorden busca_numserie busca_nombre busca_estatus busca_modelo busca_tipo
		if (count($_POST)>0) { 
			     $wh = " where (1=1) ";
			
			  if ((isset($_POST['busca_numorden'])) && ($_POST['busca_numorden']!="")) 
				  $wh .= " and (num_orden='" . $_POST['busca_numorden'] . "')";				 
			  
              if ((isset($_POST['busca_numserie'])) && ($_POST['busca_numserie']!="")) 
				  $wh .= " and num_serie='" . $_POST['busca_numserie'] . "'";
				  
			  if ((isset($_POST['busca_estatus'])) && ($_POST['busca_estatus']!="")) 
				  $wh .= " and (estatus='" . $_POST['busca_estatus'] . "')";				 
			  
              if ((isset($_POST['busca_modelo'])) && ($_POST['busca_modelo']!="")) 
				  $wh .= " and modelo='" . $_POST['busca_modelo'] . "'";
				  
              if ((isset($_POST['busca_tipo'])) && ($_POST['busca_tipo']!="")) 
				  $wh .= " and tipo='" . $_POST['busca_tipo'] . "'";	
				  
              if ((isset($_POST['busca_nombre'])) && ($_POST['busca_nombre']!="")) {
				  $arr = $this->db->query("select id from clientes where nombre like '" . 
											   $_POST['busca_nombre'] . "%'");
	              $r = ($arr->result_array());
				  //$ids = $r[0];

        if ($arr->num_rows()>0)      
            $ids = $r[0];
          else $ids =array("id"=>-1);
      

				  $nr = " and (cliente_id in (";
				  foreach ($ids as $k=>$v) {
					  $nr .= $v . ",";
				  }
				  $nr .= "-1))";
				  $wh .= $nr;			
			  }
				 
			 
			  	  
		}
		
		$queryprincipal = 'select equipos.numero_remision,equipos.situacion,equipos.clase,equipos.num_orden, equipos.id,equipos.estatus,equipos.tipo,equipos.modelo,equipos.num_serie,equipos.capacidad,equipos.software,equipos.fecha_recibido,equipos.hora_recibido,equipos.cliente_id,clientes.nombre from equipos inner join clientes on equipos.cliente_id=clientes.id' . $wh; 	
		
		$queryprincipal .= 'order by equipos.num_orden ' . $tipoorden . ' ';
		
	if ($usarlim==1) {	
	    $lim = $this->uri->segment(3,'0');
		
		$queryprincipal .= ' limit ' . $lim . ',50';
	}
	  return $queryprincipal;
		
	}	   

   function get_equipo($id) {
   	    $arr = ( $this->db->query('select * from equipos where id=' . $id));
	    $data = ($arr->result_array());
	    return $data;
   }

   function get_detalle_equipo($id) {
       $this->load->model('Tiposclasesequiposmodel');
   	    $arr = ( $this->db->query('select * from equipos where id=' . $id));
        if ($arr->num_rows()>0) {
           $data = ($arr->result_array());
           $equipo = $data[0];
           $detalletipo = $this->Tiposclasesequiposmodel->get_detalle($equipo['tipo']);
           $equipo['descripcion_tipo'] = $detalletipo['descripcion'];
           return $equipo;
        }
        else return null;
   }


   function get_usuario_recibio($id) {
        $arrur = $this->db->query("select b.usuario_id,b.equipo_id,u.usuario from bitacoras b inner join usuarios u on b.usuario_id=u.id where b.equipo_id=" . $id . " and estatus='Recibido'") ;
	    $usrur = $arrur->result_array();
	    if (count($usrur)>0)
	       return $usrur[0];
	    else {
	         return array("usuario"=>"","equipo_id"=>0,"usuario"=>"");
	    }
   }

   function existe_numorden($num_orden) {
        $arreq = $this->db->query("select * from equipos where num_orden='" . $num_orden . "'");
        $nr = $arreq->num_rows();
        if ($nr==0)
        	  return FALSE;
        else return TRUE;

   }

   function insertar_equipo($arreq){
    unset($arreq['imprimir']);
		$this->db->insert('equipos',$arreq);
		$ultimo_eq_id = $this->db->insert_id();
		return $ultimo_eq_id;
   }

    function id_numorden($num_orden) {
        $arreq = $this->db->query("select id from equipos where num_orden='" . $num_orden . "'");
        $ra = $arreq->result_array();
        return $ra[0]['id'];
   }

   function get_numorden_estandarizado($num_orden_no_estandarizado) {
        $serie = $this->get_serie_actual();
        //echo substr($num_orden_no_estandarizado,0,2); die();
        if (substr($num_orden_no_estandarizado,0,2)!=$serie) {
          $num_orden_nuevo = ltrim($num_orden_no_estandarizado,"0");
          $num_orden_nuevo_con_serie = $serie . sprintf("%04d",$num_orden_nuevo); 
        }
        else
          $num_orden_nuevo_con_serie = $num_orden_no_estandarizado;
        return $num_orden_nuevo_con_serie;
   }

   function get_numorden_incrementar() {
   	    $arrnumord = ( $this->db->query('select * from numerosordenes where id=1'));
        $numordenes = ($arrnumord->result_array());		
		$signumorden = $numordenes[0]['numero_orden'] + 1;		   
	    $p = array("numero_orden"=>$signumorden);  
		$this->db->where('id', 1);
		$this->db->update('numerosordenes', $p);
		$numordenactual =  $numordenes[0]['serie'] . sprintf("%04d",$numordenes[0]['numero_orden']);
		return $numordenactual;
   }

   function get_numorden_no_incrementar() {
   	    $arrnumord = ( $this->db->query('select * from numerosordenes where id=1'));
        $numordenes = ($arrnumord->result_array());		
		$numordenactual = $numordenes[0]['serie'] . sprintf("%04d",$numordenes[0]['numero_orden']);
		return $numordenactual;
   }

   function get_numero_orden_actual() {
   	    $arrnumord = ( $this->db->query('select * from numerosordenes where id=1'));
        $numordenes = ($arrnumord->result_array());		
		$no = $numordenes[0]['numero_orden'];
		return $no; 
   }   

   function get_numremision_incrementar() {
   	    $arrnumord = ( $this->db->query('select * from numerosordenes where id=1'));
        $numordenes = ($arrnumord->result_array());		

        if ($numordenes[0]['numero_remision']=="")
        	$signum = 1;
        else
		    $signum = $numordenes[0]['numero_remision'] + 1;		   

	    $p = array("numero_remision"=>$signum);  
		$this->db->where('id', 1);
		$this->db->update('numerosordenes', $p);
		$numactual =  $numordenes[0]['numero_remision'];
		return $numactual;
   }

   function get_numremision_no_incrementar() {
   	    $arrnumord = ( $this->db->query('select * from numerosordenes where id=1'));
        $numordenes = ($arrnumord->result_array());		
		$numremisionactual = $numordenes[0]['numero_remision'];
		if ($numremisionactual=="")
			 $numremisionactual = 0;
		return $numremisionactual;
   }

   function set_numero_remision_a_equipo($equipo_id) {
   	    $numero_remision = $this->get_numremision_incrementar();
   	    $this->db->where('id',$equipo_id);
   	    $p = array("numero_remision"=>$numero_remision);
   	    $this->db->update('equipos',$p);
   	    return $numero_remision;
   }

   function get_serie_actual() {
   	    $arrnumord = ( $this->db->query('select * from numerosordenes where id=1'));
        $numordenes = ($arrnumord->result_array());		
		$serie = $numordenes[0]['serie'];
		return $serie;
   }

   function get_clave_sucursal() {
        $arrnumord = ( $this->db->query('select * from numerosordenes where id=1'));
        $numordenes = ($arrnumord->result_array());   
    $serie = $numordenes[0]['clave_sucursal'];
    return $serie;
   }



   function set_serie_numorden($serie,$numorden) {
   	  $qry1 = "update  numerosordenes set serie='" . $serie . 
                 "', numero_orden=" . $numorden . " where id=1";
		$arr1 = ( $this->db->query($qry1));
   	 return 1;
   }

   function set_numero_remision($numremision) {
   	  $qry1 = "update  numerosordenes set "  . 
                 " numero_remision=" . $numremision . " where id=1";
		$arr1 = ( $this->db->query($qry1));
   	 return 1;
   }


   function cancelar_orden($id) {
   	 $this->db->query("update equipos set situacion='X',fecha_cancelado=NOW() where id='" . $id . "'");
   	 return 1;
   }

   function cancelar_entrega($equipo_id) {
   	    // NO VERIFICA SI FUE ENTREGADO
   	    // YA QUE PARA CUANDO SE EJECUTA ESTO, YA SE ELIMINO EN LA BITACORA EL ESTATUS DE ENTREGADO.
    	$arr =  $this->db->query("select * from bitacoras where equipo_id=" .  $equipo_id . 
    		                     " order by fecha desc, hora desc limit 1");
	    $databit = ($arr->result_array());

	    if (count($databit)>0) {
			$registro = $databit[0];
			$est = $registro['estatus'];
			$estid = $registro['estatus_id'];
		}
		else {
			$est = "";
			$estid = -1;
		}	    


        $actualizachlistent = "chlst_ent_encendido='N',chlst_ent_lcd='N',chlst_ent_digitalizador='N'," .
                              "chlst_ent_conector='N',chlst_ent_sonido='N',chlst_ent_camara='N',chlst_ent_conexiones='N'," .
                              "chlst_ent_botones='N',chlst_ent_sim='N',chlst_ent_software='N',chlst_ent_carcasa='N'," .
                              "chlst_ent_sensores='N',";
		$actualizasituacion = " situacion='A', forma_de_pago='', ";

        $query = "update equipos set " . $actualizachlistent  . $actualizasituacion . 
                 "estatus='" . $est . "', estatus_id=" . $estid . 
                 "  where id='" . $this->uri->segment(3)  . "'" ;
        $r     = $this->db->query($query);
        return TRUE;

   }

   function eliminar_equipo($equipo_id,$num_orden,$passwd_admin) {

	   	$qry1 = "select * from equipos where id=" . $equipo_id;
			$arr1 = ( $this->db->query($qry1));
			$res1 = ($arr1->result_array());
			$eq = $res1[0];
			
			$qry2 = "select * from usuarios where passwd='" . $passwd_admin . "'";
			$arr2 = ( $this->db->query($qry2));
		if ($arr2->num_rows()>0) {
			$res2 = ($arr2->result_array());
			$nivusr = $res2[0]['nivel'];
		}
		else $nivusr=-1;

   if (($num_orden==$eq['num_orden']) && ($nivusr==1)) {
     	$this->db->query("delete from equipos where id='" . $equipo_id . "'");
     	$this->db->query("delete from bitacoras where equipo_id='" . $equipo_id . "'");
		$this->db->query("delete from piezas where equipo_id='" . $equipo_id . "'");
		$this->db->query("delete from servicios where equipo_id='" . $equipo_id . "'");
		return TRUE;
	}
	else return FALSE;

   }

  function agregar_recibido_a_bitacora($equipo_id,$fecha_de_diagnostico) {
		   // AGREGAR 'RECIBIDO' A LA BITACORA
       $arr =  $this->db->query("select * from estados where estatus='Recibido'");
       $data = ($arr->result_array());
       $rec = $data[0];


		    $bit = array("estatus_id" => $rec['id'],
		                "estatus" => "Recibido",
						"fecha" => date("Y-m-d"),
						"hora" => date("H:i:s"),
						"equipo_id"=> $equipo_id,
						"usuario_id" => $this->session->userdata('usuario_id'),
						"mensaje_para_fecha_adicional" => $rec['mensaje_para_fecha_adicional'],
            "proceso" => $rec['proceso'],
            "ubicacion" => $rec['ubicacion'],
						"fecha_adicional" =>  $fecha_de_diagnostico
						);	
		   $this->db->insert('bitacoras',$bit);
		   $this->db->where('id',$equipo_id);


  
		   $e = array("estatus"=>"Recibido","estatus_id"=>$rec['id']);
		   $this->db->update('equipos',$e);				 	
  } 

  function sincronizar_estatus_con_bitacora($equipo_id) {
  	    $arr =  $this->db->query("select * from bitacoras where equipo_id=" .  $equipo_id . " order by fecha desc, hora desc limit 1");
	    $data = ($arr->result_array());
    
        $query = "update equipos set estatus='" . $data[0]['estatus'] . "', estatus_id=" . $data[0]['estatus_id'] . 
                 " where id='" . $equipo_id . "'" ;
        $r     = $this->db->query($query);
        return 1;
  }

  function sincronizar_fecha_de_entrega($equipo_id) {
      $arr =  $this->db->query("select * from bitacoras where equipo_id=" .  $equipo_id . " and estatus='Entregado'");
     if ($arr->num_rows()>0)  {
      $data = ($arr->result_array());   
      $fecha = $data[0]["fecha"];
      $ar1 = array("fecha_de_entrega"=>$fecha);
      $this->db->where("id",$equipo_id);
      $this->db->update("equipos",$ar1);

      return 1; 
      }
      else return 0;
  }

  function copiar_fecha_recibido_a_bitacora($equipo_id) {
  	   $equipo = $this->get_detalle_equipo($equipo_id);
  	   $p = array("fecha"=>$equipo['fecha_recibido'],"hora"=>$equipo['hora_recibido']);

       $query = "update bitacoras set fecha='" . $equipo['fecha_recibido'] . "', hora='" . $equipo['hora_recibido'] . "' " . 
                 " where equipo_id=" . $equipo_id . " and estatus='Recibido'" ;
       $r     = $this->db->query($query);
       return 1;
  }

  function get_equipos_en_empresa() {
  	  $arr = $this->db->query("select * from equipos where estatus not in ('Entregado','Reciclaje forzado','Donado a reciclaje') and situacion='A'");
	    $data = ($arr->result_array());
	    $data2 = array();
	    foreach ($data as $k=>$v) {
	    	 $arrt = $this->db->query("select * from tipos where tipo='" . $v['tipo'] . "'");
	         $datat = $arrt->result_array();
	         $v['descripcion_tipo'] = $datat[0]['descripcion'];
            $data2[$k] = $v;
	    }
	    return $data;
  }

  function concluir_orden_equipo(){
        $this->db->where('id',$_POST['equipo_id']);
		$e = array("situacion"=>"C");
		$this->db->update('equipos',$e);	  	
		return 1;
  }

  function get_estatus_equipo($equipo_id){
  	   $equipo = $this->get_equipo($equipo_id);
  	   $estatus = $equipo[0]['estatus'];
  	   return $estatus;
  }

  function poner_servicios_en_cero($equipo_id){
  	   $this->db->where('equipo_id',$equipo_id);
  	   $u = array("subtotal"=>0);
  	   $this->db->update('servicios',$u);
       return 1;
  }

  function reestablecer_servicios_sin_ceros($equipo_id){
  	   $this->db->query('update servicios set subtotal=costo-descuento where equipo_id=' . $equipo_id);
       return 1;
  }

  function get_numero_servicios_equipo($equipo_id) {
      $arr = $this->db->query("select count(*) as cnt from servicios where equipo_id=" . $equipo_id);
      $data = ($arr->result_array());
      return $data[0]['cnt'];
  }

  function array_checklist($tipo="") {
      $ch = array(
           "chlst_rec_sensor_centro"=>"a. Sensor de centro de carga activado.",
           "chlst_rec_sensor_humedad"=>"b. Sensor de humedad de entrada de auriculares activado.",
           "chlst_rec_falla_carga"=>"c. Falla recepci&oacute;n de carga de corriente.",
           "chlst_rec_falla_deteccion"=>"d. Falla detecci&oacute;n en computadora.",
           "chlst_rec_falla_senal"=>"e. Falla recepci&oacute;n de se&ntilde;al telef&oacute;nica.",
           "chlst_rec_falla_wifi"=>"f.  Falla recepci&oacute;n de se&ntilde;al wifi y bluetooth.",
           "chlst_rec_falla_visualizacion"=>"g. Falla visualizaci&oacute;n correcta del pantalla.",
           "chlst_rec_falla_com_touch"=>"h. Falla detecci&oacute;n de comandos de touch.",
           "chlst_rec_falla_com_rueda"=>"i.  Falla detecci&oacute;n de comandos rueda.",
           "chlst_rec_func_boc_altavoz"=>"j.  Falla funci&oacute;n de la bocina altavoz.",
           "chlst_rec_func_boc_auricular"=>"k. Falla funci&oacute;n de la bocina auricular.",
           "chlst_rec_func_ent_auriculares"=>"l.  Falla funci&oacute;n de la entrada de auriculares.",
           "chlst_rec_func_microfono"=>"m. Falla funci&oacute;n del micr&oacute;fono.",
           "chlst_rec_func_bot_home"=>"n. Falla funci&oacute;n del bot&oacute;n home.",
           "chlst_rec_func_bot_encendido"=>"o. Falla funci&oacute;n del bot&oacute;n de encendido o hold.",
           "chlst_rec_func_bot_silencio"=>"p. Falla funci&oacute;n del bot&oacute;n de silencio.",
           "chlst_rec_func_bot_volumen"=>"q. Falla funci&oacute;n de los botones de volumen.",
           "chlst_rec_falla_bandeja_sim"=>"r.  Falla bandeja SIM."
        );

    if ($tipo=="ent") { 
      $newarray = array();
      foreach ($ch as $k=>$v) {
        $knw = str_replace("_rec_", "_ent_", $k);
        $newarray[$knw] = $v;
      }
        return $newarray;
    }    
    else {
       return $ch;
     }
  }


  function siguiente_equipo_activo($equipo_id=0) {
      $arr = $this->db->query("select id from equipos where id>" . $equipo_id . 
           " and situacion='A' order by id limit 1");
      $data = ($arr->result_array());
      if ($arr->num_rows()>0)
         return $data[0]['id'];
      else return $equipo_id;

  }

  function anterior_equipo_activo($equipo_id=0) {
      $arr = $this->db->query("select id from equipos where id<" . $equipo_id . 
           " and situacion='A' order by id desc limit 1");
      $data = ($arr->result_array());
      if ($arr->num_rows()>0)
         return $data[0]['id'];
      else return $equipo_id;

  }

  function exportacion_datos($anio,$mes) {
    $qry = "select * from equipos inner join clientes on equipos.cliente_id=clientes.id where year(fecha_recibido)=" . $anio . " and month(fecha_recibido)=" . $mes . " order by equipos.id";
    $arr = $this->db->query($qry);
    $data = $arr->result_array();
    $data2 = array();
    $ii = 0;
    foreach ($data as $k=>$v) {
       //$v['servicio_descripcion'] = "";
       

       $sql = "select * from servicios where equipo_id=" . $v['id'];
       $arrs = $this->db->query($sql); 
      if ($arrs->num_rows()>0) {
          $v['servicios'] = $arrs->result_array();
           //print_r($arrs->result_array());
         }
         else $v['servicios'] = array();
      $data2[$ii] = $v;
      $ii++;
    }
    return $data2;
 

  }
  
      
}
?>