<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TimerModel extends MY_Model
{
    function getTimerDatas()
    {
        $this->db->select('s.id, s.nom, t.starter, t.pause, t.affiche');
        $this->db->from('salle s');
        $this->db->join('timer t','t.id_salle = s.id','left');
        $this->db->where(array('s.active' => 1));

        return $this->db->get()->result();
    }

    function getTimerById($id)
    {
        $this->db->select('s.id, s.nom, t.starter, t.pause, t.affiche');
        $this->db->from('salle s');
        $this->db->join('timer t','t.id_salle = s.id','left');
        $this->db->where(array('s.id' => $id));

        $result = $this->db->get()->result();
        return $result[0];
    }
}
