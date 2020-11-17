<form name="form" method="post" id="resa_admin_voucher_form" action="">
	<input type="hidden" name="voucher_id" value="<?=isset($id)?$id:''?>">
	<input type="hidden" name="cl_id" value="<?=isset($voucher['item']->cl_id)?$voucher['item']->cl_id:''?>">
	<input type="hidden" name="dest_id" value="<?=isset($voucher['dest']->id)?$voucher['dest']->id:''?>">
	<fieldset>
		<div class="row">
			<div class="col-xs-12 col-sm-6 mb8">
				<h3>Coordonnées Client :</h3>
				<ul class="list_form">
					<li>
						<label>Civilité :</label>
						<select name="civil" id="civil">
							<option value="M" <?=(isset($voucher['item']->cl_civil) && $voucher['item']->cl_civil == 'M')?'selected="selected"':''?>>M</option>
							<option value="Mme" <?=(isset($voucher['item']->cl_civil) && $voucher['item']->cl_civil == 'Mme')?'selected="selected"':''?>>Mme</option>
							<option value="Mlle" <?=(isset($voucher['item']->cl_civil) && $voucher['item']->cl_civil == 'Mlle')?'selected="selected"':''?>>Mlle</option>
						</select>
					</li>
					<li>
						<label>Nom<span class="obligatoire">*</span> :</label>
						<input class="_required" type="text" name="nom" id="nom" value="<?=(isset($voucher['item']->cl_nom))?$voucher['item']->cl_nom:''?>" />
					</li>
					<li>
						<label>Prénom<span class="obligatoire">*</span> :</label>
						<input class="_required" type="text" name="prenom" id="prenom" value="<?=(isset($voucher['item']->cl_prenom))?$voucher['item']->cl_prenom:''?>" />
					</li>
					<li>
						<label>Email<span class="obligatoire">*</span> :</label>
						<input class="_required _format_email" type="email" name="email" id="email" value="<?=(isset($voucher['item']->cl_email))?$voucher['item']->cl_email:''?>" />
					</li>
					<li>
						<label>Tél.<span class="obligatoire">*</span> :</label>
						<input class="_required" type="text" name="tel" id="tel" value="<?=(isset($voucher['item']->cl_tel))?$voucher['item']->cl_tel:''?>" />
					</li>
					<!--<li>
						Création client ? <input type='checkbox' name='creation' value='crea'>
					</li>-->
				</ul>
				<p><span class="obligatoire">*</span> champs obligatoires</p>
				<div class="error_form masque2">
					<div class="error masque2" id="error_nom">Le nom est obligatoire</div>
					<div class="error masque2" id="error_prenom">Le prénom est obligatoire</div>
					<div class="error masque2" id="error_email">L'email est obligatoire</div>
					<div class="error masque2" id="error_format_email">Format de l'adresse email incorrect</div>
					<div class="error masque2" id="error_tel">Le téléphone est obligatoire</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 mb8">
				<h3>Coordonnées du destinataire:</h3>
				<ul class="list_form">
					<li>
						<label>Civilité :</label>
						<select name="civil_d" id="civil">
							<option value="M" <?=(isset($voucher['dest']->civil) && $voucher['dest']->civil == 'M')?'selected="selected"':''?>>M</option>
							<option value="Mme" <?=(isset($voucher['dest']->civil) && $voucher['dest']->civil == 'Mme')?'selected="selected"':''?>>Mme</option>
							<option value="Mlle" <?=(isset($voucher['dest']->civil) && $voucher['dest']->civil == 'Mlle')?'selected="selected"':''?>>Mlle</option>
						</select>
					</li>
					<li>
						<label>Nom<span class="obligatoire">*</span> :</label>
						<input class="_required" type="text" name="nom_d" id="nom_d" value="<?=(isset($voucher['dest']->nom))?$voucher['dest']->nom:''?>" />
					</li>
					<li>
						<label>Prénom<span class="obligatoire">*</span> :</label>
						<input class="_required" type="text" name="prenom_d" id="prenom_d" value="<?=(isset($voucher['dest']->prenom))?$voucher['dest']->prenom:''?>" />
					</li>
					<li>
						<label>Email :</label>
						<input class="_format_email" type="email" name="email_d" id="email_d" value="<?=(isset($voucher['dest']->email))?$voucher['dest']->email:''?>" />
					</li>
					<li>
						<label>Tél :</label>
						<input type="text" name="tel_d" id="tel_d" value="<?=(isset($voucher['dest']->tel))?$voucher['dest']->tel:''?>" />
					</li>
					<!--<li>
						Création client ? <input type='checkbox' name='creation_d' value='crea'>
					</li>-->
				</ul>
				<p><span class="obligatoire">*</span> champs obligatoires</p>
				<div class="error_form masque2">
					<div class="error masque2" id="error_nom_d">Le nom du destinataire est obligatoire</div>
					<div class="error masque2" id="error_prenom_d">Le prénom du destinataire est obligatoire</div>
					<div class="error masque2" id="error_format_email_d">Format de l'adresse email du destinataire incorrect</div>
				</div>
			</div>
		</div>
		<div class=row>
			<div class="col-xs-12 col-sm-6 mb8">
				<h3>Type de carte cadeau :</h3>
				<?php  if( empty($voucher_type) ) {?>
					<p>Aucune carte cadeau disponible en ce moment!</p>
					<?php } else { ?>
						<ul class="list_voucher">
							<?php foreach ($voucher_type as $val) { ?>
								<li>
									<label><?=$val->titre?> - <?=$val->prix?> €
										<input type="radio" class="_required" name="voucher" id="<?=$val->id?>" value="<?=$val->id?>" <?=(isset($voucher['item']->type_id) && $voucher['item']->type_id ==  $val->id)?'checked':''?>/>
									</label>
								</li>
								<?php } ?>
							</ul>
							<?php } ?>
							<div class ="error masque2" id="error_v">
								Veuillez selectionner un type de voucher avant de continuer.
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 mb8">
							<ul class='list-unstyled'>
								<li>
									<label>Carte Cadeau active</label>
									<input type="radio" name="active" value="0" <?=((isset($voucher['item']->active) && $voucher['item']->active == 0) || !isset($voucher['item']->active))?'checked="checked"':""?>/> NON &nbsp;
									<input type="radio" name="active" value="1" <?=(isset($voucher['item']->active) &&$voucher['item']->active == 1)?'checked="checked"':""?>/> OUI
								</li>
								<li>
									<label>Code Carte Cadeau :</label>
									<input class="_required" type="text" id="voucher_code" name="voucher_code" value="<?=(isset($voucher['item']->voucher_code))?$voucher['item']->voucher_code:''?>">
								</li>
								<div class="error_form masque2">
									<div class="error masque2" id="error_voucher_code">Veuillez générer un code.</div>
								</div>
								<li class='text-center'>
									<button type="button" name="gen_code" id="_gen_code_voucher" class='button'>Génération nouveau code</button>
								</li>
							</ul>
						</div>
					</div>
					<div class="row">
						<ul class="list_form">
							<li>
							<br>
								<label>Commentaire :</label>
								<textarea placeholder="Écrivez un commentaire" id="comment" name="comment" cols="60" rows="3" ><?=(isset($voucher['item']))?$voucher['item']->comment:""?></textarea>
							<br><br>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class=" col-xs-12 col-sm-6 pull-right">
							<input class="button btnValider button_popin" type="button" name="submit" id="_submit_voucher_item_form" value="Valider" />
							<button type="button" name="cancel" class='button btn_annul button_popin' onclick="_inPop.close(this)">Annuler</button>
						</div>
					</div>
				</fieldset>
				<input type="submit" id="_submit_voucher_go" class="masque">
			</form>
