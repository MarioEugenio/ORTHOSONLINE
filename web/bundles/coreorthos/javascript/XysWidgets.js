(function ($, angular, undefined) {
"use strict";


/**
 * Módulo angular.js contendo diretivas utilitárias para XYS.
 */
var XysWidgets = angular.module("XysWidgets", []);


/**
 * @ngdoc directive
 *
 * @description
 * Garante que a imagem dada não vai exceder as dimensões desejadas, mantendo
 * sua proporção original.
 *
 * @example
   <!-- limitar p/ 50px de largura e altura -->
   <img ng-src="{{exemplo}}" xys-max-size="50">
   <!-- limitar p/ 100px de largura, 50px de altura -->
   <img ng-src="{{exemplo}}" xys-max-size="{width: 100, height: 50}">
   <!-- limite definido pelo escopo -->
   <img ng-src="{{exemplo}}" xys-max-size="limite">
 */
XysWidgets.directive("xysMaxSize", ["$log", function($log) {
    return function(scope, element, attrs) {
        if (element[0].tagName !== "IMG") {
            $log.error("xysMaxSize: deve ser usado em elementos <img> (usado em %o)", element[0]);
            return;
        }

        element.hide();

        var originalWidth, originalHeight;
        var constraint;
        attrs.$observe("src", function(value) {
            if (element[0].complete) {
                imageLoaded();
                return;
            }
            originalWidth = originalHeight = undefined;
            element.hide();
            attrs.$set("width", undefined);
            attrs.$set("height", undefined);
        });
        scope.$watch(attrs.xysMaxSize, function(value) {
            constraint = value;
            updateDimensions();
        }, true);
        element.load(imageLoaded);

        function imageLoaded() {
            originalWidth = element[0].naturalWidth || element.width();
            originalHeight = element[0].naturalHeight || element.height();
            updateDimensions();
        }

        function updateDimensions() {
            // só processar depois que a imagem for carregada
            if (!constraint || !originalWidth) {
                return;
            }

            var maxWidth, maxHeight;
            if (angular.isObject(constraint)) {
                maxWidth = constraint.width;
                maxHeight = constraint.height;
            } else {
                maxWidth = maxHeight = parseInt(constraint, 10);
            }

            if (isNaN(maxWidth) || maxWidth <= 0) {
                $log.error("xysMaxSize: limite de largura %o inválido", maxWidth);
                return;
            }
            if (isNaN(maxHeight) || maxHeight <= 0) {
                $log.error("xysMaxSize: limite de altura %o inválido", maxHeight);
                return;
            }

            var finalWidth, finalHeight;

            if (originalWidth / originalHeight >= maxWidth / maxHeight) {
                // a imagem carregada é mais larga que o espaço
                finalWidth = maxWidth;
                finalHeight = originalHeight * maxWidth / originalWidth;
            } else {
                finalWidth = originalWidth * maxHeight / originalHeight;
                finalHeight = maxHeight;
            }

            attrs.$set("width", finalWidth);
            attrs.$set("height", finalHeight);
            element.show();
        }
    };
}]);


XysWidgets.directive("xysRelativeDate", ['$timeout', function($timeout) {
    return {
        link: function(scope, element, attrs) {
            var localFirstDate = new Date();
            var localFirstYear = localFirstDate.getFullYear();
            var localFirstMonth = localFirstDate.getMonth();
            var localFirstDay = localFirstDate.getDate();

            var localFirstHour = localFirstDate.getHours();
            var localFirstMinute = localFirstDate.getMinutes();

            var analiseTime = function() {
                if (attrs.xysRelativeDate) {
                    var directiveDate = new Date(attrs.xysRelativeDate);

                    if (directiveDate.getFullYear() == localFirstYear && directiveDate.getMonth() == localFirstMonth) {
                        if (directiveDate.getDate() == localFirstDay) {
                            if (directiveDate.getHours() == localFirstHour) {
                                if (directiveDate.getMinutes() == localFirstMinute) {
                                    return "Criado Agora";
                                } else {
                                    var diffMinutes = localFirstMinute - directiveDate.getMinutes();
                                    if (diffMinutes < 0) {
                                        return "Criado Agora";
                                    }
                                    return diffMinutes + " minuto" + (diffMinutes != 1 ? "s" : "") + " atrás";
                                }
                            } else {
                                var diffHours = localFirstHour - directiveDate.getHours();
                                return diffHours + " hora" + (diffHours != 1 ? "s" : "") + " atrás";
                            }
                        } else if (directiveDate.getDate() >= (localFirstDay - 7)) {
                            var diffDays = localFirstDay - directiveDate.getDate();
                            return diffDays + " dia" + (diffDays != 1 ? "s" : "") + " atrás";
                        } else {
                            return directiveDate.getDate() + "/" + (directiveDate.getMonth() + 1) + "/" + directiveDate.getFullYear()
                                + " " + directiveDate.getHours() + ":" + directiveDate.getMinutes() + ":" + directiveDate.getSeconds();
                        }
                    } else {
                        return directiveDate.getDate() + "/" + (directiveDate.getMonth() + 1) + "/" + directiveDate.getFullYear()
                            + " " + directiveDate.getHours() + ":" + directiveDate.getMinutes() + ":" + directiveDate.getSeconds();
                    }
                }
            };

            var characterReplace = function(data) {
                var newData = data.toString();
                if (data.toString().length == 1) {
                    newData = "0" + data.toString();
                }
                return newData;
            };

            var updateTime = function() {
                element.text(analiseTime());
                if (attrs.xysRelativeDate) {
                    var directiveDate = new Date(attrs.xysRelativeDate);

                    $('[rel="tooltip"]').tooltip();
                    $(element).attr('data-original-title', characterReplace(directiveDate.getDate()) + "/" +
                        characterReplace((directiveDate.getMonth() + 1)) + "/"
                        + directiveDate.getFullYear() + " " + characterReplace(directiveDate.getHours()) + ":"
                        + characterReplace(directiveDate.getMinutes()) + ":"
                        + characterReplace(directiveDate.getSeconds()));
                }
                deferId = $timeout(updateTime, 10000);
            };

            var deferId = $timeout(updateTime, 10);

            $(document).on("SinglePage.changeSuccess", function() {
                scope.$on('$destroy', function() {
                    $timeout.cancel(deferId);
                });
            });

            scope.$on('$destroy', function() {
                $timeout.cancel(deferId);
            });
        }
    }
}]);

/**
 * @ngdoc directive
 *
 * @description
 * Diretiva para autocomplete.
 */
XysWidgets.directive("xysAutocomplete", ["$parse", function($parse) {
    return {
        restrict: "EA",
        require: "?ngModel",
        replace: true,
        template: '<input type="text">',
        link: function(scope, element, attrs, ngModelCtrl) {
            var getSelection = $parse(attrs.selection) || angular.noop;
            var setSelection = getSelection.assign || angular.noop;
            var getData = $parse(attrs.data) || angular.noop;
            var setData = getData.assign || angular.noop;

            $(element).keyup(function() {
                if (getSelection() != $(element).val()) {
                    scope.$apply(function() {
                        setSelection(scope, null);
                    });
                }
            });

            var autocomplete = $(element).autocomplete({
                minChars: attrs.minChars,
                delimiter: /(,|;)\s*/,
                maxHeight: 400,
                width: 300,
                deferRequestBy: 0,
                noCache: false,
                fnFormatResult: attrs.fnFormatResult ? scope.$eval(attrs.fnFormatResult) : undefined,
                onSelect: function(value, data) {
                    scope.$apply(function() {
                        if (data) {
                            setSelection(scope, value);
                            setData(scope, data);
                            if (attrs.callback) {
                                scope.$eval(attrs.callback)(value, data);
                            }
                        } else {
                            $(element).val('');
                        }
                        if (ngModelCtrl) {
                            ngModelCtrl.$setViewValue(element.val());
                        }
                    });
                }
            });

            attrs.$observe("url", function(newVal) {
                autocomplete.serviceUrl = newVal;
            });

            scope.$watch(attrs.selection, function(newVal, oldVal) {
                if (newVal != oldVal && newVal === null) {
                    if (element.val().length > 2) {
                        $(element).val('');
                        if (ngModelCtrl) {
                            ngModelCtrl.$setViewValue('');
                        }
                    }
                }
            });
        }
    };
}]);

XysWidgets.filter("xysEscapeNewlines", function() {
    return function(text) {
        var escaped = text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
        return escaped.replace(/\n/g, "<br />");
    };
});

/**
 * @ngdoc directive
 *
 * @description
 * Encapsulamento do plugin rangyinputs para AngularJS
 *
 * @example
   HTML:
   <input xys-rangy-inputs>
   JavaScript:
   $input.controller("xysRangyInputs").replaceSelection("exemplo")
 */
XysWidgets.directive("xysRangyInputs", function() {
    if (!$.fn.getSelection) {
        throw new Error("xysRangyInputs: rangyinputs (textinputs_jquery.js) não foi carregado");
    }

    return {
        controller: ["$element", function($element) {
            var ngModelCtrl = $element.controller("ngModel");

            /**
             * Atualiza o model, caso o campo tenha um ng-model.
             */
            function updateModel() {
                if (!ngModelCtrl) {
                    return;
                }

                var newText = $element.val();
                ngModelCtrl.$setViewValue(newText);

                // forçar que o ngModel faça seu re-render do campo, para então
                // tentarmos restaurar a seleção atual
                var selection = $element.getSelection();
                ngModelCtrl.$render();
                if ($element.val() === newText) {
                    $element.setSelection(selection.start, selection.end);
                }
            }

            this.getSelection = function() {
                return $element.getSelection();
            };
            this.setSelection = function(start, end) {
                $element.setSelection(start, end);
            };

            // implementar métodos que apenas redirecionam para o rangyinputs,
            // garantindo que o model está devidamente atualizado.
            var methods = ["collapseSelection", "deleteText", "deleteSelectedText",
                           "extractSelectedText", "insertText", "replaceSelectedText",
                           "surroundSelectedText"];
            angular.forEach(methods, function(method) {
                this[method] = function() {
                    // garantir que o campo de texto esteja atualizado antes de realizar a operação
                    if (ngModelCtrl) {
                        ngModelCtrl.$render();
                    }
                    var result = $element[method].apply($element, arguments);
                    updateModel();
                    return result;
                };
            }, this);
        }]
    };
});


/**
 * @ngdoc directive
 * @author
 * Magal / Paulo André
 * @description
 * Diretiva para autocomplete multiplo.
 * @example
   HTML:
   <xys-autocomplete-multiple>
 * Atributos:
 *     url: Url onde ele busca os dados
 *     min-chars: quantidade minima de caracteres para fazer a busca
 *     acm-id: especifica o nome do atributo chave do objeto json Ex.: id, co_user etc..
 *     acm-name: especifica o nome do atributo que será utilizado para parametro de busca
 *     searching-text: especifica a mensagem utilizada durante a busca;
 *     hint-text: especifica a mensagem utilizada na dica da busca;
 *     no-results-text: especifica a mensagem utilizada uqnaod não encontra nenhum resultado;
 */
XysWidgets.directive("xysAutocompleteMultiple", ["$parse", "trans", function($parse, trans) {
    return {
        restrict: "E",
        replace: true,
        template: '<input type="text"/>',

        // chegar antes do ngModel...
        priority: 100,
        // ...e impedir que ele seja processado
        terminal: true,

        link: function(scope, element, attrs) {
            var minChars = attrs.minChars || 3;
            var acmId = attrs.acmId || "id";
            var acmName = attrs.acmName || "name";
            var searchingText = attrs.searchingText ? trans(attrs.searchingText) : "Searching...";
            var hintText = attrs.hintText ? trans(attrs.hintText) : "Type in a search term";
            var noResultsText = attrs.noResultsText ? trans(attrs.noResultsText) : "No results";

            var getModel = $parse(attrs.ngModel);
            var setModel = getModel.assign;

            var options = {theme: "facebook",
                minChars: minChars,
                tokenValue: acmId,
                propertyToSearch: acmName,
                searchingText: searchingText,
                hintText: hintText,
                onAdd: updateModel,
                onDelete: updateModel
            };
            $(element).change(updateModel);

            /**
             * Indica se o componente já foi inicializado
             * @type {boolean}
             */
            var initialized = false;
            /**
             * Indica se estamos no meio de uma atualização do campo,
             * para refletir o conteúdo do ngModel
             * @type {boolean}
             */
            var updating = false;

            attrs.$observe("url", function(url) {
                //inicializa o tokeninput
                $(element).tokenInput(url, options);

                if (!initialized) {
                    initialize();
                }
            });

            function initialize() {
                scope.$watch(attrs.ngModel, function(newValue) {
                    updating = true;
                    try {
                        $(element).tokenInput("clear");
                        angular.forEach(newValue, function(value) {
                            $(element).tokenInput("add", value);
                        });
                    } finally {
                        updating = false;
                    }
                }, true);
                initialized = true;
            }

            function updateModel() {
                if (!updating) {
                    var inputValues = $(element).tokenInput("get");
                    scope.$apply(function() {
                        setModel(scope, inputValues);
                    });
                }
            }
        }
    };
}]);

XysWidgets.filter("xysTruncate", function() {
    return function(text, count) {
        if(text){
            if (text.length > count) {
                return text.substr(0, count) + "...";
            } else {
                return text;
            }
        }
    };
});

XysWidgets.directive("xysYoutube", function() {
    var URL_PREFIX = "http://www.youtube.com/embed/";
    return {
        replace: true,
        template:
            '<iframe ng-src="{{url}}" ' +
                'frameborder="0" allowfullscreen></iframe>',
        scope: {
            code: "=xysYoutube"
        },
        link: function(scope, element, attrs) {
            scope.$watch("code", function(value) {
                scope.url = value ? URL_PREFIX + value : null;
            });
        }
    };
});

})(jQuery, angular);
