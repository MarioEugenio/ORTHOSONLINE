

angular.module('confirm', []).directive('buttonDelete', function($compile, $rootScope) {
    return {
        restrict: 'E',
        replace: true,
        template: '<button type="button" class="btn"><li class="icon-remove"></li></button>',
        link: function(scope, element, attrs) {
            //            debugger;
            //element.bind('click', function(e) {
            //                var popover = $();
            //                element.clickover({content: 'test'});

            options = {};

            element.popover(angular.extend({}, options, {
                title: "Confirmação",
                content: function() {
                    //debugger;
                    var element = $compile("<div class='btn-toolbar'>" +
                        "Tem certeza que deseja remover este registro?<br><br>" +
                        "<button id='button-confirm-delete-cancel' ng-click='dismiss()' class='btn'>Cancelar</button>&nbsp;" +
                        "<button id='button-confirm-delete-ok' class='btn btn-danger' ng-click='destroy(v)'>Remover</button>" +
                        "</div>")(scope.$parent);
                    return element.html();
                },
                html: true
            }));

            // Provide scope display functions
            scope._popover = function(name) {
                element.popover(name);
            };
            scope.hide = function() {
                element.popover('hide');
            };
            scope.show = function() {
                element.popover('show');
            };
            scope.dismiss = scope.hide;

        }
    }

});

angular.module('combo', []).directive('combo', function() {
    return {
        restrict: 'E',
        replace: true,
        template: '<select ></select>',
        link: function(scope, element, attrs) {
            //            debugger;
            //element.bind('click', function(e) {
            //                var popover = $();
            //                element.clickover({content: 'test'});

            options = {};

            element.popover(angular.extend({}, options, {
                title: "Confirmação",
                content: function() {
                    //debugger;
                    var element = $compile("<div class='btn-toolbar'>" +
                        "Tem certeza que deseja remover este registro?<br><br>" +
                        "<button id='button-confirm-delete-cancel' ng-click='dismiss()' class='btn'>Cancelar</button>&nbsp;" +
                        "<button id='button-confirm-delete-ok' class='btn btn-danger' ng-click='destroy(v)'>Remover</button>" +
                        "</div>")(scope.$parent);
                    return element.html();
                },
                html: true
            }));

            // Provide scope display functions
            scope._popover = function(name) {
                element.popover(name);
            };
            scope.hide = function() {
                element.popover('hide');
            };
            scope.show = function() {
                element.popover('show');
            };
            scope.dismiss = scope.hide;

        }
    }

});

angular.module('core', []).directive('selectMultiple', function () {

    return {
        scope: true,
        link: function (scope, element, attrs) {

            element.multiselect({
                buttonWidth: 'auto',
                buttonText: function(options) {
                    if (options.length == 0) {
                        return 'Nenhum item selecionado <b class="caret"></b>';
                    }
                    else if (options.length > 3) {
                        return options.length + ' Selecionado(s) <b class="caret"></b>';
                    }
                    else {
                        var selected = '';
                        options.each(function() {
                            selected += $(this).text() + ', ';
                        });
                        return selected.substr(0, selected.length -2) + ' <b class="caret"></b>';
                    }
                },
                onChange: function (optionElement, checked) {

                    if (checked) {
                        optionElement.attr('selected', 'selected');
                    }

                    element.change();
                }
            });

            scope.$watch(function () {
                return element[0].length;
            }, function () {
                element.multiselect('rebuild');
            });


            scope.$watch(attrs.ngModel, function () {
                element.multiselect('refresh');
            });

        }

    };
}).directive('money', function () {

        return {
            scope: true,
            link: function (scope, element, attrs) {
                element.priceFormat({
                    prefix: '',
                    thousandsSeparator: ''
                });
            }

    };
}).directive('editor', function () {

        return {
            scope: true,
            link: function (scope, element, attrs) {
                element.jqte();
            }

        };$("textarea").jqte();
    }).directive('number', function () {

        return {
            scope: true,
            link: function (scope, element, attrs) {

                element.numeric();
            }

        };
    }).directive('uiCurrency', ['ui.config', 'currencyFilter' , function (uiConfig, currencyFilter) {
    var options = {
        pos: 'ui-currency-pos',
        neg: 'ui-currency-neg',
        zero: 'ui-currency-zero'
    };
    if (uiConfig.currency) {
        angular.extend(options, uiConfig.currency);
    }
    return {
        restrict: 'EAC',
        require: 'ngModel',
        link: function (scope, element, attrs, controller) {
            var opts, // instance-specific options
                renderview,
                value;

            opts = angular.extend({}, options, scope.$eval(attrs.uiCurrency));

            renderview = function (viewvalue) {
                var num;
                num = viewvalue * 1;
                element.toggleClass(opts.pos, (num > 0) );
                element.toggleClass(opts.neg, (num < 0) );
                element.toggleClass(opts.zero, (num === 0) );
                if (viewvalue === '') {
                    element.text('');
                } else {
                    element.text(currencyFilter(num, opts.symbol));
                }
                return true;
            };

            controller.$render = function () {
                value = controller.$viewValue;
                element.val(value);
                renderview(value);
            };

        }
    };
}]);