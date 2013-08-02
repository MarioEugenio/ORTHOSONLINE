(function (angular, undefined) {

    window.Message_ListCtrl = ["$scope", "$rootScope", "$http", "$templateCache", "ExposeTranslation",
        function ($scope, $rootScope, $http, $templateCache, ExposeTranslation) {

            $scope.showModalNewMessages = false;
            $scope.showModalReply = false;
            $scope.showModalMessage = false;
            $scope.messageReply = 0;
            $scope.messages = [];
            $scope.checkboxes = {};
            $scope.box = 'inbox';

            $scope.no_user = $('#j-messages-no_user').val();

            $scope.$on('sentMessageBox', function () {
                $scope.showModalNewMessage = false;
                $scope.showModalMessages = false;
                $scope.showModalReply = false;
                $scope.refresh();
                $('.token-input-dropdown-facebook').hide();
            });

            $scope.$on('cancelMessageBox', function () {
                $scope.showModalNewMessage = false;
                $scope.showModalMessages = false;
                $scope.showModalReply = false;
                $('.token-input-dropdown-facebook').hide();
            });

            $scope.responseMessages = function (message) {
                if ($scope.box == 'inbox') {
                    $rootScope.$broadcast("Message.show", message);
                    message.fl_read = true;
                    $scope.showModalReply = true;
                    $scope.selectedMessage = message;

                } else {
                    console.log(message);
                    $scope.showModalMessage = true;
                    $scope.selectedMessage = message;

                    if(!message.users){
                        $scope.selectedMessage.users = $('#j-messages-no_user').val();
                    }

                }
            };

            $scope.getInboxMessages = function () {
                $scope.box = 'inbox';
                $('.btnInbox').button('toggle');
                $scope.toOrFor = ExposeTranslation.get('message.inbox.from');
                Loading.showAll();
                $http.post(Routing.generate('message_inbox'))
                    .success(function (data) {
                        Loading.hideAll();
                        $scope.messages = data;

                        $('.token-input-dropdown-facebook').hide();
                    })
                    .error(function (data) {
                        $('.token-input-dropdown-facebook').hide();
                        Loading.hideAll();
                        console.log(data);
                    });
            };

            $scope.getSentMessages = function () {
                $scope.box = 'sent';
                $('.btnSent').button('toggle');
                $scope.toOrFor = ExposeTranslation.get('message.inbox.to');
                Loading.showAll();
                $http.get(Routing.generate('message_sent'))
                    .success(function (data) {
                        Loading.hideAll();
                        $scope.messages = data;
                        $('.token-input-dropdown-facebook').hide();
                    })
                    .error(function (data) {
                        Loading.hideAll();
                        console.log(data);
                        $('.token-input-dropdown-facebook').hide();
                    });
            };

            $scope.selectAllMessages = function () {
                $scope.checkboxes = {};
                angular.forEach($scope.messages, function (message, key) {
                    if ($scope.box == 'inbox') {
                        $scope.checkboxes[message.co_message_origin] = $scope.allMessages;
                    } else {
                        $scope.checkboxes[message.co_message] = $scope.allMessages;

                }
                });
                console.log($scope.checkboxes);
            };

            $scope.search = function (type) {

                console.log(type);
                console.log($scope.formSearch.generic);

                if (type != 1) {
                    $scope.formSearch.generic = '';
                }

                Loading.showAll();

                $http.post(Routing.generate('message_search'), $scope.formSearch)
                    .success(function (data) {
                        Loading.hideAll();
                        $scope.box = 'search';
                        $scope.messages = data;
                        $scope.formSearch.to = '';
                        $scope.formSearch.from = '';
                        $scope.formSearch.subject = '';
                        $scope.formSearch.message = '';
                        $scope.formSearch.dt_start = '';
                        $scope.formSearch.dt_end = '';
                    })
                    .error(function (data) {
                        Loading.hideAll();
                        console.log(data);
                    });
            };

            $scope.removeMessages = function () {
                if ($scope.objectSize($scope.checkboxes) > 0) {
                    Loading.showAll();
                    $http.post(Routing.generate('message_remove', {'box': $scope.box}), $scope.checkboxes)
                        .success(function (data) {
                            Loading.hideAll();
                            if (data.success) {
                                $scope.refresh();
                            }
                            $scope.checkboxes = {};
                            Modal.growl(ExposeTranslation.get('message.remove.success'), 'success');
                        })
                        .error(function (data) {
                            Loading.hideAll();
                            console.log(data);
                        });
                } else {
                    Modal.growl(ExposeTranslation.get('message.no_select'), 'error');
                }
            };

            $scope.refresh = function () {
                $('.token-input-dropdown-facebook').hide();
                $('.token-input-dropdown-facebook').remove();
                if ($scope.box == 'inbox')
                {
                    $scope.getSentMessages();
                }
            };

            $scope.objectSize = function (obj) {
                var size = 0, key;
                for (key in obj) {
                    if (obj.hasOwnProperty(key)) size++;
                }
                return size;
            };

            $scope.getInboxMessages();
            $('.token-input-dropdown-facebook').remove();

        }];
})(angular);