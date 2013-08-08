
function ParticipantesCreateCtrl($scope, $http) {

    $scope.save = function () {
        var callback = function (data) {

        };

        $http.post( 'Databases/getDbIntance/1', {}).success(callback);
    }

    $scope.create = function () {
        Load.simple('#view-page', 'participante/create');
    }
};