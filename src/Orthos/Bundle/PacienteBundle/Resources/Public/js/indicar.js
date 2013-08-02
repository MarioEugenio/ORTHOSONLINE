function indicarCtrl ($scope, $http) {
    var clinica = $('#clinicas').val();
    $scope.listClinica = (clinica)? angular.fromJson(clinica) : [];

    $scope.init = function () {
        $('.fone').mask('(99)9999-9999');
    }

    $scope.submit = function () {
        Loading.showAll();
        $scope.ind.nu_residencial = $('.j-telefone').val();
        $scope.ind.nu_celular = $('.j-celular').val();

        $http({
            method: 'POST',
            url: baseUrl + '/orthos/paciente/indicarPaciente',
            data: {
                'indicacao': $scope.ind,
                'sqPaciente': $scope.paciente.sq_paciente
            }
        }).success(
            function (data) {
                Loading.hideAll();
                Form.growlMessage(data);

                if (data.success) {
                    $scope.ind = {};
                }
            }
        );
    }

    $scope.init();
}