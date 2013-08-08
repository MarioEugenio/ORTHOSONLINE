function financeiroCtrl ($scope, $http, $timeout) {
    var list = $('#listFinanceiro').val();
    $scope.list = [];
    $scope.dt = {};
    $scope.parcela = null;
    $scope.sqParcela = null;
    $scope.negociacao = null;
    $scope.status = {};

    $scope.init = function () {
        $scope.dt = Grid.gridPagination('#GridFinanceiro');
        $scope.status.todas = true;
        $scope.carregaLista();
    }

    $scope.pagamento = function (parcela) {
        $scope.sqParcela = parcela;
        $scope.parcela = baseUrl + '/orthos/paciente/pagamento/' + parcela;
        $("#pagamento").modal({ // wire up the actual modal functionality and show the dialog
            "backdrop" : "static",
            "keyboard" : true,
            "show" : true // ensure the modal is shown immediately
        });
    }

    $scope.boleto = function (parcela) {
        window.open(baseUrl + '/orthos/financeiro/boleto/' + parcela, 'boleto', 'width=700,height=500,top=200,left=250,scrollbars=yes');
    }

    $scope.negociarDivida = function () {
        if (!Utils.getChecked('j-financeiro')) {
            Modal.growl('Selecione pelo menos uma parcela', 'error');
            return;
        }

        $scope.negociacao = baseUrl + '/orthos/paciente/negociacao/'+Utils.getChecked('j-financeiro');
        $("#negociacao").modal({ // wire up the actual modal functionality and show the dialog
            "backdrop" : "static",
            "keyboard" : true,
            "show" : true // ensure the modal is shown immediately
        });
    }

    $scope.statusParcela = function (status) {
        var tmp = [];

        if (status == 'T') {
            $scope.loadList();
            return;
        }

        angular.forEach($scope.list, function (item) {
            var dt_vencimento = (item.dt_vencimento)? item.dt_vencimento.date : null;
            var atraso = Utils.DiffDateNow(Utils.parseDate(dt_vencimento));

            if (status == 'A') {
                if (atraso >= 1) {
                    tmp.push(item);
                }
            }

            if (status == 'V') {
                if (atraso < 1) {
                    tmp.push(item);
                }
            }
        });

        $scope.loadList(tmp);
    }

    $scope.removerParcelas = function () {
        if (!Utils.getChecked('j-financeiro')) {
            Modal.growl('Selecione pelo menos uma parcela', 'error');
            return;
        }

        var conf = confirm('Tem certeza que deseja remover essas parcelas?');
        if (conf) {
            $http(
                {
                    method: 'POST',
                    url:  baseUrl + '/orthos/paciente/removerParcelas/'+Utils.getChecked('j-financeiro'),
                    data: {}
                }
            ).success(function (data) {
                Form.growlMessage(data);

                if (data.success) {
                    $scope.carregaLista();
                }
            });
        }
    }

    $scope.chequeDevolvido = function (parcela) {
        var conf = confirm('Tem certeza que deseja marcar como cheque devolvido?');
        if (conf) {
            $http(
                {
                    method: 'POST',
                    url:  baseUrl + '/orthos/financeiro/chequeDevolvido',
                    data: {parcela:parcela}
                }
            ).success(function (data) {
                    Form.growlMessage(data);

                    if (data.success) {
                        $scope.carregaLista();
                    }
                });
        }
    }

    $scope.carregaLista = function () {
        $http(
            {
                method: 'POST',
                url:  baseUrl + '/orthos/financeiro/list/'+ $scope.paciente.sq_paciente,
                data: {}
            }
        ).success(function (data) {
            $scope.loadList(data);
        });
    }

    $scope.loadList = function (data) {
        var list = [];
        if (data) {
            list = data;
        } else {
            list = $scope.list;
        }

        Grid.removeAllRows($scope.dt);

        if (list.length) {

            var rows = [];
            var row = {};
            angular.forEach(list, function (item) {

                var actions = '';
                var input = '';

                if (!item.dt_pagamento) {
                    actions = Icons.render('pagamento','#myAngularApp', 'pagamento', item.sq_parcelas)

                    if (item.fl_tipo_pagamento == 'BO') {
                        actions += Icons.render('boleto','#myAngularApp', 'boleto', item.sq_parcelas);
                    }

                    if (item.fl_tipo_pagamento == 'CH') {
                        if (!item.fl_cheque_devolvido) {
                            actions += Icons.render('cheque','#myAngularApp', 'chequeDevolvido', item.sq_parcelas);
                        }
                    }

                    if (!item.dt_pagamento) {
                        input = '<input type="checkbox" class="j-financeiro" name="financeiro['+item.sq_parcelas+']" value="'+item.sq_parcelas+'" />';

                    }
                }

                var dt_pagamento = (item.dt_pagamento)? item.dt_pagamento.date : null;
                var dt_vencimento = (item.dt_vencimento)? item.dt_vencimento.date : null;

                var atraso = 0;
                var valorCorrigido  = 0;
                if (!item.dt_pagamento) {
                    atraso = Utils.DiffDateNow(Utils.parseDate(dt_vencimento));
                    valorCorrigido = $scope.getValorCorrigido(item.vl_parcela, dt_vencimento);
                }

                row = {
                    0: input
                    ,1: actions
                    , 2: (atraso > 0)? '<span class="badge badge-warning"><li class="icon-ok-circle icon-white"></li></span>': null
                    , 3: (item.fl_cheque_devolvido)? '<span class="badge"><li class="icon-ok-circle icon-white"></li></span>': null
                    , 4: (item.sq_financeiro.sq_especialidade)? item.sq_financeiro.sq_especialidade.no_especialidade : '-'
                    , 5: Utils.parseDate(dt_vencimento)
                    , 6: Utils.parseDate(dt_pagamento)
                    , 7: item.vl_pagamento
                    , 8: item.vl_parcela
                    , 9: atraso
                    , 10: parseFloat(valorCorrigido).toFixed(2)
                };

                rows.push(row);
            });

            Grid.addRow($scope.dt, rows);
        }
    }

    $scope.getJuros = function () {
        var config = ($('#clinica').val())? angular.fromJson($('#clinica').val()) : {};
        return config.nu_juros;
    }

    $scope.getValorCorrigido = function (vlParcela, dtVencimento) {
        var parcela = parseFloat( vlParcela );
        var atraso = Utils.DiffDateNow(Utils.parseDate(dtVencimento));
        if (atraso > 0) {
            parcela = parcela + (atraso * (parcela * ($scope.getJuros()/100)));
        }

        return parcela;
    }

    $scope.init();
}