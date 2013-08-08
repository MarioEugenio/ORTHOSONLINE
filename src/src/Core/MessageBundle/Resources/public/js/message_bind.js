$(document).ready(function () {
    $('[rel="tooltip"]').tooltip();
    $('.dropdown-search-toggle').dropdown();
    $('.dropdown-menu input, .dropdown-menu label').click(function (e) {
        e.stopPropagation();
    });

    $('.datepicker-input').datepicker({format:'dd/mm/yyyy', language:$("#locale").val(), autoclose:true});
    $(document).on('click', '.input-append.date .add-on', function () {
        var $input = $(this).closest('.input-append').find('.datepicker-input');
        $input.focus();
    });
    angular.bootstrap(angular.element("#jMessageList"), ["Locale", "XysWidgets", "XysUI"]);
    angular.bootstrap(angular.element("#jMessageTest"), ["Locale", "XysWidgets", "XysUI"]);
});