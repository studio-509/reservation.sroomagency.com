<?php

include 'inc/sync_func.inc.php';
include 'inc/param.inc.php';


if (!empty($_GET['ask'])) {
	if ($_GET['ask'] = "synchro") {
		$testsynchro = SynchroRead (NET_DDB_INFOS);
		echo $testsynchro;
	}
	
	if ($_GET['ask'] = "oksync") {
		SynchroWrite (NET_DDB_INFOS);		
	}
}

if ((!empty($_GET['table']))&&(!empty($_GET['stream']))) {
	
	$table = $_GET['table'];
	
	if ($_GET['stream']="download") {
		
		
		BDDToXML (NET_DDB_INFOS, $table, $_GET['lastsync']);
	}
	
	if ($_GET['stream']="upload") {
		
		$filename = NETSYNCPATH.LOCALSYNCBASENAME.$table.".xml";
	
		XMLToBDD (NET_DDB_INFOS, $table, $filename);
	
	}
}

?>