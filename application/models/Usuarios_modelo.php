<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_modelo extends CI_Model
{
	
	function obtenerUsuarios($estatus){
		if ($estatus == 1 || $estatus == 0)
			$this->db->where('u.estatus',$estatus); 
		$this->db->select('u.id,u.nombre,p.nombre,u.estatus');
		$this->db->from('usuarios u');
		$this->db->join('perfiles p','u.id_perfil = p.id');
		return $this->db->get()->result();
	}

	function obtenerUsuariosEditar($id){
		$this->db->where('id', $id);
		return $this->db->get('usuarios')->row();
	}

	function agregarUsuarios($data){
		$this->db->insert("usuarios", $data);
		return ($this->db->affected_rows() > 0);
	}

	function cambiarEstatusUsuarios($id, $estatus){
		$this->db->where('id', $id);
		$this->db->set('estatus', $estatus);
		$this->db->update('usuarios');
		return ($this->db->affected_rows() > 0);
	}

	
}