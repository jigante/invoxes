// angular.module('myApp', []).config(function($interpolateProvider){
//         $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
//     }
// );

var myApp = angular.module('myApp', [], function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

var userSettings = {
    // ajaxSet : null,

    setUserSetting: function(element, value) {
        var ajaxSet;

        if (ajaxSet) {
            ajaxSet.abort();
        }

        url = Routing.generate('set_ajax_user_setting', {
            settingName: element.data('setting-name'),
            settingValue: value
        });
        ajaxSet = $.ajax(url, {
            complete: function(result) {
                ajaxSet = null;
            }
        });
    }
};

var pageTips = {
    init: function() {
        this.hideTips();
        this.showTips();
    },

    hideTips: function () {
        $('[data-dismiss="tips"]').on('click', function (e) {
            e.preventDefault();

            tips = $(this).parent();
            tips.hide();
            $('[data-show="tips"]').show('highlight');

            // Set the user setting via Ajax
            // The tips setting are "disable" user settings
            // and has to be 1 to hide/disable and 0 to show/enable
            userSettings.setUserSetting(tips, 1);
        });
    },

    showTips: function () {
        $('[data-show="tips"]').on('click', function (e) {
            e.preventDefault();

            tips = $(this).next();
            tips.show();
            $(this).hide();

            // Set the user setting via Ajax
            // The tips setting are "disable" user settings
            // and has to be 1 to hide/disable and 0 to show/enable
            userSettings.setUserSetting(tips, 0);
        });
    }
};

var links = {
    init: function() {
        this.submitByHrefMethod();
        this.confirmByMconfirmHeader();
        this.showHiddenDiv();
        this.focusField();
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

    showHiddenDiv: function () {
        $('[data-show-div]').on('click', function (e) {
            e.preventDefault();
            var link = $(this);
            showDiv = link.data('show-div');
            $('#'+showDiv).show();
        });
    },

    focusField: function() {
         $('[data-focus-field]').on('click', function (e) {
            e.preventDefault();
            var link = $(this);
            focusField = link.data('focus-field');
            $('#'+focusField).focus();
        });
    }

};

$(document).ready(function() {
    links.init();
    pageTips.init();

    // $(".alert").alert();
});
