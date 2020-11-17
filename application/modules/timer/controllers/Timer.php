<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Timer extends MY_Controller
{
	function __construct()
    {
        parent::__construct();

        $this->load->model('TimerModel');

    	/**
         * css du module
         **/
        //$this->data['module_css'] = load_module_css($this->data['module_css'], 'timer');

        /**
         * js du module
         **/
        $this->data['module_js'] = load_module_js($this->data['module_js'],'timer');
    }

	public function index()
	{
		$this->data['salles'] = $this->TimerModel->getList('salle', array('active' => 1));
		$this->load->view('front/index', $this->data);
	}

	public function salle()
	{
		if(!$this->uri->segment(3))
		{
			$this->index();
			exit;
		}

		$id = $this->uri->segment(3);
		$this->data['salle'] = $this->TimerModel->getTimerById($id);
		$this->load->view('front/timer', $this->data);
	}

	public function test()
    {
        $id = $this->input->post('id');

        $partie = $this->TimerModel->getData('timer', array('id_salle' => $id));
        $this->TimerModel->updateData('timer', array('vue' => 0), array('id_salle' => $id));

        echo ($partie === FALSE)?'2':$partie->vue;
    }
}
