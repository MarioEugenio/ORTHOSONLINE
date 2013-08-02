function cadastroClinicaCtrl ($scope, $http, $timeout) {
    var clinica = $('#j-clinica').val();
    $scope.form = (clinica)? angular.fromJson(clinica) : {};

    var contas = $('#contas').val();
    $scope.listContas = (contas)? angular.fromJson(contas) : [];

    var cadeiras = $('#cadeiras').val();
    $scope.listCadeira = (cadeiras)? angular.fromJson(cadeiras) : [];

    $scope.conta = {};
    $scope.cadeira = {};

    $scope.bancos = [
        {cod:'001', banco: 'Banco do Brasil'},
        {cod:'341', banco: 'Itaú Unibanco S.A.'},
        {cod:'184', banco: 'Banco Itaú BBA S.A.'},
        {cod:'479', banco: 'Banco ItaúBank S.A.'},
        {cod:'652', banco: 'Itaú Unibanco Holding S.A.'},
        {cod:'409', banco: 'UNIBANCO - União de Bancos Brasileiros S.A.'},
        {cod:'070', banco: 'BRB - Banco de Brasília S.A.'},
        {cod:'237', banco: 'Banco Bradesco S.A.'},
        {cod:'745', banco: 'Banco Citibank S.A.'}];

    $scope.init = function () {
        $(".cnpj").mask('99.999.999/9999-99');
        $(".fone").mask('(99)9999-9999');
        $('.time').mask('99:99');
        $('.number').numeric();
    }

    $scope.calcularMin = function () {
        if ($scope.form.nu_intervalo) {
            return (60 / $scope.form.nu_intervalo) + ' Minutos';
        }
    }

    $scope.viewBanco = function (cod) {
        var bancos = $scope.bancos;
        var retorno = '-';

        angular.forEach(bancos, function (itens) {
            if (itens.cod == cod) {
                retorno = itens.cod + ' - ' + itens.banco;
            }
        });

        return retorno;
    }

    $scope.validaEmail = function () {
        if ($scope.form.ds_email_clinica) {
            if (!Utils.validateEmail($scope.form.ds_email_clinica)) {
                Modal.growl('E-mail em formato inválido', 'error');
                $scope.form.ds_email_clinica = '';
                return false;
            }
        }

        return true;
    }

    $scope.removeContas = function (index) {
        var conf = confirm('Tem certeza que deseja apagar este registro?');
        if (conf) {
            $scope.listContas.splice(index, 1);
            Modal.growl('Registro removido com sucesso','success');
        }
    }

    $scope.removeCadeira = function (index) {
        var conf = confirm('Tem certeza que deseja apagar este registro?');
        if (conf) {
            $scope.listCadeira.splice(index, 1);
            Modal.growl('Registro removido com sucesso','success');
        }
    }

    $scope.addContas = function () {
        var conta = angular.copy($scope.conta);

        if (!conta.hasOwnProperty('nuBanco')){
            Modal.growl('Preencha o campo Nº do Banco','error');
            return false;
        }

        if (!conta.hasOwnProperty('nuAgencia')){
            Modal.growl('Preencha o campo Nº da Agência','error');
            return false;
        }

        if (!conta.hasOwnProperty('nuConta')){
            Modal.growl('Preencha o campo Nº da Conta','error');
            return false;
        }

        $scope.listContas.push(conta);

        Modal.growl('Registro cadastrado com sucesso','success');

        $scope.conta = {};
    }

    $scope.addCadeira = function () {
        var cadeira = angular.copy($scope.cadeira);

        if (!cadeira.noCadeira) {
            Modal.growl('Preencha o campo Nome da Cadeira','error');
            return false;
        }

        $scope.listCadeira.push(cadeira);

        Modal.growl('Registro cadastrado com sucesso','success');

        $scope.cadeira = {};
    }

    $scope.submit = function () {

        if (!$scope.validaEmail()) {
            return false;
        }

        $scope.form.nu_cnpj = $('.cnpj').val();

        $scope.form.listContas = $scope.listContas;
        $scope.form.listCadeiras = $scope.listCadeira;
        $scope.form.nu_telefone = $('.j-nu_telefone').val();
        $scope.form.nu_fax = $('.j-nu_fax').val();

        $http(
            {
                method: 'POST',
                url: baseUrl + '/orthos/clinica/save',
                data: $scope.form
            }
        ).success(function (data) {

                Form.growlMessage(data);

                if (data.success) {
                    Load.simple('#view-page', baseUrl + '/orthos/clinica');
                }
            });
    }

    $scope.pesquisa = function () {
        Load.simple('#view-page', baseUrl + '/orthos/clinica');
    }

    $scope.init();
}