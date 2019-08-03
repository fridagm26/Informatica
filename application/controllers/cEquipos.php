<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cEquipos extends CI_Controller {

	public function __construct(){
		parent::__construct();
        $this->load->model('mEquipos');
        $this->load->model('Modulos_model');

	}
	public function index(){
        $data['modulos'] = $this->Modulos_model->obtenerModulos();
        $this->load->view('vEquipos', $data);
    }
    


}