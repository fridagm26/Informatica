<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Prestamos_modelo extends CI_Model {
	
	public function __construct() {
        parent::__construct();
        $this->load->database();
	}

	
	//ACABA VAN LAS FUNCIONES
	public function mostrarPrestamos(){
        return $this->db->get('prestamos')->result();
    }
}