<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categorias_modelo extends CI_Model{

	function obtenerCategoriasPorEstado($estatus){
		if($estatus == 0 || $estatus == 1)
			$this->db->where('estado', $estatus);
		$resultado = $this->db->get('categorias')->result();
		return $resultado;
	}

	function obtenerCategoriasPorId($id){
		$this->db->where('id', $id);
		$resultado = $this->db->get('categorias')->result();
		return $resultado;
	}

	function cambiarEstatusCategoria($id, $estatus){
		$this->db->where('id', $id);
		$this->db->set('estado', $estatus);
		$this->db->update('categorias');
		return ($this->db->affected_rows() > 0);
	}
	
	function editarCategoria($id,$data){
		$this->db->where('descripcion', $data['descripcion']);
		$nomExiste = $this->db->get('categorias');
		if ($nomExiste->num_rows()>0) {
			return 2;
		}
		else {
			$this->db->where('id', $id);
			$this->db->update('categorias',$data);
			return ($this->db->affected_rows() > 0);
		}
	}

	function agregarCategoria($data){
		$this->db->where('descripcion', $data['descripcion']);
		$nomExiste = $this->db->get('categorias');
		if ($nomExiste->num_rows() > 0) {
			return 2;
		}
		else {
			$this->db->insert('categorias', $data);			
			return ($this->db->affected_rows() > 0);
		}
	}

}