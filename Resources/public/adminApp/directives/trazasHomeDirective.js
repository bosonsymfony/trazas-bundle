
/**
 * TrazasBundle/Resources/public/adminApp/directives/trazasHomeDirective.js
 */
angular.module('app')
        .directive('trazasHomeDirective',
                function () {
                    return {
                        restrict: 'A',
                        link: function ($scope, element, attrs) {
                            element.bind('mouseenter', function () {
                                element.css('background-color', 'yellow');
                                element.css('color', 'red');
                            });
                            element.bind('mouseleave', function () {
                                element.css('background-color', 'white');
                                element.css('color', 'black');
                            });
                        }
                    }
                }
        );