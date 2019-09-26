<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Perfiles_modelo extends CI_Model{

	function obtenerPerfilesPorEstado($estatus){
		if($estatus == 0 || $estatus == 1)
			$this->db->where('estatus', $estatus);
		$resultado = $this->db->get('perfiles')->result();
		return $resultado;
	}

	function obtenerPerfilesPorId($id){
		$this->db->where('id', $id);
		$resultado = $this->db->get('perfiles')->result();
		return $resultado;
	}

	function cambiarEstatusPerfil($id, $estatus){
		$this->db->where('id', $id);
		$this->db->set('estatus', $estatus);
		$this->db->update('perfiles');
		return ($this->db->affected_rows() > 0);
	}
	
	function editarPerfil($id,$data){
		$this->db->where('nombre', $data['nombre']);
		$nomExiste = $this->db->get('perfiles');
		if ($nomExiste->num_rows()>0) {
			return 2;
		}
		else {
			$this->db->where('id', $id);
			$this->db->update('perfiles',$data);
			return ($this->db->affected_rows() > 0);
		}
	}

	function agregarPerfil($data){
		$this->db->where('nombre', $data['nombre']);
		$nomExiste = $this->db->get('perfiles');
		if ($nomExiste->num_rows() > 0) {
			return 2;
		}
		else {
			$this->db->insert('perfiles', $data);			
			return ($this->db->affected_rows() > 0);
		}
	}

	// public function agregarModulo($data){
	//   	$this->db->insert('perfiles_modulos', $data);
    // 	return ($this->db->affected_rows() > 0);
	// }
	
	// public function eliminarModulo($id_perfil,$id_modulo){
	//   	$this->db->where('id_perfil',$id_perfil);
	// 	$this->db->where('id_modulo',$id_modulo);
	//   	$this->db->delete('perfiles_modulos');
    //   	return ($this->db->affected_rows() > 0);
	// }
}