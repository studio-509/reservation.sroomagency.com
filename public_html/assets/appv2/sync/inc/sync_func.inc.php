<?php

function BDDToXML ($bddinfos, $Sbddtable, $lastsyncts = "0000000000") {
	
	// CONNEXION ET LECTURE TABLE
	
	$link = mysqli_connect($bddinfos[0],$bddinfos[1],$bddinfos[2],$bddinfos[3]);
	
	if (mysqli_connect_errno()) {
		echo "ERREUR : ".mysqli_connect_error();
		exit();
	}
	
	$requete1 = "SET NAMES 'utf8'";
	
	if (mysqli_query($link, $requete1) != TRUE) {
		echo "ERREUR : ".mysqli_error($link);
	}
	
	$requete2 = "SELECT * FROM $Sbddtable WHERE UNIX_TIMESTAMP(derniere_modif) > $lastsyncts";
	
	if ($result = mysqli_query($link, $requete2)) {
		
		$i = 0;

		while($field = mysqli_fetch_field($result)) {
			$titrecolonne[$i] = $field->name;
			++$i;
		}

		$xml = "<?xml version='1.0' standalone='yes' encoding='UTF-8'?>";

		while($row = mysqli_fetch_row($result)) {

			$xml .= "<row>";
			$i = 0;
			foreach($row as $r){
				$xml .= "<field name='".$titrecolonne[$i]."'>".trim($r)."</field>"; // CREATION DE TAGS
				++$i;
			}
			$xml .= "</row>";
		}
		
		$filename = $bddinfos[4].$bddinfos[5].$Sbddtable.".xml";
		
		
		if ($fp =@fopen($filename, "w")) {
			fputs($fp,$xml);
			fclose($fp);
		}
		else {
			echo "ERREUR : Le Fichier n'a pu être écrit";
		}
		
	}
	else {
		echo "ERREUR : ".mysqli_error($link);
	}
	
	mysqli_free_result($result);
	
	mysqli_close($link); // FERME LA CONNEXION DBB
	
}



function XMLToBDD ($bddinfos, $Sbddtable, $filename) {
	
	// CONNEXION ET LECTURE TABLE
	
	$link = mysqli_connect($bddinfos[0],$bddinfos[1],$bddinfos[2],$bddinfos[3]);
	
	if (mysqli_connect_errno()) {
		echo "ERREUR : ".mysqli_connect_error();
		exit();
	}
	
	$requete1 = "LOAD XML LOCAL INFILE '".$filename."' REPLACE INTO TABLE ".$Sbddtable;
	
	if (mysqli_query($link, $requete1) != TRUE) {
		echo "ERREUR : ".mysqli_error($link);
	}
	
	mysqli_close($link); // FERME LA CONNEXION DBB
	
}


function SynchroRead ($bddinfos) {
	
	// CONNEXION ET LECTURE TABLE
	
	$link = mysqli_connect($bddinfos[0],$bddinfos[1],$bddinfos[2],$bddinfos[3]);
	
	if (mysqli_connect_errno()) {
		echo "ERREUR : ".mysqli_connect_error();
		exit();
	}
	
	$requete1 = "SET NAMES 'utf8'";
	
	if (mysqli_query($link, $requete1) != TRUE) {
		echo "ERREUR : ".mysqli_error($link);
	}
	
	$requete2 = "SELECT UNIX_TIMESTAMP(".$bddinfos[7].") FROM ".$bddinfos[6];
	
	if ($result = mysqli_query($link, $requete2)) {

		$row = mysqli_fetch_row($result); 
		$synctimestamp = $row[0];
	}
	if (!empty($synctimestamp)) {
		return $synctimestamp;
	}
	else {
		return FALSE;
	}
}

function SynchroWrite ($bddinfos) {
	
	// CONNEXION ET LECTURE TABLE
	
	$link = mysqli_connect($bddinfos[0],$bddinfos[1],$bddinfos[2],$bddinfos[3]);
	
	if (mysqli_connect_errno()) {
		echo "ERREUR : ".mysqli_connect_error();
		exit();
	}
	
	$requete1 = "SET NAMES 'utf8'";
	
	if (mysqli_query($link, $requete1) != TRUE) {
		echo "ERREUR : ".mysqli_error($link);
	}
	
	
	$requete2 = "UPDATE `".$bddinfos[6]."` SET `".$bddinfos[7]."`=NOW()" ;
	
	if (mysqli_query($link, $requete2) != TRUE) {
		echo "ERREUR : ".mysqli_error($link);
	}
}


function UploadToSyncPath ($ftpinfos,$path,$filename) {
	
	$connect = ftp_connect($ftpinfos[0])
	or die ("ERREUR : Connexion FTP Impossible");

	if (@ftp_login($connect,$ftpinfos[1],$ftpinfos[2])) {
		
		ftp_pasv($connect, true);

		$export = ftp_put($connect,$ftpinfos[3].$filename,$path.$filename, FTP_ASCII);
	}
	else {
		echo "ERREUR : Identification FTP Impossible";
	}

	ftp_close($connect);
	
	if ($export == TRUE) {
		return TRUE;
	}
	else return FALSE;
	
}