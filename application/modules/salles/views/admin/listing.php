<div>
	<ul class="listOnglets">
		<li><a id="salles_list" class="button btnONG _tab_drop <?=($onglet=='nb_max_resa')?'':'button_active'?>">Liste des salles</a></li>
		<li><a id="resa_cal" class="button btnONG _tab_drop _add_indispo <?=($onglet=='nb_max_resa')?'button_active':''?>">Création Indispos</a></li>
		<li><a id="indispos_list" class="button btnONG _tab_drop <?=($onglet=='nb_max_resa')?'button_active':''?>">Suppression Indispos</a></li>
	</ul>
</div>
		<div id="bloc_salles_list" class="_tab_bloc block_admin block_admin_ong mb64 clear <?=($onglet=='nb_max_resa')?'hidden':''?>">
		<?php// var_dump($empty); ?>
		<a class="btn_actions button pull-right _salle_add" data-id="">Ajouter une nouvelle salle</a>
		<?php
    	if(empty($salles))
			echo (' <div class="alert-message alert-ok"><p>Aucun résultat</p></div>');
		else {
			if(!empty($empty)){
				if ($emptynb>1) {
					echo (' <div class="alert-message alert-warning"><div class="warning-sign"></div><div>Attention ! Les salles <b>'.$empty.'</b> n\'ont pas d\'horaire de défini. Veuillez en créer.</div></div>');
				}
				else {
					echo (' <div class="alert-message alert-warning"><div class="warning-sign"></div><div>Attention ! La salle <b>'.$empty.'</b> n\'a pas d\'horaire de défini. Veuillez en créer.</div></div>');
				}

		}
		?>

    	<table id="table_annonces" class="table_list" width="100%" border="0" cellspacing="0" cellpadding="0">
        	<thead>
            <tr>
            	<th class="col01 first">Nom</th>
            	<th class="col01">Active</th>
				<th class="col01">Joueurs Min</th>
				<th class="col01">Joueurs Max</th>
            	<th class="col01">URL directe</th>
            	<th class="col07 last">Actions</th>
             </tr>
             </thead>
             <tbody>
			 <?php
				$i = 0;
				foreach($salles as $val){
					$class = ($i%2 == 0)?"even":"odd";
				 ?>
				 <tr class="<?php echo $class; ?>" id="_tr<?=$val->id?>">
                     <td class="col01 first"><?=$val->nom?></td>
                     <td class="col01"><?=($val->active == 1)?'OUI':'NON'?></td>
					<td class="col01"><?=$val->nbmin?></td>
					<td class="col01"><?=$val->nbmax?></td>
                     <td class="col01"><?=APP_URL . '/reservation/' . $val->slug?></td>
					 <td class="col07 last">
						<ul class="list-action">
							<li><a class="btn_actions btn_details _salle_horaires" data-id="<?=$val->id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-horaires.png" title="Horaires" alt="Time" /></a></li>
							<li><a class="btn_actions btn_details _salle_update" data-id="<?=$val->id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-modifier.png" title="Modifier" alt="Update" /></a></li>
							<li><a class="btn_actions btn_supp _salle_delete" data-id="<?=$val->id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-supprimer.png" title="Supprimer" alt="Sup" /></a></li>
						</ul>
					 </td>
				  </tr>
			  <?php $i++; } ?>
              </tbody>
        </table>
        </div>
		<div id="bloc_resa_cal" class="_tab_bloc hidden block_admin block_admin_ong mb64" >
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
		<div id="bloc_indispos_list" class="_tab_bloc hidden block_admin block_admin_ong mb64" >
			<?php if(empty($indisponibilites)) echo (' <div class="alert-message alert-ok"><p>Aucun résultat</p></div>');
			else include APPPATH.'modules/salles/views/admin/liste_indispo.php' ?>
		</div>

		<input type="hidden" name="id_reservation" id="id_reservation" value="" />
		<input type="hidden" name="salle_reservation" id="salle_reservation" value="" />
		<input type="hidden" name="joueurs_reservation" id="joueurs_reservation" value="" />


		<?php $idsalleflo = $reservation->id_salle; ?>


		</div>
		</div>
		<div id="formOrder" style="display:"></div>

        <?php } ?>

		<script type="text/javascript">

            $(function(){

                $('#date_start').datepicker($.datepicker.regional[ "fr" ]);

                $('#date_end').datepicker($.datepicker.regional[ "fr" ]);

            });

            </script>
