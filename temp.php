<?php
public function getNbmax($id = 1){
  $this->output->enable_profiler(TRUE);
  if($this->input->post('id'))
  {
    $id = $this->input->post('id');
  }
  $res = $this->ReservationModel->getData('salle', ['id' => $id], 'nbmax');
  $this->data['nbmax'] = $res->nbmax;
  if($this->is_ajax())
  {
    echo $this->load->view('/front/joueurs', $this->data);
  }
  else
  {
    return $this->load->view('/front/joueurs', $this->data, true);
  }
}

_Ajax.reload('/reservation/' + link + '/' + mobile, 'seljoueurs', id);
