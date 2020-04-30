<?php

include "inc.php";
?>
<style type="text/css">#error-message{z-index:1000;font-weight:700;background-color:#c00;height:35px;text-align:center;width:100%}#error-message span{height:35px;color:#fff;display:inline-block;font-weight:700;line-height:35px;vertical-align:middle}#error-message b{font-size:16px;font-weight:700}
#success-message{z-index:1000;font-weight:700;background-color:#00cc35;height:35px;text-align:center;width:100%}#success-message span{height:35px;color:#fff;display:inline-block;font-weight:700;line-height:35px;vertical-align:middle}#success-message b{font-size:16px;font-weight:700}
</style>
<div id="error-login-content"></div>

<div id="categories">
    <?php
    $navigationIdd = $_GET['id'];

$cataq = $bdd->prepare('SELECT * FROM catalog_pages WHERE id = ? LIMIT 1');
$cataq->execute([$navigationIdd]);
$catalogPage = $cataq->fetch();
 ?>
<center><a href="<?= $url; ?>removeCategoryById.php?id=<?= $catalogPage['id'] ?>" class="button is-danger">Supprimer cette catégorie</a></center><br>

 <form method="post" id="<?= $catalogPage['id'] ?>">
    <label class="label">ID de la catégorie</label>
     <input type="text" class="input" name="id" disabled value="<?= $catalogPage['id'] ?>" id="id" />
     <label class="label">Nom de la catégorie</label>
     <input type="text" class="input" name="caption" value="<?= $catalogPage['caption'] ?>" id="caption" />
     <label class="label">-1 = Navigation ou ID de la catégorie parent.</label>
     <input type="text" class="input" name="parent_id" value="<?= $catalogPage['parent_id'] ?>" id="parent_id" />
     <label class="label">Numéro de l\'icone</label>
     <input type="text" class="input" name="icon_image" value="<?= $catalogPage['icon_image'] ?>" id="icon_image" />
     <label class="label">Rang minimum pour voir la catégorie</label>
     <input type="text" class="input" name="min_rank" value="<?= $catalogPage['min_rank'] ?>" id="min_rank" />
     <label class="label">Activé / Désactivé la catégorie</label>
     <input type="text" class="input" name="enabled" value="<?= $catalogPage['enabled'] ?>" id="enabled" />
     <label class="label">Template de la page</label>
     <input type="text" class="input" name="page_layout" value="<?= $catalogPage['page_layout'] ?>" id="page_layout" />
     <label class="label">Nom des images</label>
     <input type="text" class="input" name="page_images" value="<?= $catalogPage['page_headline'] ?>" id="page_strings_1" />
    <label class="label">Lien</label>
     <input type="text" class="input" name="link" value="<?= $catalogPage['page_link'] ?>" id="link" /> <br>
     <input type="submit" id="editcategory" class="button is-primary" value="Modifier">
 </form>


<script type="text/javascript">
        $("#editcategory").on('click', function(event){
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "<?= $url; ?>ajax/ajax_updatecategory.php",
            data: "id="+$("#id").val()+"&caption="+$("#caption").val()+"&parent_id="+$("#parent_id").val()+"&icon_image="+$("#icon_image").val()+"&min_rank="+$("#min_rank").val()+"&enabled="+$("#enabled").val()+"&page_layout="+$("#page_layout").val()+"&page_images="+$("#page_strings_1").val()+"&link="+$("#page_link").val(),
            success: function(msg){
                if(msg == "ok") {
                  $("#error-login-content").html('<div id="success-message"><span> La catégorie vient d\'être modifié :) </span></div>').effect('bounce','slow')
               setTimeout(function(){window.location.reload(); },2000);
                }else {
                $("#error-login-content").html('<div id="error-message"><span> '+ msg +' </span></div>').effect('bounce','slow')
                }
            }
        });
    });
</script>
