<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TarifsModel extends MY_Model
{
	function getTarifList()
	{
		$this->db->select('t.*, s.nom');
		$this->db->from('tarif t');
		$this->db->join('salle s','s.id = t.salle');
			
		return $this->db->get()->result();
	}
	
}