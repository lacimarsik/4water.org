(function () {
    var app = angular.module('4water.directives');

    app.directive('calendarWeekSwitch', function () {
        return {
            restrict: 'E',
            link: function(scope) {
                scope.getButtonTranslation = function(idOfTranslationDiv) {
                    // get translation from Customizer
                    var translationDiv = document.getElementById(idOfTranslationDiv);
                    return translationDiv.textContent;
                }
            },
            templateUrl: 'wp-content/themes/Parallax-One/inc/calendar/frontend/templates/calendarWeekSwitchTemplate.html'
        };
    });
})();