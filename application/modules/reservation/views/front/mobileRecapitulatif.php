<?php 
$this->load->view('/front/head');
$this->load->view('/front/mobileHeader');
?>


<div class="row">
    <div class="col-sm-6 recap">
        <h3>Mes coordonnées</h3>
        <ul class="list_form">
            <li><?=$civil . ' ' . $prenom . ' ' . $nom?></li>
            <li><?=$email?></li>
            <li><?=$tel?></li>
        </ul>
    </div>
    <div class="col-sm-6 recap">
        <h3>Ma réservation</h3>
        <ul class="list_form">
           	<li class="ttAventure"><?=$room->nom?></li>
           	<li>Le <?=dateFr($jour)?> à <?=$horaire?></li>
			<li>Nombre de participants : <span class="rappelPrix"><?=$joueurs?></span></li>
        	<li>Montant de la réservation : <span class="rappelPrix"><?=$prix?> €</span></li>
            <?php if($remise != 0 || $montant_voucher !=0): ?>
                <li>Montant de votre réduction : <span class="rappelPrix"><?=number_format($remise+$montant_voucher,2,',',' ')?> €</span></li>
                <li>Montant à régler : <span class="rappelPrix"><?=$total?> €</span></li>
            <?php endif; ?>
        </ul>
    </div>
    <div class="col-sm-6 recap emails_agents">
        <h3>E-mails des agents de mon équipe</h3>
        <ul class="list_form">
            <?php
                for($i = 1; $i < PLAYERS_MAX; $i++)
                {
                    $var = 'joueur' . $i;
                    if(isset($$var) && $$var != '')
                        echo '<li>' . $$var . '</li>';
                }
            ?>
        </ul>
    </div>
</div>

<p class="lireCGV mt64 mb16">
	<input type="checkbox" name="cgv" id="order_cgv" value="1"> J’ai lu et j’accepte les conditions générales de vente associées à ma réservation <a href="http://www.sroomagency.com/" title="Voir les CGV" target="_blank">(voir les CGV)</a>
	<p class="error masque2" id="error_cgv">Vous devez accepter les conditions générales de vente !</p>
</p>
<p class="lireCGV mt16 mb16">
    Vous allez être redirigés vers la page de paiement en ligne afin de régler la réservation de votre aventure.<br>Pour continuer cliquez sur le bouton "Procéder au paiement"
</p>

<div class="row">
	<div class=" col-xs-12 col-sm-6 pull-right">
        <?php if($total > 0): ?>
            <form action="<?php echo $oEpt->sUrlPaiement;?>" method="post" id="PaymentRequest">
            	<input type="hidden" name="version"             id="version"        value="<?php echo $oEpt->sVersion;?>" />
            	<input type="hidden" name="TPE"                 id="TPE"            value="<?php echo $oEpt->sNumero;?>" />
            	<input type="hidden" name="date"                id="date"           value="<?php echo $sDate;?>" />
            	<input type="hidden" name="montant"             id="montant"        value="<?php echo $sMontant . $sDevise;?>" />
            	<input type="hidden" name="reference"           id="reference"      value="<?php echo $sReference;?>" />
            	<input type="hidden" name="MAC"                 id="MAC"            value="<?php echo $sMAC;?>" />
            	<input type="hidden" name="url_retour"          id="url_retour"     value="<?php echo $oEpt->sUrlKO . '/' . $cle;?>" />
            	<input type="hidden" name="url_retour_ok"       id="url_retour_ok"  value="<?php echo $oEpt->sUrlOK;?>" />
            	<input type="hidden" name="url_retour_err"      id="url_retour_err" value="<?php echo $oEpt->sUrlKO . '/' . $cle;?>" />
            	<input type="hidden" name="lgue"                id="lgue"           value="<?php echo $oEpt->sLangue;?>" />
            	<input type="hidden" name="societe"             id="societe"        value="<?php echo $oEpt->sCodeSociete;?>" />
            	<input type="hidden" name="texte-libre"         id="texte-libre"    value="<?php echo HtmlEncode($sTexteLibre);?>" />
            	<input type="hidden" name="mail"                id="mail"           value="<?php echo $sEmail;?>" />

            	<input type="hidden" name="nbrech"              id="nbrech"         value="<?php echo $sNbrEch;?>" />
            	<input type="hidden" name="dateech1"            id="dateech1"       value="<?php echo $sDateEcheance1;?>" />
            	<input type="hidden" name="montantech1"         id="montantech1"    value="<?php echo $sMontantEcheance1;?>" />
            	<input type="hidden" name="dateech2"            id="dateech2"       value="<?php echo $sDateEcheance2;?>" />
            	<input type="hidden" name="montantech2"         id="montantech2"    value="<?php echo $sMontantEcheance2;?>" />
            	<input type="hidden" name="dateech3"            id="dateech3"       value="<?php echo $sDateEcheance3;?>" />
            	<input type="hidden" name="montantech3"         id="montantech3"    value="<?php echo $sMontantEcheance3;?>" />
            	<input type="hidden" name="dateech4"            id="dateech4"       value="<?php echo $sDateEcheance4;?>" />
            	<input type="hidden" name="montantech4"         id="montantech4"    value="<?php echo $sMontantEcheance4;?>" />

                <input class="button btn_L btnValider mt32" type="button" onClick="verifMobileCgv(this.form)" value="Procéder au paiement">
        </form>

    <?php else: ?>
        <form name="voucherOk" method="post" action="/reservation/orderOk">
            <input type="hidden" name="id_resa" value="<?=$sReference?>" />
			<input type="hidden" name="voucher" value="<?=$voucher?>" />
			<input type="hidden" name="partieofferte" value="ok" />
            <input type="submit" class="button btn_L btnValider mt32" value="Valider ma réservation" />
        </form>
    <?php endif; ?>
	</div>
	<div class=" col-xs-12 col-sm-6">
        <a class="button btn_L btn_annul mt16" href="/reservation/mobileCalendar/modifier">Modifier ma réservation</a>
        <a class="button btn_L btn_annul mt16" href="/reservation/mobileDelete">Annuler ma réservation</a>
    </div>
</div>


<?php $this->load->view('/front/footer'); ?>
