<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class MMateriales extends CI_Model {
	
	public function __construct() {
		parent::__construct();
    }
    
    public function getCategorias(){
        $categorias = $this->db->select('*')->from('categorias')->where('estado',1)->get();
        return $categorias->result();
   }

    function obtenerMaterialesPorEstado($estatus){
        if($estatus == 0 || $estatus == 1)
            $this->db->where('estado', $estatus);
        $resultado = $this->db->get('materiales')->result();
        return $resultado;
    }

    function obtenerMaterialesPorId($id){
		$this->db->where('id', $id);
		$resultado = $this->db->get('materiales')->result();
		return $resultado;
	}

    function cambiarEstatusMaterial($id, $estatus){
		$this->db->where('id', $id);
		$this->db->set('estado', $estatus);
		$this->db->update('materiales');
		return ($this->db->affected_rows() > 0);
	}

    function agregarMaterial($data){
        $this->db->insert('materiales', $data);			
        return ($this->db->affected_rows() > 0);
    }
    
    function editarMaterial($id, $data){
		$this->db->where("id",$id);
		$this->db->update("materiales", $data);
		return ($this->db->affected_rows() > 0);
	}
}