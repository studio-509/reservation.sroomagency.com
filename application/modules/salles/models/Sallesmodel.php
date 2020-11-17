<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SallesModel extends MY_Model
{
	/**
	 * [rotateSet description]
	 * @param  string $set_id id set à reset
	 * @param  string $salle  id salle
	 * @return [type]         [description]
	 */
	public function rotateSet($set_id,$salle){
		$this->updateData('salle__horaire_set',['set_date_begin' => '2099-12-31'],['set_id' => $set_id ]);
		$this->deleteData('horaire',['fk_set_id' => $set_id ] );
		return $this->SallesModel->getList('salle__horaire_set', ['fk_salle_id' => $salle],'*','set_date_begin ASC');
	}
	function getIndispoList($limit = '')
	{
		$jour = date('Y-m-d');
		$heure = date('H\hi');
		$this->db->select('i.*');
		$this->db->from('indispos i');
		$this->db->where('jour >= "'.$jour.'"');
		$this->db->order_by('i.jour DESC, horaire DESC');
		if ( $limit != '')
		{
			$this->db->limit($limit[0],$limit[1]);
		}
		return $this->db->get()->result();
	}

}
