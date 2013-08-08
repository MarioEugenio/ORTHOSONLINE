function listaDiariaCtrl ($scope) {
    var list = $('#listaDiaria').val();
    $scope.listDiaria = (list)? angular.fromJson(list) : [];

    $scope.countAgendados = function () {
        return $scope.countStatus (1);
    }

    $scope.countEmEspera = function () {
        return $scope.countStatus (2);
    }

    $scope.countCancelados = function () {
        return $scope.countStatus (3);
    }

    $scope.countFinalizado = function () {
        return $scope.countStatus (4);
    }

    $scope.countEmAtendimento = function () {
        return $scope.countStatus (5);
    }

    $scope.countStatus = function (status) {
        var i = 0;

        angular.forEach($scope.listDiaria, function (item) {
            if (item.sq_status_consulta == status) {
                i++;
            }
        });

        return i;
    }
}