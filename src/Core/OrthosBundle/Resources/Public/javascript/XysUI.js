(function($, angular, undefined) {
"use strict";


/**
 * Módulo angular.js contendo abstrações simples para uso do jQuery UI.
 */
var XysUI = angular.module("XysUI", ["Locale"]);

/**
 * @ngdoc directive
 *
 * @description
 * Diretiva para ordenação simples de itens: não tem suporte a recursos de mover itens
 * para outro elemento.
 *
 * Para mais informações, consulte a documentação do Sortable no jQuery UI:
 *   http://jqueryui.com/demos/sortable/
 *
 * @element ANY
 * @param {function()=} sortUpdate
 *    Evento invocado quando o usuário termina de mover um item na lista. Nenhuma alteração
 *    visual é efetivada; você deve mover os dados no seu model apropriadamente.
 *    - event: o evento original do browser
 *    - ui: detalhes específicos do evento de ordenação (ver Sortable)
 *
 * Os seguintes parâmetros são passados diretamente para o $.fn.sortable():
 *
 *   * `sortAxis`
 *   * `sortContainment`
 *   * `sortHandle`
 *   * `sortItems`
 *   * `sortPlaceholder`
 */
XysUI.directive("xysSortableSimple", function() {
    /**
     * Retorna a lista de itens ordenáveis dentro do container dado.
     * @param {jQuery} $sortable Elemento com $().sortable
     */
    function getSortableItems($sortable) {
        return $sortable.find($sortable.sortable("option", "items"));
    }

    return function(scope, element, attrs) {
        var sortUpdateHandler = attrs.sortUpdate;

        element.sortable({
            axis: attrs.sortAxis,
            containment: attrs.sortContainment,
            handle: attrs.sortHandle,
            items: attrs.sortItems,
            placeholder: attrs.sortPlaceholder
        });
        element.bind("sortstart", function(event, ui) {
            event.stopPropagation();
            var $target = ui.item;
            var oldIndex = getSortableItems(element).index($target);
            $target.data("xys-sortable-index", oldIndex);
        });
        element.bind("sortupdate", function(event, ui) {
            event.stopPropagation();
            var $target = ui.item;
            var oldIndex = $target.data("xys-sortable-index");
            var newIndex = getSortableItems(element).index($target);
            // desfazer as alterações (deixar o angular tratar isso)
            element.sortable("cancel");
            if (sortUpdateHandler) {
                scope.$apply(function(scope) {
                    scope.$eval(sortUpdateHandler)(event, ui, oldIndex, newIndex);
                });
            }
        });
    };
});


/**
 * @ngdoc directive
 *
 * @description
 * Alterna a visibilidade do elemento de maneira semelhante ao ngShow, mas usando
 * os efeitos `slideUp` e `slideDown` do jQuery.
 *
 * @element ANY
 * @param {expression} xysShowAnimated Expressão avaliada: se for verdadeira, o elemento
 *     fica visível; se for falsa, é oculto.
 * @param {string} [slideSpeed] Velocidade da animação, no padrão do jQuery
 */
XysUI.directive("xysShowAnimated", function() {
    return function(scope, element, attrs) {
        scope.$watch(attrs.xysShowAnimated, function(newValue, oldValue) {
            if (newValue === oldValue) {  // inicialização
                element.toggle(!!newValue);
            } else if (newValue) {
                element.slideDown(attrs.slideSpeed);
            } else {
                element.slideUp(attrs.slideSpeed);
            }
        });
    };
});



XysUI.directive("xysTipsy", function() {
    return function(scope, element, attrs) {
        element.tipsy();
        scope.$on("$destroy", function() {
            element.tipsy("hide");
        });
    };
});


// adaptado de: https://gist.github.com/3135128
XysUI.directive("xysDate", ["Locale", function(Locale) {
    return {
        require: '?ngModel',
        restrict: 'A',
        link: function($scope, element, attrs, controller) {
            var baseOptions = {
                format: 'dd/mm/yyyy',
                language: Locale.current,
                autoclose: true
            };

            var updateModel;
            updateModel = function(ev) {
                element.datepicker('hide');
                element.blur();
                return $scope.$apply(function() {
                    return controller.$setViewValue(ev.date);
                });
            };
            if (controller != null) {
                controller.$render = function() {
                    element.datepicker(baseOptions).data().datepicker.date = controller.$viewValue;
                    if (controller.$viewValue) {
                        element.datepicker('setValue');
                        element.datepicker('update');
                    }
                    return controller.$viewValue;
                };
            }
            return $scope.$watch(attrs.xysDate, function(value) {
                var options = angular.copy(baseOptions);

                if (angular.isObject(value)) {
                    angular.extend(options, value);
                }

                return element.datepicker(options).on('changeDate', updateModel);
            }, true);
        }
    };
}]);


})(jQuery, angular);
