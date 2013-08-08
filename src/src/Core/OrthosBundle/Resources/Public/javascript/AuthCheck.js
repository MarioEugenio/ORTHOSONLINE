/**
 * AuthCheck: componente que verifica erros de requisições XHR, mostrando uma
 * mensagem para o usuário caso ocorra uma falha de autenticação com a sessão.
 */
(function($, angular, undefined) {
"use strict";

// reciclando o status 418 para indicar nossos erros de autenticação
var STATUS_SESSION_ERROR = 418;

/**
 * @ngdoc service
 * @description
 * Módulo para verificação de requisições via AngularJS
 */
var AuthCheck = angular.module("AuthCheck", []);

AuthCheck.config(["$httpProvider", function($httpProvider) {
    $httpProvider.responseInterceptors.push("authCheckHttpInterceptor");
}]);

/**
 * @ngdoc service
 * @description
 * Serviço que intercepta as requisições feitas via $http, do AngularJS, e
 * verifica se houve um problema com a sessão.
 */
AuthCheck.factory("authCheckHttpInterceptor", ["$q", function($q) {
    return function(promise) {
        return promise.then(function(response) {
            // nenhuma operação em caso de sucesso
            return response;
        }, function(response) {
            if (response.status == STATUS_SESSION_ERROR) {
                showLoginMessage();
            }
            return $q.reject(response);
        });
    };
}]);


// verificador de erros XHR via jQuery
$(document).ajaxError(function(event, xhr, settings, thrownError) {
    if (xhr.status == STATUS_SESSION_ERROR) {
        showLoginMessage();
    }
});



/**
 * Bloqueia a tela e solicita que o usuário efetue login novamente.
 */
function showLoginMessage() {
    $(":focus").blur();
    noty({
        text: ExposeTranslation.get("layouts.session_error.message"),
        layout: "center",
        modal: true,
        dismissQueue: false,
        buttons: [
            {
                text: ExposeTranslation.get("layouts.session_error.confirm"),
                addClass: "btn btn-primary",
                onClick: function() {
                    location.href = Routing.generate("CoreLayouts_Login_index");
                }
            }
        ]
    });
}


})(jQuery, angular);
