<form name="form" id="staff_form">
	<fieldset>
		<ul class="list_form">
			<li>
				<label>Nom <span class="obligatoire">*</span> :</label>
				<input type="text" name="nom" id="nom" class="_required" value="<?=$staffmodifinfos->nom?>">
				<div class="error masque2" id="error_nom">Le nom est obligatoire</div>
			</li>
			<li>
				<label>Prenom <span class="obligatoire">*</span> :</label>
				<input type="text" name="prenom" id="prenom" class="_required" value="<?=$staffmodifinfos->prenom?>">
				<div class="error masque2" id="error_prenom">Le prénom est obligatoire</div>
			</li>
			<li>
				<label>Adresse <span class="obligatoire">*</span> :</label>
				<input type="text" name="adresse" id="adresse" class="_required" value="<?=$staffmodifinfos->adresse?>" size="65">
				<div class="error masque2" id="error_adresse">L'adresse est obligatoire</div>
			</li>
			<li>
				<label>Téléphone <span class="obligatoire">*</span> :</label>
				<input type="text" name="tel" id="tel" class="_required" value="<?=$staffmodifinfos->tel?>">
				<div class="error masque2" id="error_tel">Le numéro de téléphone est obligatoire</div>
			</li>
			<li>
				<label>N° sécurité sociale <span class="obligatoire">*</span> :</label>
				<input type="text" name="secu" id="secu" class="_required" value="<?=$staffmodifinfos->secu?>">
				<div class="error masque2" id="error_secu">Le numéro de sécurité sociale est obligatoire</div>
			</li>
			<li>
				<label>Compétences :</label>
				<textarea name="competences" id="competences" rows="2" cols="63"><?=$staffmodifinfos->competences?></textarea>
				<!--<div class="error masque2" id="error_poste">Le poste est obligatoire</div>-->
			</li>
			<li>
				<label>Mastering :</label>
				<?php
				$gmsalles = explode('|',$staffmodifinfos->gm);
				foreach($salles as $s):
				?>
					<input class="gm_checkbox" type="checkbox" name="gm" value="<?=$s->id?>" <?=(in_array($s->id,$gmsalles))?'checked="checked"':""?>/> <?=$s->nom?>&nbsp;&nbsp;
				<?php
				endforeach;
				?>
			</li>
			<li id="li_prio_master" class="<?=($staffmodifinfos->gm == '')?'hidden':''?>">
				<label>Priorité mastering :</label>
				<?php
				$gmsalles = explode('|',$staffmodifinfos->gm);
				foreach($salles as $s):
				?>
					<input class="gm_prio_radio <?=(in_array($s->id,$gmsalles))?'':"hidden"?>" type="radio" name="gm_prio" value="<?=$s->id?>" <?=($s->id == $staffmodifinfos->gm_prio)?'checked="checked"':""?>/> <span id="nomradiogm<?=$s->id?>" class="<?=(in_array($s->id,$gmsalles))?"":"hidden"?>"><?=$s->nom?>&nbsp;&nbsp;</span>
				<?php
				endforeach;
				?>
			</li>
			<li>
				<label>Reset :</label>
				<?php
				$rstsalles = explode('|',$staffmodifinfos->rst);
				foreach($salles as $s):
				?>
					<input class="rst_checkbox" type="checkbox" name="rst" value="<?=$s->id?>" <?=(in_array($s->id,$rstsalles))?'checked="checked"':""?>/> <?=$s->nom?>&nbsp;&nbsp;
				<?php
				endforeach;
				?>
			</li>
			<li id="li_prio_rst" class="<?=($staffmodifinfos->rst == '')?'hidden':''?>">
				<label>Priorité reset :</label>
				<?php
				$rstsalles = explode('|',$staffmodifinfos->rst);
				foreach($salles as $s):
				?>
					<input class="rst_prio_radio <?=(in_array($s->id,$rstsalles))?'':"hidden"?>" type="radio" name="rst_prio" value="<?=$s->id?>" <?=($s->id == $staffmodifinfos->rst_prio)?'checked="checked"':""?>/> <span id="nomradiorst<?=$s->id?>" class="<?=(in_array($s->id,$rstsalles))?"":"hidden"?>"><?=$s->nom?>&nbsp;&nbsp;</span>
				<?php
				endforeach;
				?>
			</li>
			<li>
				<label>Couleur :</label>
				<input class="colorpicker" type="color" id="color" name="color" value="<?=$staffmodifinfos->color?>"/>
			</li>
		</ul>
		<input type="hidden" name="staff_id" id="staff_id" value="<?=(isset($staffmodifinfos->id))?$staffmodifinfos->id:""?>" />
		<ul class="list_action">
			<li>
				<input type="button" class="button btn_L btn_annul" value="Annuler" onClick="_inPop.close(this)" />
			</li>
			<li>
				<input class="button btnBlue" type="button" name="submit" id="_submit_staff_addmodif_form" value="Valider" />
			</li>
		</ul>
	</fieldset>
</form>