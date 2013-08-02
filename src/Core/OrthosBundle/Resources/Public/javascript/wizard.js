$(document).ready(function () {

    var telaHeight = $(window).height();
    telaHeight = telaHeight - 140;
    $('#J-wizzard-indicator').css('height', telaHeight);
    $(window).resize(function () {
        var telaHeight = $(window).height();
        telaHeight = telaHeight - 140;
        $('#J-wizzard-indicator').css('height', telaHeight);
    });

});

var Wizard = {
    navigation: function (obj,classe)
    {
        switch(classe){
            case 'ball-line-left':
                $('.ball-line-center1-white').removeClass('ball-line-center1-white').addClass('ball-line-center1');
                $('.ball-line-center2-white').removeClass('ball-line-center2-white').addClass('ball-line-center2');
                $('.ball-line-center3-white').removeClass('ball-line-center3-white').addClass('ball-line-center3');
                $('.ball-line-right-white').removeClass('ball-line-right-white').addClass('ball-line-right');
                $(obj).removeClass('ball-line-left').addClass('ball-line-left-white');
                break;
            case 'ball-line-center1':
                $('.ball-line-left-white').removeClass('ball-line-left-white').addClass('ball-line-left');
                $('.ball-line-center1-white').removeClass('ball-line-center1-white').addClass('ball-line-center1');
                $('.ball-line-center2-white').removeClass('ball-line-center2-white').addClass('ball-line-center2');
                $('.ball-line-center3-white').removeClass('ball-line-center3-white').addClass('ball-line-center3');
                $('.ball-line-right-white').removeClass('ball-line-right-white').addClass('ball-line-right');
                $(obj).removeClass('ball-line-center1').addClass('ball-line-center1-white');
                break;
            case 'ball-line-center2':
                $('.ball-line-left-white').removeClass('ball-line-left-white').addClass('ball-line-left');
                $('.ball-line-center1-white').removeClass('ball-line-center1-white').addClass('ball-line-center1');
                $('.ball-line-center3-white').removeClass('ball-line-center3-white').addClass('ball-line-center3');
                $('.ball-line-right-white').removeClass('ball-line-right-white').addClass('ball-line-right');
                $(obj).removeClass('ball-line-center2').addClass('ball-line-center2-white');
                break;
            case 'ball-line-center3':
                $('.ball-line-left-white').removeClass('ball-line-left-white').addClass('ball-line-left');
                $('.ball-line-center1-white').removeClass('ball-line-center1-white').addClass('ball-line-center1');
                $('.ball-line-center2-white').removeClass('ball-line-center2-white').addClass('ball-line-center2');
                $('.ball-line-right-white').removeClass('ball-line-right-white').addClass('ball-line-right');
                $(obj).removeClass('ball-line-center3').addClass('ball-line-center3-white');
                break;
            case 'ball-line-right':
                $('.ball-line-left-white').removeClass('ball-line-left-white').addClass('ball-line-left');
                $('.ball-line-center1-white').removeClass('ball-line-center1-white').addClass('ball-line-center1');
                $('.ball-line-center2-white').removeClass('ball-line-center2-white').addClass('ball-line-center2');
                $('.ball-line-center3-white').removeClass('ball-line-center3-white').addClass('ball-line-center3');
                $(obj).removeClass('ball-line-right').addClass('ball-line-right-white');
                break;
            default:
                //alert('teste');
        }
    },
    inicialize: function (route)
    {
        Load.simple('#wizard-container', Routing.generate(route));
    },
    inicializeNav: function (idForm)
    {
        $('#nav-next').click(function () {
            if (idForm) {
                Wizard.save(idForm);
            } else {
                Wizard.next(idForm);
            }
        });

        $('#nav-prev').click(function () {
            Wizard.prev(idForm);
        });
    },
    prev: function (idForm)
    {
        $('.blurExec').unbind('blur');

        var prev = $('#route-prev').val();
        var nav = $('a[rel="' + prev + '"]').parent('div');

        var classe = $(nav).attr('class');

        Wizard.navigation(nav, classe.substr(42));


        Load.simple('#wizard-container', Routing.generate(prev, {'form': $(idForm+' input[type=hidden]').serialize()}));
    },
    next: function (idForm)
    {
        $('.blurExec').unbind('blur');

        var next = $('#route-next').val();
        var nav = $('a[rel="' + next + '"]').parent('div');

        var classe = $(nav).attr('class');

        Wizard.navigation(nav, classe.substr(42));

        Load.simple('.nav-container', Routing.generate(next, {'form': $(idForm+' input[type=hidden]').serialize()}));
    },
    save: function (idForm)
    {
        $('.blurExec').unbind('blur');

        var callback = function (response) {
            Form.inicializeValidate('#form-wizard', response, 'growl-message');
            Loading.hideAll();

            if (response.success) {
                Wizard.next(idForm);
            }
        };

        var multiValue = '';
        if ($('.formOption').length > 0) {
            multiValue = Form.getValArrayInput('.formOption');
        }

        Form.submitSerialize(Routing.generate($('#route').val()), idForm, callback, 'JSON', multiValue);
    }
};