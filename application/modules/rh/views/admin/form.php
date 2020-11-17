<?php
if(empty($t_set['empty_sem']) && empty($t_set['empty_we']) && empty($t_set['empty_spe']) && empty($tarif)){
	if($t_set['salle']->nbmin != $t_set['salle']->nbmax){
		echo "<h2 class='text-center'>La salle \"". $t_set['salle']->nom ."\" accepte de ".$t_set['salle']->nbmin." joueurs".($t_set['salle']->nbmin > 1 ? "spe":"" )." à ".$t_set['salle']->nbmax." joueurs</h2><h2 class='text-center'>Tous les tarifs Réduits, Pleins et Speciaux sont définis pour chaque nombre de joueurs</h2>";
	} else {
		echo "<h2 class='text-center'>La salle \"". $t_set['salle']->nom ."\" accepte ".$t_set['salle']->nbmin." joueurs".($t_set['salle']->nbmin > 1 ? "spe":"" )."</h2><h2 class='text-center'>Tous les tarifs Réduits, Pleins et Speciaux sont définis pour chaque nombre de joueurs</h2>";
	}
} else { ?>
	<form name="form" id="tarif_form">
		<fieldset>
			<ul class="list_form">
				<li>
					<?php if(!empty($tarif)){ ?>
						<h3><?=(( $tarif->type == 'sem' ) ? 'Tarif réduit' : (($tarif->type == 'we') ?'Tarif plein':'Tarif special') )?> pour <?=$tarif->joueurs?> joueurs</h3>
						<?php }
						else { ?>
							<h3>
								<fieldset>
									Type de Tarif :
									<?php
									if(!empty($t_set['empty_sem'])){
										echo '<input type="radio" name="type" value="sem" id="tarif-sem" checked>
										<label for="tarif-sem">Réduit</label>';
									}
									if(!empty($t_set['empty_we'])){
										echo '<input type="radio" name="type" value="we" id="tarif-we" '.(empty($t_set['empty_sem'])?'checked':'').'>
										<label for="tarif-we">Plein</label>';
									}
									if(!empty($t_set['empty_spe'])){
										echo '<input type="radio" name="type" value="spe" id="tarif-spe" '. (empty($t_set['empty_sem']) && empty($t_set['empty_sem']['we'])?'checked':'').'>
										<label for="tarif-spe">Special</label>';
									}?>
								</fieldset>
							</h3>
						</li>
						<li>
							<label for="nb-joueurs">Nb de joueurs</label>
							<?php if(!empty($t_set['empty_sem'])) { ?>
								<select name="empty-sem" id="nb-joueurs">
									<?php
									foreach ($t_set['empty_sem'] as $key) {
										echo '<option value="'.$key.'">'.$key.'</option>';
									}
									?>
								</select>
								<?php } ?>
								<?php if(!empty($t_set['empty_we'])) { ?>
									<select class="<?= ( ! empty($t_set['empty_sem']) ? 'hidden' : '') ?>"  name="empty-we" id="nb-joueurs">
										<?php
										foreach ($t_set['empty_we'] as $key) {
											echo '<option value="'.$key.'">'.$key.'</option>';
										}
										?>
									</select>
									<!-- <div class="error masque2" id="error_tarif">Le tarif est obligatoire</div> -->
									<?php } ?>
									<?php if(!empty($t_set['empty_spe'])) { ?>
										<select class="<?= ((!empty($t_set['empty_sem']) || !empty($t_set['empty_we']) )?'hidden':'') ?>"  name="empty-spe" id="nb-joueurs">
											<?php
											foreach ($t_set['empty_spe'] as $key) {
												echo '<option value="'.$key.'">'.$key.'</option>';
											}
											?>
										</select>
										<!-- <div class="error masque2" id="error_tarif">Le tarif est obligatoire</div> -->
										<?php } ?>
								</li>
								<?php } ?>
								<li>
									<label>Tarif </label>
									<input type="text" class="_required" name="tarif" id="tarif" value="<?=(isset($tarif->prix))?$tarif->prix:""?>" />
									<div class="error masque2" id="error_tarif">Le tarif est obligatoire</div>
								</li>
							</ul>
							<input type="hidden" name="tarif_id" id="tarif_id" value="<?=(isset($tarif->id))?$tarif->id:""?>" />
							<ul class="list_action">
								<li>
									<input type="button" class="button btn_L btn_annul" value="Annuler" onClick="_inPop.close(this)" />
								</li>
								<li>
									<input class="button btnBlue" type="button" name="submit" id="_submit_tarif_admin_form" value="Valider" />
								</li>
							</ul>
						</fieldset>
					</form>
					<?php	} ?>
