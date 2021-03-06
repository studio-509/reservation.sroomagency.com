<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Reservation extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('ReservationModel');
		$this->load->libraries(array('form_validation'));
		/**
		* css du module
		**/
		$this->data['module_css'] = load_module_css($this->data['module_css'], 'reservation');
		/**
		* js du module
		**/
		$this->data['module_js'] = load_module_js($this->data['module_js'],'reservation');
	}
	/**
	 * [index description]
	 * @return [type] [description]
	 */
	public function index()
	{
		$this->session->sess_destroy();
		$this->clear_cache();
		$this->data['scenario'] = 0;

		$detect = new Mobile_Detect();
		$isPhone = $detect->isMobile() || $detect->isTablet();
		if($isPhone)
		{
			/*if($_SERVER['REMOTE_ADDR'] == "78.212.15.16" || $_SERVER['REMOTE_ADDR'] == "88.185.179.85" || $_SERVER['REMOTE_ADDR'] == "109.215.164.81" || $_SERVER['REMOTE_ADDR'] == "77.154.204.70")
			$this->mobileCalendar($this->data);
			else
			$this->attente();*/
			$this->mobileCalendar($this->data);
		}
		else
		{
			if($this->is_ajax()){
				
				/* if(preg_match('/MSIE/i',$_SERVER['HTTP_USER_AGENT'])){
					$post = $this->input->post('message');
					$datatemp = json_decode($post,TRUE);
					$this->data['scenario'] = $datatemp['salle'];
					$this->data['idresamaintien'] = $datatemp['idresamaintien'];
					
				}
				else { */
					$post = $this->input->post('message');
					$data = json_decode($post,TRUE);
					$this->data['scenario'] = $data['salle'];
					$idresa = $data['idresamaintien'];
					
					
					if ($idresa !='') {
						$resa = $this->ReservationModel->getData('reservation', ['id' => $idresa]);
						$this->data['idresamaintien'] = $idresa;
						$this->data['sallemaintien'] = $resa->id_salle;
						$this->data['nbjoueursmaintien'] = $resa->joueurs;
					}
					$this->data['nbjoueurs'] = $data['nbjoueurs'];
				//}
				$salle = $this->ReservationModel->getData('salle',["id" => $this->data['scenario']]);
				$this->data['caract'] = $salle->caract;
				
			} elseif($this->uri->segment(2))
			{
				$salle = $this->ReservationModel->getData('salle', array('slug' => $this->uri->segment(2)));
				$this->data['scenario'] = $salle->id;
				$this->data['caract'] = $salle->caract;
			}
			//$this->data['salles'] = $this->ReservationModel->getList('salle', array('active' => 1));
			
			$activeroom = $this->ReservationModel->getList('salle', array('active' => 1));
			
			foreach ($activeroom as $k => $v) {
				
				$test = $this->getEmptyPrice($activeroom[$k]->id);
				
				if(!empty($test['empty_we']) || !empty($test['empty_sem'])){
					unset($activeroom[$k]);
				}
			}
			
			$this->data['salles'] = $activeroom;
			
			if($this->is_ajax()){
				echo  $this->data['vue'] = $this->load->view('/front/calendrier', $this->data, true);
				return;
			}
			$this->data['vue'] = $this->load->view('/front/calendrier', $this->data, true);
			$this->load->view('/front/home', $this->data);
		}

	}
	public function attente()
	{
		$this->load->view('/front/attente', $this->data);
	}
	public function form()
	{
		/* if(preg_match('/MSIE/i',$_SERVER['HTTP_USER_AGENT'])){
			$post = $this->input->post('message');
			$this->data = json_decode($post,TRUE);
		}
		else { */
			$post = $this->input->post('message');
			$this->data = json_decode($post,TRUE);
		//}
		
		$this->data['salle_nfo'] = $this->ReservationModel->getData('salle', array('id' => $this->data['salle']));
		//test de resa sans popup
		/**$this->data['vue'] = $this->load->view('/front/form', $this->data, true);
		$this->load->view('/front/home', $this->data);**/
		$vue = $this->load->view('/front/form', $this->data, true);
		$datas = array(
			'rPop' => $vue,
			'rPopTitle' => $this->data['titre'],
			'rPopClass' => (isset($this->data['class']))?$this->data['class']:''
		);
		echo json_encode($datas);
	}
	
	/**
	 * [add description]
	 */
	public function add()
	{
		// $this->output->enable_profiler(TRUE);
		/* if(preg_match('/MSIE/i',$_SERVER['HTTP_USER_AGENT'])){
			$post = $this->input->post('message');
			$data = json_decode($post,TRUE);
		}
		else { */
			$post = $this->input->post('message');
			$data = json_decode($post,TRUE);
		//}
		if(!$this->verifDispo($data['jour'],$data['horaire'],$data['salle'],$data['id_resa']))
		{
			$datas = array(
				'rPop' => 'Ce créneau horaire est en cours de réservation<br />Sélectionnez en un autre ou réessayez d\'ici 15mn',
				'rPopTitle' => 'Réservation impossible',
				'rPopClass' => 'alerte'
			);
			echo json_encode($datas);
			exit;
		}
		$verification = $this->ReservationModel->getData('client', array('email' => $data['email']));
		$data['client_id'] = ($verification !== FALSE)?$verification->id:'';
		$dernieremodif = time();
		$formatmodif = date('Y-m-d H:i:s', $dernieremodif);
		$datas = array(
			'civil' => $data['civil'],
			'nom' => $data['nom'],
			'prenom' => $data['prenom'],
			'email' => $data['email'],
			'tel' => $data['tel'],
			'login' => $data['login'],
			'derniere_modif' => $formatmodif
		);
		if($data['password'] != '' && md5($data['password']) != $data['old_pass'])
		$datas['password'] = md5($data['password']);
		if($data['client_id'] != '')
		$this->ReservationModel->updateData('client', $datas, array('id' => $data['client_id']));
		else
		$data['client_id'] = $this->ReservationModel->setData('client', $datas, true);
		$data['remise'] = 0;
		$data['prix'] = $data['regler'] = modules::run('tarifs/admin/Tarifsadmin/getPrice',$data['jour'],$data['horaire'],$data['joueurs'],$data['salle'],'');
		$data['promo'] = $this->ReservationModel->get_active_promo();
		if( $data['promo'] !== FALSE )
		{
			foreach ($data['promo'] as $val) {
				if($val->code == $data['voucher']) {
					if($val->is_global == 1)
					{
						switch ($val->type_promo)
						{
							case '%':
							$data['remise'] = $data['prix'] * $val->taux / 100;
							break;
							case '€':
							$data['remise'] = $val->taux;
							if ($data['remise']>=$data['prix']) $data['remise'] = $data['prix'];
							break;
						}
						break;
					}
					else
					{
						$salles = explode('|',$val->salles);
						if(in_array($data['salle'],$salles))
						{
							switch ($val->type_promo)
							{
								case '%':
								$data['remise'] = $data['prix'] * $val->taux / 100;
								break;
								case '€':
								$data['remise'] = $val->taux;
								if ($data['remise']>=$data['prix']) $data['remise'] = $data['prix'];
								break;
							}
							break;
						}
					}
				}
			}
		}
		$data['montant_voucher'] = 0;
		$data['solde'] = 0;
		$test = [];
		if($data['id_resa'] != '')
		{
			$test = $this->ReservationModel->getData('reservation', array('id' => $data['id_resa']));
		}
		if($data['voucher'] != '')
		{
			$voucher = $this->ReservationModel->getData('voucher', 'code = "' . $data['voucher'] . '" AND valide = 1');
		}
		if($data['voucher'] != '' && ($data['id_resa'] == '' || ($data['id_resa'] != '' && $test->voucher == '0')))
		{
			if($voucher !== FALSE)
			{
				if($voucher->montant >= $data['prix'])
				{
					$data['montant_voucher'] = $data['prix'];
				}
				else
				{
					$data['montant_voucher'] = $voucher->montant;
				}
				//$this->ReservationModel->updateData('voucher', ['valide' => 0], ['code' => $data['voucher']]);
				$data['regler'] = $data['prix'] - $data['remise'] - $data['montant_voucher'];
				$data['solde'] = $voucher->montant - $data['remise'];
			}
		}
		elseif($data['id_resa'] != '' && $test->voucher != '0' && $voucher != FALSE)
		{

			$voucher = $this->ReservationModel->getData('voucher', 'code = "' . $data['voucher'] . '" AND valide = 1');
			$tot_voucher = $voucher->montant + $test->remise;
			if($tot_voucher >= $data['prix'])
			{
				$data['montant_voucher'] = $data['prix'];
			}
			else
			{
				$data['montant_voucher'] = $tot_voucher;
			}
			//$this->ReservationModel->updateData('voucher', ['valide' => 0], ['code' => $data['voucher']]);
			$data['regler'] = $data['prix'] - $data['remise'] - $data['montant_voucher'];
			$data['solde'] = $tot_voucher - $data['remise'];
		}

		$data['room'] = $this->ReservationModel->getData('salle', ['id' => $data['salle']]);

		$data['total'] = $data['prix'] - $data['remise'] - $data['montant_voucher'];
		
		$dernieremodif = time();
		$formatmodif = date('Y-m-d H:i:s', $dernieremodif);
		$resa = array(

			'id_client' => $data['client_id'],

			'id_salle' =>$data['salle'],
			'jour' => $data['jour'],
			'horaire' => $data['horaire'],
			'joueurs' => $data['joueurs'],
			'prix' => $data['regler'],
			'regle' => 0,
			'valide' => 0,
			'scenario' => $data['room']->nom,
			'cle' => sha1(time()),
			'voucher' => $data['voucher'],
			'remise' => $data['remise'],
			'derniere_modif' => $formatmodif			
		);
		if($data['id_resa'] == '')
		$data['id'] = $this->ReservationModel->setData('reservation', $resa, true);
		else
		{
			$this->ReservationModel->updateData('reservation', $resa, array('id' => $data['id_resa']));
			$data['id'] = $data['id_resa'];
		}
		$this->ReservationModel->deleteData('joueurs', array('id_reservation' => $data['id']));
		if($data['id'] != '')
		{
			// renseignement autres joueurs
			for($i = 1; $i < PLAYERS_MAX; $i++)
			{
				if(isset($data['joueur' . $i]) && $data['joueur' . $i] != '')
				{
					$joueur = array(
						'id_reservation' => $data['id'],
						'civil' => '',
						'nom' => '',
						'prenom' => '',
						'email' => $data['joueur' . $i]
					);
					$this->ReservationModel->setData('joueurs', $joueur);
				}
			}
			$txt = $this->load->view('/front/recapitulatif', $data, true);
			$titre = 'Récapitulatif de votre réservation';
			$class = 'success';
		}
		else
		{
			$titre = 'Erreur';
			$txt = 'Une erreur est survenue, merci de recommencer';
			$class = 'alerte';
		}
		$datas = array(
			'rPop' => $txt,
			'rPopTitle' => $titre,
			'rPopClass' => $class
		);
		echo json_encode($datas);
	}


	public function mobileAdd()
	{
		$data = array();
		$post = $this->input->post();
		foreach($post as $k=>$v)
		{
			$data[$k] = $v;
			$this->session->set_userdata($k, $v);
		}
		//mail('xavier.tezza@comnstay.fr','test',print_r($data, true));
		if(!$this->verifDispo($data['jour'],$data['horaire'],$data['salle']))
		{
			$this->session->set_flashdata('toLate', 'Ce créneau horaire est en cours de réservation<br />Sélectionnez en un autre ou réessayez d\'ici 15mn');
			redirect($data['origine']);
			exit;
		}
		$verification = $this->ReservationModel->getData('client', array('email' => $data['email']));
		$data['client_id'] = ($verification !== FALSE)?$verification->id:'';
		$dernieremodif = time();
		$formatmodif = date('Y-m-d H:i:s', $dernieremodif);
		$datas = array(
			'civil' => $data['civil'],
			'nom' => $data['nom'],
			'prenom' => $data['prenom'],
			'email' => $data['email'],
			'tel' => $data['tel'],
			'login' => $data['login'],
			'derniere_modif' => $formatmodif	
		);
		if($data['password'] != '' && md5($data['password']) != $data['old_pass'])
		$datas['password'] = md5($data['password']);
		if($data['client_id'] == '')
		$data['client_id'] = $this->ReservationModel->setData('client', $datas, true);
		else
		$this->ReservationModel->updateData('client', $datas, array('id' => $data['client_id']));
		$this->session->set_userdata('client_id', $data['client_id']);
		$data['remise'] = 0;
		$data['prix'] = modules::run('tarifs/admin/Tarifsadmin/getPrice',$data['jour'],$data['horaire'],$data['joueurs'],$data['salle'],'');
		$data['promo'] = $this->ReservationModel->get_active_promo();
		if( $data['promo'] !== FALSE )
		{
			foreach ($data['promo'] as $val) {
				if($val->code == $data['voucher']) {
					if($val->is_global == 1)
					{
						switch ($val->type_promo)
						{
							case '%':
							$data['remise'] = $data['prix'] * $val->taux / 100;
							break;
							case '€':
							$data['remise'] = $val->taux;
							if ($data['remise']>=$data['prix']) $data['remise'] = $data['prix'];
							break;
						}
						break;
					}
					else
					{
						$salles = explode('|',$val->salles);
						if(in_array($data['salle'],$salles))
						{
							switch ($val->type_promo)
							{
								case '%':
								$data['remise'] = $data['prix'] * $val->taux / 100;
								break;
								case '€':
								$data['remise'] = $val->taux;
								if ($data['remise']>=$data['prix']) $data['remise'] = $data['prix'];
								break;
							}
							break;
						}
					}
				}
			}
		}
		$data['montant_voucher'] = 0;
		$data['solde'] = 0;
		$test = [];
		if($data['id_resa'] != '')
		{
			$test = $this->ReservationModel->getData('reservation', array('id' => $data['id_resa']));
		}
		if($data['voucher'] != '')
		{
			$voucher = $this->ReservationModel->getData('voucher', 'code = "' . $data['voucher'] . '" AND valide = 1');
		}
		if($data['voucher'] != '' && ($data['id_resa'] == '' || ($data['id_resa'] != '' && $test->voucher == '0')))
		{
			if($voucher !== FALSE)
			{
				if($voucher->montant >= $data['prix'])
				{
					$data['montant_voucher'] = $data['prix'];
				}
				else
				{
					$data['montant_voucher'] = $voucher->montant;
				}
				//$this->ReservationModel->updateData('voucher', ['valide' => 0], ['code' => $data['voucher']]);
				$data['regler'] = $data['prix'] - $data['remise'] - $data['montant_voucher'];
				$data['solde'] = $voucher->montant - $data['remise'];
			}
		}
		elseif($data['id_resa'] != '' && $test->voucher != '0' && $voucher != FALSE)
		{

			$voucher = $this->ReservationModel->getData('voucher', 'code = "' . $data['voucher'] . '" AND valide = 1');
			$tot_voucher = $voucher->montant + $test->remise;
			if($tot_voucher >= $data['prix'])
			{
				$data['montant_voucher'] = $data['prix'];
			}
			else
			{
				$data['montant_voucher'] = $tot_voucher;
			}
			//$this->ReservationModel->updateData('voucher', ['valide' => 0], ['code' => $data['voucher']]);
			$data['regler'] = $data['prix'] - $data['remise'] - $data['montant_voucher'];
			$data['solde'] = $tot_voucher - $data['remise'];
		}
		$data['room'] = $this->ReservationModel->getData('salle', array('id' => $data['salle']));				
		$data['total'] = $data['prix'] - $data['remise'] - $data['montant_voucher'];
		$dernieremodif = time();
		$formatmodif = date('Y-m-d H:i:s', $dernieremodif);
		$resa = array(
			'id_client' => $data['client_id'],
			'id_salle' =>$data['salle'],
			'jour' => $data['jour'],
			'horaire' => $data['horaire'],
			'joueurs' => $data['joueurs'],
			'prix' => $data['prix'] - $data['remise'],
			'regle' => 0,
			'valide' => 0,
			'scenario' => $data['room']->nom,
			'cle' => sha1(time()),
			'voucher' => $data['voucher'],
			'remise' => $data['remise'],
			'derniere_modif' => $formatmodif				
		);
		$data['id'] = $this->ReservationModel->setData('reservation', $resa, true);
		$this->session->set_userdata('id_resa', $data['id']);
		$this->ReservationModel->deleteData('joueurs', array('id_reservation' => $data['id']));
		if($data['id'] != '')
		{
			// renseignement autres joueurs
			for($i = 1; $i < PLAYERS_MAX; $i++)
			{
				if(isset($data['joueur' . $i]) && $data['joueur' . $i] != '')
				{
					$joueur = array(
						'id_reservation' => $data['id'],
						'civil' => '',
						'nom' => '',
						'prenom' => '',
						'email' => $data['joueur' . $i]
					);
					$this->ReservationModel->setData('joueurs', $joueur);
				}
			}
		}
		require_once('../application/libraries/MoneticoPaiement_Hmac.php');
		$resa = $this->ReservationModel->getData('reservation', array('id' => $data['id']));
		$client =  $this->ReservationModel->getData('client', array('id' => $resa->id_client));
		$this->data['cle'] = $resa->cle;
		$this->data['sReference'] = $resa->id;
		$this->data['sMontant'] = number_format($resa->prix,2,'.',',');
		$this->data['sDevise']  = "EUR";
		$this->data['sTexteLibre'] = "Id réservation : " . $resa->id . "\r\n " . $client->civil . " " . $client->nom . " " . $client->prenom . " \r\n Tel : " . $client->tel . "\r\n " . $resa->scenario . " " . $resa->jour . " " . $resa->horaire . " " . $resa->joueurs . " joueurs";
		$this->data['sTexteLibre'] .= " \r\n mail : " . $client->email;
		$this->data['sDate'] = date("d/m/Y:H:i:s");
		$this->data['sLangue'] = "FR";
		$this->data['sEmail'] = $client->email;
		$this->data['sOptions'] = "";
		$this->data['sNbrEch'] = "";
		$this->data['sDateEcheance1'] = "";
		$this->data['sMontantEcheance1'] = "";
		$this->data['sDateEcheance2'] = "";
		$this->data['sMontantEcheance2'] = "";
		$this->data['sDateEcheance3'] = "";
		$this->data['sMontantEcheance3'] = "";
		$this->data['sDateEcheance4'] = "";
		$this->data['sMontantEcheance4'] = "";
		$this->data['oEpt'] = new MoneticoPaiement_Ept($this->data['sLangue']);
		$oHmac = new MoneticoPaiement_Hmac($this->data['oEpt']);
		$this->data['CtlHmac'] = sprintf(MONETICOPAIEMENT_CTLHMAC, $this->data['oEpt']->sVersion, $this->data['oEpt']->sNumero, $oHmac->computeHmac(sprintf(MONETICOPAIEMENT_CTLHMACSTR, $this->data['oEpt']->sVersion, $this->data['oEpt']->sNumero)));
		$phase1go_fields = sprintf(MONETICOPAIEMENT_PHASE1GO_FIELDS,     $this->data['oEpt']->sNumero,
		$this->data['sDate'],
		$this->data['sMontant'],
		$this->data['sDevise'],
		$this->data['sReference'],
		$this->data['sTexteLibre'],
		$this->data['oEpt']->sVersion,
		$this->data['oEpt']->sLangue,
		$this->data['oEpt']->sCodeSociete,
		$this->data['sEmail'],
		$this->data['sNbrEch'],
		$this->data['sDateEcheance1'],
		$this->data['sMontantEcheance1'],
		$this->data['sDateEcheance2'],
		$this->data['sMontantEcheance2'],
		$this->data['sDateEcheance3'],
		$this->data['sMontantEcheance3'],
		$this->data['sDateEcheance4'],
		$this->data['sMontantEcheance4'],
		$this->data['sOptions']);
		$this->data['sMAC'] = $oHmac->computeHmac($phase1go_fields);
		$this->data += $data;
		$this->load->view('/front/mobileRecapitulatif', $this->data);
	}
	/**
	 * [calendar description]
	 * @param  int $scenario [description]
	 * @return [type]            [description]
	 */
	public function calendar($scenario = 0,$idresamaintien =''){
		/* $mess_datas = array(
			'dest' => 'ayumu.hyjal@gmail.com',
			'sujet' => 'test',
			'content' => 'testcontenu'
		);
		modules::run('message', json_encode($mess_datas)); */
		$day = (date('N') - 1);
		$diff = $day * 86400;
		$this->data['start'] = (time() - $diff);
		$salle = $scenario;
		//$this->data['tititoto'] = $idresamaintien;

		if($this->input->post('message'))
		{
			$post = $this->input->post('message');
			$data = json_decode($post,TRUE);
			// $data = $this->input->post();
			$this->data['start'] = isset($data['start'])?$data['start']:$this->data['start'];
			if(strpos($this->data['start'],'-') !== FALSE){
				$this->data['start'] = strtotime($this->data['start']);
			}
			$salle = isset($data['salle'])?$data['salle']:$salle;
			
			$resaid = (isset($data['idresamaintien'])&&$data['idresamaintien'] !='')?$data['idresamaintien']:$idresamaintien;
			$resa = $this->ReservationModel->getData('reservation', ['id' => $resaid]);
			$this->data['jourmaintien'] = $resa->jour;
			$this->data['horairemaintien'] = $resa->horaire;
			$this->data['sallemaintien'] = $resa->id_salle;

			if(isset($data['addIndispo']) && $data['addIndispo'] == 1){
				$this->data['addIndispo'] = TRUE;
			} else {
				$this->data['addIndispo'] = FALSE;

			}
		}
		// $cur = localtime(time(), true);
		// $this->data['current'] = $cur['tm_hour'].':00';
		$this->data['current'] = (new DateTime())->format('H:i');
		$this->data['week'] = (time() - $diff);
		$this->data['prev'] = $this->data['start'] - 604800;
		$this->data['next'] = $this->data['start'] + 604800;
		$this->data['next_mounth'] = $this->data['start'] + 2419200;
		$this->data['prev_mounth'] = $this->data['start'] - 2419200;
		if($day == -1){
			$this->data['start'] = $this->data['start'] - 604800;
		}


		$start_search = date('Y-m-d', $this->data['start']);
		$end_search = date('Y-m-d', $this->data['next']);
		$horaire = $this->ReservationModel->getHoraireSet($salle,$start_search,$end_search);
		$tab = [];
		$this->data['resas'] = $this->ReservationModel->getListByDate($salle, $start_search, $end_search);
		$this->data['indisps'] = $this->ReservationModel->getIndispoListByDate($salle, $start_search, $end_search);
		$this->data['start_s'] = $start_search;
		$this->data['salle'] = $salle;

		foreach ($horaire['set'] as $value) {
			if($value->hor_day == 'all'){
				for ($i=1; $i <=7 ; $i++) {
					$tab[$value->hor_start][$i] = 1;
				}
			} else {
				$open_days = explode(',',$value->hor_day);
				for ($i=1; $i <=7 ; $i++) {
					($tab[$value->hor_start][$i] = in_array($i, $open_days)? 1 : 0);

				}
			}

		}
		$this->data['horaire'] = $tab;
		$this->data['totalresa'] = $this->ReservationModel->getAllRoomsListByDate($start_search, $end_search);
		$this->data['nbmaxperma'] = $this->ReservationModel->getData('nombre_salles_max', ['id' => 1]);
		$this->data['nbmaxweek'] = $this->ReservationModel->getData('nombre_salles_max', ['id' => 2]);
		$this->data['nbmaxperiod'] = $this->ReservationModel->getData('nombre_salles_max', ['id' => 3]);
		if($this->is_ajax())
		{
			$vue = $this->load->view('/front/calendar', $this->data);
			echo $vue;
		}
		else{
			return $this->load->view('/front/calendar', $this->data, true);
		}
	}

	public function getNbmax($id = 1, $nbjoueursmaintien = ''){
		if( $this->input->post('message') )
		{
			$post = $this->input->post('message');
			$data = json_decode($post,TRUE);
			if ( isset($data['salle']) )
			{
				$id = $data['salle'];
			}
		}
		$res = $this->ReservationModel->getData('salle', ['id' => $id], ['nbmin','nbmax']);
		$this->data['nbmax'] = $res->nbmax;
		$this->data['nbmin'] = $res->nbmin;
		$this->data['nbjoueursmaint'] = $nbjoueursmaintien;
		if($this->is_ajax())
		{
			echo $this->load->view('/front/joueurs', $this->data);
		}
		else
		{
			return $this->load->view('/front/joueurs', $this->data, true);
		}
	}

	public function mobileCalendar()
	{
		
		$sec = 86400;
		
			
 		if ($_GET['date'] !='') {
			$this->data['start'] = $_GET['date'];
		} 
		
		if ($_GET['nbjoueurs'] != '') {
			$this->data['nb_joueurs'] = $_GET['nbjoueurs'];
		}
		
		if ($_GET['horaire'] != '') {
			$this->data['horaire_selected'] = $_GET['horaire'];
		} 
		
		if ($this->session->userdata('civil') !='') {
			$this->data['civil'] = $this->session->userdata('civil');
		}
		
		if ($this->session->userdata('voucher') !='') {
			$this->data['voucher'] = $this->session->userdata('voucher');
		}
		
		if ($_GET['salle'] != '') {

			$salle = $this->ReservationModel->getData('salle', array('slug' => $_GET['salle']));
			$this->data['scenario'] = $salle->id;
	
			$this->data['current_salle'] = $this->ReservationModel->getData('salle', array('id' => $this->data['scenario']));
			$this->data['id_resa'] = '';
			
			
			
			$this->data['prev'] = $this->data['start'] - 86400;
			$this->data['next'] = $this->data['start'] + 86400;
			$start_search = date('Y-m-d', $this->data['start']);
			$end_search = date('Y-m-d', $this->data['next']);
			$horaire = $this->ReservationModel->getHoraireSet($this->data['current_salle']->id,$start_search,$end_search);
			$tab = [];

			foreach ($horaire['set'] as $value) {
				if($value->hor_day == 'all'){
					for ($i=1; $i <=7 ; $i++) {
						$tab[$value->hor_start][$i] = 1;
					}
				} else {
					$open_days = explode(',',$value->hor_day);
					for ($i=1; $i <=7 ; $i++) {
						($tab[$value->hor_start][$i] = in_array($i, $open_days)? 1 : 0);

					}
				}

			}
			$this->data['horaire'] = $tab;
			$this->data['totalresa'] = $this->ReservationModel->getAllRoomsListByDate($start_search, $end_search);
			$this->data['nbmaxperma'] = $this->ReservationModel->getData('nombre_salles_max', ['id' => 1]);
			$this->data['nbmaxweek'] = $this->ReservationModel->getData('nombre_salles_max', ['id' => 2]);
			$this->data['nbmaxperiod'] = $this->ReservationModel->getData('nombre_salles_max', ['id' => 3]);
	
			
			$cur = localtime(time(), true);
			$this->data['current'] = $cur['tm_hour'] + DELTA;
			
			$this->data['resas'] = $this->ReservationModel->getListByDate($this->data['scenario'], $start_search, $end_search);
			$this->data['indisps'] = $this->ReservationModel->getIndispoListByDate($this->data['scenario'], $start_search, $end_search);
			$this->data['totalresa'] = $this->ReservationModel->getAllRoomsListByDate($start_search, $end_search);
			$this->data['nbmaxperma'] = $this->ReservationModel->getData('nombre_salles_max', ['id' => 1]);
			$this->data['nbmaxweek'] = $this->ReservationModel->getData('nombre_salles_max', ['id' => 2]);
			$this->data['nbmaxperiod'] = $this->ReservationModel->getData('nombre_salles_max', ['id' => 3]);
		}
		
		if($this->uri->segment(3) && $this->uri->segment(3) == 'modifier')
			{
				$infos = $this->ReservationModel->getData('reservation', array('id' => $this->session->userdata('id_resa')));
				$this->ReservationModel->deleteData('reservation', array('id' => $this->session->userdata('id_resa')));
				$this->data['current_salle'] = $this->ReservationModel->getData('salle', array('id' => $this->session->userdata('salle')));
				$this->data['scenario'] = $this->data['current_salle']->id;
				$tempdate = new DateTime($infos->jour);
				$this->data['start'] = $tempdate->getTimestamp();
				$this->data['nb_joueurs'] = $infos->joueurs;
				$this->data['horaire_selected'] = $infos->horaire;
				$this->data['voucher'] = $infos->voucher;
				$this->data['id_resa'] = $this->session->userdata('id_resa');
				
				$this->data['prev'] = $this->data['start'] - 86400;
				$this->data['next'] = $this->data['start'] + 86400;
				$start_search = date('Y-m-d', $this->data['start']);
				$end_search = date('Y-m-d', $this->data['next']);
				$horaire = $this->ReservationModel->getHoraireSet($this->data['current_salle']->id,$start_search,$end_search);
				$tab = [];

				foreach ($horaire['set'] as $value) {
					if($value->hor_day == 'all'){
						for ($i=1; $i <=7 ; $i++) {
							$tab[$value->hor_start][$i] = 1;
						}
					} else {
						$open_days = explode(',',$value->hor_day);
						for ($i=1; $i <=7 ; $i++) {
							($tab[$value->hor_start][$i] = in_array($i, $open_days)? 1 : 0);

						}
					}

				}
				$this->data['horaire'] = $tab;
				$this->data['totalresa'] = $this->ReservationModel->getAllRoomsListByDate($start_search, $end_search);
				$this->data['nbmaxperma'] = $this->ReservationModel->getData('nombre_salles_max', ['id' => 1]);
				$this->data['nbmaxweek'] = $this->ReservationModel->getData('nombre_salles_max', ['id' => 2]);
				$this->data['nbmaxperiod'] = $this->ReservationModel->getData('nombre_salles_max', ['id' => 3]);
		
				
				$cur = localtime(time(), true);
				$this->data['current'] = $cur['tm_hour'] + DELTA;
				
				$this->data['resas'] = $this->ReservationModel->getListByDate($this->data['scenario'], $start_search, $end_search);
				$this->data['totalresa'] = $this->ReservationModel->getAllRoomsListByDate($start_search, $end_search);
				$this->data['nbmaxperma'] = $this->ReservationModel->getData('nombre_salles_max', ['id' => 1]);
				$this->data['nbmaxweek'] = $this->ReservationModel->getData('nombre_salles_max', ['id' => 2]);
				$this->data['nbmaxperiod'] = $this->ReservationModel->getData('nombre_salles_max', ['id' => 3]);
			}
		
		
		$this->data['salles'] = $this->ReservationModel->getList('salle', array('active' => 1));
		$this->data['vue'] = $this->load->view('/front/mobileCalendrier', $this->data, true);
		$this->load->view('/front/mobileHome', $this->data); 
	}
	/**
	 * [verifDispo description]
	 * @param  [type] $jour    [description]
	 * @param  [type] $horaire [description]
	 * @param  [type] $salle   [description]
	 * @param  string $id      [description]
	 * @return [type]          [description]
	 */
	public function verifDispo($jour, $horaire, $salle, $id = '')
	{
		$verif = $this->ReservationModel->getData('reservation', array('jour' => $jour, 'horaire' => $horaire, 'id_salle' => $salle));
		if($verif === FALSE || ($verif->id == $id))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function reload()
	{
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$this->data['resa'] = $this->ReservationModel->getData('reservation', array('id' => $data['id']));
		$data['room'] = $this->ReservationModel->getData('salle', array('id' => $this->data['resa']->id_salle));
		$this->data['joueurs'] =  $this->ReservationModel->getList('joueurs', array('id_reservation' => $data['id']));
		$this->data['client'] =  $this->ReservationModel->getData('client', array('id' => $this->data['resa']->id_client));
		$data['civil'] = $this->data['client']->civil;
		$data['nom'] = $this->data['client']->nom;
		$data['prenom'] = $this->data['client']->prenom;
		$data['email'] = $this->data['client']->email;
		$data['tel'] = $this->data['client']->tel;
		$data['prix'] = $this->data['resa']->prix;
		$data['remise'] = $this->data['resa']->remise;
		$data['voucher'] = $this->data['resa']->voucher;
		$voucher = $this->ReservationModel->getData('voucher', array('code' => $data['voucher']));
		if ($voucher->montant>$data['prix']) {
			$data['montant_voucher'] = $data['prix'];
		}
		else {
			$data['montant_voucher'] = $voucher->montant;
		}
		$data['total'] = $data['prix'] - $data['remise'] - $data['montant_voucher'];
		$data['horaire'] = $this->data['resa']->horaire;
		$data['jour'] = $this->data['resa']->jour;
		$i = 1;
		foreach($this->data['joueurs'] as $joueur)
		{
			$data['joueur' . $i] = $joueur->email;
			$i++;
		}
		$datas = array(
			'rPop' => $this->load->view('/front/recapitulatif', $data, true),
			'rPopTitle' => 'Récapitulatif de votre réservation',
			'rPopClass' => 'success'
		);
		echo json_encode($datas);
	}
	public function modif()
	{
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);	
		$data['resa'] = $this->ReservationModel->getData('reservation', array('id' => $data['id']));
		$datasalle = (!$data['salle'])?$data['resa']->id_salle:$data['salle'];
		$data['salle_nfo'] = $this->ReservationModel->getData('salle', array('id' => $datasalle));
		$data['joueurs'] =  $this->ReservationModel->getList('joueurs', array('id_reservation' => $data['id']));
		$this->data['client'] =  $this->ReservationModel->getData('client', array('id' => $data['resa']->id_client));
		$data['civil'] = $this->data['client']->civil;
		$data['nom'] = $this->data['client']->nom;
		$data['prenom'] = $this->data['client']->prenom;
		$data['email'] = $this->data['client']->email;
		$data['tel'] = $this->data['client']->tel;
		$data['prix'] = $data['resa']->prix;
		if (!$data['horaire']) $data['horaire'] = $data['resa']->horaire;
		if (!$data['jour']) $data['jour'] = $data['resa']->jour;
		if (!$data['nbJoueurs']) $data['nbJoueurs'] = $data['resa']->joueurs;
		$data['voucher'] = $data['resa']->voucher;
		$data['remise'] = $data['resa']->remise;
		if ($data[typemodif] == 'modif_resa_voucher') $titre = 'Code promo / Carte cadeau';
		else if ($data[typemodif] == 'modif_resa_coord') $titre = 'Modification de vos coordonnées';
		else $titre = 'Modification de votre réservation';
		$i = 1;
		foreach($data['joueurs'] as $joueur)
		{
			$data['joueur' . $i] = $joueur->email;
			$i++;
		}
		$datas = array(
			'rPop' => $this->load->view('/front/form', $data, true),
			'rPopTitle' => $titre,
			'rPopClass' => 'success'
		);
		echo json_encode($datas);
	}
	public function order()
	{
		require_once('../application/libraries/MoneticoPaiement_Hmac.php');
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		
		$_SESSION['resaid'] = $data['id'];
		$resa = $this->ReservationModel->getData('reservation', array('id' => $data['id']));
		$client =  $this->ReservationModel->getData('client', array('id' => $resa->id_client));
		
		$this->data['cle'] = $resa->cle;
		$this->data['sReference'] = $resa->id;
		$this->data['sMontant'] = number_format($resa->prix,2,'.',',');
		$this->data['sDevise']  = "EUR";
		$this->data['sTexteLibre'] = "Id réservation : " . $resa->id . "\r\n " . $client->civil . " " . $client->nom . " " . $client->prenom . " \r\n Tel : " . $client->tel . "\r\n " . $resa->scenario . " " . $resa->jour . " " . $resa->horaire . " " . $resa->joueurs . " joueurs";
		$this->data['sTexteLibre'] .= " \r\n mail : " . $client->email;
		$this->data['sDate'] = date("d/m/Y:H:i:s");
		$this->data['sLangue'] = "FR";
		$this->data['sEmail'] = $client->email;
		$this->data['sOptions'] = "";
		$this->data['sNbrEch'] = "";
		$this->data['sDateEcheance1'] = "";
		$this->data['sMontantEcheance1'] = "";
		$this->data['sDateEcheance2'] = "";
		$this->data['sMontantEcheance2'] = "";
		$this->data['sDateEcheance3'] = "";
		$this->data['sMontantEcheance3'] = "";
		$this->data['sDateEcheance4'] = "";
		$this->data['sMontantEcheance4'] = "";
		
		$this->data['oEpt'] = new MoneticoPaiement_Ept($this->data['sLangue']);
		$oHmac = new MoneticoPaiement_Hmac($this->data['oEpt']);
		$this->data['CtlHmac'] = sprintf(MONETICOPAIEMENT_CTLHMAC, $this->data['oEpt']->sVersion, $this->data['oEpt']->sNumero, $oHmac->computeHmac(sprintf(MONETICOPAIEMENT_CTLHMACSTR, $this->data['oEpt']->sVersion, $this->data['oEpt']->sNumero)));
		$phase1go_fields = sprintf(MONETICOPAIEMENT_PHASE1GO_FIELDS,     $this->data['oEpt']->sNumero,
								$this->data['sDate'],
								$this->data['sMontant'],
								$this->data['sDevise'],
								$this->data['sReference'],
								$this->data['sTexteLibre'],
								$this->data['oEpt']->sVersion,
								$this->data['oEpt']->sLangue,
								$this->data['oEpt']->sCodeSociete,
								$this->data['sEmail'],
								$this->data['sNbrEch'],
								$this->data['sDateEcheance1'],
								$this->data['sMontantEcheance1'],
								$this->data['sDateEcheance2'],
								$this->data['sMontantEcheance2'],
								$this->data['sDateEcheance3'],
								$this->data['sMontantEcheance3'],
								$this->data['sDateEcheance4'],
								$this->data['sMontantEcheance4'],
								$this->data['sOptions']);
		$this->data['sMAC'] = $oHmac->computeHmac($phase1go_fields);
		
		$datas = array(
			'form' => $this->load->view('/front/orderForm', $this->data, true),
		);
		log_message('info', 'paiement aller : ' . $this->data['sTexteLibre'] . ' ' .$resa->time_resa);
		echo json_encode($datas);
	}
	public function orderConfirm()
	{
		require_once('../application/libraries/MoneticoPaiement_Hmac.php');
		$MoneticoPaiement_bruteVars = getMethode();
		
		// TPE init variables
		$oEpt = new MoneticoPaiement_Ept();
		$oHmac = new MoneticoPaiement_Hmac($oEpt);
		
		// Message Authentication
		$phase2back_fields = sprintf(MONETICOPAIEMENT_PHASE2BACK_FIELDS, $oEpt->sNumero,
								$MoneticoPaiement_bruteVars["date"],
								$MoneticoPaiement_bruteVars['montant'],
								$MoneticoPaiement_bruteVars['reference'],
								$MoneticoPaiement_bruteVars['texte-libre'],
								$oEpt->sVersion,
								$MoneticoPaiement_bruteVars['code-retour'],
								$MoneticoPaiement_bruteVars['cvx'],
								$MoneticoPaiement_bruteVars['vld'],
								$MoneticoPaiement_bruteVars['brand'],
								$MoneticoPaiement_bruteVars['status3ds'],
								$MoneticoPaiement_bruteVars['numauto'],
								$MoneticoPaiement_bruteVars['motifrefus'],
								$MoneticoPaiement_bruteVars['originecb'],
								$MoneticoPaiement_bruteVars['bincb'],
								$MoneticoPaiement_bruteVars['hpancb'],
								$MoneticoPaiement_bruteVars['ipclient'],
								$MoneticoPaiement_bruteVars['originetr'],
								$MoneticoPaiement_bruteVars['veres'],
								$MoneticoPaiement_bruteVars['pares']
							);
							
	if ($oHmac->computeHmac($phase2back_fields) == strtolower($MoneticoPaiement_bruteVars['MAC']))
	{
		
		switch($MoneticoPaiement_bruteVars['code-retour'])
		{
			case "Annulation" :
				break;
				
			case "payetest":
			case "paiement":
				$this->orderValid($MoneticoPaiement_bruteVars['reference']);
				break;
				
			case "paiement_pf2":
			case "paiement_pf3":
			case "paiement_pf4":
				break;
				
			case "Annulation_pf2":
			case "Annulation_pf3":
			case "Annulation_pf4":
				break;
		}
		$receipt = MONETICOPAIEMENT_PHASE2BACK_MACOK;
	}
	else
	{
		$this->orderDeny($MoneticoPaiement_bruteVars['reference']);
		$receipt = MONETICOPAIEMENT_PHASE2BACK_MACNOTOK.$phase2back_fields;
	}
	header("Pragma: no-cache");
	header("Content-type: text/plain");
	printf (MONETICOPAIEMENT_PHASE2BACK_RECEIPT, $receipt);
}
private function orderValid($id)
{

	
	if(preg_match('/^v/i', $id))
	{
		$id = substr($id,1);
		$this->ReservationModel->updateData('voucher', array('valide' => 1), array('id' => $id));
		$voucher = $this->ReservationModel->getData('voucher', array('id' => $id));
		$client =  $this->ReservationModel->getData('client', array('id' => $voucher->id_client));
		// envoi des mails au client
		$message = $this->ReservationModel->getData('email', array('action' => 'voucher_confirm'));
		$sujet = $message->sujet;
		$content = $message->message;
		$mess_datas = array(
			'dest' => $client->email,
			'sujet' => $sujet,
			'content' => $content,
			'id' => $id
		);
		modules::run('message', json_encode($mess_datas));
	}
	else
	{
		$this->ReservationModel->updateData('reservation', array('valide' => 1, 'regle' => 1), array('id' => $id));
		$resa = $this->ReservationModel->getData('reservation', array('id' => $id));
		$this->ReservationModel->updateData('voucher', array('valide' => 0), array('code' => $resa->voucher));
		$client =  $this->ReservationModel->getData('client', array('id' => $resa->id_client));
		$joueurs =  $this->ReservationModel->getList('joueurs', array('id_reservation' => $id));
		// envoi des mails au client
		$message = $this->ReservationModel->getData('email', array('action' => 'order_confirm'));
		$sujet = $message->sujet;
		$content = $message->message;
		$mess_datas = array(
			'dest' => $client->email,
			'sujet' => $sujet,
			'content' => $content,
			'id' => $id
		);
		modules::run('message', json_encode($mess_datas));
		$message = $this->ReservationModel->getData('email', array('action' => 'client_play_confirm'));
		$sujet = $message->sujet;
		$content = $message->message;
		$mess_datas = array(
			'dest' => $client->email,
			'sujet' => $sujet,
			'content' => $content,
			'id' => $id
		);
		modules::run('message', json_encode($mess_datas));
		// envoi du mail aux joueurs
		foreach($joueurs as $joueur)
		{
			$message = $this->ReservationModel->getData('email', array('action' => 'player_play_confirm'));
			$sujet = $message->sujet;
			$content = $message->message;
			$mess_datas = array(
				'dest' => $joueur->email,
				'sujet' => $sujet,
				'content' => $content,
				'id' => $id
			);
			modules::run('message', json_encode($mess_datas));
		}
		// message à l'admin
		$message = $this->ReservationModel->getData('email', array('action' => 'admin_alert'));
		$sujet = $message->sujet;
		$content = $message->message;
		$content .= 'Référence : '.$id;
		$mess_datas = array(
			'dest' => RESERVATION_EMAIL,
			'sujet' => $sujet,
			'content' => $content,
			'id' => $id
		);
		modules::run('message', json_encode($mess_datas));
	}
}
public function orderOk()
{
	//if(session_id()) $id = $_SESSION['resaid'];
	$id = $this->uri->segment(3);
	
/* 	if($this->input->post('id_resa'))
	{
		$this->orderValid($this->input->post('id_resa')); */
		
		if(preg_match('#^v#', $id)) {
			$this->data['retour'] = 'Validation achat carte cadeau';
			$this->data['resavoucher'] = 'voucher';
			$voucher = $this->ReservationModel->getData('voucher', array('id' => substr($id,1)));
			$vouchercode = $voucher->code;
			$this->data['link'] = APP_URL . '/voucher/pdf/' .$vouchercode;
		}
		else {
			$this->data['retour'] = 'Validation réservation';			
			$this->data['resavoucher'] = 'resa';
			
			if ($this->input->post('partieofferte')=="ok") {
				$this->data['partieofferte'] = "ok";
				$this->ReservationModel->updateData('voucher', array('valide' => 0), array('code' => $this->input->post('voucher')));
				$this->ReservationModel->updateData('reservation', array('valide' => 1, 'regle' => 1), array('voucher' => $this->input->post('voucher')));
				$resa = $this->ReservationModel->getData('reservation', array('id' => $this->input->post('id_resa')));
				$client =  $this->ReservationModel->getData('client', array('id' => $resa->id_client));
				$joueurs =  $this->ReservationModel->getList('joueurs', array('id_reservation' => $this->input->post('id_resa')));
				// envoi des mails au client
				$message = $this->ReservationModel->getData('email', array('action' => 'order_confirm'));
				$sujet = $message->sujet;
				$content = $message->message;
				$mess_datas = array(
					'dest' => $client->email,
					'sujet' => $sujet,
					'content' => $content,
					'id' => $this->input->post('id_resa')
				);
				modules::run('message', json_encode($mess_datas));
				$message = $this->ReservationModel->getData('email', array('action' => 'client_play_confirm'));
				$sujet = $message->sujet;
				$content = $message->message;
				$mess_datas = array(
					'dest' => $client->email,
					'sujet' => $sujet,
					'content' => $content,
					'id' => $this->input->post('id_resa')
				);
				modules::run('message', json_encode($mess_datas));
				// envoi du mail aux joueurs
				foreach($joueurs as $joueur)
				{
					$message = $this->ReservationModel->getData('email', array('action' => 'player_play_confirm'));
					$sujet = $message->sujet;
					$content = $message->message;
					$mess_datas = array(
						'dest' => $joueur->email,
						'sujet' => $sujet,
						'content' => $content,
						'id' => $this->input->post('id_resa')
					);
					modules::run('message', json_encode($mess_datas));
				}
				// message à l'admin
				$message = $this->ReservationModel->getData('email', array('action' => 'admin_alert'));
				$sujet = $message->sujet;
				$content = $message->message;
				$content .= '. Référence : '.$this->input->post('id_resa');
				$mess_datas = array(
					'dest' => RESERVATION_EMAIL,
					'sujet' => $sujet,
					'content' => $content,
					'id' => $this->input->post('id_resa')
				);
				modules::run('message', json_encode($mess_datas));
			}
		}		
	/* }
	else {
		$this->data['retour'] = 'Toto';
		//$this->data['messageretour'] = 'Titi';
	} */
		
	$this->data['vue'] = $this->load->view('/front/orderOk', $this->data, true);
	
	$detect = new Mobile_Detect();
	
	//$isPhone = $detect->isMobile() && !$detect->isTablet();
	
	if ($detect->isMobile()) $this->load->view('/front/mobileHome', $this->data);
	else $this->load->view('/front/homeResa', $this->data);
}
public function orderDeny()
{
	$this->session->sess_destroy();
	$this->clear_cache();
	
	$id = $this->uri->segment(3);
	
	if(preg_match('#^v#', $id)) {
		$this->data['retour'] = 'Annulation achat carte cadeau';
		$this->data['resavoucher'] = 'voucher';
		$this->ReservationModel->deleteData('voucher', array('id' => substr($id,1)));
	}
	else {
		$this->ReservationModel->deleteData('reservation', array('id' => $this->uri->segment(3)));
		$this->data['retour'] = 'Annulation réservation';			
		$this->data['resavoucher'] = 'resa';

	}
	/*$infos = $this->ReservationModel->getData('reservation', array('cle' => $this->uri->segment(3)));
	$this->ReservationModel->deleteData('reservation', array('cle' => $this->uri->segment(3)));
	 if($infos->voucher != '0')
	{
		$voucher = $this->ReservationModel->getData('voucher', array('code' => $infos->voucher));
		$this->ReservationModel->updateData('voucher', array('valide' => 1), array('id' => $voucher->id));
	} */
	
	$this->data['vue'] = $this->load->view('/front/orderKo', $this->data, true);
	
	$detect = new Mobile_Detect();
	
	//$isPhone = $detect->isMobile() && !$detect->isTablet();
	
	if ($detect->isMobile()) $this->load->view('/front/mobileHome', $this->data);
	else $this->load->view('/front/homeResa', $this->data);
}
public function mobileDelete()
{
	$infos = $this->ReservationModel->getData('reservation', array('id' => $this->session->userdata('id_resa')));
	$vérification = $this->ReservationModel->getNbData('reservation', array('id_client' => $this->session->userdata('client_id')));
	$this->ReservationModel->deleteData('reservation', array('id' => $this->session->userdata('id_resa')));
	if($vérification == 1)
	$this->ReservationModel->deleteData('client', array('id' => $this->session->userdata('client_id')));
	if($infos->voucher != '0')
	{
		$voucher = $this->ReservationModel->getData('voucher', array('code' => $infos->voucher));
		$this->ReservationModel->updateData('voucher', array('montant' => $voucher->montant + $infos->remise), array('id' => $voucher->id));
	}
	$this->ReservationModel->deleteData('joueurs', array('id_reservation' => $this->session->userdata('id_resa')));
	$this->session->set_flashdata('supprimer', 'Votre réservation à bien été supprimée');
	redirect($this->index);
}
public function cronCleaner()
{
	$cur = strtotime('-15 minutes');
	$date = date('Y-m-d H:i:s', $cur);
	$liste = $this->ReservationModel->getList('reservation', 'time_resa <= "' . $date . '" AND valide = 0');
	foreach($liste as $resa)
	{
		$this->ReservationModel->deleteData('reservation', array('id' => $resa->id));
		$this->ReservationModel->deleteData('client', array('id' => $resa->id_client));
		$this->ReservationModel->deleteData('joueurs', array('id_reservation' => $resa->id));
	}
}
public function cronReminder()
{
	$date = date('Y-m-d');
	$liste = $this->ReservationModel->getList('reservation', 'jour like "' . $date . '%" AND valide = 1');
	$message = $this->ReservationModel->getData('email', array('action' => 'mind_refresh'));
	foreach($liste as $resa)
	{
		$client = $this->ReservationModel->getData('client', array('id' => $resa->id_client));
		$joueurs = $this->ReservationModel->getList('joueurs', array('id_reservation' => $resa->id));
		// mail de rappel au client
		$sujet = $message->sujet;
		$content = $message->message;
		$mess_datas = array(
			'dest' => $client->email,
			'sujet' => $message->sujet,
			'content' => $message->message,
			'id' => $resa->id
		);
		modules::run('message', json_encode($mess_datas));
		// mail de rappel aux joueurs
		foreach($joueurs as $joueur)
		{
			$sujet = $message->sujet;
			$content = $message->message;
			$mess_datas = array(
				'dest' => $joueur->email,
				'sujet' => $message->sujet,
				'content' => $message->message,
				'id' => $resa->id
			);
			modules::run('message', json_encode($mess_datas));
		}
	}
}
public function changeUri()
{	
	$post = $this->input->post('message');
	$data = json_decode($post,TRUE);
	$infos = $this->ReservationModel->getData('salle', array('id' => $data['salle']));
	$return = array(
		'title' => $infos->nom,
		'url' => APP_URL . '/reservation/' . $infos->slug
	);
	echo json_encode($return);
}
public function changeMobileUri()
{
	
	if ($this->input->post('salle') !='') {
		$infos = $this->ReservationModel->getData('salle', array('id' => $this->input->post('salle')));
		$maintiensalle = 'salle='.$infos->slug.'&';
	}
	if ($this->input->post('start') !='') {
		$maintiendate = 'date='.$this->input->post('start').'&';
	}
	if ($this->input->post('nbjoueurs') !='') {
		$maintienjoueurs = 'nbjoueurs='.$this->input->post('nbjoueurs').'&';
	}
	if ($this->input->post('horaire') !='') {
		$maintienhoraire = 'horaire='.$this->input->post('horaire').'&';
	}
	if ($this->input->post('nom') !='') {
		$this->session->set_userdata('nom', $this->input->post('nom'));
	}
	if ($this->input->post('prenom') !='') {
		$this->session->set_userdata('prenom', $this->input->post('prenom'));
	}
	if ($this->input->post('email') !='') {
		$this->session->set_userdata('email', $this->input->post('email'));
	}
	if ($this->input->post('tel') !='') {
		$this->session->set_userdata('tel', $this->input->post('tel'));
	}
	if ($this->input->post('civil') !='') {
		$this->session->set_userdata('civil', $this->input->post('civil'));
	}
	if ($this->input->post('voucher') !='') {
		$this->session->set_userdata('voucher', $this->input->post('voucher'));
	}
	switch ($this->input->post('jump')) {
		
		case 'salle':
		$anchor = '#calendar';
		break;
		
		case 'nbjoueurs':
		$anchor = '#selectNbjoueurs';
		break;
		
		case 'date':
		$anchor = '#selectDate';
		break;
		
		case 'horaire':
		$anchor = '#selectHoraire';
		break;
		
		default:
		$anchor ='';
		break;
	}
	
	echo APP_URL . '/reservation/mobile?'. $maintiensalle.$maintiendate.$maintienjoueurs.$maintienhoraire.$anchor;
	

}
private function clear_cache()
{
	$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
	$this->output->set_header("Pragma: no-cache");
}

public function wrong_player_number()
	{
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$datas = array(
			'rPop' => $data['txt'],
			'rPopTitle' => $data['titre'],
			'rPopClass' => (isset($data['class']))?$data['class']:''
		);
		echo json_encode($datas);
	}
	
	public function getEmptyPrice($salle = 1){
		$tarif_set = $this->ReservationModel->getList('salle__tarif',['salle_id' => $salle]);
		$res = ['sem'=>[],'we'=>[],'spe'=> []];

		foreach ($tarif_set as $key) {
			$res[$key->type][] = $key->joueurs;
		}
		unset($tarif_set);
		$salle = $this->ReservationModel->getData('salle',["id" => $salle],['nom','nbmin','nbmax']);
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
}
