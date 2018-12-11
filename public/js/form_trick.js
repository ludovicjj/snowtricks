let $wrapper = $('.wrapper');
$(document).ready(function() {
    // Supprime le premier champs pour feinter le form_rest
    // et regle le probleme du manque d'imput type file non incrémenté

    let $containerImage = $(".image-container");
    let first = $containerImage.attr("class");
    if (first.indexOf("image-container") > -1 && $containerImage.find("input").length === 0) {
        $containerImage.remove();
        var prototype = $wrapper.data('prototype');
        var index = $wrapper.data('index');
        var newForm = prototype.replace(/__name__/g, index);
        $wrapper.data('index', index + 1);
        $('.js-genus-scientist-add').after(newForm);
    }
});

// Evenemnt click pour ajouter un form
$(document).on('click', '.js-genus-scientist-add', function(e) {
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

/* Evenemnt click pour supprimer un form */
$(document).on('click', '.fa-trash', function(e) {
    e.preventDefault();
    let deleteForm = $(this).closest($(".image-container"));
    deleteForm.remove();
});

/* Evement click pour supprimer les image via Ajax */
$(document).ready(function() {
    $('.link-ajax').click(function(event) {
        event.preventDefault();
        var url = $(event.currentTarget).attr('data-url');
        $.ajax({
            url: url,
            type: 'DELETE',
            dataType: 'JSON',
            success: function (response, statusCode, xhr) {
                let $messageDelete = $('.image-delete-message');
                $messageDelete.text(response.message);
                $messageDelete.show("slow").delay(4000).hide("slow");
                console.log(response);
                console.log(xhr);
            }
        });

        let deleteImage = $(this).closest($(".image-upload"));
        deleteImage.remove();
    });
});

/* Mise à jour de l'image dans le label */
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