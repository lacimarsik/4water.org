(function () {
    var app = angular.module('4water.directives');

    app.directive('calendarModalEvent', function () {
        return {
            restrict: 'E',
            replace: true,
            templateUrl: 'wp-content/themes/Parallax-One/inc/calendar/frontend/templates/calendarModalEventTemplate.html'
        };
    });
})();