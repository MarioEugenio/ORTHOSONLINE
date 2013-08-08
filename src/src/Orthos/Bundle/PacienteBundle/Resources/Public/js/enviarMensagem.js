function enviarMensagemCtrl ($scope, $http) {
    $scope.msg = {};

    $scope.getTipoEnvio = function () {
        if ($scope.msg.sms) {
            $scope.msg.fl_tipo_mensagem = 'S';
        }

        if ($scope.msg.email) {
            $scope.msg.fl_tipo_mensagem = 'E';
        }

        if ($scope.msg.sms_email) {
            $scope.msg.fl_tipo_mensagem = 'T';
        }
    }

    $scope.submit = function () {
        $scope.getTipoEnvio();
        Loading.showAll();
        $scope.msg.sq_paciente = $scope.paciente.sq_paciente;

        $http(
            {
                method: 'POST',
                url: baseUrl + '/orthos/mensagem/enviar',
                data: $scope.msg
            }
        ).success(function (data) {
            Loading.hideAll();
            Form.growlMessage(data);

            if (data.success) {
                $scope.msg = {};
            }
        });
    }
}