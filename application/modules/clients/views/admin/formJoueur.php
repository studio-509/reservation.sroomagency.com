<form name="form" id='form_admin_joueur'>
	<fieldset>
		<ul class="list_form">
			<li>
				<label>Civilité :</label>
				<select name="civil" id="civil">
					<option value="M" <?=(isset($joueur->civil) && $joueur->civil == "M")?"selected":""?>>M</option>
					<option value="Mme" <?=(isset($joueur->civil) && $joueur->civil == "Mme")?"selected":""?>>Mme</option>
					<option value="Mlle" <?=(isset($joueur->civil) && $joueur->civil == "Mlle")?"selected":""?>>Mlle</option>
				</select>
			</li>
			<li>
				<label>Nom :</label>
				<input type="text" name="nom" id="nom" value="<?=(isset($joueur->nom))?$joueur->nom:""?>" />
			</li>
			<li>
				<label>Prénom :</label>
				<input type="text" name="prenom" id="prenom" value="<?=(isset($joueur->prenom))?$joueur->prenom:""?>" />
			</li>
			<li>
				<label>Email <span class="obligatoire">*</span> :</label>
				<input class="_required" type="text" name="email" id="email" value="<?=(isset($joueur->email))?$joueur->email:""?>" />
			</li>
			<li>
				<label>ID Réservation <span class="obligatoire">*</span> :</label>
				<input class="_required" type="text" name="id_resa" id="id_resa" value="<?=(isset($joueur->id_reservation))?$joueur->id_reservation:""?>" />
			</li>
			<li style="display:none">
				<label>Login :</label>
				<input type="text" name="login" id="login" value="<?=(isset($joueur->login))?$joueur->login:""?>" />
			</li>
			<li style="display:none">
				<label>Mot de passe :</label>
				<input type="text" name="password" id="password" />
				<input type="hidden" name="old_pass" id="old_pass" value="<?=(isset($joueur->password))?$joueur->password:""?>" /><div class="txt_infos"> <a id="_form_joueur_pass" title="Générer">Générer</a></div>
			<li>
		</ul>
		<p><span class="obligatoire">*</span> champs obligatoires</p>
		<div class="error_form masque2">
			<div class="error masque2" id="error_email">L'email est obligatoire</div>
			<div class="error masque2" id="error_format_email">Format de l'adresse email incorrect</div>
			<div class="error masque2" id="error_id_resa">L'ID de réservation est obligatoire</div>
		</div>
		<input type="hidden" name="joueur_id" id="joueur_id" value="<?=(isset($joueur->id))?$joueur->id:""?>" />
		<ul class="list_action">
			<li>
				<input type="button" class="button btn_L btn_annul" value="Annuler" onClick="_inPop.close(this)" />
			</li>
			<li>
				<input class="button btnBlue" type="button" name="submit" id="_submit_joueur_admin_form" value="Valider" />
			</li>
		</ul>
	</fieldset>
</form>