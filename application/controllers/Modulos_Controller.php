<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modulos_Controller extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('modulo_modelo');
	}
    
    public function modulos()
    {
        $modulos = $this->modulo_modelo->obtenermodulos();
        echo $modulos;

    } 
}
