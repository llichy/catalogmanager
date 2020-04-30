<?php

include "inc.php";


$categoryId = $_GET['id'];
?>
<?php
    $cata = $bdd->prepare('SELECT * FROM catalog_pages WHERE parent_id = ? ORDER by order_num ASC');
$cata->execute([$categoryId]);
$subCategories = $cata->fetchAll();

 if($cata->rowCount() == 0) {
                die('null');
            } else {

                ?>
<script>
Sortable.create(sortable<?= $categoryId; ?>, {
    onEnd: function(event) {
        var subCategories = { };
        $("#<?= $categoryId; ?> .subCategories a").each(function(index) {
            var subCategoryId = $(this).attr("category-id");
            console.log(index + " - " + subCategoryId);
            subCategories[index] = subCategoryId;
        });

        $.get(hostname + "/setOrderSubCategoryById.php", {
            subCategories: subCategories,
        })
        .done(function(content) {
            $("body").prepend(content);
        });
    }
});
</script>
<div id="sortable<?= $categoryId; ?>">
<?php
    foreach($subCategories as $subCategory) { ?>
    <a category-caption="<?= $subCategory['caption']; ?>" category-id="<?= $subCategory['id']; ?>" category-parent="<?= $subCategory['parent_id']; ?>" class="panel-block droppable">
        <img src="http://localhost/pics.nlbobba.fr/c_images/catalogue/icon_<?= $subCategory['icon_image']; ?>.png"> <span><?= $subCategory['caption']; ?></span>
    </a>
    <?php } ?>
</div>

<?php
  }         
?>