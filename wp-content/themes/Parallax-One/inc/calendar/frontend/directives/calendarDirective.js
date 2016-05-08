(function () {
    var app = angular.module('4water.directives');

    app.directive('forWaterCalendar', function () {
        return {
            restrict: 'E',
            replace: true,
            templateUrl: '/4water/wp-content/themes/Parallax-One/inc/calendar/frontend/templates/calendarTemplate.html'
        };
    });
})();