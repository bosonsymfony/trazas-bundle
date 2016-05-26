/**
 * TrazasBundle/Resources/public/adminApp/controllers/hisDato/hisDatoCtrl.js
 */
angular.module('app')
    .controller('hisDatoCtrl',
        ['$scope', 'hisDatoSvc', '$mdDialog',
            function ($scope, hisDatoSvc, $mdDialog) {

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
                    $scope.promise = hisDatoSvc.entities.get(query || $scope.query, success).$promise;
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
                        controller: 'hisDatoDeleteCtrl',
                        focusOnOpen: false,
                        targetEvent: event,
                        locals: {
                            entities: $scope.selected
                        },
                        templateUrl: $scope.$urlAssets + 'bundles/trazas/adminApp/views/hisDato/delete-dialog.html'
                    }).then(getEntities);
                };

                $scope.addEntity = function (event) {
                    $mdDialog.show({
                        clickOutsideToClose: true,
                        controller: 'hisDatoCreateCtrl',
                        focusOnOpen: false,
                        targetEvent: event,
                        templateUrl: $scope.$urlAssets + 'bundles/trazas/adminApp/views/hisDato/save-dialog.html'
                    }).then(getEntities);
                };

                $scope.editEntity = function (event) {
                    hisDatoSvc.entities.query({id: $scope.selected[0].id},
                        function (response) {
                            $mdDialog.show({
                                clickOutsideToClose: true,
                                controller: 'hisDatoUpdateCtrl',
                                focusOnOpen: false,
                                targetEvent: event,
                                templateUrl: $scope.$urlAssets + 'bundles/trazas/adminApp/views/hisDato/update-dialog.html',
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
    .controller('hisDatoDeleteCtrl',
        ['$scope', '$mdDialog', 'entities', '$q', 'hisDatoSvc', 'toastr',
            function ($scope, $mdDialog, entities, $q, hisDatoSvc, toastr) {

                $scope.cancel = $mdDialog.cancel;

                function deleteEntity(entity, index) {
                    var deferred = hisDatoSvc.entities.remove({id: entity.idTraza});

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
    .controller('hisDatoCreateCtrl',
        ['$scope', '$mdDialog', 'hisDatoSvc',
            function ($scope, $mdDialog, hisDatoSvc) {

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
                        hisDatoSvc.entities.save($scope.entity, success, error);
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
    .controller('hisDatoUpdateCtrl',
        ['$scope', '$mdDialog', 'hisDatoSvc', 'object',
            function ($scope, $mdDialog, hisDatoSvc, object) {

                $scope.entity = {
                    'trazasbundle_hisdato[idTraza]': object.id_traza,
                    'trazasbundle_hisdato[fecha]': object.fecha,
                    'trazasbundle_hisdato[hora]': object.hora,
                    'trazasbundle_hisdato[usuario]': object.usuario,
                    'trazasbundle_hisdato[ipHost]': object.ip_host,
                    'trazasbundle_hisdato[rol]': object.rol,
                    'trazasbundle_hisdato[esquema]': object.esquema,
                    'trazasbundle_hisdato[tabla]': object.tabla,
                    'trazasbundle_hisdato[accion]': object.accion,
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
                        hisDatoSvc.entities.save({id: object.id}, angular.extend({}, $scope.entity, {_method: 'PUT'}), success, error);
                    }
                }

                $scope.accept = function () {
                    updateEntity();
                };
            }
        ]
    );