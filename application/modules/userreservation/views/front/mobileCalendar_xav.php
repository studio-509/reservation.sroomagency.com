<ul class="listBtn mb16">
	<li>
		<?php if(date('Y-m-d', $prev) >= date('Y-m-d')): ?>
			<input type="button" data-id="<?=$prev?>" data-orig="front" class="_cal_drop_mobile" value="Jour précédent">
		<?php endif; ?>
	</li>
	<li>
    	<input type="button" data-id="<?=$next?>" data-orig="front" class="_cal_drop_mobile" value="Jour suivant">
    </li>
	<li>
    	<input type="button" data-id="<?=$next_week?>" data-orig="front" class="_cal_drop_mobile" value="semaine suivante">
    </li>
	<li>
    	<input type="button" data-id="<?=$next_mounth?>" data-orig="front" class="_cal_drop_mobile" value="mois suivant">
    </li>
</ul>

<div class="block_admin">
	<div class="tableau" id="calendar_table">
		<div class="tr">
			<div class="th">Horaires</div>
			<?php
				$start1 = $start;
			?>
				<div class="th"><?=getFrDay(date('N', $start1))?><br /><?=date('d/m/Y', $start1)?></div>
			<?php
				$start1 += 86400;
			?>
		</div>
		<?php
			$i = START_HOUR;
			while($i <= END_HOUR):
			$start2 = $start;
		?>
		<div class="tr">
			<div class="td"><?=$i?>h00</div>
			<?php
					$libre = 1;
					foreach($resas as $resa):
						if($resa->jour == date('Y-m-d', $start2) && $resa->horaire == $i):
							$libre = 0;
							break;
						endif;
					endforeach;

					if($libre == 0 && $resa->valide == 1):
						echo '<div class="td reserve"><a>Réservé</a></div>';
					elseif($libre == 0 && $resa->valide == 0):
						echo '<div class="td encours"><a>Réservation</a></div>';
					elseif($libre == 1 && (date('Y-m-d', $start2) > date('Y-m-d') || ( date('Y-m-d', $start2) == date('Y-m-d') && $i > $current))):
						echo '<div class="td libre"><a class="_front_resa" data-day="' . date('Y-m-d', $start2) . '" data-hour="' . $i . '">Libre</a></div>';
					elseif($libre == 1 && (date('Y-m-d', $start2) == date('Y-m-d') && $i <= $current)):
							echo '<div class="td libre" style="font-size:12px"><a>Réservation sur place</a></div>';
					else:
						echo '<div class="td passe"><a>cloturé</a></div>';
					endif;

				$start2 += 86400;
			?>
		</div>
	<?php
		$i = $i + GAME_TIME;
		endwhile;
	?>
	</div>
</div>
