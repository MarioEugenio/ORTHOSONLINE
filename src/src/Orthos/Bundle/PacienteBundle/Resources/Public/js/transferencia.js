function transferenciaCtrl ($scope, $http) {
    var clinica = $('#clinicas').val();
    $scope.listClinica = (clinica)? angular.fromJson(clinica) : [];

    $scope.submit = function () {
        var clinica = $scope.transf.clinica;
        var paciente = $scope.paciente.sq_paciente;

        var conf = confirm('tem certeza que deseja transferir este paciente?');
        if (conf) {
            $http(
                {
                    method: 'POST',
                    url: baseUrl + '/orthos/paciente/transferir/' + paciente + '/' + clinica,
                    data: {}
                }
            ).success(function (data) {
                    Form.growlMessage(data);

                    if (data.success) {
                        Load.simple('#view-page', baseUrl + '/orthos/paciente');
                    }
                });
        }
    }
}