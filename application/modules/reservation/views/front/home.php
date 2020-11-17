<?php
$this->load->view('/front/head');
$this->load->view('/front/header');
echo '<input type="hidden" id="id_resa_maintien_modif" value=""/><input type="hidden" id="jour_maintien_modif" value=""/><input type="hidden" id="heure_maintien_modif" value=""/><div id="_calendrier">'.$vue.'</div>';
$this->load->view('/front/footer');
?>
