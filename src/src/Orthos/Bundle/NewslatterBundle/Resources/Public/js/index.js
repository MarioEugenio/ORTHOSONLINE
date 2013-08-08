
function indexNewslatterCtrl($scope, $http) {
    $scope.list = [];

    $scope.init = function () {
        $scope.loadLista();
    }

    $scope.loadLista = function () {
        $http(
            {
                method: 'POST',
                url: baseUrl + '/orthos/newslatter/list',
                data: {}
            }
        ).success(function (data) {
            $scope.list = data;
        });
    }

    $scope.cadastrar = function () {
        Load.simple('#view-page', baseUrl + '/orthos/newslatter/cadastro');
    }

    $scope.cadastrarModelo = function () {
        Load.simple('#view-page', baseUrl + '/orthos/modeloDocumento');
    }

    $scope.editar = function () {

    }

    $scope.remover = function () {

    }

    $scope.init();
}