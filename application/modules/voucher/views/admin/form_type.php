<form name="form" id="voucher_form">	<fieldset>		<ul class="list_form">			<li>				<label>Titre <span class="obligatoire">*</span> :</label>				<input type="text" class="_required" name="titre" id="titre" value="<?=(isset($voucher_type->titre))?$voucher_type->titre:""?>" />				<div class="error masque2" id="error_titre">Le titre est obligatoire</div>			</li>			<li>				<label>Description <span class="obligatoire">*</span> :</label>				<textarea name="description" id="description"><?=(isset($voucher_type->description))?$voucher_type->description:""?></textarea>				<div class="error masque2" id="error_description">La description est obligatoire</div>			</li>			<li>				<label>Prix<span class="obligatoire">*</span> :</label>				<input type="text" name="_required" name="prix" id="prix" value="<?=(isset($voucher_type->prix))?$voucher_type->prix:""?>">				<div class="error masque2" id="error_prix">Le prix est obligatoire</div>			</li>			<li>				<label>Active :</label>				<input type="radio" name="active" value="0" <?=((isset($voucher_type->active) && $voucher_type->active == 0) || !isset($voucher_type->active))?'checked="checked"':""?>/> NON &nbsp;				<input type="radio" name="active" value="1" <?=(isset($voucher_type->active) && $voucher_type->active == 1)?'checked="checked"':""?>/> OUI			</li>			<li>				<label>Visible :</label>				<input type="radio" name="visible" value="0" <?=((isset($voucher_type->visible) && $voucher_type->visible == 0) || !isset($voucher_type->visible))?'checked="checked"':""?>/> NON &nbsp;				<input type="radio" name="visible" value="1" <?=(isset($voucher_type->visible) && $voucher_type->visible == 1)?'checked="checked"':""?>/> OUI			</li>		</ul>		<input type="hidden" name="voucher_id" id="voucher_id" value="<?=(isset($voucher_type->id))?$voucher_type->id:""?>" />		<ul class="list_action">			<li>				<input type="button" class="button btn_L btn_annul" value="Annuler" onClick="_inPop.close(this)" />			</li>			<li>				<input class="button btnBlue" type="button" name="submit" id="_submit_voucher_admin_form" value="Valider" />			</li>		</ul>	</fieldset></form>