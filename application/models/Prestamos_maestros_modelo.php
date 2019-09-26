<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Prestamos_maestros_modelo extends CI_Model {
	
	public function __construct() {
        parent::__construct();
        $this->load->database();
	}

	
	//ACABA VAN LAS FUNCIONES
	public function mostrarPrestamos(){
                return $this->db->get('prestamos')->result();    
        }
        public function mostrarMateriales(){
                return $this->db->get('materiales')->result();    
        }
        public function mostrarDetallesP(){
                return $this->db->get('detalle_prestamo')->result();    
        }
        public function mostrarCategorias(){
            return $this->db->get('categorias')->result();    
        }
        public function getEquipoId($id){
            $cat = $this->db->select('*')->from('equipo')->where('estado', 1)->where('id', $id)->get();
            return $cat;
        }
}