<a class="btn_actions button pull-right _staff_planning_modif" data-id="<?=($staffselected != '')?$staffselected:1?>">Modifier le planning de <?=$staffselinfos->prenom?> <?=$staffselinfos->nom?></a>
<select id="staff_select">
	<?php
	foreach($stafflist as $staff):
	?>	
		<option value="<?=$staff->id?>" <?=($staffselected == $staff->id)?'selected="selected"':''?>><?=$staff->prenom?> <?=$staff->nom?></option>
	<?php
	endforeach;
	?>
</select>
<?php $days = ['1' => 'Lundi','2' =>'Mardi','3' =>'Mercredi', '4' => 'Jeudi', '5' => 'Vendredi', '6' => 'Samedi', '7' => 'Dimanche']; ?>
<table>
	<thead>
		<th style="border-bottom:solid #BBBBBB 1px;"></th>
		<?php
		$i=1;
		foreach ($days as $d):
		?>
			<th><?=$days[$i]?></th>
			<?php
			$i++;
		endforeach;
		?>
	</thead>
	<tbody>
		<?php
		$staffselected = ($staffselected != '')?$staffselected:1;
		for ($j=0;$j<32;$j++):
		?>
			<tr>
				<td <?=($j%2 == 0)?'style="border-top:solid #BBBBBB 1px;"':''?>><?=($j%2 == 0)?(8+$j/2):''?></td>
				<?php
				$heure = ($j%2 == 0)?(8+$j/2):(7+($j+1)/2);
				$heure = (strlen($heure) == 1)?'0'.$heure:$heure;
				$heure = ($j%2 == 0)?$heure.'h00':$heure.'h30';
				
				foreach ($days as $k => $d):
					$class='style="border:solid #BBBBBB 1px;"';
					foreach ($staffplanning as $sp) {
						if ($sp->id_staff == $staffselected && $sp->jour == $k) {
							if ($heure >= $sp->heure_debut && $heure < $sp->heure_fin) $class='style="background-color:#009922;border:solid #BBBBBB 1px;"';
						}
					}
					if (substr($heuredebut[0],0,1)=='0') $heuredebut[0] = substr($heuredebut[0],1,1);
					if (substr($heurefin[0],0,1)=='0') $heurefin[0] = substr($heurefin[0],1,1);
				?>
					<td <?=$class?>>&nbsp;</td>
					<?php
				endforeach;
				?>
			</tr>
		<?php
		endfor;
		?>
	</tbody>
</table>