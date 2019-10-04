<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lab_modelo extends CI_Model{

	function obtenerLaboratoriosPorEstado($estatus){
		if($estatus == 0 || $estatus == 1)
			$this->db->where('estado', $estatus);
		$resultado = $this->db->get('laboratorios')->result();
		return $resultado;
	}

	function obtenerLaboratoriosPorId($id){
		$this->db->where('id', $id);
		$resultado = $this->db->get('laboratorios')->result();
		return $resultado;
	}

	function cambiarEstatusLaboratorio($id, $estatus){
		$this->db->where('id', $id);
		$this->db->set('estado', $estatus);
		$this->db->update('laboratorios');
		return ($this->db->affected_rows() > 0);
	}
	
	function editarLaboratorio($id,$data){
		$this->db->where('descripcion', $data['nombre']);
		$nomExiste = $this->db->get('laboratorios');
		if ($nomExiste->num_rows()>0) {
			return 2;
		}
		else {
			$this->db->where('id', $id);
			$this->db->update('laboratorios',$data);
			return ($this->db->affected_rows() > 0);
		}
	}

	function agregarLaboratorio($data){
		$this->db->where('descripcion', $data['nombre']);
		$nomExiste = $this->db->get('laboratorios');
		if ($nomExiste->num_rows() > 0) {
			return 2;
		}
		else {
			$this->db->insert('laboratorios', $data);			
			return ($this->db->affected_rows() > 0);
		}
	}

}