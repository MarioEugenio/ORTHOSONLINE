function negociacaoCtrl ($scope, $http) {
    var parcelas = $('#parcelas').val();
    $scope.parcelas = (parcelas)? angular.fromJson(parcelas) : {};
    $scope.neg = {};

    $scope.init = function () {
        $('.number').numeric();
        $('.j-data').mask('99/99/9999');
        $scope.neg.nu_parcelas = 1;
    }

    $scope.getTotal = function () {
        if ($scope.parcelas) {
            var valor = 0.00;
            angular.forEach($scope.parcelas, function (item) {
                valor = parseFloat(valor) + parseFloat($scope.getValorCorrigidoNegociacao(item.vlParcela, item.dtVencimento));
            });

            if ($scope.neg.vl_desconto) {
                valor = (parseFloat(valor) - parseFloat($scope.neg.vl_desconto));
            }

            return valor.toFixed(2);
        }

        return 0.00;
    }

    $scope.getValorParcelado = function () {
        var valor = $scope.getTotal();
        var parcela = $scope.neg.nu_parcelas;

        return (parseFloat(valor) / parcela).toFixed(2);
    }

    $scope.formataData = function (data) {
        return Utils.parseDate2(data);
    }

    $scope.getDiasAtrasosNegociacao = function (date) {
        return Utils.DiffDateNow(date);
    }

    $scope.getValorCorrigidoNegociacao = function (vlParcela, dtVencimento) {
        return $scope.getValorCorrigido(vlParcela, dtVencimento);
    }

    $scope.removerParcela = function (index) {
        var conf = confirm('Tem certeza que deseja excluir este registro?');
        if (conf) $scope.parcelas.splice(index, 1);
    }

    $scope.efetivarNegociacao = function () {
        var conf = confirm('Tem certeza que deseja efetizar essa negociação?');

        if (conf) {

            $http(
                {
                    method: 'POST',
                    url: baseUrl + '/orthos/financeiro/efetivarNegociacao',
                    data: {
                        pagamento: $scope.pag,
                        dt_vencimento: $('.j-data').val(),
                        vl_desconto: $scope.neg.vl_desconto,
                        vl_total: $('.j-total').val(),
                        nu_parcelas: $scope.neg.nu_parcelas,
                        parcelas: $scope.parcelas,
                        sq_paciente: $scope.paciente.sq_paciente
                    }
                }
            ).success(function (data) {
                    Form.growlMessage(data);

                    if (data.success) {
                        $('#negociacao').modal('hide');
                        $scope.carregaLista();
                    }
                });
        }
    }

    $scope.init();
}