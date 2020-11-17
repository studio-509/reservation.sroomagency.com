<a class="btn_actions button pull-right _staff_off_add" data-id="<?=($staffselected != '')?$staffselected:1?>">Ajouter un Congès ou une période Off pour <?=$staffselinfos->prenom?> <?=$staffselinfos->nom?></a>
<select id="staff_off_select">
	<?php
	foreach($stafflist as $staff):
	?>	
		<option value="<?=$staff->id?>" <?=($staffselected == $staff->id)?'selected="selected"':''?>><?=$staff->prenom?> <?=$staff->nom?></option>
	<?php
	endforeach;
	?>
</select>

<?php
if(empty($staffoff))
	echo (' <div class="alert-message alert-ok"><p>Aucun résultat</p></div>');
else {
?>

<table id="table_staff_off_period" class="table_list" width="100%" border="0" cellspacing="0" cellpadding="0">
	<thead>
	<tr>
		<th class="col01 first">Date de début</th>
		<th class="col01">Heure de début</th>
		<th class="col01">Date de fin</th>
		<th class="col01">Heure de fin</th>
		<th class="col07 last">Actions</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$i = 0;
	foreach($staffoff as $val){
		$class = ($i%2 == 0)?"even":"odd";
		?>
		<tr class="<?php echo $class; ?>" id="_tr<?=$val->id?>">
			<td class="col01 first"><?=$val->date_debut?></td>
			<td class="col01"><?=$val->heure_debut?></td>
			<td class="col01"><?=$val->date_fin?><br><?=$val->tel?></td>
			<td class="col01"><?=$val->heure_fin?></td>
			<td class="col07 last">
				<ul class="list-action">
					<li><a class="btn_actions btn_supp _staff_off_period_delete" data-id="<?=$val->id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-supprimer.png" title="Supprimer" alt="Sup" /></a></li>
					<li><a class="btn_actions btn_details _staff_off_period_update" data-id="<?=$val->id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-modifier.png" title="Modifier" alt="Update" /></a></li>
				</ul>
			</td>
		</tr>
		<?php 
		$i++; 
	} ?>
	</tbody>
</table>
<?php
}
?>