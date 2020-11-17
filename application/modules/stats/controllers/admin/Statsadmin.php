<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Statsadmin extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('StatsModel');
		/**
		* css du module
		**/
		$this->data['module_css'] = load_module_css($this->data['module_css'], 'stats');
		/**
		* js du module
		**/
		$this->data['module_js'] = load_module_js($this->data['module_js'],'stats');
	}
	public function listing()
	{	
		$this->data['frequentation'] = $this->get_freq();
		//$this->data['resasdatas'] = $this->get_resasdatas();
		//$this->data['reussite'] = $this->get_reussite();
		$vue = $this->load->view('/listing', $this->data, TRUE);
		return $vue;
	}
	public function get_freq(){
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$this->data['salles'] = $this->StatsModel->getList('salle',array('active' => 1),'*','nbmin');
		$this->data['sallesmax'] = $this->StatsModel->getList('salle',array('active' => 1),'*','nbmax DESC');
		$this->data['horlist'] = $this->StatsModel->getHorlist();
		$this->data['frDay'] = array('Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche');
		$this->data['frMonth'] = array('1'=>'Janvier','2'=>'Février','3'=>'Mars','4'=>'Avril','5'=>'Mai','6'=>'Juin','7'=>'Juillet','8'=>'Août','9'=>'Septembre','10'=>'Octobre','11'=>'Novembre','12'=>'Décembre');
		$this->data['years'] = $this->StatsModel->getAnneesList();
		$delai[0] = array("titre" => "Le jour même","mini" => "0","maxi" => "0");
		$delai[1] = array("titre" => "1 jour avant","mini" => "1","maxi" => "1");
		$delai[2] = array("titre" => "De 2 à 7 jours avant","mini" => "2","maxi" => "7");
		$delai[3] = array("titre" => "De 8 à 14 jours avant","mini" => "8","maxi" => "14");
		$delai[4] = array("titre" => "15 jours avant ou plus","mini" => "15","maxi" => "");
		$this->data['delai'] = $delai;
		foreach ($this->data['salles'] as $salle) {
			$this->data['classement'][$salle->id] = $this->StatsModel->getTopTen($salle->id);			
		}
		
		if($this->input->is_ajax_request())
		{
			$vue = $this->load->view('/frequentation', $this->data);
			echo $vue;
		}
		else
		{
			$vue = $this->load->view('/frequentation', $this->data, TRUE);
			return $vue;
		}
		
	}
	public function get_resasdatas(){
		
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$this->data['salles'] = $this->StatsModel->getList('salle',array('active' => 1),'*','nbmin');
		$this->data['sallesmax'] = $this->StatsModel->getList('salle',array('active' => 1),'*','nbmax DESC');
		$this->data['horlist'] = $this->StatsModel->getHorlist();
		$this->data['frDay'] = array('Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche');
		$this->data['frMonth'] = array('1'=>'Janvier','2'=>'Février','3'=>'Mars','4'=>'Avril','5'=>'Mai','6'=>'Juin','7'=>'Juillet','8'=>'Août','9'=>'Septembre','10'=>'Octobre','11'=>'Novembre','12'=>'Décembre');
		$this->data['years'] = $this->StatsModel->getAnneesList();
		$delai[0] = array("titre" => "Le jour même","mini" => "0","maxi" => "0");
		$delai[1] = array("titre" => "1 jour avant","mini" => "1","maxi" => "1");
		$delai[2] = array("titre" => "De 2 à 7 jours avant","mini" => "2","maxi" => "7");
		$delai[3] = array("titre" => "De 8 à 14 jours avant","mini" => "8","maxi" => "14");
		$delai[4] = array("titre" => "15 jours avant ou plus","mini" => "15","maxi" => "");
		$this->data['delai'] = $delai;
		foreach ($this->data['salles'] as $salle) {
			$this->data['classement'][$salle->id] = $this->StatsModel->getTopTen($salle->id);			
		}
		
		if($this->input->is_ajax_request())
		{
			$vue = $this->load->view('/resasdatas', $this->data);
			echo $vue;
		}
		else
		{
			$vue = $this->load->view('/resasdatas', $this->data, TRUE);
			return $vue;
		}
		
	}
	public function get_reussite(){
		
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$this->data['salles'] = $this->StatsModel->getList('salle',array('active' => 1),'*','nbmin');
		$this->data['sallesmax'] = $this->StatsModel->getList('salle',array('active' => 1),'*','nbmax DESC');
		$this->data['horlist'] = $this->StatsModel->getHorlist();
		$this->data['frDay'] = array('Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche');
		$this->data['frMonth'] = array('1'=>'Janvier','2'=>'Février','3'=>'Mars','4'=>'Avril','5'=>'Mai','6'=>'Juin','7'=>'Juillet','8'=>'Août','9'=>'Septembre','10'=>'Octobre','11'=>'Novembre','12'=>'Décembre');
		$this->data['years'] = $this->StatsModel->getAnneesList();
		$delai[0] = array("titre" => "Le jour même","mini" => "0","maxi" => "0");
		$delai[1] = array("titre" => "1 jour avant","mini" => "1","maxi" => "1");
		$delai[2] = array("titre" => "De 2 à 7 jours avant","mini" => "2","maxi" => "7");
		$delai[3] = array("titre" => "De 8 à 14 jours avant","mini" => "8","maxi" => "14");
		$delai[4] = array("titre" => "15 jours avant ou plus","mini" => "15","maxi" => "");
		$this->data['delai'] = $delai;
		foreach ($this->data['salles'] as $salle) {
			$this->data['classement'][$salle->id] = $this->StatsModel->getTopTen($salle->id);			
		}
		
		if($this->input->is_ajax_request())
		{
			$vue = $this->load->view('/reussite', $this->data);
			echo $vue;
		}
		else
		{
			$vue = $this->load->view('/reussite', $this->data, TRUE);
			return $vue;
		}		
	}
	public function get_ete2020(){
		
/* 		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$this->data['salles'] = $this->StatsModel->getList('salle',array('active' => 1),'*','nbmin');
		$this->data['sallesmax'] = $this->StatsModel->getList('salle',array('active' => 1),'*','nbmax DESC');
		$this->data['horlist'] = $this->StatsModel->getHorlist();
		$this->data['frDay'] = array('Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche');
		$this->data['frMonth'] = array('1'=>'Janvier','2'=>'Février','3'=>'Mars','4'=>'Avril','5'=>'Mai','6'=>'Juin','7'=>'Juillet','8'=>'Août','9'=>'Septembre','10'=>'Octobre','11'=>'Novembre','12'=>'Décembre');
		$this->data['years'] = $this->StatsModel->getAnneesList();
		$delai[0] = array("titre" => "Le jour même","mini" => "0","maxi" => "0");
		$delai[1] = array("titre" => "1 jour avant","mini" => "1","maxi" => "1");
		$delai[2] = array("titre" => "De 2 à 7 jours avant","mini" => "2","maxi" => "7");
		$delai[3] = array("titre" => "De 8 à 14 jours avant","mini" => "8","maxi" => "14");
		$delai[4] = array("titre" => "15 jours avant ou plus","mini" => "15","maxi" => "");
		$this->data['delai'] = $delai;
		foreach ($this->data['salles'] as $salle) {
			$this->data['classement'][$salle->id] = $this->StatsModel->getTopTen($salle->id);			
		} */
		
		if($this->input->is_ajax_request())
		{
			$vue = $this->load->view('/ete2020', $this->data);
			echo $vue;
		}
		else
		{
			$vue = $this->load->view('/ete2020', $this->data, TRUE);
			return $vue;
		}
		
	}
	
	public function getStatsFreq() {
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$salles = explode('|',$data['salles']);	
		$datas = array();		
		$searchsqlstart = "id_client <> '0' ORDER BY jour LIMIT 1";
		$resultstart = $this->StatsModel->getList('reservation',$searchsqlstart,'jour');
		$firstresa = new DateTime($resultstart[0]->jour);
		$firstyear = intval($firstresa->format('Y'));
		$today = new DateTime();
		$currentyear = ($data['compare'] == '1')?intval($today->format('Y')):$firstyear;
		
		
		if ($data['compare'] != '1') {
			$j=0;
			
			$filtreannee = ($data['annee'] != 0)?" AND jour >= '".$data['annee']."-01-01' AND jour <= '".$data['annee']."-12-31'":"";			
			$searchsqlstart = "id_client <> '0'".$filtreannee." ORDER BY jour LIMIT 1";
			$resultstart = $this->StatsModel->getList('reservation',$searchsqlstart,'jour');
			$searchsqlend = "id_client <> '0'".$filtreannee." ORDER BY jour DESC LIMIT 1";
			$resultend = $this->StatsModel->getList('reservation',$searchsqlend,'jour');
			
			foreach($salles as $s) {
				$i = 0;
				$datestart = new DateTime($resultstart[0]->jour);			
				$dateend = new DateTime($resultend[0]->jour);
				
				if ($data['intervale'] == "m") {
					$interval = $datestart->diff($dateend);
					$nbintervalannee = $interval->format('%y');
					$nbintervalmois = $interval->format('%m');
					$nbinterval = $nbintervalannee*12 + $nbintervalmois;
				}
				else if ($data['intervale'] == "w") {
					$weekday = $datestart->format('N');
					$subdays = intval($weekday) - 1;
					$datestart->sub(new DateInterval('P'.$subdays.'D'));
					$interval = $datestart->diff($dateend);
					$nbintervaljours = $interval->format('%a');
					$reste = $nbintervaljours%7;
					$nbinterval = ($nbintervaljours - $reste)/7;
				}
				
				
				$filtresalle = ($s=="tot")?"":"AND id_salle = '".$s."' ";
				
				for ($i=0;$i<$nbinterval+1;$i++) {
					
					if ($data['intervale'] == "m") {
						$searchdate = $datestart->format("Y-m");
						
						$searchsql = "id_client <> '0' AND jour LIKE '%".$searchdate."%' ".$filtresalle;
						$result = $this->StatsModel->getList('reservation',$searchsql,'id');				
						$nbresult = count($result);
						$key = $searchdate;	
						$datestart->add(new DateInterval('P1M'));				
					}
					else if ($data['intervale'] == "w") {
						$searchdatestart = $datestart->format("Y-m-d");
						$dateend = new DateTime($searchdatestart);
						$dateend->add(new DateInterval('P7D'));
						$searchdateend = $dateend->format("Y-m-d");
						$searchsql = "id_client <> '0' AND jour >= '".$searchdatestart."' AND jour < '".$searchdateend."' ".$filtresalle;
						$result = $this->StatsModel->getList('reservation',$searchsql,'id');				
						$nbresult = count($result);
						$key = ($datestart->format("Y")-2010).'S'.$datestart->format("W");
						$datestart->add(new DateInterval('P7D'));
						
					}
					$datas[$j.$key] = $nbresult;					
				}
				
				$infossalle = $this->StatsModel->getData('salle',array('id' => $s));				
				$datas["chart".$j] = ($s=="tot")?"Total":$infossalle->nom;
			
				$j++;
			}

		}
		else {
			$j=$firstyear;
			for ($j=$firstyear;$j<$currentyear+1;$j++) {
				$data['annee'] = strval($j);
				$iterration = substr($data['annee'],3,1);						
				$i = 0;
				
				
				if ($data['intervale'] == "m") {
					$datestart = new DateTime($data['annee'].'-01-01');			
					$dateend = new DateTime($data['annee'].'-12-31');
					$interval = $datestart->diff($dateend);
					$nbintervalannee = $interval->format('%y');
					$nbintervalmois = $interval->format('%m');
					$nbinterval = $nbintervalannee*12 + $nbintervalmois;
				}
				else if ($data['intervale'] == "w") {
					$k = 1;
					for($k=1;$k<9;$k++) {
						$datetest = new DateTime($data['annee'].'-01-0'.$k);
						if ($datetest->format('W') == '01') {
							$datestart = new DateTime($data['annee'].'-01-0'.$k);
							break;
						}
					}
					$k = 31;
					for($k=31;$k>23;$k--) {
						$datetest = new DateTime($data['annee'].'-12-'.$k);
						if ($datetest->format('W') == '52') {
							$dateend = new DateTime($data['annee'].'-12-'.$k);
							break;
						}
					}								
					
					$weekday = $datestart->format('N');
					$subdays = intval($weekday) - 1;
					$datestart->sub(new DateInterval('P'.$subdays.'D'));
					$interval = $datestart->diff($dateend);
					$nbintervaljours = $interval->format('%a');
					$reste = $nbintervaljours%7;
					$nbinterval = ($nbintervaljours - $reste)/7;
				}
				
				
				$filtresalle = ($data['salles']=="tot")?"":"AND id_salle = '".$data['salles']."' ";
				
				for ($i=0;$i<$nbinterval+1;$i++) {
					
					if ($data['intervale'] == "m") {
						$searchdate = $datestart->format("Y-m");
						$nbmois = $datestart->format("m");
						$nomsmois = array('01'=>'Jan','02'=>'Fev','03'=>'Mar','04'=>'Avr','05'=>'Mai','06'=>'Juin','07'=>'Juil','08'=>'Aout','09'=>'Sept','10'=>'Oct','11'=>'Nov','12'=>'Dec');
						$searchsql = "id_client <> '0' AND jour LIKE '%".$searchdate."%' ".$filtresalle;
						$result = $this->StatsModel->getList('reservation',$searchsql,'id');				
						$nbresult = count($result);
						$key = $iterration.$nomsmois[$nbmois];	
						$datestart->add(new DateInterval('P1M'));				
					}
					else if ($data['intervale'] == "w") {
						$searchdatestart = $datestart->format("Y-m-d");
						$dateend = new DateTime($searchdatestart);
						$dateend->add(new DateInterval('P7D'));
						$searchdateend = $dateend->format("Y-m-d");
						$searchsql = "id_client <> '0' AND jour >= '".$searchdatestart."' AND jour < '".$searchdateend."' ".$filtresalle;
						$result = $this->StatsModel->getList('reservation',$searchsql,'id');				
						$nbresult = count($result);
						$key = $iterration."'".$datestart->format("W");
						$datestart->add(new DateInterval('P7D'));
						
					}
					$datas[$key] = $nbresult;					
				}
				$nbchart = $iterration - 6;
				$infossalle = $this->StatsModel->getData('salle',array('id' => $data['salles']));				
				$datas["chart".$nbchart] = ($data['salles']=="tot")?"Total".$j:$infossalle->nom.$j;
			}
			
		}
		
		echo json_encode($datas); 
	}
	public function getStatsNbJoueursResaBar() {
		
		
	}
	public function reussite($salle = "",$reussite = "",$percent = "", $joueurs = "")
	{
		$data = $this->StatsModel->getReussite($salle,$reussite,$percent,$joueurs);	
		echo $data;
	}
	
	public function composition($salle = "", $joueurs = "", $percent = "")
	{
		$data = $this->StatsModel->getComposition($salle,$joueurs,$percent);	
		echo $data;
	}
 	public function horaires($salle = "", $horaire = "", $percent = "")
	{
		$data = $this->StatsModel->getHoraires($salle,$horaire,$percent);	
		echo $data;
	}
	public function joursSemaine($salle = "", $jour = "", $percent = "")
	{
		$data = $this->StatsModel->getJoursSemaine($salle,$jour,$percent);	
		echo $data;
	}
	public function delai($salle = "", $mini = "", $maxi = "", $percent = "")
	{
		$data = $this->StatsModel->getDelai($salle,$mini,$maxi,$percent);	
		echo $data;
	}
	public function rang($salle = "", $temps = "")
	{
		$data = $this->StatsModel->getRanking($salle,$temps);	
		echo $data;
	}
	public function ecartmois($mois = "", $annee = "")
	{
		$data = $this->StatsModel->getEcartMois($mois,$annee);	
		echo $data;
	}
	public function resasmois($mois = "", $annee = "", $salle = "")
	{
		$data = $this->StatsModel->getNbResasMois($mois,$annee,$salle);	
		echo $data;
	}
	public function resassemaine($semaine = "", $annee = "", $salle = "")
	{
		$data = $this->StatsModel->getNbResasSemaine($semaine,$annee,$salle);	
		echo $data;
	}
	public function joursEtHoraires($jour = "", $horaire = "")
	{
		$data = $this->StatsModel->getJoursEtHoraires($jour,$horaire);	
		echo $data;
	}
	public function joursEtHorairesVacances($jour = "", $horaire = "",$periode = "")
	{
		$data = $this->StatsModel->getJoursEtHorairesVacances($jour,$horaire,$periode);	
		echo $data;
	}
	public function resasVacances()
	{
		$data = $this->StatsModel->getResasVacances();	
		return $data;
	}
	public function nbResaFromOneDayToAnother($dayFrom,$dayTo)
	{
		$data = $this->StatsModel->getNbResaFromTo($dayFrom,$dayTo);	
		return $data;
		//echo "titi";
	}
	public function cAFromOneDayToAnother($dayFrom,$dayTo)
	{
		$data = $this->StatsModel->getCAFromTo($dayFrom,$dayTo);	
		return $data;
	}
}
