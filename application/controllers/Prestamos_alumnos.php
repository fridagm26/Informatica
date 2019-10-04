<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prestamos_alumnos extends CI_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->model('Modulos_model');
        $this->load->model('Prestamos_alumnos_modelo');
        $this->load->model('mMateriales');
        
	}
	public function index(){
        $data['modulos'] = $this->Modulos_model->obtenerModulos();
        $data['prestamos'] = $this->Prestamos_alumnos_modelo->mostrarPrestamos();
        $data['materiales'] = $this->Prestamos_alumnos_modelo->mostrarMateriales();
        $data['detalle_prestamo'] = $this->Prestamos_alumnos_modelo->mostrarDetallesP();
        $this->load->view('Alumnos/prestamos_alumnos',$data);
    }
}    