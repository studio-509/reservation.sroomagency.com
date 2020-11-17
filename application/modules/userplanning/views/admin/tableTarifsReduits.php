<h3><strong>Plages de tarif réduit</strong></h3>
		<?php
		$nbplages = count($startday);
		for ($i=0;$i<$nbplages;$i++):
		?>
			<div data-id="<?=$i?>" class="settings">
				<div class="">Du <span id="startday"><?=$days[$startday[$i]]?></span> <span id="starthour"><?=$starthour[$i]?></span> Au <span id="endday"><?=$days[$endday[$i]]?></span> <span id="endhour"><?=$endhour[$i]?></span>&nbsp;
					<a data-id="<?=$i?>" class="btn_actions btn_details _settings_update"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-modifier.png" title="Modifier" alt="Update" /></a>
					<a class="btn_actions btn_details _setting_delete" data-id="<?=$tseid[$i]?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-supprimer.png" title="Supprimer" alt="Sup" /></a>
				</div>
			</div>
			<div data-id="<?=$i?>" class="hidden settings_form">
			<form id="tarifs_settings" style ="display:inline !important;">
				Du
				<select class="" name="start-day">
					<?php foreach ($days as $key => $value): ?>
						<option value="<?=$key?>" <?=( $key == $startday[$i] ? 'selected':'' )?>><?=$value?></option>
					<?php endforeach; ?>
				</select>
				<input class="_required" size="4" type="text" name="start-hour" value="<?=$starthour[$i]?>">
				Au
				<select class="" name="end-day">
					<?php foreach ($days as $key => $value): ?>
						<option value="<?=$key?>" <?=( $key == $endday[$i] ? 'selected':'' )?>><?=$value?></option>
					<?php endforeach; ?>
				</select>
				<input class="_required" size="4" type="text" name="end-hour" value="<?=$endhour[$i]?>">
				<input type="hidden" name="tseid" data-id="<?=$i?>" value="<?=$tseid[$i]?>">
			</form>
			<a data-id="<?=$i?>" style ="display:inline !important;" class="btn_actions btn_details _settings_validate hidden">Valider</a>
			<a data-id="<?=$i?>" style ="display:inline !important;" class="btn_actions btn_details _settings_cancel hidden">Annuler</a>
			</div>
		<?php
		endfor;
		?>

	<br />
	<div id="bloc_crea_plage_tarif_reduit" class="block_admin clear">
		<h3><strong>Créer une nouvelle plage de tarif réduit</strong></h3>
		<div data-id="new" id="settings_crea_form" class="settings_form">
		<form id="tarifs_settings_crea" style ="display:inline !important;">
			Du
			<select class="" name="start-day">
				<?php foreach ($days as $key => $value): ?>
					<option value="<?=$key?>"><?=$value?></option>
				<?php endforeach; ?>
			</select>
			<input class="_required" size="4" type="text" name="start-hour" value="<?=$starthour[$i]?>">
			Au
			<select class="" name="end-day">
				<?php foreach ($days as $key => $value): ?>
					<option value="<?=$key?>"><?=$value?></option>
				<?php endforeach; ?>
			</select>
			<input class="_required" size="4" type="text" name="end-hour" value="<?=$endhour[$i]?>">
			<input type="hidden" name="tseid" data-id="new" value="new">
		</form>
		<a data-id="new" style ="display:inline !important;" class="btn_actions btn_details _settings_validate">Créer</a>
		</div>

	</div>