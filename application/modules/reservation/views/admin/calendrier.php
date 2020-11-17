<div>
	<div>
		<h2>Scénario</h2>

		<select name="salle" id="salle_admin" data-orig="admin">
			<?php foreach($salles as $salle): ?>
				<option value="<?=$salle->id?>"><?=$salle->nom?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<div>
		<select name="joueurs" id="joueurs">
			<?php for($i = PLAYERS_MIN; $i <= PLAYERS_MAX; $i++): ?>
				<option value="<?=$i?>"><?=$i?></option>
			<?php endfor; ?>
			<option value="99">Tarif groupe</option>
		</select>
	</div>
</div>

<div id="calendar" class="block_admin block_admin_ong">
	<?php echo modules::run('reservation/admin/Reservationadmin/calendar'); ?>
</div>
