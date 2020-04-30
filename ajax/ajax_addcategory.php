<?php

include "../inc.php";


if (empty($_POST['caption']) || empty($_POST['parent_id']) || empty($_POST['min_rank'])) {
    echo "Merci de remplir tous les champs";
}else { 
	$caption = $_POST['caption'];
	$parentid = $_POST['parent_id'];
	$minrank = $_POST['min_rank'];

$req = $bdd->prepare('INSERT INTO catalog_pages(caption, parent_id, min_rank) VALUES(?, ?, ?)');
$req->execute(array($caption, $parentid, $minrank));

echo "ok";
}

?>