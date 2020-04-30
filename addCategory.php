<style type="text/css">#error-message{z-index:1000;font-weight:700;background-color:#c00;height:35px;text-align:center;width:100%}#error-message span{height:35px;color:#fff;display:inline-block;font-weight:700;line-height:35px;vertical-align:middle}#error-message b{font-size:16px;font-weight:700}
#success-message{z-index:1000;font-weight:700;background-color:#00cc35;height:35px;text-align:center;width:100%}#success-message span{height:35px;color:#fff;display:inline-block;font-weight:700;line-height:35px;vertical-align:middle}#success-message b{font-size:16px;font-weight:700}
</style>
<div id="error-login-content"></div>

<form method="post" accept-charset="utf-8">
    <div style="display:none;">
        <input class="input" type="hidden" name="_method" value="POST">
    </div>
    <p class="control ">
        <label for="caption">Nom de la catégorie</label>
        <input class="input" type="text" name="caption" maxlength="35" id="caption"><span class="help"></span><span class="icon is-small is-left" style="display:"><i class="fa fa-"></i></span></p>
    <p class="control ">
        <label for="parent-id">Id de la catégorie parente (-1 = navigation)</label>
        <input class="input" type="text" name="parent_id" id="parent-id" value="-1"><span class="help"></span><span class="icon is-small is-left" style="display:"><i class="fa fa-"></i></span></p>
    <p class="control ">
        <label for="min-rank">Rang minimum</label>
        <input class="input" type="number" name="min_rank" id="min-rank" value="1"><span class="help"></span><span class="icon is-small is-left" style="display:"><i class="fa fa-"></i></span></p>
    <div class="submit">
        <input type="submit" id="addcategory" class="button is-primary" value="Créér">
    </div>
</form>

<script type="text/javascript">
        $("#addcategory").on('click', function(event){
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "<?= $url; ?>ajax/ajax_addcategory.php",
            data: "caption="+$("#caption").val()+"&parent_id="+$("#parent-id").val()+"&min_rank="+$("#min-rank").val(),
            success: function(msg){
                if(msg == "ok") {
                  $("#error-login-content").html('<div id="success-message"><span> La catégorie vient d\'être ajoutée :) </span></div>').effect('bounce','slow')
                }else {
                $("#error-login-content").html('<div id="error-message"><span> '+ msg +' </span></div>').effect('bounce','slow')
                }
            }
        });
    });
</script>