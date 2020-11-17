<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Timeradmin extends MY_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('TimerModel');

    	$this->load->libraries(array('form_validation'));

        /**
         * js du module
         **/
        $this->data['module_js'] = load_module_js($this->data['module_js'],'timer');
    }

    public function index()
    {
        $this->data['salles'] = $this->TimerModel->getTimerDatas();
        $this->load->view('admin/timer', $this->data);
    }

    public function startTimer()
    {
        $post = $this->input->post('message');
		$data = json_decode($post,TRUE);

        $test = $this->TimerModel->getData('timer', array('id_salle' => $data['id']));

        if($test === FALSE)
        {
            $now = time();
            $this->TimerModel->setData('timer', array('starter' => $now, 'id_salle' => $data['id'], 'vue' => 1));
            $diff = 3600;
            $auto_start = 'true';
        }
        elseif($test->pause == 0)
        {
            $diff = ($test->starter + $diff) - time();
            $auto_start = 'true';
        }
        else
        {
            $diff = ($test->starter + $diff) - time();
            $auto_start = 'false';
        }

        $return = $this->setTimer($data['id'], $diff, $auto_start);
        echo $return;
    }

    public function resetTimer()
    {
        $post = $this->input->post('message');
		$data = json_decode($post,TRUE);

        $this->TimerModel->deleteData('timer', array('id_salle' => $data['id']));

        $return = $this->setTimer($data['id'], 3600);
        echo $return;
    }

    public function pauseTimer()
    {
        $post = $this->input->post('message');
		$data = json_decode($post,TRUE);

        $now = time();
        $this->TimerModel->updateData('timer', array('pause' => $now, 'vue' => 1), array('id_salle' => $data['id']));
        $test = $this->TimerModel->getData('timer', array('id_salle' => $data['id']));
        $reste = ($test->starter + 3600) - $now;

        $return = $this->setTimer($data['id'], $reste, 'false');
        echo $return;
    }

    public function restartTimer()
    {
        $post = $this->input->post('message');
		$data = json_decode($post,TRUE);

        $now = time();
        $partie = $this->TimerModel->getData('timer', array('id_salle' => $data['id']));
        $diff = $now - $partie->pause;
        $new = $partie->starter + $diff;
        $this->TimerModel->updateData('timer', array('pause' => 0, 'starter' => $new, 'vue' => 1), array('id_salle' => $data['id']));

        $reste = ($new + 3600) - $now;

        $return = $this->setTimer($data['id'], $reste, 'true');
        echo $return;
    }

    public function setTimer($salle = '', $time = '', $auto_start = 'false')
    {
        $this->data['diff'] = $time;
        $this->data['salle'] = $salle;
        $this->data['auto_start'] = $auto_start;
        $this->data['infos'] = $this->TimerModel->getdata('salle', array('id' => $salle));

        if($this->input->post)
        {
            $post = $this->input->post('message');
			$data = json_decode($post,TRUE);

            $this->data['diff'] = $data['time'];
            $this->data['salle'] = $data['id'];
            $vue = $this->load->view('admin/blocTimer', $this->data);
            echo $vue;
        }
        else
        {
            $vue = $this->load->view('admin/blocTimer', $this->data, true);
            return $vue;
        }
    }

    public function message()
    {
        $post = $this->input->post('message');
		$data = json_decode($post,TRUE);

        $this->TimerModel->updateData('timer', array('affiche' => $data['message'], 'vue' => 1), array('id_salle' => $data['id']));

        echo $data['message'];
    }

}
