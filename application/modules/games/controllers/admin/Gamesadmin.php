<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Gamesadmin extends MY_Controller
{
	function __construct(){
		parent::__construct();
		/*** Si user non connecté ou user != administrateur et tentative d'accès au module d'admin* On redirige vers la page de connexion**/
		if(!$this->session->userdata('id_admin') && $this->uri->segment(2) != "connexion")
		die();
		$this->load->model('GamesModel');
		$this->load->libraries(['form_validation','pagination']);
		$this->load->helper('my_pagination');
		/*** css du module**/
		$this->data['module_css'] = load_module_css($this->data['module_css'], 'games');
		/*** js du module**/
		$this->data['module_js'] = load_module_js($this->data['module_js'],'games');}
	
	public function listing() {
		$this->data['gamesliste'] = $this->get_games_list();
		$vue = $this->load->view('/admin/listing', $this->data, TRUE);
		return $vue;
	}
	
	public function get_games_list(){
		
		$this->data['vuetab'] = $this->search_games_list();		
		$vue = $this->load->view('/admin/gamesListing', $this->data, TRUE);		
		return $vue;		
	}
	
	public function search_games_list(){
		
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$this->data['games'] = $this->GamesModel->getGamesList($data['search'],$data['searchstart'],$data['searchend']);
		$this->data['salles'] = $this->GamesModel->getList('salle');
		
		if($this->input->is_ajax_request())
		{
			$vue = $this->load->view('/admin/tabGames', $this->data);
			echo $vue;
		}
		else
		{
			$vue = $this->load->view('/admin/tabGames', $this->data, TRUE);
			return $vue;
		}
		
	}

	public function delete(){
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$this->GamesModel->deleteData('infos_partie', array('id' => $data['id']));
		$this->GamesModel->deleteData('agent', array('id_partie' => $data['id']));
		$datas = array(
			'rPop' => $data['txt'],
			'rPopTitle' => $data['titre'],
			'rPopClass' => (isset($data['class']))?$data['class']:''
		);
		echo json_encode($datas);
	}
	
	public function infos(){
		
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$data['game'] = $this->GamesModel->getGame($data['idresa']);
		$data['resajoueurs'] = $this->GamesModel->getList('joueurs',array('id_reservation' => $data['idresa']));
		$data['infosjoueurs'] = $this->GamesModel->getList('agent',array('id_partie' => $data['game']->id));
		$vue = $this->load->view('/admin/formGames', $data, true);
		if ($data['game']->id != "") $data["titre"] = "Modification d'une partie jouée";
		$datas = array(
			'rPop' => $vue,
			'rPopTitle' => $data['titre'],
			'rPopClass' => (isset($data['class']))?$data['class']:''
		);
		echo json_encode($datas);
	}
	
	public function update(){
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$dernieremodif = time();
		$formatmodif = date('Y-m-d H:i:s', $dernieremodif);
		$datas = array(
				"id_resa" => $data['id_resa'],
				"nom_equipe" => $data['nom_equipe'],
				"nb_joueurs" => $data['nb_joueurs'],
				"reussite" => $data['reussite'],
				"nb_indices" => $data['nb_indices'],
				"tps_jeu" => $data['tps_jeu'],
				"lien_photo" => $data['lien_photo'],
				"pub_photo" => $data['pub_photo'],
				"envoi_photo" => $data['envoi_photo'],
				"envoi_mail" => $data['envoi_mail'], 
				"commentaire" => $data['commentaire']			
		);
		if($data['id'] != ''){			
			$result1 = $this->GamesModel->updateData('infos_partie', $datas, array('id' => $data['id']));
			$idpartie = $data['id'];
		}
		else {
			$result1 = $this->GamesModel->setData('infos_partie', $datas, TRUE);
			$idpartie = $result1;
		}
		unset($datas);  
		
		$result2 = true;
 		$infos_joueurs = explode('||',$data['infos_joueurs']);
		foreach ($infos_joueurs as $infos) {
			$inf = explode('|',$infos);
			$datas = array(
				"id_partie" => $idpartie,
				"nom" => ($inf[2] != "no")?$inf[2]:"",
				"prenom" => ($inf[3] != "no")?$inf[3]:"",
				"email" => ($inf[4] != "no")?$inf[4]:"",
				"postal" => ($inf[5] != "00000")?$inf[5]:"",
				"niveau" => ($inf[6] != "no")?$inf[6]:"",
				"vecteur" => ($inf[7] != "no")?$inf[7]:""			
			);
			if($inf[0] != 'no'){			
				$result = $this->GamesModel->updateData('agent', $datas, array('id' => $inf[0]));
			}
			else {
				$result = $this->GamesModel->setData('agent', $datas);
			}
				
			if(!$result) $result2 = false;
			unset($result);
			unset($datas);	
		}  
		
		if($result2)
		{
			$txt = ($data['id'] != '')?'Mise à jour effectuée avec succès':'Ajout effectué avec succès';
			$class = 'success';
		}
		else
		{
			$txt = ($data['id'] != '')?'Erreur lors de la mise à jour':'Erreur lors de l\'ajout du client';
			$class = 'alerte';	
		}		
		//$vue = $this->load->view('/admin/formGames', $data, true);		
		$datas = array(		
			'rPop' => $txt,		
			'rPopTitle' => $data['titre'],		
			'rPopClass' => $class		
		);		
		echo json_encode($datas);
	}
	
	public function getRank($resaid) {
		$infos_partie = $this->GamesModel->getGame($resaid);
		if ($infos_partie->tps_jeu == "00:00:00") return "n/a";
		else {
			$rank = $this->GamesModel->getRanking($infos_partie->id_salle,$infos_partie->tps_jeu);
			return $rank; 
		}
		
		
	}
	
}