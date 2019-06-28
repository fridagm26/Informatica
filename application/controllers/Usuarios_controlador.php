<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_controlador extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->model('Usuario_modelo');
		$this->load->model('modulo_modelo');
	}
    
    public function index()
	{
		$data['modulos'] = $this->modulo_modelo->obtenermodulos();
		$this->load->view('Usuarios',$data);
	}
}