<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UsergamesModel extends MY_Model
{
	function getGamesList($search='',$searchstart='',$searchend='')
	{
		$this->db->select('r.jour, r.horaire, r.id as resaid, p.*, s.nom as nom_salle, a.id as agent_id');		
		$this->db->from('reservation r');
		$this->db->join('infos_partie p','p.id_resa = r.id');
		$this->db->join('salle s','s.id = r.id_salle');
		$this->db->join('agent a','a.id_partie = p.id','left');
		$criteres = "r.id != 0";
		if ($search != '') $criteres .= " AND (r.id LIKE '%".$search."%' OR p.id LIKE '%".$search."%' OR p.nom_equipe LIKE '%".$search."%' OR s.nom LIKE '%".$search."%' OR a.nom LIKE '%".$search."%'  OR a.prenom LIKE '%".$search."%' OR a.email LIKE '%".$search."%')";
		if ($searchstart != '') $criteres .= " AND r.jour >= '".$searchstart."'";
		if ($searchend != '') $criteres .= " AND r.jour <= '".$searchend."'";
		$this->db->where($criteres);
		$this->db->group_by("p.id");
		$this->db->order_by('r.jour DESC, horaire DESC');
		$this->db->limit('100');
		return $this->db->get()->result();
	}
	
	function getGame($resaId)
	{
		$this->db->select('r.jour, r.horaire, r.id as idresa, r.joueurs as resa_nbjoueurs, r.id_salle, p.*, c.email as email_client, c.nom as nom_client, c.prenom as prenom_client, s.nom as nom_salle, s.nbmax');		
		$this->db->from('reservation r');
		$this->db->join('infos_partie p','p.id_resa = r.id','left');
		$this->db->join('client c','c.id = r.id_client','left');
		$this->db->join('salle s','s.id = r.id_salle','left');
		$this->db->where('r.id = '.$resaId);
		$result = $this->db->get()->result();
		return $result[0];
	}
	
	function getRanking($idsalle, $temps)
	{
		$this->db->select('r.id as idresa, p.id');		
		$this->db->from('reservation r');
		$this->db->join('infos_partie p','p.id_resa = r.id');
		$this->db->where('r.id_salle = '.$idsalle);
		$this->db->where("p.tps_jeu < '".$temps."'");
		$this->db->where("p.tps_jeu != '00:00:00'");
		$result = $this->db->get()->result();
		$nb = count($result);
		return $nb+1;
	}
	
}