<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Perfil_modelo extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->DataBase();
	}

	
	//ACABA VAN LAS FUNCIONES
    public function obtenermodulos()
    {
        return $this->db->where('estatus',1)->get('modulos')->result();
    }
}