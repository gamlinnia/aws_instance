
app.service('indexService', function($http) {

    var urlBase = 'rest/route.php/api/';

    this.getInstanceList = function (data) {
        return $http.get(urlBase + 'getInstanceList');
    };

    this.getGroupInstanceList = function (data) {
        return $http.get(urlBase + 'getGroupInstanceList');
    };

    this.startInstance = function (instance) {
        return $http({
            method: 'POST',
            url: urlBase + 'startInstance',
            data: instance
        });
    };

    this.stopInstance = function (instance) {
        return $http({
            method: 'POST',
            url: urlBase + 'stopInstance',
            data: instance
        });
    };

});