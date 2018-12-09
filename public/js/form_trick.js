let imageContainer = $(".image-container");

function iconeDisplay(container) {
    let wrapper = container.parent(".wrapper");

    // Désactive l'icone supprimer pour le premier champs
    wrapper.find(".fa-plus-square").hide().first().show();

    // Active l'icone ajouter pour le premier champs
    wrapper.find(".fa-trash").show().first().hide();
}

function getContainers(actionIcon) {
    // Recupere la class du parent des <i> "image-action"
    let parent = $(actionIcon).parent().attr("class");

    if (parent.indexOf("image-action") > -1){
        // Return <div class="image-container">
        return $(actionIcon).closest($(".image-container"));

    }
}

/**
 * Supprime le premier element $(".image-container")
 * Genere un nouveau element $(".image-container")
 * Avec un <input type="file" id="add_trick_image_1_file">
 */
function fixFirstImage(container){
    let image = container.attr("class");

    let updateFistImage = function (container) {
        addContainer(container);
        container.remove();
    };

    if (image.indexOf("image-container") > -1 && container.find("input").length === 0) {
        updateFistImage(container);
    }
}

/**
 * Modification de hauteur du container des images
 */
function pictureContainerHeight() {
    let imgHeight = [];
    let addPicture = $(".image-container");

    addPicture.each(function () {
        imgHeight.push($(this).height());
    });

    let maxHeight = Math.max.apply(Math, imgHeight);

    addPicture.each(function () {
        $(this).height(maxHeight);
    });
}



/**
 * Rajoute image container
 */
function addContainer (container) {
    let wrapper = container.closest(".wrapper");
    let prototype = wrapper.data("prototype");
    let index = wrapper.data("index");

    prototype = prototype.replace(/__name__/g, index);
    wrapper.data("index", index + 1);

    wrapper.prepend(prototype);
    iconeDisplay(container);
}

/**
 * Evenement clic pour supprimer une image
 */
$(document).on("click", ".fa-trash", function (e) {
    e.preventDefault();

    let container = getContainers(this);
    let containers = container.parent(".wrapper").children();

    $(container).remove();
    iconeDisplay(containers);
});


/**
 * Mise à jour de l'aperçu de l'image
 */
$(document).on("change", ":input[type=file]", function () {
    let input = this;

    if (input.files && input.files[0]) {
        var reader = new FileReader();
    }
    reader.onload = function (e) {

        $(input.closest(".image-reader")).find("label img")
            .attr("src", e.target.result);
    };
    reader.readAsDataURL(input.files[0]);
    pictureContainerHeight();

    let hiddenInput = $(input).closest(".input-file").find("input[type=hidden]");
    if (hiddenInput) {
        hiddenInput.val(false);
    }
});


/**
 * Evenement clic pour rajouter une image
 */
$(document).on("click", ".fa-plus-square", function (e) {
    e.preventDefault();

    let container = getContainers(this);
    addContainer(container);
    pictureContainerHeight();
});


/**
 * Au chargement de la page
 */
$(document).ready(function() {
    pictureContainerHeight();
    iconeDisplay(imageContainer);
    fixFirstImage(imageContainer);
});