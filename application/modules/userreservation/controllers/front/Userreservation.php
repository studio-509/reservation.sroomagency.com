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
	public function index()
	{
		echo 'coucou';
	}
	public function infos()
	{
		$post = $this->input->post('message');
		$this->data = json_decode($post,TRUE);
		$vue = $this->load->view('/admin/form', $this->data, true);
		$datas = array(
			'rPop' => $vue,
			'rPopTitle' => $this->data['titre'],
			'rPopClass' => (isset($this->data['class']))?$this->data['class']:''
		);
		echo json_encode($datas);
	}
	public function add()
	{
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		if(!$this->verifDispo($data['jour'],$data['horaire'],$data['salle']))
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
		if($data['password'] != '' && md5($data['password']) != $data['old_pass'])
		$datas['password'] = md5($data['password']);
		// descrimination sur l'email
		$test = $this->ReservationModel->getData('client', array('email' => $data['email']));
		if($test !== FALSE)
		{
			$id = $test->id;
			$this->ReservationModel->updateData('client', $datas, array('id' => $id));
		}
		else
		$id = $this->ReservationModel->setData('client', $datas, true);
		$prix = modules::run('tarifs/admin/Tarifsadmin/getPrice',$data['jour'],$data['horaire'],$data['joueurs'],$data['salle']);
		$dernieremodif = time();
		$formatmodif = date('Y-m-d H:i:s', $dernieremodif);
		$resa = array(
			'id_client' => $id,
			'id_salle' =>$data['salle'],
			'jour' => $data['jour'],
			'horaire' => $data['horaire'],
			'joueurs' => $data['joueurs'],
			'prix' => $prix,
			'regle' => $data['reglement'],
			'valide' => 1,
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
			'rPopClass' => $class
		);
		echo json_encode($datas);
	}
	// public function calendar()
	// {
	// 	$day = (date('w') - 1);
	// 	$diff = $day * 86400;
	// 	$this->data['start'] = (time() - $diff);
	// 	$salle = 1;
	// 	if($this->input->post('datas'))
	// 	{
	// 		$post = $this->input->post('datas');
	// 		$data = array();
	// 		foreach($post as $k=>$v)
	// 		$data[$k] = $v;
	// 		$this->data['start'] = isset($data['start'])?$data['start']:$this->data['start'];
	// 		$salle = isset($data['salle'])?$data['salle']:$salle;
	// 	}
	// 	$cur = localtime(time(), true);
	// 	$this->data['current'] = $cur['tm_hour'] + DELTA;
	// 	$this->data['week'] = (time() - $diff);
	// 	$this->data['prev'] = $this->data['start'] - 604800;
	// 	$this->data['next'] = $this->data['start'] + 604800;
	// 	if($day == -1)
	// 	$this->data['start'] = $this->data['start'] - 604800;
	// 	$start_search = date('Y-m-d', $this->data['start']);
	// 	$end_search = date('Y-m-d', $this->data['next']);
	// 	$this->data['resas'] = $this->ReservationModel->getListByDate($salle, $start_search, $end_search);
	// 	if($this->is_ajax())
	// 	{
	// 		$vue = $this->load->view('/front/calendar', $this->data);
	// 		echo $vue;
	// 	}
	// 	else
	// 	return $this->load->view('/front/calendar', $this->data, true);
	// }

	public function calendar(){
		if($this->is_ajax()){
			modules::run('reservation/admin/Reservationadmin/calendar',$this->data);
		} else {
			return modules::run('reservation/admin/Reservationadmin/calendar',$this->data);
		}
	}

	public function verifDispo($jour, $horaire, $salle)
	{
		$verif = $this->ReservationModel->getData('reservation', array('jour' => $jour, 'horaire' => $horaire, 'id_salle' => $salle));
		if($verif === FALSE)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	public function change_uri()
	{
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$infos = $this->ReservationModel->getData('salle', array('id' => $data['salle']));
		$return = array(
			'title' => $infos->nom,
			'url' => APP_URL . '/reservation/' . $infos->slug;
		);
		return json_encode($return);
	}
	
	
}
