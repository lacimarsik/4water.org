(function () {
    var module = angular.module('4water.controllers');

    module.controller('calendarController', ['$scope', 'Calendar4Water', function ($scope, Calendar4Water) {
        var self = this;
        $(window).resize(function(){
            $scope.$apply(function(){
                self._updateSmallView();
            });
        });            
        
        this._updateSmallView = function() {
            $scope.smallView = window.innerWidth < 993;
            $scope.extraSmallView = window.innerWidth < 680;
        };
            
        this.init = function(calendarInfos) {
            this._updateSmallView();
            $scope.condensed = true;
            $scope.weekIndex = 0;
            
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