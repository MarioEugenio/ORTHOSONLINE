function contatoCtrl($scope, $http) {
    $scope.cont = {};

    $scope.enviarContato = function () {
        Loading.showAll();
        $http(
            {
                method: 'POST',
                url: baseUrl + '/contato/enviarContato',
                data: {
                    mensagem: $scope.cont.tx_contato,
                    assunto: $scope.cont.tx_assunto
                }
            }
        ).success(function (data) {
                Loading.hideAll();
                Form.growlMessage(data);

                if (data.success) $scope.cont = {};
            });
    }
}