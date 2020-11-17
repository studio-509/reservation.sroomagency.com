<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends MY_Controller {

	function __construct()
  {
    parent::__construct();

    $this->load->model('CronModel');
  }

  public function cleaner()
	{
		$limit = date('Y-m-d H:i:s', mktime (date("H"), date("i")-15, '00', date("m"), date("d"), date("Y")));
		$liste = $this->CronModel->getList('reservation', 'time_resa < "' . $limit . '" AND valide = 0');
		foreach($liste as $l)
		{
			$vérification = $this->CronModel->getNbData('reservation', array('id_client' => $l->id_client));

			if($vérification == 1)
				$this->CronModel->deleteData('client', array('id' => $l->id_client));
			$this->CronModel->deleteData('reservation', array('id' => $l->id));
			$this->CronModel->deleteData('joueurs', array('id_reservation' => $l->id));
		}
	}

	public function send_alert()
	{
		$demain = date('Y-m-d', strtotime('+1 day'));
		$liste = $this->CronModel->getGameList($demain);
		foreach($liste as $jeu)
		{
			$message = $this->CronModel->getData('email', array('action' => 'mind_refresh'));
			$sujet = $message->sujet;
			$content = $message->message;
			$mess_datas = array(
				'dest' => $jeu->email,
				'sujet' => $sujet,
				'content' => $content,
				'id' => $jeu->id
				);
			modules::run('message', json_encode($mess_datas));
			$joueurs = $this->CronModel->getList('joueurs', array('id_reservation' => $jeu->id));
			foreach($joueurs as $joueur)
			{
				$mess_datas = array(
					'dest' => $joueur->email,
					'sujet' => $sujet,
					'content' => $content,
					'id' => $jeu->id
					);
				modules::run('message', json_encode($mess_datas));
			}
		}
	}

}
?>
