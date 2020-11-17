<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MessageModel extends MY_Model
{
	function getInfos($id)
	{
		$this->db->select('r.*, c.prenom, s.nom as scenario, s.description');
		$this->db->from('reservation r');
		$this->db->join('client c', 'c.id = r.id_client');
		$this->db->join('salle s', 's.id = r.id_salle');
		$this->db->where('r.id = ' . $id);
		$result = $this->db->get()->result();
		if(!empty($result))
			return $result[0];
	}

	function getVoucherInfos($id)
	{
		$this->db->select('v.*, c.*');
		$this->db->from('voucher v');
		$this->db->join('client c', 'c.id = v.id_client');
		$this->db->where('v.id = ' . $id);
		$result = $this->db->get()->result();
		if(!empty($result))
			return $result[0];
	}

}
