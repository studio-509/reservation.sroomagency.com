<?php

	/**
	 * fullUrl()
	 * retourne l'url complète
	 */
	function fullUrl()
	{
   		$ci=& get_instance();
   		$return = APP_URL . '/' . $ci->uri->uri_string();
   		if(count($_GET) > 0)
   		{
      		$get =  array();
      		foreach($_GET as $key => $val)
     		{
         		$get[] = $key.'='.$val;
      		}
      		$return .= '?'.implode('&',$get);
   		}
   		return $return;
	} 
	
	/**
	 * getLimit()
	 * retourne le numéro de départ du limit en fonction de l'url de pagination et du pas
	 * @param $pas int nombre de résultats affichés sur la page
	 * @return $limit string limit a inclure dans la requete
	 */
	function getLimit($pas, $retour = '', $inverse = 0)
	{
   		$url = fullUrl();
		$segments = explode('/', $url);
		$lastSegment = count($segments) - 1;
		// page courante
		if(is_numeric($segments[$lastSegment]) && $retour == '')
			$base = $segments[$lastSegment]-1;
		else
		 	$base = 0;
		 	
		 $limit_value = (int) $pas;
		 $offset = (int) $base * $pas;
		
		if($inverse == 0) 	
			return array($offset, $limit_value);
		else
			return array($limit_value, $offset);
	} 
	
	
	/**
	 * pagination()
	 * système complet de pagination
	 * @param $totalItems int nombre total de résultats
	 * @param $pas int nombre de résultats affichés sur la page
	 * @param $retour int force le retour en première page de résultat
	 * @return $pagination string le bloc complet de pagination
	 **/
	function pagination($totalItems,$pas,$retour = '')
	{
		/**
		 * on commence par parser l'url pour récupérer le numéro de page courante
		 * et en déduire le lien pour la pagination
		 **/
		$url = fullUrl();
		$segments = explode('/', $url);
		$lastSegment = count($segments) - 1;
		// page courante
		if(is_numeric($segments[$lastSegment]) && $retour == '')
			$numPage = $segments[$lastSegment];
		else
		 	$numPage = 1;
		 // reconstruction de l'url
		 if(!is_numeric($segments[$lastSegment]))
		 	$lien = $url . "/";
		 else
		 {
		 	$lien = "";
		 	for($s=0;$s<$lastSegment;$s++)
		 	{
		 		$lien .= $segments[$s] . "/";
		 	}
		 }
		 	
		$nbpage = ceil($totalItems/$pas);
		$suivante = $numPage+1;
		$precedente = $numPage-1;
		// nombre de bloc à afficher dans la pagination
		if($numPage < 4) $blocs = 8 - $numPage;
		else $blocs = 4;
		if($numPage >= 1000) $blocs = $blocs -1;
		
		
		$nb = 1;
		
		$pagination = "<ul class='list_page'>";
		if($numPage > 1)
			$pagination .= "<li class=\"first previous\"><a href='".$lien.$precedente."'>Précédente</a></li>";
			
		for($i=1;$i<=($nbpage);$i++)
		{
			if($nb < $numPage+$blocs && $nb > $numPage-$blocs)
			{
				$pagination .= "<li class=\"";
				if($i == $numPage)
					$pagination .= "active";
				$pagination .= "\"><a href='".$lien.$i."'>".$i."</a></li>";
				$max = $i;
				$max2 = $i+1;
			}
			$nb++;
		}
	
		if($numPage < $nbpage)
			$pagination .= "<li class=\"last next\"><a href='".$lien.$suivante."'>Suivante</a></li>";
		
		$pagination .= "</ul>";
		if($nbpage>1)
			return $pagination;
	}
	
	/** 
	* Removes the preceeding or proceeding portion of a string 
	* relative to the last occurrence of the specified character. 
	* The character selected may be retained or discarded. 
	* 
	* Example usage: 
	* <code> 
	* $example = 'http://example.com/path/file.php'; 
	* $cwd_relative[] = cut_string_using_last('/', $example, 'left', true); 
	* $cwd_relative[] = cut_string_using_last('/', $example, 'left', false); 
	* $cwd_relative[] = cut_string_using_last('/', $example, 'right', true); 
	* $cwd_relative[] = cut_string_using_last('/', $example, 'right', false); 
	* foreach($cwd_relative as $string) { 
	*     echo "$string <br>".PHP_EOL; 
	* } 
	* </code> 
	* 
	* Outputs: 
	* <code> 
	* http://example.com/path/ 
	* http://example.com/path 
	* /file.php 
	* file.php 
	* </code> 
	* 
	* @param string $character the character to search for. 
	* @param string $string the string to search through. 
	* @param string $side determines whether text to the left or the right of the character is returned. 
	* Options are: left, or right. 
	* @param bool $keep_character determines whether or not to keep the character. 
	* Options are: true, or false. 
	* @return string 
	*/ 
	function cut_string_using_last($character, $string, $side, $keep_character=true) 
	{ 
    	$offset = ($keep_character ? 1 : 0); 
    	$whole_length = strlen($string); 
    	$right_length = (strlen(strrchr($string, $character)) - 1); 
    	$left_length = ($whole_length - $right_length - 1); 
    	switch($side) 
    	{ 
        	case 'left': 
            	$piece = substr($string, 0, ($left_length + $offset)); 
            	break; 
        	case 'right': 
            	$start = (0 - ($right_length + $offset)); 
            	$piece = substr($string, $start); 
            	break; 
        	default: 
            	$piece = false; 
            	break; 
    	} 
    	return($piece); 
	} 

?>