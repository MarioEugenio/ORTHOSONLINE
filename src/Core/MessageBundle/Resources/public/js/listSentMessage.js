(function (angular, undefined) {
    window.Message = {
        MessageListSentCtrl:["$scope", "$http", "ExposeTranslation", function ($scope, $http, ExposeTranslation) {

            $scope.checkedMessage = {};

            $scope.selectAllMessages = function () {
                angular.forEach($scope.messageSent, function (message, key) {
                    $scope.checkedMessage[message.co_message] = $scope.all;
                });
            };

            $scope.removeMessage = function (obj) {
                var check = false;

                for (var key in $scope.checkedMessage) {
                    check = true;
                }

                if (!check) {
                    Modal.growl('Selecione pelo menos uma mensagem', 'error');
                    return false;
                }

                var callback = function ($notyCategory) {
                    Loading.showAll();

                    $http({
                        method:'POST',
                        url:Routing.generate('message_remove', {}),
                        data:{
                            messages:$scope.checkedMessage
                        }
                    })
                        .success(function (data) {
                            Modal.growl(data.message, 'success');
                            Loading.hideAll();
                            Load.simple('#message-content', Routing.generate('message_sent_message'));
                        })
                        .error(function () {
                            Loading.hideAll();
                            Modal.growl('Erro ao processar requisição', 'error');
                        });

                    $notyCategory.close();
                };

                Modal.confirm(ExposeTranslation.get('forum.confirm_remove'), 'confirm', callback);
            };

            /**
             * Lista de mensagens da caixa de entrada
             */
            $scope.getSentMessages = function () {
                $http.get(Routing.generate('message_sent', {}))
                    .success(function (data) {
                        $scope.messageSent = angular.fromJson(data);
                    })
                    .error(function () {
                        Modal.growl('Erro ao processar requisição', 'error');
                    });
            };

            $scope.returnInbox = function () {
                $("#j-Message-resultSearch").val('');
                Load.simple('#message-content', Routing.generate('message_list_inbox'));
            };

            /**
             * Lista de mensagens da caixa de entrada
             */
            $scope.showMessage = function (id) {
                Load.simple('#message-content', Routing.generate('message_show', {coMessage:id, route:'message_sent_message'}));
            };
            $('.token-input-dropdown-facebook').remove();

            $scope.getSentMessages();
        }]
    };
})(angular);