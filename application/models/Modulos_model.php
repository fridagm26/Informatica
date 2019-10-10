<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Modulos_model extends CI_Model {
	
	public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array('ayuda_helper','url'));
	}

	
	//ACABA VAN LAS FUNCIONES
	public function obtenerModulos(){
        return $this->db->where('estatus',1)->get('modulos')->result();
        
    }

    public function modulosXPerfil($idPerfil){
        $query = $this->db->query("SELECT * , (SELECT 'si' FROM permisos WHERE permisos.`id_modulo` = modulos.id AND permisos.`id_perfil` = $idPerfil) tiene FROM modulos;");
        return $query->result();
    }
}