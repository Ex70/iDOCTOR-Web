<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bitacoras extends CI_Controller {

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

	 
	public function index()
	{
		
		//$this->load->model('Clientes_model');
		//echo $this->Clientes_model->get_all_data();
		//echo $this->db->count_all('clientes');
		$arr = ( $this->db->query('select * from bitacoras'));
	    $data['result'] = ($arr->result_array());
		
		//$data['r0'] = array('1','2');
		//$data['heading'] = "My Real Heading";
		//print_r($data); die(); $this->load->view('inicio/top1'); 
		 $this->load->view('bitacoras/bitacorasindex',$data); 
		 $this->load->view('inicio/bottom1'); 
		 
		
	}
	
	public function agregar() { 
		$this->load->model('Bitacorasmodel');
		$this->load->model('Equiposmodel');
		$this->load->model('Catalogosmodel');
		$this->load->model('Clientesmodel');

		$registro = $this->Bitacorasmodel->get_campos();

        $equipo = $this->Equiposmodel->get_equipo($this->uri->segment(3));

		$registro['estatusactual'] = $equipo[0]['estatus'];
		$registro['clase'] = $equipo[0]['clase'];
       
	    $data = $this->Bitacorasmodel->get_ultima_bitacora_equipo($this->uri->segment(3));

	    $numservicios = $this->Equiposmodel->get_numero_servicios_equipo($this->uri->segment(3));


	    if ((($data[0]['estatus']=="Listo para entrega") && ($numservicios==0)) ||
	    	(($data[0]['estatus']=="Listo para entrega") && ($equipo[0]['diagnostico']=="")))

	     {
	     	$msg = "";
	     	if ($numservicios==0)
	     		$msg = "No se puede entregar: debes agregar al menos un servicio.";
	     	if ($equipo[0]['diagnostico']=="")
	     		$msg .= "<br>No se puede entregar: El t&eacute;cnico debe capturar un diagn&oacute;stico.";

	    	$data['mensaje'] = $msg;
	    	
		    $this->load->view('inicio/top_single1');
			$this->load->view('comun/mensajecerrartop',$data); 
			$this->load->view('inicio/bottom_single1');

	     }    

	     else {

	    if (count($data)==0) {
	        $dataestatus = $this->Bitacorasmodel->get_estatus_recibido();
			if (count($dataestatus)>0)
	    	    $registro['catestatus'] = $dataestatus;			
		}
		else { 
	         $dataestatus = $this->Bitacorasmodel->get_siguiente_estatus($data[0]['estatus']);

			 if ((count($dataestatus)>0) && ($data[0]['estatus']!="Proceso"))
		        $registro['catestatus'] = $dataestatus;
		     else
		     	$registro['catestatus'] = $this->Bitacorasmodel->get_siguiente_estatus_compat($data[0]['estatus']);
		}

		$registro['tipos'] = $this->Catalogosmodel->get_tipos_dropdown();
		
        $equipoarr = $this->Equiposmodel->get_equipo($this->uri->segment(3));
		$equipo = $equipoarr[0];
		
		$cliente = $this->Clientesmodel->get_detalle($equipo['cliente_id']);

		$registro['clase'] = $equipo['clase'];
		$registro['cliente'] = $cliente;
		$registro['equipo'] = $equipo;		
		
		$tip = array();		

		$this->load->view('inicio/top_single1');
		$this->load->view('bitacoras/detallebitacora',$registro); 
		$this->load->view('inicio/bottom_single1');

	  } // else
	}
	
	public function modificar() {
		$this->load->model('Bitacorasmodel');
		$this->load->model('Equiposmodel');
		$this->load->model('Clientesmodel');


	    $data = $this->Bitacorasmodel->get_detalle_bitacora($this->uri->segment(3));
		
		if (count($data)>0) {

		 
		$registro = $data[0];
		
        $equipoarr = $this->Equiposmodel->get_equipo($registro['equipo_id']);
		$equipo = $equipoarr[0];
		
		$cliente = $this->Clientesmodel->get_detalle($equipo['cliente_id']);
				
		$registro['cliente'] = $cliente;
		$registro['equipo'] = $equipo;	
		$registro['id'] = $this->uri->segment(3);	
		
		$dataestatus = $this->Bitacorasmodel->get_siguiente_estatus($registro['estatus']);
		$registro['catestatus'] = $dataestatus[0];
		
		$this->load->view('inicio/top_single1');
		$this->load->view('bitacoras/modificarbitacora',$registro); 
		$this->load->view('inicio/bottom_single1');
		}
		else // hubo algun error
		  {
		  	  $this->load->view('inicio/top_single1');
    	      $this->load->view('comun/cerrartop'); 
     	      $this->load->view('inicio/bottom_single1');	
		  }
		
	}

    public function guardarmodificacion() {
    	// realizado 3 de febrero de 2012
    // Solo administradores
      if ($this->session->userdata('nivel')==1) {	
    	unset($_POST['submit']);
		 $this->db->where('id', $_POST["id"]);
		 $this->db->update('bitacoras', $_POST);
	  } 
         $this->load->view('inicio/top_single1');
    	 $this->load->view('comun/cerrartop'); 
     	$this->load->view('inicio/bottom_single1');		
    }	
	
	public function eliminar() {
		$this->load->model('Registroaccionesmodel');
		$this->load->model('Bitacorasmodel');
		$this->load->model('Equiposmodel');
		 // SOLO ADMINISTRADORES
	  if ($this->session->userdata('nivel')==1) {	

        // REGISTRO DE ACCIONES
		$this->Registroaccionesmodel->registrar("ELIMINADO","bitacora","ID: " . $this->uri->segment(4) . " Equipo: " . $this->uri->segment(3));

        //$arrd = ( $this->db->query('delete from bitacoras where id=' . $this->uri->segment(4)));
        $equipo = $this->Equiposmodel->get_detalle_equipo($this->uri->segment(3));

        // VUELVE A PONER LOS PRECIOS DE LOS SERVICIOS
        if (($equipo['estatus']=='Reciclaje forzado') or ($equipo['estatus']=='Donado a reciclaje')) {
        	$this->Equiposmodel->reestablecer_servicios_sin_ceros($this->uri->segment(3));
        }

        $this->Bitacorasmodel->eliminar_bitacora($this->uri->segment(4));
		$this->Equiposmodel->cancelar_entrega($this->uri->segment(3));
		
	  } // IF DE SOLO ADMINISTRADORES
			
         $this->load->view('top_single');
	  	 $this->load->view('comun/cerrartop'); 
		 $this->load->view('inicio/bottom_single1');	
		
	}		
	
	
	
	public function guardar() {

        $this->load->model('Bitacorasmodel');	
        $this->load->model('Registroaccionesmodel');
        $this->load->model('Equiposmodel');
        $this->load->model('Clientesmodel');
        $this->load->model('Catalogosmodel');

		unset($_POST['submit']);
		$accion = $_POST['accion'];
		
//print_r($_POST); die();		
		$estatus_actual = $this->Equiposmodel->get_estatus_equipo($_POST['equipo_id']);
		//echo $estatus_actual; die();
        unset($_POST['accion']);
		unset($_POST['estatus_siguiente']);
		
		$ud = $this->session->all_userdata();
		$_POST['usuario_id'] = $ud['usuario_id'];
		
		
//-------  Se mand� estatus_id, hay que obtener el estatus y tambien el mensaje
		if ($estatus_actual!="Proceso")

		    $registroest = $this->Bitacorasmodel->get_estado( $_POST['estatus_id']);
		else 
			{
				 $arrest1 =  $this->db->query("select * from estados_compat where id=10");
				 $resultest1 = $arrest1->result_array();
				 $registroest = $resultest1[0];
				 //print_r($registroest); die();
			}
		
        //$arr1 =  $this->db->query("select id,estatus from bitacoras where equipo_id=" .  $_POST['equipo_id'] . " order by fecha desc, hora desc limit 1");
        $arr1 = $this->Bitacorasmodel->get_ultima_bitacora_equipo($_POST['equipo_id']); 	    		
		
	/*	if ($arr1->num_rows>0) 			
			$_POST['estatus'] = $registroest['siguiente_estatus'];  
		else*/
		    $_POST['estatus'] = $registroest['estatus'];

        $_POST['mensaje_para_fecha_adicional'] = $registroest['mensaje_para_fecha_adicional'];
		
//-------
		
		
	  if ($accion=="i") {
		// Poner fecha y hora de ahorita
		
         // REGISTRO DE ACCIONES
		$this->Registroaccionesmodel->registrar("NUEVO","bitacora", $_POST['estatus'] . " Equipo: " . $_POST['equipo_id']);    
			
		$_POST['fecha'] = date("Y-m-d");

     // PARA AJUSTAR HORARIO DE VERANO
//		       $timeInMinutes = time() - 60*60;
  //     $timenew = date("H:i:s",$timeInMinutes);


		$_POST['hora'] = date("H:i:s");

//		$_POST['hora'] = $timenew;

//		print_r($_POST); die();
		if ($estatus_actual!="Proceso")

		    $estado = $this->Bitacorasmodel->get_estado($_POST['estatus_id']);
		else $estado = 'Notificado Reparado';



		$_POST['proceso'] = $estado['proceso'];
		$_POST['ubicacion'] = $estado['ubicacion'];
		
		$this->db->insert('bitacoras',$_POST);

		
		$ultimaid = $this->db->insert_id();
		
        $this->Equiposmodel->sincronizar_estatus_con_bitacora($_POST['equipo_id']); 		   
		

        $this->load->view('inicio/top_single1');

        $ultimabitacora = $this->Bitacorasmodel->get_ultima_bitacora_equipo($_POST['equipo_id']);
        $registro = $ultimabitacora[0];
        //print_r($registro); die();
  
          if ($registro['estatus']=="Entregado") {

		    $cliente = $this->Clientesmodel->get_cliente_de_equipo($_POST['equipo_id']);
 
          	$dat = array();
			$dat['equipo_id'] =  $_POST['equipo_id'];
			$dat['cliente'] = $cliente;
			
	        $servicios = $this->Catalogosmodel->get_serviciosequipo( $_POST['equipo_id']);
	        $dat["servicios"] = $servicios;
			
			// AQUI ME QUEDE 28 AGO medio dia
		    $arr = $this->db->query('select diagnostico from equipos where id=' . $_POST['equipo_id']);
	        $equipo = ($arr->result_array());
	        $dat["equipo"] = $equipo[0];	

	        $checklistentrega = $this->Equiposmodel->array_checklist("ent");		
	        $dat['checklist'] = $checklistentrega;
						
			
		    $this->load->view('equipos/entrega',$dat);
		   // OJO!! MARCAR SITUACION A (C)ONCLUIDA
		    $this->Equiposmodel->concluir_orden_equipo();
		  }
		 else 
	  	   $this->load->view('comun/cerrartop'); 
	  	
	  	$estatus = $this->Equiposmodel->get_estatus_equipo($_POST['equipo_id']);

	    if (($estatus=="Donado a reciclaje") or ($estatus=="Reciclaje forzado"))  {
	  		$this->Equiposmodel->poner_servicios_en_cero($_POST['equipo_id']);
	  	} 

        
		$this->load->view('inicio/bottom_single1');		     	         
		}
		else {
	// Actualizar estatus en principal
        $this->Equiposmodel->sincronizar_estatus_con_bitacora($_POST['equipo_id'] );
			
	     $this->db->where('id', $_POST["id"]);
		 $this->db->update('bitacoras', $_POST);
         $this->load->view('top_single');

         $estatus = $this->Equiposmodel->get_estatus_equipo($_POST['equipo_id']);

         if ($estatus=="Entregado")
		   $this->load->view('equipos/entrega');
		 else 
	  	   $this->load->view('comun/cerrartop');
     	// Si el nuevo estatus es  Donado a reciclaje o Reciclaje forzado
	  	if (($estatus=="Donado a reciclaje") or ($estatus=="Reciclaje forzado"))  {
	  		$this->Equiposmodel->poner_servicios_en_cero($_POST['equipo_id']);
	  	} 

	  	 $this->load->view('inicio/bottom_single1');	
		 
		}
		
		
	}	
	
	public function guardarmodificaciones() {
		unset($_POST['submit']);
		$this->db->insert('bitacoras',$_POST);
		redirect('/bitacoras/index');
	}	
	
	public function obtenermensajedeestatusjson() 
	{
		  $arr =  $this->db->query("select mensaje_para_fecha_adicional from estados where id=" . $this->uri->segment(3) . " limit 1");
	      $data = ($arr->result_array()); 
		
		
		$mensaje = "";
		if ($arr->num_rows>0) {
			$registro = $data[0];
			$data['mensaje'] = $registro['mensaje_para_fecha_adicional'];
			
			
		}
		$this->load->view('bitacoras/mensajedeestatusjson',$data);
	 }
	
	
}

