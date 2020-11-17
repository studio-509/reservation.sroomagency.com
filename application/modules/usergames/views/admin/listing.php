<div>
	<ul class="listOnglets">
		<li><a id="games_list" class="button btnONG _tab_drop button_active">Parties jouées</a></li>
	</ul>
</div>
<div id='bloc_games_list' class="_tab_bloc block_admin block_admin_ong mb64 clear" >
	<?=$gamesliste?>
</div>
	<?php
	if ($_GET['addgame'] == 1 && $_GET['idresa'] != 0 && $_GET['idresa'] != "") {
	?>
	<script type="text/javascript">
		/**	* affichage formulaire modification client	*/	
		$('body').ready(function() {
			$('html, body').animate({ scrollTop: 0 }, 'fast');
			var idresa = <?=$_GET['idresa']?>;		
			var titre = "Ajout d'une partie jouée";
			var datas = {"titre":titre,"idresa":idresa};
			_inPop.open('/games/admin/Gamesadmin/infos', datas, 'alerte', 'fn_games.update()');
		});
	</script>
	<?php
	}
	?>
<br>
<br><br>