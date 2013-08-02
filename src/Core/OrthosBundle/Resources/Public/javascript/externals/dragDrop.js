$(function () {
    // configura drag and drop
    $(".recebeDrag").sortable({
        connectWith: ['.recebeDrag'],
        placeholder: 'dragHelper',
        scroll: true,
        revert: true,
        stop: function (e, ui) {
            salvaCookie();
        }
    });
    // minimizar boxes
    $('.lnk-minimizar').click(function () {
        var ul = $(this).parent().parent().parent().parent().parent();
        if ($(ul).is(':visible')) {
            $(ul).slideUp();
            $(this).html('[ + ]');
        } else {
            $(ul).slideDown();
            $(this).html('[ - ]');
        }
        return false;
    });
    // remover box
    $('.lnk-remover').click(function () {
        $(this).parent().parent().parent().parent().parent().parent().parent().fadeOut();
        return false;
    });
    // configuração inicial do cookie
    if ($.cookie('df_draganddrop')) {
        var ordem = $.cookie('df_draganddrop').split('|');
        // posiciona boxes nos containers certos
        $('#drop-esquerda div.itemDrag').each(function () {
            if (ordem[0].search($(this).attr('id')) == -1) $('#drop-direita').append($(this));
        });
        $('#drop-direita div.itemDrag').each(function () {
            if (ordem[1].search($(this).attr('id')) == -1) $('#drop-esquerda').append($(this));
        });
        // ordena containers
        var esquerda = ordem[0].split(',');
        for (i = 0; i <= esquerda.length; i++) $('#drop-esquerda').append($('#' + esquerda[i]));
        var direita = ordem[1].split(',');
        for (i = 0; i <= direita.length; i++) $('#drop-direita').append($('#' + direita[i]));
    } else {
        $.cookie('df_draganddrop', '', { expires: 7, path: '/' });
    }
});
// salva cookie
var salvaCookie = function () {
    var ordem = $('#drop-esquerda').sortable('toArray');
    ordem += '|' + $('#drop-direita').sortable('toArray');
    $.cookie('df_draganddrop', ordem);
};