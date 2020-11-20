<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Voucher extends MY_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('VoucherModel');
		/**
		* css du module
		**/
		$this->data['module_css'] = load_module_css($this->data['module_css'], 'reservation');
		$this->data['module_css'] = load_module_css($this->data['module_css'], 'voucher');
		/**
		* js du module
		**/
		$this->data['module_js'] = load_module_js($this->data['module_js'],'voucher');
	}
	public function index()
	{
		$this->data['voucher_type'] = $this->VoucherModel->getList('voucher_type', ['active' => 1,'visible' => 1],'*','prix');
		$this->data['descriptif'] = $this->VoucherModel->getData('voucher_cgv',['id' => 2]);
		$this->data['vue'] = $this->load->view('/front/form', $this->data, TRUE);
		$detect = new Mobile_Detect();
		$isPhone = $detect->isMobile() || $detect->isTablet();
		if($isPhone)
		{
			$this->load->view('/front/mobileHome', $this->data);
		}
		else {
		$this->load->view('/front/home', $this->data);
		}
	}
	// public function recapitulatif()
	// {
	// 	$post = $this->input->post('datas');
	// 	$data = array();
	// 	foreach($post as $k=>$v)
	// 	$data[$k] = $v;
	//
	// 	$datas = array(
	// 		'rPop' => $this->load->view('/front/recapitulatif', $data, TRUE),
	// 		'rPopTitle' => 'Récapitulatif de votre commande',
	// 		'rPopClass' => 'success'
	// 	);
	// 	echo json_encode($datas);
	// }
	public function recapitulatif()
	{
		$post = $this->input->post('message');
		$toto = json_decode($post,TRUE);
		$id = $toto['id'];
		$data['v'] = $this->VoucherModel->getData('voucher_type',['id' => $id]);
		$data ['v'] -> civil = $toto['civil'];
		$data ['v'] -> nom = $toto['nom'];
		$data ['v'] -> prenom = $toto['prenom'];
		$data ['v'] -> civil_d = $toto['civil_d'];
		$data ['v'] -> nom_d = $toto['nom_d'];
		$data ['v'] -> prenom_d = $toto['prenom_d'];
		$datas = array(
			'rPop' => $this->load->view('/front/recapitulatif', $data, TRUE),
			'rPopTitle' => 'Récapitulatif de votre commande',
			'rPopClass' => 'success'
		);
		echo json_encode($datas);
	}
	public function order()
	{
		$post = $this->input->post();
		$data = array();
		foreach($post as $k=>$v)
		{
			$data[$k] = $v;
		}
		// Inscription client Payeur
		$verif = $this->VoucherModel->getData('client', ['email' => $data['email']]);
		//$data['client_id'] = ($verif !== FALSE) ? $verif->id:'';
		$data['client_id'] = '';
		$datas = [
			'civil' => $data['civil'],
			'nom' => $data['nom'],
			'prenom' => $data['prenom'],
			'email' => $data['email'],
			'tel' => $data['tel']
			// 'login' => $data['login']
		];
		// NOTE IDEA
		// Anticipation espace user
		// if($data['password'] != '' && md5($data['password']) != $data['old_pass'])
		// {
		// 	$datas['password'] = md5($data['password']);
		// }
		// Fin Anticipation
		if($data['client_id'] == '')
		{
			$data['client_id'] = $this->VoucherModel->setData('client', $datas, TRUE);
		}
		else
		{
			$this->VoucherModel->updateData('client', $datas, array('id' => $data['client_id']));
		}
		unset($datas);
		// Inscription client Bénéficiaire
		$verif_d = $this->VoucherModel->getData('client', ['email' => $data['email_d']]);
		//$data['client_id_d'] = ($verif !== FALSE) ? $verif_d->id:'';
		$data['client_id_d'] = '';
		$datas = [
			'civil' => $data['civil_d'],
			'nom' => $data['nom_d'],
			'prenom' => $data['prenom_d'],
			'email' => $data['email_d'],
			'tel' => $data['tel_d']
			// 'login' => $data['login']
		];
		if($data['client_id_d'] == '')
		{
			$data['client_id_d'] = $this->VoucherModel->setData('client', $datas, TRUE);
		}
		else
		{
			$this->VoucherModel->updateData('client', $datas, ['id' => $data['client_id_d']]);
		}
		unset($datas);
		// génération voucher
		$vt = $this->VoucherModel->getData('voucher_type',['id' => $data['voucher']]);
		$vt_prix = $vt->prix;
		$vt_titre = $vt->titre;
		$vt_desc = $vt->description;
		$voucher_num = $this->generate_voucher();
		$datas = [
			'id_client' => $data['client_id'],
			'id_dest' => $data['client_id_d'],
			'code' => $voucher_num,
			'montant' => $vt_prix,
			'id_type' => $data['voucher']
		];
		$data['voucher_id'] = $this->VoucherModel->setData('voucher', $datas, TRUE);
		require_once('../application/libraries/MoneticoPaiement_Hmac.php');
		$this->data['sReference'] = 'v' . $data['voucher_id'];
		$this->data['sMontant'] = $vt_prix . '.00';
		$this->data['sDevise']  = "EUR";
		$this->data['sTexteLibre'] = "Id achat : v" . $data['voucher_id'] . "\r\n Acheté par " . $data['civil'] . " " . $data['nom'] . " " . $data['prenom'] . " \r\n Pour : " . $data['civil_d'] . " " . $data['nom_d'] . " " . $data['prenom_d'] . " \r\n Tel : " . $data['tel'] . " \r\n mail : " . $data['email']."\r\n Type de carte cadeau : " . $vt->titre . "\r\n Montant : ".$vt_prix ."€ \r\n Code de la carte :".$voucher_num;
		$this->data['sDate'] = date("d/m/Y:H:i:s");
		$this->data['sLangue'] = "FR";
		$this->data['sEmail'] = $data['email'];
		$this->data['sOptions'] = "";
		$this->data['sNbrEch'] = "";
		$this->data['sDateEcheance1'] = "";
		$this->data['sMontantEcheance1'] = "";
		$this->data['sDateEcheance2'] = "";
		$this->data['sMontantEcheance2'] = "";
		$this->data['sDateEcheance3'] = "";
		$this->data['sMontantEcheance3'] = "";
		$this->data['sDateEcheance4'] = "";
		$this->data['sMontantEcheance4'] = "";
		$this->data['oEpt'] = new MoneticoPaiement_Ept($this->data['sLangue']);
		$oHmac = new MoneticoPaiement_Hmac($this->data['oEpt']);
		$this->data['CtlHmac'] = sprintf(MONETICOPAIEMENT_CTLHMAC, $this->data['oEpt']->sVersion, $this->data['oEpt']->sNumero, $oHmac->computeHmac(sprintf(MONETICOPAIEMENT_CTLHMACSTR, $this->data['oEpt']->sVersion, $this->data['oEpt']->sNumero)));
		$phase1go_fields = sprintf(MONETICOPAIEMENT_PHASE1GO_FIELDS,     $this->data['oEpt']->sNumero,
		$this->data['sDate'],
		$this->data['sMontant'],
		$this->data['sDevise'],
		$this->data['sReference'],
		$this->data['sTexteLibre'],
		$this->data['oEpt']->sVersion,
		$this->data['oEpt']->sLangue,
		$this->data['oEpt']->sCodeSociete,
		$this->data['sEmail'],
		$this->data['sNbrEch'],
		$this->data['sDateEcheance1'],
		$this->data['sMontantEcheance1'],
		$this->data['sDateEcheance2'],
		$this->data['sMontantEcheance2'],
		$this->data['sDateEcheance3'],
		$this->data['sMontantEcheance3'],
		$this->data['sDateEcheance4'],
		$this->data['sMontantEcheance4'],
		$this->data['sOptions']);
		$this->data['sMAC'] = $oHmac->computeHmac($phase1go_fields);
		$this->data['vue'] = $this->load->view('/front/orderForm', $this->data, TRUE);
		$this->load->view('/front/home', $this->data);
	}
	public function orderOk()
	{
		$id = substr($this->uri->segment(3),1);
		$infos = $this->VoucherModel->getData('voucher', array('id' => $id));
		// $this->data = [];
		$this->data['link'] = APP_URL . '/voucher/pdf/' . $infos->code;
		$this->data['retour'] = 'Validation commande';
		$this->data['vue'] = $this->load->view('/front/orderOk', $this->data, TRUE);
		$this->load->view('/front/home', $this->data);
	}
	public function orderDeny()
	{
		$id = substr($this->uri->segment(3),1);
		$this->VoucherModel->deleteData('voucher', array('id' => $id));
		$this->data['retour'] = 'Annulation Commande';
		$this->data['vue'] = $this->load->view('/front/orderKo', $this->data, TRUE);
		$this->load->view('/front/home', $this->data);
	}
	public function pdf()
	{
		require_once('../application/libraries/fpdf.php');
		
		$infosvoucher = $this->VoucherModel->getData('voucher', array('code' => $this->uri->segment(3)));
		$clientvoucher = $this->VoucherModel->getData('client', array('id' => $infosvoucher->id_client));
		$destvoucher = $this->VoucherModel->getData('client', array('id' => $infosvoucher->id_dest));
		$infosvouchertype = $this->VoucherModel->getData('voucher_type', array('id' => $infosvoucher->id_type));
		$vouchercgv = $this->VoucherModel->getData('voucher_cgv', array('id' => 1));
		$dureevalide = $this->VoucherModel->getData('voucher_duree', array('id' => 2));
		
		$clientaffiche = utf8_decode(ucwords(strtolower($clientvoucher->prenom)).' '.ucwords(strtolower($clientvoucher->nom)));
		$destaffiche = utf8_decode(ucwords(strtolower($destvoucher->prenom)).' '.ucwords(strtolower($destvoucher->nom)));
		$dateachat = new DateTime($infosvoucher->date_achat);
		$anneeachat = $dateachat->format("Y");
		$moisachat = $dateachat->format("n");
		$listemois = array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
		$anneevalide = $anneeachat;
		$moisvalide = $moisachat + $dureevalide->duree;
		if ($moisvalide > 12) {
			$moisvalide -= 12;
			$anneevalide += 1;
		}
		$moisvalideaffiche = utf8_decode($listemois[$moisvalide-1]);
		
		$qrcontent = $infosvoucher->code."|";
		$qrcontent .= $infosvouchertype->titre."|";
		$qrcontent .= $clientvoucher->prenom." ".$clientvoucher->nom."|";
		$qrcontent .= $destvoucher->prenom." ".$destvoucher->nom."|";
		$qrcontent .= $infosvoucher->montant."|";
		$qrcontent .= $listemois[$moisvalide-1]." ".$anneevalide."|";
		$qrcontent = str_replace(' ','',$qrcontent);
		
		$explodeinf = explode("<",$infosvouchertype->description);
		$description = $explodeinf[0];
		foreach ($explodeinf as $exp) {
			$explodesup = explode (">",$exp);
			$description .= $explodesup[1];
		}
		
		$pdf = new FPDF();
		$pdf->AddFont('Gloss','','Gloss_And_Bloom.php');
		$pdf->SetTopMargin(0);
		$pdf->SetLeftMargin(0);
		$pdf->SetAuthor('S Room Agency');
		$pdf->Header();
		$pagesize = array(215,95);
		$pdf->AddPage('L',$pagesize);
		$pdf->SetAutoPageBreak(false);
		$pdf->SetDrawColor(150,150,150);
		//$pdf->SetLineWidth(3);		
		$pdf->SetXY(5,8);
		$pdf->Cell(186,67,'',1);
		$pdf->Ln(0);
		$pdf->SetXY(5,5);
		$pdf->SetFillColor(30,30,30);
		$pdf->Cell(50,91,'',0,0,'L',true);
		$pdf->Image('http://'.$_SERVER['SERVER_NAME'].'/assets/img/logosra2.png',8,7,43,23,'png');
		$context = stream_context_create(array('ssl'=>array('verify_peer' => false)));
		$qrpath = file_get_contents("http://".$_SERVER['SERVER_NAME']."/assets/img/Generate_qrcode.php?code=".$qrcontent, false, $context);
		$pdf->Image("http://".$_SERVER['SERVER_NAME']."/assets/img/qrcarteskdo/".$qrpath,13.5,55,30,30,'png');
		$pdf->SetFillColor(227,5,19);
		$pdf->Rect(52,5,3,90,'F');
		
		$pdf->SetFont('Helvetica','',7);
		$pdf->SetTextColor(255,255,255);
		$pdf->SetY(31);
		$pdf->SetX(9);
		$pdf->MultiCell(34,3,utf8_decode('Vous pouvez nous joindre tous les jours au numéro'),0,'L');
		$pdf->Ln(1);
		$pdf->SetX(9);
		$pdf->SetFont('Helvetica','',9);
		$pdf->SetTextColor(227,5,19);
		$pdf->Cell(34,3,SRA_TEL);
		
		$pdf->Ln(5);
		$pdf->SetX(9);
		$pdf->SetFont('Helvetica','',7);
		$pdf->SetTextColor(255,255,255);
		$pdf->MultiCell(29,3,SRA_ADRESS);
		
		$pdf->Ln(1);
		$pdf->SetX(9);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Cell(34,3,SITE_URL);
		
		$pdf->SetFont('Helvetica','B',8);
		$pdf->SetY(82);
		$pdf->SetX(9);
		$pdf->Cell(39,13,utf8_decode("Carte ".$infosvoucher->code),0,0,'C');
		
		$pdf->SetY(11);
		$pdf->SetX(58);
		$pdf->SetFont('Helvetica','B',18);
		$pdf->SetTextColor(227,5,19);
		$pdf->Cell(130,6,'CARTE CADEAU',0,0,'C');
		$pdf->SetTextColor(0,0,0);
		$pdf->Ln(7);
		$pdf->SetX(55);
		$pdf->SetFont('Helvetica','',12);
		$numerocarte = utf8_decode($infosvouchertype->titre);
		$pdf->Cell(130,4,$numerocarte,0,0,'C');
		$pdf->Ln(9);
		$pdf->SetX(60);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Cell(10,4,'Pour :',0);
		$pdf->SetFont('Gloss','',16);
		$pdf->Cell(92,4,$destaffiche,0);
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell(30,4,utf8_decode("Valable jusqu'à"),0,0,'C');
		$pdf->Ln(8);
		$pdf->SetX(60);
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell(15,4,'Offerte par :',0);
		$pdf->SetFont('Gloss','',12);
		$pdf->Cell(92,4,'  '.$clientaffiche,0);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell(20,1,"fin ".$moisvalideaffiche." ".$anneevalide,0,0,'C');
		$pdf->Ln(8);
		$pdf->SetX(58);
		$pdf->SetFont('Helvetica','',8);
		$pdf->MultiCell(130,4,utf8_decode($description),0,'C');
		$pdf->Ln();
		$pdf->SetX(58);
		$pdf->SetFont('Helvetica','B',12);
		$pdf->Cell(130,4,'Escape Game S ROOM AGENCY Montauban',0,0,'C');
		$pdf->Ln(6);
		$pdf->SetX(58);
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell(130,4,utf8_decode("Un jeu d'équipe, une expérience unique et immersive"),0,0,'C');
		$pdf->Ln();
		$pdf->SetX(58);
		$pdf->SetFont('Helvetica','',8);
		$pdf->SetTextColor(227,5,19);
		$pdf->Cell(130,4,utf8_decode("1 heure pour résoudre des énigmes et remplir votre mission"),0,0,'C');
		$pdf->SetTextColor(0,0,0);
		$pdf->Ln(12);
		$pdf->SetX(55);
		$pdf->SetFont('Helvetica','',6);
		$pdf->MultiCell(137,3,utf8_decode($vouchercgv->cgv),0,'J');

		$pdf->SetFillColor(227,5,19);
		$pdf->Rect(163,5,32,17,'F');
		if ($infosvoucher->montant < 54) {
			$pdf->SetY(8);
			$pdf->SetX(172);
			$pdf->SetTextColor(255,255,255);
			$pdf->SetFont('Helvetica','B',28);
			$pdf->Cell(20,8,$infosvoucher->montant,0,'L');
			$pdf->SetY(14);
			$pdf->SetX(172.2);
			$pdf->SetFont('Helvetica','',10);
			$pdf->Cell(21,8,"EURO",0,'L');
		}
		else {
			$pdf->SetY(7);
			$pdf->SetX(168.5);
			$pdf->SetTextColor(255,255,255);
			$pdf->SetFont('Helvetica','',20);
			$pdf->Cell(20,8,"Partie",0,'L');
			$pdf->SetY(13);
			$pdf->SetX(168.5);
			$pdf->SetFont('Helvetica','',17);
			$pdf->Cell(21,8,"Offerte",0,'L');
		}
		$pdf->Output();
		
 		/* if( ! $this->uri->segment(3))
		{
			die('Une erreur est survenue, merci de recommencer');
		} 
		$infos = $this->VoucherModel->getData('voucher', array('code' => $this->uri->segment(3)));
		$cgv = $this->VoucherModel->getData('voucher_cgv', ['id' => 1]);
		if($infos === FALSE)
		{
			die('code inconnu');
		}
		$this->data['date_achat'] = $infos->date_achat;
		$anneevalid = intval(substr($infos->date_achat,0,4));
		$moisvalid = intval(substr($infos->date_achat,5,2))+6;
		if ($moisvalid > 12) {
			$moisvalid -= 12;
			$anneevalid += 1;
		}
		if ($moisvalid <10) $moisvalid = "0".$moisvalid;
		$this->data['date_valid'] = $moisvalid." ".$anneevalid;
		$qrpath = file_get_contents(APP_URL.'/assets/img/Generate_qrcode.php?code='.$infos->code);
		$this->data['qrpath'] = $qrpath;
		$client = $this->VoucherModel->getData('client', array('id' => $infos->id_client));
		$this->data['prenom'] = $client->prenom;
		$this->data['montant'] = str_ireplace('.', ',', $infos->montant . ' €');		
		$this->data['code'] = $infos->code;
		$this->data['cgv'] = $cgv->cgv;
		$html = $this->load->view('front/carte', $this->data, TRUE);
		$this->m_pdf->pdf->WriteHTML($html);
		$name = 'Secret-Room-Agency-carte-cadeau-'.$infos->code.'.pdf';
		$this->m_pdf->pdf->Output($name, 'I');
		echo $code; */
	}
	public function pdf2()
	{
		
/* 		if( ! $this->uri->segment(3))
		{
			die('Une erreur est survenue, merci de recommencer');
		} */
		$code = $this->input->post('voucher');
		$infos = $this->VoucherModel->getData('voucher', array('code' => $this->uri->segment(3)));
		$voucherduree = $this->VoucherModel->getData('voucher_duree',['id' => 2]);
		//$infos = $this->VoucherModel->getData('voucher', array('code' => $code));
		$cgv = $this->VoucherModel->getData('voucher_cgv', ['id' => 1]);
		if($infos === FALSE)
		{
			die('code inconnu');
		}
		$this->data['date_achat'] = $infos->date_achat;
		$anneevalid = intval(substr($infos->date_achat,0,4));
		$moisvalid = intval(substr($infos->date_achat,5,2))+$voucherduree->duree;
		if ($moisvalid > 12) {
			$moisvalid -= 12;
			$anneevalid += 1;
		}
		if ($moisvalid <10) $moisvalid = "0".$moisvalid;
		$this->data['date_valid'] = $moisvalid." ".$anneevalid;
		$context = stream_context_create(array('ssl'=>array('verify_peer' => false)));
		$qrpath = file_get_contents("http://".$_SERVER['SERVER_NAME']."/assets/img/Generate_qrcode.php?code=".$infos->code, false, $context);
		$this->data['qrpath'] = $qrpath;
		$client = $this->VoucherModel->getData('client', array('id' => $infos->id_client));
		$this->data['prenom'] = $client->prenom;
		$this->data['montant'] = str_ireplace('.', ',', $infos->montant . ' €');		
		$this->data['code'] = $infos->code;
		$this->data['cgv'] = $cgv->cgv;
		$html = $this->load->view('front/carte', $this->data, TRUE);
		$this->m_pdf->pdf->WriteHTML($html);
		$name = 'assets/cartescadeau/Secret-Room-Agency-carte-cadeau-'.$infos->code.'.pdf';
		$this->m_pdf->pdf->Output($name, 'F');
		echo $code;
	}
	public function generate_voucher()
	{
		$characts   = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
		$characts   .= '123456789';
		$code_aleatoire      = 'KC';
		for($i=0;$i < 10;$i++)    //10 est le nombre de caractères
		{
			$code_aleatoire .= substr($characts,rand()%(strlen($characts)),1);
		}
		$test = $this->VoucherModel->getNbData('voucher', array('code' => $code_aleatoire));
		if($test != 0)
		{
			$this->generate_voucher();
		}
		else
		{
		 	if ( $this->input->is_ajax_request() )
			{
				echo $code_aleatoire;
			}
			else
			{
				return $code_aleatoire;
			}
		}
	}
	public function test()
	{
		
		$code = $this->input->post('voucher');
		$salle = $this->input->post('salle');
		$test = $this->VoucherModel->getData('voucher', ['code' => $code] );
		$voucherduree = $this->VoucherModel->getData('voucher_duree',['id' => 2]);
		if (!$test) {
			$test = $this->VoucherModel->getData('promo', ['code' => $code] );
			if (!$test) {
				echo 0;
			}
			else {
				if ($test->date_debut<=date('Y-m-d') && $test->date_fin >= date('Y-m-d') && $test->taux > 0) {
					$salles = explode('|',$test->salles);
					if (in_array($salle,$salles)) echo 4;
					else echo 3;
				}
				else echo 0;
			}
		}
		else {
			if ($test->valide == 1 && $test->montant > 0) {
				$anneevalid = intval(substr($test->date_achat,0,4));
				$moisvalid = intval(substr($test->date_achat,5,2))+$voucherduree->duree;
				if ($moisvalid > 12) {
					$moisvalid -= 12;
					$anneevalid += 1;
				}
				if ($moisvalid <10) $moisvalid = "0".$moisvalid;
				$datevalid = $anneevalid.$moisvalid;
				if (date(Ym)>$datevalid) echo 2;
				else echo 4;
			}		
			else echo 1;
		}
	}
	
	
	
}
?>
