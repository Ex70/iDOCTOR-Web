<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Equipos extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 
	 
	 */
	 
    public function __construct()
       {
            parent::__construct();
	   
       }	 
	   
private function _cambiaf_a_normal($fecha){ 
   	//ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
	preg_match( "/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/", $fecha, $mifecha); 
   	$lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1]; 
   	return $lafecha; 
} 	   
	   
	   
    private function _generasqldesdebusqueda($usarlim = 1) 
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
				  $ids = $r[0];
				  $nr = " and (cliente_id in (";
				  foreach ($ids as $k=>$v) {
					  $nr .= $v . ",";
				  }
				  $nr .= "-1))";
				  //print_r($nr); die();
				  $wh .= $nr;			
			  }
				 
			 
			  	  
		}
		
		$queryprincipal = 'select equipos.situacion,equipos.clase,equipos.num_orden, equipos.id,equipos.estatus,equipos.tipo,equipos.modelo,equipos.num_serie,equipos.capacidad,equipos.software,equipos.fecha_recibido,equipos.hora_recibido,equipos.cliente_id,clientes.nombre from equipos inner join clientes on equipos.cliente_id=clientes.id' . $wh; 	
		
	if ($usarlim==1) {	
	    $lim = $this->uri->segment(3,'0');
		
		$queryprincipal .= ' limit ' . $lim . ',50';
	}
	  return $queryprincipal;
		
	}	   

	 
	public function index()
	{
		 $this->load->library('pagination');
		 // $busca_numorden busca_numserie busca_nombre busca_estatus busca_modelo busca_tipo
		  $busca_numorden = (isset($_POST['busca_numorden']) ? $_POST['busca_numorden'] : "");
		  $busca_numserie = (isset($_POST['busca_numserie']) ? $_POST['busca_numserie'] : "");
		  $busca_nombre = (isset($_POST['busca_nombre']) ? $_POST['busca_nombre'] : "");
		  $busca_estatus = (isset($_POST['busca_estatus']) ? $_POST['busca_estatus'] : "");	
		  $busca_modelo = (isset($_POST['busca_modelo']) ? $_POST['busca_modelo'] : "");
		  $busca_tipo = (isset($_POST['busca_tipo']) ? $_POST['busca_tipo'] : "");			  
		
        $arrt = ( $this->db->query('select * from tipos'));
        $tipos = ($arrt->result_array());		
		
		$tip = array("" => "Cualquiera");
		foreach ($tipos as $tipo) {
			$tip[$tipo["tipo"]] = $tipo["descripcion"];
		}				
		
		
        $qry = $this->_generasqldesdebusqueda();
		//echo $queryprincipal;
		$lim = $this->uri->segment(3,'0');
		$arr = ( $this->db->query($qry));
	    $data['result'] = ($arr->result_array());
		
		//$data['pendientes'] = $pendientes;
		$data['tipos'] = $tip;
		$data['busca_numorden'] = $busca_numorden;
		$data['busca_numserie'] = $busca_numserie;
		$data['busca_nombre'] = $busca_nombre;
		$data['busca_estatus'] = $busca_estatus;
		$data['busca_modelo'] = $busca_modelo;
		$data['busca_tipo'] = $busca_tipo;
		
		$config['base_url'] = '/index.php/equipos/index';
		$arrtot = ( $this->db->query( $this->_generasqldesdebusqueda(0)));
        $config['total_rows'] = $arrtot->num_rows();
        $config['per_page'] = 50; 
		$this->pagination->initialize($config);		

        $arrestatus =  $this->db->query("select distinct estatus from estados order by indice");
	    $dataestatus = ($arrestatus->result_array());	
		$estatus = array(""=>"Cualquiera");
		foreach ($dataestatus as $k=>$v) 
		  $estatus[$v['estatus']] = $v['estatus'];
		//print_r($estatus); die();
		
		$data['catestatus'] = $estatus; 
		$this->load->view('inicio/top1'); 
		// $this->load->view('inicio/menuinterior');
		 $this->load->view('equipos/buscar',$data); 
		 $this->load->view('equipos/equiposindex',$data); 
		 $this->load->view('inicio/bottom1'); 
		 
		
	}
	
	
	
    public function buscar() {
		
	    $pendientes = "S";
		$busca_numorden = "";
		$busca_numserie = "";
		
		if (count($_POST)>0) { 
			     $wh = " where (1=1) ";
			
			  if ((isset($_POST['busca_numorden'])) && ($_POST['busca_numorden']!="")) {
				  $wh .= " and (num_orden='" . $_POST['busca_numorden'] . "')";
				  $busca_numorden = $_POST['busca_numorden'];
			  }
              if ((isset($_POST['busca_numserie'])) && ($_POST['busca_numserie']!="")) {
				  $wh .= " and num_serie='" . $_POST['busca_numserie'] . "'";
				  $busca_numserie = $_POST['busca_numserie'];
			  }	
			  
              if ((isset($_POST['pendientes'])) && ($_POST['pendientes']=="S")) {
				  $wh .= " and estatus not in ('Entregado','Donado a Rec','Reciclaje x olv')";
				  $pendientes = "S";
			  }	
			  else {
			      $wh = " where (estatus in ('Entregado','Donado a Rec','Reciclaje x olv'))";
				   $pendientes = "";
			  }
			  
			
			  
		}
		
        $arrt = ( $this->db->query('select * from tipos'));
        $tipos = ($arrt->result_array());		
		
		$tip = array("" => "Cualquiera");
		foreach ($tipos as $tipo) {
			$tip[$tipo["tipo"]] = $tipo["descripcion"];
		}				
		
        $arrestatus =  $this->db->query("select distinct estatus from estados order by indice");
	    $dataestatus = ($arrestatus->result_array());	
		$estatus = array(""=>"Cualquiera");
		foreach ($dataestatus as $k=>$v) 
		  $estatus[$v['estatus']] = $v['estatus'];
		//print_r($estatus); die();
		$data['tipos'] = $tip;
		
		$data['catestatus'] = $estatus;
		$data['pendientes'] = $pendientes;
		$data['busca_numorden'] = $busca_numorden;
		$data['busca_numserie'] = $busca_numserie; $this->load->view('inicio/top1'); 
		 //$this->load->view('inicio/menuinterior');
		 $this->load->view('equipos/buscar',$data); 
		$this->load->view('inicio/bottom1'); 		
		
	}
	
	public function recibir($params=NULL) {
		$registro=array();
		
        $arrt = ( $this->db->query('select * from tipos'));
        $tipos = ($arrt->result_array());		
		
		$tip = array();
		foreach ($tipos as $tipo) {
			$tip[$tipo["tipo"]] = $tipo["descripcion"];
		}	
		
		// SOLO LAS CAJAS LIBRES
        $querycajas = "select * from catcajas where (catcajas.id not in " .
		"(select catcajas.id from catcajas inner join equipos on catcajas.id=equipos.caja_id)) order by catcajas.descripcion";
		
       $arrc = ( $this->db->query($querycajas));
        $cajas = ($arrc->result_array());		
		
		$caj = array(""=>"");
		foreach ($cajas as $caja) {
			$caj[$caja["id"]] = $caja["descripcion"];
		}			
		
		$registro['correo_electronico'] = '';
		$registro['telefono1a'] = '';
		$registro['telefono1b'] = '';
		$registro['telefono1c'] = '';
		$registro['telefono2a'] = '';
		$registro['telefono2b'] = '';
		$registro['telefono2c'] = '';
		$registro['contrasenia'] = '';
		$registro['fecha_de_entrega'] = '';
		$registro['chlst_encendido'] = 0;
		$registro['chlst_lcd'] = 0;
		$registro['chlst_digitalizador'] = 0;
		$registro['chlst_conector'] = 0;
		$registro['chlst_sonido'] = 0;
		$registro['chlst_camara'] = 0;
		$registro['chlst_conexiones'] = 0;
		$registro['chlst_botones'] = 0;
		$registro['chlst_sim'] = 0;
		$registro['chlst_software'] = 0;
		$registro['chlst_carcasa'] = 0;
		$registro['chlst_sensores'] = 0;
		$registro['caja_id'] = '';
		
		if (isset($params) && is_array($params)) {
			 //print_r($params); die();
			foreach ($params as $k=>$v)
			  $registro[$k] = $v;
		}
		
        $cajasel = $this->uri->segment(3,"");
		   		
		
		
		
		$arrnumord = ( $this->db->query('select * from numerosordenes where id=1'));
        $numordenes = ($arrnumord->result_array());
		
		$registro['caja']=$cajasel;		
		$registro["num_orden"] = $numordenes[0]['serie'] . sprintf("%04d",$numordenes[0]['numero_orden']) ;
        $registro["tipos"] = $tip;
		$registro["cajas"] = $caj;
		$registro["titulo"] = "Recibir equipo"; 
		$registro["fecha_recibido"] = "";
		$registro["hora_recibido"] = "";
//		$registro["correo_electronico"] = $correo_electronico;
		$this->load->view('inicio/top1');
		//$this->load->view('inicio/menuinterior');
		$this->load->view('equipos/agregarequipo',$registro); 
		$this->load->view('inicio/bottom1');
	}
	
	public function agregar() {
       /* $arr = ( $this->db->query('select * from equipos where id=1'));
	    $data = ($arr->result_array()); 
		$registro = $data[0];	*/	
		

		$registro = array(
							 "id"=>"",
							 "num_orden"=>"",
							 "estatus"=>"",
							 "tipo"=>"",
							 "modelo"=>"",
							 "num_serie"=>"",
							 "capacidad"=>"",
							 "software"=>"",
							 "fecha_recibido"=>"",
							 "hora_recibido"=>"",
							 "cliente_id"=>"",
							 "usuario_id"=>"",
							 "tipo_reparacion"=>"",
							 "equipo_en_garantia"=>"",
							 "intentaron_repararlo"=>"",
							 "en_contacto_con_agua_vap"=>"",
							 "descripcion_problema"=>"",
							 "condiciones_recepcion_eq"=>"",
							 "fixkey"=>"",
							 "sucursal"=>""
							 );
		
        $arrt = ( $this->db->query('select * from tipos'));
        $tipos = ($arrt->result_array());		
		
		$tip = array();
		foreach ($tipos as $tipo) {
			$tip[$tipo["tipo"]] = $tipo["descripcion"];
		}			
		
		$arr = ( $this->db->query('select id,nombre from clientes'));
        $clientes = ($arr->result_array());			
		
		$cli = array();
		foreach ($clientes as $cliente) {
			$cli[$cliente["id"]] = $cliente["nombre"];
		}	


		$registro["clientes"] = $cli;
		$registro["tipos"] = $tip;
		$registro["titulo"] = "Agregar orden de equipo"; $this->load->view('inicio/top1');
		//$this->load->view('inicio/menuinterior');
		$this->load->view('equipos/detalleequipo',$registro); $this->load->view('inicio/bottom1');
		
	}
	
	public function modificar() {
		//$this->load->helper('url');
		//echo $this->uri->segment(3); die();
        $arr = ( $this->db->query('select id,nombre from clientes'));
	    $clientes = ($arr->result_array());		
		$cli = array();
		foreach ($clientes as $cliente) {
			$cli[$cliente["id"]] = $cliente["nombre"];
		}

        $arr = ( $this->db->query('select b.id,b.estatus,b.fecha,b.hora,b.descripcion,b.fecha_adicional,b.usuario_id,b.equipo_id,u.usuario,b.mensaje_para_fecha_adicional from bitacoras b inner join usuarios u on b.usuario_id=u.id where b.equipo_id=' . $this->uri->segment(3) . ' order by b.fecha,b.hora,b.id') );
	    $bitacoras = ($arr->result_array());
		
        $arr = ( $this->db->query('select * from piezas where equipo_id=' . $this->uri->segment(3)));
	    $piezas = ($arr->result_array());
		
		$arr = ( $this->db->query('select * from servicios where equipo_id=' . $this->uri->segment(3)));
	    $servicios = ($arr->result_array());
	
		
        $arr = ( $this->db->query('select * from equipos where id=' . $this->uri->segment(3)));
	    $data = ($arr->result_array());
		
        $arrt = ( $this->db->query('select * from tipos'));
        $tipos = ($arrt->result_array());		
		
		
        $sqc  = "SELECT comunicaciones.id,comunicaciones.fecha,comunicaciones.usuario_id,comunicaciones.asunto,";
        $sqc .= "comunicaciones.notas,usuarios.usuario ";
        $sqc .= "FROM comunicaciones INNER JOIN usuarios ON (comunicaciones.usuario_id = usuarios.id) where equipo_id=" . $this->uri->segment(3);	

        $arrc = $this->db->query($sqc);
        $comunicaciones = ($arrc->result_array());		
		
		
		$tip = array();
		foreach ($tipos as $tipo) {
			$tip[$tipo["tipo"]] = $tipo["descripcion"];
		}
		
		
		$querycajas = "select * from catcajas where (catcajas.id not in " .
		"(select catcajas.id from catcajas inner join equipos on catcajas.id=equipos.caja_id)) ";
        if ($data[0]['caja_id']!="")
            $querycajas .= " or (catcajas.id=" . $data[0]['caja_id'] . ") ";
		$querycajas .= " order by catcajas.descripcion ";

        //$arrc = ( $this->db->query('select * from catcajas order by descripcion'));
        $arrc = ( $this->db->query($querycajas));

        $cajas = ($arrc->result_array());		
		
		$caj = array(""=>"");
		foreach ($cajas as $caja) {
			$caj[$caja["id"]] = $caja["descripcion"];
		}	
		
		$registro = array();
		$registro = $data[0];
		$registro["cajas"] = $caj;
		$registro["clientes"] = $cli;		
		$registro["bitacoras"] = $bitacoras;
		$registro["piezas"] = $piezas;
		$registro["servicios"] = $servicios;
		$registro["tipos"] = $tip;
		$registro['comunicaciones'] = $comunicaciones;
		$registro["titulo"] = "Orden de equipo";
		
		//print_r($registro); die();		
		$this->load->view('inicio/top1');
		//$this->load->view('inicio/menuinterior');
		$this->load->view('equipos/detalleequipo',$registro); 
		$this->load->view('inicio/bottom1');
		
	}


    public function validar() {
        $this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');

		$this->form_validation->set_rules('descripcion_problema', 'Descripcion', 'required');
		$this->form_validation->set_rules('condiciones_recepcion_eq', 'Condiciones...', 'required');
		//$this->form_validation->set_rules('password', 'Password', 'required');
		//$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');
		//$this->form_validation->set_rules('email', 'Email', 'required');

		if ($this->form_validation->run()==FALSE)
		{   
			$this->recibir($_POST);
		}
		else
		{
			$this->guardar($_POST);			
		}		
	
    }	
	
	
  
	
	
	public function guardar($param='') {
		//$this->load->view('agregarcliente');
		
		//$_POST['id'] = $this->db->insert_id() + 1;   //print_r($_POST); die();
		if ($param!='')
		    $_POST = $param;
		
			
		unset($_POST['submit']);
		$accion = $_POST['accion'];
        unset($_POST['accion']);
		//unset($_POST['nombrecliente']);
		unset($_POST['name']);
		
		if (isset($_POST['imprimir'])) {
		   $imprimir = $_POST['imprimir'];
		     unset($_POST['imprimir']);
		}
		
		
		if ($_POST['cliente_id']=="") {
			$arrcli = array('nombre' => $_POST['nombrecliente'],
			                'telefono1' => $_POST['telefono1a'] . "-" . $_POST['telefono1b'] . "-" . $_POST['telefono1c'],
			                'telefono2' => $_POST['telefono2a'] . "-" . $_POST['telefono2b'] . "-" . $_POST['telefono2c'],			              
			                'correo_electronico' => $_POST['correo_electronico']
							);
			$this->db->insert('clientes',$arrcli);
			$_POST['cliente_id'] = $this->db->insert_id();
			
		}
		
		    unset($_POST['nombrecliente']);
			unset($_POST['telefono1a']);
			unset($_POST['telefono1b']);
			unset($_POST['telefono1c']);
			unset($_POST['telefono2a']);
			unset($_POST['telefono2b']);
			unset($_POST['telefono2c']);
			unset($_POST['correo_electronico']);
		
	    // obtener la CLASE del TIPO del equipo
        $arrt = ( $this->db->query("select modelo,clase from tipos where tipo='" . $_POST['tipo'] . "'"));
        $clasetipo = ($arrt->result_array());
		$clase = $clasetipo[0];
		$_POST['clase'] = $clase['clase'];
		$_POST['modelo'] = $clase['modelo'];
		
		
        $ud = $this->session->all_userdata();
		$_POST['usuario_id'] = $ud['usuario_id'];		
		
		if ($accion=="i") {
		   $_POST['situacion'] = "A";	 
		   $this->db->insert('equipos',$_POST);
		   $ultimo_eq_id = $this->db->insert_id();
		   // AGREGAR 'RECIBIDO' A LA BITACORA
		    $bit = array("estatus_id" => 1,
		                "estatus" => "Recibido",
						"fecha" => date("Y-m-d"),
						"hora" => date("H:i:s"),
						"equipo_id"=> $ultimo_eq_id,
						"usuario_id" => $this->session->userdata('usuario_id'),
						"mensaje_para_fecha_adicional" => "Fecha límite para diagnosticar",
						"fecha_adicional" =>  date("Y-m-d")
						);	
		   $this->db->insert('bitacoras',$bit);
			$this->db->where('id',$ultimo_eq_id);
			$e = array("estatus"=>"Recibido","estatus_id"=>1);
			$this->db->update('equipos',$e);				 	
			
			// REGISTRO DE ACCIONES
			$registroacc = array(
			                 "usuario" => $this->session->userdata('usuario'),
			                 "usuario_id" => $this->session->userdata('usuario_id'),
			                 "fecha_hora" => date ("Y-m-d H:i:s"),
			                 "accion"  => "NUEVO",
			                 "tabla"   => "equipos",
			                 "detalle" => $_POST['num_orden']);
		   $this->db->insert('registroacciones',$registroacc);
							 
			
			// FIN REGISTRO DE ACCIONES

		  /* cancelado por el momento 
		   $bitacora = array("fecha" => $_POST['fecha_recibido'],"hora"=>$_POST['hora_recibido'],
																				 "equipo_id"=>$ultimo_eq_id,
																				 "descripcion"=>"Recibido"
																				);
		   $this->db->insert('bitacoras',$bitacora);
		   */
		   // AGREGAR UNO A LA TABLA NUMEROSORDENES
         $arrnumord = ( $this->db->query('select * from numerosordenes where id=1'));
         $numordenes = ($arrnumord->result_array());		
		 $signumorden = $numordenes[0]['numero_orden'] + 1;		   
		 $p = array("numero_orden"=>$signumorden);  
		 $this->db->where('id', 1);
		 $this->db->update('numerosordenes', $p);
		 if ($imprimir!="S")  
		   redirect('/equipos/modificar/' . $ultimo_eq_id);
         else {
          // SE MOVIO EL AGREGAR LA BITACORA DE AQUI HACIA ARRIBA PARA QUE
          // SE APLIQUE SIEMPRE
           //redirect('/equipos/ordenpdf/' . $ultimo_eq_id);
           redirect('/equipos/modificar/' . $ultimo_eq_id . "/imprimir");
			 }
         
		}
		else {
	     unset($_POST['nombrecliente']);
	     $this->db->where('id', $_POST["id"]);
		 $this->db->update('equipos', $_POST);
		 
			// REGISTRO DE ACCIONES
			$registroacc = array(
			                 "usuario" => $this->session->userdata('usuario'),
			                 "usuario_id" => $this->session->userdata('usuario_id'),
			                 "fecha_hora" => date ("Y-m-d H:i:s"),
			                 "accion"  => "MODIFICACION",
			                 "tabla"   => "equipos",
			                 "detalle" => $_POST['num_orden']);
		   $this->db->insert('registroacciones',$registroacc);
		   					 		 
		 
		   redirect('/equipos/modificar/' . $_POST["id"]); 
		}
		// PARA ACTUALIZAR: $this->db->update('mytable', $data); 
		
	}	

