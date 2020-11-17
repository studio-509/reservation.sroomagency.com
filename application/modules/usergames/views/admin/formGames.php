<?php 
	$jourresa = new DateTime($game->jour);
	$jourformat = $jourresa->format('d/m/Y');
?>
<form name="form" id='form_admin_client'>
	<fieldset>
		<ul class="list_form">
			<li id="infosresa">				
					Réservation n° <strong><?=$game->idresa?></strong> du <strong><?=$jourformat?></strong> à <strong><?=$game->horaire?></strong> pour le scénario <strong><?=$game->nom_salle?></strong><br>
					effectuée par <strong><?=$game->prenom_client?> <?=$game->nom_client?></strong> (<strong><?=$game->email_client?></strong>)<br><br>						
			</li>
			<li>
				<label>Nom d'équipe :</label>
				<input type="text" name="nom_equipe" id="nom_equipe" value="<?=(isset($game->nom_equipe))?$game->nom_equipe:""?>" />
			</li>
			<li>
				<label>Nombre de joueurs :</label>
				<input size="1" type="text" name="nb_joueurs" id="nb_joueurs" value="<?=(isset($game->nb_joueurs))?$game->nb_joueurs:""?>" />
				&nbsp;&nbsp;<input style="display:inline-block;" type="button" class="load_resa_infos button btn_L btn_annul" value="Charger infos résa" />
			</li>
			<li>
				
				<table>
				<?php $i = 1;
				for($i=1;$i<$game->nbmax+1;$i++) {
					$class = (isset($game->nb_joueurs) && $i<=$game->nb_joueurs)?'':'hidden';
					?>
						<tr id="infos_j<?=$i?>" class="<?=$class?> infos_joueurs">
							<td>
								<input type="hidden" name="id_j<?=$i?>" id="id_j<?=$i?>" value="<?=(isset($infosjoueurs[$i-1]->id))?$infosjoueurs[$i-1]->id:""?>" />
								<label>J<?=$i?></label>
							</td>
							<td>
								<input placeholder="Prénom" size="10" type="text" name="prenom_j<?=$i?>" id="prenom_j<?=$i?>" value="<?=(isset($infosjoueurs[$i-1]->prenom))?$infosjoueurs[$i-1]->prenom:""?>" />
							</td>
							<td>
								<input placeholder="Nom" size="15" type="text" name="nom_j<?=$i?>" id="nom_j<?=$i?>" value="<?=(isset($infosjoueurs[$i-1]->nom))?$infosjoueurs[$i-1]->nom:""?>" />
							</td>
							<td>
								<input placeholder="email" size="20" type="text" name="email_j<?=$i?>" id="email_j<?=$i?>" value="<?=(isset($infosjoueurs[$i-1]->email))?$infosjoueurs[$i-1]->email:""?>" />
							</td>
							<td>
								<input placeholder="C.Post" size="4" type="text" name="postal_j<?=$i?>" id="postal_j<?=$i?>" value="<?=(isset($infosjoueurs[$i-1]->postal) && $infosjoueurs[$i-1]->postal != "00000")?$infosjoueurs[$i-1]->postal:""?>" />
							</td>
							<td>
								<select name="niveau_j<?=$i?>" id="niveau_j<?=$i?>">
									<option value="no" <?=(!isset($game->niveau))?"selected":""?>>--niveau--</option>
									<option value="0" <?=(isset($game->niveau) && $game->niveau == "0")?"selected":""?>>Débutant</option>
									<option value="1" <?=(isset($game->niveau) && $game->niveau == "1")?"selected":""?>>Intermédiaire</option>
									<option value="2" <?=(isset($game->niveau) && $game->niveau == "2")?"selected":""?>>Confirmé</option>
								</select>
							</td>
							<td>
							<select name="vecteur_j<?=$i?>" id="vecteur_j<?=$i?>">
								<option value="no" <?=(!isset($game->vecteur))?"selected":""?>>--vecteur--</option>
								<option value="0" <?=(isset($game->vecteur) && $game->vecteur == "0")?"selected":""?>>Connaisance</option>
								<option value="1" <?=(isset($game->vecteur) && $game->vecteur == "1")?"selected":""?>>Autre escape</option>
								<option value="2" <?=(isset($game->vecteur) && $game->vecteur == "2")?"selected":""?>>Enseigne</option>
								<option value="3" <?=(isset($game->vecteur) && $game->vecteur == "3")?"selected":""?>>Facebook</option>
								<option value="4" <?=(isset($game->vecteur) && $game->vecteur == "4")?"selected":""?>>Trip advisor</option>
								<option value="5" <?=(isset($game->vecteur) && $game->vecteur == "5")?"selected":""?>>Print</option>
								<option value="6" <?=(isset($game->vecteur) && $game->vecteur == "6")?"selected":""?>>Campagne pub</option>
							</select>
							</td>
						</tr>
					<?php
				}
				?>
				</table>
			</li>
			<li>
				<label>Temps réalisé :</label>
				<input  size="6" type="text" name="tps_jeu" id="tps_jeu" value="<?=(isset($game->tps_jeu) && $game->tps_jeu != "00:00:00")?$game->tps_jeu:"n/a"?>" />
				<label>Nb d'indices :</label>
				<input  size="1" type="text" name="nb_indices" id="nb_indices" value="<?=(isset($game->nb_indices))?$game->nb_indices:"n/a"?>" />
				<label> Réussite : </label>
				<input type="checkbox" name="reussite" id="reussite" <?=(isset($game->reussite) && $game->reussite == "1")?"checked":""?> />
			</li>
			<li>
				<label>Lien photo :</label>
				<input style="display:none;" type="file" name="lien_photo_file" id="lien_photo_file" />
				<input style="display:inline-block;" size="40" type="text" disabled="disabled" name="lien_photo" id="lien_photo" value="<?=(isset($game->lien_photo))?$game->lien_photo:""?>" />
				<input style="display:inline-block;" type="button" class="load_photo_file button btn_L btn_annul" value="Choisir une photo" />
			</li>
			<li>
				<label>Publication photo :</label>
				<input type="checkbox" name="pub_photo" id="pub_photo" <?=(isset($game->pub_photo) && $game->pub_photo == "1")?"checked":""?> />
				<label>Envoi photo :</label>
				<input type="checkbox" name="envoi_photo" id="envoi_photo" <?=(isset($game->envoi_photo) && $game->envoi_photo == "1")?"checked":""?> />
				<label>Envoi mail :</label>
				<input type="checkbox" name="envoi_mail" id="envoi_mail" <?=(isset($game->envoi_mail) && $game->envoi_mail == "1")?"checked":""?> />

			</li>
			<li>
				<label>Commentaire :</label>
				<textarea cols="60" placeholder="Commentaire" name="commentaire" id="commentaire"><?=(isset($game->commentaire))?$game->commentaire:""?></textarea>
			</li>
		</ul>
		<input type="hidden" name="resa_id" id="resa_id" value="<?=(isset($game->idresa))?$game->idresa:""?>" />
		<input type="hidden" name="game_id" id="game_id" value="<?=(isset($game->id))?$game->id:""?>" />
		<ul class="list_action">
			<li>
				<input type="button" class="button btn_L btn_annul" value="Annuler" onClick="_inPop.close(this)" />
			</li>
			<li>
				<input class="button btnBlue" type="button" name="submit" id="_submit_games_admin_form" value="Valider" />
			</li>
		</ul>
		<input type="hidden" name="tempsreal" id="tempsreal" value="" />
		<input type="hidden" name="client_prenom" id="client_prenom" value="<?=$game->prenom_client?>" />
		<input type="hidden" name="client_nom" id="client_nom" value="<?=$game->nom_client?>" />
		<input type="hidden" name="client_email" id="client_email" value="<?=$game->email_client?>" />
		<input type="hidden" name="resa_nbjoueurs" id="resa_nbjoueurs" value="<?=$game->resa_nbjoueurs?>" />
		<?php
		$i=0;
		foreach ($resajoueurs as $joueur) {
		?>
			<input type="hidden" class="resa_joueur" name="resa_joueur" id="resa_joueur<?=$i+2?>" data-id="<?=$i+2?>" value="<?=$joueur->email?>" />
		<?php
		$i++;
		}
		?>
	</fieldset>
</form>