function dashboardCtrl ($scope, $http) {
    $scope.listRigth = [];
    $scope.listLeft = [];

    $scope.init = function () {
        $scope.listDashboardLeft();
        $scope.listDashboardRigth();
    }

    $scope.getUrlDashboard = function (item) {
        if (item.txEndereco) {
            return baseUrl + item.txEndereco;
        }

        return ;
    }

    $scope.listDashboardLeft = function () {
        $http(
            {
                method: 'POST',
                url: baseUrl + '/dashboard/list/L',
                data: {position: 'L'}
            }
        ).success(function (data) {
                $scope.listLeft = data;
            });
    }

    $scope.listDashboardRigth = function () {
        $http(
            {
                method: 'POST',
                url: baseUrl + '/dashboard/list/R',
                data: {position: 'R'}
            }
        ).success(function (data) {
                $scope.listRigth = data;
            });
    }

    $scope.init();
}