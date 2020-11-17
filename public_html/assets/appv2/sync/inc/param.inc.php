<?php

//BDD Locale
define("LOCALHOST", "localhost");
define("LOCALUSER", "root");
define("LOCALPASS", "");
define("LOCALBASE", "appmasteringv2");
define("LOCALSYNCPATH", "syncfiles/");
define("LOCALSYNCBASENAME", "local_");
define("LOCALSYNCTABLE", "synchronisation");
define("LOCALSYNCFIELD", "last_sync");
const LOCAL_DDB_INFOS = array(LOCALHOST,LOCALUSER,LOCALPASS,LOCALBASE,LOCALSYNCPATH,LOCALSYNCBASENAME,LOCALSYNCTABLE,LOCALSYNCFIELD);

//BDD Celeo
define("NETHOST", "hdx6234.celeo.net");
define("NETUSER", "giluser16dev");
define("NETPASS", "Gu4P82t-5Jy");
define("NETBASE", "gilbdd16dev");
define("NETSYNCPATH", "syncfiles/");
define("NETSYNCBASENAME", "celeo_");
define("NETSYNCTABLE", "synchronisation");
define("NETSYNCFIELD", "last_sync");
const NET_DDB_INFOS = array(NETHOST,NETUSER,NETPASS,NETBASE,NETSYNCPATH,NETSYNCBASENAME,NETSYNCTABLE,NETSYNCFIELD);

//FTP Celeo
define("FTPHOST", "95.128.74.234");
define("FTPUSER", "Sra16_com");
define("FTPPASS", "Lu5yTt72-M8g");
define("FTPSYNCPATH", "dev/public_html/assets/appv2/sync/syncfiles/");
const NET_FTP_CONNECT = array(FTPHOST,FTPUSER,FTPPASS,FTPSYNCPATH);

//Répertoire et fichier script synchro distant
define("CELEOBASEURL", "http://dev.secretroomagency.com/assets/appv2/sync/");
define("CELEOSCRIPT", "celeo_synchro.php");

//Tables à synchroniser depuis le celeo vers le local
const NET_TABLES = array("salle","reservation","client","joueurs");

//Tables à synchroniser depuis le local vers le celeo
const LOCAL_TABLES = array("partie_terminee","agent");


?>