
function cadastroNewslatterCtrl($scope, $http) {
    $scope.form = {};
    $scope.listModeloDocumento = ($('#listModeloDocumento').val())? angular.fromJson($('#listModeloDocumento').val()) : [];
    $scope.listPacientes = ($('#listPacientes').val())? angular.fromJson($('#listPacientes').val()) : [];

    $scope.defineSexo = function (item) {
        if (item.fl_sexo == 'M') return 'Masculino';

        return 'Feminino';
    }

    $scope.submit = function () {
        $http(
            {
                method: 'POST',
                url: baseUrl + '/orthos/newslatter/save',
                data: $scope.form
            }
        ).success(function (data) {
            Form.growlMessage(data);

            if (data.success) {
                Load.simple('#view-page', baseUrl + '/orthos/newslatter');
            }
        });
    }
}