<?php


include "inc.php";



$subCategoryId = $_GET['id'];
$items = $_GET['items'];

 foreach($items as $item => $subCategoryId) {

	$req = $bdd->prepare("UPDATE catalog_items SET page_id = ? WHERE item_id = ?");
	$req->execute(array($subCategoryId, $item));

}
?>