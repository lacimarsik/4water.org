(function () {
    var app = angular.module('4water.directives');

    app.directive('forWaterCalendar', function () {
        return {
            restrict: 'E',
            templateUrl: '/inc/calendar/frontend/templates/calendarTemplate.html'
        };
    });
})();