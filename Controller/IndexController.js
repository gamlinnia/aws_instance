app.controller('indexController', function($scope, indexService) {

    indexService.getInstanceList().success(function (response) {
        $scope.instances = response;
    });

    indexService.getGroupInstanceList().success(function (response) {
        $scope.groups = response;
    });

    $scope.startInstance = function (instance) {
        indexService.startInstance(instance).success(function (response) {
            alert(response);
        });
    };

    $scope.stopInstance = function (instance) {
        indexService.stopInstance(instance).success(function (response) {
            alert(response);
        });
    };

    $scope.groupStartInstance = function (group) {
        group.forEach(function (value) {
            $scope.startInstance(value);
        });
    };

    $scope.groupStopInstance = function (group) {
        group.forEach(function (value) {
            $scope.stopInstance(value);
        });
    };

});

