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
		<th class="col01">Semaine</th>
		<?php
		foreach ($days as $k=>$d):?>
		<th class="col01"><?=$days[$k]?></th>
		<?php
		endforeach;
		?>
		<th class="col01">Heures/sem</th>
		<th class="col07 last">Actions</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$i = 0;
	foreach($staffplanningset as $val){
		$week = $weekshours[$i];
		$exphour = explode(":",$week->somme);
		$hourtosec = $exphour[0] * 3600;
		$mintosec = $exphour[1] * 60;
		
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
				break;
				
				case'recur':
				$type = "Alterné";
				$infos = ($val->parite%2 == 0)?'S.Paires ':'S.Impaires ';
				$infos .= 'début : ';
				$infos .= $jourdebutformat.'<br>';
				break;
				
				case'excep':
				$type = "Ponctuel";
				$infos = "Année ".$anneeformat;
				break;
				
			}
			foreach($days as $k=>$d) $semaine[$k] = '';			
			foreach ($staffplanning as $sp) {
				if ($sp->id_set == $val->id) $semaine[$sp->jour] .= $sp->heure_debut.'-'.$sp->heure_fin.'<br>';
			}
				
		?>
		<tr class="<?php echo $class; ?>" id="_tr<?=$val->id?>">
			<td class="col01 first"><?=$type?></td>
			<td class="col01"><?=$infos?></td>
			<td class="col01"><?=$semaineformat?></td>
			<?php
			foreach ($days as $k=>$d):?>
				<td class="col01"><?=$semaine[$k]?></td>
			<?php
			endforeach;
			?>
			<td class="col01"><?=$exphour[0]?>h<?=$exphour[1]?></td>
			<td class="col07 last">
				<ul class="list-action">
					<li><a class="btn_actions btn_details _staff_planning_add_update" data-id="<?=$val->id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-modifier.png" title="Modifier" alt="Update" /></a></li>
					<li><a class="btn_actions btn_supp _staff_planning_delete" data-id="<?=$val->id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-supprimer.png" title="Supprimer" alt="Sup" /></a></li>
				</ul>
			</td>
		</tr>
		<?php 
		$i++; 
		endif;
	} 
	$class = ($i%2 == 0)?"even":"odd";
	$totalsec = 0;
	$nbweeks = 0;
	 foreach ($weekshours as $week) {
		 $nbweeks++;
		 $exphour = explode(":",$week->somme);
		 $hourtosec = $exphour[0] * 3600;
		 $mintosec = $exphour[1] * 60;
		 $secresult = $hourtosec + $mintosec;
		 $totalsec += $secresult;
	 }
	 $avgsec = $totalsec / $nbweeks;
	 ?>
	 <tr class="<?php echo $class; ?>" id="moyenne_h_sem">
		<td class="col01 first"><strong>MOYENNE</strong></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td class="col01"><?=intval($avgsec / 3600)?>h<?=(intval(($avgsec%3600)/60) < 10)?"0".intval(($avgsec%3600)/60):intval(($avgsec%3600)/60)?></td>
		<td></td>
	 
	 </tr>
	 <tr class="<?php echo $class; ?>" id="total_heures">
		<td class="col01 first"><strong>TOTAL HEURES<br>jusque sem 52</strong></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td class="col01"><?=intval($totalsec/3600)?></td>
		<td></td>
	 
	 </tr>
	</tbody>
</table>

	
		

