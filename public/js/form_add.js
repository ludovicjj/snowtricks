$(document).ready(function(){
    let $imageWrapper = $('.wrapper-image');
    let $videoWrapper = $('.wrapper-video');

    /* -------------------------- Video -------------------------- */

    /* Evenement click pour ajouter un form Video */
    $(document).on('click', '.video-add', function(e) {
        e.preventDefault();
        let prototype = $videoWrapper.data('prototype');
        let index = $videoWrapper.data('index');
        let newFormVideo = prototype.replace(/__name__/g, index);
        $videoWrapper.data('index' , index + 1);
        $(this).parent().after(newFormVideo);
    });

    /* Evenemnt click pour supprimer un Form Video */
    $(document).on('click', '.remove-video', function(e) {
        e.preventDefault();
        let videoContainer = $(this).closest($(".video-container"));
        videoContainer.remove();
    });

    /* -------------------------- Image -------------------------- */

    /* Evenemnt click pour ajouter un form image */
    $(document).on('click', '.image-add', function(e) {
        e.preventDefault();
        let prototype = $imageWrapper.data('prototype');
        let index = $imageWrapper.data('index');
        let newFormImage = prototype.replace(/__name__/g, index);
        $imageWrapper.data('index', index + 1);
        $(this).parent().after(newFormImage);
    });

    /* Evenemnt click pour supprimer un form image */
    $(document).on('click', '.remove-image', function(e) {
        e.preventDefault();
        let deleteForm = $(this).closest($(".image-container"));
        deleteForm.remove();
    });

    /* Mise à jour de l'image dans le label */
    $(document).on("change", ":input[type=file]", function (e) {

        let input = e.target;
        if (input.files && input.files[0]) {

            var reader = new FileReader();
        }

        reader.onload = function (e) {
            $(input.closest(".image-reader")).find("label img").attr("src", e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    });

});