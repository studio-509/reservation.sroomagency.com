<div class="row">
<div class="col-md-12">
  <a id="voucher_add" class="btn_actions button _voucher_item_add pull-right">Créer Carte Cadeau</a>
</div>

<div class="col-md-8 col-md-offset-2">
    <?php echo $pagination;  ?>
</div>

<div class="col-md-2 mt16 mb16 pull-right">
    <label>Résultats par page</label>
		<select class="_pag_setup" name="">
			<option value="10" <?=($pag == 10)?'selected="selected"':'' ?>>10</option>
			<option value="50" <?=($pag == 50)?'selected="selected"':'' ?>>50</option>
			<option value="100" <?=($pag == 100)?'selected="selected"':'' ?>>100</option>
		</select>
	</label>
</div>

</div>

<table id="table_voucher" class="table table-striped table_list" width="100%" border="0" cellspacing="0" cellpadding="0">

  <thead>

    <tr>

      <th class="col01 first">ID</th>
	  
	  <th class="col01">Code</th>

	  <th class="col01">Type</th>
	  
      <th class="col01">Montant</th>

      <th class="col01">Client</th>
	  
	  <th class="col01">Destinataire</th>
	  
	  <th class="col01">Date d'achat</th>
	  
	  <th class="col01">Validité</th>

      <th class="col01">Active</th>
	  
	  <th class="col01">Commentaire</th>

      <th class="col07 last">Actions</th>

    </tr>

  </thead>

  <tbody>

    <?php foreach ($voucher_list as $val): ?>

      <tr id="_tr<?=$val->voucher_id?>">

        <td class='col01 first'><?=$val->voucher_id?></td>
		
		<td class='col01 _code_voucher<?=$val->voucher_id?>'><?=$val->voucher_code?></td>
		
		<?php
		$typeok =false;		
		foreach ($voucher_type as $val3): 
			
			if ($val3->id == $val->voucher_idtype):
			$typeok = true;			
		?>
			<td class='col01'><?=$val3->titre?></td>
		<?php			
			endif;
			
		endforeach;	
		
		if ($typeok == false):				
		?>
			<td class='col01'></td>
		<?php			
		endif;
		?>
		
        <td class='col01'><?=$val->voucher_montant?></td>

        <td class='col01 _client_voucher<?=$val->voucher_id?>'><?=$val->cl_prenom?> <?=$val->cl_nom?></td>
		
		<?php
		$destok =false;		
		foreach ($voucher_list_dest as $val2): 
			
			if ($val2->id == $val->voucher_iddest):
			$destok = true;			
		?>
			<td class='col01'><?=$val2->prenom?> <?=$val2->nom?></td>
		<?php			
			endif;
			
		endforeach;	
		
		if ($destok == false):				
		?>
			<td class='col01'></td>
		<?php			
		endif;

		$dateachat = new DateTime($val->voucher_date_achat);
		$dateachatformat = $dateachat->format("d/m/Y");
		$anneeachat = $dateachat->format("Y");
		$moisachat = $dateachat->format("n");
		$listemois = array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
		$anneevalide = $anneeachat;
		$moisvalide = $moisachat + $voucher_duree->duree;
		if ($moisvalide > 12) {
			$moisvalide -= 12;
			$anneevalide += 1;
		}
		$moisvalideaffiche = $listemois[$moisvalide-1];
		$validite = "fin ".$moisvalideaffiche." ".$anneevalide;
		?>
		
		<td class='col01 _dateachat_voucher<?=$val->voucher_id?>'><?=$dateachatformat?></td>
		<td class='col01'><?=$validite?></td>
		
        <td class="col01"><?=($val->voucher_val == 1)?'OUI':'NON'?></td>
		
		<td class='col01'><?=$val->voucher_commentaires?></td>

        <td class='col07 last'>

          <ul class="list-action">

            <li><a class="btn_actions btn_details _voucher_item_update" data-id="<?=$val->voucher_id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-modifier.png" title="Modifier" alt="Update" /></a></li>
			<li><a href="<?='/voucher/pdf/'.$val->voucher_code?>" target="_blank"><img id="createpdfimg" data-id="<?=$val->voucher_code?>" src="<?php echo APP_URL; ?>/assets/img/picto-action-pdf.png" title="Créer le PDF" alt="PDF" /></a></li>
            <li><a class="btn_actions btn_supp _voucher_item_delete" data-id="<?=$val->voucher_id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-supprimer.png" title="Supprimer" alt="Sup" /></a></li>
           <!-- <li><a href="<?//='/voucher/pdf/'.$val->voucher_code?>" target="_blank"><img src="<?php// echo APP_URL; ?>/assets/img/picto-action-pdf.png" /></a></li> -->

          </ul>

        </td>

      </tr>

    <?php endforeach; ?>

  </tbody>

</table>

<div class="row">

  <div class="col-md-8 col-md-offset-2">
    <?php echo $pagination;  ?>
  </div>

  <div class="col-md-2 mt16 mb16 pull-right">
    <label>Résultats par page</label>
      <select class="_pag_setup" name="">
        <option value="10" <?=($pag == 10)?'selected="selected"':'' ?>>10</option>
        <option value="50" <?=($pag == 50)?'selected="selected"':'' ?>>50</option>
        <option value="100" <?=($pag == 100)?'selected="selected"':'' ?>>100</option>
      </select>
    </label>
  </div>

</div>

