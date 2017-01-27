
/**
 * TrazasBundle/Resources/public/adminApp/filters/trazasHomeFilter.js
 */
angular.module('app')
        .filter('trazasHomeFilter',
                function () {
                    return function (input) {
                        input = input || '';
                        var out = "";
                        for (var i = 0; i < input.length; i++) {
                            out = input.charAt(i) + out;
                        }
                        return out;
                    }
                }
        );