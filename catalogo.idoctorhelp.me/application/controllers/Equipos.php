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
	   
	   
	   
	 
	public function index()
	{
          $this->load->model('Equiposmodel');

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
		
		
        $qry = $this->Equiposmodel->get_sqldesdebusqueda(1,"desc");
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
		$arrtot = ( $this->db->query( $this->Equiposmodel->get_sqldesdebusqueda(0,"")));
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
		
		$this->load->view('equipos/buscar',$data); 
		$this->load->view('equipos/equiposindex',$data); 
		$this->load->view('inicio/bottom1'); 
		 		
	}
	
	
	
    public function buscar() {
		
		$this->load->model('Catalogosmodel');
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
		
        $tip = array();
		$tip = $this->Catalogosmodel->get_tipos_dropdown();
		$tip[''] = "Cualquiera"; 
		
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
		$data['busca_numserie'] = $busca_numserie; 
		$this->load->view('inicio/top1'); 
		 $this->load->view('equipos/buscar',$data); 
		$this->load->view('inicio/bottom1'); 		
		
	}

	public function nuevaorden() {
		$this->load->model('Equiposmodel');

		$this->load->view('inicio/top1');
		$this->load->view('equipos/nuevaorden');
		$this->load->view('inicio/bottom1');
	}

	public function checklist() {
		$this->load->view('inicio/top1');
		$this->load->view('equipos/checklist');
		$this->load->view('inicio/bottom1');

	}
	
	public function recibir($params=NULL) {
		$this->load->model('Equiposmodel');
		$this->load->model('Catalogosmodel');
		$this->load->model('Tiposclasesequiposmodel');


		$registro=array();

		$tip = $this->Tiposclasesequiposmodel->get_tipos_dropdown();

		$caj = $this->Catalogosmodel->get_cajas_dropdown("");

		$registro['correo_electronico'] = '';
		$registro['telefono1'] = '';
		$registro['telefono2'] = '';

		$registro['direccion'] = '';
		$registro['colonia'] = '';
		$registro['cp'] = '';
		$registro['ciudad'] = '';
		$registro['estado'] = '';

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
		   		

		$registro['caja']=$cajasel;		
		$registro["num_orden"] = $this->Equiposmodel->get_numorden_no_incrementar();
        $registro["tipos"] = $tip;
		$registro["cajas"] = $caj;
		$registro["titulo"] = "Recibir equipo"; 
		$registro["fecha_recibido"] = "";
		$registro["hora_recibido"] = "";

		$registro["checklist"] = $this->Equiposmodel->array_checklist();

		$registro["equipo_enciende"] = $_POST['equipo_enciende'];
		$registro["equipo_mojado"] = $_POST['equipo_mojado'];



		$this->load->view('inicio/top1');
		$this->load->view('equipos/agregarequipo',$registro); 
		$this->load->view('inicio/bottom1');
	}
	

	public function modificar() {
		$this->load->model('Equiposmodel');
		$this->load->model('Catalogosmodel');
		$this->load->model('Comunicacionesmodel');
		$this->load->model('Clientesmodel');

		$cli = $this->Clientesmodel->get_clientes_dropdown();

//echo $this->uri->segment(3); die();		
		$usrur = $this->Equiposmodel->get_usuario_recibio($this->uri->segment(3));

	    $bitacoras = $this->Catalogosmodel->get_bitacorasequipo($this->uri->segment(3));
		
	    $piezas = $this->Catalogosmodel->get_piezasequipo($this->uri->segment(3));
		

	    $servicios = $this->Catalogosmodel->get_serviciosequipo($this->uri->segment(3));
	
	    $data = $this->Equiposmodel->get_equipo($this->uri->segment(3));
		
        $tipos = $this->Catalogosmodel->get_tipos();
		
		$comunicaciones = $this->Comunicacionesmodel->get_comunicaciones($this->uri->segment(3));
				
		$tip = $this->Catalogosmodel->get_tipos_dropdown();

		$caj = $this->Catalogosmodel->get_cajas_dropdown($data[0]['caja_id']);	
		
		$registro = array();
		$registro = $data[0];
		$registro["usuario_recibio"] = $usrur["usuario"];
		$registro["cajas"] = $caj;
		$registro["clientes"] = $cli;		
		$registro["bitacoras"] = $bitacoras;
		$registro["piezas"] = $piezas;
		$registro["servicios"] = $servicios;
		$registro["tipos"] = $tip;
		$registro['comunicaciones'] = $comunicaciones;
		$registro["titulo"] = "Orden de equipo";
		$registro["checklist"] = $this->Equiposmodel->array_checklist();
		$registro["checklistentrega"] = $this->Equiposmodel->array_checklist("ent");
		$registro["siguiente_id"] = $this->Equiposmodel->siguiente_equipo_activo($this->uri->segment(3));
		$registro["anterior_id"] = $this->Equiposmodel->anterior_equipo_activo($this->uri->segment(3));
		
	
		$this->load->view('inicio/top1');
	//	$this->load->view('equipos/detalleequipo',$registro);

		$this->load->view('equipos/detalleequipo_encabezado',$registro);
		$this->load->view('equipos/detalleequipo_datosgrales',$registro);
		$this->load->view('equipos/detalleequipo_bitacora',$registro);
		$this->load->view('equipos/detalleequipo_piezas',$registro);
		$this->load->view('equipos/detalleequipo_servicios',$registro);
		$this->load->view('equipos/detalleequipo_comunicaciones',$registro);
		$this->load->view('equipos/detalleequipo_otrosdatos',$registro);		
		$this->load->view('equipos/detalleequipo_chklst_recepcion',$registro);
		$this->load->view('equipos/detalleequipo_chklst_entrega',$registro);
		$this->load->view('equipos/detalleequipo_datosfinales',$registro);		

		$this->load->view('equipos/detalleequipo_botonesfin',$registro);

		$this->load->view('inicio/bottom1');
		
	}


    public function validar() {
        $this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');

		$this->form_validation->set_rules('descripcion_problema', 'Descripcion', 'required');
		$this->form_validation->set_rules('condiciones_recepcion_eq', 'Condiciones...', 'required');
		

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
        $this->load->model('Tiposclasesequiposmodel');
        $this->load->model('Equiposmodel');
        $this->load->model('Registroaccionesmodel');
        $this->load->model('Clientesmodel');

		if ($param!='')
		    $_POST = $param;
		
			
		unset($_POST['submit']);
		unset($_POST['botonenviar']);
		

		$accion = $_POST['accion'];
        unset($_POST['accion']);
		unset($_POST['passwdadmin']);
		//unset($_POST['nombrecliente']);
		unset($_POST['name']);
		
		if (isset($_POST['editimprimir'])) {
		   $imprimir = $_POST['editimprimir'];
		     unset($_POST['editimprimir']);
		}
		
		
		if ($_POST['cliente_id']=="") {

			$_POST['cliente_id'] = $this->Clientesmodel->agregar_nuevo_cliente_nueva_orden($_POST);
			
		}
		else
		    $this->Clientesmodel->activar_cliente($_POST['cliente_id']);

		    unset($_POST['nombrecliente']);
			unset($_POST['telefono1']);
			unset($_POST['telefono2']);
			unset($_POST['correo_electronico']);
			unset($_POST['direccion']);
			unset($_POST['colonia']);
			unset($_POST['cp']);
			unset($_POST['ciudad']);
			unset($_POST['estado']);

   if (isset($_POST['fecha_de_diagnostico'])) {
		$fecha_de_diagnostico = $_POST['fecha_de_diagnostico'];
		unset($_POST['fecha_de_diagnostico']);	
    }
	else $fecha_de_diagnostico = "";


	    // obtener la CLASE del TIPO del equipo
        $tipodetalle = $this->Tiposclasesequiposmodel->get_detalle($_POST['tipo']);

		$_POST['clase'] =  $tipodetalle['clase'];
		$_POST['modelo'] = $tipodetalle['modelo'];
		
		
        $ud = $this->session->all_userdata();
		$_POST['usuario_id'] = $ud['usuario_id'];		
		
    if ($accion=="i") {
		   $_POST['situacion'] = "A";

           // OBTENER NUMERO DE ORDEN Y AGREGAR UNO A LA TABLA NUMEROSORDENES
           while ($this->Equiposmodel->existe_numorden($_POST['num_orden']))
	           $_POST['num_orden'] = $this->Equiposmodel->get_numorden_incrementar();

           $ultimo_eq_id = $this->Equiposmodel->insertar_equipo($_POST);

            // AGREGAR RECIBIDO A BITACORA
		   $this->Equiposmodel->agregar_recibido_a_bitacora($ultimo_eq_id,$fecha_de_diagnostico);

			// REGISTRO DE ACCIONES
			$this->Registroaccionesmodel->registrar("NUEVO","equipos",$_POST['num_orden']);
		 if ($imprimir!="S")  
		   redirect('/equipos/modificar/' . $ultimo_eq_id);
         else {
          // SE MOVIO EL AGREGAR LA BITACORA DE AQUI HACIA ARRIBA PARA QUE
          // SE APLIQUE SIEMPRE
          
           redirect('/equipos/modificar/' . $ultimo_eq_id . "/imprimir");
			 }
         
		}
		else {
	     unset($_POST['nombrecliente']);
	     unset($_POST['eq_id_ir']);
	     unset($_POST['eq_id_ir2']);
	     $this->db->where('id', $_POST["id"]);
		 $this->db->update('equipos', $_POST);
		 //die();
		 $this->Equiposmodel->copiar_fecha_recibido_a_bitacora($_POST['id']);
		 
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
        $this->load->model('Equiposmodel');  
        $this->Equiposmodel->cancelar_orden($this->uri->segment(3));

		$r = array("mensaje"=>"La orden ha sido cancelada.",
		           "url" => "/index.php/equipos/index");

   	    $this->load->view('inicio/top1');
		$this->load->view('comun/mensaje',$r); 
		$this->load->view('inicio/bottom1');
   	
}

public function eliminar() {

	$this->load->model("Equiposmodel");
	$this->load->model("Registroaccionesmodel");

  if ($this->Equiposmodel->eliminar_equipo($this->uri->segment(3),$this->uri->segment(4),$this->uri->segment(6)) ) {

    $this->Registroaccionesmodel->registrar("ELIMINO","equipos","Num orden :" . $this->uri->segment(4));

	if ($this->uri->segment(5,"")=="")	 
		 redirect('/equipos/index'); 
	 else echo "Eliminaci&oacute;n correcta.";
     }
	else { 
	   if ($this->uri->segment(5,"")=="")	 
		 redirect('/equipos/index'); 
		 else echo "Datos incorrectos para eliminar.";
	}
}
	

   public function iraequipo() {
   	  $this->load->model("Equiposmodel");
   	  $equipo_desde_id = $this->uri->segment(3);
   	  $equipo_orden_ir = $this->uri->segment(4);

   	  $num_orden_estandarizado = $this->Equiposmodel->get_numorden_estandarizado($equipo_orden_ir);

      if ($this->Equiposmodel->existe_numorden($num_orden_estandarizado)===FALSE) {
  	    $this->load->view('inicio/top1');
		$r = array("mensaje"=>"No existe el n&uacute;mero de orden especificado (" . $num_orden_estandarizado . ").",
		           "url" => "/index.php/equipos/modificar/" . $equipo_desde_id);
		$this->load->view('comun/mensaje',$r); 
		$this->load->view('inicio/bottom1');
      }
      else 
      	redirect("equipos/modificar/" . $this->Equiposmodel->id_numorden($num_orden_estandarizado));
/*        $qry1 = "select * from equipos where num_orden='" . $equipo_orden_ir . "'";
		$arr1 = ( $this->db->query($qry1));
		$res1 = ($arr1->result_array());   	  */

   }

   public function entregar() {
   	   $this->load->model("Equiposmodel");
   	// ESTA FUNCION SE EJECUTA DENTRO DEL IFRAME DONDE SALEN LAS BITACORAS
		$cli = array(
		             "nombre" => $_POST['nombre'],
		             "telefono1" => $_POST['telefono1'],
		             "telefono2" => $_POST['telefono2'],
		             "direccion" => $_POST['direccion'],
		             "colonia" => $_POST['colonia'],
		             "cp" => $_POST['cp'],
		             "ciudad" => $_POST['ciudad'],
		             "estado" => $_POST['estado'],
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
			unset($_POST['colonia']);
			unset($_POST['cp']);
			unset($_POST['ciudad']);
			unset($_POST['estado']);
			unset($_POST['correo_electronico']);
			unset($_POST['submit']);

   	    $this->db->where('id', $_POST["equipo_id"]);
   	    $equipo_id = $_POST['equipo_id'];
   	    			unset($_POST['equipo_id']);
		
		 $this->db->update('equipos', $_POST);

		 $this->Equiposmodel->sincronizar_fecha_de_entrega($equipo_id);
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
		 $this->load->view('equipos/reporte1',$data); 
		 $this->load->view('inicio/bottom1'); 		
	
	}
	
	
    public function reporteequiposenempresa() {
    	$this->load->model('Equiposmodel');
    	$eqemp['result'] = $this->Equiposmodel->get_equipos_en_empresa();

		 $this->load->view('inicio/top1'); 
		 $this->load->view('equipos/equiposenempresa',$eqemp); 
		 $this->load->view('inicio/bottom1'); 		
    }
    	
    
    function x_week_range(&$start_date, &$end_date, $date) {
        $ts = strtotime($date);
        $start = (date('w', $ts) == 0) ? $ts : strtotime('last sunday', $ts);
        $start_date = date('Y-m-d', $start);
        $end_date = date('Y-m-d', strtotime('next saturday', $start)); 
    }
        
    
	
	
	public function reportecalendario() {
		$this->load->model('Calendariomodel');
		$this->Calendariomodel->procesocalendario();
		//$this->procesocalendario();
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
		 $this->load->view('equipos/reporte1',$data); 
		 $this->load->view('inicio/bottom1'); 		
		
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

	 	$this->load->model('Equiposmodel');
	 	$numordenes = array();
	 	$numordenes['numero_orden'] = $this->Equiposmodel->get_numero_orden_actual();
	 	$numordenes['serie'] = $this->Equiposmodel->get_serie_actual();
	 	$numordenes['numero_remision'] = $this->Equiposmodel->get_numremision_no_incrementar();

         $this->load->view('inicio/top1'); 
		 $this->load->view('equipos/cambiarnumorden',$numordenes); 
		 $this->load->view('inicio/bottom1'); 			
		
	}
}	

function guardarnumorden() {
	 if ($this->session->userdata('nivel')==1) {
        $this->load->model("Equiposmodel");
        $this->Equiposmodel->set_serie_numorden($_POST['serie'],$_POST['numero_orden']);
        $this->Equiposmodel->set_numero_remision($_POST['numero_remision']);
		
		redirect('/inicio/iniciar'); 
		
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

public function ordennueva() {
	
	    $arr = ( $this->db->query('select * from equipos where id=' . $this->uri->segment(3)));
	    $data = ($arr->result_array());

        $equipo = $data[0];
		
        $arr = ( $this->db->query('select * from clientes where id=' . $equipo['cliente_id']));
	    $clientes = ($arr->result_array());			
	    $cliente = $clientes[0];
		
		$valores = array("equipos"=>$equipo,"clientes"=>$cliente);
	
	  $this->load->model('Reportesmodel');
	  $this->Reportesmodel->preview("orden1",$valores,"LEGAL","P");
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

    $this->load->model('Tiposclasesequiposmodel');

    $this->load->model('Equiposmodel');

    $this->load->model('Clientesmodel');

    // PONER EL NUMERO DE LA NOTA DE VENTA, SI ES QUE NO TIENE, ASIGNARLE UN CONSECUTIVO
    $equipo1 = $this->Equiposmodel->get_detalle_equipo($this->uri->segment(3));

    if (($equipo1['numero_remision']=="") or ($equipo1['numero_remision']==0)) {
    	// NO TIENE, ASIGNARLE UN NUMERO
    	$this->Equiposmodel->set_numero_remision_a_equipo($this->uri->segment(3));
    }

 	$this->load->library('Pdf');
$ddx = 0; $ddy = 3; $mostrarcirculos = 0;

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

$pdf->Image(dirname(__FILE__) . '/../../images/nota_venta.png' , 10 + $ddx, 7 + $ddy, 200, 140, 'PNG', '', '', true, 150, '', false, false, 0, false, false, false);

    $equipo = $this->Equiposmodel->get_detalle_equipo($this->uri->segment(3));

	$cliente = $this->Clientesmodel->get_detalle($equipo['cliente_id']);	
		
// Print text using writeHTMLCell()
$pdf->SetFont('Helvetica', '', 10, '', 'false');

$pdf->writeHTMLCell($w=0, $h=0, $x=185 + $ddx, $y=17 + $ddy, $equipo['numero_remision'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMLCell($w=0, $h=0, $x=38 + $ddx, $y=32 + $ddy, $equipo['num_orden'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=0, $h=0, $x=35 + $ddx, $y=39 + $ddy, $cliente['nombre'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->writeHTMLCell($w=0, $h=0, $x=35 + $ddx, $y=47 + $ddy, $cliente['direccion'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=0, $h=0, $x=35 + $ddx, $y=54 + $ddy, $cliente['colonia'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=0, $h=0, $x=35 + $ddx, $y=62 + $ddy, $cliente['ciudad'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);


$pdf->writeHTMLCell($w=0, $h=0, $x=150 + $ddx, $y=47 + $ddy, $cliente['telefono1'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=0, $h=0, $x=150 + $ddx, $y=54 + $ddy, $cliente['cp'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=0, $h=0, $x=157 + $ddx, $y=62 + $ddy, $cliente['estado'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=0, $h=0, $x=135 + $ddx, $y=39 + $ddy, $cliente['correo_electronico'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);


// COnseguir la fecha de entrega
 $arrf = ( $this->db->query("select * from bitacoras where estatus='Entregado' and  equipo_id=" . $this->uri->segment(3)));
 if ($arrf->num_rows()>0) {
	    $serviciosf = ($arrf->result_array());
		$fecha = $this->_cambiaf_a_normal($serviciosf[0]['fecha']);
 }
 else $fecha = date("d/m/Y");
//



$pdf->writeHTMLCell($w=0, $h=0, $x=174 + $ddx, $y=31 + $ddy,  $fecha  , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);



 $arr = ( $this->db->query('select * from servicios where equipo_id=' . $this->uri->segment(3)));
	    $servicios = ($arr->result_array());

 $linea = 0;
 $total = 0;

  $detalletipo = $this->Tiposclasesequiposmodel->get_detalle($equipo['tipo']);

  $pdf->writeHTMLCell($w=0, $h=0, $x=35 + $ddx, $y=76 + $ddy + $linea,
  	    "Equipo: " . $detalletipo['descripcion'] . "   " . $detalletipo['modelo']
  	  , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

  $linea = $linea + 1;


 foreach ($servicios as $servicio) {
      $pdf->writeHTMLCell($w=0, $h=0, $x=16 + $ddx, $y=80 + $ddy + $linea,"1", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
	 
      $pdf->writeHTMLCell($w=0, $h=0, $x=40 + $ddx, $y=80 + $ddy + $linea, $servicio['descripcion'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
       $pdf->writeHTMLCell($w=0, $h=0, $x=150 + $ddx, $y=80 + $ddy + $linea, "$" . number_format($servicio['subtotal'], 2, '.', ','), $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

       $pdf->writeHTMLCell($w=0, $h=0, $x=185 + $ddx, $y=80 + $ddy + $linea, "$" . number_format($servicio['subtotal'], 2, '.', ','), $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

	 $linea = $linea + 5; 
	 $total += $servicio['subtotal'];
 }
 
       $pdf->writeHTMLCell($w=0, $h=0, $x=185 + $ddx, $y=121 + $ddy , "$" . number_format($total, 2, '.', ','), $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
 

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

$pdf->Image(dirname(__FILE__) . '/../../images/garantia.jpg' , 13 + $ddx, 15 + $ddy, 190, 240, 'JPG', '', '', true, 150, '', false, false, 0, false, false, false);

$pdf->Output('Garantia.pdf', 'I'); 
   }	


   
public function calendario() {
		
	    $this->load->model('Calendariomodel');
		$this->Calendariomodel->procesocalendario();	   

		$result = array();
		$anio = $this->uri->segment(3,date('Y')); 
		$mes  = $this->uri->segment(4,date('n'));
		$result = $this->Calendariomodel->get_dias_calendario($anio,$mes);  
	
		 $this->load->view('inicio/top1'); 

		 $d = getDate();
		 $d['year'] = $this->uri->segment(3,date('Y'));
		 $d['mon']  = $this->uri->segment(4,date('n'));

		 $data['calendario'] = $this->Calendariomodel->calendar($d,$result);
		 
		 $data['urlregresar'] = '/index.php/inicio/proceso';
		 $data['titulo'] = 'Calendario';
		 $this->load->view('equipos/calendario',$data); 
		 $this->load->view('inicio/bottom1'); 	
}




   public function qrcode() {
 	$this->load->library('qrcode_library');
   // echo $this->qrcode_library->make_qrcode("http://www.despertarveracruz.com", $errorCorrectionLevel= '', $matrixPointSize='');
 }	
   
   public function localizarqrcaja() {
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


public function ordenpdf3() {

	ini_set("memory_limit","64M");


	$this->load->model("Equiposmodel");
	$equipo = $this->Equiposmodel->get_detalle_equipo($this->uri->segment(3));

	$this->load->model("Clientesmodel");
	$cliente = $this->Clientesmodel->get_cliente_de_equipo($this->uri->segment(3)); 

	$this->load->model("Bitacorasmodel");

	$this->load->library('Pdf');


$ddx = 0; $ddy = 0; $mostrarcirculos = 0;

$bord = 0; // BORDER


$pdf = new Pdf('P', 'mm', 'LETTER', true, 'UTF-8', false);
$pdf->SetTitle('Orden nueva');
//$pdf->SetHeaderMargin(30);
//$pdf->SetTopMargin(20);
$pdf->setFooterMargin(0);
//echo $pdf->getFooterMargin(); die();
$pdf->SetAutoPageBreak(false);
$pdf->SetAuthor('iDoctor');
$pdf->SetDisplayMode('real', 'default');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AddPage();

//Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', 
//    $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, 
//    $border=0, $fitbox=false, $hidden=false, $fitonpage=false, $alt=false, $altimgs=array()


$pdf->Image(dirname(__FILE__) . '/../../images/orden_ov_sup.png' , 13 , 10 , 190, 18, 'PNG', '', '', false, 300, '', 
  	            false, false, 0, false, false, false);

$pdf->Image(dirname(__FILE__) . '/../../images/orden_ov_inf.png' , 13 , 247 , 190, 25, 'PNG', '', '', true, 300, '', 
	            false, false, 0, false, false, false);


$pdf->SetFont('Helvetica', '', 9, '', 'false');

$yy = 25;

$pdf->writeHTMLCell($w=0, $h=0, $x=175, $y=18 , $equipo['num_orden'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);


$yy = $yy + 5;

$pdf->writeHTMLCell($w=0, $h=0, $x=145, $y=$yy , "Fecha de recepción:", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=0, $h=0, $x=180, $y=$yy , $this->_cambiaf_a_normal($equipo['fecha_recibido']), $border=0, $ln=1, $fill=0, $reseth=true, $align='L', $autopadding=true);



$yy = $yy + 5;


$pdf->writeHTMLCell($w=215, $h=5, $x=0, $yy, "<b>Información del Cliente</b>"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='C', $autopadding=true);

$yy = $yy + 5;

$pdf->writeHTMLCell($w=40, $h=5, $x=20, $yy, "Nombre:"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=80, $h=5, $x=60, $yy, $cliente['nombre']  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=40, $h=5, $x=120, $yy, "Teléfono:"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=80, $h=5, $x=140, $yy, $cliente['telefono1']  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);


$yy = $yy + 5;

$pdf->writeHTMLCell($w=40, $h=5, $x=20, $yy, "Correo electrónico:"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=80, $h=5, $x=60, $yy, $cliente['correo_electronico']  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);


$pdf->writeHTMLCell($w=40, $h=5, $x=120, $yy, "Móvil:"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=80, $h=5, $x=140, $yy, $cliente['telefono2']  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$yy = $yy + 10;



$pdf->writeHTMLCell($w=215, $h=5, $x=0, $yy, "<b>Información del Equipo</b>"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='C', $autopadding=true);

$yy = $yy + 5;
$yy1 = $yy;

$pdf->writeHTMLCell($w=40, $h=5, $x=20, $yy, "Dispositivo:"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=50, $h=5, $x=50, $yy, $equipo['descripcion_tipo']  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);


$pdf->writeHTMLCell($w=40, $h=5, $x=80, $yy, "Capacidad:"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=50, $h=5, $x=110, $yy, $equipo['capacidad']  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=40, $h=5, $x=140, $yy, "Color:"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=50, $h=5, $x=160, $yy, $equipo['color']  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$yy = $yy + 5;

$pdf->writeHTMLCell($w=40, $h=5, $x=20, $yy, "Num. serie:"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=50, $h=5, $x=50, $yy, $equipo['num_serie']  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);


$pdf->writeHTMLCell($w=40, $h=5, $x=80, $yy, "Versión de IOS:"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=50, $h=5, $x=110, $yy, $equipo['ios_version']  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=40, $h=5, $x=140, $yy, "Firmware modem:"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

if (substr($equipo['tipo'],0,5)=="iPhon")

   $pdf->writeHTMLCell($w=50, $h=5, $x=175, $yy, $equipo['iphone_firmware_modem']  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
else
   $pdf->writeHTMLCell($w=50, $h=5, $x=175, $yy, "No aplica" , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);



$yy = $yy + 5;

$pdf->writeHTMLCell($w=40, $h=5, $x=20, $yy, "IMEI:"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);



if (substr($equipo['tipo'],0,5)=="iPhon")

   $pdf->writeHTMLCell($w=50, $h=5, $x=30, $yy, $equipo['iphone_imei']  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
else

   $pdf->writeHTMLCell($w=50, $h=5, $x=30, $yy, "No aplica" , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);



$pdf->writeHTMLCell($w=40, $h=5, $x=80, $yy, "Operador:"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

if (substr($equipo['tipo'],0,5)=="iPhon")
    $pdf->writeHTMLCell($w=50, $h=5, $x=110, $yy, $equipo['operador']  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
else
   $pdf->writeHTMLCell($w=50, $h=5, $x=110, $yy, "No aplica" , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

//echo substr($equipo['tipo'],0,5); die();

$yy = $yy + 10;



$xx = 20;

$pdf->writeHTMLCell($w=80, $h=5, $x=20 + $xx, $yy, "¿El equipo está dentro del año de garantía?"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=10, $h=5, $x=140 + $xx, $yy, ($equipo['equipo_en_garantia']=="S" ? "Sí" : "No") , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$yy = $yy + 5;

$pdf->writeHTMLCell($w=120, $h=10, $x=20 + $xx, $yy, "¿El equipo estuvo en contacto con agua o vapores de algún tipo?"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=10, $h=5, $x=140 + $xx, $yy, ($equipo['en_contacto_con_agua_vap']=="S" ? "Sí" : "No") , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$yy = $yy + 5;

$pdf->writeHTMLCell($w=80, $h=5, $x=20 + $xx, $yy, "¿Alguien más intentó reparar tu equipo?"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=10, $h=5, $x=140 + $xx, $yy, ($equipo['intentaron_repararlo']=="S" ? "Sí" : "No") , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$yy = $yy + 5;

$pdf->writeHTMLCell($w=80, $h=5, $x=20 + $xx, $yy, "¿El equipo tiene jailbreak en este momento?"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=10, $h=5, $x=140 + $xx, $yy, ($equipo['tiene_jailbreak_o_cydia']=="S" ? "Sí" : "No") , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$yy = $yy + 5;

$pdf->writeHTMLCell($w=80, $h=5, $x=20 + $xx, $yy, "El equipo tiene desbloqueo"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=80, $h=5, $x=140 + $xx, $yy, ($equipo['equipo_tiene_desbloqueo']=="NO" ? "No" : $equipo['equipo_tiene_desbloqueo']), 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);


$yy = $yy + 5;

$pdf->writeHTMLCell($w=80, $h=5, $x=20 + $xx, $yy, "¿El equipo fue comprado en el país?"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=10, $h=5, $x=140 + $xx, $yy, ($equipo['iphone_comprado_en_pais']="S" ? "Sí" : "No") , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$yy = $yy + 10;

$pdf->writeHTMLCell($w=215, $h=5, $x=0, $yy, "<b>Checklist de recepción</b>"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='C', $autopadding=true);


if (($equipo['equipo_enciende']=="SI") && ($equipo['equipo_mojado']=="NO"))
    { 

$array_checklist = $this->Equiposmodel->array_checklist();

$cntx = 0;
$x01 = 20; $x02 = 110;

$yy2 = $yy;
$yy3 = $yy;

foreach ($array_checklist as $k=>$v) {
  if (($equipo[$k]!="NO") && ($equipo[$k]!="")) {
    $yy = $yy + 4;
    $pdf->writeHTMLCell($w=130, $h=4, $x=$x01, $yy, $v , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
    $pdf->writeHTMLCell($w=30, $h=4, $x=$x02, $yy, ($equipo[$k]=="SI" ? "Sí" : "N.V.") , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

    $cntx++;
    if ($cntx==10) {
    	$x01 = 120;
    	$x02 = 195;
    	$yy3 = $yy;
    	$yy = $yy2;
    }
  }

}

if ($cntx>=10)
	$yy = $yy2 + 40;
//$yy = $yy3;

}

else {  //EQUIPO NO ENCIENDE O EQUIPO MOJADO.

	$yy = $yy + 5;

    if ($equipo['equipo_enciende']=="NO") {
      $pdf->writeHTMLCell($w=190, $h=10, $x=10, $yy, "El equipo no encendió durante la recepción, por lo cual no fue posible realizarse las comprobaciones de rutina."  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='C', $autopadding=true);
      $yy = $yy + 10;
      }

    if ($equipo['equipo_mojado']=="SI") {
      $pdf->writeHTMLCell($w=190, $h=10, $x=10, $yy, "Debido a las condiciones de humedad en las que se recibe el equipo, se omitirá la comprobación de rutina a fin de evitar mayores daños al dispositivo."  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='C', $autopadding=true);
      $yy = $yy + 10;
      }


}



$yy = $yy + 7;

$pdf->writeHTMLCell($w=215, $h=5, $x=0, $yy, "<b>Descripción del problema</b>"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='C', $autopadding=true);
$yy = $yy + 5;

$pdf->writeHTMLCell($w=175, $h=20, $x=20, $yy, $equipo['descripcion_problema']  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$yy = $yy + 10;

$pdf->writeHTMLCell($w=215, $h=5, $x=0, $yy, "<b>Condiciones del equipo</b>"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='C', $autopadding=true);
$yy = $yy + 5;

$pdf->writeHTMLCell($w=175, $h=10, $x=20, $yy, $equipo['condiciones_recepcion_eq']  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$yy = $yy + 10;

$pdf->writeHTMLCell($w=215, $h=5, $x=0, $yy, "<b>Otras observaciones</b>"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='C', $autopadding=true);
$yy = $yy + 5;

$pdf->writeHTMLCell($w=175, $h=10, $x=20, $yy, $equipo['otras_observaciones_rec']  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);



$yy = $yy + 8;

$meses = array(1=>"Enero",2=>"Febrero",3=>"Marzo",4=>"Abril",5=>"Mayo",6=>"Junio",
	   7=>"Julio",8=>"Agosto",9=>"Septiembre",10=>"Octubre",11=>"Noviembre",12=>"Diciembre");

$fecha_diagnostico = $this->Bitacorasmodel->get_fecha_diagnostico($equipo['id']);

//$fecha_diagnostico2 = date($fecha_diagnostico, strtotime(' +1 day'));


$mensaje = "<b>Por favor comuníquese el día " . date("j",strtotime($fecha_diagnostico . " + 1 day")) . " de " .
          $meses[date("n",strtotime($fecha_diagnostico . " + 1 day"))] . " del " . date("Y",strtotime($fecha_diagnostico . " + 1 day")) . 
          " para recibir información de su diagnóstico y/o reparación.</b>";

$pdf->writeHTMLCell($w=175, $h=10, $x=20, $yy, $mensaje  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);



$yy = $yy + 20;

// OJO CON ESTO!!!:::::::

$yy = 230;
$pdf->SetFont('Helvetica', '', 8, '', 'false');


$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter',  'phase' => 10, 'color' => array(0, 0, 0));

$pdf->Line(18, $yy, 110, $yy, $style);

$pdf->writeHTMLCell($w=90, $h=10, $x=20, $yy, "Declaro que este equipo es de mi propiedad y autorizo la realización de los procedimientos necesarios para su diagnóstico y/o reparación."  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='C', $autopadding=true);

$pdf->Line(115, $yy, 200, $yy, $style);


$pdf->writeHTMLCell($w=90, $h=10, $x=115, $yy, "Recibo el equipo en las condiciones pactados y declaro mi conformidad con el servicio recibido."  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='C', $autopadding=true);


$pdf->Output('Orden-' . $equipo['num_orden'] . '.pdf', 'I'); 


}	  



public function notadeventa3() {

	ini_set("memory_limit","64M");


	$this->load->model("Equiposmodel");
	$equipo = $this->Equiposmodel->get_detalle_equipo($this->uri->segment(3));

	$this->load->model("Clientesmodel");
	$cliente = $this->Clientesmodel->get_cliente_de_equipo($this->uri->segment(3)); 

	$this->load->model("Bitacorasmodel");

    $equipo1 = $this->Equiposmodel->get_detalle_equipo($this->uri->segment(3));

    if (($equipo1['numero_remision']=="") or ($equipo1['numero_remision']==0)) {
    	// NO TIENE, ASIGNARLE UN NUMERO
    	$equipo['numero_remision'] = $this->Equiposmodel->set_numero_remision_a_equipo($this->uri->segment(3));
    }


	$this->load->library('Pdf');


$ddx = 0; $ddy = 0; $mostrarcirculos = 0;

$bord = 0; // BORDER


$pdf = new Pdf('P', 'mm', 'LETTER', true, 'UTF-8', false);
$pdf->SetTitle('Orden nueva');
//$pdf->SetHeaderMargin(30);
//$pdf->SetTopMargin(20);
$pdf->setFooterMargin(0);
//echo $pdf->getFooterMargin(); die();
$pdf->SetAutoPageBreak(false);
$pdf->SetAuthor('iDoctor');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetDisplayMode('real', 'default');
$pdf->AddPage();

//Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', 
//    $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, 
//    $border=0, $fitbox=false, $hidden=false, $fitonpage=false, $alt=false, $altimgs=array()


$pdf->Image(dirname(__FILE__) . '/../../images/nota_venta_sup.png' , 13 , 10 , 120, 20, 'PNG', '', '', false, 300, '', 
  	            false, false, 0, false, false, false);

$pdf->Image(dirname(__FILE__) . '/../../images/nota_venta_ov_inf.png' , 13 , 247 , 190, 18, 'PNG', '', '', true, 300, '', 
	            false, false, 0, false, false, false);

$pdf->SetFont('Helvetica', '', 9, '', 'false');

$pdf->writeHTMLCell($w=0, $h=0, $x=173, $y=12 , "No. de nota", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);


$pdf->SetFont('Helvetica', '', 12, '', 'false');


$yy = 40;

$clave_sucursal = $this->Equiposmodel->get_clave_sucursal();
$pdf->SetFont('Helvetica', '', 14, '', 'false');

$pdf->writeHTMLCell($w=0, $h=0, $x=173, $y=16 , substr($clave_sucursal,0,2) . " " . $equipo['numero_remision'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->SetFont('Helvetica', '', 12, '', 'false');

$yy = $yy + 10;




$pdf->writeHTMLCell($w=0, $h=0, $x=15, $y=$yy , "Número de orden:", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=0, $h=0, $x=50, $y=$yy , $equipo['num_orden'], $border=0, $ln=1, $fill=0, $reseth=true, $align='L', $autopadding=true);

$pdf->writeHTMLCell($w=0, $h=0, $x=145, $y=$yy , "Fecha de entrega:", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=0, $h=0, $x=180, $y=$yy , $this->_cambiaf_a_normal($equipo['fecha_de_entrega']), $border=0, $ln=1, $fill=0, $reseth=true, $align='L', $autopadding=true);


$yy = $yy + 10;


$pdf->writeHTMLCell($w=215, $h=5, $x=0, $yy, "<b>Información del Cliente</b>"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='C', $autopadding=true);

$yy = $yy + 10;

$pdf->writeHTMLCell($w=40, $h=5, $x=20, $yy, "Nombre:"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=80, $h=5, $x=40, $yy, $cliente['nombre']  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=40, $h=5, $x=120, $yy, "Teléfono:"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=80, $h=5, $x=140, $yy, $cliente['telefono1']  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);


$yy = $yy + 7;

$pdf->writeHTMLCell($w=40, $h=5, $x=20, $yy, "Correo electrónico:"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->SetFont('Helvetica', '', 11, '', 'false');

$pdf->writeHTMLCell($w=80, $h=5, $x=60, $yy, $cliente['correo_electronico']  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->SetFont('Helvetica', '', 12, '', 'false');


$pdf->writeHTMLCell($w=40, $h=5, $x=120, $yy, "Móvil:"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=80, $h=5, $x=140, $yy, $cliente['telefono2']  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$yy = $yy + 10;



$pdf->writeHTMLCell($w=215, $h=5, $x=0, $yy, "<b>Información del Equipo</b>"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='C', $autopadding=true);

$yy = $yy + 7;
$yy1 = $yy;

$pdf->writeHTMLCell($w=40, $h=5, $x=20, $yy, "Dispositivo:"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=50, $h=5, $x=50, $yy, $equipo['descripcion_tipo']  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);


$pdf->writeHTMLCell($w=40, $h=5, $x=80, $yy, "Capacidad:"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=50, $h=5, $x=110, $yy, $equipo['capacidad']  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=40, $h=5, $x=140, $yy, "Color:"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=50, $h=5, $x=160, $yy, $equipo['color']  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$yy = $yy + 7;

$pdf->writeHTMLCell($w=40, $h=5, $x=20, $yy, "Num. serie:"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=50, $h=5, $x=44, $yy, $equipo['num_serie']  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);


$pdf->writeHTMLCell($w=40, $h=5, $x=80, $yy, "Versión de IOS:"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=50, $h=5, $x=110, $yy, $equipo['ios_version']  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=40, $h=5, $x=140, $yy, "Firmware modem:"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

if (substr($equipo['tipo'],0,5)=="iPhon")

   $pdf->writeHTMLCell($w=50, $h=5, $x=175, $yy, $equipo['iphone_firmware_modem']  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
else
   $pdf->writeHTMLCell($w=50, $h=5, $x=175, $yy, "No aplica" , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);



$yy = $yy + 7;

$pdf->writeHTMLCell($w=40, $h=5, $x=20, $yy, "IMEI:"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);



if (substr($equipo['tipo'],0,5)=="iPhon")

   $pdf->writeHTMLCell($w=50, $h=5, $x=30, $yy, $equipo['iphone_imei']  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
else

   $pdf->writeHTMLCell($w=50, $h=5, $x=30, $yy, "No aplica" , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);



$pdf->writeHTMLCell($w=40, $h=5, $x=80, $yy, "Operador:"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

if (substr($equipo['tipo'],0,5)=="iPhon")
    $pdf->writeHTMLCell($w=50, $h=5, $x=110, $yy, $equipo['operador']  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
else
   $pdf->writeHTMLCell($w=50, $h=5, $x=110, $yy, "No aplica" , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

//echo substr($equipo['tipo'],0,5); die();


$yy = $yy + 10;

$style = array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter',  'phase' => 10, 'color' => array(0, 0, 0));




$ddy = 10;


// COnseguir la fecha de entrega
/* $arrf = ( $this->db->query("select * from bitacoras where estatus='Entregado' and  equipo_id=" . $this->uri->segment(3)));
 if ($arrf->num_rows()>0) {
	    $serviciosf = ($arrf->result_array());
		$fecha = $this->_cambiaf_a_normal($serviciosf[0]['fecha']);
 }
 else $fecha = date("d/m/Y");




$pdf->writeHTMLCell($w=0, $h=0, $x=174 + $ddx, $y=31 + $ddy,  $fecha  , $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
*/


 $arr = ( $this->db->query('select * from servicios where equipo_id=' . $this->uri->segment(3)));
	    $servicios = ($arr->result_array());

 $linea = 0;
 $total = 0;

  $detalletipo = $this->Tiposclasesequiposmodel->get_detalle($equipo['tipo']);

  $pdf->Line(15, $yy+18, 200, $yy+18, $style);


  $linea = $linea + 1;

      $pdf->writeHTMLCell($w=0, $h=0, $x=16 + $ddx, $y=$yy + $ddy + $linea,"Cantidad", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
	 
      $pdf->writeHTMLCell($w=0, $h=0, $x=40 + $ddx, $y=$yy + $ddy + $linea, "Concepto", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
      $pdf->writeHTMLCell($w=0, $h=0, $x=150 + $ddx, $y=$yy + $ddy + $linea, "Precio unitario", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
      $pdf->writeHTMLCell($w=0, $h=0, $x=185 + $ddx, $y=$yy + $ddy + $linea, "Importe", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$linea = $linea + 7;

 foreach ($servicios as $servicio) {
      $pdf->writeHTMLCell($w=0, $h=0, $x=20 + $ddx, $y=$yy + $ddy + $linea,"1", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
	 
      $pdf->writeHTMLCell($w=0, $h=0, $x=40 + $ddx, $y=$yy + $ddy + $linea, $servicio['descripcion'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
       $pdf->writeHTMLCell($w=0, $h=0, $x=150 + $ddx, $y=$yy + $ddy + $linea, "$" . number_format($servicio['subtotal'], 2, '.', ','), $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

       $pdf->writeHTMLCell($w=0, $h=0, $x=185 + $ddx, $y=$yy + $ddy + $linea, "$" . number_format($servicio['subtotal'], 2, '.', ','), $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

	 $linea = $linea + 5; 
	 $total += $servicio['subtotal'];
 }



$pdf->Line(15, 178 + $ddy, 200, 178 + $ddy, $style);


       $pdf->writeHTMLCell($w=0, $h=0, $x=160 + $ddx, $y=180 + $ddy , "Total", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
 
       $pdf->writeHTMLCell($w=0, $h=0, $x=185 + $ddx, $y=180 + $ddy , "$" . number_format($total, 2, '.', ','), $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
 

       $pdf->writeHTMLCell($w=0, $h=0, $x=20 + $ddx, $y=180 + $ddy , "Forma de pago:", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
 
       $pdf->writeHTMLCell($w=0, $h=0, $x=58 + $ddx, $y=180 + $ddy , $equipo['forma_de_pago'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);



$pdf->writeHTMLCell($w=0, $h=0, $x=20, $y=190 + $ddy , "No. de Nota:", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=0, $h=0, $x=58, $y=190 + $ddy , $equipo['numero_remision'], $border=0, $ln=1, $fill=0, $reseth=true, $align='L', $autopadding=true);





$pdf->Output('Notavta-' . $equipo['num_orden'] . '.pdf', 'I'); 


}	  


  function exportarequipos() {
  	ini_set('memory_limit','32M');
    $this->load->model("Equiposmodel");
    $datos = $this->Equiposmodel->exportacion_datos($this->uri->segment(3),$this->uri->segment(4));
    $xls = "<html><head><style type='text/css'>"; 
    $xls .= "td {border:0.5px solid #000; vertical-align:top; font-size:9pt;} </style> ";
    $xls .= "</head><body>"; 

    $xls .= "<table>";

    $xls .= "<tr style='background-color:black;color:white;'>";
    	$xls .= "<td>Num. orden</td>";
    	$xls .= "<td>Estatus</td>";
    	
    	$xls .= "<td>Tipo</td>";
    	$xls .= "<td>Modelo</td>";
    	$xls .= "<td>No. serie</td>";
    	$xls .= "<td>Capacidad</td>";
    	$xls .= "<td>Software</td>";
    	$xls .= "<td>Fecha de recibido</td>";
    	$xls .= "<td>Hora de recibido</td>";
    	$xls .= "<td>Nombre del cliente</td>"; 
     	
  		
  		$xls .= "<td>Intentaron repararlo</td>"; 
  		$xls .= "<td>Estuvo en contacto con agua</td>"; 
  		$xls .= "<td>Descripción del problema</td>"; 
  		$xls .= "<td>Número de remisión</td>"; 
  		$xls .= "<td>Nota o factura</td>"; 
  		$xls .= "<td>Notas</td>"; 
  		
  		$xls .= "<td>Diagnóstico</td>"; 
  		$xls .= "<td>Situación</td>"; 
  		$xls .= "<td>Forma de pago</td>"; 
    	$xls .= "</tr>";    

    foreach ($datos as $k=>$v) {
    	$xls .= "<tr style='background-color:white;'>";
    	$xls .= "<td>" . $v['num_orden'] . "</td>";
    	$xls .= "<td>" . $v['estatus'] . "</td>";
    	
    	$xls .= "<td>" . $v['tipo'] . "</td>";
    	$xls .= "<td>" . $v['modelo'] . "</td>";
    	$xls .= "<td>" . $v['num_serie'] . "</td>";
    	$xls .= "<td>" . $v['capacidad'] . "</td>";
    	$xls .= "<td>" . $v['software'] . "</td>";
    	$xls .= "<td>" . $v['fecha_recibido'] . "</td>";
    	$xls .= "<td>" . $v['hora_recibido'] . "</td>";
    	$xls .= "<td>" . $v['nombre'] . "</td>"; 
     	
  		
  		$xls .= "<td>" . $v['intentaron_repararlo'] . "</td>"; 
  		$xls .= "<td>" . $v['en_contacto_con_agua_vap'] . "</td>"; 
  		$xls .= "<td>" . $v['descripcion_problema'] . "</td>"; 
  		$xls .= "<td>" . $v['numero_remision'] . "</td>"; 
  		$xls .= "<td>" . $v['nota_o_factura'] . "</td>"; 
  		$xls .= "<td>" . $v['notas'] . "</td>"; 
  	
  		$xls .= "<td>" . $v['diagnostico'] . "</td>"; 
  		$xls .= "<td>" . $v['situacion'] . "</td>"; 
  		$xls .= "<td>" . $v['forma_de_pago'] . "</td>"; 
    	$xls .= "</tr>";
    	if (count($v['servicios'])) {
    	  foreach ($v['servicios'] as $ks => $vs) {	
    		$xls .= "<tr style='background-color:#ccc;'>";
    		$xls .= "<td></td>";
    		$xls .= "<td>Servicio:</td>";
    		$xls .= "<td>" . $vs['descripcion'] . "</td>";
    		$xls .= "<td>Costo:</td>";
    		$xls .= "<td>" . $vs['costo'] . "</td>";
    		$xls .= "<td>Descuento:</td>";
    		$xls .= "<td>" . $vs['descuento'] . "</td>";
    		$xls .= "<td>Subtotal:</td>";
    		$xls .= "<td>" . $vs['subtotal'] . "</td>";


    		$xls .= "</tr>";
    	  }	

    	}
    }
    $xls .= "</table></body></html>";
    $this->output->set_content_type('application/vnd.ms-excel');
    $this->output->set_header("Content-Disposition: attachment; filename=ordenes_". $this->uri->segment(3) . "_" . $this->uri->segment(4) .".xls");
    $this->output->set_output($xls);
    
  }



}




/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */