<form name="form" id="salle_form">
	<fieldset>
		<ul class="list_form">
			<li>
				<label>Nom <span class="obligatoire">*</span> :</label>
				<input type="text" class="_required" name="nom" id="nom" value="<?=(isset($salle->nom))?$salle->nom:""?>" />
				<div class="error masque2" id="error_nom">Le nom est obligatoire</div>
			</li>
			<li>
				<label>Scenario <span class="obligatoire">*</span> :</label>
				<textarea class="_required" name="scenario" id="scenario" rows="4" cols="60"><?=(isset($salle->description))?$salle->description:""?></textarea>
				<div class="error masque2" id="error_scenario">Le scenario est obligatoire</div>
			</li>
			<li>
				<label>Caractéristiques : </label>
				<textarea name="caract" rows="4" cols="60" id="caract"><?= (isset($salle->caract)?$salle->caract:'')?></textarea>
			</li>
			<li>
				<label>Joueurs Min<span class="obligatoire">*</span> :</label>
				<input type="text" class="_required" name="nbmin" id="nbmin" value="<?=(isset($salle->nbmin))?$salle->nbmin:""?>">
				<div class="error masque2" id="error_nbmin">Le nombre de joueurs min est obligatoire</div>
				<div class="error masque2" id="error_z">Le nombre de joueurs minimum ne peut être égal à 0.</div>
			</li>
			<li>
				<label>Joueurs Max<span class="obligatoire">*</span> :</label>
				<input type="text" class="_required" name="nbmax" id="nbmax" value="<?=(isset($salle->nbmax))?$salle->nbmax:""?>">
				<div class="error masque2" id="error_nbmax">Le nombre de joueurs max est obligatoire</div>
				<div class="error masque2" id="error_joueurs">Le nombre de joueurs max est inférieur au nombre de joueurs min</div>
			</li>
			<li>
				<label>Durée Partie<span class="obligatoire">*</span> <em>(mns)</em>  :</label>
				<input type="text" class="_required" name="duration" id="duration" value="<?=(isset($salle->duration))?$salle->duration:"60"?>" <!--disabled-->><span class="input_unit">mns</span>
				<div class="error masque2" id="error_duration">La durée de partie est obligatoire</div>
			</li>
			<li>
				<label>Active :</label>
				<input type="radio" name="active" value="0" <?=((isset($salle->active) && $salle->active == 0) || !isset($salle->active))?'checked="checked"':""?>/> NON &nbsp;
				<input type="radio" name="active" value="1" <?=(isset($salle->active) && $salle->active == 1)?'checked="checked"':""?>/> OUI
			</li>
		</ul>
		<input type="hidden" name="salle_id" id="salle_id" value="<?=(isset($salle->id))?$salle->id:""?>" />
		<ul class="list_action">
			<li>
				<input type="button" class="button btn_L btn_annul" value="Annuler" onClick="_inPop.close(this)" />
			</li>
			<li>
				<input class="button btnBlue" type="button" name="submit" id="_submit_salle_admin_form" value="Valider" />
			</li>
		</ul>
	</fieldset>
</form>
