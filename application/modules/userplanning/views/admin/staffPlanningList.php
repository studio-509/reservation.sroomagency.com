<a class="btn_actions button pull-right _staff_planning_add_update" data-id="">Ajouter un planning pour <?=$staffselinfos->prenom?> <?=$staffselinfos->nom?></a>
<select id="staff_select">
	<?php
	foreach($stafflist as $staff):
	?>	
		<option value="<?=$staff->id?>" <?=($staffselected == $staff->id)?'selected="selected"':''?>><?=$staff->prenom?> <?=$staff->nom?></option>
	<?php
	endforeach;
	?>
</select>
<br>
<br>
<?php
if(empty($staffplanningset))
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
$days = ['1' => 'Lundi','2' =>'Mardi','3' =>'Mercredi', '4' => 'Jeudi', '5' => 'Vendredi', '6' => 'Samedi', '7' => 'Dimanche'];
?>

<table id="table_staff_list" class="table_list" width="100%" border="0" cellspacing="0" cellpadding="0">
	<thead>
	<tr>
		<th class="col01 first">Type</th>
		<th class="col01">Infos</th>
		<?php
		foreach ($days as $k=>$d):?>
		<th class="col01"><?=$days[$k]?></th>
		<?php
		endforeach;
		?>
		<th class="col07 last">Actions</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$i = 0;
	foreach($staffplanningset as $val){
		$class = ($i%2 == 0)?"even":"odd";
		$jourdebut = new Datetime($val->date);
		$jourdebutformat = $jourdebut->format('d/m/Y');
		$semaineformat = $jourdebut->format('W');
		$anneeformat = $jourdebut->format('Y');
		if ($val->id_staff == $staffselinfos->id):
			switch($val->type) {
				
				case'perm':
				$type = "Permanent";
				$infos = 'A partir du ';
				$infos .= $jourdebutformat.'<br>';
				$infos .= '(semaine '.$semaineformat.')';
				break;
				
				case'recur':
				$type = "Une semaine sur deux";
				$infos = ($val->parite%2 == 0)?'Semaines paires<br>':'Semaines impaires<br>';
				$infos .= 'à partir du ';
				$infos .= $jourdebutformat.'<br>';
				$infos .= '(semaine '.$semaineformat.')';
				break;
				
				case'excep':
				$type = "Ponctuel";
				$infos = "Semaine ".$semaineformat."<br>de l'année ".$anneeformat;
				break;
				
			}
			foreach($days as $k=>$d) $semaine[$k] = '';			
			foreach ($staffplanning as $sp) {
				if ($sp->id_set == $val->id) $semaine[$sp->jour] .= $sp->heure_debut.' '.$sp->heure_fin.'<br>';
			}
				
		?>
		<tr class="<?php echo $class; ?>" id="_tr<?=$val->id?>">
			<td class="col01 first"><?=$type?></td>
			<td class="col01"><?=$infos?></td>
			<?php
			foreach ($days as $k=>$d):?>
				<td class="col01"><?=$semaine[$k]?></td>
			<?php
			endforeach;
			?>
			<td class="col07 last">
				<ul class="list-action">
					<li><a class="btn_actions btn_supp _staff_planning_delete" data-id="<?=$val->id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-supprimer.png" title="Supprimer" alt="Sup" /></a></li>
					<li><a class="btn_actions btn_details _staff_planning_add_update" data-id="<?=$val->id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-modifier.png" title="Modifier" alt="Update" /></a></li>
				</ul>
			</td>
		</tr>
		<?php 
		$i++; 
		endif;
	} ?>
	</tbody>
</table>
