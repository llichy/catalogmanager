<?php

include "inc.php";



$subCategoryId = $_GET['id'];
$caption = $_GET['caption'];


    $cata = $bdd->prepare('SELECT * FROM catalog_items WHERE page_id = ?');
$cata->execute([$subCategoryId]);
$furnitures = $cata->fetchAll();


    ?>

    <div id="items-<?= $subCategoryId; ?>">
    <p class="title is-6" style="margin-top: 10px"><?= $caption; ?></p>
    <?php
    foreach($furnitures as $item) { 

$cata2 = $bdd->prepare('SELECT * from furniture WHERE id = ?');
$cata2->execute([$item['item_id']]);
$furniture = $cata2->fetch();
    	?>

    <div class="item tooltip" item-id="<?= $item['item_id']; ?>" item-parent="<?= $item['page_id']; ?>" data-tooltip="<?= $furniture['item_name']; ?>">
        <img src="<?= $swf; ?>dcr/hof_furni/icon/<?= str_replace("*","_", $furniture['item_name']) ?>_icon.png">
    </div>
    <?php } ?>
</div>