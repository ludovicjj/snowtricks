$('#exampleModal').on('shown.bs.modal', function (e) {
    var btn = $(e.relatedTarget);
    var url = btn.attr('data-href');
    var modal = $(this);
    modal.find('.modal-body').load(url);
});


$(document).on('submit', 'form', function(e){
    e.preventDefault();

    $form = $(e.target);
    modal = $('#exampleModal');
    var $submitButton = $form.find(':submit');
    $submitButton.html('<i class="fas fa-spinner fa-pulse"></i>');

    $submitButton.prop('disabled', true);
    // ajaxSubmit du plugin ajaxForm nécessaire pour l'upload de fichier
    $form.ajaxSubmit({
        type: 'post',
        success: function(data, textStatus, jqxhr) {
            if (jqxhr.status === 200) {
                modal.modal('toggle');
                location.reload();
            } else {
                modal.find('.modal-body').html(data);
            }
        },
        error: function(jqXHR, status, error) {
            $submitButton.html(button.data('label'));
            $submitButton.prop('disabled', false);
        }
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
