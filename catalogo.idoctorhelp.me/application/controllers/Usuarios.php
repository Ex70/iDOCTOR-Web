<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	 
	public function index()
	{


        $this->load->model("Usuariosmodel");

	    $data['result'] = $this->Usuariosmodel->get_lista_usuarios();
		
		$data['titulo'] = "Control de usuarios";
		
	
		 $this->load->view('inicio/top1'); 
		 $this->load->view('usuarios/listausuarios',$data); 
		 $this->load->view('inicio/bottom1'); 
		
	}
	
	public function agregar() {
		$this->load->model("Usuariosmodel");
		$registro = $this->Usuariosmodel->get_campos();; 
		$niveles = $this->Usuariosmodel->get_niveles();
		$registro['niveles'] = $this->Usuariosmodel->get_niveles();
		$registro['titulo'] = "Agregar un usuario";
		$registro['sucursales'] = $this->Usuariosmodel->get_usuarios_de_sucursal();

		$this->load->view('inicio/top1');

		$this->load->view('usuarios/detalleusuario',$registro); 
		$this->load->view('inicio/bottom1');
		
	}
	
	public function modificar() {
        $this->load->model("Usuariosmodel");
        $registro = $this->Usuariosmodel->get_detalle_usuario($this->uri->segment(3));
		
		$niveles = $this->Usuariosmodel->get_niveles();
		$registro['niveles'] = $this->Usuariosmodel->get_niveles(); 
		$registro['es_super_administrador'] = $this->Usuariosmodel->es_super_administrador($this->uri->segment(3));
	    $registro['titulo'] = "Modificar usuario";
		$this->load->view('inicio/top1');
	
		$this->load->view('usuarios/detalleusuario',$registro); 
		$this->load->view('inicio/bottom1');
		
	}	
	
	public function convertirensuperadmin() {
 		if ($this->session->userdata('session_id')===FALSE) 
      		    die();
 		if ($this->session->userdata('username')=="")
      			die();

		$this->load->model("Usuariosmodel");
		$this->Usuariosmodel->crear_super_administrador($this->uri->segment(3));
		redirect("usuarios/modificar/" . $this->uri->segment(3));
	}

	public function quitarsuperadmin() {
 		if ($this->session->userdata('session_id')===FALSE) 
      		    die();
 		if ($this->session->userdata('username')=="")
      			die();

		$this->load->model("Usuariosmodel");
		$this->Usuariosmodel->quitar_super_administrador($this->uri->segment(3));
		redirect("usuarios/modificar/" . $this->uri->segment(3));
	}	
	
	public function guardar() {
		$this->load->model("Usuariosmodel");
	   $this->Usuariosmodel->guardar($_POST);
	   redirect("usuarios");
	}


	public function eliminar() {

      $this->load->model("Usuariosmodel");
      $this->Usuariosmodel->eliminar($this->uri->segment(3));
	}



   public function cambiarmipasswd() {

        $this->load->view('inicio/top1');	
		$this->load->view('usuarios/cambiarmipasswd'); 
		$this->load->view('inicio/bottom1');
   }
   
   public function guardarcambiopasswd() {
   	   $this->load->model("Usuariosmodel");
   	   $usuario = ($this->session->userdata('usuario'));
	   $id = ($this->session->userdata('usuario_id'));
			
		$registro = $this->Usuariosmodel->get_detalle($id);
		if ($_POST['passwd_actual']==$registro['passwd']) {
			if ($_POST['passwd1']==$_POST['passwd2']) {
				$this->Usuariosmodel->cambiar_password($usuario,$_POST['passwd1']);
			     $this->load->view('inicio/top1');	
		$this->load->view('comun/mensaje',array("mensaje"=>"La contraseña fue cambiada satisfactoriamente.","url"=>"/index.php/equipos/listado/index")); 
		$this->load->view('inicio/bottom1');
			}
          else {
          	 $this->load->view('inicio/top1');	
		     $this->load->view('comun/mensaje',array("mensaje"=>"Contraseñas no coinciden.","url"=>"/index.php/usuarios/cambiarmipasswd")); 
		     $this->load->view('inicio/bottom1');
			 
           	 
          }	
		}
       else {
         	  $this->load->view('inicio/top1');	
		$this->load->view('comun/mensaje',array("mensaje"=>"Contraseña actual incorrecta.","url"=>"/index.php/usuarios/cambiarmipasswd")); 
		$this->load->view('inicio/bottom1');
       	
       }
	   
     }
   
	
}

