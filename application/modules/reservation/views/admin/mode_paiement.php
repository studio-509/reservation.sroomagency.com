<div id="mode_paiement_tab">
	<table>
		<tr>
			<th>Mode de paiement</th>
			<th>Référence</th>
			<th>Montant</th>
			<th></th>
		</tr>
		<?php 
		foreach ($mode_paiement as $mp) {
		?>
			<tr>
				<td><?=$mp->modep?></td>
				<td><?=$mp->reference?></td>
				<td><?=$mp->montant?></td>
				<td><a class="btn_actions btn_supp _del_paiement" data-id="<?=$mp->id?>"><img src="<?php echo APP_URL; ?>/assets/img/picto-action-supprimer.png" title="Supprimer" alt="Sup" /></a></td>
			</tr>
		<?php
		}
		?>
	</table>
</div>
<span class="button btnBlue _add_mode_paiement">Ajouter un paiement</span>
<form id="add_paiement_form" class="hidden">
	<fieldset>
		<ul class="list_form">
			<li>
				<label>Mode de paiement</label>
				<select name="modep" id="modep">
					<option value="MS">MS</option>
					<option value="MM">MM</option>
					<option value="CQ">CQ</option>
					<option value="VR">VR</option>
					<option value="VR">KC</option>
				</select>
			</li>
			<li>
				<span class="obligatoire">*</span>
				<input class="_required" placeholder="Référence" type="text" name="reference" id="reference" />
			</li>
			<li>
				<span class="obligatoire">*</span>
				<input class="_required" placeholder="Montant" type="text" size="2" name="montant" id="montant" />
			</li>
			<li>
				<input type="button" id="cancel_add_paiement" class="button btn_L btn_annul" value="Annuler" />
			</li>
			<li>
				<input class="button btnBlue" type="button" name="submit" id="add_paiement" value="Valider" data-id="<?=$id?>"/>
			</li>
		</ul>
		<p><span class="obligatoire">*</span> champs obligatoires</p>

		<div class="error_form masque2">
			<div class="error masque2" id="error_reference">La référence est obligatoire</div>
			<div class="error masque2" id="error_montant">Le montant est obligatoire</div>						
		</div>
	</fieldset>
</form>
