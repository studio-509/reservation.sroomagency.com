<a class="btn_actions button pull-right _societe_add_update" data-id="">Ajouter une société</a>
<label>Rechercher une société : </label>
<input type="text" class="_recherche_societe" />
<?php
if(empty($societes))
echo (' <div class="alert-message alert-ok"><p>Aucun résultat</p></div>');
else {
	?>
	<div id="tab_societes_search">
	
	<?=$vuetab?>
	
		
	</div>

	<?php
}
?>