function fornecedorCadastroCtrl ($scope, $http, $timeout) {
    $scope.id = ($('#sqFornecedor').val())? $('#sqFornecedor').val() : null;
    $scope.form = {};

    $scope.init = function () {
        $('.cnpj').mask('99.999.999/9999-99');
        $('.fone').mask('(99)9999-9999');

        $scope.edit();
    }

    $scope.submit = function () {
        $scope.form.nu_cnpj = $('.cnpj').val();
        $scope.form.nu_telefone = $('.fone').val();

        $http(
            {
                method: 'POST',
                url: baseUrl + '/orthos/financeiro/fornecedor/save',
                data: $scope.form
            }
        ).success(function (data) {
            Form.growlMessage(data);
            if (data.success) {
                Load.simple('#view-page', baseUrl + '/orthos/financeiro/fornecedor');
            }
        });
    }

    $scope.pesquisa = function () {
        Load.simple('#view-page', baseUrl + '/orthos/financeiro/fornecedor');
    }

    $scope.edit = function () {
        if ($scope.id) {
            $http(
                {
                    method: 'POST',
                    url: baseUrl + '/orthos/financeiro/fornecedor/list/' + $scope.id,
                    data: {}
                }
            ).success(function (data) {
                $scope.form = data;
            });
        }
    }

    $scope.init();
}