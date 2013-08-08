
function alteracaoPacienteCtrl($scope, $http, $timeout) {
    var paciente = $('#paciente').val();
    var status = $('#status').val();
    var convenio = $('#listConvenios').val();

    $scope.paciente = (paciente)? angular.fromJson(paciente) : [];
    $scope.statusPacience = (status)? angular.fromJson(status) : [];
    $scope.listParcelas = [];
    $scope.estCivil = {};
    $scope.sexo = {};
    $scope.contato = {};
    $scope.transferencia = '';
    $scope.indicacao = '';
    $scope.mensagem = '';
    $scope.orcamento = '';
    $scope.convenio = (convenio)? angular.fromJson(convenio) : [];

    $scope.templates =
        [
            {name: 'Consultas', url: baseUrl + '/orthos/paciente/consultas/' + $scope.paciente.sq_paciente}
            ,{name: 'Prontuario', url: baseUrl + '/orthos/paciente/prontuario/' + $scope.paciente.sq_paciente}
            ,{name: 'Financeiro', url: baseUrl + '/orthos/paciente/financeiro/' + $scope.paciente.sq_paciente}
            ,{name: 'Mensagens', url: baseUrl + '/orthos/paciente/mensagens/' + $scope.paciente.sq_paciente}
            ,{name: 'Indicacao', url: baseUrl + '/orthos/paciente/indicacao/' + $scope.paciente.sq_paciente}
            ,{name: 'Prontuario', url: baseUrl + '/orthos/prontuario/cadastro'}
            ,{name: 'Transferencia', url: baseUrl + '/orthos/paciente/transferencia'}
            ,{name: 'Indicar', url: baseUrl + '/orthos/paciente/indicar'}
            ,{name: 'EnviarMensagem', url: baseUrl + '/orthos/paciente/enviarMensagem'}
            ,{name: 'Orcamento', url: baseUrl + '/orthos/financeiro/orcamento'}
        ];

    $scope.template = $scope.templates[1];

    $scope.setTemplate = function (index) {
        $scope.template = $scope.templates[index];
    }

    $scope.setTransferencia = function () {
        $scope.transferencia = $scope.templates[6].url;
    }

    $scope.setEnviarMensagem = function () {
        $scope.mensagem = $scope.templates[8].url;
    }

    $scope.setIndicacao = function () {
        $scope.indicacao = $scope.templates[7].url;
    }

    $scope.setOrcamento = function () {
        return $scope.orcamento = $scope.indicacao = $scope.templates[9].url;
    }

    $scope.loadContato = function () {
        var contato = $scope.paciente.fl_contato;
        if (contato == 'S') $scope.contato.sim = true;
        if (contato == 'N') $scope.contato.nao = true;
    }

    $scope.loadEstadoCivil = function () {
        var estCivil = $scope.paciente.fl_estado_civil;
        if (estCivil == 'S') $scope.estCivil.Solteiro = true;
        if (estCivil == 'C') $scope.estCivil.Casado = true;
        if (estCivil == 'V') $scope.estCivil.Viuvo = true;
        if (estCivil == 'D') $scope.estCivil.Divorciado = true;
    }

    $scope.loadSexo = function () {
        var sexo = $scope.paciente.fl_sexo;
        if (sexo == 'M') $scope.sexo.masculino = true;
        if (sexo == 'F') $scope.sexo.feminino = true;
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

    $scope.find = function () {
        var callback = function (data) {
            $scope.paciente = data;
            $scope.paciente.dt_nascimento = Utils.parseDate(data.dt_nascimento.date);
        };

        $http.post( baseUrl + '/orthos/paciente/find/' + $scope.paciente.sq_paciente, {}).success(callback);

    }

    $scope.init = function () {
        $scope.loadContato();
        $scope.loadEstadoCivil();
        $scope.loadSexo();

        var date = ($scope.paciente.dt_nascimento.date);
        $scope.paciente.dt_nascimento = Utils.parseDate(date);

        $('.j-cpf').mask('999.999.999-99');
        $('.j-cpf-responsavel').mask('999.999.999-99');
        $('.date').mask('99/99/9999');
        $('.fone').mask('(99)9999-9999');
        $('#myTab a:last').tab('show');

        $scope.parcelasAtrasadas($scope.paciente.sq_paciente);
        $scope.find();
    }

    $scope.parcelasAtrasadas = function (id) {
        var callbackParc = function (data) {
            $scope.listParcelas = data;
        };

        $http.post( baseUrl + '/orthos/financeiro/listParcelasAtrasadaPaciente/' + id, {}).success(callbackParc);

    }


    $scope.validaEmail = function () {
        if ($scope.paciente.ds_email) {
            if (!Utils.validateEmail($scope.paciente.ds_email)) {
                Modal.growl('E-mail em formato inválido', 'error');
                $scope.paciente.ds_email = '';
                return false;
            }
        }

        return true;
    }

    $scope.submit = function () {

        if (!$scope.validaEmail()) {
            return false;
        }

        $scope.paciente.fl_sexo = $scope.getSexo();
        $scope.paciente.fl_estado_civil = $scope.getEstadoCivil();
        $scope.paciente.fl_contato = $scope.getContato();
        $scope.paciente.dt_nascimento = $('.date').val();
        $scope.paciente.nu_residencial = $('.j-fone-residencial').val();
        $scope.paciente.nu_celular = $('.j-fone-celular').val();
        $scope.paciente.nu_cpf = $('.j-cpf').val();
        $scope.paciente.nu_cpf_responsavel = $('.j-cpf-responsavel').val();

        $http(
            {
                method: 'POST',
                url: baseUrl + '/orthos/paciente/save',
                data: $scope.paciente
            }
        ).success(function (data) {
                Form.growlMessage(data);

                if (data.success) {
                    Load.simple('#view-page', baseUrl + '/orthos/paciente');
                }
            });
    }

    $scope.pesquisar = function () {
        Load.simple('#view-page', baseUrl + '/orthos/paciente');
    }

    $scope.init();
};