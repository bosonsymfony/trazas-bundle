/**
 * TrazasBundle/Resources/public/adminApp/controllers/hisExcepcion/hisExcepcionCtrl.js
 */
angular.module('app')
        .controller('hisExcepcionCtrl',
                ['$scope', 'hisExcepcionSvc', '$mdDialog',
                    function ($scope, hisExcepcionSvc, $mdDialog) {

                        var bookmark;

                        $scope.selected = [];

                        $scope.filter = {
                            options: {
                                debounce: 500
                            }
                        };

                        $scope.query = {
                            filter: '',
                            limit: '5',
                            order: 'idTraza',
                            page: 1
                        };

                        function getEntities(query) {
                            $scope.promise = hisExcepcionSvc.entities.get(query || $scope.query, success).$promise;
                        }

                        function success(entities) {
                            $scope.entities = entities;
                            $scope.selected = [];
                        }

                        $scope.onPaginate = function (page, limit) {
                            getEntities(angular.extend({}, $scope.query, {page: page, limit: limit}));
                        };

                        $scope.onReorder = function (order) {
                            getEntities(angular.extend({}, $scope.query, {order: order}));
                        };

                        $scope.removeFilter = function () {
                            $scope.filter.show = false;
                            $scope.query.filter = '';

                            if ($scope.filter.form.$dirty) {
                                $scope.filter.form.$setPristine();
                            }
                        };

                        $scope.$watch('query.filter', function (newValue, oldValue) {
                            if (!oldValue) {
                                bookmark = $scope.query.page;
                            }

                            if (newValue !== oldValue) {
                                $scope.query.page = 1;
                            }

                            if (!newValue) {
                                $scope.query.page = bookmark;
                            }

                            getEntities();
                        });

                        $scope.deleteSelected = function (event) {
                            $mdDialog.show({
                                clickOutsideToClose: true,
                                controller: 'hisExcepcionDeleteCtrl',
                                focusOnOpen: false,
                                targetEvent: event,
                                locals: {
                                    entities: $scope.selected
                                },
                                templateUrl: $scope.$urlAssets + 'bundles/trazas/adminApp/views/hisExcepcion/delete-dialog.html'
                            }).then(getEntities);
                        };

                        $scope.addEntity = function (event) {
                            $mdDialog.show({
                                clickOutsideToClose: true,
                                controller: 'hisExcepcionCreateCtrl',
                                focusOnOpen: false,
                                targetEvent: event,
                                templateUrl: $scope.$urlAssets + 'bundles/trazas/adminApp/views/hisExcepcion/save-dialog.html'
                            }).then(getEntities);
                        };

                        $scope.editEntity = function (event) {
                            hisExcepcionSvc.entities.query({id: $scope.selected[0].id},
                                    function (response) {
                                        $mdDialog.show({
                                            clickOutsideToClose: true,
                                            controller: 'hisExcepcionUpdateCtrl',
                                            focusOnOpen: false,
                                            targetEvent: event,
                                            templateUrl: $scope.$urlAssets + 'bundles/trazas/adminApp/views/hisExcepcion/update-dialog.html',
                                            locals: {
                                                object: response
                                            }
                                        }).then(getEntities);
                                    }, function (error) {
                                        alert(error);
                                    }
                            );
                        }
                    }
                ]
        )
        .controller('hisExcepcionDeleteCtrl',
                ['$scope', '$mdDialog', 'entities', '$q', 'hisExcepcionSvc', 'toastr',
                    function ($scope, $mdDialog, entities, $q, hisExcepcionSvc, toastr) {

                        $scope.cancel = $mdDialog.cancel;

                        function deleteEntity(entity, index) {
                            var deferred = hisExcepcionSvc.entities.remove({id: entity.idTraza});

                            deferred.$promise.then(function () {
                                entities.splice(index, 1);
                            });

                            return deferred.$promise;
                        }

                        function onComplete() {
                            toastr.success("Traza(s) eliminada con éxito");
                            $mdDialog.hide();
                        }

                        $scope.delete = function () {
                            $q.all(entities.forEach(deleteEntity)).then(onComplete);
                        }
                    }
                ]
        )
        .controller('hisExcepcionCreateCtrl',
                ['$scope', '$mdDialog', 'hisExcepcionSvc',
                    function ($scope, $mdDialog, hisExcepcionSvc) {

                        var update = false;

                        var hide = true;

                        $scope.cancel = function () {
                            if (update) {
                                return $mdDialog.hide();
                            } else {
                                return $mdDialog.cancel();
                            }
                        };

                        function success(response) {
                            if (hide) {
                                $mdDialog.hide();
                            } else {
                                update = true;
                                clean();
                            }
                        }

                        function clean() {
                            $scope.entity = {};
                        }

                        function error(errors) {
                            $scope.errors = errors.data;
                        }

                        function addEntity() {

                            if ($scope.form.$valid) {
                                hisExcepcionSvc.entities.save($scope.entity, success, error);
                            }
                        }

                        $scope.accept = function () {
                            hide = true;
                            addEntity();
                        };

                        $scope.apply = function () {
                            hide = false;
                            addEntity();
                        };

                        $scope.errors = {};
                    }
                ]
        )
        .controller('hisExcepcionUpdateCtrl',
                ['$scope', '$mdDialog', 'hisExcepcionSvc', 'object',
                    function ($scope, $mdDialog, hisExcepcionSvc, object) {

                        $scope.entity = {
                            'trazasbundle_hisexcepcion[idTraza]': object.id_traza,
                            'trazasbundle_hisexcepcion[fecha]': object.fecha,
                            'trazasbundle_hisexcepcion[hora]': object.hora,
                            'trazasbundle_hisexcepcion[usuario]': object.usuario,
                            'trazasbundle_hisexcepcion[ipHost]': object.ip_host,
                            'trazasbundle_hisexcepcion[rol]': object.rol,
                            'trazasbundle_hisexcepcion[tipo]': object.tipo,
                            'trazasbundle_hisexcepcion[mensaje]': object.mensaje,
                        };


                        $scope.cancel = function () {
                            return $mdDialog.cancel();
                        };

                        function success(response) {
                            $mdDialog.hide();
                        }

                        function error(errors) {
                            $scope.errors = errors.data;
                        }

                        function updateEntity() {
                            if ($scope.form.$valid) {
                                hisExcepcionSvc.entities.save({id: object.id}, angular.extend({}, $scope.entity, {_method: 'PUT'}), success, error);
                            }
                        }

                        $scope.accept = function () {
                            updateEntity();
                        };
                    }
                ]
        );