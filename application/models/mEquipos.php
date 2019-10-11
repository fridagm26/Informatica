<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class MEquipos extends CI_Model {
	
	public function __construct() {
		parent::__construct();
    }
    
    public function getCategorias(){
        $categorias = $this->db->select('*')->from('categorias')->where('estado',1)->get();
        return $categorias->result();
   }

    function obtenerEquiposPorEstado($estatus){
        if($estatus == 0 || $estatus == 1)
            $this->db->where('estado', $estatus);
        $resultado = $this->db->get('equipo')->result();
        return $resultado;
    }

    function obtenerEquiposPorId($id){
		$this->db->where('id', $id);
		$resultado = $this->db->get('equipo')->result();
		return $resultado;
	}

    function cambiarEstatusEquipo($id, $estatus){
		$this->db->where('id', $id);
		$this->db->set('estado', $estatus);
		$this->db->update('equipo');
		return ($this->db->affected_rows() > 0);
	}

    function agregarEquipo($data){
        $this->db->insert('equipo', $data);			
        return ($this->db->affected_rows() > 0);
    }
    
    function editarEquipo($id,$data){
		$this->db->where('descripcion', $data['descripcion']);
		$nomExiste = $this->db->get('equipo');
		if ($nomExiste->num_rows()>0) {
			return 2;
		}
		else {
			$this->db->where('id', $id);
			$this->db->update('equipo',$data);
			return ($this->db->affected_rows() > 0);
		}
	}
}