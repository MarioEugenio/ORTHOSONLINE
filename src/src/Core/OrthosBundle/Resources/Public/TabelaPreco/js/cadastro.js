function cadastroTabelaPrecoCtrl ($scope, $http, $timeout) {
    var tabelaPreco = $('#tabelaPreco').val();
    $scope.form = (tabelaPreco)? angular.fromJson(tabelaPreco) : {};
    $scope.especialidade = {};
    $scope.aparelho = {};

    $scope.init = function () {
        $(".money").maskMoney();
        $scope.aparelho.nao = true;

        if ($scope.form.sq_especialidade) {
            $scope.especialidade = {};
            switch ($scope.form.sq_especialidade) {
                case 1:
                    $scope.especialidade.ortodontia = true;
                    break
                case 2:
                    $scope.especialidade.clinicaGeral = true;
                    break;
            }
        }

        if ($scope.form.fl_fixo) {
            $scope.aparelho = {};
            switch ($scope.form.fl_fixo) {
                case true:
                    $scope.aparelho.sim = true;
                    break
                case false:
                    $scope.aparelho.nao = true;
                    break;
            }
        }
    }

    $scope.getAparelho = function () {
        if ($scope.aparelho.sim) {
            return true;
        }

        if ($scope.aparelho.nao) {
            return false;
        }
    }

    $scope.getEspecialidade = function () {
        if ($scope.especialidade.ortodontia) {
            return 1;
        }

        if ($scope.especialidade.clinicaGeral) {
            return 2;
        }
    }

    $scope.submit = function () {
        $scope.form.vl_total = $('.money').val();
        $scope.form.sq_especialidade = $scope.getEspecialidade();
        $scope.form.fl_fixo = $scope.getAparelho();

        $http(
            {
                method: 'POST',
                url: baseUrl + '/tabelaPreco/save',
                data: $scope.form
            }
        ).success(function (data) {

                Form.growlMessage(data);

                if (data.success) {
                    Load.simple('#view-page', baseUrl + '/tabelaPreco');
                }
            });
    }

    $scope.pesquisa = function () {
        Load.simple('#view-page', baseUrl + '/tabelaPreco');
    }

    $scope.init();
}