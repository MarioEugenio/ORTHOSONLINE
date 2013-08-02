(function (angular, undefined) {
    window.Message = {
        SendMessageCtrl:["$scope", "$http", "$timeout", "ExposeTranslation", function ($scope, $http, $timeout, ExposeTranslation) {

            var forAutoComplete= angular.fromJson($("#jMessage-for-autocomplete-multiple").val());

            var for_auto = forAutoComplete ? forAutoComplete : [];
            $scope.formMessage = {subject:'', messageBody:'', 'for': for_auto};
            $scope.messages = [];
            $scope.messageSent = [];
            $scope.messageText = '';
            $scope.urlAutocomplete = Routing.generate('search_user_autocomplete');

            /**
             * Salva o rascunho da mensagem.
             */
            $scope.saveDraft = function () {
                if(!$scope.countingTime){
                    $scope.countingTime = true;
                    $timeout(function() {
                        $scope.formMessage.draft = 1;
                        $scope.formMessage.co_message = $("#jMessage-sentMessage-co_message").val();

                        $http.post(Routing.generate('message_new_save'),
                            $scope.formMessage).success(function(data){
                                if (data.success) {
                                    $("#jMessage-sentMessage-co_message").val(data.result);
                                    $scope.formMessage.co_message = data.result;
                                }
                            });

                        $scope.countingTime = false;
                    }, 3000);
                }
            };

            $scope.clearFormNewMessage = function () {
                $("#j-Message-resultSearch").val('');
                Load.simple('#message-content', Routing.generate('message_list_inbox'));
            };

            /**
             * Salva a mensagem.
             */
            $scope.saveNewMessage = function () {
                Loading.showAll();
                var message = angular.copy($scope.formMessage);
                $scope.formMessage.draft = 0;
                if($scope.validateForm(message)){
                    $http.post(Routing.generate('message_new'),
                        $scope.formMessage).success(function(data){
                            Form.inicializeValidate('#frm-new-message', data, 'growl-message');
                            Loading.hideAll();

                            if (data.success) {
                                if(!$('#j-forum-index-modal').length) {
                                    $('.token-input-dropdown-facebook').remove();
                                    Load.simple('#message-content', Routing.generate('message_list_inbox'));
                                } else {
                                    $scope.clearFormNewMessage();
                                }

                            }
                        });
                }
                Loading.hideAll();
            };

            /**
             * Descartar o rascunho.
             */
            $scope.discardMessage = function () {
                if($("#jMessage-sentMessage-co_message").val()) {
                    $http.post(Routing.generate('message_remove_draft'),
                        $scope.formMessage).success(function(data){
                            if (data.success) {
                                if(!$('#j-forum-index-modal').length) {
                                    Load.simple('#message-content', Routing.generate('message_list_inbox'));
                                } else {
                                    $scope.clearFormNewMessage();
                                }
                            }
                        });
                } else {
                    if(!$('#j-forum-index-modal').length) {
                        Load.simple('#message-content', Routing.generate('message_list_inbox'));
                    } else {
                        $scope.clearFormNewMessage();
                    }
                }
            };

            $scope.getMessageText = function (objMessage) {
                $http.get(Routing.generate('message_text', {co_message:objMessage.co_message}))
                    .success(function (data) {
                        $scope.messageText = angular.fromJson(data);
                    })
                    .error(function (data) {
                        Modal.growl('Erro ao processar requisição', 'error');
                    });
            };

            /**
             * Valida o formulário.
             * @return boolean Se os dados são válidos ou não
             */
            $scope.validateForm = function (message) {

                var errors = [];

                if(message.hasOwnProperty('for')){
                    if (message['for'].length<1) {
                        errors.push("message.validate.users");
                    }
                }

                if (!message.subject) {
                    errors.push("message.validate.subject");
                }

                if (!message.messageBody) {
                    errors.push("message.validate.message");
                }

                if (errors.length) {
                    angular.forEach(errors, function (error) {
                        Form.postValidate('frm-new-message');
                        Modal.growl(ExposeTranslation.get(error), "error");
                    });
                    return false;
                } else {
                    return true;
                }

            };

            $scope.clearFormNewMessage = function () {
                $('#response').hide();
                $('#bottons').hide();
                $('#messageText').hide();
                $('#replay').show();

                $('#subject').val('');
                $('#message-body').val('');

                if($('#j-forum-index-modal').length) {
                    $('#j-forum-index-modal').modal('hide');
                }
            };
        }]
    };
})(angular);
