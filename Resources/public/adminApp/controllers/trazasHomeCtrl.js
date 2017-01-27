/**
 * TrazasBundle/Resources/public/adminApp/controllers/trazasHomeCtrl.js
 */
angular.module('app')
    .controller('trazasHomeCtrl',
        ['$scope', 'trazasHomeSvc', 'toastr', '$mdDialog',
            function ($scope, trazasHomeSvc, toastr, $mdDialog) {

                trazasHomeSvc.getCSRFtoken()
                    .success(function (response) {
                        $scope.token = response;
                    })
                    .error(function (response) {
                    });

                $scope.wasmodified = false;

                $scope.modif = function () {
                    $scope.wasmodified = true;
                };

                trazasHomeSvc.showCurrentInfo()
                    .success(function (response) {
                        $scope.swdata = false;
                        $scope.swaction = false;
                        $scope.swperformance = false;
                        $scope.swexception = false;

                        if (response.data == true) {
                            $scope.swdata = true;
                        }
                        if (response.action == true) {
                            $scope.swaction = true;
                        }
                        if (response.exception == true) {
                            $scope.swexception = true;
                        }
                        if (response.performance == true) {
                            $scope.swperformance = true;
                        }
                    });

                $scope.guardarClick = function (ev) {

                    $mdDialog.show({
                        clickOutsideToClose: true,
                        controller: 'DialogController',
                        focusOnOpen: false,
                        targetEvent: ev,
                        locals: {
                            entities: $scope.selected
                        },
                        templateUrl: $scope.$urlAssets + 'bundles/trazas/adminApp/views/confirm-dialog.html'
                    }).then(function (answer) {
                        //console.log(answer);
                        if (answer == 'Aceptar') {
                            var data = {
                                uci_boson_trazasbundle_data: {
                                    action: $scope.swaction,
                                    performance: $scope.swperformance,
                                    exception: $scope.swexception,
                                    data: $scope.swdata,
                                    _token: $scope.token
                                }
                            };
                            trazasHomeSvc.writeYAML(data)
                                .success(function (response) {
                                    toastr.success(response);
                                    $scope.wasmodified = false;
                                })
                                .error(function (response) {
                                    console.log(response);
                                    toastr.error(response);
                                });
                        } else {
                            // alert("Cancelar");
                        }
                    });
                };
            }
        ]
    )
    .controller('DialogController',
        ['$scope', 'trazasHomeSvc', 'toastr', '$mdDialog',
            function ($scope, trazasHomeSvc, toastr, $mdDialog) {
                $scope.hide = function () {
                    $mdDialog.hide();
                };
                $scope.cancel = function () {
                    $mdDialog.cancel();
                };
                $scope.answer = function (answer) {
                    $mdDialog.hide(answer);
                };

            }
        ]
    );