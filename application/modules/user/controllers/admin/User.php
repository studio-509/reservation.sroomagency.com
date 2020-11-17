<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends MY_Controller
{
	function __construct()
    {
        parent::__construct();
        /**
         * Si user non connecté ou user != administrateur et tentative d'accès au module d'admin
         * On redirige vers la page de connexion
         **/
        if(!$this->session->userdata('id_admin') && $this->uri->segment(2) != "connexion")
    		redirect('./user/connexion?page='.$this->uri->segment(2).'/');
    	$this->data['user'] = $this->session->userdata('user');
		$this->data['userfirstname'] = $this->session->userdata('userfirstname');
    	$this->load->model('UserModel');
    	$this->load->libraries(array('form_validation'));
    	$this->load->helper('my_pagination');
    	/**
         * css du module
         **/
        $this->data['module_css'] = load_module_css($this->data['module_css'], 'user');
        /**
         * js du module
         **/
        $this->data['module_js'] = load_module_js($this->data['module_js'],'user');
    }
    public function index()
    {

    	if($this->session->userdata('id_admin') )
			redirect('./user/reservations/');
		else
			redirect('./user/connexion/');
    }
    /**
     * function connexion()
     * page de connexion à l'interface d'administration du site
     * Si la fonction reçoit une variable post, elle tente la connexion
     **/
	public function connexion()
	{
		if($this->session->userdata('id_admin')) {
			$page = ($_GET['page'] != '')?$_GET['page']:'reservations';
			redirect('./user/'.$page.'/');
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
                if ($statut = $this->UserModel->userLogin($user, $mdp)) {
					$page = ($_GET['page'] != '')?$_GET['page']:'reservations';
						redirect('./user/'.$page.'/', 'refresh');
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
		redirect('./user/connexion/','refresh');
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
     * function games()
     * Accès à la page de gestion des parties jouées
     **/
	public function games()
	{
		$this->data['titre'] = 'Parties jouées';
		$this->data['section'] = 'usergames';
		$this->data['module_css'] = load_module_css($this->data['module_css'], 'usergames');
        $this->data['module_js'] = load_module_js($this->data['module_js'],'usergames');
		$this->data['vue'] = modules::run('usergames/admin/Usergamesadmin/listing', $this->data);
        $this->load->view('/admin/admin',$this->data);
	}
	/**
     * function reservations()
     * Accès à la page de gestion des reservations
     **/
	public function reservations()
	{
		$this->data['titre'] = 'Réservations';
		$this->data['section'] = 'userreservations';
		$this->data['module_css'] = load_module_css($this->data['module_css'], 'userreservation');
        $this->data['module_js'] = load_module_js($this->data['module_js'],'userreservation');
		$this->data['vue'] = modules::run('userreservation/admin/Userreservationadmin/listing', $this->data, true);
        $this->load->view('/admin/admin',$this->data);
	}
	/**
     * function rh()
     * Accès à la page de gestion des ressources humaines
     **/
	public function planning()
	{
		$this->data['titre'] = 'Mon planning';
		$this->data['section'] = 'userplanning';
		$this->data['module_css'] = load_module_css($this->data['module_css'], 'userplanning');
        $this->data['module_js'] = load_module_js($this->data['module_js'],'userplanning');
		$this->data['vue'] = modules::run('userplanning/admin/Userplanningadmin/listing', $this->data, true);
        $this->load->view('/admin/admin',$this->data);
	}
	/**
     * function delete()
     * suppression d'un admin
     **/
	public function delete()
    {
	    $post = $this->input->post('message');
		$data = json_decode($post,TRUE);
	    $this->UserModel->deleteData('admin', array('id' => $data['id']));
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
	    $data['client'] = $this->UserModel->getData('admin', array('id' => $data['id']));
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
	    	$result = $this->UserModel->updateData('admin', $datas, array('id' => $data['id']));
	    else
	    {
	    	$result = $this->UserModel->setData('admin', $datas);
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
	    if($this->UserModel->updateData('admin', $datas, array('id' => $data['id'])))
	    {
		    $infos = $this->UserModel->getData('admin', array('id' => $data['id']));
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
