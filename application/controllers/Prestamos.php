<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prestamos extends CI_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->model('Modulos_model');
        $this->load->model('Prestamos_modelo');

	}
	public function index()
	{
        $data['modulos'] = $this->Modulos_model->obtenerModulos();
        $data['prestamos'] = $this->Prestamos_modelo->mostrarPrestamos();
        $this->load->view('prestamos',$data);
    }
}    