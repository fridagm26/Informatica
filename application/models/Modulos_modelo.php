<?php

class Modulos_modelo extends CI_Model {
	
	public function __construct() {
        parent::__construct();
        $this->load->DataBase();
    }

    public function obtenermodulos(){
        return $this->db->where('estatus',1)->get('modulos')->result();
        
    }
}    