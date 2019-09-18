<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CLogin extends CI_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->library(array('session'));  
		$this->load->model('mLogin');
        $this->load->model('Modulos_model');
    }
    
    public function index() {
        switch ($this->session->userdata('id_perfil')) {
            case '':
                $this->load->view('vLogin');
                break;
            case '1':
                redirect(base_url().'index.php/cAdministrador');
                break;
            case '2':
                redirect(base_url().'index.php/cLaboratorista');
                break;   
            case '3':
                redirect(base_url().'index.php/cProfesor');
                break;    
            case '4':
                redirect(base_url().'index.php/cAlumnos');
                break;
            case '5':
                redirect(base_url().'index.php/cDirector');
                break;         
            default:
                redirect(base_url().'index.php/vLogin');
                break;
        }
    }

    public function ingresar(){
        if($this->input->is_ajax_request()) {
            $usuario = $this->input->post("usuario");
            $contraseña = $this->input->post("contraseña");
            echo $this->mLogin->login($usuario,$contraseña);
        }
        else{
            show_404();
        }
    }

    public function salir(){
        $this->session->sess_destroy();//-destruye la sesion actual
        header('Location: '.base_url());
    }
	
}