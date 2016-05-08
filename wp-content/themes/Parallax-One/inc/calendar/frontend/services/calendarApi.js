(function () {
    var module = angular.module('4water.services');

    module.service('Calendar4WaterApi', ['$http', function ($http) {
        function getCalendarData(weekStart, done) {
            $http.get('wp-json/calendar/4water/api/' + weekStart)
                .success(function(results) {
                    done(null, results)
                })
                .error(function(err) {
                    done(err);
                });
        };
        
        return {
            getCalendarData: getCalendarData
        };
    }]);
})();