function remessaCtrl ($scope, $http, $timeout) {
    var listRemessa = [];
    $scope.listRemessa = (listRemessa)? angular.fromJson(listRemessa) :[];
    $scope.total = 0;
    $scope.totalPago = 0;

    $scope.check = function () {
        var listRemessa = $('#listRemessa').val();
        $scope.listRemessa = (listRemessa)? angular.fromJson(listRemessa) :[];
    }

    $scope.somaTotal = function (valor) {
        $scope.total = parseFloat($scope.total) + parseFloat(valor);
    }

    $scope.somaTotalPago = function (valor) {
        $scope.totalPago = parseFloat($scope.totalPago) + parseFloat(valor);
    }

    $scope.executeCheck = function () {
        $timeout(function () {
            if (!$scope.listRemessa.length) {
                $scope.check();
                $scope.executeCheck();
            }
        }, 300);
    }

    $scope.baixar = function (item) {
        var conf = confirm('Tem certeza que deseja baixar essa parcela?');
        if (conf) {
            $http(
                {
                    method: 'POST',
                    url: baseUrl + '/orthos/financeiro/pagarParcela',
                    data: { parcela: item.sq_parcela, vl_pagamento: item.vl_pagamento }
                }
            ).success(function (data) {
                    Form.growlMessage(data);
                    if (data.success) {
                        item.check = false;
                    }
                });
        }
    }

    $scope.status = function (status) {
        switch (status) {
            case true:
                return "<span class='icon-ok'></span> Parcela Encontrada";
            break;
            case false:
                return "<span class='icon-remove'></span> Parcela Não Encontrada";
                break;
        }
    }

    $scope.executeCheck();
}