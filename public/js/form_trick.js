let $imageWrapper = $('.wrapper-image');
let $videoWrapper = $('.wrapper-video');

/* -------------------------- Video -------------------------- */

// Evenemnt click pour supprimer un Form Video
$(document).on('click', '.remove-video', function(e) {
    e.preventDefault();
    let videoContainer = $(this).closest($(".video-container"));
    videoContainer.remove();
});

// Evenement click pour ajouter un form Video
$(document).on('click', '.video-add', function(e) {
    e.preventDefault();
    let prototype = $videoWrapper.data('prototype');
    let index = $videoWrapper.data('index');
    let newFormVideo = prototype.replace(/__name__/g, index);
    $videoWrapper.data('index' , index + 1);
    $(this).parent().after(newFormVideo);
});


/* -------------------------- Image -------------------------- */

// Evenemnt click pour ajouter un form image
$(document).on('click', '.image-add', function(e) {
    e.preventDefault();
    let prototype = $imageWrapper.data('prototype');
    let index = $imageWrapper.data('index');
    let newFormImage = prototype
        .replace(/__name__/g, index)
        .replace(/__name__label__/g, index)
    ;
    $imageWrapper.data('index', index + 1);
    $(this).parent().after(newFormImage);
});

/* Evenemnt click pour supprimer un form */
$(document).on('click', '.fa-trash', function(e) {
    e.preventDefault();
    let deleteForm = $(this).closest($(".image-container"));
    deleteForm.remove();
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

/* -------------------------- Ajax -------------------------- */

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