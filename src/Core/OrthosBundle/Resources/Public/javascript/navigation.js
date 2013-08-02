var Navigation = {
    button: function () {
        if ($('#nav-back').length > 0) {
            if (!$('#nav-back').val()) {
                $('#prev_view').addClass('disabled');
            } else {
                $('#prev_view').removeClass('disabled').click(function () {
                    var route = $('#nav-back').val();
                    Load.simple('.nav-container', Routing.generate(route));
                });

            }
        }

        if ($('#nav-next').length > 0) {
            if (!$('#nav-next').val()) {
                $('#next_view').addClass('disabled');
            } else {
                $('#next_view').removeClass('disabled').click(function () {
                    var route = $('#nav-next').val();
                    Load.simple('.nav-container', Routing.generate(route));
                });

            }
        }
    }
};