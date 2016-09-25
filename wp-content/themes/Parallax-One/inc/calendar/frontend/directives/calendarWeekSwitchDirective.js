(function () {
    var app = angular.module('4water.directives');

    app.directive('calendarWeekSwitch', function () {
            var templateUrl = null;
            if ((document.getElementById('calendar-this-week') != undefined) && (document.getElementById('calendar-next-week') != undefined)) {
                templateUrl = 'wp-content/themes/Parallax-One/inc/calendar/frontend/templates/calendarWeekSwitchTemplate.html';
            }
            return {
                restrict: 'E',
                link: function (scope) {
                    scope.getButtonTranslation = function (idOfTranslationDiv) {
                        // get translation from Customizer
                        var translationDiv = document.getElementById(idOfTranslationDiv);
                        return translationDiv.textContent;
                    }
                },
                templateUrl:  templateUrl
        }
    );
})();