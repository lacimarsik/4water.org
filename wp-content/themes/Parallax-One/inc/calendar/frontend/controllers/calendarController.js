(function () {
    var module = angular.module('4water.controllers');

    module.controller('calendarController', 
            ['$scope', 'Calendar4Water', 'Calendar4WaterApi', 
            function ($scope, Calendar4Water, Calendar4WaterApi) {

        var self = this;
        
        $scope.loaded = false;
        $scope.loadError = false;
                
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
                calendarNormal.build(false, i);
                $scope.calendars.push(calendarNormal);
                
                var calendarCondensed = new Calendar4Water(procEvents, timePoints);
                calendarCondensed.build(true, i);
                $scope.calendars.push(calendarCondensed);
            }
        };
        
        $scope.eventHover = function(calendarId, index, hover) {
            var overflow = hover ? 'visible' : 'hidden';
            $('#' + calendarId + '-' + index + '-inner').css('overflow', overflow);
        };
        
        //Trying to get calendar through API call
        
        this.initBetter = function(startWeek) {
            Calendar4WaterApi.getCalendarData(startWeek, function(err, results) {
                if (err) {
                    $scope.loadError = true;
                    $('#calendar-error').append('ERROR');
                }
                else {
                    init(results);
                }
                $scope.loaded = true;
            });
        };
    }]);
})();