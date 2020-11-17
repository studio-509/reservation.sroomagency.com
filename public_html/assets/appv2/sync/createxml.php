<?php

$Sbddhost = 'hdx6234.celeo.net';
$Sbdduser = 'giluser16dev';
$Sbddpass = 'Gu4P82t-5Jy';
$Sbddbase = 'gilbdd16dev';
$Sbdderreur = 'La base est inaccessible.';

$Sbddtable = "salle"; // $_GET['table'];

$Sdatalimit = 0; // LIMIT DE DONNEES A CONVERTIR ( 0 = toutes )

// DEFINIR L'ORDRE DE LECTURE (NECCESSITE DE CONNAITRE LE CHAMPS DE REFERENCE)
// LAISSER VIDE SI AUCUN ORDRE A DEFNIR
$dataorder = 'id'; // EX: ID DESC


// CONNEXION ET LECTURE TABLE

if(!$mysql_link = @mysql_connect($Sbddhost,$Sbdduser,$Sbddpass))
{
echo $Sbdderreur;
exit;
}

$sql = "SELECT * FROM $Sbddbase.$Sbddtable";

$sqlnew = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '.$bddtable'";

if(!empty($dataorder)) $sql .= " ORDER BY $dataorder";

if($Sdatalimit >= 1) $sql .= " LIMIT $Sdatalimit";

$req0 = mysql_query("SET NAMES 'utf8'");
$req = mysql_query($sql,$mysql_link);
$req2 = mysql_query($sql,$mysql_link);
$req3 = mysql_query($sqlnew,$mysql_link);

mysql_close($mysql_link); // FERME LA CONNEXION DBB

// CONVERSION
$i = 0;

while($field = mysql_fetch_field($req2)) {
$titrecolonne[$i] = $field->name;

++$i;
}

$xml = "<?xml version='1.0' standalone='yes' encoding='UTF-8'?>";


while($row = mysql_fetch_row($req)) {

$xml .= "<row>";
$i = 0;
foreach($row as $r){
$xml .= "<field name='".$titrecolonne[$i]."'>".trim($r)."</field>"; // CREATION DE TAGS
++$i;
}

$xml .= "</row>";

}

echo ($xml);

?>
