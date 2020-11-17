<div>
	<ul class="listOnglets">
		<li><a id="resa_liste" class="button btnONG _tab_drop button_active">Liste</a></li>
		<li><a id="resa_cal" class="button btnONG _tab_drop">Disponibilités</a></li>
	</ul>
</div>

<div id="bloc_resa_liste" class="_tab_bloc block_admin block_admin_ong mb64">
	
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
	
</div>
<div id="bloc_resa_cal" class="_tab_bloc masque2 block_admin block_admin_ong mb64" >
	<div class="row">
		<div class="col-xs-6 col-sm-4 col-md-3 mt16">
			<label>Nom de la salle :</label>
				<select name="salle" id="salle-admin">
					<?php foreach($salles as $salleb): ?>
					<option value="<?=$salleb->id?>" <?=($salleb->id == $salle)?'selected="selected"':'' ?>><?=$salleb->nom?></option>
					<?php endforeach; ?>
				</select>
		</div>
	</div>
<div id="calendar">	<?=$calendar?></div>	

<?php  
	//echo $salle_id; 
 ?>
<div id="select_options" class="bloc-select-liste">
	<div id="info_resa" ></div>
</div>




	<!-- <a class="btn_actions button pull-right _cancel_resa">Annuler</a> -->
	
</div>

<input type="hidden" name="id_reservation" id="id_reservation" value="" />
<input type="hidden" name="salle_reservation" id="salle_reservation" value="" />
<input type="hidden" name="joueurs_reservation" id="joueurs_reservation" value="" />


<?php $idsalleflo = $reservation->id_salle; ?>


</div>
</div>
<div id="formOrder" style="display:"></div>
