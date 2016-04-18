(function () {
    var app = angular.module('4water.directives');

    app.directive('calendarModeSwitch', function () {
        return {
            restrict: 'E',
            templateUrl: '/inc/calendar/frontend/templates/calendarTemplate.html',
            link: function($scope) {
                $scope.condensed = true;
            }
        };
    });
})();