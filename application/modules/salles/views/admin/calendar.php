<ul class="listBtn mb16 mt16">
	<li>
		<?php if(date('Y-m-d', $prev) >= date('Y-m-d', $week)): ?>
			<a data-id="<?=$prev?>" data-orig="admin" class="_cal_drop">Semaine précédente</a>
		<?php endif; ?>
	</li>
	<li>
		<a data-id="<?=$next?>" data-orig="admin" class="_cal_drop">Semaine suivante</a>
	</li>
</ul>
<input type="hidden" name="addIndispo" id="addIndispo" value="<?=($addIndispo?'1':'0')?>" />
<input type="hidden" name="addResa" id="addResa" value="<?=($addResa?'1':'0')?>" />
<div class="block_admin">
	<table id="calendar_table">
		<thead>
			<tr>
				<!--<th>Horaires</th>-->
				<?php
				$start1 = $start;
				
				for($i=1;$i<8;$i++): ?>
				<th><?= getFrDay ($i)?><br /><span <?=(($i==1)?'class="calday toto"':'class="calday"')?> data-day="<?=date('Y-m-d', $start1)?>" <?=($addIndispo?'style="text-decoration:underline;cursor:pointer"':'')?>><?=date('d/m/Y', $start1)?></span></th>
					<?php
					$start1 += 86400;
				endfor;
				?>
			</tr>
		</thead>
		<tbody>
			<?php

			foreach ($horaire as $key => $value) {
				$start2 = $start;
								// echo $key . ' => ' . $value;
				//echo '<tr><td>'.$key.'</td>';
				echo '<tr>';
				for($j=1;$j<8;$j++){
					$libre = 1;
					foreach ($resas as $resa) {
						if($resa->jour == date('Y-m-d', $start2) && $resa->horaire == $key){
							$libre = 0;
							break;
						}
					}
					
					if(date('Y-m-d', $start2) < date('Y-m-d') || ( date('Y-m-d', $start2) == date('Y-m-d') && $key < $current)){
						echo '<td class="passe"></td>';
					}
						
					elseif($value[$j] == 0){
						//echo '<td class="passe">'.$key.'<br>Fermé</td>';
						echo '<td class="horferme"></td>';
					}
					elseif($libre == 0 && $resa->valide == 1 && $resa->id_client != 0){
						//echo '<td class="reserve">'.$key.'<br>Réservé</td>';
						echo '<td class="reserve">'.$key.'</td>';
					}
					elseif ($libre == 0 && $resa->id_client == 0 && $resa->valide == 1) {
						//echo '<td class="passe">'.$key.'<br>Indisponible</td>';
						echo '<td class="horindispo"><a class="_admin_resa" data-day="' . date('Y-m-d', $start2) . '" data-hour="' . $key . '">'.$key.'</a></td>';
					}
					elseif($libre == 0 && $resa->valide == 0) {
						//echo '<td class="encours">'.$key.'<br>Résa en cours</td>';
						echo '<td class="encours">'.$key.'</td>';
					}
					elseif($libre == 1 && (date('Y-m-d', $start2) > date('Y-m-d') || ( date('Y-m-d', $start2) == date('Y-m-d') && $key >= $current))){
						//echo '<td class="libre"><a class="_admin_resa" data-day="' . date('Y-m-d', $start2) . '" data-hour="' . $key . '">'.$key.'<br>Libre</a></td>';
						if($addIndispo || $addResa) {
							echo '<td class="libre"><a class="_admin_resa" data-day="' . date('Y-m-d', $start2) . '" data-hour="' . $key . '">'.$key.'</a></td>';
						}
						else {
							echo '<td class="libresanslien">'.$key.'</td>';
						}
					}
					else{
						//echo '<td class="passe">'.$key.'<br>Cloturé</td>'; //'<td class="passe">Cloturé</td>';
						echo '<td class="passe"></td>';
					}

						$start2 += 86400;
				}
				echo '</tr>';
			}
				?>
					</tbody>
				</table>
				
				

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
	<div class="legendeLeft" id="carreReserve">
	&nbsp;
	</div>
	<div class="legendeLeft texteLegende" id="texteReserve">
		Réservé
	</div>
		<div class="legendeLeft" id="carreHorferme">
	&nbsp;
	</div>
	<div class="legendeLeft texteLegende" id="texteHorferme">
		Fermé
	</div>
	<div class="legendeLeft" id="carreCloture">
	&nbsp;
	</div>
	<div class="legendeLeft texteLegende" id="texteCloture">
		Clôturé
	</div>
</div>
</div>