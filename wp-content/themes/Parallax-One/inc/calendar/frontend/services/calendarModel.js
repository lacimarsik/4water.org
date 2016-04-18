(function () {
    var module = angular.module('4water.services');

    module.factory('Calendar4Water', function () { 
        var NON_CONDENSED_CALENDAR_HEIGHT = 500;
        var MAX_UNIT_HEIGHT = 100;
        var MIN_UNIT_HEIGHT = 30;
        var EDGE_UNIT_HEIGHT_RATIO = 1;
        var CONDENSED_UNIT_HEIGHT = 80;
        var DAY_LEGEND_HEIGHT = 70;
        var DAY_COL_PERC = 12.1;
        var TIME_COL_PERC = 15.3;
        var LINE_WIDTH = 2;

        var END_OF_DAY = 99;
        var START_OF_DAY = -99;
        
        function Calendar4Water(procEvents, timePoints) {
            this._procEvents = procEvents;
            this._timePoints = timePoints;
        }
        
        Calendar4Water.prototype.build = function(condensed) {    
            this._hasOvernight = this._hasOvernightEvent();

            this._minHour = this._timePoints[0];
            this._maxHour = this._timePoints[this._timePoints.length - 1];
            
            this.condensed = condensed;
            this._unitHeight = condensed 
                ? CONDENSED_UNIT_HEIGHT
                : this._getNonCondensedUnitHeight();
            this._edgeUnitHeight = Math.max(this._unitHeight*EDGE_UNIT_HEIGHT_RATIO, MIN_UNIT_HEIGHT);
            
            this.calendarHeightPx = this._getCalendarHeight();
            this.timeLines = this._makeTimeLines();
            this.timeLegends = this._makeTimeLegends();
            this.dayLegends = this._makeDayLegends();
            this.events = this._makeEvents();
        };

        Calendar4Water.prototype._getNonCondensedUnitHeight = function() {
            var result = NON_CONDENSED_CALENDAR_HEIGHT / (this._maxHour - this._minHour);
            result = Math.round(result);

            //should be withing limits
            result = Math.max(MIN_UNIT_HEIGHT, result);
            result = Math.min(MAX_UNIT_HEIGHT, result);

            //should be even number
            if (result % 2 === 1) result++;

            return result;
        };

        Calendar4Water.prototype._hasOvernightEvent = function() {
            for (var i = 0; i < this._procEvents.length; i++) {
                if (this._procEvents[i]['start-hour-frac'] > this._procEvents[i]['end-hour-frac']) {
                    return true;
                }
            }

            return false;
        };
        
        Calendar4Water.prototype._getCalendarHeight = function() {
            this.topOffset = DAY_LEGEND_HEIGHT;
            this.bottomOffset = 0;
            if (this._hasOvernight) {
                this.topOffset += this._edgeUnitHeight;
                this.bottomOffset += this._edgeUnitHeight;
            }

            if (this.condensed) {
                return this.topOffset + (this._timePoints.length - 1)*this._unitHeight + this.bottomOffset;
            }
            else {
                return this.topOffset + (this._maxHour - this._minHour)*this._unitHeight + this.bottomOffset;
            }
        };
        
        Calendar4Water.prototype._makeTimeLines = function() {
            var self = this;
            var timeLines = [];

            var makeTimeLine = function(top) {
                var timeLine = { 
                    topPx: top 
                };
                timeLines.push(timeLine);
            };

            if (this._hasOvernight) {
                makeTimeLine(-this._edgeUnitHeight);
            }

            for (var i = 0; i < this._timePoints.length; i++) {
                var top = this.condensed 
                    ? i*this._unitHeight
                    : (this._timePoints[i] - this._minHour)*this._unitHeight;
                makeTimeLine(top);
            }
            
            return timeLines;
        };

        Calendar4Water.prototype._makeTimeLegends = function() {   
            var self = this;
            var timeLegends = [];

            var prepTimeLegendText = function(from, till) {
                var timeLegendText = '';
                if (typeof(from) === 'number') {
                    timeLegendText += from <= 12 ? from + 'AM' : (from - 12) + 'PM';
                }
                else {
                    timeLegendText += from;
                }
                timeLegendText += ' - ';
                if (typeof(till) === 'number') {
                    timeLegendText += till <= 12 ? till + 'AM' : (till - 12) + 'PM';
                }
                else {
                    timeLegendText += till;
                }
                return timeLegendText;
            };

            var makeTimeLegend = function(timeLegendText, height, top) {
                var timeLegend = {
                    text: timeLegendText,
                    topPx: self.topOffset + top + height/2,
                    heightPx: height
                };
                timeLegends.push(timeLegend);
            };

            if (this._hasOvernight) {
                var height = this._edgeUnitHeight;

                var asguText = prepTimeLegendText('ASGU*', this._minHour);
                makeTimeLegend(asguText, height, -this._edgeUnitHeight);

                var thftText = prepTimeLegendText(this._maxHour, 'THFR*');
                var thfrTop = this.condensed 
                    ? (this._timePoints.length - 1)*this._unitHeight 
                    : (this._maxHour - this._minHour)*this._unitHeight;
                makeTimeLegend(thftText, height, thfrTop);
            }

            for (var i = 0; i < this._timePoints.length - 1; i++) {
                var timeLegendText = prepTimeLegendText(this._timePoints[i], this._timePoints[i + 1]);
                var height = this.condensed 
                    ? this._unitHeight
                    : (this._timePoints[i + 1] - this._timePoints[i])*this._unitHeight;
                var top = this.condensed 
                    ? i*this._unitHeight 
                    : (this._timePoints[i] - this._minHour)*this._unitHeight;
                makeTimeLegend(timeLegendText, height, top);
            }
            
            return timeLegends;
        };

        Calendar4Water.prototype._makeDayLegends = function() {
            var dayLegends = [];            
            
            var weekday = new Array(7);
            weekday[0] = "Monday";
            weekday[1] = "Tuesday";
            weekday[2] = "Wednesday";
            weekday[3] = "Thursday";
            weekday[4] = "Friday";
            weekday[5] = "Saturday";
            weekday[6]=  "Sunday";

            for (var i = 0; i < 7; i++) {
                var dayLegend = {
                    text: weekday[i],
                    leftPerc: TIME_COL_PERC + i*DAY_COL_PERC,
                    topPx: DAY_LEGEND_HEIGHT/2
                };
                dayLegends.push(dayLegend);
            }
            
            return dayLegends;
        };

        Calendar4Water.prototype._makeEvent = function(event) {
            var self = this;

            var getTimePointIndex = function(hourFrac) {
                var rounded = Math.round(hourFrac);

                if (rounded < self._timePoints[0]) return -1;

                for (var j = 0; j < self._timePoints.length; j++) {
                    if (rounded === self._timePoints[j]) return j;
                }

                return self._timePoints.length;
            };

            var getCondensedTop = function(hourFrac) {
                if (hourFrac === START_OF_DAY) return -self._edgeUnitHeight;
                if (hourFrac === END_OF_DAY) return (self._timePoints.length - 1)*self._unitHeight + self._edgeUnitHeight;

                var tlIndex = getTimePointIndex(hourFrac);
                var condensedTop = tlIndex*self._unitHeight;

                if (hourFrac - self._timePoints[tlIndex] > 0.084) { //more than 5 minutes
                    //todo
                }

                return condensedTop;
            };

            var getNormalTop = function(hourFrac) {
                if (hourFrac === START_OF_DAY) return -self._edgeUnitHeight;
                if (hourFrac === END_OF_DAY) return (self._maxHour - self._minHour)*self._unitHeight + self._edgeUnitHeight;

                return (hourFrac - self._minHour)*self._unitHeight;
            };

            var condensedHeight = getCondensedTop(event['end-hour-frac']) - getCondensedTop(event['start-hour-frac']);
            var normalHeight = getNormalTop(event['end-hour-frac']) - getNormalTop(event['start-hour-frac']);
            var height = this.condensed ? condensedHeight : normalHeight;

            var top = this.condensed ? getCondensedTop(event['start-hour-frac']) : getNormalTop(event['start-hour-frac']);

            var left = (event['start-day'] + event['concurrent-order']/event['concurrent-out-of'])*DAY_COL_PERC;

            var width = DAY_COL_PERC/event['concurrent-out-of'];

            return {
                title: event.title,
                leftPerc: TIME_COL_PERC + left, 
                topPx: this.topOffset + top + LINE_WIDTH,
                widthPerc: width,
                heightPx: height - LINE_WIDTH
            };
        };

        Calendar4Water.prototype._makeEvents = function() {  
            var events = [];
            
            for (var i = 0; i < this._procEvents.length; i++) {
                var event = this._procEvents[i];
                if (!event['display']) continue;

                //overnight event - split into two
                if (event['start-hour-frac'] > event['end-hour-frac']) {
                    var endHourFrac = event['end-hour-frac'];
                    var startHourFrac = event['start-hour-frac'];

                    event['end-hour-frac'] = END_OF_DAY;
                    events.push(this._makeEvent(event));
                    event['start-hour-frac'] = START_OF_DAY;
                    event['end-hour-frac'] = endHourFrac;
                    event['start-day']++;
                    events.push(this._makeEvent(event));
                    event['start-hour-frac'] = startHourFrac;
                    event['start-day']--;
                }
                else {
                    events.push(this._makeEvent(event));
                }
            }
            
            return events;
        };
        
        return Calendar4Water;
    });
})();