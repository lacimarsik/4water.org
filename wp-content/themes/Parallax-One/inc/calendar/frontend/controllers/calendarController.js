(function () {
    var module = angular.module('4water.controllers');

    module.controller('calendarController', ['$scope', 'Calendar4Water', function ($scope, Calendar4Water) {
        var self = this;
        
        this.init = function(calendarInfos) {
            console.log(calendarInfos);
            $scope.calendars = [];
            for (var i = 0; i < calendarInfos.length; i++) {
                var calInfo = JSON.parse(calendarInfos[i]);
                var procEvents = calInfo.procEvents;
                var timePoints = calInfo.timePoints;
                
                var calendarNormal = new Calendar4Water(procEvents, timePoints);
                calendarNormal.build(false);
                calendarNormal.weekIndex = i;
                $scope.calendars.push(calendarNormal);
                
                var calendarCondensed = new Calendar4Water(procEvents, timePoints);
                calendarCondensed.build(true);
                calendarCondensed.weekIndex = i;
                $scope.calendars.push(calendarCondensed);
            }
        };
    }]);
})();