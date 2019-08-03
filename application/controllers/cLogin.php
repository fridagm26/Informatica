<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CLogin extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('mLogin');

	}
	public function index(){
    $this->load->view('vLogin');
	}
	
	public function ingresar(){
		$usu = $this->input->post('txtUsuario');
		$contra = $this->input->post('txtContraseña');

		$result = $this->mLogin->ingresar($usu,$contra);

		if ($result == 1) {
				$data['datosUsuario'] = $this->session->userdata("DatosUsuarios");
				$this->load->view('inicio', $data);
		} else {
				$this->load->view('vLogin');
		}
	}
}