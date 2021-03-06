
<table id="reservation_table" class="table_list" width="100%" border="0" cellspacing="0" cellpadding="0">
  <thead>
    <tr>
      <th class="col01 first">ID</th>
      <th class="col01">Date</th>
      <th class="col02 ">Scénario</th>
      <th class="col02 ">Nom</th>
      <th class="col02 ">Email</th>
      <th class="col02 ">Tel</th>
      <th class="col03 text-center">NbJ</th>
      <th class="col03 ">Tarif</th>
      <th class="col03 ">Code</th>
      <th class="col03 text-center">Etat</th>
	  <th class="col03 ">Inf</th>
      <th class="col03 last">Actions</th>
	  <th class="col01 text-center">Fiche</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $i = 0;
    foreach($reservations as $val){
      if($val->jour < date('Y-m-d') || ($val->jour == date('Y-m-d') && $val->horaire < date('H')))
      {
        $class = 'passe';
        $picto = 'picto-etat-cloture';
		$pictotitle = 'Cloturée';
      }
      elseif($val->regle == 0 && $val->valide == 0)
      {
        $class = 'encours';
        $picto = 'picto-etat-encours';
		$pictotitle = 'En cours';
      }
      elseif($val->regle == 0 && $val->valide == 1)
      {
        $class = 'resa_alerte';
        $picto = '';
      }
      else
      {
        $class = 'libre';
        $picto = 'picto-etat-valide';
		$pictotitle = 'Validée';
      }   
      ?>
      <tr class="<?=$class?>" id="_tr<?=$val->id?>">
        <td class="col01 first"><?=$val->id?></td>
        <td class="col01"><?=dateFr($val->jour)?> <?=$val->horaire?></td>
        <td class="col02"><?=$val->scenario?></td>
        <td class="col02"><?=$val->civil . ' ' . $val->prenom . ' ' . $val->nom?></td>
        <td class="col02"><?=$val->email?></td>
        <td class="col03"><?=$val->tel?></td>
        <td class="col03" align="center"><?=$val->joueurs?></td>
        <td class="col03"><?=number_format($val->prix,2)?> €</td>
		<td class="col02"><?=($val->voucher != '')?$val->voucher:''?></td>
        <td class="col03 text-center"><?php if ($picto !=''):?><img src="<?php echo APP_URL; ?>/assets/img/<?=$picto?>.png" title="<?=$pictotitle?>"/><?php endif;?></td>
        <td class="col03">
			<ul class="list-action">
				<li><?php if ($val->societe !=0):?><a class="btn_actions btn_supp _societe_resa" data-id="<?=$val->societe?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-etat-societe.png" title="Société"/></a><?php endif;?></li>
				<li><?php if ($val->comment != ''):?><a class="btn_actions btn_supp _comment_resa" data-id="<?=$val->id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-infos.png" title="Infos"/></a><?php endif;?></li>
			</ul>
		</td>
		<td class="col03">
		<div class="hidden" id="hidden<?=$val->id?>" data-id="<?=$val->id_salle?>"></div>
          <ul class="list-action">
			<li><a class="btn_actions btn_supp _partie_create" href="<?php echo APP_URL; ?>/admin/games?addgame=1&idresa=<?=$val->id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-creapartie.png" title="Créer une partir jouée" alt="GameCreate" /></a></li>
			<li><a class="btn_actions btn_supp _reservation_update" data-id="<?=$val->id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-modifier.png" title="Modifier" alt="Update" /></a></li>
            <li><a class="btn_actions btn_supp _reservation_delete" data-id="<?=$val->id?>" data-idsalle="<?=$val->id_salle?>" data-scenario="<?=$val->scenario?>" resindis="resa" data-client="<?=$val->civil . ' ' . $val->prenom . ' ' . $val->nom?>" data-date="<?=dateFr($val->jour)?> à <?=$val->horaire?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-supprimer.png" title="Supprimer" alt="Sup" /></a></li>
			<li><a class="btn_actions btn_supp _payment_mode" data-id="<?=$val->id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-paiement-cb.png" title="Paiement CB" alt="CB"/></a></li>
			<?php if($val->regle == 0): ?>
            <li><a class="btn_actions btn_supp _reservation_paid" data-id="<?=$val->id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-reglement-sur-place.png" title="Valider le règlement" alt="Paiement s/place" /></a></li>
			<?php endif; ?>
		  </ul>
        </td>
		<td class="col01 text-center">
			<input type="checkbox" class="_check_fiche" name="_check_fiche" value="<?=$val->id?>">
		</td>
      </tr>
      <?php $i++; } ?>
    </tbody>
  </table>