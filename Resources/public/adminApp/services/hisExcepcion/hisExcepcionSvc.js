/**
 * TrazasBundle/Resources/public/adminApp/controllers/hisExcepcion/hisExcepcionSvc.js
 */
angular.module('app')
        .factory('hisExcepcionSvc',
                ['$resource',
                    function ($resource) {
                        return {
                            entities: $resource(Routing.generate('hisexcepcion_create', {}, true) + ':id', null, {
                                'query': {
                                    isArray: false
                                }
                            })
                        };
                    }
                ]
        );