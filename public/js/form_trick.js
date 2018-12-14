let $wrapper = $('.wrapper');
let $collectionHolder;
let $linkVideo;

$(document).ready(function() {
    let $collectionHolder = $('.wrapper-video');
    let $linkVideo = $('.video-add');
    if ($collectionHolder.find(':input').length === 0) {
        addVideo($collectionHolder, $linkVideo);
    }

    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $linkVideo.on('click', function(e){
        e.preventDefault();
        addVideo($collectionHolder, $linkVideo);
    });


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

function addVideo($collectionHolder, $linkVideo) {
    var prototype = $collectionHolder.data('prototype');
    var index = $collectionHolder.data('index');
    var newForm = prototype;
    newForm = newForm.replace(/__name__label/g, index).replace(/__name__/g, index);
    $collectionHolder.data('index', index + 1);
    $linkVideo.next().append(newForm);
}



// Evenemnt click pour ajouter un form video
/*
$(document).on('click', '.video-add', function(e) {
    e.preventDefault();

    let collectionHolder = $('.wrapper-video');
    let indexVideo = wrapperVideo.data('index');
    let prototypeVideo = wrapperVideo.data('prototype');

    let newFormVideo = prototypeVideo
        .replace(/__name__label__/g, indexVideo)
        .replace(/__name__/g, indexVideo);

    wrapperVideo.data('index', indexVideo + 1);

    $(this).next().append(newFormVideo);


    let containerVideo = $wrapperVideo.data('prototype');
    let indexVideo = $wrapperVideo.data('index');
    containerVideo.attr('data-prototype').replace(/__name__label__/g, 'Catégorie n°' + (indexVideo+1));
    let newFormVideo = containerVideo.replace(/__name__/g, indexVideo);
    //Incrémantation
    $wrapperVideo.data('index', indexVideo + 1);
    $(this).next().append(newFormVideo).append(/__name__label__url/g, 'Catégorie n°' + (indexVideo +1));

});
*/

// Evenemnt click pour ajouter un form image
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