function prontuarioCtrl ($scope, $http) {
    var list = $('#listProntuario').val();
    $scope.list = (list)? angular.fromJson(list) : [];

    var listMedia = $('#listProntuarioMedia').val();
    $scope.listMedia = (listMedia)? angular.fromJson(listMedia) : [];

    $scope.dt = {};
    $scope.dtMedia = {};
    $scope.visible = {};
    $scope.especialidade = {};
    $scope.pront = {
        tx_alerta_medico: ""
    };
    $scope.templateMedia = "";

    $scope.getCadastroProntuario = function () {
        return baseUrl + '/orthos/prontuario/cadastro/' + $scope.paciente.sq_paciente;
    }

    $scope.getUploadMedia = function () {
        $scope.templateMedia = baseUrl + '/orthos/media';
    }

    $scope.init = function () {
        $scope.pront.sq_paciente = $scope.paciente.sq_paciente;
        $scope.pront.nu_previsao = $scope.paciente.nu_previsao;
        $scope.pront.tx_diagnostico = $scope.paciente.tx_diagnostico;
        $scope.pront.tx_plano_tratamento = $scope.paciente.tx_plano_tratamento;
        $scope.pront.tx_sequencia_mecanica = $scope.paciente.tx_sequencia_mecanica;
        $scope.pront.tx_convenio = $scope.paciente.tx_convenio;
        $scope.pront.tx_evolucao = $scope.paciente.tx_evolucao;
        $scope.pront.tx_alerta_medico = ($scope.paciente.hasOwnProperty('tx_alerta_medico'))? $scope.paciente.tx_alerta_medico : "";

        $('.number').numeric();

        $scope.visible.prontuario = true;
        $scope.especialidade.ortodontia = true;

        $scope.dt = Grid.gridPagination('#GridProntuario');
        $scope.dtMedia = Grid.gridPagination('#GridProntuarioMedia');

        $scope.loadList();
        //$scope.loadListMedia();

        $('.screenshots a').click(function(e){
            e.preventDefault();
            if ($('#modal_ss').length < 1){
                $('body').append('<div class="modal hide fade" id="modal_ss" style="width:800px;margin-left:50%; left:-400px;"><div class="modal-body"><img src=""></div><div class="modal-footer"><a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Fechar</a></div></div>');
            }
            var imgScreen = $(this).attr('href');
            $('#modal-shots img').attr('src', imgScreen);
            $("#modal-shots").modal('show');
        });
    }

    $scope.classPlanoTratamento = function () {
        if ($scope.pront.tx_alerta_medico.length > 0) {
            return 'alert alert-error';
        }

        return;
    }

    $scope.autosave = function () {

        $http(
            {
                method: 'POST',
                url: baseUrl + '/orthos/paciente/saveProntuario',
                data: $scope.pront
            }
        ).success(function (data) {
                Form.growlMessage(data);
            });
    }

    $scope.setVisible = function (view) {
        $scope.visible.prontuario = false;
        $scope.visible.media = false;
        $scope.visible.planejamento = false;
        $scope.visible.observacao = false;

        switch (view) {
            case 1:
                $scope.visible.prontuario = true;
                break;
            case 2:
                $scope.visible.media = true;
                break;
            case 3:
                $scope.visible.observacao = true;
                break;
            case 4:
                $scope.visible.planejamento = true;
                break;
        }
    }

    $scope.formataProcedimentos = function (data) {
        if (data.length) {
            var retorno = [];
            angular.forEach(data, function (item) {
                retorno.push(item.noProcedimento);
            });

            retorno[0] = '<li class="icon-asterisk"></li> ' + retorno[0];
            return retorno.join(' <br> <li class="icon-asterisk"></li> ');
        }

        return;
    }

    $scope.addListProntuario = function (data) {

        var rows = [];
console.log(data);
        var row = {
            0: Utils.parseDate(data.dt_procedimento.date)
            ,1: (data.realizados.length > 0)? $scope.formataProcedimentos(data.realizados) : '-'
            , 2: (data.arealizar.length > 0)? $scope.formataProcedimentos(data.arealizar) : '-'
            , 3: (data.thd)? data.thd.no_usuario : '-'
            , 4: (data.txObservacao)? data.txObservacao : '-'
            , 5: data.no_usuario
        };

        rows.push(row);

        Grid.addRow($scope.dt, rows);
    }

    $scope.loadList = function () {

        Grid.removeAllRows($scope.dt);

        if ($scope.list.length) {

            var rows = [];
            var row = {};
            angular.forEach($scope.list, function (item) {

                row = {
                    0:item.dt_procedimento
                    ,1: (item.realizados.length > 0)? $scope.formataProcedimentos(item.realizados) : '-'
                    , 2: (item.arealizar.length > 0)? $scope.formataProcedimentos(item.arealizar) : '-'
                    , 3: item.no_atendente
                    , 4: (item.txObservacao)? item.txObservacao : '-'
                    , 5:item.no_usuario
                };

                rows.push(row);
            });

            Grid.addRow($scope.dt, rows);
        }
    }

    $scope.modalMedia = function (item) {
        $('#img_'+ item.sq_imagem).modal('show');
    }

    $scope.loadListMedia = function () {

        Grid.removeAllRows($scope.dtMedia);

        if ($scope.listMedia.length) {

            var rows = [];
            var row = {};
            angular.forEach($scope.listMedia, function (item) {
                var img = '<a class="screenshots" style="cursor: pointer;" onclick="$(\'#img_'+ item.sq_imagem +'\').modal(\'show\');" >';
                img += '<img width="70" src="/web/uploads/tmp/' + item.no_arquivo +'" class="img-polaroid">';
                img += '</a>';

                img += '';
                img += '<div class="row"><img src="/web/uploads/tmp/' + item.no_arquivo +'"></div>';
                img += '<div class="row"><small class="left"><strong>Data:</strong> '+item.dt_cadastro+' </small><small class="right">- <strong>Publicado por:</strong> '+item.no_usuario+' </small></div>';
                img += '</div>';

                row = {
                    0: img
                    ,1: item.dt_cadastro
                    , 2: item.no_usuario
                };

                rows.push(row);
            });

            Grid.addRow($scope.dtMedia, rows);
        }
    }

    $scope.init();
}