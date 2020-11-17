<a class="btn_actions button pull-right _joueur_add_update" data-id="">Ajouter un joueur</a>
<label>Rechercher un joueur : </label>
<input type="text" class="_recherche_joueur" />
<?php
if(empty($joueurs))
echo (' <div class="alert-message alert-ok"><p>Aucun résultat</p></div>');
else {
	?>
	<div id="tab_joueurs_search">
	
	<?=$vuetab?>
	
		
	</div>

	<?php
}
?>