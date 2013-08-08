function cadastroUsuarioCtrl ($scope, $http, $timeout) {
    var perfil = $('#listPerfil').val();
    var clinica = $('#listClinica').val();
    var usuario = $('#usuario').val();

    $scope.listPerfil = (perfil)? Utils.mapBy('sqPerfil',angular.fromJson(perfil)) : [];
    $scope.listClinica = (clinica)? Utils.mapBy('sqClinica',angular.fromJson(clinica)) : [];
    $scope.form = (usuario)? angular.fromJson(usuario) : {};
    $scope.edit = false;
    $scope.atendente = {};
    $scope.medico = {};

    $scope.checkPassword = function () {
        var senha = $scope.form.tx_senha;
        var repete = $scope.form.tx_r_senha;

        if ((repete) && (senha)) {
            if (repete != senha) {
                Modal.growl('Repita novamente a senha', 'error');
                return false;
            }
        }

        return true;
    }

    $scope.showPassword = function () {
        if ($('#usuario').val()) {
            return false;
        }

        return true;
    }

    $scope.validaEmail = function () {
        if ($scope.form.ds_email) {
            if (!Utils.validateEmail($scope.form.ds_email)) {
                Modal.growl('E-mail em formato inválido', 'error');
                $scope.form.ds_email = '';
                return false;
            }
        }

        return true;
    }

    $scope.getAtendente = function () {
        if ($scope.atendente.sim) {
            return true;
        }

        if ($scope.atendente.nao) {
            return false;
        }
    }

    $scope.getMedico = function () {
        if ($scope.medico.sim) {
            return true;
        }

        if ($scope.medico.nao) {
            return false;
        }
    }

    $scope.selectedPerfil = function () {
        var perfil = [];
        var perfis = $scope.form.sqPerfil;

        if (perfis) {
            angular.forEach(perfis, function (item) {
                perfil.push(item.sq_perfil);
            });
        }

        $scope.form.sqPerfil = perfil;
    }

    $scope.selectedClinica = function () {
        var clinica = [];
        var clinica = $scope.form.sqClinicas;

        if (clinica) {
            angular.forEach(clinica, function (item) {
                clinica.push(item.sq_clinica);
            });
        }

        $scope.form.sqClinicas = clinica;
    }

    $scope.init = function () {
        $scope.selectedPerfil();
        $scope.selectedClinica();

        if ($scope.form.fl_atendente == true) {
            $scope.atendente.sim = true;
        } else  {
            $scope.atendente.nao = true;
        }

        if ($scope.form.fl_medico == true) {
            $scope.medico.sim = true;
        } else  {
            $scope.medico.nao = true;
        }
    }

    $scope.submit = function () {
        if (!$scope.validaEmail()) {
            return false;
        }

        if (!$scope.checkPassword()) {
            return false;
        }

        if ($('#sqUsuario').val()) {
            $scope.form.sq_usuario = $('#sqUsuario').val();
        }

        $scope.form.fl_atendente = $scope.getAtendente();
        $scope.form.fl_medico = $scope.getMedico();

        $http(
            {
                method: 'POST',
                url: baseUrl + '/usuario/save',
                data: $scope.form
            }
        ).success(function (data) {
            Form.growlMessage(data);

            if (data.success) {
                Load.simple('#view-page', baseUrl + '/usuario');
            }
        });
    }

    $scope.pesquisa = function () {
        Load.simple('#view-page', baseUrl + '/usuario');
    }

    $scope.init();

}