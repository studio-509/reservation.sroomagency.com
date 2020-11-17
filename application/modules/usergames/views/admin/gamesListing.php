<a class="btn_actions button pull-right _games_add_update" data-id="<?=($reservation != '')?$reservation[0]->id:''?>">Ajouter une partie jouée</a>
<label>Rechercher une partie : </label>
<input type="text" class="_recherche_games" />
<?php
if(empty($games))
echo (' <div class="alert-message alert-ok"><p>Aucun résultat</p></div>');
else {
	?>
	<div id="tab_games_search">
	
	<?=$vuetab?>
	
		
	</div>

	<?php
}
?>
