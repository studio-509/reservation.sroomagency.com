<form name="form" id='form_admin_client'>
	<fieldset>
		<ul class="list_form">
			<li>
				<label>Civilité :</label>
				<select name="civil" id="civil">
					<option value="M" <?=(isset($client->civil) && $client->civil == "M")?"selected":""?>>M</option>
					<option value="Mme" <?=(isset($client->civil) && $client->civil == "Mme")?"selected":""?>>Mme</option>
					<option value="Mlle" <?=(isset($client->civil) && $client->civil == "Mlle")?"selected":""?>>Mlle</option>
				</select>
			</li>
			<li>
				<label>Nom <span class="obligatoire">*</span> :</label>
				<input class="_required" type="text" name="nom" id="nom" value="<?=(isset($client->nom))?$client->nom:""?>" />
			</li>
			<li>
				<label>Prénom <span class="obligatoire">*</span> :</label>
				<input class="_required" type="text" name="prenom" id="prenom" value="<?=(isset($client->prenom))?$client->prenom:""?>" />
			</li>
			<li>
				<label>Email <span class="obligatoire">*</span> :</label>
				<input class="_required" type="text" name="email" id="email" value="<?=(isset($client->email))?$client->email:""?>" />
			</li>
			<li>
				<label>Téléphone :</label>
				<input  type="text" name="tel" id="tel" value="<?=(isset($client->tel))?$client->tel:""?>" />
			</li>
			<li style="display:none">
				<label>Login :</label>
				<input type="text" name="login" id="login" value="<?=(isset($client->login))?$client->login:""?>" />
			</li>
			<li style="display:none">
				<label>Mot de passe :</label>
				<input type="text" name="password" id="password" />
				<input type="hidden" name="old_pass" id="old_pass" value="<?=(isset($client->password))?$client->password:""?>" /><div class="txt_infos"> <a id="_form_client_pass" title="Générer">Générer</a></div>
			<li>
		</ul>
		<p><span class="obligatoire">*</span> champs obligatoires</p>
		<div class="error_form masque2">
			<div class="error masque2" id="error_nom">Le nom est obligatoire</div>
			<div class="error masque2" id="error_prenom">Le prénom est obligatoire</div>
			<div class="error masque2" id="error_email">L'email est obligatoire</div>
			<div class="error masque2" id="error_format_email">Format de l'adresse email incorrect</div>
			<div class="error masque2" id="error_tel">Le téléphone est obligatoire</div>
		</div>
		<input type="hidden" name="client_id" id="client_id" value="<?=(isset($client->id))?$client->id:""?>" />
		<ul class="list_action">
			<li>
				<input type="button" class="button btn_L btn_annul" value="Annuler" onClick="_inPop.close(this)" />
			</li>
			<li>
				<input class="button btnBlue" type="button" name="submit" id="_submit_client_admin_form" value="Valider" />
			</li>
		</ul>
	</fieldset>
</form>