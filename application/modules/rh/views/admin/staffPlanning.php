<?php $days = ['1' => 'Lundi','2' =>'Mardi','3' =>'Mercredi', '4' => 'Jeudi', '5' => 'Vendredi', '6' => 'Samedi', '7' => 'Dimanche']; ?>
<table>
	<thead>
		<tr>
		<?php
			foreach ($days as $k => $d):
				$class='';
				for ($j=0;$j<32;$j++):
					$heure = ($j%2 == 0)?(8+$j/2):(7+($j+1)/2);
					$heure = (strlen($heure) == 1)?'0'.$heure:$heure;
					$heure = ($j%2 == 0)?$heure.'h00':$heure.'h30';
					
					foreach ($staffplanning as $sp) {
						if ($sp->jour == $k) {
							if ($heure >= $sp->heure_debut && $heure < $sp->heure_fin) $class='_reset_planning_day';
						}
					}
				endfor;?>
				<th data-id="<?=$k?>" class="_titre_col_plan <?=$class?>"><?=$days[$k]?></th>					
			<?php
			endforeach;
			?>
		</tr>
	</thead>
	<tbody>
		<?php
		for ($j=0;$j<32;$j++):
		?>
			<tr style="height:13px;">
				<?php
				$heure = ($j%2 == 0)?(8+$j/2):(7+($j+1)/2);
				$heure = (strlen($heure) == 1)?'0'.$heure:$heure;
				$heure = ($j%2 == 0)?$heure.'h00':$heure.'h30';
				
				foreach ($days as $k => $d):
					$class='hour_button_none';
					foreach ($staffplanning as $sp) {
						if ($sp->jour == $k) {
							if ($sp->heure_fin == "00h00") $sp->heure_fin = "23h59";
							if ($heure >= $sp->heure_debut && $heure < $sp->heure_fin) $class='hour_button_active';
							
						}
					}
					if (substr($heuredebut[0],0,1)=='0') $heuredebut[0] = substr($heuredebut[0],1,1);
					if (substr($heurefin[0],0,1)=='0') $heurefin[0] = substr($heurefin[0],1,1);
				?>
					<td data-id="<?=$k.'|'.$j?>" class="_planning_hour_button hour_button <?=$class?>"><?=$heure?></td>
					<?php
				endforeach;
				?>
			</tr>
		<?php
		endfor;
		?>
	</tbody>
</table>
<br>
<span id="error_difdays" class="error masque2">Le début et la fin de la plage horaire doivent apartenir au même jour.</span>
<span id="error_startafterend" class="error masque2">La fin de la plage horaire doit être égale ou postérieure au début.</span>
<form name="form" id="staff_planning_set_form">
	<fieldset>
		<ul class="list_form">
			<li>
				<label>Type :</label>
				<select id="staff_planning_type_select">
					<option value="perm" <?=($staffplanset->type == 'perm')?'selected="selected"':''?>>Permanent</option>
					<option value="recur" <?=($staffplanset->type == 'recur')?'selected="selected"':''?>>Une semaine sur deux</option>
					<option value="excep" <?=($staffplanset->type == 'excep')?'selected="selected"':''?>>Ponctuel</option>
				</select>
				<div class="error masque2" id="error_type_date">Un planning du même type et commençant à la même date a déjà été créé pour ce collaborateur.</div>
			</li>
			<li id="selectparite" class="<?=($staffplanset->type == 'recur')?'':'hidden'?>">
				<label>Semaines :</label>
				<input type="radio" name="parite" id="paritepaire" value="0" <?=($staffplanset->parite == 0||!isset($staffplanset->parite))?'checked="checked"':''?>> paires
				<input type="radio" name="parite" id="pariteimpaire" value="1"<?=($staffplanset->parite == 1)?'checked="checked"':''?>> impaires
			<?php
				if ($staffplanset->date != '0000-00-00') {
					$plandate = new Datetime($staffplanset->date);
					$planweek = $plandate->format('W');
				}
			?>
			</li>
			<li>
				<label>Semaine/Début :</label>
				<input type="date" name="date" step="7" min="2015-01-05" id="dateplanning" class="_required" value="<?=$staffplanset->date?>"><span> Semaine <strong id="numberofweek"><?=$planweek?></strong></span>
			</li>
		</ul>
		<input type="hidden" name="planningset_id" id="planningset_id" value="<?=(isset($staffplanset->id))?$staffplanset->id:""?>" />
		<input type="hidden" name="planningstaff_id" id="planningstaff_id" value="<?=(isset($staffselected))?$staffselected:""?>" />
		<ul class="list_action">
			<li>
				<input type="button" class="button btn_L btn_annul" value="Annuler" onClick="_inPop.close(this)" />
			</li>
			<li>
				<input class="button btnBlue" type="button" name="submit" id="_submit_planningset_addmodif_form" value="Valider" />
			</li>
		</ul>
	</fieldset>
</form>