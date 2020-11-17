<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message extends MY_Controller {

	function __construct()
    {
        parent::__construct();

        $this->data = array();
        $this->load->model('MessageModel');


    }

    public function index($data)
	{
		$this->load->library('mailin');
		$data = json_decode($data);
		//$dest = (ENVIRONMENT == 'development')?DEV_EMAIL:$data->dest;
		$dest = $data->dest;
		if(isset($data->id))
			$message = $this->substitution($data->content, $data->id);
		else
			$message = $data->content;
		$final = $this->messageBase($data->sujet, $message);
		$messageHtml = $this->messageHtml($final);
		$messageText = $this->messageText($final);

		$datas = array(
        	'to' => array($dest => $data->dest),
            'from' => array(SITE_EMAIL, SITE_EXP),
            'replyto' => array(SITE_EMAIL, SITE_EXP),
            'subject' => $data->sujet,
            'text' => $messageText,
            'html' => $messageHtml
		);
        ob_start();
        $rep = $this->mailin->send_email($datas);
        ob_get_clean();

        return TRUE;
	}

	/**
	 * fonction permettant la subsitution de valeurs dans un message
	 *
	 * @param $message : le message à traiter
	 * @param $variables : array - les couples à substituer
	 *
	 * @return : le message formaté
	 **/

	private function substitution($message,$id)
	{
		if(preg_match('#__VOUCHER_LINK__#', $message))
			$infos = $this->MessageModel->getVoucherInfos($id);
		else
			$infos = $this->MessageModel->getInfos($id);

		$variables = array(
			'__PRENOM__' => $infos->prenom,
			'__DATE__' => dateFr($infos->jour),
			'__HEURE__' => $infos->horaire ,
			'__PRIX__' => $infos->prix,
			'__SCENARIO__' => $infos->scenario,
			'__DESCRIPTIF__' => $infos->description,
			'__NOMBRE__' => $infos->joueurs - 1,
			'__ADRESSE__' => SRA_ADRESS,
			'__VOUCHER_LINK__' => APP_URL . '/voucher/pdf/' . $infos->code
		);

		foreach($variables as $key=>$val){
			$message = str_replace($key, $val, $message);
			}
		return $message;
	}

	/**
	 * fonction permettant de transformer un mail html en mail texte
	 * @param 	$str 	(string) le message à transformer
	 * @return 	$t		(string) le message au format texte
	 **/
	protected function html2str($str)
	{
		$pattern = Array("/<br \/>/","/<\/p>/","/<\/h(.)>/","/<a href=\"([^\"]*)\"([^>]*)>([^<]*)<\/a>/","/<title>([^<]*)<\/title>/","/   /");
		$rep_pat = Array("-/ligne/-","-/ligne/-","-/ligne/-","-/ligne/-$3 -> $1-/ligne/-","--------------------------------/ligne/-$1-/ligne/---------------------------------/ligne/--/ligne/-"," ");
		$str_noacc = preg_replace($pattern, $rep_pat, $str);
		$str_noacc = str_replace(array("\r","\n",CHR(10),CHR(13),"\t","  ","   ","  "),array('',"","","",""," "," "," "),html_entity_decode($str_noacc,ENT_QUOTES,"UTF-8"));
		$t = explode("-/ligne/-",$str_noacc);
		foreach($t as $k=>$v)
			$t[$k] = trim($v," ");
		return implode(CHR(10),$t);
	}

	private function messageHtml($message)
	{
		$message = stripslashes(nl2br($message));
		return $message;
	}

	private function messageText($message)
	{
		$message = stripslashes($message);
		$message = $this->html2str($message);
		$message = strip_tags($message);
		return $message;
	}

	private function messageBase($sujet, $content)
	{
		$this->data['sujet'] = $sujet;
		$this->data['content'] = $content;
		$str = $this->load->view('message',$this->data, true);
		return $str;
	}

}
?>
