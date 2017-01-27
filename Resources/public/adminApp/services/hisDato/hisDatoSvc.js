/**
 * TrazasBundle/Resources/public/adminApp/controllers/hisDato/hisDatoSvc.js
 */
angular.module('app')
        .factory('hisDatoSvc',
                ['$resource',
                    function ($resource) {
                        return {
                            entities: $resource(Routing.generate('hisdato_create', {}, true) + ':id', null, {
                                'query': {
                                    isArray: false
                                }
                            })
                        };
                    }
                ]
        );