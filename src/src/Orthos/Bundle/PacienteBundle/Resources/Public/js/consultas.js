function consultasCtrl ($scope, $http) {
    var consultas = $('#listConsultas').val();
    $scope.listConsultas = (consultas)? angular.fromJson(consultas) : [];
    $scope.dt = {};

    $scope.init = function () {
        $scope.dt = Grid.gridPagination('#GridConsultas');
        $scope.loadList();
    }

    $scope.loadList = function () {

        Grid.removeAllRows($scope.dt);

        if ($scope.listConsultas.length) {

            var rows = [];
            var row = {};
            angular.forEach($scope.listConsultas, function (item) {
                row = {0:item.dtAgenda,1:item.dtChegada,2:item.noAtendente,3:item.txObservacao,4:item.status};
                rows.push(row);
            });

            Grid.addRow($scope.dt, rows);
        }
    }

    $scope.init();
}