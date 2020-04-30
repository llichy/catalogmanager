<?php

include "inc.php";
?>
    <?php
    $id = $_GET['id'];

$query = $bdd->prepare('SELECT * FROM furniture INNER JOIN catalog_items ON furniture.id = catalog_items.item_id WHERE catalog_items.item_id = ? LIMIT 1');
$query->execute([$id]);
$catalogitez = $query->fetch();
 ?>
<style type="text/css">#error-message{z-index:1000;font-weight:700;background-color:#c00;height:35px;text-align:center;width:100%}#error-message span{height:35px;color:#fff;display:inline-block;font-weight:700;line-height:35px;vertical-align:middle}#error-message b{font-size:16px;font-weight:700}
#success-message{z-index:1000;font-weight:700;background-color:#00cc35;height:35px;text-align:center;width:100%}#success-message span{height:35px;color:#fff;display:inline-block;font-weight:700;line-height:35px;vertical-align:middle}#success-message b{font-size:16px;font-weight:700}
</style>
<div id="error-login-content"></div>
<div style="height: 100%; width:100%; display: block; overflow-y: auto;">
<form method="post" accept-charset="utf-8">
    <input type="hidden" id="id" value="<?= $catalogitez['item_id'] ?>" name="id">
    <p class="control ">
        <label for="catalog-name">Nom du mobis</label>
        <input class="input" type="text" name="catalog_name" id="catalog-name" value="<?= $catalogitez['catalog_name'] ?>"><span class="help">Le nom du mobis défini dans le catalogue.</span><span class="icon is-small is-left" style="display:none"><i class="fa fa-"></i></span></p>
    <label for="page-id">Page ID</label>
    <input class="input" type="text" name="page_id" id="page-id" value="<?= $catalogitez['page_id'] ?>">
     <p class="control ">
    <p class="control ">
        <label for="cost-credits">Coût en crédits</label>
        <input class="input" type="text" name="cost_creditse" id="cost-creditse" value="<?= $catalogitez['cost_credits'] ?>"><span class="help"></span><span class="icon is-small is-left" style="display:"><i class="fa fa-"></i></span></p>
    <p class="control ">
        <label for="cost-diamonds">Coût en diamants</label>
        <input class="input" type="text" name="cost_points" id="cost-points" value="<?= $catalogitez['cost_points'] ?>" ><span class="help"></span><span class="icon is-small is-left" style="display:"><i class="fa fa-"></i></span></p>
    <p class="control ">
        <label for="amount">Vendu par unité</label>
        <input class="input" type="text" name="amount" id="amount" value="<?= $catalogitez['amount'] ?>" ><span class="help">La quantité du même mobis achetée par achat.</span><span class="icon is-small is-left" style="display:none"><i class="fa fa-"></i></span></p>
    <p class="control ">
        <label for="limited-sells">(LTD) Déjà vendu</label>
        <input class="input" type="text" name="limited_sells" id="limited-sells" value="<?= $catalogitez['limited_sells'] ?>"><span class="help">Le nombre de fois que ce mobis a été acheté par les habbos pour ce LTD. Par défaut laisser 0.</span><span class="icon is-small is-left" style="display:none"><i class="fa fa-"></i></span></p>
    <p class="control ">
        <label for="limited-stack">(LTD) Unité mis en vente</label>
        <input class="input" type="text" name="limited_stack" id="limited-stack" value="<?= $catalogitez['limited_stack'] ?>"><span class="help">Le nombre de mobis mis en vente pour ce LTD.</span><span class="icon is-small is-left" style="display:none"><i class="fa fa-"></i></span></p>
    <input class="input" type="hidden" name="furniture[id]" id="furniture-id">
    <p class="control ">
        <label for="furniture-type">Type du mobis</label>
        <input class="input" type="text" name="furniture[type]" id="furniture-type" value="<?= $catalogitez['type'] ?>"><span class="help">s = mobis au sol, i = mobis au mur</span><span class="icon is-small is-left" style="display:none"><i class="fa fa-"></i></span></p>
    <p class="control ">
        <label for="furniture-width">Taille de la largeur du mobis</label>
        <input class="input" type="text" name="furniture[width]" id="furniture-width" value="<?= $catalogitez['width'] ?>"><span class="help"></span><span class="icon is-small is-left" style="display:"><i class="fa fa-"></i></span></p>
    <p class="control ">
        <label for="furniture-length">Taille de la longeur du mobis</label>
        <input class="input" type="text" name="furniture[length]" id="furniture-length" value="<?= $catalogitez['length'] ?>"><span class="help"></span><span class="icon is-small is-left" style="display:"><i class="fa fa-"></i></span></p>
    <p class="control ">
        <label for="furniture-stack-height">Hauteur du mobis empilé</label>
        <input class="input" type="text" name="furniture[stack_height]" id="furniture-stack-height" value="<?= $catalogitez['stack_height'] ?>"><span class="help">Définit la hauteur ou ce positionnera le mobis qu'on souhaite empiler sur celui-ci</span><span class="icon is-small is-left" style="display:none"><i class="fa fa-"></i></span></p>
 <p class="control ">
        <label for="furniture-interaction-type">Type d'interaction</label>
        <input class="input" type="text" name="furniture[interaction_type]" id="furniture-interaction-type" value="<?= $catalogitez['interaction_type'] ?>"><span class="help">default = par défaut, teleport = mobis téléporteur, bed = lit</span><span class="icon is-small is-left" style="display:none"><i class="fa fa-"></i></span></p>
    <p class="control ">
        <label for="furniture-interaction-modes-count">Nombre d'états du mobis</label>
        <input class="input" type="text" name="furniture[interaction_modes_count]" id="furniture-interaction-modes-count" value="<?= $catalogitez['interaction_modes_count'] ?>"><span class="help">Nombre des différents états du mobis en double cliquant dessus. (Ex: une porte de bar mode = 2 (ouvert/fermé)</span><span class="icon is-small is-left" style="display:none"><i class="fa fa-"></i></span></p>
    <p class="control ">
        <label for="furniture-vending-ids">ID des items à consommer</label>
        <input class="input" type="text" name="furniture[vending_ids]" id="furniture-vending-ids" value="<?= $catalogitez['vending_ids'] ?>"><span class="help">Exemple: 1,2,3)</span><span class="icon is-small is-left" style="display:none"><i class="fa fa-"></i></span></p>
    <p class="control ">
        <label for="furniture-effect-id">ID de l'effet</label>
        <input class="input" type="text" name="furniture[effect_id]" id="furniture-effect-id" value="<?= $catalogitez['effect_id'] ?>"><span class="help">Si le mobis est de type effect, attribuez lui un enable.</span><span class="icon is-small is-left" style="display:none"><i class="fa fa-"></i></span></p>
    <p class="control ">
        <label for="furniture-can-stack">Autorise l'empilement sur ce mobis</label>
        <input class="input" type="text" name="furniture[can_stack]" id="furniture-can-stack" value="<?= $catalogitez['can_stack'] ?>"><span class="help"></span><span class="icon is-small is-left" style="display:"><i class="fa fa-"></i></span></p>
    <p class="control ">
        <label for="furniture-can-sit">Pouvoir s'asseoir sur ce mobis</label>
        <input class="input" type="text" name="furniture[can_sit]" id="furniture-can-sit" value="<?= $catalogitez['can_sit'] ?>"><span class="help"></span><span class="icon is-small is-left" style="display:"><i class="fa fa-"></i></span></p>
    <p class="control ">
        <label for="furniture-is-walkable">Pouvoir marcher sur ce mobis</label>
        <input class="input" type="text" name="furniture[is_walkable]" id="furniture-is-walkable" value="<?= $catalogitez['is_walkable'] ?>"><span class="help"></span><span class="icon is-small is-left" style="display:"><i class="fa fa-"></i></span></p>
    <p class="control ">
        <label for="furniture-allow-trade">Autoriser l'échange de ce mobis</label>
        <input class="input" type="text" name="furniture[allow_trade]" id="furniture-allow-trade" value="<?= $catalogitez['allow_trade'] ?>"><span class="help"></span><span class="icon is-small is-left" style="display:"><i class="fa fa-"></i></span></p>
    <p class="control ">
        <label for="furniture-allow-gift">Autoriser l'envoi de ce mobis en cadeaux</label>
        <input class="input" type="text" name="furniture[allow_gift]" id="furniture-allow-gift" value="<?= $catalogitez['allow_gift'] ?>"><span class="help"></span><span class="icon is-small is-left" style="display:"><i class="fa fa-"></i></span></p>
    <div class="submit">
        <input type="submit" id="editfurni" class="button is-primary" value="Modifier">
    </div>
