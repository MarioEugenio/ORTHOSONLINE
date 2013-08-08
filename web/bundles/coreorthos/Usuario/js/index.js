function indexUsuarioCtrl ($scope, $http) {
    $scope.search = {};
    $scope.listUsuario = [];

    $scope.pesquisar = function () {
        $http({
            method: 'POST',
            url: baseUrl + '/usuario/search',
            data: $scope.search
        }).success(
            function (data) {
                $scope.listUsuario = (data);
            }
        );
    }

    $scope.cadastrar = function () {
        Load.simple('#view-page', baseUrl + '/usuario/cadastro');
    }

    $scope.editar = function (id) {
        Load.simple('#view-page', baseUrl + '/usuario/alterar/' + id);
    }

    $scope.remover = function (id, index) {
        var conf = confirm('Deseja realmente remover esse registro?');

        if (conf) {
            $http(
                {
                    method: 'POST',
                    url: baseUrl + '/usuario/deletar/' + id,
                    data: {}
                }
            ).success(function (data) {

                    if (data.success) {
                        console.log(index);
                        $scope.listUsuario.splice(index, 1);
                    }

                    Form.growlMessage(data);
                });
        }

    }
}