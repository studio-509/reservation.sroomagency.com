<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * function cache()
 * gestion des fichiers de cache par module
 *
 * @param	$file	(string)	fichier à observer
 * @param	$time	(int)		durée de vie du fichier en secondes
 *
 * @return	true si cache ok false si cache a refaire
 **/
 
function cache_part($file, $time)
{
	/*if(file_exists($file))
	{
		$expire = time() - $time;
		if(filemtime($file) > $expire) return TRUE;
		else return FALSE;
	}
	else return FALSE;*/
	return FALSE;
}

?>