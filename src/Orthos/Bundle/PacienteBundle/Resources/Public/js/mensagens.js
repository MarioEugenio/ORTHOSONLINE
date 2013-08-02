function mensagensCtrl ($scope, $http) {
    var list = $('#listMensagens').val();
    $scope.list = (list)? angular.fromJson(list) : [];
    $scope.dt = {};

    $scope.init = function () {
        $scope.dt = Grid.gridPagination('#GridMensagens');
        $scope.loadList();
    }

    $scope.tipEnvio = function (tipo) {
        switch (tipo) {
            case 'S':
                return 'SMS';
            break;
            case 'E':
                return 'E-mail';
            break;
            default :
                return 'SMS / E-mail';
        }
    }

    $scope.loadList = function () {

        Grid.removeAllRows($scope.dt);

        if ($scope.list.length) {

            var rows = [];
            var row = {};
            angular.forEach($scope.list, function (item) {

                row = {
                    0:item.dtEnvio
                    ,1:item.txAssunto
                    , 2:item.txMensagem
                    , 3:$scope.tipEnvio(item.flTipoMensagem)
                };

                rows.push(row);
            });

            Grid.addRow($scope.dt, rows);
        }
    }

    $scope.init();
}