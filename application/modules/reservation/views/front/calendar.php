<?php if($salle != 0): ?>
			<ul class="listBtn mb16">
	<li class="_bouton_cal_gauche">
		<a data-id="<?=$prev_mounth?>" data-orig="front" class="_cal_drop month">Mois précédent</a>
	</li>
	<li class="_bouton_cal_gauche">
		<?php //if(date('Y-m-d', $prev) >= date('Y-m-d', $week)): ?>
			<a data-id="<?=$prev?>" data-orig="front" class="_cal_drop week">Semaine précédente</a>
		<?php //endif; ?>
	</li>
	<li class="_bouton_cal_droite">
		<a data-id="<?=$next_mounth?>" data-orig="front" class="_cal_drop month">Mois suivant</a>
	</li>
	<li class="_bouton_cal_droite">
		<a data-id="<?=$next?>" data-orig="front" class="_cal_drop week">Semaine suivante</a>
	</li>
</ul>
<input type="hidden" id="maintiendate" value="<?=$start?>">
<div class="block_admin">
	<div class="tableau" id="calendar_table">
		<div class="tr">
			<?php //<div class="th">Horaires</div> ?>
			<?php
			$start1 = $start;
			for($i=1;$i<8;$i++): ?>
			<div class="th"><?= getFrDay ($i)?><br /><?=date('d/m/Y', $start1)?></div>
			<?php
			$start1 += 86400;
		endfor;
		?>
	</div>
	<?php

	foreach ($horaire as $key => $value) {
		$start2 = $start;
		// echo $key . ' => ' . $value;
		echo '<div class="tr">';//<div class="td">'.$key.'</div>';
		for($j=1;$j<8;$j++){
			$libre = 1;
			foreach ($resas as $resa) {
				if($resa->jour == date('Y-m-d', $start2) && $resa->horaire == $key){
					$libre = 0;
					break;
				}
			}
			
			$isindispo = false;
			foreach ($indisps as $ind) {
				if($ind->jour == date('Y-m-d', $start2) && $ind->horaire == $key){
					$libre = 0;
					$isindispo = true;
					break;
				}
			}
			
			
			$allresacount = 0;
			
			$heurecreneau = substr($key,0,2).":".substr($key,3,2);
			$datecreneau = new DateTime(date('Y-m-d', $start2).' '.$heurecreneau);
			$datelimite = new DateTime(date('Y-m-d H:i', time() + (4 * 3600)));
			$interval = $datelimite->diff($datecreneau);
			
			/* foreach ($totalresa as $allresa) {
				if($allresa->jour == date('Y-m-d', $start2) && $allresa->horaire == $key){
					$allresacount++;
				}
			}
			
			$nbresadayexp = explode(',',$nbmaxweek->weekdays);
			if ((date('Y-m-d', $start2) >= $nbmaxperiod->datedebut)&&(date('Y-m-d', $start2) <= $nbmaxperiod->datefin)) {
				$nbmaxresa = $nbmaxperiod->nb_max;
			}
			else if (in_array($j, $nbresadayexp)) {

				$nbmaxresa = $nbmaxweek->nb_max;
			}
			else {
				$nbmaxresa = $nbmaxperma->nb_max;
			} */
			
			$teststaff = modules::run('rh/admin/Rhadmin/freeStaff', $salle, date('Y-m-d', $start2),$key);
			
			if(($jourmaintien == date('Y-m-d', $start2))&&($horairemaintien == $key)&&($sallemaintien == $salle)){
				echo '<div class="td libre" style="border: 2px solid red;"><a class="_front_resa" data-day="' . date('Y-m-d', $start2) . '" data-hour="' . $key . '">'.$key.'</a></div>';
				// echo '<td class="libre"><a class="_admin_resa" data-day="' . date('Y-m-d', $start2) . '" data-hour="' . $key . '">Libre</a></td>';
			}
			elseif($libre == 0 && $resa->valide == 0 && $isindispo == false) {
				echo '<div class="td encours"><a>Résa en cours</a></div>';
			}
			elseif ($libre == 0 && $isindispo == true) {
				echo '<div class="td passe"><a>&nbsp;</a></div>'; //'<div class="td passe"><a>Indisponible</a></div>';
			}
			elseif ($teststaff[$salle] == "0") {
				echo '<div class="td passe"><a>&nbsp;</a></div>'; //'<div class="td passe"><a>Pas de personnel disponible pour gérer ce créneau</a></div>';
			}
			else if($value[$j] == 0){
				echo '<div class="td passe"><a>&nbsp;</a></div>'; //'<div class="td passe"><a>Fermé</a></div>';
			}
			elseif($libre == 0 && $resa->valide == 1 && $resa->id_client != 0){
				echo '<div class="td passe"><a>&nbsp;</a></div>';  //'<div class="td reserve"><a>Réservé</a></div>';
			}
			
			elseif($libre == 1 && (date('Y-m-d', $start2) > date('Y-m-d') || ( date('Y-m-d', $start2) == date('Y-m-d') && ($interval->invert == 0)))){
				echo '<div class="td libre"><a class="_front_resa" data-day="' . date('Y-m-d', $start2) . '" data-hour="' . $key . '">'.$key.'</a></div>';
				// echo '<td class="libre"><a class="_admin_resa" data-day="' . date('Y-m-d', $start2) . '" data-hour="' . $key . '">Libre</a></td>';
			}
			else{
				echo '<div class="td passe"><a>&nbsp;</a></div>'; //'<div class="td passe"><a>cloturé</a></div>';
			}

			$start2 += 86400;
		}
		echo '</div>';
	}
	?>

</div>
</div>
<div id="legende">
	<div class="legendeLeft" id="carreLibre">
	&nbsp;
	</div>
	<div class="legendeLeft texteLegende" id="texteLibre">
		Libre
	</div>
	<div class="legendeLeft" id="carreIndispo">
	&nbsp;
	</div>
	<div class="legendeLeft texteLegende" id="texteIndispo">
		Indisponible
	</div>
	<div class="legendeLeft" id="carreEncours">
	&nbsp;
	</div>
	<div class="legendeLeft texteLegende" id="texteEncours">
		En cours de réservation
	</div>
</div>
<?php endif;?>
