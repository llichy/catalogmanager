<?php
include "inc.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue Manager</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://raw.githubusercontent.com/SortableJS/Sortable/master/Sortable.js"></script>
</head>
<body>
    <script>
        var hostname = "<?= $url; ?>";
        var modeEditor = false;

        $(document).ready(function() {


            jQuery.fn.single_double_click = function(single_click_callback, double_click_callback, timeout) {
                return this.each(function(){
                    var clicks = 0, self = this;
                    jQuery(this).click(function(event){
                    clicks++;
                    if (clicks == 1) {
                        setTimeout(function(){
                        if(clicks == 1) {
                            single_click_callback.call(self, event);
                        } else {
                            double_click_callback.call(self, event);
                        }
                        clicks = 0;
                        }, timeout || 300);
                    }
                    });
                });
            }

            jQuery.fn.extend({
                animateCss: function (animationName, callback) {
                    var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
                    this.addClass('animated ' + animationName).one(animationEnd, function() {
                        $(this).removeClass('animated ' + animationName);
                        if (callback) {
                        callback();
                        }
                    });
                    return this;
                }
            });

            // Activation des boutons de navigation
            $("#tabs").tabs();

            $("#tabs li").click(function() {
                var navigationId = $(this).attr("navigation-id");
                var elmt = $(this);
                if(modeEditor) {
                    var body = $("body");
                    console.log("Open modal for category " + navigationId);
                    $.get(hostname + "getCategoryById.php", {
                        id: navigationId
                    })
                    .done(function(content) {
                        $(".settings").css("height", body.css('height')).html(content).show();
                        $(".settings form").submit(function(event) {
                            event.preventDefault();
                            var data = {
                                id: $(".settings form #id").val(),
                                parent_id: $(".settings form #parent-id").val(),
                                caption: $(".settings form #caption").val(),
                                type: $(".settings form #type").val(),
                                icon_color: $(".settings form #icon-color").val(),
                                icon_image: $(".settings form #icon-image").val(),
                                visible: $(".settings form #visible").val(),
                                min_rank: $(".settings form #min-rank").val(),
                                vip_only: $(".settings form #vip-only").val(),
                                enabled: $(".settings form #enabled").val(),
                                page_layout: $(".settings form #page-layout").val(),
                                page_images: $(".settings form #page-images").val(),
                                page_texts: $(".settings form #page-texts").val(),
                                extra_data: $(".settings form #extra-data").val(),
                            };

                            $.post(hostname + "editCategoryById.php", {
                                data: data
                            })
                            .done(function(content) {
                                elmt.find('span').html($(".settings form #caption").val());
                                console.debug(content);
                            });
                        });
                    });
                } else {
                    // Clic sur un bouton
                    $.get(hostname + "getAllCategoriesById.php", {
                        id : navigationId
                    })
                    .done(function(content) {
                        $("#items").html("");
                        $("#tabs-" + navigationId).html(content);
                    });
                }
            });

            // Mode éditeur activé / désactivé
            $("#modeEditor").click(function() {
                if($(this).attr("checked")) {
                    modeEditor = false;
                    $(this).removeAttr("checked");
                    $(".settings").hide();
                } else {
                    modeEditor = true;
                    $(".item").removeClass("selected");
                    $(this).attr("checked", "checked");
                }
            });

            // Evènement sur les catégories
            $(document).on('click', 'a.panel-block', function() {
                var elmt = $(this);
                var categoryId = $(this).attr("category-id");
                var caption = $(this).attr("category-caption");

                // Mode editeur
                if(modeEditor) {
                    var body = $("body");
                    console.log("Open modal for category " + categoryId);
                    $.get(hostname + "getCategoryById.php", {
                        id: categoryId
                    })
                    .done(function(content) {
                        $(".settings").css("height", body.css('height')).html(content).show();
                        $(".settings form").submit(function(event) {
                            event.preventDefault();
                            var data = {
                                id: $(".settings form #id").val(),
                                parent_id: $(".settings form #parent-id").val(),
                                caption: $(".settings form #caption").val(),
                                type: $(".settings form #type").val(),
                                icon_color: $(".settings form #icon-color").val(),
                                icon_image: $(".settings form #icon-image").val(),
                                visible: $(".settings form #visible").val(),
                                min_rank: $(".settings form #min-rank").val(),
                                vip_only: $(".settings form #vip-only").val(),
                                enabled: $(".settings form #enabled").val(),
                                page_layout: $(".settings form #page-layout").val(),
                                page_images: $(".settings form #page-images").val(),
                                page_texts: $(".settings form #page-texts").val(),
                                extra_data: $(".settings form #extra-data").val(),
                            };

                            $.post(hostname + "editCategoryById.php", {
                                data: data
                            })
                            .done(function(content) {
                                elmt.attr("category-caption",  $(".settings form #caption").val());
                                elmt.find('span').html($(".settings form #caption").val());
                                elmt.find('img').attr("src", "<?= $swf; ?>c_images/catalogue/icon_" + $(".settings form #icon-image").val() + ".png");
                                console.debug(content);
                            });
                        });
                    });
                }
                // Mode normal
                else {
                    var subCategories = $(".subCategories[category-id=" + categoryId +"]");
                    subCategories.toggle();

                    if($(this).hasClass("is-active")) {
                        $(this).toggleClass("is-active");
                        $("#items-" + categoryId).remove();
                        $("#" + categoryId + " .subCategories a").each(function(index) {
                            var subCategoryId = $(this).attr("category-id");
                            $("#items-" + subCategoryId).remove();
                        });
                    } else {
                        $(this).toggleClass("is-active");

                        $.get(hostname + "getAllSubCategoriesById.php", {
                                id: categoryId
                        })
                        .done(function(content) {
                            if(content == "null") {
                                $.get(hostname + "getAllFurnituresById.php", {
                                    id: categoryId,
                                    caption: caption
                                })
                                .done(function(content) {
                                    $("#items").prepend(content);

                                    $("#items div.item").draggable({
                                        revert: 'invalid',
                                        revertDuration: 0,
                                        start: function(event, ui) {
                                            if(!ui.helper.hasClass("selected") && !modeEditor)
                                                ui.helper.addClass("selected");
                                        },
                                        stop: function(event, ui) {
                                            $('.selected').css({
                                                top: 0,
                                                left: 0
                                            });
                                        },
                                        drag: function(event, ui) {
                                            $('.selected').css({
                                                top: ui.position.top,
                                                left: ui.position.left
                                            });
                                        }
                                    });
                                });
                            } else {
                                subCategories.html(content);
                            }
                        });

                        // Elements droppable
                        $(".droppable").droppable({
                            accept: "#items div.item.selected",
                            classes: {
                                "ui-droppable-hover": "is-hover",
                            },
                            drop: function(event, ui) {
                                var categoryTarget = $(this);
                                $(this).addClass("is-success").animateCss("pulse", function() {
                                    categoryTarget.removeClass("is-success");
                                });

                                var itemsToSave = { };
                                $(".selected").each(function() {
                                    // Sauvegarde du changement de catégorie
                                    if($(this).attr("item-parent") != categoryTarget.attr("category-id")) {
                                        itemsToSave[$(this).attr("item-id")] = categoryTarget.attr("category-id");
                                    }

                                    console.log($(this).attr("item-id"));
                                    $(this).removeClass("selected");

                                    if($(document).find("#items-" + categoryTarget.attr("category-id")).length == 0) {
                                        $(this).fadeOut();
                                    } else {
                                        var listOfItems = $("#items-" + categoryTarget.attr("category-id"));
                                        $(this).css('display', 'inline-block');
                                        $(this).css('left', '0');
                                        $(this).css('top', 0);
                                        listOfItems.append($(this));
                                    }
                                });

                                if($(this).attr("item-parent") != categoryTarget.attr("category-id")) {
                                    $.get(hostname + "saveFurnitureToCategoryId.php", {
                                        items: itemsToSave
                                    })
                                    .done(function(content) {
                                    });
                                }
                            }
                        });
                    }
                }
            });

            // Action sur un item
            $(document).on("click", "#items div.item", function() {
                var itemId = $(this).attr("item-id");
                if(modeEditor) {
                    var body = $("body");
                    $.get(hostname + "getFurnitureById.php", {
                        id: itemId
                    })
                    .done(function(content) {
                        $(".settings").css("height", body.css('height')).html(content).show();
                        $(".settings form").submit(function(event) {
                            event.preventDefault();
                            var data = {
                                id: $(".settings form #id").val(),
                                catalog_name: $(".settings form #catalog-name").val(),
                                page_id: $(".settings form #page-id").val(),
                                cost_credits: $(".settings form #cost-credits").val(),
                                cost_diamonds: $(".settings form #cost-diamonds").val(),
                                cost_pixels: $(".settings form #cost-pixels").val(),
                                amount: $(".settings form #amount").val(),
                                limited_sells: $(".settings form #limited-sells").val(),
                                limited_stack: $(".settings form #limited-stack").val(),
                                furniture: {
                                    id: $(".settings form #furniture-id").val(),
                                    is_rare: $(".settings form #furniture-is-rare").val(),
                                    is_ltd: $(".settings form #furniture-is-ltd").val(),
                                    type: $(".settings form #furniture-type").val(),
                                    width: $(".settings form #furniture-width").val(),
                                    length: $(".settings form #furniture-length").val(),
                                    stack_height: $(".settings form #furniture-stack-height").val(),
                                    variable_heights: $(".settings form #furniture-variable-heights").val(),
                                    interaction_type: $(".settings form #furniture-interaction-type").val(),
                                    interaction_modes_count: $(".settings form #furniture-interaction-modes-count").val(),
                                    vending_ids: $(".settings form #furniture-vending-ids").val(),
                                    effect_id: $(".settings form #furniture-effect-id").val(),
                                    can_stack: $(".settings form #furniture-can-stack").val(),
                                    can_sit: $(".settings form #furniture-can-sit").val(),
                                    is_walkable: $(".settings form #furniture-is-walkable").val(),
                                    allow_trade: $(".settings form #furniture-allow-trade").val(),
                                    allow_gift: $(".settings form #furniture-allow-gift").val()                                }
                            };

                            $.post(hostname + "editFurnitureById.php", {
                                data: data
                            })
                            .done(function(content) {
                            });
                            console.debug(data);
                        });
                    });
                    console.log("Open modal for item " + itemId);
                } else {
                    $(this).toggleClass("selected");
                }
            });

            $(".add-category").click(function() {
                var body = $("body");

                $.get(hostname + "addCategory.php")
                .done(function(content) {
                    $(".settings").html(content).show();
                });
            });
        });
    </script>
   
    <style>
    @import url('https://fonts.googleapis.com/css?family=Ubuntu');
    @import url('https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.0/css/bulma.min.css');
    @import url('https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    @import url('https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css');
    @import url('http://localhost/bulma-tooltip.min.css');
    @import url('http://localhost/bulma-switch.min.css');

    html {
        background: rgb(241, 241, 241);
        font-family: 'Ubuntu';
        margin: 0;
        overflow: auto;
    }

    nav img {
        margin-right: 10px;
    }

    .subCategories {
        padding-left: 30px;
        display: none;
    }

    .item {
        width: 50px;
        height: 50px;
        display: inline-block;
        background: rgb(221, 221, 221);
        margin: 5px;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
    }

    .item img {
        position: absolute;
        width: 30px;
        height: 30px;
    }

    .item.selected {
        background: rgba(255, 201, 14, 0.2);
    }

    .panel-block.is-success {
        border-left-color: #23d160;
        border-right-color: #23d160;
        color: #363636;
    }

    .panel-block.is-hover {
        background: rgba(255, 201, 14, 0.2);
        color: #363636;
    }

    .tabs li.ui-state-active a {
        border-bottom-color: #3273dc;
        color: #3273dc;
    }

    .settings {
        display: none;
        top: 0;
        right: 0;
        width: 400px;
        height: auto;
        min-height: 100%;
        position: absolute;
        background: rgb(235, 235, 235);
        border-left: 1px solid #CCC;
        padding: 10px;
    }
    </style>

    <section class="hero is-info">
        <div class="hero-body">
            <div class="container">
            <h1 class="title">
                Catalogue Manager
            </h1>
            <h2 class="subtitle">
                Gestion du catalogue par interface graphique
            </h2>
            </div>
        </div>
    </section>

    <section style="margin-top: 20px">
        <div class="container">
<div id="tabs">
<section style="margin-top: 20px">
        <div class="container">
            <div class="columns">
                <div class="column is-12">
                    <div class="tabs is-centered">
                        <ul>
                            <?php

$cata = $bdd->prepare('SELECT * FROM catalog_pages WHERE parent_id = ? ORDER by order_num ASC');
$cata->execute(['-1']);
$navigations = $cata->fetchAll();

                            foreach($navigations as $navigation) {
                                echo '<li navigation-id="' . $navigation['id'] . '"><a href="#tabs-' . $navigation['id'] . '"><span>' . $navigation['caption'] .'</span></a></li>';
                            } ?>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="columns">
                <div class="column is-3">
                    <nav class="panel">
                        <p class="panel-heading">
                            Catégories <a style="float: right;" class="button is-small is-success add-category"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        </p>
                        
                        <div style="height: 640px; display: block; overflow-x: visibile; overflow-y: auto;">
                            <?php
                            foreach($navigations as $navigation) {
                                echo '<div id="tabs-' . $navigation['id'] . '"></div>';
                            } ?>
                        </div>                      
                    </nav>
                </div>
                
                <div class="column is-7">
                    <div class="field">
                        <input id="modeEditor" type="checkbox" name="modeEditor" class="switch is-small is-rounded is-rtl">
                        <label for="modeEditor">Mode editeur</label>
                    </div>

                    <div style="height: 640px; width:100%; display: block; overflow-x: visibile; overflow-y: auto;">
                        <div id="items" class="selectable">
                        
                        </div>
                    </div>
                </div>
            </div>

            <!--<div class="columns">
                <div class="column is-12">
                    <div class="field is-grouped is-grouped-centered">
                        <p class="control">
                            <a id="saveTheCatalog" class="button is-success">
                                Sauvegarder le catalogue
                            </a>
                        </p>
                    </div>
                </div>
            </div>-->
        </div>
    </section>
</div>
        </div>
    </section>

    <section class="settings">

    </section>
</body>
</html>



	<script type="text/javascript">
	$(document).ready(function() {

	$("a.has-parent").click(function() {
		$(this).toggleClass("is-active");
		var children = $(this).attr("data-children");
		$("ul[data-children=" + children + "]").toggle();
	});

	// Get currently page
	var currentPage = $("a.is-active").closest("ul");
	$("a.has-parent[data-children=" + currentPage.attr("data-children") + "]").toggleClass("is-active");
	currentPage.show();

	// Random color assign to tile
	var randomColor = ["is-primary", "is-link", "is-info", "is-success", "is-danger", "is-dark"];
	$(".tile.is-child.notification").each(function() {
		var color = randomColor[Math.floor(Math.random() * randomColor.length)];
		//$(this).addClass(color);
	});
});	


	</script>

</body>
</html>
