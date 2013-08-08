

function cadastroPacienteCtrl($scope, $http) {
    var convenio = $('#listConvenios').val();
    $scope.form = {};
    $scope.estCivil = {};
    $scope.sexo = {};
    $scope.contato = {};
    $scope.convenio = (convenio)? angular.fromJson(convenio) : [];

    $scope.init = function () {
        $('.number').numeric();
        $('.cpf').mask('999.999.999-99');
        $('.fone').mask('(99)9999-9999');
        $('.date').mask('99/99/9999');
    }

    $scope.getContato = function () {
        var contato = $scope.contato;
        var retorno;

        if (contato.sim) retorno = 'S';
        if (contato.nao) retorno = 'N';

        return retorno;
    }

    $scope.getSexo = function () {
        var sexo = $scope.sexo;
        var retorno;

        if (sexo.masculino) retorno = 'M';
        if (sexo.feminino) retorno = 'F';

        return retorno;
    }

    $scope.getEstadoCivil = function () {
        var estCivil = $scope.estCivil;
        var retorno;

        if (estCivil.Casado) retorno = 'C';
        if (estCivil.Solteiro) retorno = 'S';
        if (estCivil.Viuvo) retorno = 'V';
        if (estCivil.Divorciado) retorno = 'D';

        return retorno;
    }

    $scope.validaCPF = function () {
        var cpf = $('.j-cpf').val();

        if (!Utils.validaCPF(cpf)) {
            Modal.growl('CPF em formato inválido', 'error');
            $scope.form.nu_cpf = '';
            return false;
        }

        $scope.form.nu_cpf = cpf;

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

    $scope.submit = function () {

        if (!$scope.validaEmail()) {
            return false;
        }

        if (!$scope.validaCPF()) {
            return false;
        }

        $scope.form.fl_sexo = $scope.getSexo();
        $scope.form.fl_estado_civil = $scope.getEstadoCivil();
        $scope.form.fl_contato = $scope.getContato();
        $scope.form.dt_nascimento = $('.date').val();
        $scope.form.nu_residencial = $('.j-fone-residencial').val();
        $scope.form.nu_celular = $('.j-fone-celular').val();
        $scope.form.nu_cpf_responsavel = $('.j-cpf-responsavel').val();

        $http(
            {
                method: 'POST',
                url: baseUrl + '/orthos/paciente/save',
                data: $scope.form
            }
        ).success(function (data) {
            Form.growlMessage(data);

            if (data.success) {
                Load.simple('#view-page', baseUrl + '/orthos/paciente');
            }
        });
    }

    $scope.pesquisa = function () {
        Load.simple('#view-page', baseUrl + '/orthos/paciente');
    }

    $scope.init();
}