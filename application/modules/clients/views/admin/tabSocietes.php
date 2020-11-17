
<table id="table_annonces" class="table_list" width="100%" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<tr>
				<th class="col01 first _order_title" data-id="id">ID</th>
				<th class="col02 _order_title" data-id="nom">Nom</th>
				<th class="col02 _order_title" data-id="adresse">Adresse</th>
				<th class="col02 _order_title" data-id="tel">Téléphone</th>				
				<th class="col03 _order_title" data-id="email">Email</th>
				<th class="col03 _order_title" data-id="nom_contact">Nom du contact</th>
				<th class="col07 last">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i = 0;
			foreach($societes as $val){
				$class = ($i%2 == 0)?"even":"odd";
				?>
				<tr class="<?php echo $class; ?>" id="_tr<?=$val->id?>">
					<td class="col01 first"><?=$val->id?></td>
					<td class="col02 _nom_societe<?=$val->id?>"><?=$val->nom?></td>
					<td class="col02"><?=$val->adresse.' '.$val->comp_adresse.' '.$val->code_postal.' '.$val->ville?></td>
					<td class="col02"><?=$val->tel?></td>
					<td class="col03"><?=$val->email?></td>
					<td class="col03"><?=$val->nom_contact?></td>
					<td class="col07 last">
						<ul class="list-action">
							<li><a class="btn_actions btn_details _societe_add_update" data-id="<?=$val->id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-modifier.png" title="Modifier" alt="Update" /></a></li>
							<li><a class="btn_actions btn_details _societe_delete" data-id="<?=$val->id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-supprimer.png" title="Supprimer" alt="Sup" /></a></li>
							<!--li><a class="btn_actions btn_mdp _client_password" data-id="<?=$val->id?>">Renvoyer mot de passe</a></li-->
						</ul>
					</td>
				</tr>
				<?php $i++; } ?>
			</tbody>
		</table>
		