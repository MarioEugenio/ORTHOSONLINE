function alterarSenhaCtrl ($scope, $http) {
    $scope.pass = {};
    $scope.alert;

    $scope.checkSenha = function () {
        if (!$scope.pass.tx_senha) {
            return false;
        }

        if (!$scope.pass.tx_rep_senha) {
            return false;
        }

        if ($scope.pass.tx_senha != $scope.pass.tx_rep_senha) {
            return false;
        }

        return true;
    }

    $scope.submit = function () {
        if (!$scope.checkSenha()) {
            $scope.alert = ('As senhas digitadas não conferem, digite novamente');
            return;
        }

        $http({
            method: 'POST',
            url: baseUrl + '/usuario/saveSenha',
            data: $scope.pass
        }).success(
            function (data) {
                Form.growlMessage(data);

                if (data.success) {
                    $('#modalSenha').modal('hide');
                }
            }
        );
    }
}