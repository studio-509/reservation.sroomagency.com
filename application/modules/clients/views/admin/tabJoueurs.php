
<table id="table_annonces" class="table_list" width="100%" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th class="col01 first _order_title" data-id="id">ID</th>
				<th class="col02 ">Civil</th>
				<th class="col02 _order_title" data-id="prenom">Prénom</th>
				<th class="col02 _order_title" data-id="nom">Nom</th>				
				<th class="col03 _order_title" data-id="email">Email</th>
				<th class="col04 ">ID Réservation</th>
				<th class="col07 last">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i = 0;
			foreach($joueurs as $val){
				$class = ($i%2 == 0)?"even":"odd";
				?>
				<tr class="<?php echo $class; ?>" id="_tr<?=$val->id?>">
					<td class="col01 first"><?=$val->id?></td>
					<td class="col02"><?=$val->civil?></td>
					<td class="col02 _prenom_joueur<?=$val->id?>"><?=$val->prenom?></td>
					<td class="col02 _nom_joueur<?=$val->id?>"><?=$val->nom?></td>
					<td class="col03 _email_joueur<?=$val->id?>"><?=$val->email?></td>
					<td class="col04"><?=$val->id_reservation?></td>
					<td class="col07 last">
						<ul class="list-action">
							<li><a class="btn_actions btn_details _joueur_add_update" data-id="<?=$val->id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-modifier.png" title="Modifier" alt="Update" /></a></li>
							<li><a class="btn_actions btn_details _joueur_delete" data-id="<?=$val->id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-supprimer.png" title="Supprimer" alt="Sup" /></a></li>
							<!--li><a class="btn_actions btn_mdp _client_password" data-id="<?=$val->id?>">Renvoyer mot de passe</a></li-->
						</ul>
					</td>
				</tr>
				<?php $i++; } ?>
			</tbody>
		</table>
		