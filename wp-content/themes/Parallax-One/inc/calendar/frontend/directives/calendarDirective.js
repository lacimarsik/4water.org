(function () {
    var app = angular.module('4water.directives');

    app.directive('forWaterCalendar', function () {
        return {
            restrict: 'E',
            replace: true,
            templateUrl: 'wp-content/themes/Parallax-One/inc/calendar/frontend/templates/calendarTemplate.html'
        };
    });
})();