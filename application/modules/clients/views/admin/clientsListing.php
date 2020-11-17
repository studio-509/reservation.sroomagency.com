<a class="btn_actions button pull-right _client_add_update" data-id="">Ajouter un client</a>

<label>Rechercher un client : </label>
<input type="text" class="_recherche_client" />

<label class="label_results_page">Résultats/page : </label>
<select id="nb_result_page" >
	<option value="50" selected="selected">50</option>
	<option value="100">100</option>
	<option value="200">200</option>
</select>
<?php
if(empty($clients))
echo (' <div class="alert-message alert-ok"><p>Aucun résultat</p></div>');
else {
	?>
	<div id="tab_clients_search">
	
	<?=$vuetab?>
	
		
	</div>

	<?php
}
?>
