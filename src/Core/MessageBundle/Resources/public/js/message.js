(function (angular, undefined) {
    window.Message_ListInboxCtrl = ["$scope", "$http", "ExposeTranslation", function ($scope, $http, ExposeTranslation) {

            //var resultSearch = ($("#j-Message-resultSearch").val().length > 5 ? angular.fromJson($("#j-Message-resultSearch").val()) : '');

            $scope.messageInbox = [];
            $scope.checkedMessage = {};

            $scope.selectAllMessages = function () {
                angular.forEach($scope.messageInbox, function (message, key) {
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
                            //Load.simple('#message-content', Routing.generate('message_list_inbox'));
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
            $scope.getInboxMessages = function () {
                $http.get(Routing.generate('message_inbox', {}))
                    .success(function (data) {
                        console.log(data);
                        $scope.messageInbox = angular.fromJson(data);
                    })
                    .error(function () {
                        Modal.growl('Erro ao processar requisição', 'error');
                    });
            };

            $scope.markAsReaded = function(item){
                var objStyle = {'cursor': 'pointer'};
                if(!item.fl_read && !resultSearch){
                    objStyle['font-weight'] = 'bold';
                }
                return objStyle;
            };

            /**
             * Lista de mensagens da caixa de entrada
             */
            $scope.showMessage = function (id) {
                Load.simple('#message-content', Routing.generate('message_show', {coMessage:id, route:'message_list_inbox'}));
            };

            $('.token-input-dropdown-facebook').remove();

            $scope.getInboxMessages();
        }];
})(angular);