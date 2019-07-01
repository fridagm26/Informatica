<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Modulos_model extends CI_Model {
	
	public function __construct() {
        parent::__construct();
        $this->load->database();
	}

	
	//ACABA VAN LAS FUNCIONES
	public function obtenerModulos(){
        return $this->db->where('estatus',1)->get('modulos')->result();
        
    }
}