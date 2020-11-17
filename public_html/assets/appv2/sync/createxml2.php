<?php
include 'inc/sync_func.inc.php';
include 'inc/param.inc.php';

if (!empty($_GET['table'])) {
	
	$table = $_GET['table'];

	$result = BDDToXML(NET_DDB_CONNECT, $table, "0000000000");
	echo ($result);
}
else {
		echo "ERREUR : Pas de Table Sélectionnée";
}

?>
