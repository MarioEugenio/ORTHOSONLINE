function loginCtrl ($scope, $http) {
    $scope.login = {};
    $scope.listClinica = [];
    $scope.autenticacao = true;

    $scope.autenticar = function () {
        var user = ($scope.login.user == undefined)? null : $scope.login.user;
        var password = ($scope.login.password == undefined)? null : $scope.login.password;

        $http(
            {
                method: 'POST',
                url: baseUrl + '/usuario/autenticar',
                data: {
                    user: user,
                    password: password
                }
            }
        ).success(function (data) {

                if (data.success) {

                    if (data.result.hasOwnProperty('clinicas')) {

                        if (data.result.clinicas.length > 0) {

                            $scope.listClinica = data.result.clinicas;
                            Modal.growl('Selecione a clínica que deseja acessar', 'error');
                        } else {
                            window.location = baseUrl + '/orthos/main';
                        }
                    } else {
                        window.location = baseUrl + '/orthos/main';
                    }
                } else {
                    Form.growlMessage(data);
                }
            });
    }

    $scope.setClinica = function () {
        $http(
            {
                method: 'POST',
                url: baseUrl + '/usuario/definirClinica',
                data: $scope.login
            }
        ).success(function (data) {

                if (data.success) {
                    window.location = baseUrl + '/orthos/main';
                } else {
                    Form.growlMessage(data);
                }
            }
        );
    }
}