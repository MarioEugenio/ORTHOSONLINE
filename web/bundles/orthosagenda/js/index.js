

function indexCtrl($scope, $http, $timeout) {
{
    var clinicas = $('#listClinica').val();

    $scope.listAgenda = [];
    $scope.listClinica = (clinicas)? angular.fromJson(clinicas) : [];
    $scope.date = "";
    $scope.clinica = {};
    $scope.tmpItem = [];
    $scope.listProntuario = [];
    $scope.listParcelas = [];
    $scope.listConsultas = [];
    $scope.tmpAutocomplete = [];
    $scope.formModal = {};
    $scope.typeahead = [];
    $scope.paciente = {};
    $scope.atendente = {};
    $scope.sq_agenda = null;
    $scope.agenda = {};
    $scope.btagendar = false;
    $scope.dataAtendente = [];
    $scope.dataDentista = [];
    $scope.confirmDendista = false;

    $scope.dateCurrent = function () {
        var datetime = new Date();
        var day = datetime.getDate().toString();
        var month = (datetime.getMonth() + 1).toString();
        var year = datetime.getFullYear();

        if (day.length == 1) {
            day = '0' + day;
        }

        if (month.length == 1) {
            month = '0' + month;
        }

        return day + '/' + month + '/' + year;
    }

    $scope.setAgendaManual = function () {
        $scope.date = $('#dataManual').val();
        $scope.listAgenda = [];
        $scope.loadAgenda();
        $('#myModal').modal('hide');
    }

    $scope.initAgenda = function () {
        var clinica = $('#clinica').val();
        $scope.clinica = (clinica)? angular.fromJson(clinica).sq_clinica : {};

        $('.date').mask('99/99/9999');

        var i = 6;
        $scope.date = $scope.dateCurrent();

        $("#j-boxCalendar").calendarPicker({callback:function(cal){
            $timeout(function () {
                var datetime = new Date(cal.currentDate);
                var day = datetime.getDate().toString();
                var month = (datetime.getMonth() + 1).toString();
                var year = datetime.getFullYear();

                if (day.length == 1) { day = '0' + day; }

                if (month.length == 1) { month = '0' + month; }

                $scope.date = day + '/' + month + '/' + year;
                $scope.listAgenda = [];
                $scope.loadAgenda();
                $('#myModal').modal('hide');
            }, 0);
        }});


        $scope.loadAgenda = function () {
            Loading.showAll();
            $scope.listAgenda = [];

           var callback = function (data) {
               angular.forEach(data, function (value,key) {
                   $scope.listAgenda.push(value);
               });

               $scope.checkStatus();
               Loading.hideAll();
           };

           $http.post( 'agenda/load',{date: $scope.date, clinica: $scope.clinica}).success(callback);

        }

        $scope.checkTime = function (item) {
            var datetime = new Date();

            var date = $scope.date.split('/');

            var hora = item.idTime;
            if (hora.length == 1) hora = '0' + hora;
            hora = hora + ':00:00';

            var datetimeValid = new Date();
            datetimeValid.setDate(date[0]);
            datetimeValid.setMonth(parseInt(date[1]) - 1);
            datetimeValid.setFullYear(parseInt(date[2]));
            datetimeValid.setHours(parseInt(hora));
            datetimeValid.setMinutes(59);

            if (datetimeValid <= datetime) {
                return true;
            }

            return false;
        }

        $scope.top = function () {
            var datetime = new Date();
            var time = datetime.getHours();

            if ($("#time_"+(time - 1)).length) {
                $('html, body').animate({
                    scrollTop: $("#time_"+(time - 1)).offset().top
                }, 2000);
            }
        }

        $scope.initScroll = function () {
            $scope.agenda = $timeout(function () {

                //$scope.top();
                $scope.initScroll();
                $scope.checkStatus();
            }, 20000);



        }

        $scope.initScrollSimple = function () {
            var datetime = new Date();
            var time = datetime.getHours();

            $('html, body').animate({
                scrollTop: $("#time_"+(time - 1)).offset().top
            }, 2000);
        }

        $scope.checkAgendamento = function (item, item2) {
            if (!item2.hasOwnProperty('paciente')) return true;

            if (item2.hasOwnProperty('paciente')) {
                if ((item2.paciente.hasOwnProperty('nome'))) {
                    if ((!item2.paciente.nome)) {
                        if (!$scope.checkTime(item)) {
                            return true;
                        }
                    }
                }
            }

            return false;
        }

        $scope.checkAcoesObservacao = function (item, item2) {
            if (item2.tx_observacao) {
                //if (!$scope.checkTime(item)) {
                    return true;
                //}
            }

            return false;
        }

        $scope.checkAcoesTransferencia = function (item, item2) {
            if (item2.hasOwnProperty('paciente')) {
                if (item2.paciente.nome) {
                    if (!$scope.checkTime(item)) {
                        return true;
                    }
                }
            }

            return false;
        }

        $scope.checkAcoesEdicao = function (item, item2) {
            if (item2.hasOwnProperty('paciente')) {
                if (item2.paciente.nome) {
                    //if (!$scope.checkTime(item)) {
                        return true;
                    //}
                }
            }

            return false;
        }

        $scope.checkAcoesCancelamento = function (item, item2) {
            if (item2.hasOwnProperty('paciente')) {
                if (item2.paciente.nome) {
                    if (!$scope.checkTime(item)) {
                        return true;
                    }
                }
            }

            return false;
        }

        $scope.getDateAgenda = function () {
            return $scope.date;
        }

        $scope.agendar = function (item) {
            $('#agendarModal').modal();
        }

        $scope.getBackground = function(item, item2) {
            if (item2.hasOwnProperty('paciente')) {
                if (!item2.paciente.nome) {
                    if ($scope.checkTime(item)) {
                        return "#CCC";
                    }
                }
            }

            return item2.status;
        };

        $scope.setIndex = function (row, colunm, item, item2) {
            $scope.tmpItem = {};

            $scope.listParcelas = [];
            $scope.listProntuario = [];
            $scope.tmpAutocomplete = [];

            $scope.tmpItem = {
                "row": row,
                "colunm": colunm,
                "edit": false,
                "date" : $scope.date,
                "time" : item.time,
                "item": item2
            };

            $('#agendarModal').modal('show');
        }

        $scope.agendarLoad = function (id) {

            Load.execute('#agendarModal', '/orthos/agendar', {
                sq_agenda: id
            }, function () {
                $('#agendarModal').modal('show');
            });
        }

        $scope.setStatus = function (formModal, status) {
            var row = $scope.tmpItem.row;
            var colunm = $scope.tmpItem.colunm;

            $http(
                {
                    method: 'POST',
                    url: baseUrl + '/orthos/agenda/status/'+formModal.sqAgenda+'/'+status,
                    data: {}
                }
            ).success(function (data) {
                Form.growlMessage(data);

                var agenda = $scope.listAgenda;

                switch (status) {
                    case 2:
                        agenda[row].cadeiras[colunm].status = '#F4ADAD';
                        agenda[row].cadeiras[colunm].dtChegada = Utils.getTime();
                        break;
                    case 4:
                        agenda[row].cadeiras[colunm].status = '#A8D9F7';
                        break;
                    case 5:
                        agenda[row].cadeiras[colunm].status = '#B2F7CE';
                        break;

                }

                $scope.clear();
            });
        }

        $scope.setEdit = function (row, colunm, item, item2) {
            $scope.tmpItem = {};
            $scope.listParcelas = [];
            $scope.listProntuario = [];
            $scope.tmpAutocomplete = [];


            $scope.tmpItem = {
                "row": row,
                "colunm": colunm,
                "edit": true,
                "date" : $scope.date,
                "time" : item.time,
                "item": item2
            };

            $scope.formModal.no_paciente = item2.paciente.nome;

            $scope.formModal.sq_atendente = item2.sq_atendente;
            $scope.formModal.no_atendente = item2.no_atendente;

            $scope.formModal.sq_dentista = item2.sq_dentista;
            $scope.formModal.no_dentista = item2.no_dentista;

            $scope.formModal.sqAgenda = item2.sqAgenda;

            if (item2.paciente.hasOwnProperty('matricula')) {
                $scope.formModal.nu_matricula = item2.paciente.matricula
            }

            if (item2.hasOwnProperty('atendente')) {
                $scope.formModal.no_usuario = item2.atendente.nome;
            }

            if (item2.hasOwnProperty('tx_observacao')) {
                $scope.formModal.tx_observacao = item2.tx_observacao;
            }

            if (item2.paciente.hasOwnProperty('telefone')) {
                $scope.formModal.nu_paciente = item2.paciente.telefone;
            }

            if (item2.paciente.id) {
                $scope.setPacientePorId(item2.paciente.id);
            }


            $('#agendarModal').modal('show');
        }

        $scope.accessUser = function (item2) {
            Load.simple('#view-page', baseUrl + '/orthos/paciente/alteracao/'+item2.paciente.id);
        }

        $scope.agendarConsulta = function () {
            var row = $scope.tmpItem.row;
            var colunm = $scope.tmpItem.colunm;


            $scope.formModal.date = $scope.tmpItem.date;
            $scope.formModal.time = $scope.tmpItem.time;
            $scope.formModal.sq_cadeira = ($scope.tmpItem.item.hasOwnProperty('sqCadeira')) ? $scope.tmpItem.item.sqCadeira : 0;
            $scope.formModal.nu_row = $scope.tmpItem.row;
            $scope.formModal.nu_colunm = $scope.tmpItem.colunm;

            $http(
                {
                    method: 'POST',
                    url: baseUrl + '/orthos/agenda/save',
                    data: $scope.formModal
                }
            ).success(function (data) {
                    Form.growlMessage(data);

                    if (data.success) {
                        $scope.btagendar = false;
                        var agenda = angular.copy($scope.listAgenda);

                        agenda[row].cadeiras[colunm].paciente.nome = $scope.formModal.no_paciente;
                        agenda[row].cadeiras[colunm].paciente.matricula = $scope.formModal.nu_matricula;

                        if (data.result.paciente != null) {
                            agenda[row].cadeiras[colunm].paciente.id = data.result.paciente.sq_paciente;
                        }

                        agenda[row].cadeiras[colunm].sq_atendente = $scope.formModal.sq_atendente;
                        agenda[row].cadeiras[colunm].no_atendente = $scope.formModal.no_atendente;
                        agenda[row].cadeiras[colunm].no_dentista = $scope.formModal.no_dentista;
                        agenda[row].cadeiras[colunm].sq_dentista = $scope.formModal.sq_dentista;
                        agenda[row].cadeiras[colunm].sqAgenda = data.result.sq_agenda;
                        agenda[row].cadeiras[colunm].status = '#EFF4BC';
                        agenda[row].cadeiras[colunm].tx_observacao = $scope.formModal.tx_observacao;

                        $scope.listAgenda = agenda;

                        $scope.formModal = {};
                        $scope.tmpItem = {};
                        $scope.tmpAutocomplete = [];
                        $scope.typeahead = [];
                        $scope.listProntuario = [];
                        $scope.listParcelas = [];
                    }
                });

        }

        $scope.clear = function () {
            $scope.formModal = {};
            $scope.tmpItem = {};
            $scope.tmpAutocomplete = [];
            $scope.typeahead = [];
        }

        $scope.getMatricula = function () {
            var id = $('.j-paciente').attr('typeaheadId');

            $timeout(function () {
                if ($scope.tmpAutocomplete.hasOwnProperty(id)) {
                    if ($scope.tmpAutocomplete[id]) {
                        $scope.setPacientePorId($scope.tmpAutocomplete[id]);
                    }
                }
            }, 500);

        }

        $scope.efetivaAgendado = function () {
            $scope.getMatricula();
            $scope.btagendar = true;
        }

        $scope.viewAgendar = function () {
            if (($scope.tmpItem.edit == false) && ($scope.btagendar)) {
                return true;
            }

            return false;
        }

        $scope.setPacientePorId = function (id) {
            var callback = function (data) {
                $scope.paciente = data;

                $scope.formModal.nu_matricula = $scope.paciente.nuMatricula;
                $scope.formModal.sq_paciente = $scope.paciente.sqPaciente;

                $scope.formModal.tx_alerta_medico = $scope.paciente.txAlertaMedico;

                var telefone = ((data.nuResidencial)? data.nuResidencial : '') + ((data.nuCelular)? ' / '+ data.nuCelular : '');
                $scope.formModal.nu_paciente = telefone;
            };

            $http.post( baseUrl + '/orthos/paciente/search/' + id, {}).success(callback);

            $scope.listProntuario = [];

            var callbackPront = function (data) {
                $scope.listProntuario = data;
            };

            $http.post( baseUrl + '/orthos/prontuario/list/' + id, {}).success(callbackPront);

            var callbackParc = function (data) {
                $scope.listParcelas = data;
            };

            $http.post( baseUrl + '/orthos/financeiro/listParcelasAtrasadaPaciente/' + id, {}).success(callbackParc);

        }

        $scope.pesquisarConsulta = function () {
            var id = $('.j-pesquisa').attr('typeaheadId');

            console.log($scope.tmpAutocomplete[id]);
            if ($scope.tmpAutocomplete[id]) {
                var callback = function (data) {
                    $scope.listConsultas = data;
                };

                var id = $scope.tmpAutocomplete[id];

                $http.post( baseUrl + '/orthos/paciente/consultasPesquisa/' + id, {}).success(callback);
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

        $scope.autocompletePaciente = function(query, what) {

            $scope.formModal.nu_matricula = null;

            var callback = function (data) {
                $scope.typeahead = data;
            };

            $http.post( baseUrl + '/orthos/paciente/autocomplete', {query : query}).success(callback);

            return $.map($scope.typeahead, function(value) {
                return value.value;
            });

        }

        $scope.getAtendente = function () {
            var id = $('.j-atendente').attr('typeaheadId');

            $timeout(function () {
                 $scope.formModal.sq_atendente = $scope.tmpAutocomplete[id];

            }, 300);
        }

        $scope.setAtendentePorId = function (id) {
            var callback = function (data) {
                $scope.atendente = data;
            };

            $http.post( 'usuario/search/' + id, {}).success(callback);
        }

        $scope.autocompleteAtendente = function(query, what) {

            var callback = function (data) {
                $scope.typeahead = data;
            };

            $http.post( 'usuario/atendente', {query : query}).success(callback);

            return $.map($scope.typeahead, function(value) {
                return value.value;
            });

        }

        $scope.autocompleteDentista = function(query, what) {

            var callback = function (data) {
                $scope.typeahead = data;
            };

            $http.post( 'usuario/medico', {query : query}).success(callback);

            return $.map($scope.typeahead, function(value) {
                return value.value;
            });

        }

        $scope.getDentista = function () {
            var id = $('.j-dentista').attr('typeaheadId');

            $timeout(function () {
                $scope.formModal.sq_dentista = $scope.tmpAutocomplete[id];
                $scope.confirmDendista = true;
                console.log($scope.tmpAutocomplete);
            }, 300);
        }

        $scope.destroy = function(row, $index, item, item2) {
            var agenda = ($scope.listAgenda);

            $http(
                {
                    method: 'POST',
                    url: baseUrl + '/orthos/agenda/remover',
                    data: {sqAgenda: item2.sqAgenda}
                }
            ).success(function (data) {
                    Form.growlMessage(data);
                });

            agenda[row].cadeiras[$index].sq_medico = null;
            agenda[row].cadeiras[$index].no_medico = null;
            agenda[row].cadeiras[$index].sq_atendente = null;
            agenda[row].cadeiras[$index].no_atendente = null;
            agenda[row].cadeiras[$index].sq_dentista = null;
            agenda[row].cadeiras[$index].no_dentista = null;
            agenda[row].cadeiras[$index].dtChegada = null;
            agenda[row].cadeiras[$index].sqAgenda = null;
            agenda[row].cadeiras[$index].status = null;
            agenda[row].cadeiras[$index].tx_observacao = null;
            agenda[row].cadeiras[$index].paciente.nome = null;
            agenda[row].cadeiras[$index].paciente.id = null;
            agenda[row].cadeiras[$index].paciente.matricula = null;
            agenda[row].cadeiras[$index].paciente.telefone = null;

        }

        $scope.checkStatus = function () {
            if (!$('#agendaCheck').length) {
                $timeout.cancel($scope.agenda);
            } else {
                $http(
                    {
                        method: 'POST',
                        url: baseUrl + '/orthos/agenda/checkStatus',
                        data: {date: $scope.date, clinica: $scope.clinica}
                    }
                    ).success(function (data) {
                            angular.forEach(data, function (item) {
                                if (item.map != "|") {
                                    var map = item.map.split('|');
                                    var row = map[0];
                                    var colunm = map[1];

                                    $scope.listAgenda[row].cadeiras[colunm] = item;
                                }
                            });
                        });
                }

            }

    }

    $scope.initAgenda();
    $scope.initScroll();
}

};