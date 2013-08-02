function lancamentoCtrl ($scope, $http, $timeout) {
    $scope.typeahead = [];
    $scope.tmpAutocomplete = [];
    $scope.form = {};
    $scope.modal = {};
    $scope.modal.repeticao = {};
    $scope.modal.repeticao.nu_repeticao = 1;
    $scope.list = [];
    $scope.saldo = 0;
    $scope.saldoTotal = 0;
    $scope.contas = ($('#listContas').val())? angular.fromJson($('#listContas').val()) : [];
    $scope.categoria = ($('#listCategoria').val())? angular.fromJson($('#listCategoria').val()) : [];
    $scope.fornecedor = ($('#listFornecedor').val())? angular.fromJson($('#listFornecedor').val()) : [];
    $scope.tipo = null;
    $scope.bancos = [
        {cod:'001', banco: 'Banco do Brasil'},
        {cod:'341', banco: 'Itaú Unibanco S.A.'},
        {cod:'184', banco: 'Banco Itaú BBA S.A.'},
        {cod:'479', banco: 'Banco ItaúBank S.A.'},
        {cod:'652', banco: 'Itaú Unibanco Holding S.A.'},
        {cod:'409', banco: 'UNIBANCO - União de Bancos Brasileiros S.A.'},
        {cod:'070', banco: 'BRB - Banco de Brasília S.A.'},
        {cod:'237', banco: 'Banco Bradesco S.A.'},
        {cod:'745', banco: 'Banco Citibank S.A.'}];

    $scope.tipo_lancamento = [
        {id:'BO', value: 'Boleto'},
        {id:'NO', value: 'Nota Fiscal'},
        {id:'RE', value: 'Recibo'},
        {id:'DO', value: 'Documento'},
        {id:'GU', value: 'Guia de Imposto'},
        {id:'DI', value: 'Dinheiro'},
        {id:'CH', value: 'Cheque'},
        {id:'CA', value: 'Cartão de Crédito'},
        {id:'CD', value: 'Cartão de Débito'}
    ];

    $scope.init = function () {
        $scope.modal.repeticao.nao = true;
        $(".moneyLancamento").maskMoney();

        $scope.loadGrid();
    }

    $scope.getTipoLancamento = function (item) {
        var valor;

        angular.forEach($scope.tipo_lancamento, function (value) {
            if (value.id == item.fl_tipo_documento) {
                valor = value.value;
            }
        });

        return valor;
    }

    $scope.loadGrid = function () {
        $scope.list = [];
        $http(
            {
                method: 'POST',
                url: baseUrl + '/orthos/financeiro/lancamentos/list',
                data: $scope.form
            }
        ).success(function (data) {
            $scope.list = data;
        });
    }

    $scope.listBancos = function () {
        var list = [];

        angular.forEach($scope.contas, function ($contas) {
            angular.forEach($scope.bancos, function ($bancos) {
                if ($contas.nu_banco == $bancos.cod) {
                    $contas.banco = $bancos.banco;
                    list.push($contas);
                }
            });
        });

        console.log(list);
        return list;
    }

    $scope.getTitle = function () {
        if ($scope.tipo == 'C') {
            return "Lançar Crédito";
        }

        return "Lançar Débito";
    }

    $scope.clearRepeticao = function () {
        $scope.modal.repeticao.mensal = false;
        $scope.modal.repeticao.semanal = false;
    }

    $scope.lancamento = function (tipo) {
        $scope.tipo = tipo;

        $('#modal').modal('show');
        $(".money").maskMoney();
        $('.number').numeric();
    }

    $scope.getFornecedor = function () {
        var id = $('.j-fornecedor').attr('typeaheadId');

        $timeout(function () {
            $scope.modal.sq_fornecedor = $scope.tmpAutocomplete[id];
        }, 300);
    }

    $scope.autocompleteFornecedor = function(query, what) {

        var callback = function (data) {
            $scope.typeahead = data;
        };

        $http.post( baseUrl + '/orthos/financeiro/fornecedor/autocomplete', {query : query}).success(callback);

        return $.map($scope.typeahead, function(value) {
            return value.value;
        });

    }

    $scope.getValor = function (item, tipo) {
        if (item.fl_tipo_movimento == tipo) {
            return item.vl_nominal;
        }

        return 0;
    }

    $scope.getClassTotal = function (valor) {

        if (parseFloat(valor) < 0) {
            return 'text-debito';
        }

        return 'text-credito';
    }

    $scope.submit = function () {
        $scope.modal.vl_nominal = $('.j-vlNominal').val();
        $scope.modal.vl_desconto = $('.j-vlDesconto').val();
        $scope.modal.fl_tipo_movimento = $scope.tipo;

        $http(
            {
                method: 'POST',
                url: baseUrl + '/orthos/financeiro/lancamentos/save',
                data: $scope.modal
            }
        ).success(function (data) {
            Form.postMessage(data, 'alert');

            if (data.success) {
                $scope.modal = {};
                $('#modal').modal('hide');
                $scope.loadGrid();
            }
        });
    }

    $scope.init();
}