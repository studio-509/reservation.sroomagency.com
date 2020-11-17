<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StatsModel extends MY_Model
{
	function getHolidaysResas() {
		$this->db->select('r.jour, v.semaine, v.annee');		
		$this->db->from('vacances_scolaires v');
		$this->db->join('reservation r','v.annee = YEAR(r.jour) AND v.semaine = WEEK(r.jour)');
		$this->db->order_by('r.jour');
		return $this->db->get()->result();
		
	}
	function getHorlist()
	{
		$this->db->select('horaire as hor_start');		
		$this->db->from('reservation');		
		$this->db->order_by('horaire');
		$this->db->distinct();
		return $this->db->get()->result();	 	
	}
	function getAnneesList()
	{
		$this->db->select('YEAR(jour) as annee');		
		$this->db->from('reservation');		
		$this->db->distinct();
		return $this->db->get()->result();	 	
	}
	
	function getReussite($salle,$reussite,$percent,$joueurs) {
		$this->db->select('r.id_salle, r.joueurs, p.reussite');
		$this->db->from('infos_partie p');
		$this->db->join('reservation r','r.id = p.id_resa','left');
		if ($reussite !="") $this->db->where("p.reussite ='".$reussite."'");
		if ($salle !="") $this->db->where("r.id_salle ='".$salle."'");
		if ($joueurs !="") $this->db->where("r.joueurs ='".$joueurs."'");
		$result = $this->db->get()->result();
		$nbresult = count($result);
		$retour = $nbresult;
		
		if ($percent == 1) {
			$this->db->select('r.id_salle, r.joueurs, p.reussite');
			$this->db->from('infos_partie p');
			$this->db->join('reservation r','r.id = p.id_resa','left');
			if ($salle !="") $this->db->where("r.id_salle ='".$salle."'");
			if ($joueurs !="") $this->db->where("r.joueurs ='".$joueurs."'");
			$result2 = $this->db->get()->result();
			$nbresult2 = count($result2);
			$retour = strval(round($nbresult*100/$nbresult2));
		}
		return $retour;
			
	}
	
	function getComposition($salle,$joueurs,$percent) {
		$this->db->select('r.id_salle, r.joueurs, p.reussite');
		$this->db->from('infos_partie p');
		$this->db->join('reservation r','r.id = p.id_resa','left');
		if ($salle !="") $this->db->where("r.id_salle ='".$salle."'");
		if ($joueurs !="") $this->db->where("r.joueurs ='".$joueurs."'");
		$result = $this->db->get()->result();
		$nbresult = count($result);
		$retour = $nbresult;
		
		if ($percent == 1) {
			$this->db->select('r.id_salle, r.joueurs, p.reussite');
			$this->db->from('infos_partie p');
			$this->db->join('reservation r','r.id = p.id_resa','left');
			if ($salle !="") $this->db->where("r.id_salle ='".$salle."'");
			$result2 = $this->db->get()->result();
			$nbresult2 = count($result2);
			$retour = strval(round($nbresult*100/$nbresult2));
		}
		return $retour;
			
	}
	
	function getHoraires($salle,$horaire,$percent) {
		$this->db->select('id_salle, joueurs');
		$this->db->from('reservation');
		if ($salle !="") $this->db->where("id_salle ='".$salle."'");
		if ($horaire !="") $this->db->where("horaire ='".$horaire."'");
		$result = $this->db->get()->result();
		$nbresult = count($result);
		$retour = $nbresult;
		
		if ($percent == 1) {
			$this->db->select('id_salle, joueurs');
			$this->db->from('reservation');
			if ($salle !="") $this->db->where("id_salle ='".$salle."'");
			$result2 = $this->db->get()->result();
			$nbresult2 = count($result2);
			$retour = strval(round($nbresult*100/$nbresult2));
		}
		return $retour;
			
	}
	
	function getJoursSemaine($salle,$jour,$percent) {
		$this->db->select('id_salle, joueurs');
		$this->db->from('reservation');
		if ($salle !="") $this->db->where("id_salle ='".$salle."'");
		if ($jour !="") $this->db->where("WEEKDAY(jour) ='".$jour."'");
		$result = $this->db->get()->result();
		$nbresult = count($result);
		$retour = $nbresult;
		
		if ($percent == 1) {
			$this->db->select('id_salle, joueurs');
			$this->db->from('reservation');
			if ($salle !="") $this->db->where("id_salle ='".$salle."'");
			$result2 = $this->db->get()->result();
			$nbresult2 = count($result2);
			$retour = strval(round($nbresult*100/$nbresult2));
		}
		return $retour;
			
	}
	function getDelai($salle,$mini,$maxi,$percent) {
		$this->db->select('id_salle, joueurs');
		$this->db->from('reservation');
		if ($salle !="") $this->db->where("id_salle ='".$salle."'");
		if ($mini !="") $this->db->where("DATE(time_resa) <= DATE_SUB(jour,INTERVAL ".$mini." DAY)");
		if ($maxi !="") $this->db->where("DATE(time_resa) >= DATE_SUB(jour,INTERVAL ".$maxi." DAY)");
		$result = $this->db->get()->result();
		$nbresult = count($result);
		$retour = $nbresult;
		
		if ($percent == 1) {
			$this->db->select('id_salle, joueurs');
			$this->db->from('reservation');
			if ($salle !="") $this->db->where("id_salle ='".$salle."'");
			$result2 = $this->db->get()->result();
			$nbresult2 = count($result2);
			$retour = strval(round($nbresult*100/$nbresult2));
		}
		return $retour;
			
	}
	function getTopTen($salle)
	{
		$this->db->select('r.jour, r.horaire, r.id as resaid, p.*');		
		$this->db->from('reservation r');
		$this->db->join('infos_partie p','p.id_resa = r.id');
		$this->db->where("r.id_salle = '".$salle."'");
		$this->db->where("p.tps_jeu != '00:00:00'");
		$this->db->order_by('p.tps_jeu');
		$this->db->limit('10');
		return $this->db->get()->result();
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
	function getEcartMois($mois,$annee)
	{
		$this->db->select('DATEDIFF(jour,DATE(time_resa)) as dif');		
		$this->db->from('reservation');
		$this->db->where("MONTH(jour) = ".$mois."");
		$this->db->where("YEAR(jour) = ".$annee."");
		$result = $this->db->get()->result();
		$nb = count($result);
		foreach ($result as $r) {
			$total += $r->dif;
		}
		$average = round($total/$nb);
		return $average;
	}
	function getNbResasMois($mois,$annee,$salle)
	{
		$this->db->select('*');		
		$this->db->from('reservation');
		$this->db->where("id_client != 0");
		if ($salle !="") $this->db->where("id_salle = '".$salle."'");
		$this->db->where("MONTH(jour) = ".$mois."");
		$this->db->where("YEAR(jour) = ".$annee."");
		$result = $this->db->get()->result();
		$nb = count($result);
		return $nb;	 	
	}
	function getNbResasSemaine($semaine,$annee,$salle)
	{
		$this->db->select('*');		
		$this->db->from('reservation');
		$this->db->where("id_client != 0");
		if ($salle !="") $this->db->where("id_salle = '".$salle."'");
		$this->db->where("WEEK(jour,3) = ".$semaine."");
		$this->db->where("YEAR(jour) = ".$annee."");
		$result = $this->db->get()->result();
		$nb = count($result);
		return $nb;	 	
	}	
	function getJoursEtHoraires($jour,$horaire) {
		$this->db->select('id_salle, joueurs');
		$this->db->from('reservation');
		$this->db->where('id_client != 0');
		$this->db->where("WEEKDAY(jour) ='".$jour."'");
		$this->db->where("horaire ='".$horaire."'");
		$result = $this->db->get()->result();
		$nbresult = count($result);
		$retour = $nbresult;
		$this->db->select('id_salle, joueurs');
		$this->db->from('reservation');
		$this->db->where('id_client != 0');
		$result2 = $this->db->get()->result();
		$nbresult2 = count($result2);
		$retour = strval($nbresult*100/$nbresult2);
		return $retour;
			
	}
	function getJoursEtHorairesVacances($jour,$horaire,$periode) {
		$this->db->select('r.jour, v.semaine, v.annee');
		$this->db->from('vacances_scolaires v');
		if($periode == "vacances") $this->db->join('reservation r',"v.annee = DATE_FORMAT(r.jour, '%x') AND v.semaine = WEEK(r.jour, 3)");
		else $this->db->join('reservation r',"v.annee != DATE_FORMAT(r.jour, '%x') OR v.semaine != WEEK(r.jour, 3)");
		$this->db->where('r.id_client != 0');
		$this->db->where("WEEKDAY(r.jour) ='".$jour."'");
		$this->db->where("r.horaire ='".$horaire."'");
		$result = $this->db->get()->result();
		$nbresult = count($result);
		$retour = $nbresult;
		$this->db->select('r.jour, v.semaine, v.annee');
		$this->db->from('vacances_scolaires v');
		if($periode == "vacances") $this->db->join('reservation r',"v.annee = DATE_FORMAT(r.jour, '%x') AND v.semaine = WEEK(r.jour, 3)");
		else $this->db->join('reservation r',"v.annee != DATE_FORMAT(r.jour, '%x') OR v.semaine != WEEK(r.jour, 3)");
		$this->db->where('r.id_client != 0');
		$result2 = $this->db->get()->result();
		$nbresult2 = count($result2);
		$retour = strval($nbresult*100/$nbresult2);
		return $retour;
			
	}
	function getResasVacances()
	{
		$this->db->select('r.jour, v.semaine, v.annee');		
		$this->db->from('vacances_scolaires v');
		$this->db->join('reservation r',"v.annee = DATE_FORMAT(r.jour, '%x') AND v.semaine = WEEK(r.jour, 3)");
		$this->db->where('r.id_client != 0');
		$this->db->order_by('r.jour');
		return $this->db->get()->result(); 	
	}
	function getNbResaFromTo($dayFrom,$dayTo) 
	{
		$this->db->select('id');
		$this->db->from('reservation r');
		$this->db->where("r.jour BETWEEN '".$dayFrom."' AND '".$dayTo."'");
		$result2 = $this->db->get()->result();
		$nbresult2 = count($result2);
		return $nbresult2; 
	}
	
	function getCAFromTo($dayFrom,$dayTo) 
	{
		$this->db->select('SUM(prix) as sum');
		$this->db->from('reservation r');
		$this->db->where("r.jour BETWEEN '".$dayFrom."' AND '".$dayTo."'");
		$result = $this->db->get()->result();
		return $result[0]->sum; 
	}
	/**
	 * [rotateSet description] 
	 * @param  string $set_id id set à reset
	 * @param  string $salle  id salle
	 * @return [type]         [description]
	 */

}