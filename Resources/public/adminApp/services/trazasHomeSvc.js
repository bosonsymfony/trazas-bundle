/**
 * TrazasBundle/Resources/public/adminApp/services/trazasHomeSvc.js
 */
angular.module('app')
    .service('trazasHomeSvc', ['$http',
            function ($http) {
                var message = '';

                function setMessage(newMessage) {
                    message = newMessage;
                }

                function getMessage() {
                    return message;
                }

                function writeYAML(data) {
                    return $http.post(Routing.generate('trazas_save_data', {}, true), data);
                }

                function showCurrentInfo() {
                    return $http.get(Routing.generate('trazas_current_info', {}, true));
                }

                function getCSRFtoken() {
                    return $http.post(Routing.generate('trazas_csrf_form', {}, true), {id_form: 'uci_boson_trazasbundle_data'});
                }

                return {
                    setMessage: setMessage,
                    getMessage: getMessage,
                    writeYAML: writeYAML,
                    showCurrentInfo: showCurrentInfo,
                    getCSRFtoken: getCSRFtoken,
                    $get: function () {
                    }
                }
            }
        ]
    );