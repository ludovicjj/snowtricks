let $wrapper = $('.wrapper');
$(document).ready(function() {

    addForm();
    // Supprime le premier champs pour feinter le form_rest
    // et regle le probleme du manque d'imput type file non incrémenté
    // Avec un <input type="file" id="add_trick_image_1_file">
    let first = $(".image-container").attr("class");
    if (first.indexOf("image-container") > -1 && $(".image-container").find("input").length === 0) {
        $(".image-container").remove();
        var prototype = $wrapper.data('prototype');
        var index = $wrapper.data('index');
        var newForm = prototype.replace(/__name__/g, index);
        $wrapper.data('index', index + 1);
        $('.js-genus-scientist-add').after(newForm);
    }
});

function addForm() {

    $wrapper.on('click', '.js-genus-scientist-add', function(e) {
        e.preventDefault();
        // Get the data-prototype explained earlier
        let prototype = $wrapper.data('prototype');
        // get the new index
        let index = $wrapper.data('index');
        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        let newForm = prototype.replace(/__name__/g, index);
        // increase the index with one for the next item
        $wrapper.data('index', index + 1);
        // Display the form in the page before the "new" link
        $(this).after(newForm);
    });
}

/* Evenemnt clic pour supprimer un form */
$(document).on('click', '.fa-trash', function(e) {
    e.preventDefault();
    let deleteForm = $(this).closest($(".image-container"));
    deleteForm.remove();
});


/* Mise à jour  de l'image dans le label */
$(document).on("change", ":input[type=file]", function () {
    let input = this;

    if (input.files && input.files[0]) {
        var reader = new FileReader();
    }
    reader.onload = function (e) {
        $(input.closest(".image-reader")).find("label img").attr("src", e.target.result);
    };
    reader.readAsDataURL(input.files[0]);
});










