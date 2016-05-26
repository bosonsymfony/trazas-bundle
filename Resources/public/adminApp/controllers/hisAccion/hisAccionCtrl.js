/**
 * TrazasBundle/Resources/public/adminApp/controllers/hisAccion/hisAccionCtrl.js
 */
angular.module('app')
    .controller('hisAccionCtrl',
        ['$scope', 'hisAccionSvc', '$mdDialog', 'toastr',
            function ($scope, hisAccionSvc, $mdDialog, toastr) {

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
                    $scope.promise = hisAccionSvc.entities.get(query || $scope.query, success).$promise;
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
                        controller: 'hisAccionDeleteCtrl',
                        focusOnOpen: false,
                        targetEvent: event,
                        locals: {
                            entities: $scope.selected
                        },
                        templateUrl: $scope.$urlAssets + 'bundles/trazas/adminApp/views/hisAccion/delete-dialog.html'
                    }).then(getEntities);
                };

                $scope.addEntity = function (event) {
                    $mdDialog.show({
                        clickOutsideToClose: true,
                        controller: 'hisAccionCreateCtrl',
                        focusOnOpen: false,
                        targetEvent: event,
                        templateUrl: $scope.$urlAssets + 'bundles/trazas/adminApp/views/hisAccion/save-dialog.html'
                    }).then(getEntities);
                };

                $scope.editEntity = function (event) {
                    hisAccionSvc.entities.query({id: $scope.selected[0].id},
                        function (response) {
                            $mdDialog.show({
                                clickOutsideToClose: true,
                                controller: 'hisAccionUpdateCtrl',
                                focusOnOpen: false,
                                targetEvent: event,
                                templateUrl: $scope.$urlAssets + 'bundles/trazas/adminApp/views/hisAccion/update-dialog.html',
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
    .controller('hisAccionDeleteCtrl',
        ['$scope', '$mdDialog', 'entities', '$q', 'hisAccionSvc', 'toastr',
            function ($scope, $mdDialog, entities, $q, hisAccionSvc, toastr) {

                $scope.cancel = $mdDialog.cancel;

                function deleteEntity(entity, index) {
                    var deferred = hisAccionSvc.entities.remove({id: entity.idTraza});

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
    .controller('hisAccionCreateCtrl',
        ['$scope', '$mdDialog', 'hisAccionSvc',
            function ($scope, $mdDialog, hisAccionSvc) {

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
                        hisAccionSvc.entities.save($scope.entity, success, error);
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
    .controller('hisAccionUpdateCtrl',
        ['$scope', '$mdDialog', 'hisAccionSvc', 'object',
            function ($scope, $mdDialog, hisAccionSvc, object) {

                $scope.entity = {
                    'trazasbundle_hisaccion[idTraza]': object.id_traza,
                    'trazasbundle_hisaccion[fecha]': object.fecha,
                    'trazasbundle_hisaccion[hora]': object.hora,
                    'trazasbundle_hisaccion[usuario]': object.usuario,
                    'trazasbundle_hisaccion[ipHost]': object.ip_host,
                    'trazasbundle_hisaccion[rol]': object.rol,
                    'trazasbundle_hisaccion[referencia]': object.referencia,
                    'trazasbundle_hisaccion[controlador]': object.controlador,
                    'trazasbundle_hisaccion[accion]': object.accion,
                    'trazasbundle_hisaccion[inicio]': object.inicio,
                    'trazasbundle_hisaccion[falla]': object.falla,
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
                        hisAccionSvc.entities.save({id: object.id}, angular.extend({}, $scope.entity, {_method: 'PUT'}), success, error);
                    }
                }

                $scope.accept = function () {
                    updateEntity();
                };
            }
        ]
    );