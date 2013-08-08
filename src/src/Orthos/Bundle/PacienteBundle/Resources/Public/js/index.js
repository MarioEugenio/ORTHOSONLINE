
function indexCtrl($scope, $http, $timeout) {
    var paciente = $('#listPaciente').val();

    $scope.listPaciente = [];
    $scope.dt = {};
    $scope.search = {};

    $scope.init = function () {
        $('.cpf').mask('999.999.999-99');
        $scope.dt = Grid.gridPagination('#GridPaciente');
        $scope.loadList();
    }

    $scope.validaPesquisa = function () {
        if (
                (!$scope.search.no_paciente) &&
                (!$scope.search.ds_email) &&
                (!$scope.search.nu_matricula) &&
                (!$scope.search.nu_cpf)
        ) {
            Modal.growl('Selecione pelo menos um parâmetro para realizar a pesquisa', 'error');
            return false;
        }

        return true;
    }

    $scope.pesquisar = function () {
        $scope.search.nu_cpf = $('.cpf').val();
        $scope.listPaciente = [];

        if (!$scope.validaPesquisa()) {
            return false;
        }

        Loading.showAll();

        $http({
            method: 'POST',
            url: baseUrl + '/orthos/paciente/list',
            data: $scope.search
        }).success(
            function (data) {
                $scope.loadList(data);

                Loading.hideAll();
            }
        );


    }

    $scope.loadList = function (data) {

        if (data) $scope.listPaciente = data

        Grid.removeAllRows($scope.dt);

        if ($scope.listPaciente.length) {

            var rows = [];
            var row = {};
            angular.forEach($scope.listPaciente, function (item) {

                var actions = Icons.render('edit','#myAngularApp', 'alterar', item.sq_paciente); //Icons.render('remove','#myAngularApp', 'remover', item.sq_paciente) +


                row = {
                    0:item.no_paciente
                    ,1:item.nu_matricula
                    , 2:item.nu_cpf
                    , 3:item.ds_email
                    , 4:item.nu_residencial
                    , 5:actions
                };

                rows.push(row);
            });

            Grid.addRow($scope.dt, rows);
        }
    }

    $scope.cadastrar = function () {
        Load.simple('#view-page', baseUrl + '/orthos/paciente/cadastro');
    }

    $scope.remover = function(index) {

    }

    $scope.alterar = function(index) {
        Load.simple('#view-page', baseUrl + '/orthos/paciente/alteracao/'+index);
    }

    $scope.init();
};