public function cancelarorden() {
   $this->db->query("update equipos set situacion='X',fecha_cancelado=NOW() where id='" . $this->uri->segment(3) . "'");

   	    $this->load->view('inicio/top1');
		$r = array("mensaje"=>"La orden ha sido cancelada.",
		           "url" => "/index.php/equipos/index");
		$this->load->view('comun/mensaje',$r); 
		$this->load->view('inicio/bottom1');
   	
}

public function eliminar() {
$qry1 = "select * from equipos where id=" . $this->uri->segment(3);
		$arr1 = ( $this->db->query($qry1));
		$res1 = ($arr1->result_array());
		$eq = $res1[0];
			//print_r($eq); die(); 
			
			//echo $this->uri->segment(4); die();


  if ((($this->session->userdata('nivel')==1)) &&  ($this->uri->segment(4)==$eq['num_orden'])) {
  	//echo "aaa"; die(); 	
     	$this->db->query("delete from equipos where id='" . $this->uri->segment(3) . "'");
     	$this->db->query("delete from bitacoras where equipo_id='" . $this->uri->segment(3) . "'");
		$this->db->query("delete from piezas where equipo_id='" . $this->uri->segment(3) . "'");
		$this->db->query("delete from servicios where equipo_id='" . $this->uri->segment(3) . "'");
           // REGISTRO DE ACCIONES
			$registroacc = array(
			                 "usuario" => $this->session->userdata('usuario'),
			                 "usuario_id" => $this->session->userdata('usuario_id'),
			                 "fecha_hora" => date ("Y-m-d H:i:s"),
			                 "accion"  => "ELIMINADO",
			                 "tabla"   => "equipos",
			                 "detalle" => "ID: " . $this->uri->segment(3));
		   $this->db->insert('registroacciones',$registroacc);		 
		 
		 redirect('/equipos/index'); 
     }
}
	


   public function entregar() {
   	// ESTA FUNCION SE EJECUTA DENTRO DEL IFRAME DONDE SALEN LAS BITACORAS
		$cli = array(
		             "nombre" => $_POST['nombre'],
		             "telefono1" => $_POST['telefono1'],
		             "telefono2" => $_POST['telefono2'],
		             "direccion" => $_POST['direccion'],
		             "correo_electronico" => $_POST['correo_electronico']
		 );
		 $this->db->where('id', $_POST['cliente_id']);
		 $this->db->update('clientes',$cli);
		 
		//$equipo_id = $_POST["equipo_id"];
		    unset($_POST['cliente_id']);
			unset($_POST['nombre']);
			unset($_POST['telefono1']);
			unset($_POST['telefono2']);
			unset($_POST['direccion']);
			unset($_POST['correo_electronico']);
			unset($_POST['submit']);

   	    $this->db->where('id', $_POST["equipo_id"]);
   	    			unset($_POST['equipo_id']);
		
		 $this->db->update('equipos', $_POST);
		  $this->load->view('inicio/top_single1');
		   $this->load->view('comun/cerrartop');
		    $this->load->view('inicio/bottom_single1');
		   //redirect('/equipos/modificar/' . $_POST["equipo_id"]);
   }	
	
	// REPORTES DE PROCESO
	public function reportecalendarioentregas() {
		$this->load->library('pagination');

        $qry1 = "select id from estados where estatus_de_entrega='S'";
		$arr1 = ( $this->db->query($qry1));
		$res1 = ($arr1->result_array());
		$es   = "";
		foreach ($res1 as $k) {
			$es .= $k['id'] . ",";
		}
		 $es .= "-1";
		

        $qry = "select equipos.num_orden, equipos.id,equipos.estatus,equipos.tipo,equipos.modelo,equipos.num_serie,equipos.capacidad,equipos.software," .
		" equipos.fecha_recibido,equipos.hora_recibido,equipos.cliente_id,clientes.nombre,bitacoras.fecha,bitacoras.hora,bitacoras.descripcion" .
		" from equipos inner join clientes on equipos.cliente_id=clientes.id " .
		" inner join bitacoras on equipos.estatus_id=bitacoras.estatus_id  and equipos.id=bitacoras.equipo_id where equipos.estatus_id in (" . $es . ") order by bitacoras.fecha,bitacoras.hora";
		//echo $queryprincipal;
		$lim = $this->uri->segment(3,'0');
		$arr = ( $this->db->query($qry));
	    $data['result'] = ($arr->result_array());
		$data['titulo'] = "Calendario de entregas";
		$data['urlregresar'] = "/index.php/inicio/proceso";
		 $this->load->view('inicio/top1'); 
        // $this->load->view('inicio/menuinterior');
		
		 $this->load->view('equipos/reporte1',$data); 
		 $this->load->view('inicio/bottom1'); 		
	
	}
	
	
    public function procesocalendario(){
			// PRIMERO ELIMINAR LOS REGISTROS
		
		$this->db->query("delete from reportecalendario");
		
		$qry1 = "select id from estados where estatus_de_entrega='S'";
		$arr1 = ( $this->db->query($qry1));
		$res1 = ($arr1->result_array());
		$es   = "";
		foreach ($res1 as $k) {
			$es .= $k['id'] . ",";
		}
		 $es .= "-1";
		
        // echo $es; die();
        $qry = "select ";
        $qry .= "equipos.num_orden,";
        $qry .= "equipos.id as equipo_id,";
        $qry .= "equipos.estatus,";
        $qry .= "equipos.tipo,";
       // $qry .= "equipos.situacion,";
       // $qry .= "equipos.fecha_de_entrega,";
        //$qry .= "equipos.capacidad,";
        //$qry .= "equipos.software,";
		//$qry .= "equipos.fecha_recibido,";
		//$qry .= "equipos.hora_recibido,";
		$qry .= "equipos.cliente_id,";
		$qry .= "clientes.id as cliente_id,";
		$qry .= "clientes.nombre,";
		$qry .= "clientes.telefono1,";
	    $qry .= "clientes.telefono2,";
		$qry .= "clientes.correo_electronico,";
		//$qry .= "bitacoras.fecha,";
		//$qry .= "bitacoras.hora,";
		$qry .= "bitacoras.estatus_id,";
		$qry .= "bitacoras.mensaje_para_fecha_adicional,";
		$qry .= "bitacoras.fecha_adicional ";
		$qry .= "from equipos inner join clientes on equipos.cliente_id=clientes.id ";
		$qry .= " inner join bitacoras on equipos.estatus_id=bitacoras.estatus_id  and equipos.id=bitacoras.equipo_id ";
		$qry1 = $qry . " where equipos.estatus_id in (" . $es . ") order by bitacoras.fecha,bitacoras.hora";
		//echo $queryprincipal;
		$lim = $this->uri->segment(3,'0');
		$arr = ( $this->db->query($qry1));
	    $datos = ($arr->result_array());
				
		foreach ($datos as $datodet) {
			$datodet['recordatorio_de'] = "Entregar";
			$datodet['fecha_hora'] = date ("Y-m-d H:i:s");
		 $this->db->insert('reportecalendario',$datodet);
		}	

		// POR NOTIIFCAR
        $qry1 = "select id from estados where estatus_por_notificar='S'";
		$arr1 = ( $this->db->query($qry1));
		$res1 = ($arr1->result_array());
		$es   = "";
		foreach ($res1 as $k) {
			$es .= $k['id'] . ",";
		}
		 $es .= "-1";		
		
		$qry2 = $qry . " where equipos.estatus_id in (" . $es . ") order by bitacoras.fecha,bitacoras.hora";
		//echo $queryprincipal;
		$lim = $this->uri->segment(3,'0');
		$arr = ( $this->db->query($qry2));
	    $datos = ($arr->result_array());
				
		foreach ($datos as $datodet) {
			$datodet['recordatorio_de'] = "Notificar";
			$datodet['fecha_hora'] = date ("Y-m-d H:i:s");
		 $this->db->insert('reportecalendario',$datodet);
		}		
		
		
		// POR DIAGNOSTICAR
        $qry1 = "select id from estados where estatus_por_diagnosticar='S'";
		$arr1 = ( $this->db->query($qry1));
		$res1 = ($arr1->result_array());
		$es   = "";
		foreach ($res1 as $k) {
			$es .= $k['id'] . ",";
		}
		 $es .= "-1";		
		
		$qry2 = $qry . " where equipos.estatus_id in (" . $es . ") order by bitacoras.fecha,bitacoras.hora";
		//echo $queryprincipal;
		$lim = $this->uri->segment(3,'0');
		$arr = ( $this->db->query($qry2));
	    $datos = ($arr->result_array());
				
		foreach ($datos as $datodet) {
			$datodet['recordatorio_de'] = "Diagnosticar";
			$datodet['fecha_hora'] = date ("Y-m-d H:i:s");
		 $this->db->insert('reportecalendario',$datodet);
		}		
		
		
		// POR REPARAR
        $qry1 = "select id from estados where estatus_por_reparar='S'";
		$arr1 = ( $this->db->query($qry1));
		$res1 = ($arr1->result_array());
		$es   = "";
		foreach ($res1 as $k) {
			$es .= $k['id'] . ",";
		}
		 $es .= "-1";		
		
		$qry2 = $qry . " where equipos.estatus_id in (" . $es . ") order by bitacoras.fecha,bitacoras.hora";
		//echo $queryprincipal;
		$lim = $this->uri->segment(3,'0');
		$arr = ( $this->db->query($qry2));
	    $datos = ($arr->result_array());
				
		foreach ($datos as $datodet) {
			$datodet['recordatorio_de'] = "Reparar";
			$datodet['fecha_hora'] = date ("Y-m-d H:i:s");
		 $this->db->insert('reportecalendario',$datodet);
		}	
		
		
		
		// EN ESPERA
        $qry1 = "select id from estados where estatus_en_espera='S'";
		$arr1 = ( $this->db->query($qry1));
		$res1 = ($arr1->result_array());
		$es   = "";
		foreach ($res1 as $k) {
			$es .= $k['id'] . ",";
		}
		 $es .= "-1";		
		
		$qry2 = $qry . " where equipos.estatus_id in (" . $es . ") order by bitacoras.fecha,bitacoras.hora";
		//echo $queryprincipal;
		$lim = $this->uri->segment(3,'0');
		$arr = ( $this->db->query($qry2));
	    $datos = ($arr->result_array());
				
		foreach ($datos as $datodet) {
			$datodet['recordatorio_de'] = "En espera";
			$datodet['fecha_hora'] = date ("Y-m-d H:i:s");
		 $this->db->insert('reportecalendario',$datodet);
		}	
		
		// FECHAS DE ENTREGA TENTATIVA
		$qryfet  = "select equipos.num_orden,equipos.id as equipo_id,equipos.estatus,equipos.tipo,";
        $qryfet .= "equipos.fecha_de_entrega as fecha_adicional,equipos.cliente_id,clientes.id as cliente_id,clientes.nombre,clientes.telefono1,";
        $qryfet .= "clientes.telefono2,clientes.correo_electronico,bitacoras.estatus_id ";
        $qryfet .= "from equipos inner join clientes on equipos.cliente_id=clientes.id ";
        $qryfet .= "inner join bitacoras on equipos.estatus_id=bitacoras.estatus_id  and equipos.id=bitacoras.equipo_id "; 
		$qryfet .= "where equipos.situacion='A'";
		
	//	$qry2 = $qry . " where equipos.situacion='A'";
		
        $arr = ( $this->db->query($qryfet));
	    $datos = ($arr->result_array());
				
		foreach ($datos as $datodet) {
			$datodet['recordatorio_de'] = "Entrega Tentativa";
			$datodet['fecha_hora'] = date ("Y-m-d H:i:s");
			$datodet['mensaje_para_fecha_adicional'] = 'Entrega tentativa programada';
		 $this->db->insert('reportecalendario',$datodet);
		}		
		
			
			
    }
    	
    
    function x_week_range(&$start_date, &$end_date, $date) {
        $ts = strtotime($date);
        $start = (date('w', $ts) == 0) ? $ts : strtotime('last sunday', $ts);
        $start_date = date('Y-m-d', $start);
        $end_date = date('Y-m-d', strtotime('next saturday', $start)); 
    }
        
    
	
	
	public function reportecalendario() {
		
		$this->procesocalendario();
		$this->load->library('pagination');	
		
	    $this->x_week_range($sd,$ed,date("Y-m-d"));
	    //echo $sd . " = " . $ed;
	
		$qry = "select ";
		$qry .= "id,fecha_hora,equipo_id,tipo,recordatorio_de,mensaje_para_fecha_adicional,";
		$qry .= "fecha_adicional,DATEDIFF(CURRENT_DATE,fecha_adicional) as dias_vencidos,num_orden,";
		$qry .= "estatus_id,estatus,cliente_id,nombre,telefono1,telefono2,correo_electronico ";
		$qry .= "from reportecalendario where fecha_adicional>='" . $sd . "' and fecha_adicional<='" . $ed . "' order by fecha_adicional";
			
        $arr = ( $this->db->query($qry));
	    $data['result'] = ($arr->result_array());
		$data['titulo'] = "Calendario de operaciones";
		$data['urlregresar'] = "/index.php/inicio/proceso";
		$data['fechainicio'] = $this->_cambiaf_a_normal($sd);
		$data['fechatermino'] = $this->_cambiaf_a_normal($ed);	
		
		 $this->load->view('inicio/top1'); 
       //  $this->load->view('inicio/menuinterior');
		 $this->load->view('equipos/reporte1',$data); 
		 $this->load->view('inicio/bottom1'); 		
		
		//print_r($data);
		//echo "Listo"; 
	}


	
		public function reporteordenespendientesnotificar() {
		$this->load->library('pagination');

        $qry1 = "select id from estados where estatus_por_notificar='S'";
		$arr1 = ( $this->db->query($qry1));
		$res1 = ($arr1->result_array());
		$es   = "";
		foreach ($res1 as $k) {
			$es .= $k['id'] . ",";
		}
		 $es .= "-1";
		

        $qry = "select equipos.num_orden, equipos.id,equipos.estatus,equipos.tipo,equipos.modelo,equipos.num_serie,equipos.capacidad,equipos.software," .
		" equipos.fecha_recibido,equipos.hora_recibido,equipos.cliente_id,clientes.nombre,bitacoras.fecha,bitacoras.hora,bitacoras.descripcion" .
		" from equipos inner join clientes on equipos.cliente_id=clientes.id " .
		" inner join bitacoras on equipos.estatus_id=bitacoras.estatus_id and equipos.id=bitacoras.equipo_id where equipos.estatus_id in (" . $es . ") order by bitacoras.fecha,bitacoras.hora";
		
		$lim = $this->uri->segment(3,'0');
		$arr = ( $this->db->query($qry));
	    $data['result'] = ($arr->result_array());
		$data['titulo'] = "&Oacute;rdenes pendientes de notificaci&oacute;n";
		$data['urlregresar'] = "/index.php/inicio/proceso";
		 $this->load->view('inicio/top1'); 
        // $this->load->view('inicio/menuinterior');
		
		 $this->load->view('equipos/reporte1',$data); 
		 $this->load->view('inicio/bottom1'); 		
		 
	
	}
	
		public function reporteequiposenabandono() {
		$this->load->library('pagination');

        $qry1 = "select id from estados where estatus_de_entrega='S'";
		$arr1 = ( $this->db->query($qry1));
		$res1 = ($arr1->result_array());
		$es   = "";
		foreach ($res1 as $k) {
			$es .= $k['id'] . ",";
		}
		 $es .= "-1";
		

        $qry = "select DATEDIFF(CURRENT_DATE,bitacoras.fecha),equipos.num_orden, equipos.id,equipos.estatus,equipos.tipo,equipos.modelo,equipos.num_serie,equipos.capacidad,equipos.software," .
		" equipos.fecha_recibido,equipos.hora_recibido,equipos.cliente_id,clientes.nombre,bitacoras.fecha,bitacoras.hora,bitacoras.descripcion" .
		" from equipos inner join clientes on equipos.cliente_id=clientes.id " .
		" inner join bitacoras on equipos.estatus_id=bitacoras.estatus_id and equipos.id=bitacoras.equipo_id where equipos.estatus_id in (" . $es . ")  and DATEDIFF(CURRENT_DATE,bitacoras.fecha)>30 order by bitacoras.fecha,bitacoras.hora";
		
		$lim = $this->uri->segment(3,'0');
		$arr = ( $this->db->query($qry));
	    $data['result'] = ($arr->result_array());
		$data['titulo'] = "Equipos en abandono";
		$data['urlregresar'] = "/index.php/inicio/proceso";
		 $this->load->view('inicio/top1'); 
        // $this->load->view('inicio/menuinterior');
		
		 $this->load->view('equipos/reporte1',$data); 
		 $this->load->view('inicio/bottom1'); 		
	
	}	
	
	
