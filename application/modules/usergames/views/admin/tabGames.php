
<table id="table_annonces" class="table_list" width="100%" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th class="col01 first _order_title" data-id="id">ID</th>
				<th class="col02 _order_title" data-id="id_resa">ID Résa</th>
				<th class="col02 _order_title" data-id="id_jour">Jour</th>
				<th class="col02 _order_title" data-id="id_heure">Heure</th>
				<th class="col02 _order_title" data-id="nom_equipe">Nom d'équipe</th>
				<th class="col02 _order_title" data-id="nb_joueurs">NbJ</th>
				<th class="col02 _order_title" data-id="id_salle">Salle</th>
				<th class="col02 _order_title" data-id="tps_jeu">Temps réalisé</th>
				<th class="col02 _order_title" data-id="nb_indices">Indices</th>				
				<th class="col03 _order_title" data-id="rank">Rang</th>
				<th class="col04 ">Infos</th>
				<th class="col07 last">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($salles as $s) {
				$nomsalle[$s->id] = $s->nom;
			}
			$i = 0;
			foreach($games as $val){
				$class = ($i%2 == 0)?"even":"odd";
				$expjour = explode('-',$val->jour);
				$frenchjour = $expjour[2].'/'.$expjour[1].'/'.$expjour[0];
				?>
				<tr class="<?php echo $class; ?>" id="_tr<?=$val->id?>">
					<td class="col01 first"><?=$val->id?></td>
					<td class="col02 _id_resa<?=$val->id?>"><?=$val->id_resa?></td>
					<td class="col02 _jour_resa<?=$val->id?>"><?=$frenchjour?></td>
					<td class="col02 _horaire_resa<?=$val->id?>"><?=$val->horaire?></td>
					<td class="col02 _nom_equipe<?=$val->id?>"><?=$val->nom_equipe?></td>
					<td class="col02 _nb_joueurs<?=$val->id?>"><?=$val->nb_joueurs?></td>
					<td class="col02 _nom_salle<?=$val->id?>"><?=$val->nom_salle?></td>
					<td class="col02 _tps_jeu<?=$val->id?>"><?=$val->tps_jeu?></td>
					<td class="col02 _nb_indices<?=$val->id?>"><?=$val->nb_indices?></td>
					<td class="col03" ><?php echo modules::run('games/admin/Gamesadmin/getRank',$val->id_resa); ?></td>
					<td class="col04"></td>
					<td class="col07 last">
						<ul class="list-action">
							<li><a class="btn_actions btn_details _games_add_update" data-id="<?=$val->id_resa?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-modifier.png" title="Modifier" alt="Update" /></a></li>
							<li><a class="btn_actions btn_details _games_delete" data-id="<?=$val->id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-supprimer.png" title="Supprimer" alt="Sup" /></a></li>
							<!--li><a class="btn_actions btn_mdp _client_password" data-id="<?=$val->id?>">Renvoyer mot de passe</a></li-->
						</ul>
					</td>
				</tr>
				<?php $i++; } ?>
			</tbody>
		</table>
		