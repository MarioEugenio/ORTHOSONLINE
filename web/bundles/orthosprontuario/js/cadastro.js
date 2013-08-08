function cadastroProntuarioCtrl ($scope, $http) {
    var consultas = $('#consultas').val();
    $scope.especialidade = {};
    $scope.typeahead = {};
    $scope.tmpAutocomplete = [];
    $scope.listProcedimentoRealizados = [];
    $scope.listProcedimentoARealizar = [];
    $scope.consultas = (consultas)? angular.fromJson(consultas) : [];
    $scope.form = {};
    $scope.alert = "";
    $scope.cadastro = false;
    $scope.proc = {};

    $scope.init = function () {
        $scope.especialidade.ortodontia = true;
        $scope.alert = "";
        $(".money").maskMoney();
    }

    $scope.convertDate = function (date) {
        return Utils.parseDate(date);
    }

    $scope.viewCadastro = function () {
        if ($scope.cadastro) {
            return true;
        }

        return false;
    }



    $scope.getEspecialidade = function () {
        if ($scope.especialidade.ortodontia) {
            return 1;
        }

        if ($scope.especialidade.clinicaGeral) {
            return 2;
        }
    }

    $scope.removeProcedimentoRealizado = function (index) {
        $scope.listProcedimentoRealizados.splice(index, 1);
    }

    $scope.removeProcedimentoARealizar = function (index) {
        $scope.listProcedimentoARealizar.splice(index, 1);
    }

    $scope.addProcedimentoRealizado = function () {
        if (!$scope.form.procedimento1) {
            $scope.alert = 'Selecione um procedimento para ser adicionado';
            return;
        }

        $scope.listProcedimentoRealizados.push({
            sqProcedimento: $scope.tmpAutocomplete['sqProcedimento1'],
            noProcedimento: $scope.form.procedimento1
        });

        $scope.form.procedimento1 = "";
    }

    $scope.addProcedimentoARealizar = function () {
        if (!$scope.form.procedimento2) {
            $scope.alert = 'Selecione um procedimento para ser adicionado';
            return;
        }

        $scope.listProcedimentoARealizar.push({
            sqProcedimento: $scope.tmpAutocomplete['sqProcedimento2'],
            noProcedimento: $scope.form.procedimento2
        });

        $scope.form.procedimento2 = "";
    }

    $scope.autocompleteProcedimento = function(query, what) {

        var callback = function (data) {
            $scope.typeahead = data;
        };

        $http.post( baseUrl + '/orthos/procedimento/autocomplete',
            {
                query : query,
                especialidade: $scope.getEspecialidade()
            }
        ).success(callback);

        return $.map($scope.typeahead, function(value) {
            return value.value;
        });

    }

    $scope.valida = function () {
        if ((!$scope.listProcedimentoRealizados.length) && (!$scope.listProcedimentoARealizar.length)) {
            $scope.alert = 'Adicione pelo menos um procedimento para completar o processo';
            return false;
        }

        return true;
    }

    $scope.validaProcedimento = function () {
        if ((!$scope.proc.no_procedimento)) {
            $scope.alert = 'O campo Nome do procedimento é obrigatório';
            return false;
        }

        if ((!$scope.proc.ortodontia) && (!$scope.proc.clinicaGeral)) {
            $scope.alert = 'O campo Especialidade é obrigatório';
            return false;
        }

        return true;
    }

    $scope.cadastrarProcedimento = function () {
        if (!$scope.validaProcedimento()) {
            return;
        }

        var callback = function (data) {
            if (data.success) {
                $scope.success = data.message;
                $scope.proc = {};
                $scope.cadastro = false;
            }
        };

        $http.post( baseUrl + '/orthos/procedimento/save',
        $scope.proc
        ).success(callback);
    }

    $scope.submit = function () {

        if (!$scope.valida()) {
            return;
        }

        var callback = function (data) {
            Form.growlMessage(data);

            if (data.success) {
                $scope.typeahead = {};
                $scope.tmpAutocomplete = [];
                $scope.listProcedimentoRealizados = [];
                $scope.listProcedimentoARealizar = [];
                $scope.form = {};
                $scope.alert = "";
                $scope.success = "";
                $('#prontuario').modal('hide');

                $scope.dt = Grid.gridPagination('#GridProntuario');

                $scope.addListProntuario(data.result);
            }
        };

        $http.post( baseUrl + '/orthos/prontuario/save',
            {
                'realizados' : $scope.listProcedimentoRealizados,
                'arealizar' : $scope.listProcedimentoARealizar,
                'sqPaciente' : $('#sqPaciente').val(),
                'txObservacao' : $scope.form.tx_observacao,
                'sq_agenda' : $scope.form.sq_agenda
            }
        ).success(callback);
    }

    $scope.init();
}