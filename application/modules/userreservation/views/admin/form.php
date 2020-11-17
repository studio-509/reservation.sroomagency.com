
<div id="formrow" class="<?=($reservation !='')?'':'hidden'?>">


		<div>
			<form name="form" id="resa_admin_form">
				<div class="row">
					<div class="col-md-3 mt16">
						<div class="block_admin">
						<h2>Informations client</h2>
							<ul class="list_form">
								<li>
									<label>Civilité :</label>
									<select name="civil" id="civil">
										<option value="M" <?=(isset($client) && $client->civil == "M")?"selected":""?>>M</option>
										<option value="Mme" <?=(isset($client) && $client->civil == "Mme")?"selected":""?>>Mme</option>
										<option value="Mlle" <?=(isset($client) && $client->civil == "Mlle")?"selected":""?>>Mlle</option>
									</select>
								</li>
								<li>
									<span class="obligatoire">*</span>
									<input placeholder="Nom" type="text" class="_required" name="nom" id="nom" value="<?=(isset($client))?$client->nom:""?>" />
								</li>
								<li>
									<span class="obligatoire">*</span>
									<input placeholder="Prénom" type="text" class="_required" name="prenom" id="prenom" value="<?=(isset($client))?$client->prenom:""?>" />
								</li>
								<li>
									<span class="obligatoire">*</span>
									<input placeholder="Email" type="text" class="_required _format_email" name="email" id="email" value="<?=(isset($client))?$client->email:""?>" />
								</li>
								<li>
									<span class="obligatoire">*</span>
									<input placeholder="Téléphone" type="text" class="_required" name="tel" id="tel" value="<?=(isset($client))?$client->tel:""?>" />
								</li>
							</ul>
						</div>
					</div>
					<div class="col-md-3 mt16">
						<div class="block_admin">
						<h2>Informations partie</h2>
							<ul class="list_form">
								<li>
									<div id="jour_heure_resa" class="<?=(isset($reservation)&&$reservation !='')?'':'masque2';?>">
											<label>Jour : </label>
											<span id="date_resa">

												<?=dateFr($reservation->jour)?> à <?=$reservation->horaire?>

											</span>
									</div>
								</li>
								<li>
									<div id="sel">
									
									<?php 
										if ($reservation->id_salle !='' && $reservation->joueurs !='') echo modules::run('reservation/admin/Reservationadmin/getNbmax', $reservation->id_salle, $reservation->joueurs);
										else echo modules::run('reservation/admin/Reservationadmin/getNbmax');
									?>
									</div>
								</li>
								<li>
										<input type="hidden" name="jour" id="jour_resa" value="<?=(isset($reservation))?$reservation->jour:$jour?>" />
										<input type="hidden" name="horaire" id="horaire_resa" value="<?=(isset($reservation))?$reservation->horaire:$horaire?>" />
										<input type="hidden" name="id_reservation" id="id_reservation" value="<?=(isset($reservation))?$reservation->id:''?>" />
										<input type="hidden" name="client_id" id="client_id" value="<?=(isset($client->id))?$client->id:""?>" />
								</li>
								<?php for($i = 1; $i <= 5; $i++): ?>

									<li style="<?=($i >= $nbJoueurs)?'display:none':''?>" id="form_joueur<?=$i?>">

										<?php

										if( isset($joueurs[$i-1])):?>

										<input placeholder="e-mail joueur <?=$i + 1?>" type="text" class="_format_email" name="joueur<?=$i?>" id="joueur<?=$i?>" value="<?=$joueurs[$i-1]->email?>" />

										<?php

									else:

										?>

										<input placeholder="e-mail joueur <?=$i + 1?>" type="text" class="_format_email" name="joueur<?=$i?>" id="joueur<?=$i?>" value="" />

									<?php endif; ?>

								</li>

							<?php endfor; ?>
							</ul>
						</div>
					</div>
					<div class="col-md-3 mt16">
						<div class="block_admin">
						<h2>Informations société</h2>
							<ul class="list_form">
								<li>
									<label>Société :</label>
									<input type="radio" name="societe" value="1" <?=($reservation->societe != 0)?'checked="checked"':''?>/> OUI &nbsp;
									<input type="radio" name="societe" value="0" <?=($reservation->societe == 0)?'checked="checked"':''?>/> NON 
									<input type="hidden" name="idsociete" id="id_societe" value="<?=(isset($infos_societe))?$infos_societe->id:''?>" />
								</li>
								
								<div id="infossociete" class="<?=($reservation->societe != 0)?'':'masque2'?>">
									<li>
										<input placeholder="Raison sociale" type="text" name="nom_societe" id="nom_societe" value="<?=(isset($infos_societe))?$infos_societe->nom:""?>" />
									</li>
									<li>
										<input placeholder="Adresse" type="text" name="adresse_societe" id="adresse_societe" value="<?=(isset($infos_societe))?$infos_societe->adresse:""?>" />
									</li>
									<li>
										<input placeholder="Compl. Adresse" type="text" name="comp_adresse_societe" id="comp_adresse_societe" value="<?=(isset($infos_societe))?$infos_societe->comp_adresse:""?>" />
									</li>
									<li>
										<input placeholder="Code Postal" type="text" name="code_postal_societe" id="code_postal_societe" value="<?=(isset($infos_societe))?$infos_societe->code_postal:""?>" />
									</li>
									<li>
										<input placeholder="Ville" type="text" name="ville_societe" id="ville_societe" value="<?=(isset($infos_societe))?$infos_societe->ville:""?>" />
									</li>
									<li>
										<input placeholder="Tel" type="text" name="tel_societe" id="tel_societe" value="<?=(isset($infos_societe))?$infos_societe->tel:""?>" />
									</li>
									<li>
										<input placeholder="e-mail" type="text" name="email_societe" id="email_societe" value="<?=(isset($infos_societe))?$infos_societe->email:""?>" />
									</li>
									<li>
										<input placeholder="Nom contact" type="text" name="nom_contact_societe" id="nom_contact_societe" value="<?=(isset($infos_societe))?$infos_societe->nom_contact:""?>" />
									</li>
									<li>
										<textarea placeholder="Commentaire société" id="comment_societe" name="comment_societe" cols="29" rows="3" ><?=($infos_societe != '')?$infos_societe->comment:''?></textarea>
									</li>
								</div>
							</ul>
						</div>
					</div>
					<div class="col-md-3 mt16">
						<div class="block_admin">
						<h2>Informations paiement</h2>
							<ul class="list_form">
								<li>
									<label>Tarif standard :</label>
									<input type="checkbox" name="tarifstand" id="tarifstand" value="1" <?=(($reservation->tarifstand == 1)||($reservation->tarifstand == "")||(!isset($reservation)))?'checked="checked"':''?> />&nbsp;&nbsp;<input type="text" size="2" name="tarif" id="tarif" value="<?=(isset($reservation))?$reservation->prix:""?>" <?=(($reservation->tarifstand == 0)&&($reservation->tarifstand != "")&&(isset($reservation)))?'':'disabled="disabled"'?> />
								</li>
								<li>
									<input placeholder="carte cadeau / code promo" type="text" name="voucher" id="voucher" value="<?=(isset($reservation))?$reservation->voucher:""?>" />
								</li>
								<li>
									<label>Règlement :</label>
									<input type="radio" name="reglement" value="1" <?=($reservation->regle == 1)?'checked="checked"':''?> /> OUI &nbsp;
									<input type="radio" name="reglement" value="0" <?=($reservation->regle == 0)?'checked="checked"':''?> /> NON
								</li>							
							</ul>
						</div>
					</div>
				</div>
				<div class="block_admin col-md-12 mt16 clearfix">
					<ul class="list_form">
						<li>
							<textarea placeholder="Commentaire" id="comment" name="comment" cols="60" rows="3" ><?=(isset($reservation))?$reservation->comment:""?></textarea>
						</li>
					
						

					</ul>
				</div>
							
					<p><span class="obligatoire">*</span> champs obligatoires</p>

					<!-- <button type="button" name="cancel_resa" class="btn_actions button text-center">Annuler</button> -->

					<div class="error_form masque2">
						<div class="error masque2" id="error_nbjoueurs">Veuillez sélectionner un nombre de joueurs</div>
						<div class="error masque2" id="error_nom">Le nom est obligatoire</div>
						<div class="error masque2" id="error_prenom">Le prénom est obligatoire</div>
						<div class="error masque2" id="error_email">L'email est obligatoire</div>
						<div class="error masque2" id="error_format_email">Format de l'adresse email incorrect</div>
						<div class="error masque2" id="error_tel">Le téléphone est obligatoire</div>
						<div class="error masque2" id="error_login">Le login est obligatoire</div>
						<div class="error masque2" id="error_password">Le mot de passe est obligatoire</div>
						<div class="error masque2" id="error_envoimail">Veuillez sélectionner une option pour l'envoi d'e-mail</div>						
					</div>

					<?php if(isset($reservation)){ ?>
					<ul class="list_action">
						<li>
							<label>Envoi d'e-mail :</label>
							<input id="envoimailoui" type="radio" name="envoimail" value="Oui" /> OUI &nbsp;
							<input id="envoimailnon" type="radio" name="envoimail" value="Non" /> NON
						</li>
					</ul>
					<ul class="list_action">
							<!-- <li>
							<input type="button" class="button btn_L btn_annul" value="Annuler" onClick="_inPop.close(this)" />
							</li> -->
						
						<li><a class="button btn_L btn_annul mt32 _annul_resaindis">Annuler</a></li>
						<li><input class="button btnBlue type="button" name="submit" id="_submit_resa_admin_form" value="Valider" /></li>
					</ul>
					<?php } ?>
			
		</form>
	</div>
</div>

<?php 
if ($reservation !=''):
?>
<script>$('html, body').animate({ scrollTop: $('#formrow').offset().top-60 }, 'fast');</script>
<?php
endif;
?>

