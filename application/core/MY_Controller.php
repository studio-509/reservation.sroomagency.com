<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends MX_Controller {

	/**
	 * Controller parent comprenant les fonctions que l'on retrouve
	 * dans tous les controllers du système
	 **/

	function __construct()
    {
        parent::__construct();

        $this->data = array();

        /**
         * librairies JS à charger partout
         **/
        $this->data['lib_js'] = array();

				$this->data['lib_js'] = load_lib_js($this->data['lib_js'],array('jquery-2.1.1.min','jquery-ui.min', 'jq-timeTo-master/jquery.time-to','datepicker-fr'));

        $this->data['module_css'] = array();
        $this->data['module_css'] = load_module_css($this->data['module_css'], 'popin');
        $this->data['module_js'] = array();


		/* if(preg_match('/MSIE/i',$_SERVER['HTTP_USER_AGENT'])){
			$this->data['module_js'] = load_module_js($this->data['module_js'], 'popinie');
		}
		else { */
			$this->data['module_js'] = load_module_js($this->data['module_js'], 'popin');
		//}
		date_default_timezone_set('Europe/Paris');

    }

    /**
     * is_ajax()
	 * vérifie si une requête ajax a été générée
	 *
     * @return boolean TRUE si requête ajax
     */
    protected function is_ajax()
    {
        return ($this->input->server('HTTP_X_REQUESTED_WITH') == 'XMLHttpRequest') ? TRUE : FALSE;
    }

}

/* End of file MY_controller.php */
/* Location: ./application/core/MY_controller.php */
