<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sallesadmin extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('SallesModel');
		/**
		* css du module
		**/
		$this->data['module_css'] = load_module_css($this->data['module_css'], 'salles');
		/**
		* js du module
		**/
		$this->data['module_js'] = load_module_js($this->data['module_js'],'salles');
	}
	public function listing()
	{	
		$resindis = "indis";
		$data['onglet'] = '';
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$this->data['onglet'] = $data['onglet']; 
		
		if( ! empty($data['resindis']))
		{
			$resindis = $data['resindis'];
			$this->session->resindis_r = $resindis;
		}
		
		$this->data['salles'] = $this->SallesModel->getList('salle');
		$tmpty = [];
		foreach ($this->data['salles'] as $value) {
			$query = $this->db->query('SELECT * FROM `horaire` INNER JOIN `salle__horaire_set` ON `fk_set_id` = `set_id` WHERE `fk_salle_id` = '.$value->id.' AND set_date_begin <= NOW()');
			$tmp_set = $query->result_array();
			if(empty($tmp_set)){
				$tmpty[] = $value->id;
			}
		}
		if(!empty($tmpty)){
			// $this->data['empty'] = '';
			$this->data['empty'] = '';
			$query = $this->db->query('SELECT `nom` FROM `salle` WHERE `id` IN ('.implode(',',$tmpty).') ');
			
			$count = 0;
			
			foreach ($query->result_array() as $v) {
				$count++;
				$this->data['empty'] .= $v['nom'].', ';
				// $this->data['empty'][] = $v;	
			}
			$this->data['emptynb'] = $count;
			
			$this->data['empty'] = substr($this->data['empty'],0, strlen($this->data['empty']) - 2 );
		}
		$this->data['nbmax'] = $this->SallesModel->getData('nombre_salles_max',['id' => 1]);
		$this->data['nbmaxweek'] = $this->SallesModel->getData('nombre_salles_max',['id' => 2]);
		$this->data['nbmaxperiod'] = $this->SallesModel->getData('nombre_salles_max',['id' => 3]);
		$this->data['salles'] = $this->SallesModel->getList('salle');
		$this->data['resindis'] = $resindis;
		$this->data['indisponibilites'] = $this->SallesModel->getIndispoList('salle');
		
		if($this->input->is_ajax_request()){
			$vue = $this->load->view('/admin/listing', $this->data);
			echo $vue;
		} else {
			$this->data['calendar'] = modules::run('reservation/admin/Reservationadmin/calendar');
			$vue = $this->load->view('/admin/listing', $this->data, true);
			return $vue;
		}
	}
	public function delete()
	{
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$this->SallesModel->deleteData('salle', ['id' => $data['id']]);
		$datas = [
		'rPop' => $data['txt'],
		'rPopTitle' => $data['titre'],
		'rPopClass' => (isset($data['class']))?$data['class']:''
		];
		echo json_encode($datas);
	}
	public function deleteIndispo()
	{
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);

		$this->SallesModel->deleteData('indispos', array('id' => $data['id']));
		
		$datas = array(
			'rPop' => $data['txt'],
			'rPopTitle' => $data['titre'],
			'rPopClass' => (isset($data['class']))?$data['class']:''
		);
		echo json_encode($datas);
	}
	public function infos()
	{
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$data['salle'] = $this->SallesModel->getData('salle',['id' => $data['id']]);
		$vue = $this->load->view('/admin/form', $data, true);
		$datas = [
		'rPop' => $vue,
		'rPopTitle' => $data['titre'],
		'rPopClass' => (isset($data['class']))?$data['class']:''
		];
		echo json_encode($datas);
	}
	public function update_set(){
		$data = $this->input->post();
		$res = [];
		if(empty($data['set_id']) && empty($data['set_date_begin'])){
			die('Wrong call');
		}
		$regexDate = '/^20\d\d-[0-1]\d-[0-3]\d$/';
		if(!preg_match($regexDate,$data['set_date_begin'])){
			$res['status'] = 'error';
			$res['message'] = 'Erreur date';
			print json_encode($res);
			return;
		}
		// Check résa
		$resa = $this->SallesModel->getList('reservation',['jour >=' => $data['set_date_begin']]);
		if(!empty($resa)){
			// Resa existante après le changement d'horaire.
			$res['status'] = 'warning';
			$res['message'] = 'Reservations existantes après la nouvelle date d\'horaires, date non appliqué';
		}
		$this->SallesModel->updateData('salle__horaire_set',['set_date_begin' => $data['set_date_begin']],['set_id'=>$data['set_id']]);
		$res['status'] = 'success';
		$res['message'] = 'Date mise à jour avec succès';
		$d = new DateTime($data['set_date_begin']);
		$res['data'] = 'HORAIRES A VENIR (à partir du '.$d->format('d-m-Y').'  )';
		print json_encode($res);
	}
	public function update()
	{
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);				
		$dernieremodif = time();				
		$formatmodif = date('Y-m-d H:i:s', $dernieremodif);
		$datas = [
		'nom' => $data['nom'],
		'description' => htmlspecialchars($data['scenario']),
		'active' => $data['active'],
		'slug' => slugify($data['nom']),
		'nbmin' => (int)$data['nbmin'],
		'nbmax' => (int)$data['nbmax'],
		// FIXED VALUE FOR NOW
		'duration' => (int)$data['duration'],
		'caract' => htmlspecialchars($data['caract']),						
		'derniere_modif' => $formatmodif
		];
		if($datas['nbmin'] > $datas['nbmax'] ){
			$txt = 'Nb de joueurs min supérieur au nombre de joueurs max, veuillez vérifier votre saisie';
			$class = 'error';
			$vue = $this->load->view('/admin/form', $data, true);
			$res =[
			'rPop' => $txt,
			'rPopTitle' => $data['titre'],
			'rPopClass' => $class
			];
			echo json_encode($res);
			return;
		}
		if($datas['nbmin'] == 0 ){
			$txt = 'Le nombre de joueurs minimum ne peut être égal à zéro';
			$class = 'error';
			$vue = $this->load->view('/admin/form', $data, true);
			$res =[
			'rPop' => $txt,
			'rPopTitle' => $data['titre'],
			'rPopClass' => $class
			];
			echo json_encode($res);
			return;
		}
		if($data['id'] != ''){
			// $this->init_horaire($data['id']);
			$result = $this->SallesModel->updateData('salle', $datas, ['id' => $data['id']]);
		}
		else{
			$salle_id = $result = $this->SallesModel->setData('salle', $datas,TRUE);
			$this->init_horaire($salle_id);
		}
		if($result)
		{
			$txt = ($data['id'] != '')?'Mise à jour effectuée avec succès':'Salle ajoutée avec succès';
			$class = 'success';
		}
		else
		{
			$txt = ($data['id'] != '')?'Erreur lors de la mise à jour':'Erreur lors de l\'ajout de la salle';
			$class = 'alerte';
		}
		$vue = $this->load->view('/admin/form', $data, true);
		$datas = [
		'rPop' => $txt,
		'rPopTitle' => $data['titre'],
		'rPopClass' => $class
		];
		echo json_encode($datas);
	}
	
	public function update_nb_resa_max() {
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		
		/* Update nombre resa max général. */
		$datas = [
		'nb_max'=> $data['nb_resa_max']
		];		
		$result = $this->SallesModel->updateData('nombre_salles_max', $datas, ['id' => 1]);
		
		
		/* Update nombre resa max sur la semaine. */
		$datas2 = [
		'nb_max'=> $data['nb_resa_max_week'],
		'weekdays' => $data['weekdays']
		];		
		$result2 = $this->SallesModel->updateData('nombre_salles_max', $datas2, ['id' => 2]);
		
		
		/* Update nombre resa max sur une période. */
		$datestartexp = explode('/',$data['datestart']);
		$datestart = $datestartexp[2].'-'.$datestartexp[1].'-'.$datestartexp[0];
		$dateendexp = explode('/',$data['dateend']);
		$dateend = $dateendexp[2].'-'.$dateendexp[1].'-'.$dateendexp[0];
		$datas3 = [
		'nb_max'=> $data['nb_resa_max_period'],
		'datedebut' => $datestart,
		'datefin' => $dateend
		];
		$result3 = $this->SallesModel->updateData('nombre_salles_max', $datas3, ['id' => 3]);
		
		
		if($result&&$result2&&$result3)
		{
			$txt = 'Mise à jour effectuée avec succès'.$weekdaystring;
			$class = 'success';
		}
		else
		{
			$txt = 'Erreur lors de la mise à jour';
			$class = 'alerte';
		}
		$datas = [
		'rPop' => $txt,
		'rPopTitle' => 'Mise à jour du nombre max de salles réservables',
		'rPopClass' => $class
		];
		echo json_encode($datas);
	}
	public function init_horaire($salle_id = 1){
		$date = new DateTime();
		$data = ['fk_salle_id' => $salle_id,'set_date_begin' => $date->format('Y-m-d') ];
		$set_id = $this->SallesModel->setData('salle__horaire_set',$data,TRUE);
		$batch_tab = [];
		$k = 0;
		for($j = 10; $j<=22 ; $j += 2){
			$batch_tab[$k]['hor_start'] = (string)$j .'h00';
			$batch_tab[$k]['hor_day'] = 'all';
			$batch_tab[$k]['fk_set_id'] = $set_id;
			$k++;
		}
		$this->SallesModel->setBatchData('horaire',$batch_tab);
		return $set_id;
	}
	public function infos_horaires(){
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		if(empty($data['id'])){
			die('Wrong call !!');
		}
		$date = new DateTime();
		$dat['horaire_set'] = $this->SallesModel->getList('salle__horaire_set', ['fk_salle_id' => $data['id']],'*','set_date_begin ASC');
		$nb_set = count($dat['horaire_set']);
		if($nb_set == 0)
		{
			$set_id = $this->init_horaire($data['id']);
			$where = "fk_set_id = ".$set_id;
		} else {
			if($nb_set == 1 ){
				$this->SallesModel->setData('salle__horaire_set',['fk_salle_id' => $data['id'] , 'set_date_begin' => '2099-12-31','set_state' => 1]);
				$dat['horaire_set'] = $this->SallesModel->getList('salle__horaire_set', ['fk_salle_id' => $data['id']],'*','set_date_begin ASC');
			}
			if ($nb_set > 1 && $dat['horaire_set'][1]->set_date_begin != '2099-12-31' && $dat['horaire_set'][1]->set_date_begin <= $date->format('Y-m-d')  )
			{
				$dat['horaire_set'] = $this->SallesModel->rotateSet($dat['horaire_set'][0]->set_id, $data['id']);
			}
			$where = "fk_set_id IN (";
			for ($i=0; $i < $nb_set; $i++)
			{
				$where .= "'".$dat['horaire_set'][$i]->set_id."'";
				if($i < $nb_set - 1 )
				{
					$where .= " , ";
				}
			}
			$where .= ")";
		}
		$dat['salle'] = $this->SallesModel->getData('salle',['id'=>$data['id']]);
		$dat['horaires'] = $this->SallesModel->getList('horaire',$where,'*','fk_set_id ASC ,  hor_start');
		$vue = $this->load->view('/admin/horaire', $dat, true);
		if(empty($data['reload'])){
			$datas = [
			'rPop' => $vue,
			'rPopTitle' => $data['titre'],
			'rPopClass' => (isset($data['class']))?$data['class']:''
			];
			echo json_encode($datas);
		} else {
			echo $vue;
		}
	}
	public function update_horaire(){
		$data = $this->input->post();
		if(empty($data['hor_id'])){
			print json_encode(['status' => 'error','message' => 'Wrong call']);
			return;
		}
		$regex_hour = '/^([01]?[0-9]|2[0-3])h[0-5][0-9]$/';
		$regex_days = '/^[1-7](,[1-7]){0,5}$/';
		if(!preg_match($regex_hour,$data['horaire']) || ( $data['days'] != 'all' && !preg_match($regex_days,$data['days'] ))){
			print json_encode(['status' => 'error','message' => 'Format incorrect']);
			return;
		}
		if($this->SallesModel->updateData('horaire',['hor_start' => $data['horaire'], 'hor_day' => $data['days']],['hor_id' => $data['hor_id']])){
			print json_encode(['status' => 'success','message' => 'Mise à jour ok','horaire' => $data['horaire']]);
			return;
		} else {
			print json_encode(['status' => 'error','message' => 'Erreur DB<br>Veuillez réessayer']);
			return;
		}
	}
	public function add_horaire(){
		$data = $this->input->post();
		// var_dump($data);
		$regex_hour = '/^([01]?[0-9]|2[0-3])h[0-5][0-9]$/';
		// $regex_days = '/^[1-7](,[1-7]){0,5}$/';
		if(!preg_match($regex_hour,$data['hor_start']) ){
			print json_encode(['status' => 'error','message' => 'Format incorrect']);
			return;
		}
		$hor_id = $this->SallesModel->setData('horaire',['hor_start' => $data['hor_start'], 'hor_day' => 'all','fk_set_id' => $data['set_id'] ] , TRUE );
		if($hor_id != FALSE ){
			// $this->SallesModel->
			print json_encode(['status' => 'success','message' => 'Ajout de l\'horaire avec succès','horaire' => $data['hor_start'] ,'hor_id'=>$hor_id]);
			return;
		} else {
			$res = ['status' => 'error','message' => 'Erreur DB Veuillez réessayer'];
			print json_encode($res);
			return;
		}
	}
	public function delete_horaire(){
		$data = $this->input->post();
		if(empty($data['hor_id'])){
			print json_encode(['status' => 'error','message' => 'Wrong call']);
			return;
		}
		if($this->SallesModel->deleteData('horaire',['hor_id' => $data['hor_id']])){
			print json_encode(['status' => 'success','message' => 'Suppression avec succès']);
			return;
		} else {
			print json_encode(['status' => 'error','message' => 'Erreur DB<br>Veuillez réessayer']);
			return;
		}
	}
}
