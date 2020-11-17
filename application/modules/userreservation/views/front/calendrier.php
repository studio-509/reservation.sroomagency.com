<div id="selectSalle" class="row">

	<div class="col-xs-12 col-sm-4 col-md-6">
		
		<h3 class="labelResa">1. Sélectionnez votre aventure&nbsp;</h3>

		<select name="salle" id="salle" data-orig="front" data-mobile="0">

				<option value="0" >---</option>

			<?php foreach($salles as $salle):?>

				<option value="<?=$salle->id?>" <?=($salle->id == $scenario)?'selected="selected"':''?>><?=$salle->nom?></option>

			<?php endforeach; ?>

		</select>

			<?php if(!empty($caract)) { ?>

			<!--<h3>Caractéristiques :</h3>-->

			<p><?= nl2br($caract); ?></p>



			<?php } ?>

		<div id="sel">

			<?= modules::run('reservation/Reservation/getNbmax', $scenario, $nbjoueursmaintien); ?>

		</div>

	</div>

</div>
<?php if($scenario !=0): ?>
<div id ="selhoraire">

	<h3 class="labelResa">3. Sélectionnez la date et l'horaire sur le planning ci-dessous</h3>

</div>

<div id="calendar" class="block_admin block_admin_ong mb64">

	<?= modules::run('reservation/Reservation/calendar', $scenario, $idresamaintien); ?>

</div>
<?php endif; ?>



