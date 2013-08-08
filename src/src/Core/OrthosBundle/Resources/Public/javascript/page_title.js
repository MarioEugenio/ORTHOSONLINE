(function($, undefined) {
"use strict";

/**
 * Componente que mostra um título deslizante quando a página é alterada.
 */
window.PageTitle = {
    _init: function() {
        /**
         * Título original da página, sempre mostrado quando visitamos uma seção
         * @type {string}
         * @private
         */
        this._baseTitle = document.title;

        this._reposition();

        $(window).resize($.proxy(this, "_reposition"));

        $(document).on("SinglePage.changeSuccess", $.proxy(function() {
            var pageTitle = $("#pageTitle").val();
            if (pageTitle) {
                document.title = pageTitle + " \u2013 " + this._baseTitle;
                this._showTitle(pageTitle);
            } else {
                document.title = this._baseTitle;
            }
        }, this));
        $(document).on("SinglePage.changeError", $.proxy(function() {
            document.title = this._baseTitle;
        }, this));
    },

    /**
     * Reposiciona o título deslizante em proporção às dimensões da tela.
     */
    _reposition: function() {
        var telaWidth = $(window).width();
        $("#j-PageTitle-bar").css("left", (telaWidth / 2) - 310);
    },

    _showTitle: function(title) {
        $("#j-PageTitle-text").text(title);
        $("#j-PageTitle-bar")
            .show()
            .animate({top: "40px"}, 500)
            .delay(4000)
            .animate({top: "0px"}, 500, function() {
                $(this).hide();
            });
    }
};

$(document).ready(function() {
    PageTitle._init();
});

})(jQuery);
