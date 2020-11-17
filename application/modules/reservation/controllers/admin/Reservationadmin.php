<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Reservationadmin extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('ReservationModel');
		$this->load->libraries(['form_validation','pagination']);

		// $this->load->helper('my_pagination');
		/**
		* css du module
		**/
		$this->data['module_css'] = load_module_css($this->data['module_css'], 'reservation');
		/**
		* js du module
		**/
		$this->data['module_js'] = load_module_js($this->data['module_js'],'reservation');
	}
	public function listing($offset = 0)
	{
		$resindis = "resa";
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);

		$this->data['reservations'] = $this->ReservationModel->getReservationList();
		$this->data['salles'] = $this->ReservationModel->getList('salle');
		$this->data['resindis'] = $resindis;

		if($this->input->is_ajax_request())
		{
			$vue = $this->load->view('/admin/liste', $this->data);
			echo $vue;
		}
		else
		{
			$this->data['calendar'] = $this->calendar();
			$vue = $this->load->view('/admin/listing', $this->data, true);
			return $vue;
		}


/* 		$pag = PAGINATION;
		$resindis = "resa";

		if($this->session->has_userdata('pag_r'))
		{
			$pag = $this->session->pag_r;
		}

		if($this->session->has_userdata('resindis_r'))
		{
			$resindis = $this->session->resindis_r;
		}



		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);

		if( ! empty($data['pag']))
		{
			$pag = $data['pag'];
			$this->session->pag_r = $pag;
		}

		if( ! empty($data['resindis']))
		{
			$resindis = $data['resindis'];
			$this->session->resindis_r = $resindis;
		}


		$offset = $this->uri->segment(3,0);

		$limit = [$pag,$offset];
		$this->session->limit = $limit;
		$this->data['nbRes'] = $this->ReservationModel->getNbData('reservation', 'id_client != 0');

		$config['base_url'] = APP_URL.'/admin/reservations';
		$config['total_rows'] = $this->data['nbRes']-$pag;
		$config['per_page'] = $pag;
		$config['full_tag_open'] = '<div class="text-center"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></div><!--pagination-->';
		$config['first_link'] = '&laquo; Premier';
		$config['first_tag_open'] = '<li class="Page prec.">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Dernier &raquo;';
		$config['last_tag_open'] = '<li class="Page suiv.">';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = 'Suivant &rarr;';
		$config['next_tag_open'] = '<li class="Page prec.">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&larr; Précédent';
		$config['prev_tag_open'] = '<li class="Page suiv.">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page">';
		$config['num_tag_close'] = '</li>';
		$config['anchor_class'] = 'follow_link';

		$this->pagination->initialize($config);
		$this->data['pagination'] = $this->pagination->create_links();
		$this->session->debug = $this->data['nbRes'];
		if ($resindis == 'resa') {
			$this->data['reservations'] = $this->ReservationModel->getReservationList($limit);
		}
		else {
			$this->data['reservations'] = $this->ReservationModel->getIndispoList($limit);
		}
		$this->data['salles'] = $this->ReservationModel->getList('salle');
		$this->data['pag'] = $pag;
		$this->data['resindis'] = $resindis;


		if($this->input->is_ajax_request())
		{
			$vue = $this->load->view('/admin/liste', $this->data);
			echo $vue;
		}
		else
		{
			$this->data['calendar'] = $this->calendar();
			$vue = $this->load->view('/admin/listing', $this->data, true);
			return $vue;
		} */
	}
	public function listingsearch()
	{

		// Récupération des data Post (Ajax Reload)
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);

		$this->data['reservations'] = $this->ReservationModel->getReservationListSearch($data['search'],$data['searchstart'],$data['searchend']);
		$this->data['salles'] = $this->ReservationModel->getList('salle');

		$vue = $this->load->view('/admin/liste_resa', $this->data);
		echo $vue;


	}
	public function delete()
	{
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$infos = $this->ReservationModel->getData('reservation', array('id' => $data['id']));
		$vérification = $this->ReservationModel->getNbData('reservation', array('id_client' => $infos->id_client));
		$this->ReservationModel->deleteData('reservation', array('id' => $data['id']));
		if($vérification == 1)
		{
			$this->ReservationModel->deleteData('client', array('id' => $infos->id_client));
		}
		if($infos->voucher != '0')
		{
			$voucher = $this->ReservationModel->getData('voucher', ['code' => $infos->voucher]);
			$this->ReservationModel->updateData('voucher', ['valide' => '1'], ['id' => $voucher->id]);
		}
		$this->ReservationModel->deleteData('joueurs', array('id_reservation' => $data['id']));
		$datas = array(
			'rPop' => $data['txt'],
			'rPopTitle' => $data['titre'],
			'rPopClass' => (isset($data['class']))?$data['class']:''
		);
		echo json_encode($datas);
	}
	public function deleteIndispo()
	{
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$this->ReservationModel->deleteData('indispos', array('id' => $data['id']));
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
		$this->data = json_decode($post,TRUE);
		if($this->data['id_reservation'] !== '')
		{
			$this->data['client'] = $this->ReservationModel->getClientByOrder($this->data['id_reservation']);
			$this->data['joueurs'] = $this->ReservationModel->getList('joueurs', array('id_reservation' => $this->data['id_reservation']));
			$this->data['reservation'] = $this->ReservationModel->getData('reservation', array('id' => $this->data['id_reservation']));
		}
		$vue = $this->load->view('/admin/form', $this->data, true);
		// echo $vue;
		$datas = array(
			'rPop' => $vue,
			'rPopTitle' => $this->data['titre'],
			'rPopClass' => (isset($this->data['class']))?$this->data['class']:''
		);
		echo json_encode($datas);
	}
	public function infos_up()
	{
		$post = $this->input->post('message');
		$this->data = json_decode($post,TRUE);
		if($this->data['id_reservation'] !== '')
		{
			$this->data['client'] = $this->ReservationModel->getClientByOrder($this->data['id_reservation']);
			$this->data['joueurs'] = $this->ReservationModel->getList('joueurs', ['id_reservation' => $this->data['id_reservation']]);
			$this->data['reservation'] = $this->ReservationModel->getData('reservation', ['id' => $this->data['id_reservation']]);
			$this->data['infos_societe'] = $this->ReservationModel->getData('infos_societe', ['id' => $this->data['reservation']->societe]);
			$this->data['nbJoueurs'] = $this->data['reservation']->joueurs;
		}
		$vue = $this->load->view('/admin/form', $this->data);
		echo $vue;
	}
	public function add()
	{
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		if($this->verifDispo($data['jour'],$data['horaire'],$data['salle']) !== TRUE)
		{
			$datas = array(
				'rPop' => 'Ce créneau horaire est en cours de réservation<br />Sélectionnez en un autre ou réessayez d\'ici 30mn',
				'rPopTitle' => $data['titre'],
				'rPopClass' => 'alerte'
			);
			echo json_encode($datas);
			exit;
		}
		// descrimination sur l'email
		$test = $this->ReservationModel->getData('client', array('email' => $data['email']));
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
		if( $test !== FALSE )
		{
			$id = $test->id;
			$this->ReservationModel->updateData('client', $datas, array('id' => $id));
		}
		else
		{
			$id = $this->ReservationModel->setData('client', $datas, true);
		}

		$id_societe = 0;

		if ($data['societe'] == 1) {
			$infos_societe = array(
				'nom' => $data['nom_societe'],
				'adresse' => $data['adresse_societe'],
				'comp_adresse' => $data['comp_adresse_societe'],
				'code_postal' => $data['code_postal_societe'],
				'ville' => $data['ville_societe'],
				'tel' => $data['tel_societe'],
				'email' => $data['email_societe'],
				'nom_contact' => $data['nom_contact_societe'],
				'comment' => $data['comment_societe']
			);
			$test_societe = $this->ReservationModel->getData('infos_societe', array('id' => $data['id_societe']));
			if ($test_societe !== FALSE) {
				$id_societe = $test_societe->id;
				$this->ReservationModel->updateData('infos_societe', $infos_societe, array('id' => $id_societe));
			}
			else {
				$id_societe = $this->ReservationModel->setData('infos_societe', $infos_societe, true);
			}
		}
		$forcedprice = ($data['tarifstand'] == '1')?'':$data['tarif'];
		$prix = modules::run('tarifs/admin/Tarifsadmin/getPrice',$data['jour'],$data['horaire'],$data['joueurs'],$data['salle'],$forcedprice);

		$salle = $this->ReservationModel->getData('salle', array('id' => $data['salle']));
		$dernieremodif = time();
		$formatmodif = date('Y-m-d H:i:s', $dernieremodif);
		$resa = array(
			'id_client' => $id,
			'id_salle' =>$data['salle'],
			'jour' => $data['jour'],
			'horaire' => $data['horaire'],
			'joueurs' => $data['joueurs'],
			'prix' => $prix,
			'societe' => $id_societe,
			'voucher' => $data['voucher'],
			'regle' => $data['reglement'],
			'valide' => 1,
			'scenario' => $salle->nom,
			'tarifstand' => $data['tarifstand'],
			'comment' => $data['comment'],
			'derniere_modif' => $formatmodif
		);
		if($new_id = $this->ReservationModel->setData('reservation', $resa, true))
		{
			// renseignement autres joueurs
			for($i = 1; $i < PLAYERS_MAX; $i++)
			{
				if($data['joueur' . $i] != '')
				{
					$joueur = array(
						'id_reservation' => $new_id,
						'civil' => '',
						'nom' => '',
						'prenom' => '',
						'email' => $data['joueur' . $i]
					);
					$this->ReservationModel->setData('joueurs', $joueur);
					if ($data['envoimail'] == 'Oui') {
					// envoi du mail au joueur
						$message = $this->ReservationModel->getData('email', array('action' => 'player_play_confirm'));
						$sujet = $message->sujet;
						$content = $message->message;
						$mess_datas = array(
							'dest' => $data['email'],
							'sujet' => $sujet,
							'content' => $content,
							'id' => $new_id
						);
						modules::run('message', json_encode($mess_datas));
					}
				}
			}
			if ($data['envoimail'] == 'Oui') {
				// envoi des mails au client
				$action = ($data['reglement'] == 1)?'order_confirm':'admin_order_confirm';
				$message = $this->ReservationModel->getData('email', array('action' => $action));
				$sujet = $message->sujet;
				$content = $message->message;
				$mess_datas = array(
					'dest' => $data['email'],
					'sujet' => $sujet,
					'content' => $content,
					'id' => $new_id
				);
				modules::run('message', json_encode($mess_datas));
				$message = $this->ReservationModel->getData('email', array('action' => 'client_play_confirm'));
				$sujet = $message->sujet;
				$content = $message->message;
				$mess_datas = array(
					'dest' => $data['email'],
					'sujet' => $sujet,
					'content' => $content,
					'id' => $new_id
				);
				modules::run('message', json_encode($mess_datas));
			}
			$txt = 'Ajout effectué avec succès';
			$class = 'success';
		}
		else
		{
			$txt = 'Erreur lors de l\'ajout';
			$class = 'alerte';
		}
		$vue = $this->load->view('/admin/form', $data, true);
		$datas = array(
			'rPop' => $txt,
			'rPopTitle' => $data['titre'],
			'rPopClass' => $class,
			'retourlistingresa' => ($class='success')?'ok':''
		);
		echo json_encode($datas);
	}
	public function update_test()
	{
		$datas = ['rPop' => 'blabla',
		'rPopTitle' => 'blibli',
		'rPopClass' => 'alerte'];
		echo json_encode($datas);
	}
	public function update()
	{
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$verif = $this->verifDispo($data['jour'],$data['horaire'],$data['salle']);
		if($verif !== TRUE && $verif != $data['id'])
		{
			$datas = array(
				'rPop' => 'Ce créneau horaire est en cours de réservation<br />Sélectionnez en un autre ou réessayez d\'ici 30mn',
				'rPopTitle' => $data['titre'],
				'rPopClass' => 'alerte'
			);
			echo json_encode($datas);
			exit;
		}
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
		$client = $this->ReservationModel->getData('reservation',['id' => $data['id']],'id_client');
		if($data['password'] != '' && md5($data['password']) != $data['old_pass'])
		{
			$datas['password'] = md5($data['password']);
		}
		$this->ReservationModel->updateData('client', $datas, array('id' => $client->id_client));


		$id_societe = 0;

		if ($data['societe'] == 1) {
			$infos_societe = array(
				'nom' => $data['nom_societe'],
				'adresse' => $data['adresse_societe'],
				'comp_adresse' => $data['comp_adresse_societe'],
				'code_postal' => $data['code_postal_societe'],
				'ville' => $data['ville_societe'],
				'tel' => $data['tel_societe'],
				'email' => $data['email_societe'],
				'nom_contact' => $data['nom_contact_societe'],
				'comment' => $data['comment_societe']
			);
			$test_societe = $this->ReservationModel->getData('infos_societe', array('id' => $data['id_societe']));
			if ($test_societe !== FALSE) {
				$id_societe = $test_societe->id;
				$this->ReservationModel->updateData('infos_societe', $infos_societe, array('id' => $id_societe));
			}
			else {
				$id_societe = $this->ReservationModel->setData('infos_societe', $infos_societe, true);
			}
		}


		// var_dump($data);
		$forcedprice = ($data['tarifstand'] == '1')?'':$data['tarif'];
		$prix = modules::run('tarifs/admin/Tarifsadmin/getPrice',$data['jour'],$data['horaire'],$data['joueurs'],$data['salle'],$forcedprice);
		$salle = $this->ReservationModel->getData('salle', array('id' => $data['salle']));
		$dernieremodif = time();
		$formatmodif = date('Y-m-d H:i:s', $dernieremodif);
		$resa = array(
			'id_salle' =>$data['salle'],
			'jour' => $data['jour'],
			'horaire' => $data['horaire'],
			'joueurs' => $data['joueurs'],
			'prix' => $prix,
			'societe' => $id_societe,
			'voucher' => $data['voucher'],
			'regle' => $data['reglement'],
			'scenario' => $salle->nom,
			'tarifstand' => $data['tarifstand'],
			'comment' => $data['comment'],
			'derniere_modif' => $formatmodif
		);
		if($this->ReservationModel->updateData('reservation', $resa, array('id' => $data['id'])))
		{
			$this->ReservationModel->deleteData('joueurs', array('id_reservation' => $data['id']));
			// renseignement autres joueurs
			for($i = 1; $i < PLAYERS_MAX; $i++)
			{
				if($data['joueur' . $i] != '')
				{
					$joueur = array(
						'id_reservation' => $data['id'],
						'civil' => '',
						'nom' => '',
						'prenom' => '',
						'email' => $data['joueur' . $i]
					);
					$this->ReservationModel->setData('joueurs', $joueur);
					if ($data['envoimail'] == 'Oui') {
						// envoi du mail au joueur
						$message = $this->ReservationModel->getData('email', array('action' => 'player_modif_confirm'));
						$sujet = $message->sujet;
						$content = $message->message;
						$mess_datas = array(
							'dest' => $data['joueur' . $i],
							'sujet' => $sujet,
							'content' => $content,
							'id' => $data['id']
						);
						modules::run('message', json_encode($mess_datas));
					}
				}
			}
			if ($data['envoimail'] == 'Oui') {
				// envoi du mail au client
				$message = $this->ReservationModel->getData('email', array('action' => 'player_modif_confirm'));
				$sujet = $message->sujet;
				$content = $message->message;
				$mess_datas = array(
					'dest' => $data['email'],
					'sujet' => $sujet,
					'content' => $content,
					'id' => $data['id']
				);
				modules::run('message', json_encode($mess_datas));
			}
			$txt = 'Modification effectuée avec succès';
			$class = 'success';
		}
		else
		{
			$txt = 'Erreur lors de la modification';
			$class = 'alerte';

		}

		$vue = $this->load->view('/admin/form', $data, TRUE);
		$datas = ['rPop' => $txt,
		'rPopTitle' => $data['titre'],
		'rPopClass' => $class,
		'retourlistingresa' => ($class='success')?'ok':''];
		echo json_encode($datas);
	}
	public function calendar_old()
	{
		$day = (date('w') - 1);
		$diff = $day * 86400;
		$this->data['start'] = (time() - $diff);
		$salle = 1;
		if($this->input->post('message'))
		{
			$post = $this->input->post('message');
			$data = json_decode($post,TRUE);
			$this->data['start'] = isset($data['start'])?$data['start']:$this->data['start'];
			if(strpos($this->data['start'],'-') !== FALSE){
				$this->data['start'] = strtotime($this->data['start']);
			}
			$salle = isset($data['salle'])?$data['salle']:$salle;
			if(isset($data['addIndispo']) && $data['addIndispo'] == 1){
				$this->data['addIndispo'] = TRUE;
			} else {
				$this->data['addIndispo'] = FALSE;

			}
		}
		$cur = localtime(time(), true);
		$this->data['current'] = $cur['tm_hour'];
		$this->data['week'] = (time() - $diff);
		$this->data['prev'] = $this->data['start'] - 604800;
		$this->data['next'] = $this->data['start'] + 604800;
		if($day == -1){
			$this->data['start'] = $this->data['start'] - 604800;
		}
		$start_search = date('Y-m-d', $this->data['start']);
		$end_search = date('Y-m-d', $this->data['next']);
		$this->data['resas'] = $this->ReservationModel->getListByDate($salle, $start_search, $end_search);
		if($this->is_ajax())
		{
			$vue = $this->load->view('/admin/calendar', $this->data);
			echo $vue;
		}
		else{
			return $this->load->view('/admin/calendar', $this->data, true);
		}
	}

	public function calendar(){
		$day = (date('N') - 1);
		$diff = $day * 86400;
		$this->data['start'] = (time() - $diff);
		$salle = 1;
		if($this->input->post('message'))
		{
			$post = $this->input->post('message');
			$data = json_decode($post,TRUE);
			// $data = $this->input->post();
			$this->data['start'] = isset($data['start'])?$data['start']:$this->data['start'];

			if(strpos($data['start'],'-') !== FALSE){
				$this->data['start'] = strtotime($this->data['start'])+7200;
			}
/* 			if ($this->$data['modifresa'] == 'ok') {
				$tempresa = $this->ReservationModel->getData('reservation', array('id' => $data['id_reservation']));
				$salle = $tempresa->id_salle;
			}
			else { */
			$salle = isset($data['salle'])?$data['salle']:$salle;
			$this->data['salle'] = $salle;
			//}

			if(isset($data['addIndispo']) && $data['addIndispo'] == 1){
				$this->data['addIndispo'] = TRUE;
			} else {
				$this->data['addIndispo'] = FALSE;

			}
			if(isset($data['addResa']) && $data['addResa'] == 1){
				$this->data['addResa'] = TRUE;
			} else {
				$this->data['addResa'] = FALSE;

			}

		}
		// $cur = localtime(time(), true);
		// $this->data['current'] = $cur['tm_hour'].':00';
		$this->data['current'] = (new DateTime())->format('H:i');
		$this->data['week'] = (time() - $diff);
		$this->data['prev'] = $this->data['start'] - 604800;
		$this->data['next'] = $this->data['start'] + 604800;
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
		if($this->is_ajax())
		{
			$vue = $this->load->view('/admin/calendar', $this->data);
			echo $vue;
		}
		else{
			return $this->load->view('/admin/calendar', $this->data, true);
		}
	}

	/**
	 * Changement des formats horaire de la BDD
	 * @return void
	 */
	private function change_horaire(){
		$data = $this->ReservationModel->getList('horaire');
		foreach ($data as $value) {
			$this->ReservationModel->updateData('horaire',['hor_start' => str_replace(':', 'h', $value->hor_start)], ['hor_id' => $value->hor_id]);
		}
		$data = $this->ReservationModel->getList('reservation');
		foreach ($data as $value) {
			$this->ReservationModel->updateData('reservation',['horaire' =>  (strlen($value->horaire) < 3? $value->horaire.'h00': $value->horaire) ], ['id' => $value->id]);
		}
	}
	public function confirm_date()
	{
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$date_fr = date('d-m-Y',time($this->data['horaire']));
		$datas =
		['rPop' => 'Vous avez choisi de créer une nouvelle réservation pour le '.$date_fr.' à '.$this->data['horaire'].'.<br> Validez ce choix pour la création ',
		'rPopTitle' => $this->data['titre'],
		'rPopClass' => '']
		;
		echo json_encode($datas);
	}
	public function getResaInfos()
	{
		$post = $this->input->post('message');
		$this->data = json_decode($post,TRUE);
		$this->data['reservation'] = $this->ReservationModel->getData('reservation', array('id' => $this->data['id_reservation']));
		$datas = array(
			'nbJoueurs' => $this->data['reservation']->joueurs,
			'salle' => $this->data['reservation']->id_salle
		);
		echo json_encode($datas);
	}
	public function verifDispo($jour, $horaire, $salle)
	{
		$verif = $this->ReservationModel->getData('reservation', array('jour' => $jour, 'horaire' => $horaire, 'id_salle' => $salle));
		$verif2 = $this->ReservationModel->getData('reservation', array('jour' => $jour, 'horaire' => $horaire, 'id_salle' => $salle, 'id_client' => 0));
		if($verif === FALSE)
		{
			return TRUE;
		}
		else if ($verfi2 === FALSE)
		{
			return $verif->id;
		}
		else
			{
			return TRUE;
		}
	}
	public function paid()
	{
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$this->ReservationModel->updateData('reservation', array('regle' => 1), array('id' => $data['id']));
		$datas = array(
			'rPop' => 'Le règlement à bien été pris en compte',
			'rPopTitle' => 'Paiement sur place',
			'rPopClass' => ''
		);
		echo json_encode($datas);
	}
	public function getNbmax($id = 1, $nb = 0){
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
		$this->data['joueurs'] = ($nb==0)?$data['joueurs']:$nb;
		if($this->is_ajax())
		{
			echo $this->load->view('/admin/joueurs', $this->data);
		}
		else
		{
			return $this->load->view('/admin/joueurs', $this->data, true);
		}
	}

	public function setIndispo(){
		if( $this->input->post('message') )
		{
			$post = $this->input->post('message');
			$data = json_decode($post,TRUE);
			$indispo = $data['indispo'];
			if($data['salle'] == 'all'){
				// $id = $this->ReservationModel->getData('salle',['active' => '1'],'*');
				$id = $this->ReservationModel->getList('salle',['active' => '1']);
			} else {
				$id = (int)$data['salle'];
			}
			$dernieremodif = time();
			$formatmodif = date('Y-m-d H:i:s', $dernieremodif);
			$resa = [
/* 				'id_client' => 0,
				 'id_salle' =>$id,
				'joueurs' => 0,
				'prix' => 0,
				'regle' => 0,
				'valide' => 1,
				'scenario' => '0', */
				'derniere_modif' => $formatmodif]
				;
				if(strlen($indispo) == 10){

					$ishoraireset = date("Y-m-d");
					$resa['jour'] = $indispo;
					$resa['comment'] = "";

					if (is_int($id)){
							$resa['id_salle'] = $id;
							$salledata = $this->ReservationModel->getData('salle', array('id' => $id));
							$resa['scenario'] = $salledata->nom;
							$hset = $this->ReservationModel->getHoraireSet($resa['id_salle'],$ishoraireset,$ishoraireset);

							foreach ($hset['set'] as $horairesalle) {
								$resa['horaire'] = $horairesalle -> hor_start;
								$this->ReservationModel->setData('indispos',$resa,true);
							}


					} else {
						foreach($id as $salle){
							$resa['id_salle'] = $salle->id;
							$salledata = $this->ReservationModel->getData('salle', array('id' => $salle->id));
							$resa['scenario'] = $salledata->nom;
							$hset = $this->ReservationModel->getHoraireSet($resa['id_salle'],$ishoraireset,$ishoraireset);

							foreach ($hset['set'] as $horairesalle) {
								$resa['horaire'] = $horairesalle -> hor_start;
								$this->ReservationModel->setData('indispos',$resa,true);
							}
						}
					}

				} elseif (strlen($indispo) == 16) {
					$tab_in = explode(' ',$indispo);
					$resa['jour'] = $tab_in[0];
					$resa['comment'] = "";
					$pattern = '/:/';
					$replace = 'h';
					$resa['horaire'] = preg_replace($pattern,$replace,$tab_in[1]);
					if (is_int($id)){
						$resa['id_salle'] = $id;
						$salledata = $this->ReservationModel->getData('salle', array('id' => $id));
						$resa['scenario'] = $salledata->nom;
						$this->ReservationModel->setData('indispos',$resa,true);
					} else {
						foreach($id as $salle){
							$resa['id_salle'] = $salle->id;
							$salledata = $this->ReservationModel->getData('salle', array('id' => $id));
							$resa['scenario'] = $salledata->nom;
							$this->ReservationModel->setData('indispos',$resa,true);
						}
					}
				}
				$datas =[
					'rPop' => $data['txt'],
					'rPopTitle' => $data['titre'],
					'rPopClass' => (isset($data['class']))?$data['class']:''
				];
				echo json_encode($datas);
			} else{
				return FALSE;
			}
		}

		public function loadComment() {
			$post = $this->input->post('message');
			$data = json_decode($post,TRUE);

			$resa = $this->ReservationModel->getData('reservation', array('id' => $data['id']));

			$datas =[
				'rPop' => nl2br($resa->comment),
				'rPopTitle' => 'Commentaires réservation '.$data['id'],
				'rPopClass' => 'success'
			];
			echo json_encode($datas);

		}

		public function loadCompanyinfos() {
			$post = $this->input->post('message');
			$data = json_decode($post,TRUE);

			$infos = $this->ReservationModel->getData('infos_societe', array('id' => $data['id']));

			$content .= '<strong>Identifiant société : </strong>'.$data['id'].'<br><br>';
			$content .= '<strong>'.$infos->nom.'</strong><br>';
			$content .= $infos->adresse.'<br>';
			$content .= ($infos->comp_adresse != '')?$infos->comp_adresse.'<br>':'';
			$content .= $infos->code_postal.' ';
			$content .= $infos->ville.'<br><br>';
			$content .= '<strong>Téléphone : </strong>'.$infos->tel.'<br><br>';
			$content .= '<strong>email : </strong>'.$infos->email.'<br><br>';
			$content .= '<strong>Contact : </strong>'.$infos->nom_contact;
			$content .= '<br><br>';

			$datas =[
				'rPop' => nl2br($content),
				'rPopTitle' => 'Informations sur la société',
				'rPopClass' => 'success'
			];
			echo json_encode($datas);

		}
		public function calculPrix()
		{
			$post = $this->input->post('message');
			$data = json_decode($post,TRUE);
			$prix = modules::run('tarifs/admin/Tarifsadmin/getPrice',$data['jour'],$data['horaire'],$data['joueurs'],$data['salle'],'');
			echo $prix;
		}

		public function mode_paiement()
		{
			$post = $this->input->post('message');
			$this->data = json_decode($post,TRUE);
			if($this->data['id'] !== '')
			{
				$this->data['mode_paiement'] = $this->ReservationModel->getList('mode_paiement',array('id_resa' => $this->data['id']));
			}
			$vue = $this->load->view('/admin/mode_paiement', $this->data, true);
			$datas = array(
				'rPop' => $vue,
				'rPopTitle' => $this->data['titre'],
				'rPopClass' => (isset($this->data['class']))?$this->data['class']:''
			);
			echo json_encode($datas);
		}

		public function add_mode_paiement()
		{
 			$post = $this->input->post('message');
			$data = json_decode($post,TRUE);
			$datas = array(
				'id_resa' => $data['id_resa'],
				'modep' => $data['modep'],
				'reference' => $data['reference'],
				'montant' => $data['montant']
			);
			$result = $this->ReservationModel->setData('mode_paiement',$datas);
			if ($result) {
				$this->data['id'] = $data['id_resa'];
				$this->data['mode_paiement'] = $this->ReservationModel->getList('mode_paiement',array('id_resa' => $this->data['id']));
				$vue = $this->load->view('/admin/mode_paiement_tab', $this->data, true);
				echo $vue;
			}
		}

		public function del_mode_paiement()
		{
 			$post = $this->input->post('message');
			$data = json_decode($post,TRUE);
			$result = $this->ReservationModel->deleteData('mode_paiement',array('id' => $data['id']));
			if ($result) {
				$this->data['id'] = $data['id_resa'];
				$this->data['mode_paiement'] = $this->ReservationModel->getList('mode_paiement',array('id_resa' => $this->data['id']));
				$vue = $this->load->view('/admin/mode_paiement_tab', $this->data, true);
				echo $vue;
			}
		}

		public function printfiche(){


		require_once('../application/libraries/fpdf.php');

		$pdf = new FPDF();
		$pdf->SetLeftMargin(17);
		$pdf->SetTopMargin(18);
		$pdf->SetAuthor('Secret Room Agency');

		$longueurlist = strlen($this->uri->segment(5))-1;
		$ficheslist = substr($this->uri->segment(5),0,$longueurlist);
		$ficheslist = explode("a",$ficheslist);

		if (count($ficheslist)>1) {
			$pdf->SetTitle("Fiches d'aventure");
			$nomfichier = "Fiches_aventure.pdf";
		}
		else {
			$pdf->SetTitle("Fiche d'aventure");
			$nomfichier = "Fiche_aventure.pdf";
		}


		foreach ($ficheslist as $resaid) {


			$infosresa = $this->ReservationModel->getData('reservation',array('id' => $resaid));
			$dateformat = substr($infosresa->jour,8,2).'/'.substr($infosresa->jour,5,2).'/'.substr($infosresa->jour,0,4);
			$infosclient = $this->ReservationModel->getData('client',array('id' => $infosresa->id_client));
			$infosjoueurs = $this->ReservationModel->getList('joueurs',array('id_reservation' => $resaid));
			$emailjoueurs = ['','','','',''];


			$i = 0;
			foreach ($infosjoueurs as $joueur) {
				$emailjoueurs[$i] = $joueur->email;
				$i++;
			}


			//Paramètres
			$dateresa = $dateformat;
			$heureresa = $infosresa->horaire;
			$scenarioresa = $infosresa->scenario;
			$nombrejresa = $infosresa->joueurs;
			$prenomresa = $infosclient->prenom;
			$nomresa = $infosclient->nom;
			$emailresa = $infosclient->email;



			/* $content = $dateformat.','.$infosresa->horaire.','.$infosresa->scenario.','.$infosresa->joueurs.','.$infosclient->prenom.','.$infosclient->nom.','.$infosclient->email;

			$mess_datas = array(
			'dest' => 'ayumu.hyjal@gmail.com',
			'sujet' => 'test',
			'content' => $content,
			'id' => 634
			);
			modules::run('message', json_encode($mess_datas)); */

			//Création Page et en-tête de la fiche
			$pdf->Header();
			$pdf->AddPage('L');
			$pdf->SetFont('Arial','B',25);
			$pdf->Cell(200,15,'Fiche d\'aventure','B');
			$pdf->Cell(9);
			$pdf->Image('http://'.$_SERVER['SERVER_NAME'].'/assets/img/logosra3.png',235,14,47,29,'PNG');
			$pdf->Ln(32);

			//Ligne nom d'équipe
			$pdf->SetFont('Arial','B',13);
			$equipe = utf8_decode(' Nom de l\'équipe');
			$pdf->Cell(50,16,$equipe,1);
			$pdf->Cell(127,16,'',1);
			$pdf->Cell(42,16,'',1);
			$pdf->Cell(45,16,'',1);
			$pdf->Ln(0);
			$pdf->SetFont('Arial','',13);
			$pdf->Cell(50);
			$pdf->Cell(127);
			//Date titre
			$pdf->Cell(42,8,'Date',1);
			//Date data
			$pdf->Cell(45,8,$dateresa,1,0,'C');
			$pdf->Ln(8);
			$pdf->Cell(50);
			$pdf->Cell(127);
			//Heure titre
			$pdf->Cell(42,8,'Heure',1);
			//Heure data
			$pdf->Cell(45,8,$heureresa,1,0,'C');
			$pdf->Ln(8);

			//Ligne Aventure
			$pdf->SetFont('Arial','',13);
			$pdf->Cell(50,16,' Aventure',1);
			$pdf->SetFont('Arial','',18);
			$decodescenar = '  '.utf8_decode($scenarioresa);
			$pdf->Cell(127,16,$decodescenar,1);
			$pdf->Cell(42,16,'',1);
			$pdf->Cell(45,16,'',1);
			$pdf->Ln(0);
			$pdf->Cell(50);
			$pdf->Cell(127);
			//Nombre d'agents titre
			$pdf->SetFont('Arial','',13);
			$pdf->Cell(42,8,'Nombre d\'agents',1);
			//Nombre d'agents data
			$pdf->Cell(45,8,$nombrejresa,1,0,'C');
			$pdf->Ln(8);
			$pdf->Cell(50);
			$pdf->Cell(127);
			//Temps réalisé titre
			$tempsreal = utf8_decode('Temps réalisé');
			$pdf->Cell(42,8,$tempsreal,1);
			//Temps réalisé data
			$pdf->Cell(45,8,'',1);

			$pdf->Ln(18);

			//Phrase d'information emails.
			$pdf->SetFont('Arial','',10);
			$phraseinfos = utf8_decode('Si vous souhaitez être informés de nos publications sur les réseaux sociaux et de nos nouveautés, vous pouvez nous laisser votre e-mail. Merci.');
			$pdf->Cell(264,8,$phraseinfos);

			$pdf->Ln();

			//Titres tableau infos joueurs
			$pdf->SetFont('Arial','B',13);
			$prenomtitre = utf8_decode('Prénom');
			$pdf->Cell(50,8,$prenomtitre,1);
			$pdf->Cell(57,8,'Nom',1);
			$pdf->Cell(112,8,'e-mail',1);
			$pdf->Cell(45,8,'Code Postal',1);

			$pdf->Ln();

			//Lignes tableau infos joueurs

			//Ligne 1
			$pdf->SetFont('Arial','',14);
			$prenomdecode = utf8_decode('  '.$prenomresa);
			$pdf->Cell(50,13,$prenomdecode,1);
			$nomdecode = utf8_decode('  '.$nomresa);
			$pdf->Cell(57,13,$nomdecode,1);
			$emaildecode = utf8_decode('  '.$emailresa);
			$pdf->Cell(112,13,$emaildecode,1);
			$pdf->Cell(45,13,'',1);
			$pdf->Ln();

			//Ligne 2
			$pdf->Cell(50,13,'',1);
			$pdf->Cell(57,13,'',1);
			$emaildecode2 = utf8_decode('  '.$emailjoueurs[0]);
			$pdf->Cell(112,13,$emaildecode2,1);
			$pdf->Cell(45,13,'',1);
			$pdf->Ln();

			//Ligne 3
			$pdf->Cell(50,13,'',1);
			$pdf->Cell(57,13,'',1);
			$emaildecode3 = utf8_decode('  '.$emailjoueurs[1]);
			$pdf->Cell(112,13,$emaildecode3,1);
			$pdf->Cell(45,13,'',1);
			$pdf->Ln();

			//Ligne 4
			$pdf->Cell(50,13,'',1);
			$pdf->Cell(57,13,'',1);
			$emaildecode4 = utf8_decode('  '.$emailjoueurs[2]);
			$pdf->Cell(112,13,$emaildecode4,1);
			$pdf->Cell(45,13,'',1);
			$pdf->Ln();

			//Ligne 5
			$pdf->Cell(50,13,'',1);
			$pdf->Cell(57,13,'',1);
			$emaildecode5 = utf8_decode('  '.$emailjoueurs[3]);
			$pdf->Cell(112,13,$emaildecode5,1);
			$pdf->Cell(45,13,'',1);
			$pdf->Ln();

			//Ligne 6
			$pdf->SetFont('Arial','B',13);
			$pdf->Cell(50,13,'',1);
			$pdf->Cell(57,13,'',1);
			$emaildecode6 = utf8_decode('  '.$emailjoueurs[4]);
			$pdf->Cell(112,13,$emaildecode6,1);
			$pdf->Cell(45,13,'',1);
			$pdf->Ln();


			//Affichage du marqueur "R" sur les réservations non payées.
			if ($infosresa->regle == 0) {
				$pdf->SetFillColor(0,0,0);
				$pdf->Rect(5,5,13,13,'F');
				$pdf->SetTextColor(255,255,255);
				$pdf->SetFont('Arial','B',32);
				$pdf->Text(7,16,'R');
				$pdf->SetTextColor(0,0,0);
			}

			$pdf->Footer();
		}
		//Génération du fichier pdf
		$pdf->Output('I',$nomfichier,TRUE);
		echo "OK";

	}

	}
