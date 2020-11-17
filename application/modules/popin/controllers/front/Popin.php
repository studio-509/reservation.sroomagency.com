<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Popin extends MY_Controller
{
	function __construct()
    {
        parent::__construct();
    }

    public function index($datas)
    {
	    $this->load->view('front/popin', $datas);
    }

    public function confirm()
    {
	    $post = $this->input->post('message');
		$data = json_decode($post,TRUE);
	    $vue = $this->load->view('front/confirm', $data, true);
	    $datas = array(
		    'rPop' => $vue,
		    'rPopTitle' => $data['titre'],
		    'rPopClass' => (isset($data['class']))?$data['class']:''
	    );
	    echo json_encode($datas);
    }

		public function valid()
    {
	    $post = $this->input->post('message');
		$data = json_decode($post,TRUE);
	    $vue = $this->load->view('front/valid', $data, true);
	    $datas = array(
		    'rPop' => $vue,
		    'rPopTitle' => $data['titre'],
		    'rPopClass' => (isset($data['class']))?$data['class']:''
	    );
	    echo json_encode($datas);
    }
}
