<?php
/*****************************************************************************
 *
 * "open source" kit for Monetico paiement(TM)
 *
 * File "MoneticoPaiement_Ept.inc.php":
 *
 * Author   : Euro-Information/e-Commerce
 * Version  : 4.0
 * Date      : 05/06/2014
 *
 * Copyright: (c) 2014 Euro-Information. All rights reserved.
 * License  : see attached document "License.txt".
 *
 *****************************************************************************/

/*****************************************************************************
*
* Classe / Class : MoneticoPaiement_Ept
*
*****************************************************************************/

class MoneticoPaiement_Ept {


	public $sVersion;	// Version du TPE - EPT Version (Ex : 3.0)
	public $sNumero;	// Numero du TPE - EPT Number (Ex : 1234567)
	public $sCodeSociete;	// Code Societe - Company code (Ex : companyname)
	public $sLangue;	// Langue - Language (Ex : FR, DE, EN, ..)
	public $sUrlOK;		// Url de retour OK - Return URL OK
	public $sUrlKO;		// Url de retour KO - Return URL KO
	public $sUrlPaiement;	// Url du serveur de paiement - Payment Server URL (Ex : https://p.monetico-services.com/paiement.cgi)

	private $_sCle;		// La cl� - The Key


	// ----------------------------------------------------------------------------
	//
	// Constructeur / Constructor
	//
	// ----------------------------------------------------------------------------

	function __construct($sLangue = "FR") {

		// contr�le de l'existence des constantes de param�trages.
		$aRequiredConstants = array('MONETICOPAIEMENT_KEY', 'MONETICOPAIEMENT_VERSION', 'MONETICOPAIEMENT_EPTNUMBER', 'MONETICOPAIEMENT_COMPANYCODE');
		$this->_checkEptParams($aRequiredConstants);

		$this->sVersion = MONETICOPAIEMENT_VERSION;
		$this->_sCle = MONETICOPAIEMENT_KEY;
		$this->sNumero = MONETICOPAIEMENT_EPTNUMBER;
		$this->sUrlPaiement = MONETICOPAIEMENT_URLSERVER . MONETICOPAIEMENT_URLPAYMENT;

		$this->sCodeSociete = MONETICOPAIEMENT_COMPANYCODE;
		$this->sLangue = $sLangue;

		$this->sUrlOK = MONETICOPAIEMENT_URLOK;
		$this->sUrlKO = MONETICOPAIEMENT_URLKO;

	}

	// ----------------------------------------------------------------------------
	//
	// Fonction / Function : getCle
	//
	// Renvoie la cl� du TPE / return the EPT Key
	//
	// ----------------------------------------------------------------------------

	public function getCle() {

		return $this->_sCle;
	}

	// ----------------------------------------------------------------------------
	//
	// Fonction / Function : _checkEptParams
	//
	// Contr�le l'existence des constantes d'initialisation du TPE
	// Check for the initialising constants of the EPT
	//
	// ----------------------------------------------------------------------------

	private function _checkEptParams($aConstants) {

		for ($i = 0; $i < count($aConstants); $i++)
			if (!defined($aConstants[$i]))
				die ("Erreur param�tre " . $aConstants[$i] . " ind�fini");
	}

}
?>
