<a class="btn_actions button pull-right _staff_add_update" data-id="">Ajouter un collaborateur</a>
<?php
if(empty($salles))
	echo (' <div class="alert-message alert-ok"><p>Aucun résultat</p></div>');
/* else {
	if(!empty($empty)){
		if ($emptynb>1) {
			echo (' <div class="alert-message alert-warning"><div class="warning-sign"></div><div>Attention ! Les salles <b>'.$empty.'</b> n\'ont pas d\'horaire de défini. Veuillez en créer.</div></div>');
		}
		else {
			echo (' <div class="alert-message alert-warning"><div class="warning-sign"></div><div>Attention ! La salle <b>'.$empty.'</b> n\'a pas d\'horaire de défini. Veuillez en créer.</div></div>');
		}
	
} */
?>

<table id="table_staff_list" class="table_list" width="100%" border="0" cellspacing="0" cellpadding="0">
	<thead>
	<tr>
		<th class="col01 first">Nom</th>
		<th class="col01">Prénom</th>
		<th class="col01">Coordonnées</th>
		<th class="col01">n°sécu</th>
		<th class="col01">Compétences</th>
		<th class="col01">Mastering</th>
		<th class="col01">Reset</th>
		<th class="col01">Couleur</th>
		<th class="col07 last">Actions</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$i = 0;
	foreach($stafflist as $val){
		$class = ($i%2 == 0)?"even":"odd";
		?>
		<tr class="<?php echo $class; ?>" id="_tr<?=$val->id?>">
			<td class="col01 first"><?=$val->nom?></td>
			<td class="col01"><?=$val->prenom?></td>
			<td class="col01"><?=$val->adresse?><br><?=$val->tel?></td>
			<td class="col01"><?=$val->secu?></td>
			<td class="col01"><?=$val->competences?></td>
			<td class="col01">
				<?php
				if($val->gm !='') :
				$mastering = explode("|",$val->gm);
				foreach($mastering as $master):
					foreach($salles as $s):
						if($master == $s->id):?>
							<?=($master == $val->gm_prio)?'<strong>':''?>
							<?=$s->nom?>
							<?=($master == $val->gm_prio)?'</strong>':''?>	
							<br>
						<?php
						endif;
					endforeach;
				endforeach;
				endif;
				?>
			</td>
			<td class="col01">
				<?php
				if($val->rst !=''):
				$reset = explode("|",$val->rst);
				foreach($reset as $rst):
					foreach($salles as $s):
						if($rst == $s->id):?>
							<?=($rst == $val->rst_prio)?'<strong>':''?>
							<?=$s->nom?>
							<?=($rst == $val->rst_prio)?'</strong>':''?>
							<br>
						<?php
						endif;
					endforeach;
				endforeach;
				endif;
				?>
			</td>
			<td class="col01" style="text-align:center;"><div style="display:inline-block;width:20px;height:20px;background-color:<?=$val->color?>;"></div></td>
			<td class="col07 last">
				<ul class="list-action">
					<li><a class="btn_actions btn_details _staff_add_update" data-id="<?=$val->id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-modifier.png" title="Modifier" alt="Update" /></a></li>
					<li><a class="btn_actions btn_supp _staff_delete" data-id="<?=$val->id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-supprimer.png" title="Supprimer" alt="Sup" /></a></li>
				</ul>
			</td>
		</tr>
		<?php 
		$i++; 
	} ?>
	</tbody>
</table>

