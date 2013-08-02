function pagamentoCtrl ($scope, $http, $timeout) {
    var parcela = $('#parcela').val();
    $scope.pagamento = (parcela)? angular.fromJson(parcela) : {};
    $scope.pag = {};

    $scope.getAtraso = function () {
        var date = $scope.pagamento.dtVencimento;
        var diff = Utils.DiffDateNow(date);
        return diff;
    }

    $scope.getJuros = function () {
        var config = ($('#clinica').val())? angular.fromJson($('#clinica').val()) : {};
        return config.nu_juros;
    }

    $scope.getValorCorrigido = function () {
        var parcela = parseFloat( $scope.pagamento.vlParcela );

        if ($scope.getAtraso() > 0) {
            parcela = parcela + ($scope.getAtraso() * (parcela * ($scope.getJuros()/100)));
        }

        return parcela.toFixed(2);
    }

    $scope.getValorPagamento = function () {
        var valor = (parseFloat($scope.getValorCorrigido()) - parseFloat($scope.pag.vl_desconto));

        if (!valor) {
            return $scope.getValorCorrigido();
        }

        return valor.toFixed(2);
    }

    $scope.pagar = function () {
        var conf = confirm('Tem certeza que deseja pagar esta parcela?');

        if (conf) {
            var desconto = ($('.j-vlDesconto').val())? $('.j-vlDesconto').val(): null;
            var pagamento = ($('.j-vlPagamento').val())? $('.j-vlPagamento').val(): null;

            $http(
                {
                    method: 'POST',
                    url: baseUrl + '/orthos/financeiro/pagarParcela',
                    data: { pagamento: $scope.pag, vl_desconto: desconto,vl_pagamento: pagamento, parcela: $scope.sqParcela }
                }
            ).success(function (data) {
                    Form.growlMessage(data);

                    if (data.success) {
                        $scope.carregaLista();
                        $('#pagamento').modal('hide');

                    }
                });
        }
    }

    $scope.pagarCartao = function () {

        $http(
            {
                method: 'POST',
                url: baseUrl + '/orthos/paciente/pagamentoCartao',
                data: {}
            }
        ).success(function (data) {
                console.log(data);
            });

    }

    $scope.init = function () {

    }

    $scope.init();
}