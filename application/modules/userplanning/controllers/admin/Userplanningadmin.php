<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Userplanningadmin extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Userplanningmodel');
		/**
		* css du module
		**/
		$this->data['module_css'] = load_module_css($this->data['module_css'], 'userplanning');
		/**
		* js du module
		**/
		$this->data['module_js'] = load_module_js($this->data['module_js'],'userplanning');
	}
	public function listing()
	{
		$this->data['liste'] = $this->get_list_personnel();
		$this->data['planning'] = $this->get_planning_list();
		$this->data['globalplanning'] = $this->get_global_planning();
/* 		$this->data['offperiod'] = $this->get_off_period();
		$this->data['extraperiod'] = $this->get_extra_period(); */
		$vue = $this->load->view('/admin/listing', $this->data, TRUE);
		return $vue;
	}
	public function get_list_personnel()
	{
		$data['stafflist'] = $this->Userplanningmodel->getList('staff');
		$data['salles'] = $this->Userplanningmodel->getList('salle');
		if($this->is_ajax())
		{
			$vue = $this->load->view('/admin/staffList', $data);
			echo $vue;
		}
		else
		{
			$vue = $this->load->view('/admin/staffList', $data, TRUE);
			return $vue;
		}
	}
	public function get_planning_list()
	{
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$staffselid = ($data['staffselected'])?$data['staffselected']:1;
		$data['staffselinfos'] = $this->Userplanningmodel->getData('staff',['id' => $staffselid ]);
		$data['stafflist'] = $this->Userplanningmodel->getList('staff');
		$data['staffplanning'] = $this->Userplanningmodel->getList('staff_planning');
		$data['staffplanningset'] = $this->Userplanningmodel->getList('staff_planning_set');
		if($this->is_ajax())
		{
			$vue = $this->load->view('/admin/staffPlanningList', $data);
			echo $vue;
		}
		else
		{
			$vue = $this->load->view('/admin/staffPlanningList', $data, TRUE);
			return $vue;
		}
	}
	public function load_planning_form()
	{
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$setid = $data['id'];
		$data['staffplanset'] = $this->Userplanningmodel->getData('staff_planning_set',['id' => $setid ]);
		//$data['staffset'] = $this->Userplanningmodel->getData('staff_planning_set',['id' => $setid ]);
		$data['staffplanning'] = $this->Userplanningmodel->getList('staff_planning',['id_set' => $data['id']]);
		$staffid = $data['staffset']->id_staff;
		$data['staffselinfos'] = $this->Userplanningmodel->getData('staff',['id' => $staffid ]);
		$vue = $this->load->view('/admin/staffPlanning', $data, TRUE);
		$datas = [
		'rPop' => $vue,
		'rPopTitle' => $data['titre'],
		'rPopClass' => (isset($data['class']))?$data['class']:''
		];
		echo json_encode($datas);

	}
	public function get_global_planning()
	{
		$day = (date('N') - 1);
		$diff = $day * 86400;
		$this->data['start'] = (time() - $diff);
		
		
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		
		$this->data['start'] = isset($data['start'])?$data['start']:$this->data['start'];
		if(strpos($this->data['start'],'-') !== FALSE){
				$this->data['start'] = strtotime($this->data['start']);
		}
		$this->data['current'] = (new DateTime())->format('H:i');
		$this->data['week'] = (time() - $diff);
		$this->data['prev'] = $this->data['start'] - 604800;
		$this->data['next'] = $this->data['start'] + 604800;
		if($day == -1){
			$this->data['start'] = $this->data['start'] - 604800;
		}
		$this->data['stafflist'] = $this->Userplanningmodel->getList('staff',array ('id_connect' => $this->session->userdata('id_admin')));
		$this->data['nbstaff'] = count($this->data['stafflist']);
		$startdayformat = date('Y-m-d',$this->data['start']);
		foreach ($this->data['stafflist'] as $staff) {
			
			$excepplanset = $this->Userplanningmodel->isPlanningExcep($staff->id,$startdayformat);	
			$recurplanset = $this->Userplanningmodel->isPlanningRecur($staff->id,$startdayformat);
			$permplanset = $this->Userplanningmodel->isPlanningPerm($staff->id,$startdayformat);
			
			if ($excepplanset) {
				$this->data['planningok'][$staff->id] = $this->Userplanningmodel->getList('staff_planning', array('id_set' => $excepplanset[0]->id));
			}
			else if ($recurplanset) {
				$this->data['planningok'][$staff->id] = $this->Userplanningmodel->getList('staff_planning', array('id_set' => $recurplanset[0]->id));
			}
			else if ($permplanset) {
				$this->data['planningok'][$staff->id] = $this->Userplanningmodel->getList('staff_planning', array('id_set' => $permplanset[0]->id));
			}
			else $this->data['planningok'][$staff->id] = 0;
		}
			
		if($this->is_ajax())
		{
			$vue = $this->load->view('/admin/staffGlobalPlanning', $this->data);
			echo $vue;
		}
		else
		{
			$vue = $this->load->view('/admin/staffGlobalPlanning', $this->data, TRUE);
			return $vue;
		}
	}
	public function get_off_period()
	{
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$staffselid = ($data['staffselected'])?$data['staffselected']:1;
		$data['staffselinfos'] = $this->Userplanningmodel->getData('staff',['id' => $staffselid ]);
		$data['staffoff'] = $this->Userplanningmodel->getList('staff_off_period',['id_staff' => $staffselid ]);
		$data['stafflist'] = $this->Userplanningmodel->getList('staff');
		if($this->is_ajax())
		{
			$vue = $this->load->view('/admin/staffOff', $data);
			echo $vue;
		}
		else
		{
			$vue = $this->load->view('/admin/staffOff', $data, TRUE);
			return $vue;
		}
	}
	public function get_extra_period()
	{
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$staffselid = ($data['staffselected'])?$data['staffselected']:1;
		$data['staffselinfos'] = $this->Userplanningmodel->getData('staff',['id' => $staffselid ]);
		$data['staffextra'] = $this->Userplanningmodel->getList('staff_extra_period',['id_staff' => $staffselid ]);
		$data['stafflist'] = $this->Userplanningmodel->getList('staff');
		if($this->is_ajax())
		{
			$vue = $this->load->view('/admin/staffExtra', $data);
			echo $vue;
		}
		else
		{
			$vue = $this->load->view('/admin/staffExtra', $data, TRUE);
			return $vue;
		}
	}
	public function load_staff_form()
	{
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		if ($data['id'] != '') $data['staffmodifinfos'] = $this->Userplanningmodel->getData('staff',['id' => $data['id']]);
		$data['salles'] = $this->Userplanningmodel->getList('salle');
		$vue = $this->load->view('/admin/staffForm', $data, true);
		$datas = [
		'rPop' => $vue,
		'rPopTitle' => $data['titre'],
		'rPopClass' => (isset($data['class']))?$data['class']:''
		];
		echo json_encode($datas);
	}
	public function update()
	{
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$datas = [
				'nom' => $data['nom'],
				'prenom' => $data['prenom'],
				'adresse' => $data['adresse'],
				'tel' => $data['tel'],
				'secu' => $data['secu'],
				'competences' => $data['competences'],
				'gm' => $data['gm'],
				'gm_prio' => $data['gm_prio'],
				'rst' => $data['rst'],
				'rst_prio' => $data['rst_prio'],
				'color' => $data['color']
		];
		
		if($data['id'] != ''){			 
			$result = $this->Userplanningmodel->updateData('staff', $datas, array('id' => $data['id']));
		}
		else{
			$result = $this->Userplanningmodel->setData('staff', $datas);
		}
		unset($datas);
		if($result)
		{
			$txt = ($data['id'] != '')?'Mise à jour effectuée avec succès':'Collaborateur ajouté avec succès';
			$class = 'success';
		}
		else
		{
			$txt = ($data['id'] != '')?'Erreur lors de la mise à jour':'Erreur lors de l\'ajout du collaborateur';
			$class = 'alerte';
		}
		
		$vue = $this->load->view('/admin/staffForm', $data, TRUE);
		
		$datas = array(
			'rPop' => $txt,
			'rPopTitle' => $data['titre'],
			'rPopClass' => $class,
			'data' => $data
		);
		echo json_encode($datas); 
	}
	
	public function updatePlanning()
	{
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		
		$datas = [
				'type' => $data['type'],
				'id_staff' => $data['id_staff'],
				'parite' => $data['parite'],
				'date' => $data['date']
		];
		
		if($data['id'] != ''){			 
			$result = $this->Userplanningmodel->updateData('staff_planning_set', $datas, array('id' => $data['id']));
			$result2 = $this->Userplanningmodel->deleteData('staff_planning', array('id_set' => $data['id']));
		}
		else{
			$result = $this->Userplanningmodel->setData('staff_planning_set', $datas,TRUE);
			$result2 = true;
		}
		unset($datas);
		
		$plageinfos = explode('||', $data['infosplanning']);
		foreach ($plageinfos as $pi) {
			if ($pi != '') {
				$piinfos = explode('|',$pi);
				$datas = [
					'jour' => $piinfos[0],
					'heure_debut' => $piinfos[1],
					'heure_fin' => $piinfos[2]
				];
				$datas['id_set'] = ($data['id'] != '')?$data['id']:$result;
				$result3 = $this->Userplanningmodel->setData('staff_planning', $datas);
			}
		}
		unset($datas);
		
		if($result)
		{
			$txt = ($data['id'] != '')?'Mise à jour effectuée avec succès':'Planning ajouté avec succès';
			$class = 'success';
		}
		else
		{
			$txt = ($data['id'] != '')?'Erreur lors de la mise à jour':'Erreur lors de l\'ajout du planning';
			$class = 'alerte';
		}
		
		$vue = $this->load->view('/admin/staffPlanning', $data, TRUE);
		
		$datas = array(
			'rPop' => $txt,
			'rPopTitle' => $data['titre'],
			'rPopClass' => $class,
			'data' => $data
		);
		echo json_encode($datas); 
	}
	
	public function delete()
	{
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$this->Userplanningmodel->deleteData('staff', array('id' => $data['id']));
		$datas = array(
			'rPop' => $data['txt'],
			'rPopTitle' => $data['titre'],
			'rPopClass' => (isset($data['class']))?$data['class']:''
		);
		echo json_encode($datas);
	}
	
	public function delete_planning()
	{
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$this->Userplanningmodel->deleteData('staff_planning_set', array('id' => $data['id']));
		$this->Userplanningmodel->deleteData('staff_planning', array('id_set' => $data['id']));
		$datas = array(
			'rPop' => $data['txt'],
			'rPopTitle' => $data['titre'],
			'rPopClass' => (isset($data['class']))?$data['class']:''
		);
		echo json_encode($datas);
	}
	
	public function testPlanAlreadyOn() {
		$data['id'] = $this->input->post('id');
		$data['type'] = $this->input->post('type');
		$data['date'] = $this->input->post('date');
		$data['parite'] = $this->input->post('parite');
		$donneestest = array(
			'id_staff' => $data['id'],
			'type' => $data['type'],
			'date' => $data['date']
		);
		if ($data['type'] == 'recur') $donneestest['parite'] = $data['parite'];
		
		$resultsperm = $this->Userplanningmodel->getData('staff_planning_set',$donneestest);
		if($resultsperm) $testperm = 'ko';
		else $testperm = 'ok';
		echo $testperm;
	}
	public function get_week_number() {
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$date = new Datetime($data['date']);
		$week = $date->format('W');
		echo $week;
	}
	public function freeStaff($salle, $jour, $heure) {
	
	$finished = false;
	while ($finished == false) {
			
			if (!$sallesreservees) $sallesreservees = array();
			$searchsalle = 'active = 1';
			foreach($sallesreservees as $salleres) $searchsalle .= ' AND id != '.$salleres;			
			$salles = $this->Userplanningmodel->getList('salle',$searchsalle);
			
			if (!$gmdejapris) $gmdejapris = array();
			$searchstaff = 'gm != ""';
			foreach($gmdejapris as $gmpris) $searchstaff .= ' AND id != '.$gmpris;
			$staff = $this->Userplanningmodel->getList('staff',$searchstaff,'*','FIELD (gm_prio, "'.$salle.'") DESC');
			
			if (!$salles || !$staff) {
				$finished = true;
				break;
			}
			
		//Création d'un tableau contenant les GM disponibles. Clé = id du gm. Valeur = salles masterisées ------------------------------------			
			$hour = preg_replace('/h/',':',$heure);
			$date = new DateTime($jour.' '.$hour);
			
			//heure début et fin nécessaires pour pouvoir effectuer la résa
			$hourformat = $date->format('H:i');
			$beforeinterval = new DateInterval("PT30M");
			$starttime = new DateTime($jour.' '.$hour);		
			$starttime->sub($beforeinterval);
			$starttimeformat = $starttime->format('H\hi');
			
			$afterinterval = new DateInterval("PT90M");
			$endtime = new DateTime($jour.' '.$hour);
			$endtime->add($afterinterval);
			$endtimeformat = $endtime->format('H\hi');
				
			//date du premier jour de la semaine----------//
			$weekday = $date->format('N');
			$weekdaydif = $weekday - 1;
			$interval = new DateInterval("P".$weekdaydif."D");
			$startday = $date;
			$startday->sub($interval);		
			$startdayformat = $startday->format('Y-m-d');
			
			$value = "";
			foreach ($staff as $s) {
				$excepplanset = $this->Userplanningmodel->isPlanningExcep($s->id,$startdayformat);	
				$recurplanset = $this->Userplanningmodel->isPlanningRecur($s->id,$startdayformat);
				$permplanset = $this->Userplanningmodel->isPlanningPerm($s->id,$startdayformat);
				
				//est-ce que ce collaborateur a un planning ponctuel défini pour la semaine concernée ?
				//si oui
				if ($excepplanset) {
					foreach ($excepplanset as $e) {
						//est-ce que, sur ce planning ponctuel, le collaborateur travaille le jour concerné ?
						$excepplan = $this->Userplanningmodel->getList('staff_planning',array('jour' => $weekday,'id_set'=> $e->id));
						//si oui
						if ($excepplan) {
							foreach ($excepplan as $ep) {
								$hourstart = preg_replace('/h/',':',$ep->heure_debut);
								$dateplandebut = new DateTime($jour.' '.$hourstart);
								
								$hourend = preg_replace('/h/',':',$ep->heure_fin);
								$dateplanfin = new DateTime($jour.' '.$hourend);
								$endinterval = new DateInterval("P1D");
								if ($ep->heure_fin == '00h00') $dateplanfin->add($endinterval);
								
								if ($dateplandebut <= $starttime && $dateplanfin >= $endtime) {
									$dateaffiche = new DateTime($e->date);
									$weekaffiche = $dateaffiche->format('W');
									$staffpresent[$s->id] = $s->gm;
								}
							}
						}
					}
				}
				//si non
				//est-ce que ce collaborateur a un planning de type "une semaine sur deux" défini pour la semaine concernée ?
				else if ($recurplanset){
					foreach ($recurplanset as $r) {
						//est-ce que, sur ce planning de type "une semaine sur deux", le collaborateur travaille le jour concerné ?
						$recurplan = $this->Userplanningmodel->getList('staff_planning',array('jour' => $weekday,'id_set'=> $r->id));
						//si oui
						if ($recurplan) {
							foreach ($recurplan as $rp) {
								$hourstart = preg_replace('/h/',':',$rp->heure_debut);
								$dateplandebut = new DateTime($jour.' '.$hourstart);
								
								$hourend = preg_replace('/h/',':',$rp->heure_fin);
								$dateplanfin = new DateTime($jour.' '.$hourend);
								$endinterval = new DateInterval("P1D");
								if ($rp->heure_fin == '00h00') $dateplanfin->add($endinterval);
								
								if ($dateplandebut <= $starttime && $dateplanfin >= $endtime) {
									$staffpresent[$s->id] = $s->gm;
								}
							}
						}
					}
				}
				//si non
				//est-ce que ce collaborateur a un planning de type permanent défini pour la semaine concernée ?
				else if ($permplanset){
					foreach ($permplanset as $p) {
						//est-ce que, sur ce planning de type permanent, le collaborateur travaille le jour concerné ?
						$permplan = $this->Userplanningmodel->getList('staff_planning',array('jour' => $weekday,'id_set'=> $p->id));
						//si oui
						if ($permplan) {
							foreach ($permplan as $pp) {
								$hourstart = preg_replace('/h/',':',$pp->heure_debut);
								$dateplandebut = new DateTime($jour.' '.$hourstart);
								
								$hourend = preg_replace('/h/',':',$pp->heure_fin);
								$dateplanfin = new DateTime($jour.' '.$hourend);
								$endinterval = new DateInterval("P1D");
								if ($pp->heure_fin == '00h00') $dateplanfin->add($endinterval);
								
								if ($dateplandebut <= $starttime && $dateplanfin >= $endtime) {
									$staffpresent[$s->id] = $s->gm;
								}
							}
						}
					}
				}
			}
			if (!$staffpresent) {
				$finished = true;
				break;
			}
		//Fin création d'un tableau contenant les GM disponibles. Clé = id du gm. Valeur = salles masterisées -------------------------------------------------------
		
		//Création d'un tableau contenant les salles disponibles (pas d'indispo créée sur ces salles) Clé = id de la salle. Valeur = Nombre de gm qui masterisent cette salle--------------------
			
			foreach($salles as $s) {
				$nb = 0;
				foreach($staffpresent as $staff) {				
					$expstaff = explode('|',$staff);
					
					if (in_array($s->id,$expstaff)) {
						$nb++;	
					}
				}
				$sallesmaster[$s->id] = $nb;
			}
			arsort($sallesmaster);
		//Fin création d'un tableau contenant les salles disponibles (pas d'indispo créée sur ces salles) Clé = id de la salle. Valeur = Nombre de gm qui masterisent cette salle--------------------
		
		//Création d'un tableau contenant les gm disponibles classés par nombre de salles qu'ils peuvent masteriser. Clé = integer. Valeur = id du gm--------------------
			$countsalles = count($sallesmaster) + count($sallesreservees);
			$gmordered = array();
			for($i=1;$i<$countsalles+1;$i++) {
				foreach($staffpresent as $id => $staff) {
					$expstaff = explode('|',$staff);
					if(count($expstaff) == $i) 	$gmordered[$id] = 0; 			
				}
			}
		//Fin de création d'un tableau contenant les gm disponibles classés par nombre de salles qu'ils peuvent masteriser. Clé = integer. Valeur = id du gm--------------------
			$whomasters = array();
			$stillagm = false;
			foreach ($sallesmaster as $idsalle => $valuesalle) {
				$whomasters[$idsalle] = array();
				$first = true;
				foreach ($gmordered as $gmokey => $gmovalue) {
					$expstaff = explode('|', $staffpresent[$gmokey]);
					if (in_array($idsalle,$expstaff)) {
						array_push($whomasters[$idsalle],$gmokey);
						
						if ($first == true) {
							$gmordered[$gmokey] += count($sallesmaster);
							$first = false;
						}
						else $gmordered[$gmokey] += 1;
						$stillagm = true;						
					}
				}
				asort($gmordered);
			}
			if ($stillagm == false) {
				$finished = true;
				break;
			}
			//foreach ($gmordered as $key => $value) echo $key." : ".$value;
			$noresa = true;
			foreach ($whomasters as $key => $value) {
								
				$resas = $this->Userplanningmodel->getData('reservation','id_salle = "'.$key.'" AND id_client != 0 AND jour = "'.$jour.'" AND horaire = "'.$heure.'"');
				$staffaffiche = $this->Userplanningmodel->getData('staff',array('id' => $whomasters[$key][0]));
				if($resas != "") {
					$sallesreservees[] = $key;
					$gmdejapris[] = $whomasters[$key][0];		
					$infosalle[$key] = "resa|".$staffaffiche->prenom." ".$staffaffiche->nom;
					$noresa = false;
					unset($staffpresent);
					unset($whomasters);
					unset($sallesmaster);
					unset($gmordered);
					break;
				}
			}
			if ($noresa == true) {
				foreach ($whomasters as $key => $value) {
					$staffaffiche = $this->Userplanningmodel->getData('staff',array('id' => $whomasters[$key][0]));
					if ($staffaffiche) $infosalle[$key] = "noresa|".$staffaffiche->prenom." ".$staffaffiche->nom;
					else $infosalle[$key] = 0;
				}
				$finished = true;
			}
			
		}
		$rooms = $this->Userplanningmodel->getList('salle',array('active' => 1));
		foreach ($rooms as $room) {
			if (!$infosalle[$room->id]) $infosalle[$room->id] = 0;
		}
		
		return $infosalle;
			
	}
	/* fonction qui n'est plus utilisée
	public function firstdayofweek($semaine,$annee)
	{
		$m = 1;
		for($m=1;$m<13;$m++) {
			if($m == 2) {
				if((($annee%4 == 0)&&($annee%100 != 0))||($annee%400 == 0)) {
					$n = 1;
					for($n=1;$n<30;$n++) {
						$mois = '02';
						$jour = ($n<10)?'0'.$n:$n;
						$date = $annee.'-'.$mois.'-'.$jour;
						$date = new DateTime($date);
						if ($date->format('W') == $semaine) {
							$jourdebut = $date;
							break;
						}
					}
				}
			}
			else if ((($m%2 == 1)&&($m<8))||(($m%2 == 0)&&($m>7))) {
				$n = 1;
					for($n=1;$n<31;$n++) {
						$mois = ($m<10)?'0'.$m:$m;
						$jour = ($n<10)?'0'.$n:$n;
						$date = $annee.'-'.$mois.'-'.$jour;
						$date = new DateTime($date);
						if ($date->format('W') == $semaine) {
							$jourdebut = $date;
							break;
						}
					}
			}
			else {
				$n = 1;
					for($n=1;$n<30;$n++) {
						$mois = ($m<10)?'0'.$m:$m;
						$jour = ($n<10)?'0'.$n:$n;
						$date = $annee.'-'.$mois.'-'.$jour;
						$date = new DateTime($date);
						if ($date->format('W') == $semaine) {
							$jourdebut = $date;
							break;
						}
					}
			}
		}
		return $jourdebut;
	}
	*/
}
