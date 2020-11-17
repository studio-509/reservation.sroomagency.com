<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CronModel extends MY_Model
{
	function getGameList($date)
	{
		$this->db->select('r.*, c.civil, c.nom, c.prenom, c.email');
		$this->db->from('reservation r');
		$this->db->join('client c','c.id = r.id_client');
		$this->db->where(array('r.jour' => $date));
		$result = $this->db->get()->result();

		return $result;
	}
}
