<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends MY_Controller
{
	function __construct()
    {
        parent::__construct();
        /**
         * Si user non connecté ou user != administrateur et tentative d'accès au module d'admin
         * On redirige vers la page de connexion
         **/
        if((!$this->session->userdata('id_admin')|| $this->session->userdata('type') != "0") && $this->uri->segment(2) != "connexion")
    		redirect('./admin/connexion?page='.$this->uri->segment(2).'/');
    	$this->data['user'] = $this->session->userdata('user');
    	$this->load->model('AdminModel');
    	$this->load->libraries(array('form_validation'));
    	$this->load->helper('my_pagination');
    	/**
         * css du module
         **/
        $this->data['module_css'] = load_module_css($this->data['module_css'], 'admin');
        /**
         * js du module
         **/
        $this->data['module_js'] = load_module_js($this->data['module_js'],'admin');
    }
    public function index()
    {
    	if($this->session->userdata('id_admin') && $this->session->userdata('type') == "0")
			redirect('./admin/reservations/');
		else
			redirect('./admin/connexion/');
    }
    /**
     * function connexion()
     * page de connexion à l'interface d'administration du site
     * Si la fonction reçoit une variable post, elle tente la connexion
     **/
	public function connexion()
	{
		if($this->session->userdata('id_admin') && $this->session->userdata('type') == "0") {
			$page = ($_GET['page'] != '')?$_GET['page']:'reservations';
			redirect('./admin/'.$page.'/');
		}
		// tentative de connexion
     	if($this->input->post('user'))
     	{
     		$user = $this->input->post('user');
            $mdp = $this->input->post('mdp');
            // tests et validation formulaire
            $this->form_validation->set_message('required', 'Le champs ci dessus est obligatoire.');
            $this->form_validation->set_rules('user', '"user"', 'required|trim');
            $this->form_validation->set_rules('mdp', '"mdp"', 'required|trim');
            if ($this->form_validation->run() == true)
			{
                if ($statut = $this->AdminModel->userLogin($user, $mdp)) {
					if ($statut == "admin") {
						$page = ($_GET['page'] != '')?$_GET['page']:'reservations';
						redirect('./admin/'.$page.'/', 'refresh');
					}
					else {
						$this->data['error'] = "Ce compte n'est pas un compte administrateur";
						$this->load->view('/admin/connexion',$this->data);
					}
				}
                else
				{
                    $this->data['error'] = "Aucun compte ne correspond à vos identifiants";
                    $this->load->view('/admin/connexion',$this->data);
                }
            }
            else
            {
                $this->data['error'] = "Une erreur est survenue, veuillez vous reconnecter";
                $this->load->view('/admin/connexion',$this->data);
            }
     	}
     	else
			$this->load->view('/admin/connexion',$this->data);
	}
	/**
     * function logout()
     * déconnexion de l'interface d'administration du site
     **/
	public function logout()
	{
        $this->session->sess_destroy();
		redirect('./admin/connexion/','refresh');
	}
	/**
     * function error404()
     * affiche la page 404
     **/
    public function error404()
    {
    	$this->data['vue'] = $this->load->view('404', $this->data, true);
		$this->load->view('/admin',$this->data);
    }
	/**
     * function dashboard()
     * Accès à la page d'accueil de l'administration du site
     **/
	public function dashboard()
	{
		$this->data['titre'] = 'Dashboard';
		$this->data['section'] = 'dashboard';
		$this->output->enable_profiler(TRUE);
		$this->data['vue'] = $this->load->view('/admin/dashboard', $this->data, true);
        $this->load->view('/admin',$this->data);
	}
	/**
     * function games()
     * Accès à la page de gestion des parties jouées
     **/
	public function games()
	{
		$this->data['titre'] = 'Parties jouées';
		$this->data['section'] = 'games';
		$this->data['module_css'] = load_module_css($this->data['module_css'], 'games');
        $this->data['module_js'] = load_module_js($this->data['module_js'],'games');
		$this->data['vue'] = modules::run('games/admin/Gamesadmin/listing', $this->data);
        $this->load->view('/admin/admin',$this->data);
	}
	/**
     * function games()
     * Accès à la page de gestion des clients
     **/
	public function clients()
	{
		$this->data['titre'] = 'Gestion clients';
		$this->data['section'] = 'clients';
		$this->data['module_css'] = load_module_css($this->data['module_css'], 'clients');
        $this->data['module_js'] = load_module_js($this->data['module_js'],'clients');
		$this->data['vue'] = modules::run('clients/admin/Clientsadmin/listing', $this->data);
        $this->load->view('/admin/admin',$this->data);
	}
	/**
     * function timer()
     * Accès à la page de gestion dujeu
     **/
	public function timer()
	{
		$this->data['titre'] = 'Gestion du jeu';
		$this->data['section'] = 'timer';
		$this->data['module_css'] = load_module_css($this->data['module_css'], 'timer');
        $this->data['module_js'] = load_module_js($this->data['module_js'],'timer');
		$this->data['vue'] = modules::run('timer/admin/Timeradmin/index', $this->data);
        $this->load->view('/admin/admin',$this->data);
	}
	/**
     * function reservations()
     * Accès à la page de gestion des reservations
     **/
	public function reservations()
	{
		$this->data['titre'] = 'Gestion réservations';
		$this->data['section'] = 'reservations';
		$this->data['module_css'] = load_module_css($this->data['module_css'], 'reservation');
        $this->data['module_js'] = load_module_js($this->data['module_js'],'reservation');
		$this->data['vue'] = modules::run('reservation/admin/Reservationadmin/listing', $this->data, true);
        $this->load->view('/admin/admin',$this->data);
	}
	/**
     * function salles()
     * Accès à la page de gestion des salles
     **/
	public function salles()
	{
		$this->data['titre'] = 'Gestion salles';
		$this->data['section'] = 'salles';
		$this->data['module_css'] = load_module_css($this->data['module_css'], 'salles');
        $this->data['module_js'] = load_module_js($this->data['module_js'],'salles');
		$this->data['vue'] = modules::run('salles/admin/Sallesadmin/listing', $this->data, true);
        $this->load->view('/admin/admin',$this->data);
	}
	/**
     * function tarifs()
     * Accès à la page de gestion des tarifs
     **/
	public function tarifs()
	{
		$this->data['titre'] = 'Gestion des tarifs et promotions';
		$this->data['section'] = 'tarifs';
		$this->data['module_css'] = load_module_css($this->data['module_css'], 'tarifs');
        $this->data['module_js'] = load_module_js($this->data['module_js'],'tarifs');
		$this->data['vue'] = modules::run('tarifs/admin/Tarifsadmin/listing', $this->data, true);
        $this->load->view('/admin/admin',$this->data);
	}
	/**
		 * function vouchers()
		 * Accès à la page de gestion des vouchers
		 **/
	public function vouchers(){
		$this->data['titre'] = 'Gestion des cartes cadeaux';
		$this->data['section'] = 'vouchers';
		$this->data['module_js'] = load_module_js($this->data['module_js'],'voucher');
		$this->data['vue'] = modules::run('voucher/admin/Voucheradmin/listing', $this->data, true);
		$this->load->view('/admin/admin',$this->data);
	}
	/**
     * function emails()
     * Accès à la page de gestion des emails
     **/
	public function emails()
	{
		$this->data['titre'] = 'Gestion emails';
		$this->data['section'] = 'emails';
		$this->data['module_css'] = load_module_css($this->data['module_css'], 'emails');
        $this->data['module_js'] = load_module_js($this->data['module_js'],'emails');
		$this->data['vue'] = modules::run('emails/admin/Emailsadmin/listing', $this->data, true);
        $this->load->view('/admin/admin',$this->data);
	}
	/**
     * function rh()
     * Accès à la page de gestion des ressources humaines
     **/
	public function rh()
	{
		$this->data['titre'] = 'Gestion du personnel';
		$this->data['section'] = 'rh';
		$this->data['module_css'] = load_module_css($this->data['module_css'], 'rh');
        $this->data['module_js'] = load_module_js($this->data['module_js'],'rh');
		$this->data['vue'] = modules::run('rh/admin/Rhadmin/listing', $this->data, true);
        $this->load->view('/admin/admin',$this->data);
	}
	/**
     * function admins()
     * Accès à la page de gestion des admins
     **/
	public function admins()
	{
		$this->data['titre'] = 'Gestion administrateurs';
		$this->data['section'] = 'admins';
		$limit = getLimit(PAGINATION);
	    $this->data['nbRes'] = $this->AdminModel->getNbData('admin');
		$this->data['pagination'] = pagination($this->data['nbRes'], PAGINATION);
	    $this->data['admins'] = $this->AdminModel->getList('admin','','*','',$limit);
		$this->data['vue'] = $this->load->view('/admin/listing', $this->data, true);
        $this->load->view('/admin',$this->data);
	}
	/**
     * function stats()
     * Accès à la page de gestion des stats
     **/
	public function stats()
	{
		$this->data['titre'] = 'Statistiques';
		$this->data['section'] = 'stats';
		$this->data['module_css'] = load_module_css($this->data['module_css'], 'stats');
        $this->data['module_js'] = load_module_js($this->data['module_js'],'stats');
		$this->data['vue'] = modules::run('stats/admin/Statsadmin/listing', $this->data);
        $this->load->view('/admin/admin',$this->data);
	}
	public function modepaiement()
	{
		$reservationsms = $this->AdminModel->getList('reservation',array('regle' => 1));
		foreach ($reservationsms as $rms) {
			if ($rms->prix != 0) $this->AdminModel->setData('mode_paiement',array('id_resa' => $rms->id, 'modep' => 'MS', 'reference' => $rms->id, 'montant' => $rms->prix));
			if ($rms->voucher != "" && $rms->voucher != "0") {
 				$voucher = $this->AdminModel->getData('voucher',array('code' => $rms->voucher));
				$this->AdminModel->setData('mode_paiement',array('id_resa' => $rms->id, 'modep' => 'KC', 'reference' => $rms->voucher, 'montant' => $voucher->montant));
 			}
		}
	}
	/**
     * function delete()
     * suppression d'un admin
     **/
	public function delete()
    {
	    $post = $this->input->post('message');
		$data = json_decode($post,TRUE);
	    $this->AdminModel->deleteData('admin', array('id' => $data['id']));
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
	    $data['client'] = $this->AdminModel->getData('admin', array('id' => $data['id']));
	    $vue = $this->load->view('/admin/form', $data, true);
	    $datas = array(
		    'rPop' => $vue,
		    'rPopTitle' => $data['titre'],
		    'rPopClass' => (isset($data['class']))?$data['class']:''
	    );
	    echo json_encode($datas);
    }
    public function update()
    {
	    $post = $this->input->post('message');
		$data = json_decode($post,TRUE);
	    $datas = array(
				'civil' => $data['civil'],
		    'nom' => $data['nom'],
			'prenom' => $data['prenom'],
			'email' => $data['email'],
			'login' => $data['login']
	    );
	    if($data['password'] != '' && md5($data['password']) != $data['old_pass'])
	    	$datas['password'] = md5($data['password']);
	    if($data['id'] != '')
	    	$result = $this->AdminModel->updateData('admin', $datas, array('id' => $data['id']));
	    else
	    {
	    	$result = $this->AdminModel->setData('admin', $datas);
	    	$sujet = 'Vos identifiants administrateur sur ' . APP_NAME;
		    $content = 'Voici identifiants administrateur site ' . APP_NAME . ' : <br />Login : ' . $data['login'] . '<br />Mot de passe : ' . $data['password'];
		    $mess_datas = array(
			    'dest' => $infos->email,
			    'sujet' => $sujet,
			    'content' => $content
		    );
		    modules::run('message', json_encode($mess_datas));
		}
	    if($result)
	    {
	    	$txt = ($data['id'] != '')?'Mise à jour effectuée avec succès':'Admin ajouté avec succès';
	    	$class = 'success';
	    }
	    else
	    {
		    $txt = ($data['id'] != '')?'Erreur lors de la mise à jour':'Erreur lors de l\'ajout de l\'admin';
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
    public function pass()
    {
	    $post = $this->input->post('message');
		$data = json_decode($post,TRUE);
	    $datas['password'] = md5($data['password']);
	    if($this->AdminModel->updateData('admin', $datas, array('id' => $data['id'])))
	    {
		    $infos = $this->AdminModel->getData('admin', array('id' => $data['id']));
		    $sujet = 'Votre mot de passe sur ' . APP_NAME;
		    $content = 'Voici votre nouveau mot de passe admin site ' . APP_NAME . ' : ' . $data['password'];
		    $mess_datas = array(
			    'dest' => $infos->email,
			    'sujet' => $sujet,
			    'content' => $content
		    );
		    modules::run('message', json_encode($mess_datas));
	    	$txt = 'Mise à jour effectuée avec succès';
	    	$class = 'success';
	    }
	    else
	    {
		    $txt = 'Erreur lors de la mise à jour';
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
}
