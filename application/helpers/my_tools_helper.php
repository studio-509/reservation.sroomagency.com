<?php
/**
 * function array2object()
 * retourne un objet à partir d'un array
 * @param	$array	(array)	tableau à convertir
 *
 * @return (object) tableau converti en objet
 **/
function array2object(array $array){ 
    $object = new stdClass(); 
    foreach ($array as $key => $val){ 
        if (is_array($val)){ 
            $object->$key = array2Object($val); 
        } else { 
            $object->$key = $val; 
        } 
    } 
    return $object; 
} 

/**
 * @method dateFr formatage une date au format Français
 * @param string $date date a traiter
 * @return string date formatée
 */
function dateFr($date)
{
	$horaire = '';
	// séparation heures / date
	if(strlen($date) > 10)
	{
		$split = explode(' ', $date);
		$date = $split[0];
		$h = explode(':', $split[1]);
		$horaire = ' ' . $h[0] . 'h ' . $h[1] . 'mn ' . $h[2] . 's';
	}
	$exp = explode("-",$date);
	if(count($exp) > 1)
		return $exp[2] . "/" . $exp[1] . "/" . $exp[0] . $horaire;
	else return $date . $horaire;
}

/**
 * frenchDate mise au format français de la date à partir d'un format anglais
 * @return date au format français 
 */
function frenchDate($date)
{
    $date = str_replace('/','-',$date);
    $date = explode('-',$date); 
    if(!empty($date) && count($date == 3))
    {
        $arrayMonths = array('janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre');

        $date = $date[2]." ".$arrayMonths[$date[1]-1]." ".$date[0];  
    }
    return $date;
}

/**
 * @method dateEN formatage une date au format anglais pour DB
 * @param string $date date a traiter
 * @return string date formatée
 */
function dateEn($date)
{
	$exp = explode("/",$date);
	if(count($exp) > 1)
		return $exp[2] . "-" . $exp[1] . "-" . $exp[0];
	else return $date;
}

/**
 * @method affDate formatage une date au format français avec mois litéral
 * @param string $date date a traiter
 * @return string date formatée
 */
function affDate($date)
{
	$exp = explode("-",$date);
	if(count($exp) > 1)
		return $exp[2] . " " . moisFr($exp[1]) . " " . $exp[0];
	else return $date;
}

/**
 * function gen_mdp()
 * génération du mot de passe aléatoire
 * @param	$nb_car (int)	nombre de caractère du mdp à générer (facultatif)
 * @return	$mdp (string)	mot de passe généré	
 **/	
function genMdp($nb_car = '10')
{
	$chaine = 'AZERTYUIOPQSDFGHJKLMWXCVBNazertyuiopqsdfghjklmwxcvbn123456789@#*$%';
    $nb_lettres = strlen($chaine) - 1;
    $generation = '';
    for($i=0; $i < $nb_car; $i++) {
        $pos = mt_rand(0, $nb_lettres);
        $car = $chaine[$pos];
        $generation .= $car;
    	}
    return $generation;
}

/**
 * function moisFr()
 * affiche le mois litéral en Français
 * @param	$mois (int)	N° du mois
 * @return	$m (string) nom du mois	
 **/	
function moisFr($mois)
{
	switch($mois)
	{
		case 1:
			$m = 'janvier';
			break;
		case 2:
			$m = 'février';
			break;
		case 3:
			$m = 'mars';
			break;
		case 4:
			$m = 'avril';
			break;
		case 5:
			$m = 'mai';
			break;
		case 6:
			$m = 'juin';
			break;
		case 7:
			$m = 'juillet';
			break;
		case 8:
			$m = 'août';
			break;
		case 9:
			$m = 'septembre';
			break;
		case 10:
			$m = 'octobre';
			break;
		case 11:
			$m = 'novembre';
			break;
		case 12:
			$m = 'decembre';
			break;
		return $m;	
	}
	return $m;
}

/**
 * function getFrDay()
 * retourne le jour litéral en Français
 * @param	$jour (int)	N° du jour
 * @return	$m (string) nom du jour	
 **/
function getFrDay($jour)
{
	switch($jour)
	{
		case 1:
			$m = 'Lundi';
			break;
		case 2:
			$m = 'Mardi';
			break;
		case 3:
			$m = 'Mercredi';
			break;
		case 4:
			$m = 'Jeudi';
			break;
		case 5:
			$m = 'Vendredi';
			break;
		case 6:
			$m = 'Samedi';
			break;
		case 7:
			$m = 'Dimanche';
			break;
		return $m;	
	}
	return $m;
}

/**
 * @method debug pour le débogage
 * @param $var variable à déboguer
 */