function cambiarnumorden() {
	 if ($this->session->userdata('nivel')==1) {
        $qry1 = "select * from numerosordenes where id=1";
		$arr1 = ( $this->db->query($qry1));
		$res1 = ($arr1->result_array());
		$numordenes=$res1[0];
		
		//print_r($numordenes); die();
         $this->load->view('inicio/top1'); 
        // $this->load->view('inicio/menuinterior');
		
		 $this->load->view('equipos/cambiarnumorden',$numordenes); 
		 $this->load->view('inicio/bottom1'); 			
		
	}
}	

function guardarnumorden() {
	 if ($this->session->userdata('nivel')==1) {
        $qry1 = "update  numerosordenes set serie='" . $_POST['serie'] . 
                 "', numero_orden=" . $_POST['numero_orden'] . " where id=1";
		$arr1 = ( $this->db->query($qry1));
		
		redirect('/inicio/administracion'); 
		
	}
}
	
	
function createpdf()
    {
    $this->load->helper('dompdf');

	$html =  $this->load->view('inicio/top1'); 
    //$html .=     $this->load->view('inicio/menuinterior');
	$html .= "<table border=1 width=80%><tr><td>Uno</td><td>Dos</td></tr></table>";	
	//$html .=	 $this->load->view('equipos/reporte1',$data); 
	$html .=	 $this->load->view('inicio/bottom1'); 	
    //$html = "<html><body>aaa</body></html>";
    pdf_create($html, 'somefilename');
    } 	


