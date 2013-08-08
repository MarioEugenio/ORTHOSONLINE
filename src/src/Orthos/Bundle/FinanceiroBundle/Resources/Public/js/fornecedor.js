function fornecedorCtrl ($scope, $http, $timeout) {
    $scope.list = [];
    $scope.search = {};

    $scope.pesquisar = function () {
        $http(
            {
                method: 'POST',
                url: baseUrl + '/orthos/financeiro/fornecedor/search',
                data: $scope.search
            }
        ).success(function (data) {
            $scope.list = data;
        });
    }

    $scope.cadastrar = function () {
        Load.simple('#view-page', baseUrl + '/orthos/financeiro/fornecedor/cadastro');
    }

    $scope.editar = function (id) {
        Load.simple('#view-page', baseUrl + '/orthos/financeiro/fornecedor/alterar/' + id);
    }

    $scope.remover = function (id, index) {
        var conf = confirm('Tem certeza que deseja excluir esse registro?');

        if (conf) {
            $http(
                {
                    method: 'POST',
                    url: baseUrl + '/orthos/financeiro/fornecedor/remover/' + id,
                    data: $scope.form
                }
            ).success(function (data) {
                Form.growlMessage(data);
                if (data.success) {
                    $scope.list.splice(index, 1);
                }
            });
        }
    }
}