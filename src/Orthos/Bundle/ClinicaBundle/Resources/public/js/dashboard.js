function dashboardCtrl ($scope) {
    var clinica = $('#clinica').val();
    $scope.clinica = (clinica)? angular.fromJson(clinica) : {};
}