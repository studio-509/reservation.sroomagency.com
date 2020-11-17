<form name="form" id="admin_form">
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
                <input type="text" class="_required" name="nom" id="nom" value="<?=(isset($client->nom))?$client->nom:""?>" />
                <div class="error masque2" id="error_nom">Le nom est obligatoire</div>
            </li>
            <li>
                <label>Prénom <span class="obligatoire">*</span> :</label>
                <input type="text" class="_required" name="prenom" id="prenom" value="<?=(isset($client->prenom))?$client->prenom:""?>" />
                <div class="error masque2" id="error_prenom">Le prénom est obligatoire</div>
            </li>
            <li>
                <label>Email <span class="obligatoire">*</span> :</label>
                <input type="text" class="_required" name="email" id="email" value="<?=(isset($client->email))?$client->email:""?>" />
                <div class="error masque2" id="error_email">L'email est obligatoire</div>
            </li>
            <li>
                <label>Login :</label>
                <input type="text" class="_required" name="login" id="login" value="<?=(isset($client->login))?$client->login:""?>" />
                <div class="error masque2" id="error_login">Le login est obligatoire</div>
            </li>
            <li>
                <label>Mot de passe :</label>
                <input type="text" class="_required" name="password" id="password" />
                <input type="hidden" name="old_pass" id="old_pass" value="<?=(isset($client->password))?$client->password:""?>" />
                <div class="txt_infos"> <a id="_form_admin_pass" title="Générer">Générer</a></div>
                <div class="error masque2" id="error_password">Le mot de passe est obligatoire</div>
            </li>
		</ul>
		
		<input type="hidden" name="admin_id" id="admin_id" value="<?=(isset($client->id))?$client->id:""?>" />
		
		<ul class="list_action">
        	<li>
                <input type="button" class="button btn_L btn_annul" value="Annuler" onClick="_inPop.close(this)" />
            </li>
            <li>
                <input class="button btnBlue" type="button" name="submit" id="_submit_admin_form" value="Valider" />
            </li>
        </ul>
	</fieldset>
</form>