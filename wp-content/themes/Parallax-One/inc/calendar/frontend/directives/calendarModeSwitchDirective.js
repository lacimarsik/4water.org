(function () {
    var app = angular.module('4water.directives');

    app.directive('calendarModeSwitch', function () {
        return {
            restrict: 'E',
            templateUrl: '/4water/wp-content/themes/Parallax-One/inc/calendar/frontend/templates/calendarModeSwitchTemplate.html'
        };
    });
})();