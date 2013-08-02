(function (angular, $, undefined) {
    "use strict";

    /**
     * Módulo contendo as diretivas para mensagens
     * @type {XysMessage}
     */
    var XysMessage = angular.module("XysMessage", ['Core', 'ui']);

    /**
     * Diretiva que invoca a div para enviar as mensagens
     */
    XysMessage.directive("xysMessageBox", ['$parse', 'asset', '$http', 'ExposeTranslation',
        function ($parse, asset, $http, ExposeTranslation) {
            return {
                templateUrl:asset("bundles/coremessage/templates/messageWindow.html"),
                scope:{
                    to:"=usersTo",
                    subject:"=ds_subject",
                    reply:"="
                },
                controller:['$scope', function ($scope) {
                    $('.token-input-dropdown-facebook').hide();
                    $scope.$watch('to', function (newValue) {
                        $scope.formMessage.users_sent = newValue;
                    });

                    $scope.no_user = $('#no_user').val();

                    $scope.formMessage = {};

                    $scope.urlUsersAutoComplete = Routing.generate('search_user_autocomplete');

                    var $formatContainer = $('<div></div>');
                    var $formatPicture = $('<img width="21" height="28" style="width: 21px!important; height: 28px!important;" />');
                    var $formatName = $('<span/>');
                    $('<li/>')
                        .appendTo($formatContainer)
                        .append($formatPicture)
                        .append(document.createTextNode(" "))
                        .append($formatName);
                    $scope.formatWithPicture = function(item) {
                        $formatPicture.attr("src", asset(item.image));
                        $formatName.text(item.name);
                        return $formatContainer.html();
                    };

                    $scope.sendMessage = function () {
                        Loading.showAll();
                        if ($scope.formMessage.users_sent[0].hasOwnProperty('co_message')) {
                            $scope.formMessage.co_message = $scope.formMessage.users_sent[0].co_message;
                            $scope.formMessage.co_message_origin = $scope.formMessage.users_sent[0].co_message_origin;
                        }
                        $http.post(Routing.generate('message_new'), $scope.formMessage)
                            .success(function (data) {
                                Loading.hideAll();
                                if (data.success) {
                                    Modal.growl(data.message, 'success');
                                    $scope.$emit('sentMessageBox');
                                    $scope.resetData();
                                } else {
                                    Form.growlMessage(data);
                                }
                            })
                            .error(function (data) {
                                Loading.hideAll();
                                console.log(data);
                                Modal.growl("Erro de requisição", "error");
                            });
                    };

                    $scope.resetData = function () {
                        $scope.formMessage.ds_subject = '';
                        $scope.formMessage.ds_message = '';
                        $scope.formMessage.users_sent = [];
                        setTimeout(function (){
                            $('.token-input-dropdown-facebook').hide();
                        },100);
                        $scope.$emit('cancelMessageBox');
                    };
                }]
            };
        }]);

    XysMessage.directive("xysMessageThread", ['asset', '$http', 'ExposeTranslation',
        function (asset, $http, ExposeTranslation) {
            return {
                templateUrl:asset("bundles/coremessage/templates/messageThread.html"),
                scope:{
                    coMessage:'='
                },
                controller:['$scope', function ($scope) {

                    $scope.messagesThread = [];
                    $scope.replyData = false;

                    $scope.$on("Message.show", function (event, message) {
                        $scope.coMessage = message.co_message_origin;
                        $scope.ds_subject = "Re: " + message.subject;
                        $scope.getMessages();
                    });

                    $scope.getMessages = function () {
                        $scope.replyData = false;
                        if ($scope.coMessage) {
                            $scope.messagesThread = [];
                            Loading.showAll();
                            $http.get(Routing.generate('message_show', {'coMessage':$scope.coMessage}))
                                .success(function (data) {
                                    if(angular.element($('#jProfile-MessageCounter'))) {
                                        $http.get(Routing.generate ('CoreMessage_Message_total_unread'))
                                            .success(function (data) {
                                                $('#jProfile-MessageCounter').text(data.total);
                                            })
                                            .error(function (data) {
                                                $('#jProfile-MessageCounter').html('');
                                            });
                                    }
                                    Loading.hideAll();
                                    $scope.messagesThread = data;
                                })
                                .error(function (data) {
                                    Loading.hideAll();
                                    Modal.growl('Erro de requisição', 'error');
                                });
                        }
                    };

                    $scope.listUsersSent = function(message){
                        var listText = '';
                        var separator = '';
                        angular.forEach(message.users, function(user){
                            if(message.co_user != user.id){
                                listText += separator + user.name;
                                separator = ", ";
                            }
                        });

                        if(listText.length == 0){
                            listText = message.users[0].name;
                        }

                        return listText;
                    };

                    $scope.showMessageToggle = function(message){
                        if(message.hasOwnProperty('show')){
                            if(message.show){
                                message.show = false;
                            }else{
                                message.show = true;
                            }
                        }else{
                            message.show = true;
                        }
                    };

                    $scope.setOpen = function (message, last) {
                        if(!message.hasOwnProperty('show')){
                            if(last){
                                message.show = true;
                            }
                        }

                        return message.show;
                    };

                    $scope.reply = function (message) {
                        $scope.usersReply = [
                            {
                                'id':message.co_user,
                                'name':message.no_user,
                                'co_message':message.co_message,
                                'co_message_origin':message.message_origin
                            }
                        ];
                        $scope.replyData = true;
                    };

                    $scope.replyAll = function (message) {
                        var usersToReply = [];
                        var userSenterPresent = false;
                        angular.forEach(message.users, function(user, key){
                            if(user.id != user.co_user_logged){
                                user.co_message = message.co_message;
                                user.co_message_origin = message.message_origin;
                                usersToReply.push(user);
                                if(user.id == message.co_user){
                                    userSenterPresent = true;
                                }
                            }

                        });

                        if(!userSenterPresent){
                            if(message.co_user != message.co_user_logged){
                                var userSenter = {
                                    'id' : message.co_user,
                                    'name' : message.no_user,
                                    'co_message':message.co_message,
                                    'co_message_origin':message.message_origin
                                }
                                usersToReply.push(userSenter);
                            }
                        }

                        $scope.usersReply = usersToReply;
                        $scope.replyData = true;
                    };

                    $scope.cancel = function () {
                        $scope.replyData = false;
                    };

                    $scope.getMessages();
                }]
            };
        }]);

})(angular, jQuery)