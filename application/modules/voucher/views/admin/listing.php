<div>
  <ul class="listOnglets">
    <li><a id="voucher_list" class="button btnONG _tab_drop button_active">Lister</a></li>
    <li><a id="voucher_mng" class="button btnONG _tab_drop">Gérer</a></li>
  </ul>
</div>
<div id='bloc_voucher_list' class="_tab_bloc block_admin block_admin_ong mb64 clear">
  <?php include(APPPATH.'modules/voucher/views/admin/liste.php'); ?>
</div>
<div id='bloc_voucher_mng' class="_tab_bloc block_admin block_admin_ong masque2 mb64 clear">
  <?php include(APPPATH.'modules/voucher/views/admin/liste_type.php'); ?>
</div>
