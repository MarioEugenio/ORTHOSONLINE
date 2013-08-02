(function ($, angular, JSON, undefined) {
    "use strict";

    var MessageLastMessages = angular.module("MessageLastMessages", ["Core"]);

    MessageLastMessages.controller("MessageLastMessagesCtrl",
        ['$scope','$timeout', '$http', '$templateCache', 'ExposeTranslation',
            function($scope,$timeout,$http, $templateCache, ExposeTranslation) {
                $scope.lastMessages = angular.fromJson($("#j-GalleryComment-Last-Values").val());

                /**
                 * Abre um Modal com a mensagem em seu contexto
                 * @param int co_message
                 */
                $scope.openModalMessage = function(message){
                    console.log(message);
                    message.fl_read = true;
                    Modal.load(Routing.generate('message_index',{'co_message': co_message}),ExposeTranslation.get('message.message.label'));
                }

            }]);

    MessageLastMessages.filter('trunc', function() {
        return function(text, count) {
            if(text.length > count){
                return text.substr(0,count)+"...";
            }else{
                return text;
            }
        };
    });


})(jQuery, angular, JSON);