</form>
</div>

<script type="text/javascript">
        $("#editfurni").on('click', function(event){
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "ajax/ajax_updatefurniture.php",
            data: "id="+$("#id").val()+"&catalog_name="+$("#catalog-name").val()+"&page_id="+$("#page-id").val()+"&cost_creditse="+$("#cost-creditse").val()+"&cost_points="+$("#cost-points").val()+"&amount="+$("#amount").val()+"&limited_sells="+$("#limited-sells").val()+"&limited_stack="+$("#limited-stack").val()+"&furniture_type="+$("#furniture-type").val()+"&furniture_width="+$("#furniture-width").val()+"&furniture_length="+$("#furniture-length").val()+"&furniture_stackheight="+$("#furniture-stack-height").val()+"&furniture_interactiontype="+$("#furniture-interaction-type").val()+"&furniture_modescount="+$("#furniture-interaction-modes-count").val()+"&furniture_vendingids="+$("#furniture-vending-ids").val()+"&furniture_effectid="+$("#furniture-effect-id").val()+"&furniture_canstack="+$("#furniture-can-stack").val()+"&furniture_cansit="+$("#furniture-can-sit").val()+"&furniture_iswalkable="+$("#furniture-is-walkable").val()+"&furniture_allowtrade="+$("#furniture-allow-trade").val()+"&furniture_allowgift="+$("#furniture-allow-gift").val(),
            success: function(msg){
                if(msg == "ok") {
                  $("#error-login-content").html('<div id="success-message"><span> Le mobi vient d\'être modifié :) </span></div>').effect('bounce','slow')
                }else {
                $("#error-login-content").html('<div id="error-message"><span> '+ msg +' </span></div>').effect('bounce','slow')
                }
            }
        });
    });
</script>