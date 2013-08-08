function menuCtrl($scope, $http) {
    var user = $('#user').val();
    $scope.listMenu = [];
    $scope.user = (user)? angular.fromJson(user) : {};
    $scope.templateMenu;
    $scope.srcAlterarSenha;
    $scope.tooltip = [{
            "title": "Página Inicial",
            "checked": false
        }]

    $scope.setModalSenha = function () {
        $scope.srcAlterarSenha = baseUrl + '/usuario/alterarSenha';
        $('#modalSenha').modal('show');
    }

    $scope.init = function () {
        $http(
            {
                method: 'POST',
                url: baseUrl + '/usuario/getMenuPerfil',
                data: {}
            }
        ).success(function (data) {
            $scope.listMenu = [];
            $scope.listMenu = data;
        });

        if (!$scope.templateMenu) {
            $scope.templateMenu = baseUrl + '/orthos/inicial';
        }
    }

    $scope.getContato = function() {
        return baseUrl + '/contato';
    }

    $scope.link = function (item) {
        if (item.ds_uri) {
            $scope.templateMenu = baseUrl + item.ds_uri;
        }
    }

    $scope.linkUrl = function (url) {
        if (url) {
            $scope.templateMenu = baseUrl + url;
        }
    }

    $scope.getImagem = function (user) {
        return '/bundles/coreorthos/img/icon_user_default.png';
    }

    $scope.getSubmenu = function (item) {
        if (item.hasOwnProperty('filhos')) {
            return 'dropdown-submenu';
        }

        return '';
    }

    $scope.logoff = function () {
        window.location = baseUrl + '/usuario/logoff';
    }

    $scope.init();
}