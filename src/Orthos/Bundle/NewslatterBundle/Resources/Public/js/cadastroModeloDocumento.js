
function cadastroModeloDocumentoCtrl($scope, $http) {
    $scope.form = {};
    $scope.listModeloDocumento = ($('#listModeloDocumento').val())? angular.fromJson($('#listModeloDocumento').val()) : [];
    $scope.listPacientes = ($('#listPacientes').val())? angular.fromJson($('#listPacientes').val()) : [];

    $scope.defineSexo = function (item) {
        if (item.fl_sexo == 'M') return 'Masculino';

        return 'Feminino';
    }

    $scope.submit = function () {
        $scope.form.tx_header = $(".j-tx-header").val();
        $scope.form.tx_body = $(".j-tx-body").val();
        $scope.form.tx_footer = $(".j-tx-footer").val();

        $http(
            {
                method: 'POST',
                url: baseUrl + '/orthos/modeloDocumento/save',
                data: $scope.form
            }
        ).success(function (data) {
            Form.growlMessage(data);

            if (data.success) {
                Load.simple('#view-page', baseUrl + '/orthos/modeloDocumento');
            }
        });
    }
}