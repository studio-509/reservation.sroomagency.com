<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminModel extends MY_Model
{
	/**
     * function userLogin()
     * @param	$user (string)	pseudo du user
     * @param	$mdp (string)	mot de passe du user
     *
     * @return	"ok" si ok sinon false
     **/
     function userLogin($user,$mdp)
     {
     	$this->db->select('*');
		$this->db->from('admin');
		$this->db->where('login', $user);
		$this->db->where('password', md5($mdp));

		$data = $this->db->get()->result();

		if(!empty($data))
		{
			foreach ($data as $val)
			{
				$this->session->set_userdata('id_admin', $val->id);
   				$this->session->set_userdata('user',  $val->prenom . " " . $val->nom);
				$this->session->set_userdata('type',  $val->type);
				$isadmin = ($val->type == "0")?"admin":"user";
			}
			return $isadmin;
		}
		else
			return false;
     }
}
