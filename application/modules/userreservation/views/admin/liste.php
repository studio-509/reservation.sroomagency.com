
<div class="row">
	<div class="col-xs-6 col-md-4 pull-right">  <!--col-md-offset-2-->
		<a id="sheet_create" class="btn_actions button btn_annul pull-right" >Imprimer fiche(s) d'aventure</a>
	</div>
	
	<label>Rechercher une réservation : </label>
	<input type="text" id="searchresa">&nbsp;&nbsp;
	<label>du </label>
	<input type="date" id="datesearchstart">&nbsp;&nbsp;
	<label>au </label>
	<input type="date" id="datesearchend">
</div>

			<div id="tab_resa_search">		
			<?= modules::run('userreservation/admin/Userreservationadmin/listingsearch'); ?>
			</div>