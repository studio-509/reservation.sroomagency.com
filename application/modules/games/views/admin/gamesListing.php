<label>Rechercher une partie : </label>
<input type="text" class="_recherche_games" />
<label>du </label>
<input type="date" id="datesearchstart">&nbsp;&nbsp;
<label>au </label>
<input type="date" id="datesearchend"><br><br>
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

