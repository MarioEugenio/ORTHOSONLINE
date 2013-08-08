function indexTabelaPrecoCtrl ($scope, $http) {
    $scope.search = {};
    $scope.list = [];

    $scope.pesquisar = function () {
        $http({
            method: 'POST',
            url: baseUrl + '/tabelaPreco/search',
            data: $scope.search
        }).success(
            function (data) {
                $scope.list = (data);
            }
        );
    }

    $scope.cadastrar = function () {
        Load.simple('#view-page', baseUrl + '/tabelaPreco/cadastro');
    }

    $scope.editar = function (id) {
        Load.simple('#view-page', baseUrl + '/tabelaPreco/alterar/' + id);
    }

    $scope.remover = function (id, index) {
        var conf = confirm('Deseja realmente remover esse registro?');

        if (conf) {
            $http(
                {
                    method: 'POST',
                    url: baseUrl + '/tabelaPreco/remover/' + id,
                    data: {}
                }
            ).success(function (data) {

                    if (data.success) {
                        console.log(index);
                        $scope.list.splice(index, 1);
                    }

                    Form.growlMessage(data);
                });
        }

    }
}