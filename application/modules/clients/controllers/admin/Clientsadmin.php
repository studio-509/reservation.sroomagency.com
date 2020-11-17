<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Clientsadmin extends MY_Controller
{
	function __construct(){
		parent::__construct();
		/*** Si user non connecté ou user != administrateur et tentative d'accès au module d'admin* On redirige vers la page de connexion**/
		if(!$this->session->userdata('id_admin') && $this->uri->segment(2) != "connexion")
		die();
		$this->load->model('ClientsModel');
		$this->load->libraries(['form_validation','pagination']);
		$this->load->helper('my_pagination');
		/*** css du module**/
		$this->data['module_css'] = load_module_css($this->data['module_css'], 'clients');
		/*** js du module**/
		$this->data['module_js'] = load_module_js($this->data['module_js'],'clients');}

	public function listing() {
		$this->data['clientsliste'] = $this->get_clients_list();
		$this->data['joueursliste'] = $this->get_joueurs_list();
		$this->data['societesliste'] = $this->get_societes_list();
		$vue = $this->load->view('/admin/listing', $this->data, TRUE);
		return $vue;
	}
	
	public function get_clients_list(){
		
		$this->data['vuetab'] = $this->search_clients_list();	
		//$this->data['clients'] = $this->ClientsModel->getList('client','','','',array(0=>'50',1=>'0'));		
		$vue = $this->load->view('/admin/clientsListing', $this->data, TRUE);		
		return $vue;		
	}
	
	public function search_clients_list(){
		
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);	
		$searchsql = ($data['search'] != '')?"id LIKE '%".$data['search']."%' OR prenom LIKE '%".$data['search']."%' OR nom LIKE '%".$data['search']."%' OR email LIKE '%".$data['search']."%'":"";	
		$limit = ($data['results_page'] != '')?$data['results_page']:50;
		$offset = ($data['offset'] != '')?$data['offset']:0;
		$order = ($data['order'] != '')?$data['order']:"";		
		$this->data['clients'] = $this->ClientsModel->getList('client',$searchsql,'*',$order,array($limit,$offset));
		
		
		if($this->input->is_ajax_request())
		{
			$vue = $this->load->view('/admin/tabClient', $this->data);
			echo $vue;
		}
		else
		{
			$vue = $this->load->view('/admin/tabClient', $this->data, TRUE);
			return $vue;
		}
		
	}
	
	public function get_joueurs_list(){
		
		$this->data['vuetab'] = $this->search_joueurs_list();	
		$this->data['joueurs'] = $this->ClientsModel->getList('joueurs');		
		$vue = $this->load->view('/admin/joueursListing', $this->data, TRUE);		
		return $vue;
	}
	
	public function search_joueurs_list(){
		
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$searchsql = ($data['search'] != '')?"id LIKE '%".$data['search']."%' OR prenom LIKE '%".$data['search']."%' OR nom LIKE '%".$data['search']."%' OR email LIKE '%".$data['search']."%'":"";	
		$this->data['joueurs'] = $this->ClientsModel->getList('joueurs',$searchsql,'*');
		
		if($this->input->is_ajax_request())
		{
			$vue = $this->load->view('/admin/tabJoueurs', $this->data);
			echo $vue;
		}
		else
		{
			$vue = $this->load->view('/admin/tabJoueurs', $this->data, TRUE);
			return $vue;
		}
		
	}
	
	public function get_societes_list(){
		
		$this->data['vuetab'] = $this->search_societes_list();	
		$this->data['societes'] = $this->ClientsModel->getList('infos_societe');		
		$vue = $this->load->view('/admin/societesListing', $this->data, TRUE);		
		return $vue;
	}
	
	public function search_societes_list(){
		
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$searchsql = ($data['search'] != '')?"id LIKE '%".$data['search']."%' OR nom LIKE '%".$data['search']."%' OR adresse LIKE '%".$data['search']."%' OR comp_adresse LIKE '%".$data['search']."%' OR code_postal LIKE '%".$data['search']."%' OR ville LIKE '%".$data['search']."%' OR tel LIKE '%".$data['search']."%' OR nom_contact LIKE '%".$data['search']."%' OR email LIKE '%".$data['search']."%'":"";	
		$this->data['societes'] = $this->ClientsModel->getList('infos_societe',$searchsql,'*');
		
		if($this->input->is_ajax_request())
		{
			$vue = $this->load->view('/admin/tabSocietes', $this->data);
			echo $vue;
		}
		else
		{
			$vue = $this->load->view('/admin/tabSocietes', $this->data, TRUE);
			return $vue;
		}
		
	}

	public function delete(){
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$this->ClientsModel->deleteData('client', array('id' => $data['id']));
		$datas = array(
		'rPop' => $data['txt'],
		'rPopTitle' => $data['titre'],
		'rPopClass' => (isset($data['class']))?$data['class']:''
		);
		echo json_encode($datas);
	}
	
	public function delete_joueur(){
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$this->ClientsModel->deleteData('joueurs', array('id' => $data['id']));
		$datas = array(
			'rPop' => $data['txt'],
			'rPopTitle' => $data['titre'],
			'rPopClass' => (isset($data['class']))?$data['class']:''
		);
		echo json_encode($datas);
	}
	
	public function delete_societe(){
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$this->ClientsModel->deleteData('infos_societe', array('id' => $data['id']));
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
		$data['client'] = $this->ClientsModel->getData('client', array('id' => $data['id']));
		$vue = $this->load->view('/admin/formClient', $data, true);
		$datas = array(
		'rPop' => $vue,
		'rPopTitle' => $data['titre'],
		'rPopClass' => (isset($data['class']))?$data['class']:''
		);
		echo json_encode($datas);
	}
	
	public function infos_joueur(){
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$data['joueur'] = $this->ClientsModel->getData('joueurs', array('id' => $data['id']));
		$vue = $this->load->view('/admin/formJoueur', $data, true);
		$datas = array(
			'rPop' => $vue,
			'rPopTitle' => $data['titre'],
			'rPopClass' => (isset($data['class']))?$data['class']:''
		);
		echo json_encode($datas);
	}
	
	public function infos_societe(){
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$data['societe'] = $this->ClientsModel->getData('infos_societe', array('id' => $data['id']));
		$vue = $this->load->view('/admin/formSociete', $data, true);
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
			'civil' => $data['civil'],
			'nom' => $data['nom'],
			'prenom' => $data['prenom'],
			'email' => $data['email'],
			'tel' => $data['tel'],
			'login' => $data['login'],
			'derniere_modif' => $formatmodif
		);
		if($data['password'] != '' && md5($data['password']) != $data['old_pass'])$datas['password'] = md5($data['password']);
		if($data['id'] != ''){			
			$result = $this->ClientsModel->updateData('client', $datas, array('id' => $data['id']));
		}
		else {
			$result = $this->ClientsModel->setData('client', $datas);
		}
		unset($datas);
		if($result)
		{
			$txt = ($data['id'] != '')?'Mise à jour effectuée avec succès':'Ajout effectué avec succès';
			$class = 'success';
		}
		else
		{
			$txt = ($data['id'] != '')?'Erreur lors de la mise à jour':'Erreur lors de l\'ajout du client';
			$class = 'alerte';	
		}		
		$vue = $this->load->view('/admin/formClient', $data, true);		
		$datas = array(		
			'rPop' => $txt,		
			'rPopTitle' => $data['titre'],		
			'rPopClass' => $class		
		);		
		echo json_encode($datas);
	}
	
	public function update_joueur(){
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$dernieremodif = time();
		$formatmodif = date('Y-m-d H:i:s', $dernieremodif);
		$datas = array(
			'civil' => $data['civil'],
			'nom' => $data['nom'],
			'prenom' => $data['prenom'],
			'email' => $data['email'],
			'id_reservation' => $data['id_reservation'],
			'derniere_modif' => $formatmodif
		);
		if($data['id'] != ''){			
			$result = $this->ClientsModel->updateData('joueurs', $datas, array('id' => $data['id']));
		}
		else {
			$result = $this->ClientsModel->setData('joueurs', $datas);
		}
		unset($datas);
		if($result)
		{
			$txt = ($data['id'] != '')?'Mise à jour effectuée avec succès':'Ajout effectué avec succès';
			$class = 'success';
		}
		else
		{
			$txt = ($data['id'] != '')?'Erreur lors de la mise à jour':'Erreur lors de l\'ajout du joueur';
			$class = 'alerte';		
		}		
		
		$vue = $this->load->view('/admin/formJoueur', $data, true);	
		$datas = array(		
			'rPop' => $txt,		
			'rPopTitle' => $data['titre'],		
			'rPopClass' => $class		
		);		
			
		echo json_encode($datas);
	}
	
	public function update_societe(){
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$dernieremodif = time();
		$formatmodif = date('Y-m-d H:i:s', $dernieremodif);
		$datas = array(
			'nom' => $data['nom'],
			'adresse' => $data['adresse'],
			'comp_adresse' => $data['comp_adresse'],
			'code_postal' => $data['code_postal'],
			'ville' => $data['ville'],
			'tel' => $data['tel'],
			'email' => $data['email'],
			'nom_contact' => $data['nom_contact'],
			'comment' => $data['comment'],
			'derniere_modif' => $formatmodif 
		);
		if($data['id'] != ''){			
			$result = $this->ClientsModel->updateData('infos_societe', $datas, array('id' => $data['id']));
		}
		else {
			$result = $this->ClientsModel->setData('infos_societe', $datas);
		}
		unset($datas);
		if($result)
		{
			$txt = ($data['id'] != '')?'Mise à jour effectuée avec succès':'Ajout effectué avec succès';
			$class = 'success';
		}
		else
		{
			$txt = ($data['id'] != '')?'Erreur lors de la mise à jour':'Erreur lors de l\'ajout de la société';
			$class = 'alerte';		
		}		
		
		$vue = $this->load->view('/admin/formSociete', $data, true);	
		$datas = array(		
			'rPop' => $txt,		
			'rPopTitle' => $data['titre'],		
			'rPopClass' => $class		
		);		
			
		echo json_encode($datas);
	}

	public function pass(){		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);		$datas['password'] = md5($data['password']);		if($this->ClientsModel->updateData('client', $datas, array('id' => $data['id'])))		{			$infos = $this->ClientsModel->getData('client', array('id' => $data['id']));			$sujet = 'Votre mot de passe sur ' . APP_NAME;			$content = 'Voici votre nouveau mot de passe sur le site ' . APP_NAME . ' : ' . $data['password'];			$mess_datas = array(			'dest' => $infos->email,			'sujet' => $sujet,			'content' => $content			);			modules::run('message', json_encode($mess_datas));			$txt = 'Mise à jour effectuée avec succès';			$class = 'success';		}		else		{			$txt = 'Erreur lors de la mise à jour';			$class = 'alerte';		}		$vue = $this->load->view('/admin/formClient', $data, true);		$datas = array(		'rPop' => $txt,		'rPopTitle' => $data['titre'],		'rPopClass' => $class		);		echo json_encode($datas);
	}
}