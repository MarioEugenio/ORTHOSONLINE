function orcamentoCtrl ($scope, $http, $timeout) {
    var tabelaPreco = $('#tabelaPreco').val();
    $scope.list = (tabelaPreco)? angular.fromJson(tabelaPreco) : [];
    $scope.esp = {};
    $scope.especialidade = 0;
    $scope.etapa = 1;
    $scope.orc = {};
    $scope.checkbox = [];
    $scope.total = 0;
    $scope.parcelaTrue = false;
    $scope.aparelho = {};
    $scope.alert = '';

    $scope.parcela = [];

    $scope.voltar = function () {
        $scope.etapa = ($scope.etapa - 1);
    }

    $scope.recalcular = function () {
        $scope.calculaParcela();
    }

    $scope.validaOrcamento = function () {
        if ($scope.etapa == 1) {
            if ($scope.especialidade == 1) {

                if (!$scope.orc.radio) {
                    $scope.alert = ('Selecione o procedimento desejado');
                    return false;
                }
            }

            /*if ($scope.especialidade == 2) {
                if ($scope.checkbox.length == 0) {
                    $scope.alert = ('Selecione o procedimento desejado');
                    return false;
                }
            }*/

        }


        if (!$scope.orc.nu_parcelas) {
            $scope.alert = ('O Nº de parcelas é obrigatório');
            return false;
        }

        return true;
    }

    $scope.avancar = function () {
        var valorTotal = 0;
        var list = $scope.getList();
        var listFixo = $scope.getListFixo();

        if (!$scope.validaOrcamento()) {

            $timeout(function () {
                $scope.alert = '';
            }, 5000);

            return;
        }


        if ($scope.checkbox) {
            angular.forEach(list, function (item) {
                angular.forEach($scope.checkbox, function (value, key) {
                    if (item.sq_tabela_preco == key) {
                        valorTotal = parseFloat(valorTotal) + parseFloat(item.vl_total);
                    }
                });
            });
        }

        if ($scope.orc.radio) {
            angular.forEach(list, function (item) {
                if (item.sq_tabela_preco == $scope.orc.radio) {
                    valorTotal = parseFloat(valorTotal) + parseFloat(item.vl_total);
                }
            });

            angular.forEach(listFixo, function (item) {
                if (item.sq_tabela_preco == $scope.orc.radioFixo) {
                    valorTotal = parseFloat(valorTotal) + parseFloat(item.vl_total);
                    $scope.aparelho = {
                        valor:parseFloat(item.vl_total).toFixed(2),
                        nome:item.no_procedimento
                    };
                }
            });
        }

        if (!$scope.parcelaTrue) {
            $scope.parcela = [];
            $scope.parcela.push({
                parcela: 1,
                data: Utils.getDate(),
                valor: valorTotal.toFixed(2)
            });
        }

        $scope.parcelaTrue = true;

        var desconto = Utils.formateMoney($scope.orc.vl_desconto);

        if ($scope.especialidade == 2) $scope.orc.nu_valor_parcelado = ((valorTotal - desconto) / $scope.orc.nu_parcelas).toFixed(2);
        else $scope.orc.nu_valor_parcelado = (valorTotal - desconto).toFixed(2);

        if ($scope.especialidade == 2) $scope.orc.nu_valor_total = (valorTotal).toFixed(2);
        else $scope.orc.nu_valor_total = (valorTotal * $scope.orc.nu_parcelas).toFixed(2);

        $scope.total = (valorTotal - desconto).toFixed(2);

        $scope.etapa = ($scope.etapa + 1);


    }

    $scope.setOrtodontia = function () {
        $scope.especialidade = 1;
        $scope.checkbox = [];
        $scope.orc.radio = '';
        $scope.orc.radioFixo = '';
        $scope.aparelho = {};
        $scope.parcela = [];
    }

    $scope.setClinicaGeral = function () {
        $scope.especialidade = 2;
        $scope.checkbox = [];
        $scope.orc.radio = '';
        $scope.orc.radioFixo = '';
        $scope.aparelho = {};
        $scope.parcela = [];
    }

    $scope.init = function () {
        $scope.etapa = 1;
        $scope.orc.nu_parcelas = 1;
    }

    $scope.calculaParcela = function () {
        var parcelas = $scope.orc.nu_parcelas;
        var total = Utils.formateMoney($scope.orc.nu_valor_total);
        var desconto = Utils.formateMoney($scope.orc.vl_desconto);

        if (!parcelas) {
            Modal.growl('Digite um número de parcela', 'error');
            return;
        }

        if ($scope.especialidade == 2) {
            var valorParcelado = ((total - desconto) / parcelas).toFixed(2);
        } else {
            var valorParcelado = (total - desconto).toFixed(2);
        }

        $scope.parcela = [];
        var dtParcela = $scope.orc.dt_vencimento;

        if (!dtParcela) {
            dtParcela = Utils.getDate();
        }

        for(var i=1;i<=parcelas;i++) {
            if (i > 1) dtParcela = Utils.addMonth(dtParcela, 1);

            $scope.parcela.push({
                parcela: i,
                data: dtParcela,
                valor: valorParcelado
            });
        }


        $scope.orc.nu_valor_parcelado = valorParcelado;
    }

    $scope.viewVoltar = function () {
        if ($scope.etapa > 1) {
            return true;
        }

        return false;
    }

    $scope.viewAvancar = function () {
        if ($scope.etapa < 3) {
            return true;
        }

        return false;
    }

    $scope.getValorParcelado = function () {
        return ( $scope.orc.nu_valor_total / $scope.orc.nu_parcelas ).toFixed(2);
    }

    $scope.getListFixo = function () {
        var tmp = [];

        if ($scope.list.length) {
            angular.forEach($scope.list, function (item) {
                if (item.sq_especialidade.sq_especialidade == $scope.especialidade) {
                    if (item.fl_fixo == true) {
                        tmp.push(item);
                    }
                }
            });
        }

        return tmp;
    }

    $scope.getList = function () {
        var tmp = [];

        if ($scope.list.length) {
            angular.forEach($scope.list, function (item) {
                if (item.sq_especialidade.sq_especialidade == $scope.especialidade) {
                    if (item.fl_fixo == false) {
                        tmp.push(item);
                    }
                }
            });
        }

        return tmp;
    }

    $scope.gerarParcelas = function () {
        var conf = confirm('Tem certeza que deseja gerar as parcelas?');
        if (conf) {

            if (!$scope.pag) {
                $scope.alert = ('Selecione uma forma de pagamento')
                return;
            }

            $http(
                {
                    method: 'POST',
                    url: baseUrl + '/orthos/financeiro/gerarParcelas',
                    data: {
                        pagamento:$scope.pag,
                        cobranca: $scope.orc,
                        parcelas: $scope.parcela,
                        paciente: $scope.paciente.sq_paciente,
                        especialidade: $scope.especialidade
                    }
                }
            ).success(function (data) {
                    Form.growlMessage(data);

                    if (data.success) {
                        $('#orcamento').modal('hide');
                    }
                });
        }
    }

    $scope.init();
}