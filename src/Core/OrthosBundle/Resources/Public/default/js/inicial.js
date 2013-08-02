function inicialCtrl($scope, $http) {
    $scope.timeout = [];

    $scope.getInicial = function () {
        return baseUrl + '/dashboard';
    }
}