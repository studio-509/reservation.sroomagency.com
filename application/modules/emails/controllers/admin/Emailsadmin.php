<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Emailsadmin extends MY_Controller
{
	function __construct()
    {
        parent::__construct();
        
        $this->load->model('EmailsModel');
    	
    	/**
         * css du module
         **/
        $this->data['module_css'] = load_module_css($this->data['module_css'], 'emails');
                                
        /**
         * js du module
         **/
        $this->data['module_js'] = load_module_js($this->data['module_js'],'emails');
    }
    
    public function listing()
    {
	    $this->data['emails'] = $this->EmailsModel->getList('email');
	    
	    $vue = $this->load->view('/admin/listing', $this->data, true);
	    
	    return $vue;
    }
    
    public function delete()
    {
	    $post = $this->input->post('message');
		$data = json_decode($post,TRUE);
	    $this->EmailsModel->deleteData('email', array('id' => $data['id']));
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
	    $data['actions'] = $this->EmailsModel->getList('email');
	    $data['email'] = $this->EmailsModel->getData('email', array('id' => $data['id']));
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
		    'sujet' => $data['sujet'],
		    'message' => $data['message']
	    );
	    if($data['id'] != '')
	    	$result = $this->EmailsModel->updateData('email', $datas, array('id' => $data['id']));
	    else
	    	$result = $this->EmailsModel->setData('email', $datas);
	    	
	    if($result)
	    {
	    	$txt = 'Mise à jour effectuée avec succès';
	    	$class = 'success';
	    }
	    else
	    {
		    $txt = 'Erreur lors de la mise à jour';
	    	$class = 'alerte';
	    }
	    
	    $data['actions'] = $this->EmailsModel->getList('email');
	    $vue = $this->load->view('/admin/form', $data, true);
	    $datas = array(
		    'rPop' => $txt,
		    'rPopTitle' => $data['titre'],
		    'rPopClass' => $class
	    );
	    echo json_encode($datas);
    }
}