function debug($var)
{
    // permet de localiser l'endroit où à été appelée la function
    $backtrace = debug_backtrace();//echo "<pre>";print_r($backtrace);echo "</pre>";die;

    // lien vers fichier débugger
    $debug = '<div>';
    $debug .= '<p>
          	<a href=\'#\' onclick=\'$(this).parent().next(\'ol\').slideToggle(); return false;\'>
                <strong>'.$backtrace[0]['file'].' <strong>, à la ligne : '.$backtrace[0]['line'].'
            </a>
         </p>';

    $debug .= '<ol style =\'display:none;\'>';

    // j'affiche les autres fichiers concernés par $var
    foreach ($backtrace as $key => $value) 
    {
        // je ne réaffiche pas le premier tableau déjà exploité dans le premier $backtrace
        if($key>0 && isset($value['file']))
        {
            $debug .= '<li><strong>'.$value['file'].' <strong>, à la ligne : '.$value['line'].'</li>';
        }
     }
     $debug .= '</ol>';
     // détaille la variable débuggée
     $debug .= '<pre style=\'color:black\'>';
     $debug .= print_r($var, true);
     $debug .= '</pre>';
     $debug .= '</div>';
     
	 $_SESSION['debug'] = $debug;
}

/**
 * @method color - couleur des évènements de l'agenda selon user
 * @param $id id user
 */
 function color($id)
 {
	 switch($id)
	 {
		 case 1:
		 	$color = 'aqua';
		 	break;
		 case 2:
		 	$color = 'green';
		 	break;
		 default:
		 	$color = 'blue';
	 }
	 return $color;
 }
 
 /**
 * @method textcolor - couleur des textes des évènements de l'agenda selon user
 * @param $id id user
 */
 function textcolor($id)
 {
	 switch($id)
	 {
		 case 1:
		 	$textcolor = '#000';
		 	break;
		 case 2:
		 	$textcolor = '#fff';
		 	break;
		 default:
		 	$textcolor = '#fff';
	 }
	 return $textcolor;
 }

/**
 * @method csvstring_to_array - place le contenu d'un csv dans un tableau php
 * @param $string fichier csv
 * @param $CSV_SEPARATOR séparateur csv
 * @param $CSV_ENCLOSURE délimiteur csv
 * @param $CSV_LINEBREAK retour ligne csv
 */ 
 function csvstring_to_array($string, $CSV_SEPARATOR = ';', $CSV_ENCLOSURE = '"', $CSV_LINEBREAK = "\r\n") {
    $array1 = array(); //va contenir les lignes
    $array2= array(); //va contenir les champs ("zat" ou zaze ou """azer" ...)
    $arrayfinal= array(); //va contenir nos champs, correctement traités, avec une dimension par ligne.
     
    $array1=preg_split('#'.$CSV_LINEBREAK.'#',$string);//on éclate la chaine par ligne en array (une ligne par ligne)
    for($i=0;$i<count($array1);$i++){//pour chaque ligne de notre chaine
        for($o=0;$o<strlen($array1[$i]);$o++){//pour chaque caractère de la ligne
            if(preg_match('#^'.$CSV_ENCLOSURE.'#',substr($array1[$i],$o))){//si sa commence par un ENCLOSURE
                //on enregistre le mot jusqu'a qu'on trouve un seul ENCLOSURE suivie d'un SEPARATOR (donc qui commence pas par un ENCLOSURE)
                if(!preg_match('#^"(([^'.$CSV_ENCLOSURE.']*('.$CSV_ENCLOSURE.$CSV_ENCLOSURE.')?[^'.$CSV_ENCLOSURE.']*)*)'.$CSV_ENCLOSURE.$CSV_SEPARATOR.'#i',substr($array1[$i],$o,strlen($array1[$i])),$mot)){
                    $mot[1]=substr(substr($array1[$i],$o,strlen($array1[$i])),1,-1);
                }$o+=2;
            }
            else{//sinon ...
                //on prend le mot (ne contenant pas SEPARATOR ou ENCLOSURE) jusqu'au prochain SEPARATOR
                if(!preg_match('#^([^'.$CSV_ENCLOSURE.$CSV_SEPARATOR.']*)'.$CSV_SEPARATOR.'#i',substr($array1[$i],$o,strlen($array1[$i])),$mot)){
                    $mot[1]=substr($array1[$i],$o,strlen($array1[$i]));
                }
            }
        $o=$o+strlen($mot[1]);//on avance dans la ligne jusqu'au prochain mot
        $array2[$i][]=str_replace($CSV_ENCLOSURE.$CSV_ENCLOSURE,$CSV_ENCLOSURE,$mot[1]);//on transforme les double ENCLOSURE par des simple
        }
    }
  return $array2;
}

function slugify($text) {
    $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
    $text = trim($text, '-');
    if (function_exists('iconv'))
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = strtolower($text);
    $text = preg_replace('~[^-\w]+~', '', $text);
         
    if (empty($text))
        return 'n-a';
      
    return $text;
    }
?>