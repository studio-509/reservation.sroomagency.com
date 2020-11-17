<div>
	<p style="text-align:center">Merci de patienter, vous aller être rediriger vers la page de paiement en ligne</p>
</div>
<div class="masque">
<form action="<?php echo $oEpt->sUrlPaiement;?>" method="post" id="PaymentRequest">
	<input type="hidden" name="version"             id="version"        value="<?php echo $oEpt->sVersion;?>" />
	<input type="hidden" name="TPE"                 id="TPE"            value="<?php echo $oEpt->sNumero;?>" />
	<input type="hidden" name="date"                id="date"           value="<?php echo $sDate;?>" />
	<input type="hidden" name="montant"             id="montant"        value="<?php echo $sMontant . $sDevise;?>" />
	<input type="hidden" name="reference"           id="reference"      value="<?php echo $sReference;?>" />
	<input type="hidden" name="MAC"                 id="MAC"            value="<?php echo $sMAC;?>" />
	<input type="hidden" name="url_retour"          id="url_retour"     value="<?php echo $oEpt->sUrlKO . '/' . $sReference;?>" />
	<input type="hidden" name="url_retour_ok"       id="url_retour_ok"  value="<?php echo $oEpt->sUrlOK . '/' . $sReference;?>" />
	<input type="hidden" name="url_retour_err"      id="url_retour_err" value="<?php echo $oEpt->sUrlKO . '/' . $sReference;?>" />
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
</form>
</form>
<script type="text/javascript">
	$(document).ready(function(){
		$("#PaymentRequest").submit();
	});
</script>
