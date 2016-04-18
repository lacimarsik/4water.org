(function () {
    var app = angular.module('4water.directives');

    app.directive('calendarWeekSwitch', function () {
        return {
            restrict: 'E',
            templateUrl: '/inc/calendar/frontend/templates/calendarTemplate.html',
            link: function($scope) {
                $scope.weekIndex = 0;
            }
        };
    });
})();