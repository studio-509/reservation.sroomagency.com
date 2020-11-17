<form name="form" id='form_admin_societe'>
	<fieldset>
		<ul class="list_form">
			<li>
				<label>Nom <span class="obligatoire">*</span> :</label>
				<input class="_required" type="text" name="nom" id="nom" value="<?=(isset($societe->nom))?$societe->nom:""?>" />
			</li>
			<li>
				<label>Adresse <span class="obligatoire">*</span> :</label>
				<input class="_required" type="text" name="adresse" id="adresse" value="<?=(isset($societe->adresse))?$societe->adresse:""?>" />
			</li>
			<li>
				<label>Comp. adresse :</label>
				<input type="text" name="comp_adresse" id="comp_adresse" value="<?=(isset($societe->comp_adresse))?$societe->comp_adresse:""?>" />
			</li>
			<li>
				<label>Code postal <span class="obligatoire">*</span> :</label>
				<input class="_required" type="text" name="code_postal" id="code_postal" value="<?=(isset($societe->code_postal))?$societe->code_postal:""?>" />
			</li>
			<li>
				<label>Ville <span class="obligatoire">*</span> :</label>
				<input class="_required" type="text" name="ville" id="ville" value="<?=(isset($societe->ville))?$societe->ville:""?>" />
			</li>
			<li>
				<label>Téléphone :</label>
				<input  type="text" name="tel" id="tel" value="<?=(isset($societe->tel))?$societe->tel:""?>" />
			</li>
			<li>
				<label>Email <span class="obligatoire">*</span> :</label>
				<input class="_required" type="text" name="email" id="email" value="<?=(isset($societe->email))?$societe->email:""?>" />
			</li>
			<li>
				<label>Nom contact <span class="obligatoire">*</span> :</label>
				<input class="_required" type="text" name="nom_contact" id="nom_contact" value="<?=(isset($societe->nom_contact))?$societe->nom_contact:""?>" />
			</li>
			<li>
				<label>Commentaires :</label>
				<textarea id="comment" name="comment" cols="29" rows="3" ><?=($societe != '')?$societe->comment:''?></textarea>
			</li>
		</ul>
		<p><span class="obligatoire">*</span> champs obligatoires</p>
		<div class="error_form masque2">
			<div class="error masque2" id="error_nom">Le nom est obligatoire</div>
			<div class="error masque2" id="error_adresse">L'adresse est obligatoire</div>
			<div class="error masque2" id="error_code_postal">Le code postal est obligatoire</div>
			<div class="error masque2" id="error_ville">La ville est obligatoire</div>
			<div class="error masque2" id="error_tel">Le téléphone est obligatoire</div>
			<div class="error masque2" id="error_email">L'email est obligatoire</div>
			<div class="error masque2" id="error_format_email">Format de l'adresse email incorrect</div>
			<div class="error masque2" id="error_nom_contact">Le nom du contact est obligatoire</div>
			
		</div>
		<input type="hidden" name="societe_id" id="societe_id" value="<?=(isset($societe->id))?$societe->id:""?>" />
		<ul class="list_action">
			<li>
				<input type="button" class="button btn_L btn_annul" value="Annuler" onClick="_inPop.close(this)" />
			</li>
			<li>
				<input class="button btnBlue" type="button" name="submit" id="_submit_societe_admin_form" value="Valider" />
			</li>
		</ul>
	</fieldset>
</form>