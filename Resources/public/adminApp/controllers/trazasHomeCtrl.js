/**
 * TrazasBundle/Resources/public/adminApp/controllers/trazasHomeCtrl.js
 */
angular.module('app')
    .controller('trazasHomeCtrl',
        ['$scope', 'trazasHomeSvc', 'toastr', '$mdDialog',
            function ($scope, trazasHomeSvc, toastr, $mdDialog) {
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

                    var confirm = $mdDialog.confirm()
                        .title('Confirmación de cambios')
                        .textContent('¿Está seguro que desea guardar los cambios?')
                        .targetEvent(ev)
                        .ok('Si')
                        .cancel('No');
                    $mdDialog.show(confirm).then(function() {
                        //si se selecciona que si:
                        var data = {
                            uci_boson_trazasbundle_data: {
                                action: $scope.swaction,
                                performance: $scope.swperformance,
                                exception: $scope.swexception,
                                data: $scope.swdata,
                            }
                        };

                        trazasHomeSvc.writeYAML(data)
                            .success(function (response) {
                                toastr.success("Se han configurado las trazas satisfactoriamente");
                                $scope.wasmodified = false;
                            })
                            .error(function (response) {
                                console.log(response);
                                toastr.error(response);
                            });
                    }, function() {
                        //en caso contrario:
                        toastr.info("Se ha cancelado la operación");
                    });
                };
            }
        ]
    );