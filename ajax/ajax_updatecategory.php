<?php

include "../inc.php";


if (empty($_POST['caption']) || empty($_POST['parent_id']) || empty($_POST['min_rank'])) {
    echo "Merci de remplir tous les champs";
}else { 
		$id = $_POST['id'];
		$caption = $_POST['caption'];
		$parent_id = $_POST['parent_id'];
		$icon_image	 = $_POST['icon_image'];
		$min_rank = $_POST['min_rank'];
		$enabled = $_POST['enabled'];
		$page_layout = $_POST['page_layout'];
		$page_strings_1 = $_POST['page_images'];
		$page_link = $_POST['link'];

	$req = $bdd->prepare("UPDATE catalog_pages SET caption = ?, parent_id = ?, icon_image = ?, min_rank = ?, enabled = ?, page_layout = ?, page_text1 = ?, page_link = ? WHERE id = ? LIMIT 1");
	$req->execute(array($caption, $parent_id, $icon_image, $min_rank, $enabled, $page_layout, $page_strings_1, $page_link,$id));
echo "ok";
}

?>