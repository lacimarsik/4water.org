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
            
        this.buildCalendars = function(calendarInfos) {
            this._updateSmallView();
            $scope.condensed = true;
            $scope.weekIndex = 0;
            
            $scope.calendars = [];
            for (var i = 0; i < calendarInfos.length; i++) {
                var calInfo = calendarInfos[i];
                
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
            $('#' + this.outerEventId(calendarId, index)).css('overflow', overflow);
            
            var eventCss = {
                cursor: hover ? 'pointer' : 'initial',
                backgroundColor: hover ? '#E7E8EA' : 'initial',
                zIndex: hover ? 999 : 'initial',
                overflowY: hover ? 'auto' : 'hidden'
            };
            $('#' + this.eventId(calendarId, index)).css(eventCss);
        };
               
        this.init = function(startWeek) {
            var self = this;
            Calendar4WaterApi.getCalendarData(startWeek, function(err, results) {
                if (err) {
                    $('#calendar-error').show();
                }
                else {
                    self.buildCalendars(results);
                    $scope.loaded = true;
                }
            });
        };
        
        $scope.borderBottomStyle = function(calEvent) {           
            if (!calEvent.short) {
                return '1px solid ' + calEvent.color;
            }
            return 'initial';
        };
        
        $scope.innerDivWidthStyle = function(calEvent) {
            if (calEvent.short) {
                return calEvent.outOf*100/calEvent.colWidth + '%';
            }
            return '100%';
        };
        
        $scope.narrowDivWidthStyle = function(calEvent) {
            if (calEvent.short) {
                return 100*calEvent.colWidth/calEvent.outOf + '%';
            }
            return '100%';
        };
        
        $scope.modalEventId = function(calId, index) {
            return this.eventId(calId, index) + '-modal';
        };
        
        $scope.outerEventId = function(calId, index) {
            return this.eventId(calId, index) + '-outer';
        };
        
        $scope.eventId = function(calId, index) {
            return calId + '-' + index;
        };
    }]);
})();