<div id="content" class="text-center mb32">
	<?=$descriptif->cgv?></div>
	<form name="form" method="post" id="resa_front_voucher_form" action="/voucher/order">
	<fieldset>	
					<div id="content" class="row">
						<div class="mb8 text-center" style="display:inline-block;">
							<span style="font-size:14pt;margin:10px 0;display:inline-block;">Choissisez le type de carte cadeau que vous souhaitez offrir.</span>
							<?php  if( empty($voucher_type) ) {?>
							<p>Aucune carte cadeau disponible en ce moment!</p>
							<?php } else { ?>
							<ul class="list_voucher" style="list-style-type: none;">
								<?php foreach ($voucher_type as $val) { ?>
								<li class="col-sm-4 mb8">
									<input type="radio" class="_required" name="voucher" id="<?=$val->id?>" value="<?=$val->id?>" />
									<label for="<?=$val->id?>"><?=$val->titre?> - <?=$val->prix?> €</label>
									<p style="font-size:11pt;"><?=$val->description?></p>
								</li>
								<?php } ?>
							</ul>
							<?php } ?>
							<div class ="error masque2" id="error_v">
							Vous devez selectionner un type de carte cadeau avant de commander.
							</div>
						</div>
					</div>
<div id="content" class="mb8 mt32">					
	
		<div class="row">			
			<div class="col-xs-12 col-sm-6 mb8">
				<h3><strong>Vos coordonnées</strong></h3>
				<ul class="list_form">
					<li>
						<label>Civilité :</label>
						<select name="civil" id="civil">
							<option value="M" <?=(isset($civil) && $civil == 'M')?'selected="selected"':''?>>M</option>
								<option value="Mme" <?=(isset($civil) && $civil == 'Mme')?'selected="selected"':''?>>Mme</option>
									<option value="Mlle" <?=(isset($civil) && $civil == 'Mlle')?'selected="selected"':''?>>Mlle</option>
									</select>
								</li>
								<li>
									<label>Nom <span class="obligatoire">*</span> :</label>
									<input class="_required" type="text" name="nom" id="nom" value="<?=(isset($nom))?$nom:''?>" />
								</li>
								<li>
									<label>Prénom <span class="obligatoire">*</span> :</label>
									<input class="_required" type="text" name="prenom" id="prenom" value="<?=(isset($prenom))?$prenom:''?>" />
								</li>
								<li>
									<label>Email <span class="obligatoire">*</span> :</label>
									<input class="_required _format_email" type="email" name="email" id="email" value="<?=(isset($email))?$email:''?>" />
								</li>
								<li>
									<label>Téléphone <span class="obligatoire">*</span> :</label>
									<input class="_required" type="text" name="tel" id="tel" value="<?=(isset($tel))?$tel:''?>" />
								</li>
								<li style="display:none">
									<label>Login :</label>
									<input type="text" name="login" id="login" value="<?=(isset($login))?$login:''?>" />
								</li>
								<li style="display:none">
									<label>Mot de passe :</label>
									<input type="text" name="password" id="password" />
									<input type="hidden" name="old_pass" id="old_pass" value="<?=(isset($pass))?$passm:''?>" />
									<div class="txt_infos">
										<a id="_form_client_pass" title="Générer">Générer</a>
									</div>
								</li>
							</ul>
							<p>
								<span class="obligatoire">*</span> champs obligatoires</p>
							<div class="error_form masque2">
								<div class="error masque2" id="error_nom">Le nom est obligatoire</div>
								<div class="error masque2" id="error_prenom">Le prénom est obligatoire</div>
								<div class="error masque2" id="error_email">L'email est obligatoire</div>
								<div class="error masque2" id="error_format_email">Format de l'adresse email incorrect</div>
								<div class="error masque2" id="error_tel">Le téléphone est obligatoire</div>
								<div class="error masque2" id="error_login">Le login est obligatoire</div>
								<div class="error masque2" id="error_password">Le mot de passe est obligatoire</div>
								<div class="error masque2" id="error_voucher">Le montant de la carte cadeau est obligatoire</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 mb8">
							<h3><strong>Coordonnées du destinataire</strong></h3>
							<ul class="list_form">
								<li>
									<label>Civilité :</label>
									<select name="civil_d" id="civil_d">
										<option value="M" selected>M</option>
										<option value="Mme">Mme</option>
										<option value="Mlle">Mlle</option>
									</select>
								</li>
								<li>
									<label>Nom <span class="obligatoire">*</span> :</label>
									<input class="_required" type="text" name="nom_d" id="nom_d" value="<?=(isset($nom_d))?$nom_d:''?>" />
								</li>
								<li>
									<label>Prénom <span class="obligatoire">*</span> :</label>
									<input class="_required" type="text" name="prenom_d" id="prenom_d" value="<?=(isset($prenom_d))?$prenom_d:''?>" />
								</li>
								<li>
									<label>Email :</label>
									<input class="_format_email" type="email" name="email_d" id="email_d" value="<?=(isset($email_d))?$email_d:''?>" />
								</li>
								<li>
									<label>Téléphone :</label>
									<input type="text" name="tel_d" id="tel_d" value="<?=(isset($tel))?$tel:''?>" />
								</li>
							</ul>
							<p>
								<span class="obligatoire">*</span> champs obligatoires</p>
							<div class="error_form masque2">
								<div class="error masque2" id="error_nom_d">Le nom du destinataire est obligatoire</div>
								<div class="error masque2" id="error_prenom_d">Le prénom du destinataire est obligatoire</div>
								<!-- <div class="error masque2" id="error_email_d">L'email du destinataire est obligatoire</div> -->
								<div class="error masque2" id="error_format_email_d">Format de l'adresse email du destinataire incorrect</div>
							</div>
						</div>
					</div>

					<div class="infos-voucher">
						<p>Commandez en ligne pour accédez à la carte cadeau choisie
						<br>Une fois votre commande validée, vous pourrez récupérer la carte cadeau pour l'imprimer ou l'envoyer par e-mail au destinataire
					</div>
					
					<div class="row">
						<div class="col-xs-12 col-sm-12 text-center">
							<input class="button btnValider" type="button" name="submit" id="_submit_voucher_front_form" value="Commander" />
						</div>
					</div>
					</div>
				</fieldset>
				<input type="submit" id="_submit_voucher_go" class="masque">
				</form>
				
				