<?php

define('sql_host', 'localhost');
define('sql_user', 'user');
define('sql_name', 'admin');
define('sql_pass', 'admin');

try {
	$bdd = new PDO('mysql:host='.sql_host.';dbname='.sql_name, sql_user, sql_pass);
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(Exception $e) {
	die('Maintenance en cours...');
}

$url = "https://localhost/catalog/"; // Lien vers l'emplacement ou vous aller installer le catalog manager
$swf = "https://localhost/game/"; // Lien vers vos SWF
