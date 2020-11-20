<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Voucheradmin extends MY_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('VoucherModel');
    $this->load->libraries(['pagination']);
    /**
    * css du module
    **/
    $this->data['module_css'] = load_module_css($this->data['module_css'], 'voucher');
    /**
    * js du module
    **/
    $this->data['module_js'] = load_module_js($this->data['module_js'],'voucher');
  }
  public function listing($offset = 0)
  {
    $pag = PAGINATION;
    // DEBUG
    // $this->output->enable_profiler(TRUE);
    // Verif existence pagination définie dans les valeurs de session
    if($this->session->has_userdata('pag_v'))
    {
      $pag = $this->session->pag_v;
    }
    // Récupération des data Post (Ajax Reload)
    $post = $this->input->post('message');
	$data = json_decode($post,TRUE);
    // Vérif presence d'une valeur de pagination
    if( ! empty($data['pag']))
    {
      $pag = $data['pag'];
      $this->session->pag_v = $pag;
    }
    // Pagination voucher liste
    $offset = $this->uri->segment(3,0);
    // Initialisation variables
    $limit = [$pag,$offset];
    $this->session->offset = $offset;
    $this->data['nbVouch'] = $this->VoucherModel->getNbData('voucher');
    $this->data['voucher_list'] = $this->VoucherModel->get_list_voucher($limit);
	$this->data['voucher_list_dest'] = $this->VoucherModel->getList('client');
	$this->data['voucher_duree'] = $this->VoucherModel->getData('voucher_duree',['id' => 2]);
	
	//A supprimer pour repasser la durée de validité de base des voucher en mode bdd
	$this->data['voucher_duree']->duree = VOUCHER_DURATION;
	
	$this->data['voucher_type'] = $this->VoucherModel->getList('voucher_type');
    // configuration pagination
    $config['base_url'] = APP_URL.'/admin/vouchers';
    $config['total_rows'] = $this->data['nbVouch'];
    $config['per_page'] = $pag;
    $config['full_tag_open'] = '<div class="text-center"><ul class="pagination">';
    $config['full_tag_close'] = '</ul></div><!--pagination-->';
    $config['first_link'] = '&laquo; Premier';
    $config['first_tag_open'] = '<li class="Page prec.">';
    $config['first_tag_close'] = '</li>';
    $config['last_link'] = 'Dernier &raquo;';
    $config['last_tag_open'] = '<li class="Page suiv.">';
    $config['last_tag_close'] = '</li>';
    $config['next_link'] = 'Suivant &rarr;';
    $config['next_tag_open'] = '<li class="Page prec.">';
    $config['next_tag_close'] = '</li>';
    $config['prev_link'] = '&larr; Précédent';
    $config['prev_tag_open'] = '<li class="Page suiv.">';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li class="page">';
    $config['num_tag_close'] = '</li>';
    $config['anchor_class'] = 'follow_link';
    // Initialisation pagination
    $this->pagination->initialize($config);
    $this->data['pagination'] = $this->pagination->create_links();
    $this->data['pag'] = $pag;
    if($this->input->is_ajax_request())
    {
      $vue = $this->load->view('/admin/liste',$this->data);
      echo $vue;
    }
    else
    {
      $this->data['voucher_type'] = $this->VoucherModel->getList('voucher_type');
      $this->data['cgv'] = $this->VoucherModel->getData('voucher_cgv', ['id' => 1]);
      $this->data['descriptif'] = $this->VoucherModel->getData('voucher_cgv',['id' => 2]);
      $vue = $this->load->view('/admin/listing', $this->data, TRUE);
      return $vue;
    }
  }
  public function listing_cgv(){
    if( ! $this->input->is_ajax_request() )
    {
      exit('Appel de controlleur Ajax non conforme');
    }
    else {
      $this->data['voucher_type'] = $this->VoucherModel->getList('voucher_type');
      $this->data['cgv'] = $this->VoucherModel->getData('voucher_cgv', ['id' => 1]);
      $this->data['descriptif'] = $this->VoucherModel->getData('voucher_cgv',['id' => 2]);
      $vue = $this->load->view('/admin/liste_type',$this->data);
      echo $vue;
    }
  }
  public function infos_type()
  {
    $post = $this->input->post('message');
	$data = json_decode($post,TRUE);
    $data['voucher_type'] = $this->VoucherModel->getData('voucher_type', ['id' => $data['id'] ]);
    $vue = $this->load->view('/admin/form_type', $data, TRUE);
    $datas = [
      'rPop' => $vue,
      'rPopTitle' => $data['titre'],
      'rPopClass' => (isset($data['class']))?$data['class']:''
    ];
    echo json_encode($datas);
  }
  public function infos_item()
  {
    $post = $this->input->post('message');
	$data = json_decode($post,TRUE);
    if ( ! empty($data['id']))
    {
      $data['voucher'] = $this->VoucherModel->get_voucher_details($data['id']);
    }
    $data['voucher_type'] = $this->VoucherModel->getList('voucher_type',['active' => 1],'*','prix');
    $vue = $this->load->view('/admin/form_item', $data, TRUE);
    $datas = [
      'rPop' => $vue,
      'rPopTitle' => $data['titre'],
      'rPopClass' => (isset($data['class']))?$data['class']:''
    ];
    echo json_encode($datas);
  }
  public function infos_cgv(){
    $cgv = $this->VoucherModel->getData('voucher_cgv', ['id' => 1]);
    $data['id'] = 1;
    $data['txt'] = $cgv->cgv;
    $vue = $this->load->view('/admin/form_cgv',$data,TRUE);
    $datas = [
      'rPop' => $vue,
      'rPopTitle' => 'Modification CGV cartes cadeaux',
      'rPopClass' => (isset($data['class']))?$data['class']:''
    ];
    echo json_encode($datas);
  }
  public function infos_desc(){
    $descriptif = $this->VoucherModel->getData('voucher_cgv', ['id' => 2]);
    $data['id'] = 2;
    $data['txt'] = $descriptif->cgv;
    $vue = $this->load->view('/admin/form_cgv',$data,TRUE);
    $datas = [
      'rPop' => $vue,
      'rPopTitle' => 'Modification Descriptif cartes cadeaux',
      'rPopClass' => (isset($data['class']))?$data['class']:''
    ];
    echo json_encode($datas);
  }
  public function update()
  {
    $post = $this->input->post('message');
	$data = json_decode($post,TRUE);
    $datas = ['titre' => $data['titre'],
    'description' => $data['description'],
    'active' => $data['active'],
	'visible' => $data['visible'],
    'prix' => $data['prix']];
    if($data['id'] != '')
    $result = $this->VoucherModel->updateData('voucher_type', $datas, array('id' => $data['id']));
    else
    $result = $this->VoucherModel->setData('voucher_type', $datas);
    if($result)
    {
      $txt = ($data['id'] != '')?'Mise à jour faite avec succès':'Voucher ajoutée avec succès';
      $class = 'success';
    }
    else
    {
      $txt = ($data['id'] != '')?'Erreur lors de la mise à jour':'Erreur lors de l\'ajout du voucher';
      $class = 'alerte';
    }
    $vue = $this->load->view('/admin/form', $data, TRUE);
    $datas = array(
      'rPop' => $txt,
      'rPopTitle' => $data['titre'],
      'rPopClass' => $class
    );
    echo json_encode($datas);
  }
  public function update_item()
  {
    // Initialisation variable error
    $error = 0;
    $post = $this->input->post('message');
	$data = json_decode($post,TRUE);
    // check id client
    if (empty($data['cl_id']) && $data['creation'] == 0){
      if ( ($result = $this->VoucherModel->getData('client',['email' => $data['email']],'id')) !== FALSE )
      {
        $data['cl_id'] = $result->id;
      }
      else
      {
        $data['creation'] = 1;
      }
    }
    // Traitement formulaire Client
    $data_cl =[
      'civil' => $data['civil'],
      'nom' => $data['nom'],
      'prenom' => $data['prenom'],
      'email' => $data['email'],
      'tel' => $data['tel']
    ];
    // Creation nouveau client
    if ($data['creation'] == 1 )
    {
      if  ( ($cl_id = $this->VoucherModel->setData('client',$data_cl,TRUE)) !== FALSE )
      {
        $txt = 'Client créé avec succés : id => '.$cl_id;
        $class = 'success';
      }
      else {
        $txt ='Erreur lors de la création du client';
        $class = 'alerte';
        $error = 1;
      }
    }
    else
    {
      // Update Client
      $cl_id = $data['cl_id'];
      if ($this->VoucherModel->updateData('client',$data_cl,['id' => $cl_id]) !== FALSE )
      {
        $txt = 'Mise à jour du client faite avec succès<br>';
        $class = 'success';
      }
      else
      {
        $txt = 'Erreur lors de la mise à jour du client<br>';
        $class = 'alerte';
        $error = 1;
      }
    }
    unset($data_cl);
    if ($error == 0){
      if (empty($data['dest_id']) && $data['creation_d'] == 0){
        if ( ($result = $this->VoucherModel->getData('client',['email' => $data['email_d']],'id')) !== FALSE )
        {
          $data['dest_id'] = $result->id;
        }
        else
        {
          $data['creation_d'] = 1;
        }
      }
      // Traitement formulaire destinataire
      $data_dest =[
        'civil' => $data['civil_d'],
        'nom' => $data['nom_d'],
        'prenom' => $data['prenom_d'],
        'email' => $data['email_d'],
        'tel' => $data['tel_d']
      ];
      // Creation nouveau destinataire
      if ($data['creation_d'] == 1)
      {
        if  ( ($dest_id = $this->VoucherModel->setData('client',$data_dest,TRUE)) !== FALSE )
        {
          $txt .= 'Destinataire créé avec succès<br>';
          $class = 'success';
        }
        else {
          $txt .='Erreur lors de la création du destinataire';
          $class = 'alerte';
          $error = 1;
        }
      }
      else
      {
        // Update Destinataire
        $dest_id = $data['dest_id'];
        if ($this->VoucherModel->updateData('client',$data_dest,['id' => $dest_id]) !== FALSE )
        {
          $txt .= 'Mise à jour du destinataire faite avec succès<br>';
          $class = 'success';
        }
        else
        {
          $txt .= 'Erreur lors de la mise à jour dudDestinataire';
          $class = 'alerte';
          $error = 1;
        }
      }
      unset($data_dest);
      if ($error == 0){
        // Update voucher avec les infos
        // Récupération montant voucher
        $req = $this->VoucherModel->getData('voucher_type','id = '.$data['voucher'],'prix');
        $montant = $req->prix;
        // Préparation data à insérer, update
        $data_v = [
          'id_client' => $cl_id,
          'id_dest' => $dest_id,
          'id_type' => $data['voucher'],
          'montant' => $montant,
          'code' => $data['voucher_code'],
          'valide' => $data['valide'],
		  'commentaires' => $data['comment']
        ];
        if ( ! empty($data['voucher_id']))
        {
          if ($this->VoucherModel->updateData('voucher',$data_v,'id = '.$data['voucher_id']) !== FALSE)
          {
            $txt .= 'Mise à jour de la carte cadeau faite avec succès<br>';
            $class = 'success';
          }
          else
          {
            $txt .= 'Erreur lors de la mise à jour de la carte cadeau<br>';
            $class = 'alerte';
            $error = 1;
          }
        }
        else
        {
          if ($v_id = $this->VoucherModel->setData('voucher',$data_v,TRUE) !== FALSE)
          {
            $txt .= 'Carte cadeau créée avec succès<br>';
            $class = 'success';
          }
          else
          {
            $txt .= 'Erreur lors de la création de la carte cadeau<br>';
            $class = 'alerte';
            $error = 1;
          }
        }
      }
    }
    $vue = $this->load->view('/admin/form_item', $data, TRUE);
    $datas = ['rPop' => $txt,
    'rPopTitle' => 'Modification Carte Cadeau',
    'rPopClass' => $class];
    echo json_encode($datas);
  }
  public function update_cgv(){
    if( ! $this->input->is_ajax_request())
    {
      exit('Appel de controlleur Ajax non conforme');
    }
    $post = $this->input->post('message');
	$data = json_decode($post,TRUE);
    switch ($data['id']) {
      case 1:
        $item = 'des CGV';
        break;
      case 2:
        $item = 'du descriptif';
        break;
      default:
        exit('Erreur lors de l\'appel de controlleur');
        break;
    }
    if ($data['txt'] !== '')
    {
      $datas = ['cgv' => $data['txt']];
      $result = $this->VoucherModel->updateData('voucher_cgv',$datas, ['id' => $data['id']]);
    }
    if($result)
    {
      $txt = 'Mise à jour '.$item.' faite avec succès';
      $class = 'success';
    }
    else
    {
      $txt = 'Erreur lors de la mise à jour '.$item;
      $class = 'alerte';
    }
    $vue = $this->load->view('/admin/form_cgv', $data, TRUE);
    $datas = array(
      'rPop' => $txt,
      'rPopTitle' => 'Modification '.$item,
      'rPopClass' => $class
    );
    echo json_encode($datas);
  }
  public function activate()
  {
    $post = $this->input->post('message');
	$data = json_decode($post,TRUE);
    $this->VoucherModel->updateData('voucher',['valide' => $data['active']],['id' => $data['id']]);
    $datas = array(
      'rPop' => $data['txt'],
      'rPopTitle' => $data['titre'],
      'rPopClass' => (isset($data['class']))?$data['class']:''
    );
    echo json_encode($datas);
  }
  public function delete_type()
  {
    $post = $this->input->post('message');
	$data = json_decode($post,TRUE);
    $this->VoucherModel->deleteData('voucher_type', ['id' => $data['id']]);
    $datas = array(
      'rPop' => $data['txt'],
      'rPopTitle' => $data['titre'],
      'rPopClass' => (isset($data['class']))?$data['class']:''
    );
    echo json_encode($datas);
  }
  public function delete_item()
  {
    $post = $this->input->post('message');
	$data = json_decode($post,TRUE);
    $this->VoucherModel->deleteData('voucher', ['id' => $data['id']]);
    $datas = array(
      'rPop' => $data['txt'],
      'rPopTitle' => $data['titre'],
      'rPopClass' => (isset($data['class']))?$data['class']:''
    );
    echo json_encode($datas);
  }
  public function create_pdf_alert()
	{
		$post = $this->input->post('message');
		$data = json_decode($post,TRUE);
		$datas = array(
			'rPop' => $data['txt'],
			'rPopTitle' => $data['titre'],
			'rPopClass' => (isset($data['class']))?$data['class']:''
		);
		echo json_encode($datas);
	}
}
