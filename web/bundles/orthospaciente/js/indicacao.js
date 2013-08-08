function indicacaoCtrl ($scope, $http) {
    var list = $('#listIndicacao').val();
    $scope.list = (list)? angular.fromJson(list) : [];
    $scope.dt = {};

    $scope.init = function () {
        $scope.dt = Grid.gridPagination('#GridIndicacao');
        $scope.loadList();
    }

    $scope.loadList = function () {

        Grid.removeAllRows($scope.dt);

        if ($scope.list.length) {

            var rows = [];
            var row = {};
            angular.forEach($scope.list, function (item) {

                row = {
                    0:item.dtCadastro
                    ,1:item.noPaciente
                    , 2:item.dsEmail
                    , 3:item.nuResidencial
                    , 4:item.nuCelular
                };

                rows.push(row);
            });

            Grid.addRow($scope.dt, rows);
        }
    }

    $scope.init();
}