public function ordenpdf() {
   	$this->load->library('Pdf');


$ddx = 0; $ddy = 0; $mostrarcirculos = 0;

$pagina = "http://sistema.hospitaldeipods.mx/index.php/equipos/localizarqrcaja/" . $this->uri->segment(3);
$this->load->library('qrcode_library');


$pdf = new Pdf('P', 'mm', 'LEGAL', true, 'UTF-8', false);
$pdf->SetTitle('My Title');
//$pdf->SetHeaderMargin(30);
//$pdf->SetTopMargin(20);
//$pdf->setFooterMargin(20);
//$pdf->SetAutoPageBreak(true);
$pdf->SetAuthor('Author');
$pdf->SetDisplayMode('real', 'default');
$pdf->AddPage();


$codigoqr =  $this->qrcode_library->make_qrcode($pagina, $errorCorrectionLevel= '', $matrixPointSize='');
// EL DE ARRIBA
$pdf->Image(dirname(__FILE__) . '/../..' . $codigoqr, 180 + $ddx, 215 + $ddy, 25, 25, 'PNG', '', '', true, 150, '', false, false, 0, false, false, false);
// EL DE ABAJO
$pdf->Image(dirname(__FILE__) . '/../..' . $codigoqr, 180 + $ddx, 293 + $ddy, 25, 25, 'PNG', '', '', true, 150, '', false, false, 0, false, false, false);

//$pdf->Image(dirname(__FILE__) . '/../libraries/imagenes/escaneado.jpg', 0, 0, 800, 1000, 'JPG', '', '', true, 150, '', false, false, 0, false, false, false);
//$pdf->Image($file)
//$pdf->writeHTMLCell(200, 100, 100, 100,"HOLA");
//$pdf->writeHTML("ABCDEFG");
        $arr = ( $this->db->query('select * from equipos where id=' . $this->uri->segment(3)));
	    $data = ($arr->result_array());

        $equipo = $data[0];
		
        $arr = ( $this->db->query('select * from clientes where id=' . $equipo['cliente_id']));
	    $clientes = ($arr->result_array());			
	    $cliente = $clientes[0];
		
// Print text using writeHTMLCell()
$pdf->SetFont('Helvetica', '', 10, '', 'false');

$pdf->writeHTMLCell($w=0, $h=0, $x=185 + $ddx, $y=16 + $ddy, $equipo['num_orden'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);


$pdf->writeHTMLCell($w=0, $h=0, $x=174 + $ddx, $y=31 + $ddy,  $this->_cambiaf_a_normal($equipo['fecha_recibido'])  , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);


$pdf->writeHTMLCell($w=0, $h=0, $x=30 + $ddx, $y=31 + $ddy, $cliente['nombre'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMLCell($w=0, $h=0, $x=25 + $ddx, $y=37 + $ddy, $cliente['telefono1'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMLCell($w=0, $h=0, $x=100 + $ddx, $y=37 + $ddy,  $cliente['telefono2'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMLCell($w=0, $h=0, $x=145 + $ddx, $y=37 + $ddy,  $cliente['correo_electronico'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

if ($mostrarcirculos) {
$pdf->Circle (15 + $ddx, 52 + $ddy, 2, 0, 360, '', array(), array(), 2);
$pdf->Circle (75 + $ddx, 52 + $ddy, 2, 0, 360, '', array(), array(), 2);
$pdf->Circle (114 + $ddx, 52 + $ddy, 2, 0, 360, '', array(), array(), 2);
$pdf->Circle (169 + $ddx, 52 + $ddy, 2, 0, 360, '', array(), array(), 2);
$pdf->Circle (15 + $ddx, 58 + $ddy, 2, 0, 360, '', array(), array(), 2);
$pdf->Circle (75 + $ddx, 58 + $ddy, 2, 0, 360, '', array(), array(), 2);
$pdf->Circle (114 + $ddx, 58 + $ddy, 2, 0, 360, '', array(), array(), 2);
$pdf->Circle (169 + $ddx, 58 + $ddy, 2, 0, 360, '', array(), array(), 2);
$pdf->Circle (15 + $ddx, 64 + $ddy, 2, 0, 360, '', array(), array(), 2);
}

switch ($equipo['como_te_enteraste']) {
	case "CORREO ELECTRONICO":
        $pdf->writeHTMLCell($w=0, $h=0, $x=14 + $ddx, $y=51 + $ddy, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);				
		break;
    case "ESPECTACULAR":
        $pdf->writeHTMLCell($w=0, $h=0, $x=74 + $ddx, $y=51 + $ddy, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
		break;
    case "MEDALLON":
        $pdf->writeHTMLCell($w=0, $h=0, $x=124 + $ddx, $y=51 + $ddy, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
    	break;
    case "PUBLICACION":
        $pdf->writeHTMLCell($w=0, $h=0, $x=164 + $ddx, $y=51 + $ddy, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
		break;
    case "RECOMENDACION":
        $pdf->writeHTMLCell($w=0, $h=0, $x=14 + $ddx, $y=57 + $ddy, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);				
        break;
    case "REDES SOCIALES":
        $pdf->writeHTMLCell($w=0, $h=0, $x=74 + $ddx, $y=57 + $ddy, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
    		break;
    case "SITIO WEB":
        $pdf->writeHTMLCell($w=0, $h=0, $x=124 + $ddx, $y=57 + $ddy, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
		break;
    case "VISTE EL LOCAL":
        $pdf->writeHTMLCell($w=0, $h=0, $x=164 + $ddx, $y=57 + $ddy, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
		break;
    case "OTRO NEGOCIO":
        $pdf->writeHTMLCell($w=0, $h=0, $x=74 + $ddx, $y=63 + $ddy, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);				
		break;
				
} 

if ($mostrarcirculos) {
$pdf->Circle (119 + $ddx, 73 + $ddy, 2, 0, 360, '', array(), array(), 2);
$pdf->Circle (143 + $ddx, 73 + $ddy, 2, 0, 360, '', array(), array(), 2);
}

        // PROMOCIONES
     if ($equipo['desea_recibir_promociones']=='S')   
        $pdf->writeHTMLCell($w=0, $h=0, $x=117 + $ddx, $y=71 + $ddy, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
	 else
        $pdf->writeHTMLCell($w=0, $h=0, $x=141 + $ddx, $y=71 + $ddy, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);


//$pdf->writeHTMLCell($w=0, $h=0, $x=20, $y=70, "<b>&iquest;Deseas recibir nuestras promociones en tu correo?</b>  ", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->SetFont('Helvetica', '', 12, '', 'false');
$pdf->writeHTMLCell($w=0, $h=0, $x=70 + $ddx, $y=93 + $ddy, $equipo['tipo'] . "/" . $equipo['modelo'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->SetFont('Helvetica', '', 10, '', 'false');


//$pdf->writeHTMLCell($w=0, $h=0, $x=110, $y=63, $equipo['modelo'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
//$pdf->writeHTMLCell($w=0, $h=0, $x=160, $y=80, "<b>Generaci&oacute;n</b>", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMLCell($w=0, $h=0, $x=75 + $ddx, $y=102 + $ddy, $equipo['num_serie'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMLCell($w=0, $h=0, $x=130 + $ddx, $y=102 + $ddy, $equipo['capacidad'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=0, $h=0, $x=176 + $ddx, $y=93 + $ddy, $equipo['color'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=0, $h=0, $x=176 + $ddx, $y=102 + $ddy, $equipo['operador'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);


if ($mostrarcirculos) {
    $pdf->Circle (176 + $ddx, 115 + $ddy, 2, 0, 360, '', array(), array(), 2);
    $pdf->Circle (194 + $ddx, 115 + $ddy, 2, 0, 360, '', array(), array(), 2);
}

if ($equipo['equipo_en_garantia']=="S")
   $pdf->writeHTMLCell($w=0, $h=0, $x=174 + $ddx, $y=113 + $ddy, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
else
   $pdf->writeHTMLCell($w=0, $h=0, $x=192 + $ddx, $y=113 + $ddy, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

if ($mostrarcirculos) {
    $pdf->Circle (176 + $ddx, 122 + $ddy, 2, 0, 360, '', array(), array(), 2);
    $pdf->Circle (194 + $ddx, 122 + $ddy, 2, 0, 360, '', array(), array(), 2);
}

if ($equipo['intentaron_repararlo']=="S")
   $pdf->writeHTMLCell($w=0, $h=0, $x=174 + $ddx, $y=119 + $ddy, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
else
   $pdf->writeHTMLCell($w=0, $h=0, $x=192 + $ddx, $y=119 + $ddy, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

if ($mostrarcirculos) {
    $pdf->Circle (176 + $ddx, 129 + $ddy, 2, 0, 360, '', array(), array(), 2);
    $pdf->Circle (194 + $ddx, 129 + $ddy, 2, 0, 360, '', array(), array(), 2);
}

if ($equipo['en_contacto_con_agua_vap']=="S")
   $pdf->writeHTMLCell($w=0, $h=0, $x=174 + $ddx, $y=127 + $ddy, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
else
   $pdf->writeHTMLCell($w=0, $h=0, $x=192 + $ddx, $y=127 + $ddy, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

if ($mostrarcirculos) {
    $pdf->Circle (176 + $ddx, 136 + $ddy, 2, 0, 360, '', array(), array(), 2);
    $pdf->Circle (194 + $ddx, 136 + $ddy, 2, 0, 360, '', array(), array(), 2);
}
if ($equipo['iphone_comprado_en_pais']=="S")
   $pdf->writeHTMLCell($w=0, $h=0, $x=174 + $ddx, $y=134 + $ddy, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
else
   $pdf->writeHTMLCell($w=0, $h=0, $x=192 + $ddx, $y=134 + $ddy, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

if ($mostrarcirculos) {
    $pdf->Circle (176 + $ddx, 143 + $ddy, 2, 0, 360, '', array(), array(), 2);
    $pdf->Circle (194 + $ddx, 143 + $ddy, 2, 0, 360, '', array(), array(), 2);
}

if ($equipo['tiene_jailbreak_o_cydia']=="S")
   $pdf->writeHTMLCell($w=0, $h=0, $x=174 + $ddx, $y=141 + $ddy, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
else
   $pdf->writeHTMLCell($w=0, $h=0, $x=192 + $ddx, $y=141 + $ddy, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
   
   //------------------------------

$pdf->writeHTMLCell($w=188, $h=17, $x=13 + $ddx, $y=155 + $ddy, $equipo['descripcion_problema'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=86, $h=22, $x=13 + $ddx, $y=180 + $ddy, $equipo['condiciones_recepcion_eq'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->SetFont('Helvetica', '', 12, '', 'false');


$pdf->SetFont('Helvetica', '', 17, '', 'false');
/*
if ($equipo['calificacion_servicio']>0)
     $pdf->writeHTMLCell($w=0, $h=0, $x=137, $y=158, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
if ($equipo['calificacion_servicio']>2)
     $pdf->writeHTMLCell($w=0, $h=0, $x=146, $y=158, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
if ($equipo['calificacion_servicio']>4)
     $pdf->writeHTMLCell($w=0, $h=0, $x=155, $y=158, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
if ($equipo['calificacion_servicio']>6)
     $pdf->writeHTMLCell($w=0, $h=0, $x=164, $y=158, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
if ($equipo['calificacion_servicio']>8)
     $pdf->writeHTMLCell($w=0, $h=0, $x=173, $y=158, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->SetFont('Helvetica', '', 10, '', 'false');
*/
$pdf->SetFont('Helvetica', '', 8, '', 'false');
$pdf->writeHTMLCell($w=175, $h=14, $x=20 + $ddx, $y=250 + $ddy, $equipo['notas'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

// ------------------------------------------------
$pdf->SetFont('Helvetica', '', 8, '', 'false');
$pdf->writeHTMLCell($w=0, $h=0, $x=185 + $ddx, $y=286 + $ddy, $equipo['num_orden'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMLCell($w=0, $h=0, $x=35 + $ddx, $y=289 + $ddy, $equipo['tipo'] , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMLCell($w=0, $h=0, $x=120 + $ddx, $y=289 + $ddy, $equipo['num_serie'] , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMLCell($w=0, $h=0, $x=50 + $ddx, $y=297 + $ddy,  $this->_cambiaf_a_normal($equipo['fecha_recibido'])  , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMLCell($w=0, $h=0, $x=130 + $ddx, $y=297 + $ddy, $this->_cambiaf_a_normal($equipo['fecha_de_entrega'])  , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMLCell($w=165, $h=10, $x=35 + $ddx, $y=303 + $ddy, substr($equipo['descripcion_problema'],0,250), $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMLCell($w=165, $h=10, $x=35 + $ddx, $y=312 + $ddy, $equipo['notas'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

// !------
$pdf->Output('Orden-' . $equipo['num_orden'] . '.pdf', 'I'); 
   }	


public function otropdf() {
	
	ini_set("memory_limit","64M");
 	$this->load->library('Pdf');
$ddx = 0; $ddy = 0; $mostrarcirculos = 0;

$pdf = new Pdf('P', 'mm', 'BE_RUCHE', true, 'UTF-8', false,false);
$pdf->SetTitle('Nota de venta');
$pdf->Output('Otro.pdf', 'I'); 
}

public function notadeventa() {
	
	ini_set("memory_limit","64M");
 	$this->load->library('Pdf');
$ddx = 0; $ddy = 0; $mostrarcirculos = 0;

$pdf = new Pdf('P', 'mm', 'LETTER', true, 'UTF-8', false,false);
$pdf->SetTitle('Nota de venta');
//$pdf->SetHeaderMargin(30);
//$pdf->SetTopMargin(20);
//$pdf->setFooterMargin(20);
//$pdf->SetAutoPageBreak(true);
$pdf->SetAuthor('iDoctor');
$pdf->SetDisplayMode('real', 'default');
$pdf->AddPage();

//echo dirname(__FILE__) . '/../../../images/nota_venta_xa1.jpg'; die();

$pdf->Image(dirname(__FILE__) . '/../../images/nota_venta_xa1.png' , 10 + $ddx, 10 + $ddy, 200, 140, 'PNG', '', '', true, 150, '', false, false, 0, false, false, false);


    $arr = ( $this->db->query('select * from equipos where id=' . $this->uri->segment(3)));
	    $data = ($arr->result_array());

        $equipo = $data[0];
		
        $arr = ( $this->db->query('select * from clientes where id=' . $equipo['cliente_id']));
	    $clientes = ($arr->result_array());			
	    $cliente = $clientes[0];
		
// Print text using writeHTMLCell()
$pdf->SetFont('Helvetica', '', 10, '', 'false');

$pdf->writeHTMLCell($w=0, $h=0, $x=185 + $ddx, $y=16 + $ddy, $equipo['num_orden'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMLCell($w=0, $h=0, $x=35 + $ddx, $y=31 + $ddy, $equipo['num_orden'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=0, $h=0, $x=35 + $ddx, $y=39 + $ddy, $cliente['nombre'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMLCell($w=0, $h=0, $x=35 + $ddx, $y=47 + $ddy, $cliente['direccion'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=0, $h=0, $x=150 + $ddx, $y=47 + $ddy, $cliente['telefono1'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=0, $h=0, $x=135 + $ddx, $y=39 + $ddy, $cliente['correo_electronico'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);


// COnseguir la fecha de entrega
 $arrf = ( $this->db->query("select * from bitacoras where estatus='Entregado' and  equipo_id=" . $this->uri->segment(3)));
 if ($arrf->num_rows()>0) {
	    $serviciosf = ($arrf->result_array());
		$fecha = $this->_cambiaf_a_normal($serviciosf[0]['fecha']);
 }
 else $fecha = "";
//



$pdf->writeHTMLCell($w=0, $h=0, $x=174 + $ddx, $y=31 + $ddy,  $fecha  , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);



 $arr = ( $this->db->query('select * from servicios where equipo_id=' . $this->uri->segment(3)));
	    $servicios = ($arr->result_array());

 $linea = 0;
 $total = 0;
 foreach ($servicios as $servicio) {
      $pdf->writeHTMLCell($w=0, $h=0, $x=16 + $ddx, $y=80 + $ddy + $linea,"1", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
	 
      $pdf->writeHTMLCell($w=0, $h=0, $x=40 + $ddx, $y=80 + $ddy + $linea, $servicio['descripcion'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
       $pdf->writeHTMLCell($w=0, $h=0, $x=150 + $ddx, $y=80 + $ddy + $linea, "$" . number_format($servicio['subtotal'], 2, '.', ','), $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

       $pdf->writeHTMLCell($w=0, $h=0, $x=185 + $ddx, $y=80 + $ddy + $linea, "$" . number_format($servicio['subtotal'], 2, '.', ','), $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

	 $linea = $linea + 5; 
	 $total += $servicio['subtotal'];
 }
 
       $pdf->writeHTMLCell($w=0, $h=0, $x=185 + $ddx, $y=127 + $ddy , "$" . number_format($total, 2, '.', ','), $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
 

// !------
$pdf->Output('Nota de venta.pdf', 'I'); 
   }	
   
   
public function garantia() {
	
	ini_set("memory_limit","64M");
 	$this->load->library('Pdf');
$ddx = 0; $ddy = 0; $mostrarcirculos = 0;

$pdf = new Pdf('P', 'mm', 'LETTER', true, 'UTF-8', false);
$pdf->SetTitle('Nota de venta');
//$pdf->SetHeaderMargin(30);
//$pdf->SetTopMargin(20);
//$pdf->setFooterMargin(20);
//$pdf->SetAutoPageBreak(true);
$pdf->SetAuthor('iDoctor');
$pdf->SetDisplayMode('real', 'default');
$pdf->AddPage();

//echo dirname(__FILE__) . '/../../../images/nota_venta_xa1.jpg'; die();

$pdf->Image(dirname(__FILE__) . '/../../images/garantia.png' , 10 + $ddx, 10 + $ddy, 190, 125, 'PNG', '', '', true, 150, '', false, false, 0, false, false, false);

$pdf->Output('Garantia.pdf', 'I'); 
   }	


   
public function calendario() {
			
		
	    $this->procesocalendario();
					
		$qry = "SELECT DAY(fecha_adicional) as dia,num_orden,recordatorio_de," .
               "mensaje_para_fecha_adicional,fecha_adicional,equipo_id " .
               " FROM reportecalendario WHERE YEAR(fecha_adicional) = " . $this->uri->segment(3,date('Y')) .
               " AND MONTH(fecha_adicional) = " . $this->uri->segment(4,date('n'));
			   //echo $qry;die();
			   
	    $arr = ( $this->db->query($qry));
	    $result = ($arr->result_array());
		$result2 = array();	
		foreach ($result as $k=>$v) {
			  $result2[$v['dia']] = $v;
		  }
		
		//print_r($result); die();
	
		 $this->load->view('inicio/top1'); 
         //$this->load->view('inicio/menuinterior');
		 $d = getDate();
		 $d['year'] = $this->uri->segment(3,date('Y'));
		 $d['mon']  = $this->uri->segment(4,date('n'));
		 $data['calendario'] = $this->calendar($d,$result);
		 
		 $data['urlregresar'] = '/index.php/inicio/proceso';
		 $data['titulo'] = 'Calendario';
		 $this->load->view('equipos/calendario',$data); 
		 $this->load->view('inicio/bottom1'); 	
}


public function calendar($date,$dias)
         {
         //If no parameter is passed use the current date.
         if($date == null)
            $date = getDate();

         $day = $date["mday"];
         $month = $date["mon"];
		 $meses = array(1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',
		                7=>'Julio',8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre');
         $month_name = $meses[$date['mon']];
         $year = $date["year"];

         $this_month = getDate(mktime(0, 0, 0, $month, 1, $year));
         $next_month = getDate(mktime(0, 0, 0, $month + 1, 1, $year));

         //Find out when this month starts and ends.
         $first_week_day = $this_month["wday"];
         $days_in_this_month = round(($next_month[0] - $this_month[0]) / (60 * 60 * 24));

         $calendar_html = "<table class='calendarioeventos'>";

         if ($month==1) {
         	$anioant = $year - 1;
			$mesant  = 12;
			$aniosig = $year;
			$messig  = 2;
         }
		 else if ($month==12) {
         	$anioant = $year;
			$mesant  = 11;
			$aniosig = $year + 1;
			$messig  = 1;		 	
		 }
		 else {
         	$anioant = $year;
			$mesant  = $month - 1;
			$aniosig = $year;
			$messig  = $month + 1;		 	
		 }
		 
//print_r( $this_month);

         $calendar_html .= "<tr>";
		 $calendar_html .= "<td align=center><a href='/index.php/equipos/calendario/" . 
		                    $anioant . "/" . $mesant . "'>[Anterior]</a></td>";
         $calendar_html .= "<td colspan=\"5\" align=\"center\" style=\"background-color:9999cc; color:000000;font-size:1.6em;\">" .
                           $month_name . " " . $year;
		 $calendar_html .= "<td align=center><a href='/index.php/equipos/calendario/" . 
		                    $aniosig . "/" . $messig . "'>[Siguiente]</a></td>";
		 $calendar_html .= "</td></tr>";

		 $calendar_html .= "<tr><th class='thcalendarioeventos'>Domingo</th>" .
		                       "<th  class='thcalendarioeventos'>Lunes</th>" .
		                       "<th  class='thcalendarioeventos'>Martes</th>" .
		                       "<th  class='thcalendarioeventos'>Mi&eacute;rcoles</th>" . 
		                       "<th  class='thcalendarioeventos'>Jueves</th>" .
		                       "<th  class='thcalendarioeventos'>Viernes</th>" .
		                       "<th  class='thcalendarioeventos'>S&aacute;bado</th></tr>";


         $calendar_html .= "<tr>";

         //Fill the first week of the month with the appropriate number of blanks.
         for($week_day = 0; $week_day < $first_week_day; $week_day++)
            {
            $calendar_html .= "<td style=\"background-color:9999cc; color:000000;\"> </td>";
            }

         $week_day = $first_week_day;
		 
		// echo "week day: " . $week_day;
         for($day_counter = 1; $day_counter <= $days_in_this_month; $day_counter++)
            {
            $week_day %= 7;

            if($week_day == 0)
               $calendar_html .= "<td colspan='7'></td></tr><tr>";

            //Do something different for the current day.
         //   if($day == $day_counter)
         //style=\"width:14%;border: 1px solid;vertical-align:top;color:#000;\"
               $calendar_html .= "<td class=\"celdacal\" align=\"center\"><b>";
			   if (($day == $day_counter) && ($month==date('n')))
			      $calendar_html .= "<div style='font-size:1.3em;background-color:#fff;color:#f00;'>" . $day_counter . "</div><br>";
			   else
			      $calendar_html .= $day_counter . "<br>";

			   foreach ($dias as $k=>$v) {
			   	if ($v['dia']==$day_counter) {
			   	  switch ($v['recordatorio_de' ]) {
					case "Notificar":
					$col = "#cccccc";
					$class="notificar";
					break;
					case "Entregar":
					$col = "#00ff00";
					$class="entregar";
					break;
					case "En espera":
					$col = "#ffff00";
				    $class = "enespera";
					break;
					case "Diagnosticar":
					$col = "#ff0000";
					$class="diagnosticar";
					break;
					case "Reparar":
					$col = "#ffffff";
					$class="reparar";
					break;
					case "Entrega Tentativa":
					$col = "#00ffff";
					$class = "entregatentativa";
					break;
					default:
					$col = "#ffffff";
					$class="otro";
					break;
					}
				$calendar_html .= "<div class='" . $class . "' style='background-color:" . $col . "';>" . substr($v['recordatorio_de'],0,1) . 
				      ":&nbsp;" . "<a href='/index.php/equipos/modificar/" . $v['equipo_id'] . "'>" . $v['num_orden'] . "</a></div><br>";
				}	
			   }
			   //if (isset($dias[$day_counter]))
			    // $calendar_html .= 'aaa';
			   $calendar_html .= "</b></td>";
         //   else
          //     $calendar_html .= "<td align=\"center\" style=\"background-color:9999cc; color:000000;\">&nbsp;" .
            //                     $day_counter . " </td>";

            $week_day++;
            }

         $calendar_html .= "</tr>";
         $calendar_html .= "</table>";

         return($calendar_html);
         }

   public function qrcode() {
 	$this->load->library('qrcode_library');
   // echo $this->qrcode_library->make_qrcode("http://www.despertarveracruz.com", $errorCorrectionLevel= '', $matrixPointSize='');
 }	
   
   public function localizarqrcaja() {
   	   // $arrt =  $this->db->query("select equipos.id from catcajas inner join equipos " .
   	                                //" on catcajas.id=equipos.caja_id where catcajas.id=" . $this->uri->segment(3));
		// PRIMERO LOCALIZAR LA CAJA
		$arrt = $this->db->query("select * from catcajas where id=" . $this->uri->segment(3));							
		if ($arrt->num_rows()>0) {							
           $caja = $arrt->result_array();
		   $caja_id = $caja[0]['id'];
		   // SI EXISTE EQUIPO ASIGNADO A CAJA, ENTONCES IR A ESA ORDEN
		   $arreq = $this->db->query("select * from equipos where caja_id=" . $caja_id);
		   if ($arreq->num_rows()>0) {
		   	$equipoencaja = $arreq->result_array();
			redirect("equipos/modificar/" . $equipoencaja[0]['id']);
		   }	 
		   else {
		   	  
		   	  redirect("equipos/recibir/" . 	$caja[0]['id']);
		   }  
		   //echo $caja[0]['num_orden'];
		   }
		else {
		//	echo "No existe la caja.";
			$this->load->view('inicio/top1');
		$r = array("mensaje"=>"No existe la caja solicitada. Puedes darla de alta.",
		           "url" => "/index.php/cajas/index");
		$this->load->view('comun/mensaje',$r); 
		$this->load->view('inicio/bottom1');
		} 		
		
      }
      
public function ordenpdf2() {
   	$this->load->library('Pdf');

$pdf = new Pdf('P', 'mm', 'LEGAL', true, 'UTF-8', false);
$pdf->SetTitle('My Title');
//$pdf->SetHeaderMargin(30);
//$pdf->SetTopMargin(20);
//$pdf->setFooterMargin(20);
//$pdf->SetAutoPageBreak(true);
$pdf->SetAuthor('Author');
$pdf->SetDisplayMode('real', 'default');
$pdf->AddPage();

$mostrarcirculos = 0;

if ($mostrarcirculos)
$pdf->Image(dirname(__FILE__) . '/../libraries/imagenes/escaneado.jpg', 0, 0, 215, 280, 'JPG', '', '', true, 150, '', false, false, 0, false, false, false);
//$pdf->Image($file)
//$pdf->writeHTMLCell(200, 100, 100, 100,"HOLA");
//$pdf->writeHTML("ABCDEFG");
        $arr = ( $this->db->query('select * from equipos where id=' . $this->uri->segment(3)));
	    $data = ($arr->result_array());

        $equipo = $data[0];
		
        $arr = ( $this->db->query('select * from clientes where id=' . $equipo['cliente_id']));
	    $clientes = ($arr->result_array());			
	    $cliente = $clientes[0];
		
// Print text using writeHTMLCell()
$pdf->SetFont('Helvetica', '', 10, '', 'false');

$pdf->writeHTMLCell($w=0, $h=0, $x=185, $y=17, $equipo['num_orden'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);


$pdf->writeHTMLCell($w=0, $h=0, $x=180, $y=25,  $this->_cambiaf_a_normal($equipo['fecha_recibido'])  , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);


$pdf->writeHTMLCell($w=0, $h=0, $x=30, $y=25,  $cliente['nombre'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMLCell($w=0, $h=0, $x=26, $y=30,  $cliente['telefono1'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMLCell($w=0, $h=0, $x=70, $y=30,  $cliente['telefono2'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMLCell($w=0, $h=0, $x=120, $y=30, $cliente['correo_electronico'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->SetFont('Helvetica', '', 9, '', 'false');
$pdf->SetFont('Helvetica', '', 10, '', 'false');

if ($mostrarcirculos) {
$pdf->Circle (29, 43, 2, 0, 360, '', array(), array(), 2);
$pdf->Circle (70, 43, 2, 0, 360, '', array(), array(), 2);
$pdf->Circle (105, 43, 2, 0, 360, '', array(), array(), 2);
$pdf->Circle (145, 43, 2, 0, 360, '', array(), array(), 2);
$pdf->Circle (29, 48, 2, 0, 360, '', array(), array(), 2);
$pdf->Circle (70, 48, 2, 0, 360, '', array(), array(), 2);
$pdf->Circle (105, 48, 2, 0, 360, '', array(), array(), 2);
$pdf->Circle (145, 48, 2, 0, 360, '', array(), array(), 2);
$pdf->Circle (29, 53, 2, 0, 360, '', array(), array(), 2);
}
switch ($equipo['como_te_enteraste']) {
	case "CORREO ELECTRONICO":
        $pdf->writeHTMLCell($w=0, $h=0, $x=27, $y=41, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);				
		break;
    case "ESPECTACULAR":
        $pdf->writeHTMLCell($w=0, $h=0, $x=68, $y=41, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
		break;
    case "MEDALLON":
        $pdf->writeHTMLCell($w=0, $h=0, $x=103, $y=41, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
    	break;
    case "PUBLICACION":
        $pdf->writeHTMLCell($w=0, $h=0, $x=141, $y=41, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
		break;
    case "RECOMENDACION":
        $pdf->writeHTMLCell($w=0, $h=0, $x=27, $y=46, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);				
        break;
    case "REDES SOCIALES":
        $pdf->writeHTMLCell($w=0, $h=0, $x=68, $y=46, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
    		break;
    case "SITIO WEB":
        $pdf->writeHTMLCell($w=0, $h=0, $x=103, $y=46, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
		break;
    case "VISTE EL LOCAL":
        $pdf->writeHTMLCell($w=0, $h=0, $x=141, $y=46, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
		break;
    case "OTRO NEGOCIO":
        $pdf->writeHTMLCell($w=0, $h=0, $x=27, $y=51, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);				
		break;
				
} 

if ($mostrarcirculos) {
$pdf->Circle (106, 59, 2, 0, 360, '', array(), array(), 2);
$pdf->Circle (120, 59, 2, 0, 360, '', array(), array(), 2);
}
        // PROMOCIONES
     if ($equipo['desea_recibir_promociones']=='S')   
        $pdf->writeHTMLCell($w=0, $h=0, $x=104, $y=57, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
	 else
        $pdf->writeHTMLCell($w=0, $h=0, $x=118, $y=57, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);


//$pdf->writeHTMLCell($w=0, $h=0, $x=20, $y=70, "<b>&iquest;Deseas recibir nuestras promociones en tu correo?</b>  ", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

 $pdf->SetFont('Helvetica', '', 12, '', 'false');
$pdf->writeHTMLCell($w=0, $h=0, $x=30, $y=73, $equipo['tipo'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->SetFont('Helvetica', '', 10, '', 'false');


$pdf->writeHTMLCell($w=0, $h=0, $x=115, $y=67, $equipo['modelo'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
//$pdf->writeHTMLCell($w=0, $h=0, $x=160, $y=80, "<b>Generaci&oacute;n</b>", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMLCell($w=0, $h=0, $x=115, $y=73, $equipo['num_serie'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMLCell($w=0, $h=0, $x=187, $y=73, $equipo['capacidad'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);



//$pdf->writeHTMLCell($w=0, $h=0, $x=20, $y=95, "2. &iquest;Tu equipo está aún en el plazo de garantía ofrecido por Apple? (1 año)", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
if ($mostrarcirculos) {

$pdf->Circle (172, 81, 2, 0, 360, '', array(), array(), 2); //97 en la 5
$pdf->Circle (186, 81, 2, 0, 360, '', array(), array(), 2);

}

if ($equipo['equipo_en_garantia']=="S")
   $pdf->writeHTMLCell($w=0, $h=0, $x=170, $y=79, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
else
   $pdf->writeHTMLCell($w=0, $h=0, $x=184, $y=79, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);


//$pdf->writeHTMLCell($w=0, $h=0, $x=20, $y=100, "3. &iquest;Alguien más intentó reparar tu equipo antes de venir con nosotros?", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
if ($mostrarcirculos) {
$pdf->Circle (172, 86, 2, 0, 360, '', array(), array(), 2);
$pdf->Circle (186, 86, 2, 0, 360, '', array(), array(), 2);
}
if ($equipo['intentaron_repararlo']=="S")
   $pdf->writeHTMLCell($w=0, $h=0, $x=170, $y=84, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
else
   $pdf->writeHTMLCell($w=0, $h=0, $x=184, $y=84, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

//$pdf->writeHTMLCell($w=0, $h=0, $x=20, $y=105, "4. &iquest;El producto estuvo en contacto directo con agua o vapores de algún tipo?", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
if ($mostrarcirculos) {
$pdf->Circle (172, 91, 2, 0, 360, '', array(), array(), 2);
$pdf->Circle (186, 91, 2, 0, 360, '', array(), array(), 2);
}
if ($equipo['en_contacto_con_agua_vap']=="S")
   $pdf->writeHTMLCell($w=0, $h=0, $x=170, $y=89, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
else
   $pdf->writeHTMLCell($w=0, $h=0, $x=184, $y=89, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

//$pdf->writeHTMLCell($w=0, $h=0, $x=20, $y=110, "5. &iquest;Adquiriste tu equipo dentro del país?", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
if ($mostrarcirculos) {
$pdf->Circle (172, 96, 2, 0, 360, '', array(), array(), 2);
$pdf->Circle (186, 96, 2, 0, 360, '', array(), array(), 2);
}
if ($equipo['iphone_comprado_en_pais']=="S")
   $pdf->writeHTMLCell($w=0, $h=0, $x=170, $y=94, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
else
   $pdf->writeHTMLCell($w=0, $h=0, $x=184, $y=94, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

//$pdf->writeHTMLCell($w=0, $h=0, $x=20, $y=115, "6. En este momento, &iquest;tu dispositivo tiene jailbreak o cydia?", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
if ($mostrarcirculos) {
$pdf->Circle (172, 102, 2, 0, 360, '', array(), array(), 2);
$pdf->Circle (186, 102, 2, 0, 360, '', array(), array(), 2);
}
if ($equipo['tiene_jailbreak_o_cydia']=="S")
   $pdf->writeHTMLCell($w=0, $h=0, $x=170, $y=100, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
else
   $pdf->writeHTMLCell($w=0, $h=0, $x=184, $y=100, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

//$pdf->writeHTMLCell($w=0, $h=0, $x=20, $y=120, "7. Describe con detalle qu&eacute; problema(s) presenta tu equipo.", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMLCell($w=175, $h=17, $x=20, $y=110, $equipo['descripcion_problema'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

//$pdf->writeHTMLCell($w=0, $h=0, $x=20, $y=142, "8. Condiciones en las que se recibe el equipo.", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMLCell($w=86, $h=22, $x=20, $y=132, $equipo['condiciones_recepcion_eq'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->SetFont('Helvetica', '', 6, '', 'false');

$pdf->SetFont('Helvetica', '', 10, '', 'false');


$pdf->writeHTMLCell($w=0, $h=0, $x=170, $y=159, $this->_cambiaf_a_normal($equipo['fecha_de_entrega']) , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->SetFont('Helvetica', '', 13, '', 'false');
$pdf->SetFont('Helvetica', '', 10, '', 'false');

$pdf->SetFont('Helvetica', '', 17, '', 'false');

if ($equipo['calificacion_servicio']>0)
     $pdf->writeHTMLCell($w=0, $h=0, $x=138, $y=170, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
if ($equipo['calificacion_servicio']>2)
     $pdf->writeHTMLCell($w=0, $h=0, $x=146, $y=170, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
if ($equipo['calificacion_servicio']>4)
     $pdf->writeHTMLCell($w=0, $h=0, $x=154, $y=170, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
if ($equipo['calificacion_servicio']>6)
     $pdf->writeHTMLCell($w=0, $h=0, $x=160, $y=170, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
if ($equipo['calificacion_servicio']>8)
     $pdf->writeHTMLCell($w=0, $h=0, $x=166, $y=170, "X", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->SetFont('Helvetica', '', 10, '', 'false');

$pdf->SetFont('Helvetica', '', 8, '', 'false');
$pdf->writeHTMLCell($w=175, $h=14, $x=20, $y=185, $equipo['notas'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->SetFont('Helvetica', '', 10, '', 'false');

$pdf->SetFont('Helvetica', '', 8, '', 'false');
$pdf->writeHTMLCell($w=0, $h=0, $x=85, $y=218, $equipo['num_orden'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMLCell($w=0, $h=0, $x=190, $y=218, $equipo['num_orden'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=0, $h=0, $x=20, $y=225,  $cliente['nombre'] , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMLCell($w=0, $h=0, $x=80, $y=225,  $cliente['telefono1'] , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMLCell($w=0, $h=0, $x=30, $y=229,$this->_cambiaf_a_normal($equipo['fecha_recibido'])  , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMLCell($w=0, $h=0, $x=80, $y=229,$this->_cambiaf_a_normal($equipo['fecha_de_entrega'])  , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMLCell($w=90, $h=20, $x=22, $y=233,  $equipo['descripcion_problema']  , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=0, $h=0, $x=130, $y=225, $equipo['tipo'] , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMLCell($w=0, $h=0, $x=180, $y=225,  $equipo['num_serie'] , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMLCell($w=0, $h=0, $x=140, $y=229, $this->_cambiaf_a_normal($equipo['fecha_recibido'])  , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMLCell($w=0, $h=0, $x=185, $y=229,  $this->_cambiaf_a_normal($equipo['fecha_de_entrega'])  , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMLCell($w=90, $h=20, $x=130, $y=233, $equipo['descripcion_problema']  , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMLCell($w=90, $h=20, $x=114, $y=245, $equipo['notas']  , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);



//$pdf->SetFont('Helvetica', '', 6, '', 'false');
//$pdf->writeHTMLCell($w=90, $h=20, $x=110, $y=240, '<center>Av. Ruiz Cortines #30 Entre Úrsulo Galván e I. de la Llave. Tel. 204 0488 52*14*21675<br>Xalapa, Ver. ayudame@hospitaldeipods.mx www.hospitaldeipods.mx</center>' , $border=0, $ln=1, $fill=0, $reseth=true, $align='C', $autopadding=true);



$pdf->SetFont('Helvetica', '', 10, '', 'false');
//$pdf->writeHTMLCell($w=30, $h=5, $x=50, $y=242, 'Importe:'   , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
//$pdf->writeHTMLCell($w=90, $h=20, $x=40, $y=272, 'Importe:'   , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);


//$pdf->Write(50, 'Some sample text');
$pdf->Output('Orden-' . $equipo['num_orden'] . '.pdf', 'I'); 
   }		  
	  

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */