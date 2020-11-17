<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class VoucherModel extends MY_Model
{
  /**
  * function get_list_voucher()()
  * Ins�re plusieurs lignes simultan�es dans la table
  *
  * @return liste des vouchers (join avec clients)
  **/
  public function get_list_voucher($limit = NULL)
  {
    $this->db->select('voucher.id as voucher_id');
    $this->db->select('client.nom as cl_nom');
    $this->db->select('client.prenom as cl_prenom');
    $this->db->select('voucher.montant as voucher_montant');
    $this->db->select('voucher.code as voucher_code');
    $this->db->select('voucher.valide as voucher_val');
	$this->db->select('voucher.id_type as voucher_idtype');
	$this->db->select('voucher.id_dest as voucher_iddest');
	$this->db->select('voucher.date_achat as voucher_date_achat');
	$this->db->select('voucher.commentaires as voucher_commentaires');
    $this->db->from('voucher');
    $this->db->join('client', 'client.id = voucher.id_client','inner');
    if($limit !== NULL){
      $this->db->limit($limit[0], $limit[1]);
    }
    return $this->db->get()->result();
  }

  public function get_voucher_details($id)
  {
    $this->db->select('client.id as cl_id');
    $this->db->select('client.nom as cl_nom');
    $this->db->select('client.civil as cl_civil');
    $this->db->select('client.prenom as cl_prenom');
    $this->db->select('client.email as cl_email');
    $this->db->select('client.tel as cl_tel');
    $this->db->select('voucher.code as voucher_code');
    $this->db->select('voucher.id_type as type_id');
    $this->db->select('voucher.valide as active');
    $this->db->select('voucher.id_dest as dest_id');
	$this->db->select('voucher.commentaires as comment');
    $this->db->select('voucher_type.prix as voucher_prix');
    $this->db->select('voucher_type.titre as voucher_titre');
    $this->db->from('voucher');
    $this->db->join('client', 'client.id = voucher.id_client','inner');
    $this->db->join('voucher_type','voucher_type.id = voucher.id_type');
    $this->db->where('voucher.id = '.$id);
    $item = $this->db->get()->row();
    $data = [];
    $data['item'] = $item;
    // Si le destinataire était défini dans la BDD, on récupére les infos
    if($item->dest_id != '0')
    {
      if ( ($dest = $this->getData('client',['id' => $item->dest_id],'nom, prenom, email,civil,id')) !== FALSE)
      {
        $data['dest'] = $dest;
      }
      else
      {
        $data['dest'] = NULL;
      }
    }
    else
    {
      $data['dest'] = NULL;
    }
    return $data;
  }
  
}
