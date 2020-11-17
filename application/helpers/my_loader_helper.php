<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * function load_module_css()
 * copie dans le home les fichiers css utile pour la page
 * et complète le tableau parsé dans le header de la page
 * @param	$datas (array)		tableau contenant les fichiers css à appeler
 * @param	$module (string)	module à inspecter pour récupérer les fichiers
 * @param	$file	(string)	optionnel - fichier à recopier et insérer dans $datas
 * @return	$datas	(array)		tableau contenant les fichiers css à appeler complété par les fichiers du module
 **/
function load_module_css($datas,$module,$file='')
{
	if($file != '')
	{
		$css_path = '../application/modules/' . $module . '/assets/css/'. $file . '.css';
		$copy_file = $_SERVER['DOCUMENT_ROOT'] . '/assets/css/modules/' . $module . '/' . $file . '.css';
		$new_file = '/assets/css/modules/' . $module . '/' . $file . '.css';
		if(!is_dir($_SERVER['DOCUMENT_ROOT'] . '/assets/css/modules/' . $module))
			mkdir($_SERVER['DOCUMENT_ROOT'] . '/assets/css/modules/' . $module, 0755);
		if(cache_part($copy_file, 3600) == FALSE)
			copy($css_path,$copy_file);
		array_push($datas, $new_file);
	}
	else
	{
		$css_path = '../application/modules/' . $module . '/assets/css/';
		if(is_dir($css_path) && $dir = opendir($css_path))
		{
			while($file = readdir($dir))
			{
				$file_path = $css_path.$file;
				if($file != '.' && $file != '..' && !is_dir($file_path) && pathinfo($file, PATHINFO_EXTENSION) == 'css')
				{
					$copy_file = $_SERVER['DOCUMENT_ROOT'] . '/assets/css/modules/' . $module . '/' . $file;
					$new_file = '/assets/css/modules/' . $module . '/' . $file;
					if(!is_dir($_SERVER['DOCUMENT_ROOT'] . '/assets/css/modules/' . $module))
						mkdir($_SERVER['DOCUMENT_ROOT'] . '/assets/css/modules/' . $module, 0755);
					if(cache_part($copy_file, 3600) == FALSE)
						copy($file_path,$copy_file);
					array_push($datas, $new_file);
				}
			}
		}
	}
	return $datas;
}

/**
 * function load_module_js()
 * copie dans le home les fichiers js utile pour la page
 * et complète le tableau parsé dans le header de la page
 * @param	$datas 	(array)		tableau contenant les fichiers js à appeler
 * @param	$module (string)	module à inspecter pour récupérer les fichiers
 * @param	$file	(string)	optionnel - fichier à recopier et insérer dans $datas
 * @return	$datas	(array)		tableau contenant les fichiers js à appeler complété par les fichiers du module
 **/
function load_module_js($datas,$module,$file='')
{
	if($file != '')
	{
		$file_path = '../application/modules/' . $module . '/assets/js/' . $file . '.js';
		$copy_file = $_SERVER['DOCUMENT_ROOT'] . '/assets/js/modules/' . $module . '/' . $file . '.js';
		$new_file = '/assets/js/modules/' . $module . '/' . $file . '.js';
		if(!is_dir($_SERVER['DOCUMENT_ROOT'] . '/assets/js/modules/' . $module))
			mkdir($_SERVER['DOCUMENT_ROOT'] . '/assets/js/modules/' . $module, 0755);
		if(cache_part($copy_file, 3600) == FALSE)
			copy($file_path,$copy_file);
		array_push($datas, $new_file);
	}
	else
	{
		$js_path = '../application/modules/' . $module . '/assets/js/';
		if(is_dir($js_path) && $dir = opendir($js_path))
		{
			while($file = readdir($dir))
			{
				$file_path = $js_path.$file;
				if($file != '.' && $file != '..' && !is_dir($file_path) && pathinfo($file, PATHINFO_EXTENSION) == 'js')
				{
					$new_file = '/assets/js/modules/' . $module . '/' . $file;
					$copy_file = $_SERVER['DOCUMENT_ROOT'] . '/assets/js/modules/' . $module . '/' . $file;
					if(!is_dir($_SERVER['DOCUMENT_ROOT'] . '/assets/js/modules/' . $module))
						mkdir($_SERVER['DOCUMENT_ROOT'] . '/assets/js/modules/' . $module, 0755);
					if(cache_part($copy_file, 3600) == FALSE)
						copy($file_path,$copy_file);
					array_push($datas, $new_file);
				}
			}
		}
	}
	return $datas;
}

/**
 * function load_lib_js()
 * Complète le tableau parsé dans le header de la page pour appeler les librairies JS utiles à la page
 * @param	$datas 	(array)		tableau contenant les librairies à appeler
 * @param	$libs	(array)		tableau des librairies à insérer dans $datas
 * @return	$datas	(array)		tableau contenant les librairies à appeler complété par les librairies utiles au module
 **/
function load_lib_js($datas,$libs)
{
	if(!empty($libs))
	{
		foreach($libs as $lib)
		{
			$search_file = $_SERVER['DOCUMENT_ROOT'] . '/assets/js/libraries/' . $lib . '.js';
			$path_file = '/assets/js/libraries/' . $lib . '.js';
			if(file_exists($search_file))
				array_push($datas, $path_file);
		}
	}
	return $datas;
}

?>
