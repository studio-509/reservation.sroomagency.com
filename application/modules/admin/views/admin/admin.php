<?php
$this->load->view('/admin/head');
$this->load->view('/admin/header');
$this->load->view('/admin/header_content');
?>
<div id="admin_content">
  <?php echo $vue;?>
</div>
<?php $this->load->view('/admin/footer');
?>
