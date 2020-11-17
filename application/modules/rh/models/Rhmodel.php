<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rhmodel extends MY_Model
{
	function getTarifList()
	{
		$this->db->select('t.*, s.nom');
		$this->db->from('tarif t');
		$this->db->join('salle s','s.id = t.salle');
			
		return $this->db->get()->result();
	}
	function isPlanningExcep($idstaff,$startdayformat)
	{
		$this->db->select('id, date');
		$this->db->from('staff_planning_set');
		$this->db->where('id_staff = "'.$idstaff.'" AND date = "'.$startdayformat.'" AND type = "excep"');
		
		return $this->db->get()->result();
	}
	function isPlanningRecur($idstaff,$startdayformat)
	{
		$date = new DateTime($startdayformat);
		$weeknb = $date->format('W');
		$parite = $weeknb%2;
		
		$this->db->select('id, date');
		$this->db->from('staff_planning_set');
		$this->db->where('id_staff = "'.$idstaff.'" AND date <= "'.$startdayformat.'" AND parite = "'.$parite.'" AND type = "recur"');
		$this->db->order_by('date DESC');
		$this->db->limit(1);
		
		return $this->db->get()->result();
	}
	function isPlanningPerm($idstaff,$startdayformat)
	{
		$this->db->select('id, date');
		$this->db->from('staff_planning_set');
		$this->db->where('id_staff = "'.$idstaff.'" AND date <= "'.$startdayformat.'" AND type = "perm"');
		$this->db->order_by('date DESC');
		$this->db->limit(1);
		
		return $this->db->get()->result();
	}
	function getWeeksHours($idstaff) {
		$this->db->select("WEEK(s.date,3) AS semaine, SEC_TO_TIME(SUM(TIME_TO_SEC(SUBTIME(CAST(REPLACE(p.heure_fin, 'h', ':') AS time) , CAST(REPLACE(p.heure_debut, 'h',':') AS time))))) AS somme FROM staff_planning_set s INNER JOIN staff_planning p ON s.id = p.id_set WHERE s.id_staff = ".$idstaff." AND WEEK(s.date,3) > 12 GROUP BY s.date ORDER BY s.id_staff, s.date", FALSE);
		
		return $this->db->get()->result();
	}
	/* function getPlanningExcep($idstaff,$jour,$heure)
	{
		$date = new DateTime($jour);
		$day = $date->format('Y-m-d');
		$weekday = $date->format('N');
		$weekdaydif = $weekday - 1;
		$interval = new DateInterval("P".$weekdaydif."D");
		$startday = date_sub($date, $interval);
		$startdayformat = $startday->format('Y-m-d');
		
		$this->db->select('p.id');
		$this->db->from('staff_planning p');
		$this->db->join('staff_planning_set s','s.id = p.id_set');
		$this->db->where('s.id_staff = "'.$idstaff.'" AND s.date = "'.$startdayformat.'" AND s.type = "excep" AND p.jour = "'.$weekday.'" AND p.heure_debut <= "'.$heure.'" AND p.heure_fin > "'.$heure.'"');
		$this->db->order_by('date DESC');
		$this->db->limit(1);
			
		return $this->db->get()->result();
	} */
	
}