<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ReservationModel extends MY_Model
{
	function getListByDate($salle, $start_search, $end_search)
	{
		$this->db->select('jour, horaire, valide, id_client');
		$this->db->from('reservation');
		$this->db->where('jour BETWEEN "'. $start_search . '" AND "' . $end_search . '" AND id_salle = ' . $salle);
		$this->db->order_by('jour','DESC');
		return $this->db->get()->result();
	}
	
	function getIndispoListByDate($salle, $start_search, $end_search)
	{
		$this->db->select('jour, horaire');
		$this->db->from('indispos');
		$this->db->where('jour BETWEEN "'. $start_search . '" AND "' . $end_search . '" AND id_salle = ' . $salle);
		$this->db->order_by('jour','DESC');
		return $this->db->get()->result();
	}
	
 	function getAllRoomsListByDate($start_search, $end_search)
	{
		$this->db->select('jour, horaire');
		$this->db->from('reservation');
		$this->db->where('id_client <> 0 AND jour BETWEEN "'. $start_search . '" AND "' . $end_search . '"');
		$this->db->order_by('jour','DESC');
		return $this->db->get()->result();
	} 
	
	function getHoraireSet($salle,$start_search,$end_search){
		$data = [];
		$this->db->select('')
				 ->from('salle__horaire_set')
				 ->where('set_date_begin <= "'.$start_search.'"  AND fk_salle_id = '.$salle.' AND set_state = 1')
				 ->order_by('set_date_begin DESC')
				 ->limit(1);
		$set =  $this->db->get()->result();
		$this->db->select('')->from('horaire')->where('fk_set_id = '.$set[0]->set_id)->order_by('hor_start');
		$data['set'] = $this->db->get()->result();
		return $data;
	}


	function getReservationList($limit = '')
	{
		$this->db->select('r.*, c.civil, c.nom, c.prenom, c.email, c.tel');
		$this->db->from('reservation r');
		$this->db->join('client c','c.id = r.id_client');
		$this->db->where('c.id != 0');
		$this->db->order_by('r.jour DESC, horaire DESC');
		if ( $limit != '')
		{
			$this->db->limit($limit[0],$limit[1]);
		}
		return $this->db->get()->result();
	}
	function getReservationListSearch($search='',$searchstart='',$searchend='')
	{
		$this->db->select('r.*, c.civil, c.nom, c.prenom, c.email, c.tel');
		$this->db->from('reservation r');
		$this->db->join('client c','c.id = r.id_client');
		$criteres = "c.id != 0";
		if ($search != '') $criteres .= " AND (r.id LIKE '%".$search."%' OR r.scenario LIKE '%".$search."%' OR r.jour LIKE '%".$search."%' OR c.nom LIKE '%".$search."%' OR c.prenom LIKE '%".$search."%' OR c.tel LIKE '%".$search."%' OR c.email LIKE '%".$search."%')";
		if ($searchstart != '') $criteres .= " AND r.jour >= '".$searchstart."'";
		if ($searchend != '') $criteres .= " AND r.jour <= '".$searchend."'";
		$this->db->where($criteres);
		$this->db->order_by('r.jour DESC, horaire DESC');
		$this->db->limit('100');
		return $this->db->get()->result();
	}
	function getIndispoList($limit = '')
	{
		$this->db->select('i.*');
		$this->db->from('indispos i');
		$this->db->order_by('i.jour DESC, horaire DESC');
		if ( $limit != '')
		{
			$this->db->limit($limit[0],$limit[1]);
		}
		return $this->db->get()->result();
	}
	function getClientByOrder($id)
	{
		$this->db->select('c.*');
		$this->db->from('client c');
		$this->db->join('reservation r','c.id = r.id_client');
		$this->db->where(array('r.id' => $id));
		$result = $this->db->get()->result();
		if(!empty($result))
			return $result[0];
	}
	function get_active_promo()
	{
		$this->db->select('*');
		$this->db->from('promo');
		$this->db->where([
			'date_debut <=' => date('Ymd'),
			'date_fin >=' => date('Ymd')
		]);
		$result = $this->db->get()->result();
		if(empty($result))
		{
			return FALSE;
		}
		return $result;
	}
}
