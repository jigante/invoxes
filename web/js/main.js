$(document).ready(function() {

    $('a[data-href-method]').on('click', function (e){
        var link = $(this),
        href = link.attr('href'),
        method = link.data('href-method'),
        form = $('<form method="post" action="'+href+'">'),
        metadata_input = '<input name="_method" value="'+method+'" type="hidden" />';

        // if (csrf_param != null && csrf_token != null) {
        //     metadata_input += '<input name="'+csrf_param+'" value="'+csrf_token+'" type="hidden" />';
        // }

        form.hide()
            .append(metadata_input)
            .appendTo('body');

        e.preventDefault();

        confirmMessage = link.data('mconfirm-header');
        
        if (typeof confirmMessage === 'undefined' || confirmMessage === false) {
            confirmMessage = "Are you sure?";
        }

        var confirmResult = confirm(confirmMessage);

        if (confirmResult) {
            form.submit();
        }
    });

});
