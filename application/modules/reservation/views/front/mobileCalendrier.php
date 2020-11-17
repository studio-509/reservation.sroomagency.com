<div><p style="text-align:center;">Cloture des réservations 4 heures avant.<br>Pour une réservation de dernière minute ou toute autre question sur votre réservation, appelez nous au <br><?php echo SRA_TEL; ?>.<br><br></div>

<div style="text-align:center;color:red">
	<?php if($this->session->flashdata('toLate')): ?>
	   <b><?=$this->session->flashdata('toLate')?></b>
	<?php endif; ?>
	<?php if($this->session->flashdata('supprimer')): ?>
	   <b><?=$this->session->flashdata('supprimer')?></b>
	<?php endif; ?>
</div>
<div id="calendar" class="">

	<form name="form1" method="post" action="/reservation/mobileAdd">
	<input id="maintiendate" type="hidden" value="<?= $start?>" >
	<div id="selectSalle" class="blockMobile mb32">
        <h3 class="labelResaMobile">1. Sélectionnez votre aventure</h3>
        <select name="salle" id="salle_mobile" data-orig="front" data-mobile="1">
				<option value="" <?=($scenario == '')?'selected="selected"':''?>>---</option>
            <?php foreach($salles as $salle): ?>
                <option value="<?=$salle->id?>" <?=($salle->id == $scenario)?'selected="selected"':''?>><?=$salle->nom?></option>
            <?php endforeach; ?>
        </select>
		<div class="caractmobile">
			<p><?=$current_salle->caract?></p>
		</div>
		<div class="error masque2" id="error_scenario">Veuillez sélectionner une aventure</div>
	</div>
	<div id="selectNbjoueurs" class="blockMobile mb32 <?=($scenario != '')?'':'hidden'?>">
        <h3 class="labelResaMobile">2. Sélectionnez le nombre de joueurs</h3>
        <select name="joueurs" id="joueursMobile">
				<option value="" <?=(($scenario == '')||($scenario<$current_salle->nbmin)||($scenario>$current_salle->nbmax))?'selected="selected"':''?>>---</option>
            <?php 
			$testnbjoueurs = 0;
			for($i = $current_salle->nbmin; $i <= $current_salle->nbmax; $i++): 
				if ($i == $nb_joueurs) $testnbjoueurs = 1;?>
                <option value="<?=$i?>" <?=(($i == $nb_joueurs)&&($scenario != ''))?'selected="selected"':''?>><?=$i?></option>
            <?php endfor; 
			$thisDay = date('Y-m-d', $start);
			?>
        </select>
		<div class="error masque2" id="error_nbjoueurs">Veuillez sélectionner un nombre de joueurs</div>
		<div class="error <?=(($nb_joueurs != '')&&($testnbjoueurs == 0))?'':'masque2'?>" id="error_nbjoueurstest">Le nombre de joueurs sélectionné précédemment n'est pas disponible pour cette aventure. Veuillez sélectionner un autre nombre de joueurs</div>
    </div>
	<?php if ($scenario !='') :?>
	<div id="selectDate" class="blockMobile mb32">
	<h3 class="labelResaMobile">3. Sélectionnez la date</h3>
	<input type="date" id="dateCalendarMobile" value="<?=($start !='')?$thisDay:''?>">
	<div class="error masque2" id="error_date">Veuillez sélectionner une date</div>
	</div>
	<?php 
	endif;
	if (($start !='')&&($scenario !='')): 
	
	?>
	<div id="selectHoraire" class="blockMobile mb32">
		<?php $nodispo= 0; ?>
		
		<h3 class="labelResaMobile" id="titreSelectHoraire"></h3>
		<p><strong>Disponibilités du <?=getFrDay(date('N', $start))?>&nbsp;<?=date('d/m/Y', $start)?></strong></p>
		<ul class="listHeureResa">
			<?php
			
			foreach ($horaire as $key => $value) {
				$libre = 1;
				
				$j = strftime ('%u',$start);
				
				foreach ($resas as $resa) {
					if($resa->jour == date('Y-m-d', $start) && $resa->horaire == $key){
						$libre = 0;
						break;
					}
				}
				
				$isindispo = false;
				foreach ($indisps as $ind) {
					if($ind->jour == date('Y-m-d', $start) && $ind->horaire == $key){
						$libre = 0;
						$isindispo = true;
						break;
					}
				}
				
				$allresacount = 0;
				$heurecreneau = substr($key,0,2).":".substr($key,3,2);
				$datecreneau = new DateTime(date('Y-m-d', $start).' '.$heurecreneau);
				$datelimite = new DateTime(date('Y-m-d H:i', time() + (4 * 3600)));
				$interval = $datelimite->diff($datecreneau);
				
				/* foreach ($totalresa as $allresa) {
					if($allresa->jour == date('Y-m-d', $start) && $allresa->horaire == $key){
						$allresacount++;
					}
				}
				$nbresadayexp = explode(',',$nbmaxweek->weekdays);
				if ((date('Y-m-d', $start) >= $nbmaxperiod->datedebut)&&(date('Y-m-d', $start) <= $nbmaxperiod->datefin)) {
					$nbmaxresa = $nbmaxperiod->nb_max;
				}
				else if (in_array($j, $nbresadayexp)) {
					$nbmaxresa = $nbmaxweek->nb_max;
				}
				else {
					$nbmaxresa = $nbmaxperma->nb_max;
				} */
				
				$teststaff = modules::run('rh/admin/Rhadmin/freeStaff', $scenario, date('Y-m-d', $start),$key);
				
				if ($teststaff[$scenario] == "0") { /* Cas nombre max de salles en parallèle atteint */
				}
				else  if($value[$j] == 0){ /*cas Fermé */
				} 
				elseif ($libre == 0 && $isindispo == true) { /* Cas Indisponible */
				}
				elseif($libre == 0 && $resa->valide == 1 && $resa->id_client != 0){ /* cas réservé */
				}
				elseif($libre == 0 && $resa->valide == 0) { /* Cas Résa en cours */
				}
				elseif($libre == 1 && (date('Y-m-d', $start) > date('Y-m-d') || ( date('Y-m-d', $start) == date('Y-m-d') && ($interval->invert == 0)))){
					echo '<li class="mobile_libre"><a class="_mobile_front_resa ';
					if ($key == $horaire_selected) {
						echo 'horaire_mobile_selected';
						$horaire_selected_ok = 'ok';
					}
					echo '" data-day="' . date('Y-m-d', $start) . '" data-hour="' . $key . '">'.$key.'</a></li>';
					$nodispo = 1;
				}
				else{
					/* Cas cloturé */
				}
			}
			
			if ($nodispo == 0):
			echo '<p>Aucun horaire disponible à cette date pour cette aventure. Choisissez une autre date ou une autre aventure. Merci</p>';
			else:
			?>
			<div class="error masque2" id="error_horaire">Veuillez sélectionner un horaire</div>
			<div class="error <?=(($horaire_selected != '')&&($horaire_selected_ok != 'ok'))?'':'masque2'?>" id="error_horairetest">L'horaire sélectionné précédemment n'est pas disponible pour cette aventure. Veuillez sélectionner un autre horaire</div>
			<script type="text/javascript">
					$('#titreSelectHoraire').html('4. Sélectionnez un horaire');
			</script>
			<?php endif;?>
        </ul>
		<?php if ($horaire_selected != ''):
		?>
			<p style="text-align:center;">Vous avez sélectionné l'horaire de<br><strong><?=$horaire_selected?></strong></p>
		<?php
			endif;
		?>
    </div>
	<?php endif; ?>

	<div  class="blockMobile mb32 <?=($horaire_selected_ok == 'ok')?'':'hidden'?>" id="coordonnees">
		<h2>Vos coordonnées</h2>
		<ul class="list_form">
			<li>
				<label>Civilité :</label>
				<select name="civil" id="civil">
					<option value="M" <?=(isset($civil) && $civil == 'M')?'selected="selected"':''?>>M</option>
					<option value="Mme" <?=(isset($civil) && $civil == 'Mme')?'selected="selected"':''?>>Mme</option>
					<option value="Mlle" <?=(isset($civil) && $civil == 'Mlle')?'selected="selected"':''?>>Mlle</option>
				</select>
			</li>
			<li>
				<label>Nom <span class="obligatoire">*</span> :</label>
				<input class="_required" type="text" name="nom" id="nom" value="<?=($this->session->userdata('nom'))?$this->session->userdata('nom'):''?>" />
				<div class="error masque2" id="error_nom">Merci de renseigner votre Nom</div>
			</li>
			<li>
				<label>Prénom <span class="obligatoire">*</span> :</label>
				<input class="_required" type="text" name="prenom" id="prenom" value="<?=($this->session->userdata('prenom'))?$this->session->userdata('prenom'):''?>" />
				<div class="error masque2" id="error_prenom">Merci de renseigner votre Prénom</div>
			</li>
			<li>
				<label>Email <span class="obligatoire">*</span> :</label>
				<input class="_required _format_email" type="email" name="email" id="email" value="<?=($this->session->userdata('email'))?$this->session->userdata('email'):''?>" />
				<div class="error masque2" id="error_mail">Merci de renseigner votre adresse email</div>
				<div class="error masque2" id="error_mail_valid">Votre adresse email n'est pas au bon format</div>
			</li>
			<li>
				<label>Téléphone <span class="obligatoire">*</span> :</label>
				<input class="_required" type="text" name="tel" id="tel" value="<?=($this->session->userdata('tel'))?$this->session->userdata('tel'):''?>" />
				<div class="error masque2" id="error_tel">Merci de renseigner votre numéro de téléphone</div>
				<div class="error masque2" id="error_tel_valid">Votre numéro de téléphone n'est pas au bon format</div>
			</li>
			<li style="display:none">
				<label>Login :</label>
				<input type="text" name="login" id="login" value="<?=($this->session->userdata('login'))?$this->session->userdata('login'):''?>" />
			</li>
			<li style="display:none">
				<label>Mot de passe :</label>
				<input type="text" name="password" id="password" />
				<input type="hidden" name="old_pass" id="old_pass" value="<?=(isset($pass))?$passm:''?>" />
				<div class="txt_infos"> <a id="_form_client_pass" title="Générer">Générer</a></div>
			</li>
		</ul>
	</div>

	<div class="blockMobile mb32 <?=($horaire_selected_ok == 'ok')?'':'hidden'?>" id="emailsJoueurs">
		<h2>Liste des joueurs</h2>
		<p>Ce n’est pas obligatoire pour réserver mais, si vous le souhaitez, vous pouvez renseigner les adresses email des autres joueurs afin qu’ils soient prévenus de la date et de l’heure de l’aventure.</p>
		<ul class="list_form">
			<?php for($i = 1; $i <= $nb_joueurs-1; $i++): ?>
				<li>
					<label>Email Joueur <?=$i + 1?> :</label>
					<input type="text" class="_format_email" name="joueur<?=$i?>" id="joueur<?=$i?>" value="<?=($this->session->userdata('joueur'.$i))?$this->session->userdata('joueur'.$i):''?>" />
					<div class="error masque2" id="error_mail_valid_joueur<?=$i?>">L'adresse email du joueur <?=$i?> n'est pas au bon format</div>
				</li>
			<?php endfor; ?>
		</ul>
	</div>
	
	<div class="blockMobile mb32 <?=($horaire_selected_ok == 'ok')?'':'hidden'?>" id="voucherSelect">
		<h2>Code de réduction</h2>
		<label>Je bénéficie d'un code de réduction : </label>
		<input type="text" name="voucher" id="voucher" value="<?=($voucher !='')?$voucher:''?>" />
		<div class="error masque2" id="error_voucher">Le code de réduction saisi n’est pas valide. Veuillez le vérifier</div>
			<div class="error masque2" id="used_voucher">Cette carte cadeau a déjà été utilisée. Aucune réduction ne peut être appliquée</div>
			<div class="error masque2" id="passed_voucher">Cette carte cadeau n'est plus valide. Aucune réduction ne peut être appliquée</div>
			<div class="error masque2" id="notthisroom_voucher">Ce code promotionnel ne concerne pas l'aventure que vous avez choisie. Aucune réduction ne peut être appliquée</div>
			<div class="error masque2" id="ok_voucher">Ce code est valide</div>
	</div>

    <div class="<?=($horaire_selected_ok == 'ok')?'':'hidden'?>">
        <input type="hidden" name="origine" value="<?=current_url()?>">
        <input type="hidden" name="client_id" value="<?=($this->session->userdata('client_id'))?$this->session->userdata('client_id'):''?>">
        <input type="hidden" name="jour" value="<?=$thisDay?>">
		<input type="hidden" name="horaire" value="<?=(($horaire_selected != '')&&($horaire_selected_ok=='ok'))?$horaire_selected:''?>">
        <input type="button" class=" btn btnValider" onClick="valideForm1(this.form)" value="Valider">
    </div>
