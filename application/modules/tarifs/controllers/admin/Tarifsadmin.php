<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tarifsadmin extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('TarifsModel');
		/**
		* css du module
		**/
		$this->data['module_css'] = load_module_css($this->data['module_css'], 'tarifs');
		/**
		* js du module
		**/
		$this->data['module_js'] = load_module_js($this->data['module_js'],'tarifs');
	}
	public function listing()
	{
		$this->data['liste'] = $this->getTarifSalle(1);
		$this->data['liste_promo'] = $this->get_list_promo();
		$this->data['liste_tarifs_reduits'] = $this->getSettingsTarifs();
		
		
		$vue = $this->load->view('/admin/listing', $this->data, TRUE);
		return $vue;
	}
	
	public function getSettingsTarifs(){
		$days = ['1' => 'Lundi','2' =>'Mardi','3' =>'Mercredi', '4' => 'Jeudi', '5' => 'Vendredi', '6' => 'Samedi', '7' => 'Dimanche'];
		$this->data['salles_list'] = $this->TarifsModel->getList('salle',['active' => 1],['id','nom']);
		$settings = $this->TarifsModel->getList('tarif__setting');
		$i = 0;
		foreach ($settings as $set) {
			$idset = $set->tse_id;
			$start = explode('|',$set->tse_start);
			$end = explode('|',$set->tse_end);
			//$this->data['settings'] = '<span id="startday">'.$days[$start[0]].'</span> <span id="starthour">'.$start[1]. '</span> au <span id="endday">'.$days[$end[0]].'</span> <span id="endhour">'.$end[1].'</span>';
			$this->data['startday'][$i] = $start[0];
			$this->data['starthour'][$i] = $start[1];
			$this->data['endday'][$i] = $end[0];
			$this->data['endhour'][$i] = $end[1];
			$this->data['tseid'][$i] = $idset;
			$i++;
		}
		$this->data['days'] = $days;
		
		if($this->is_ajax())
		{
			$vue = $this->load->view('/admin/tableTarifsReduits', $this->data);
			echo $vue;
		}
		else
		{
			$vue = $this->load->view('/admin/tableTarifsReduits', $this->data, TRUE);
			return $vue;
		}
	}

	public function getTarifSalle($salle = 1){
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		if (!empty($data['salle'])){
			$salle = $data['salle'];
		}
		$this->data['tarifs'] = $this->TarifsModel->getList('salle__tarif',['salle_id' => $salle],'*','type ASC, joueurs ASC');
		$this->data['salle'] = $this->TarifsModel->getData('salle',['id' => $salle ]);
		$this->data['empty'] = $this->getEmptyPrice($salle);

		// $this->data['liste_promo'] = $this->get_list_promo();
		if($this->is_ajax())
		{
			$vue = $this->load->view('/admin/tableList', $this->data);
			echo $vue;
		}
		else
		{
			$vue = $this->load->view('/admin/tableList', $this->data, TRUE);
			return $vue;
		}
	}
	public function getList()
	{
		$this->data['tarifs'] = $this->TarifsModel->getList('tarif');
		if($this->is_ajax())
		{
			$vue = $this->load->view('/admin/tableList', $this->data);
			echo $vue;
		}
		else
		{
			$vue = $this->load->view('/admin/tableList', $this->data, TRUE);
			return $vue;
		}
	}

	public function update_settings(){

		$error = 0;
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);

		if($error == 0)
		{
			
			// Tableau des données à insérer/update dans BDD
			$datas = [
				'tse_type' => "we",
				'tse_start' => $data['tse_start'],
				'tse_end' => $data['tse_end'],
				'tse_state' => "1"
			];
			// Check Update / Add
			
			if($data['tse_id'] != 'new')
			{
				
				// update
				 $data['titre'] = "Mise à jour d'une plage de tarif réduit";
				if($this->TarifsModel->updateData('tarif__setting',$datas,array('tse_id' => $data['tse_id'])) !== FALSE)
				{
					$txt = 'Mise à jour de la plage de tarif réduit avec succés';
					$class = 'success';
				}
				else
				{
					$txt = 'Erreur lors de la mise à jour de la plage de tarif réduit : Erreur BDD';
					$class ='alerte';
				} 
			}
			// add
			else
			{	
				
				 $data['titre'] = "Ajout d'une plage de tarif réduit";
				if($this->TarifsModel->setData('tarif__setting',$datas) !== FALSE)
				{
					$txt = 'Création de la plage de tarif réduit avec succés';
					$class = 'success';
				}
				else
				{
					$txt = 'Erreur lors de la création de la plage de tarif réduit : Erreur BDD';
					$class ='alerte';
				} 
			}
		}
		$datas = ['rPop' => $txt,
		'rPopTitle' => $data['titre'],
		'rPopClass' => $class];
		echo json_encode($datas);
		
		
	}
	public function get_list_promo()
	{
		$this->data['promo'] = $this->TarifsModel->getlist('promo');
		// $this->data['promo_salle'] = $this->TarifsModel->getlist('promo_salle');
		$this->data['salles'] = $this->TarifsModel->getlist('salle','','id,nom');
		if ($this->input->is_ajax_request())
		{
			$vue = $this->load->view('/admin/tablePromo', $this->data);
			echo $vue;
		}
		else
		{
			$vue = $this->load->view('/admin/tablePromo', $this->data, TRUE);
			return $vue;
		}
	}
	public function delete()
	{
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$this->TarifsModel->deleteData('salle__tarif', array('id' => $data['id']));
		$datas = array(
			'rPop' => $data['txt'],
			'rPopTitle' => $data['titre'],
			'rPopClass' => (isset($data['class']))?$data['class']:''
		);
		echo json_encode($datas);
	}

	public function delete_promo()
	{
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		if(empty($data['id'])){
			$txt = 'Erreur de requête';
			$datas = ['rPop' => $txt,
			'rPopTitle' => $data['titre'],
			'rPopClass' => $class];
			echo json_encode($datas);
			return;
		}
		$this->TarifsModel->deleteData('promo',['id' => $data['id']]);
		$txt = 'Promotion supprimée avec succès';
		$datas = ['rPop' => $txt,
		'rPopTitle' => $data['titre'],
		'rPopClass' => $class];
		echo json_encode($datas);
	}
	public function delete_setting()
	{
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$this->TarifsModel->deleteData('tarif__setting', array('tse_id' => $data['id']));
		//$vue = $this->load->view('/admin/listing', $data, true);
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
		if(!empty($data['id'])){
			$data['tarif'] = $this->TarifsModel->getData('salle__tarif', array('id' => $data['id']));
			$vue = $this->load->view('/admin/form', $data, TRUE);
		} else {
			if(!empty($data['salle'])){
				$data['t_set'] = $this->getEmptyPrice($data['salle']);
			} else {
				$data['t_set'] = $this->getEmptyPrice();
			}
			$vue = $this->load->view('/admin/form', $data, TRUE);

			// Récupération des infos de la salle et des tarifs non fixés
		}

		$datas = array(
			'rPop' => $vue,
			'rPopTitle' => $data['titre'],
			'rPopClass' => (isset($data['class']))?$data['class']:''
		);
		echo json_encode($datas);
	}

	public function getEmptyPrice($salle = 1){
		$tarif_set = $this->TarifsModel->getList('salle__tarif',['salle_id' => $salle]);
		$res = ['sem'=>[],'we'=>[],'spe'=> []];

		foreach ($tarif_set as $key) {
			$res[$key->type][] = $key->joueurs;
		}
		unset($tarif_set);
		$salle = $this->TarifsModel->getData('salle',["id" => $salle],['nom','nbmin','nbmax']);
		$res['empty_sem'] = [];
		$res['empty_we'] = [];
		$res['empty_spe'] = [];
		for ($i=$salle->nbmin; $i <= $salle->nbmax; $i++) {
			if(!in_array($i, $res['sem'])){
				$res['empty_sem'][] = (int)$i;
			}
			if(!in_array($i, $res['we'])){
				$res['empty_we'][] = (int)$i;
			}
			if(!in_array($i,$res['spe'])){
				$res['empty_spe'][] = (int)$i;
			}
		}
		$res['salle'] = $salle;
		unset($res['sem'], $res['we'],$res['spe']);
		return $res;
	}

	public function infos_promo()
	{
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		if($data['id'] != '')
		{
			$data['promo'] = $this->TarifsModel->getData('promo',['id' => $data['id']]);
		}
		if($data['promo']->is_global == 0)
		{
			$data['salles'] = explode('|',$data['promo']->salles);
		}
		$data['list_salle'] = $this->TarifsModel->getlist('salle','','id,nom');
		$vue = $this->load->view('/admin/form_promo',$data,TRUE);
		$datas = ['rPop' => $vue,
		'rPopTitle' => $data['titre'],
		'rPopClass' => (isset($data['class']))?$data['class']:''];
		echo json_encode($datas);
	}
	public function update()
	{
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		if($data['id'] != ''){
			$datas = ['prix' => $data['tarif']];
			$result = $this->TarifsModel->updateData('salle__tarif', $datas, array('id' => $data['id']));
		}
		else{
			$datas = [
				'salle_id' => $data['salle_id'],
				'type' => $data['type'],
				'joueurs' => $data['joueurs'],
				'prix' => $data['tarif']
			];
			$result = $this->TarifsModel->setData('salle__tarif', $datas);
		}
		unset($datas);
		if($result)
		{
			$txt = ($data['id'] != '')?'Mise à jour effectuée avec succès':'Tarif ajouté avec succès';
			$class = 'success';
		}
		else
		{
			$txt = ($data['id'] != '')?'Erreur lors de la mise à jour':'Erreur lors de l\'ajout du tarif';
			$class = 'alerte';
		}
		$vue = $this->load->view('/admin/form', $data, TRUE);
		$datas = array(
			'rPop' => $txt,
			'rPopTitle' => $data['titre'],
			'rPopClass' => $class,
			'data' => $data
		);
		echo json_encode($datas);
	}
	public function update_promo(){
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		if(!empty($data['code'])){
			$pattern = '/^[[:alnum:]]{5,25}$/';
			if( ! preg_match($pattern, $data['code'] )){
				$txt = 'Le code promo est invalide';
				$datas = ['rPop' => $txt,
				'rPopTitle' => $data['titre'],
				'rPopClass' => $class];
				echo json_encode($datas);
				return;
			}
			$check = $this->TarifsModel->getData('promo',['code' => $data['code']]);
			if ($check && ( empty($data['id']) || (!empty($data['id']) && $data['id'] != $check->id ) ) ){
					$txt = 'Ce code existe déjà';
					$datas = ['rPop' => $txt,
					'rPopTitle' => $data['titre'],
					'rPopClass' => $class];
					echo json_encode($datas);
					return;
			}
		}
		// Conversion des dates au format Y/m/d pour SQL
		// Remplacement des '/' par des '.' pour interpretation date en EU par strtotime
		$data['start'] = strtr($data['start'],'/','.');
		$start_date = date('Y/m/d',strtotime($data['start']));
		$data['end'] = strtr($data['end'],'/','.');
		$end_date = date('Y/m/d',strtotime($data['end']));
		// Gestion des types de promos et préparation valeurs SQL
		switch ($data['type_promo']) {
			case 'euro':
			$type_promo = '€';
			break;
			case 'pourcent':
			$type_promo = '%';
			break;
			default:
			$error = 1;
			$txt = 'Erreur lors de la création/mise à jour de la promotion';
			$class ='alerte';
			break;
		}
		// Vérification du taux en numérique
		if ($error == 0 && !is_numeric($data['taux_promo']))
		{
			$error = 1;
			$txt = 'Erreur lors de la création/mise à jour de la promotion : Taux incorrect';
			$class ='alerte';
		} elseif ($type_promo == '%' && $data['taux_promo'] >= 100)
		{
			$error = 1;
			$txt = 'Erreur lors de la création/mise à jour de la promotion : % supérieur à 100';
			$class ='alerte';
		}
		if($error == 0)
		{
			// Gestion des salles
			$nb_salle = count($data['salles']);
			if ($nb_salle >= $this->TarifsModel->getNbData('salle',['active' => '1']))
			{
				$is_global = 1;
				$salles = '';
			}
			else
			{
				$is_global = 0;
				$salles = implode('|',$data['salles']);
			}
			// Tableau des données à insérer/update dans BDD
			$datas = [
				'type_promo' => $type_promo,
				'taux' => $data['taux_promo'],
				'titre' => $data['titre_promo'],
				'code' => $data['code'],
				'date_debut' => $start_date,
				'date_fin' => $end_date,
				'is_global' => $is_global,
				'salles' => $salles
			];
			// Check Update / Add
			if($data['id'] != '')
			{
				// update
				if($this->TarifsModel->updateData('promo',$datas,['id' => $data['id']]) !== FALSE)
				{
					$txt = 'Mise à jour de la promotion avec succés';
					$class = 'success';
				}
				else
				{
					$txt = 'Erreur lors de la mise à jour de la promotion : Erreur BDD';
					$class ='alerte';
				}
			}
			// add
			else
			{
				if($this->TarifsModel->setData('promo',$datas) !== FALSE)
				{
					$txt = 'Création de la promotion avec succés';
					$class = 'success';
				}
				else
				{
					$txt = 'Erreur lors de la création de la promotion : Erreur BDD';
					$class ='alerte';
				}
			}
		}
		$datas = ['rPop' => $txt,
		'rPopTitle' => $data['titre'],
		'rPopClass' => $class];
		echo json_encode($datas);
	}

	public function getPrice($jour,$horaire,$joueurs,$salle,$forcedprice)
	{
		$special = $this->TarifsModel->getData('salle__tarif',['type' => 'spe', 'joueurs' => $joueurs,'salle_id' => $salle]);
		if ($forcedprice != '') {
			return $forcedprice;
		}
		else {
			if($special !== FALSE && $special->prix != 0) {
				return $special->prix * $joueurs;
			} else {
				// $exp = explode('-', $jour);
				// $timestamp = mktime(0, 0, 0, $exp[1], $exp[2], $exp[0]);
				// $day = date('sem', $timestamp);
				$date = new DateTime($jour);
				$day = $date->format('N');
				
				$type = 'we';
				$we_time = $this->TarifsModel->getList('tarif__setting', ['tse_type' => 'we', 'tse_state' => 1]);
				foreach ($we_time as $wetime) {
					$we_start = explode('|',$wetime->tse_start);
					$we_end = explode('|',$wetime->tse_end);
					$we_start[1] = strtotime(str_replace('h', '.', $we_start[1]));
					$we_end[1] = strtotime(str_replace('h', '.', $we_end[1]));
					$horaire = strtotime(str_replace('h','.',$horaire));
					if (($day == $we_start[0] && $horaire >= $we_start[1]) || ($day == $we_end[0] && $horaire < $we_end[1])) 
					{
						$type = 'sem';
					}
					else if ($we_start[0] < $we_end[0]) {
						if ($day > $we_start[0] && $day < $we_end[0]) {
							$type = 'sem';
						}
					}
					else {
						if ($day > $we_start[0] || $day < $we_end[0]) {
							$type = 'sem';
						}
					}
				}


				$price = $this->TarifsModel->getData('salle__tarif',array('type' => $type, 'joueurs' => $joueurs,'salle_id' => $salle));
				return $price->prix * $joueurs;
			}
		} 
	}
}
