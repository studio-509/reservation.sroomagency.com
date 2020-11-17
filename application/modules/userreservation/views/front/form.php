<h3 class="rappelResa mt0">Votre réservation du <strong><?=dateFr($jour)?> </strong>à <strong><?=$horaire?></strong><br>pour le scénario <strong>"<?=$salle_nfo->nom?>"</strong></h3>
<form name="form" id="resa_front_form">
	<fieldset>
    	<div class="row <?=($typemodif == 'modif_resa_voucher')?'hidden':'';?>">
    	<div class="col-xs-12 col-sm-6 mb8">
        	<h3>Vos coordonnées</h3>
            <ul class="list_form">
					<input type="hidden" name="resaid" id="id_resa" value="<?=$resaid?>" />
                    <input type="hidden" name="jour" id="jour_resa" value="<?=$jour?>" />
                    <input type="hidden" name="horaire" id="horaire_resa" value="<?=$horaire?>" />
					<input type="hidden" name="roomid" id="id_room" value="<?=$salle_nfo->id?>" />
                <li>
                    <label>Civilité</label>
                    <select name="civil" id="civil">
                        <option value="M" <?=(isset($civil) && $civil == 'M')?'selectred="selected"':''?>>M</option>
                        <option value="Mme" <?=(isset($civil) && $civil == 'Mme')?'selectred="selected"':''?>>Mme</option>
                        <option value="Mlle" <?=(isset($civil) && $civil == 'Mlle')?'selectred="selected"':''?>>Mlle</option>
                    </select>
                </li>
                <li>
                    <label>Nom <span class="obligatoire">*</span></label>
                    <input class="_required" type="text" name="nom" id="nom" value="<?=(isset($nom))?$nom:''?>" />
                </li>
                <li>
                    <label>Prénom <span class="obligatoire">*</span></label>
                    <input class="_required" type="text" name="prenom" id="prenom" value="<?=(isset($prenom))?$prenom:''?>" />
                </li>
                <li>
                    <label>Email <span class="obligatoire">*</span></label>
                    <input class="_required _format_email" type="email" name="email" id="email" value="<?=(isset($email))?$email:''?>" />
                </li>
                <li>
                    <label>Téléphone <span class="obligatoire">*</span></label>
                    <input class="_required" type="text" name="tel" id="tel" value="<?=(isset($tel))?$tel:''?>" />
                </li>
                <li style="display:none">
                    <label>Login :</label>
                    <input type="text" name="login" id="login" value="<?=(isset($login))?$login:''?>" />
                </li>
                <li style="display:none">
                    <label>Mot de passe :</label>
                    <input type="text" name="password" id="password" />
                    <input type="hidden" name="old_pass" id="old_pass" value="<?=(isset($pass))?$passm:''?>" />
                    <div class="txt_infos"> <a id="_form_client_pass" title="Générer">Générer</a></div>
                </li>
            </ul>
            <p><span class="obligatoire">*</span> champs obligatoires</p>
            <div class="error_form masque2">
	            <div class="error masque2" id="error_nom">Le nom est obligatoire</div>
	            <div class="error masque2" id="error_prenom">Le prénom est obligatoire</div>
	            <div class="error masque2" id="error_email">L'e-mail est obligatoire</div>
				<div class="error masque2" id="error_format_email">Le format d'e-mail est incorrect</div>
	            <div class="error masque2" id="error_tel">Le téléphone est obligatoire</div>
	            <div class="error masque2" id="error_login">Le login est obligatoire</div>
	            <div class="error masque2" id="error_password">Le mot de passe est obligatoire</div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 mb8">
        	<h3>Liste des joueurs</h3>
            <p>Ce n’est pas obligatoire pour réserver mais, si vous le souhaitez, vous pouvez renseigner les adresses email des autres joueurs afin qu’ils soient prévenus de la date et de l’heure de l’aventure.</p>
            <ul class="list_form">
                <?php for($i = 1; $i <= 5; $i++): ?>
                    <li style="<?=($i >= $nbJoueurs)?'display:none':''?>">
                        <label>Email Joueur <?=$i + 1?></label>
                        <input type="email" class="_format_email" name="joueur<?=$i?>" id="joueur<?=$i?>" value="<?=(isset($joueurs[$i-1]) && !empty($joueurs[$i-1]))?$joueurs[$i-1]->email:""?>" />
                    </li>
                <?php endfor; ?>
            </ul>
			<div class="error masque2" id="error_format_joueur1">Le format d'e-mail du joueur 2 est incorrect</div>
			<div class="error masque2" id="error_format_joueur2">Le format d'e-mail du joueur 3 est incorrect</div>
			<div class="error masque2" id="error_format_joueur3">Le format d'e-mail du joueur 4 est incorrect</div>
			<div class="error masque2" id="error_format_joueur4">Le format d'e-mail du joueur 5 est incorrect</div>
			<div class="error masque2" id="error_format_joueur5">Le format d'e-mail du joueur 6 est incorrect</div>
		</div>
		<input type="hidden" name="reservation_id" id="reservation_id" value="<?=(isset($resa->id))?$resa->id:""?>" />
		<input type="hidden" name="client_id" id="client_id" value="<?=(isset($client->id))?$client->id:""?>" />
        </div>
		<div class="row col-sm-12 <?=($typemodif == 'modif_resa_coord')?'hidden':'';?>">
			<p>Je saisi un code promo ou un numéro de carte cadeau : <input type="text" name="voucher" id="voucher" value="<?=(isset($voucher))?$voucher:''?>" /> <!--<input type="button" class="button btn_L btn_annul mt32" value="Tester le code" id="_test_voucher" />--> </p>
			<div class="errorv masque2" id="error_voucher">Le code de réduction saisi n’est pas valide. Veuillez le vérifier</div>
			<div class="errorv masque2" id="used_voucher">Cette carte cadeau a déjà été utilisée. Aucune réduction ne peut être appliquée</div>
			<div class="errorv masque2" id="passed_voucher">Cette carte cadeau n'est plus valide. Aucune réduction ne peut être appliquée</div>
			<div class="errorv masque2" id="notthisroom_voucher">Ce code promotionnel ne concerne pas l'aventure que vous avez choisie. Aucune réduction ne peut être appliquée</div>
			<div class="errorv masque2" id="ok_voucher">Ce code est valide</div>
		</div>
        <div class="row">
        	<div class="col-xs-12 col-sm-12 pull-right text-center mt32"><input class="button btnValider" type="button" name="submit" id="_submit_resa_front_form" value="Valider" /></div>
<!--        	<div class="col-xs-12 col-sm-6 pull-right text-center mt32"><input class="button btnValider hidden" type="button" id="_btn_att_resa_front_form" value="Valider" /></div>
-->            <div class="col-xs-12 col-sm-6 text-center mt16 hidden"><input type="button" class="<?=($typemodif != '')?'_cancel_modif':'';?> button btn_L btn_annul mt32" value="Annuler" <?=($typemodif != '')?'data-id="'.$resa->id.'"':'onClick="_inPop.close(this)"';?> /></div>
        </div>
	</fieldset>
</form>
