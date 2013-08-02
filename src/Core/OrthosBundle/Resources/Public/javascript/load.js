var Load = {
    execute: function (container, url, params, callback) {
        $(container).load(
            url
            ,params
            ,callback
        ).error(function () {
                Modal.growl('Ocorreu um erro inesperado, conteto o administrador da rede', 'erro')
                Loading.hideAll();
            });
    },
    simple: function (container, url) {
        e = $(container);
        scope = angular.element(e).scope();
        scope.templateMenu = url;

    },
    redirect: function (url) {
        window.location = url;
    }
};