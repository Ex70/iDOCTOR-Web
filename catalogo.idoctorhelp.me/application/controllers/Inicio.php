<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends CI_Controller {

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
		$this->load->view('inicio');
	}

	public function fecha() {
		echo date("Y-m-d H:i:s");
	}
	
    public function menu()
	{
		$this->load->view('inicio/top_single1');  
		$this->load->view('menu');
		$this->load->view('inicio/bottom1');  
	}	
	
    public function iniciar()
	{
		$this->load->view('inicio/top1');  
		$this->load->view('inicio/menuprincipal'); 
		$this->load->view('inicio/inicio');
		$this->load->view('inicio/bottom1'); 
	}	
	
	
    public function proceso()
	{
		$this->load->view('inicio/top1');  
		$this->load->view('inicio/menuprincipal'); 
		$this->load->view('inicio/proceso');
		$this->load->view('inicio/bottom1'); 
	}	
	
    public function servicios()
	{
		$this->load->view('inicio/top1');  
		$this->load->view('inicio/menuprincipal'); 
		$this->load->view('inicio/servicios');
		$this->load->view('inicio/bottom1'); 
	}	
	
    public function clientes()
	{
		$this->load->view('inicio/top1');  
		$this->load->view('inicio/menuprincipal'); 
		$this->load->view('inicio/clientes');
		$this->load->view('inicio/bottom1'); 
	}	
	
    public function sistema()
	{
		$this->load->view('inicio/top1');  
		$this->load->view('inicio/menuprincipal'); 
	    $this->load->view('inicio/sistema');
		$this->load->view('inicio/bottom1'); 
	}	
	
    public function administracion()
	{
		$this->load->view('inicio/top1');  
		$this->load->view('inicio/menuprincipal'); 
		$this->load->view('inicio/administracion');
		$this->load->view('inicio/bottom1'); 
	}	
	
	public function valida()
	{
        $arr =  $this->db->query("select * from usuarios where usuario='" . $_POST['usuario'] . "' and passwd='" . $_POST['passwd'] . "'");
	    $data = ($arr->result_array());


		if (count($data)>0) {
             $newdata = array(
                   'username'  => $_POST['usuario'],
                   'email'     => $data[0]['correo_electronico'],
				   'usuario_id'     => $data[0]['id'],
				   'usuario'     => $data[0]['usuario'],
				   'nivel'     => $data[0]['nivel'],
                   'logged_in' => TRUE
               );
             $this->session->set_userdata($newdata);	
              $registroacc = array( 
			                 "usuario" => $_POST['usuario'],
			                 "usuario_id" => $data[0]['id'],
			                 "fecha_hora" => date ("Y-m-d H:i:s"),
			                 "accion"  => "INGRESO",
			                 "tabla"   => "sistema",
			                 "detalle" => $_POST['usuario']);
		      $this->db->insert('registroacciones',$registroacc);		
			  redirect('inicio/iniciar');  
		}
		else redirect('/');
	}
	
	
	public function terminar() {
		$this->session->sess_destroy();
        $registroacc = array( 
			                 "usuario" => $this->session->userdata('usuario'),
			                 "usuario_id" => $this->session->userdata('usuario_id'),
			                 "fecha_hora" => date ("Y-m-d H:i:s"),
			                 "accion"  => "TERMINO SESION",
			                 "tabla"   => "sistema",
			                 "detalle" => $this->session->userdata('usuario'));
		      $this->db->insert('registroacciones',$registroacc);
		redirect('inicio/iniciar');
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */