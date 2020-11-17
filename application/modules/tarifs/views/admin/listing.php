
<div>
	<ul class="listOnglets">
		<li><a id="settings_list" class="button btnONG _tab_drop button_active">Tarifs Réduits</a></li>
		<li><a id="tarif_list" class="button btnONG _tab_drop">Tarifs</a></li>
		<li><a id="promo_list" class="button btnONG _tab_drop">Promotions</a></li>
	</ul>
</div>
<div id='bloc_tarif_list' class="_tab_bloc block_admin block_admin_ong mb64 masque2 clear">
<!--	<div class="row"> -->
<!--		<div class="col-xs-6 col-sm-4 col-md-3"/> -->
		<label>Nom de la salle :</label>
		<select name="salle" id="salle-admin">
			<?php foreach($salles as $salle): ?>
				<option value="<?=$salle->id?>"><?=$salle->nom?></option>
			<?php endforeach; ?>
		</select>
<!--	</div> -->
	<a class="btn_actions button pull-right _tarif_add">Créer un nouveau tarif</a>
	<div id="bloc_tarif" class="block_admin clear">
		<?=$liste?>
	</div>
</div>
</div>
<div id='bloc_promo_list' class="_tab_bloc block_admin block_admin_ong masque2 mb64 clear">
	<a class="btn_actions button pull-right _promo_add">Créer une nouvelle promotion</a>
	<div id="bloc_promo" class="block_admin clear">
		<?=$liste_promo?>
	</div>
</div>
<div id='bloc_settings_list' class="_tab_bloc block_admin block_admin_ong mb64 clear">
	
	<?=$liste_tarifs_reduits?>
</div>
