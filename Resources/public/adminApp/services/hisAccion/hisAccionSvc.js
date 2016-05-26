/**
 * TrazasBundle/Resources/public/adminApp/controllers/hisAccion/hisAccionSvc.js
 */
angular.module('app')
        .factory('hisAccionSvc',
                ['$resource',
                    function ($resource) {
                        return {
                            entities: $resource(Routing.generate('hisaccion_create', {}, true) + ':id', null, {
                                'query': {
                                    isArray: false
                                }
                            })
                        };
                    }
                ]
        );