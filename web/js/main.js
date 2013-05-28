var links = {
    init: function() {
        this.submitByHrefMethod();
        this.confirmByMconfirmHeader();
        this.hideTips();
        this.showTips();
    },

    // If there is a link with the data attribute "data-href-method"
    // We build an hidden form to submit the link using the "_method" defined in it
    submitByHrefMethod: function() {
        $('a[data-href-method]').on('click', function (e) {

            var link = $(this),
            href = link.attr('href'),
            method = link.data('href-method'),
            form = $('<form method="post" action="'+href+'">'),
            metadata_input = '<input name="_method" value="'+method+'" type="hidden" />';

            form.hide()
                .append(metadata_input)
                .appendTo('body');

            e.preventDefault();

            confirmMessage = link.data('mconfirm-header');

            if (typeof confirmMessage === 'undefined' || confirmMessage === false) {
                confirmMessage = "Are you sure?";
            }

            if (confirm(confirmMessage)) {
                form.submit();
            }
        });
    },

    confirmByMconfirmHeader: function () {
        $('a[data-mconfirm-header]:not([data-href-method])').on('click', function (e) {
            confirmMessage = $(this).data('mconfirm-header');
            if (typeof confirmMessage === 'undefined' || confirmMessage === false) {
                confirmMessage = "Are you sure?";
            }

            return confirm(confirmMessage);

        });
    },

    hideTips: function () {
        $('[data-dismiss-tips="alert"]').on('click', function (e) {
            tipsShow = $('.tips-show');
            tips = $(this).parent();

            tipsShow.show('highlight');
            tips.hide();
        });
    },

    showTips: function () {
        $('a.tips-show-link').on('click', function (e) {
            tipsShow = $('.tips-show');
            tips = tipsShow.next();

            tipsShow.hide();
            tips.show();
        });
    }
};

$(document).ready(function() {
    links.init();

    // $(".alert").alert();
});
