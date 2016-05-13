(function () {
    var module = angular.module('4water.services');

    module.factory('Calendar4Water', function ($filter) { 
        var NON_CONDENSED_CALENDAR_HEIGHT = 500;
        var MAX_UNIT_HEIGHT = 100;
        var MIN_UNIT_HEIGHT = 30;
        var CONDENSED_UNIT_HEIGHT = 80;
        var DAY_LEGEND_HEIGHT = 70;
        var DAY_COL_PERC = 12.1;
        var TIME_COL_PERC = 15.3;
        var LINE_WIDTH = 2;
        var LONG_TERM_UNIT_HEIGHT = 50;

        var END_OF_DAY = 99;
        var START_OF_DAY = -99;
        
        function Calendar4Water(procEvents, timePoints) {
            this._procEvents = procEvents;
            this._timePoints = timePoints;
        }
        
        Calendar4Water.prototype.build = function(condensed, weekIndex) {
            this.condensed = condensed;
            this.weekIndex = weekIndex;
            
            this._hasOvernight = this._hasOvernightEvent();

            this._minHour = this._timePoints[0];
            this._maxHour = this._timePoints[this._timePoints.length - 1];
            
            this._unitHeight = condensed 
                ? CONDENSED_UNIT_HEIGHT
                : this._getNonCondensedUnitHeight();
            this._edgeUnitHeight = this._unitHeight;
            this._longTermHeight = this._getLongTermHeight();
            
            this.colWidthPerc = DAY_COL_PERC;
            this.calendarHeightPx = this._getCalendarHeight();
            this.timeLines = this._makeTimeLines();
            this.timeLegends = this._makeTimeLegends();
            this.dayLegends = this._makeDayLegends();
            this.dayLines = this._makeDayLines();
            this.shortTermEvents = this._makeShortTermEvents();
            this.longTermEvents = this._makeLongTermEvents();
            this.events = this.shortTermEvents.concat(this.longTermEvents);
            this.id = (this.condensed ? 'c' : 'n') + this.weekIndex;
        };

        Calendar4Water.prototype._getLongTermHeight = function() {
            var maximum = 0;
            for (var i = 0; i < this._procEvents.length; i++) {
                if (this._procEvents[i]['short-term']) continue;
                
                maximum = this._procEvents[i]['concurrent-out-of'] > maximum ? 
                    this._procEvents[i]['concurrent-out-of'] :
                    maximum;
            }
            
            return maximum*LONG_TERM_UNIT_HEIGHT;
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
            if (this._timePoints.length === 0) return DAY_LEGEND_HEIGHT;
                      
            this.topOffset = DAY_LEGEND_HEIGHT + this._longTermHeight;
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

            var makeTimeLine = function(top, intensive) {
                var timeLine = { 
                    topPx: self.topOffset + top,
                    intensive: intensive ? true : false
                };
                timeLines.push(timeLine);
            };

            if (this._hasOvernight) {
                makeTimeLine(-this._edgeUnitHeight, true);
            }
            if (this._longTermHeight > 0) {
                makeTimeLine(-this._edgeUnitHeight - this._longTermHeight, true);
            }

            for (var i = 0; i < this._timePoints.length; i++) {
                var top = this.condensed 
                    ? i*this._unitHeight
                    : (this._timePoints[i] - this._minHour)*this._unitHeight;
                makeTimeLine(top, i === 0 && !this._hasOvernight);
            }
            
            return timeLines;
        };

        Calendar4Water.prototype._makeTimeLegends = function() {   
            var self = this;
            var timeLegends = [];

            var addAmPm = function(entry) {
                return entry <= 12 ? entry + 'AM' : (entry - 12) + 'PM';
            };

            var prepTimeLegendText = function(entryA, entryB) {
                if (typeof(entryA) === 'number') {
                    entryA = addAmPm(entryA);
                }
                
                if (typeof(entryB) === 'number') {
                    entryB = addAmPm(entryB);
                }
                
                var text = entryA;
                if (entryB) {
                    text += ' - ' + entryB;
                }
                return text;
            };

            var makeTimeLegend = function(text, height, top) {
                var timeLegend = {
                    text: text,
                    topPx: self.topOffset + top + height/2,
                    heightPx: height,
                    widthPerc: TIME_COL_PERC
                };
                timeLegends.push(timeLegend);
            };

            if (this._longTermHeight > 0) {
                var longTermText = prepTimeLegendText('ALL DAY');
                makeTimeLegend(longTermText, this._longTermHeight, -this._edgeUnitHeight - this._longTermHeight);
            }

            if (this._hasOvernight) {
                var height = this._edgeUnitHeight;

                var asguText = prepTimeLegendText('ASGU*', this._minHour);
                makeTimeLegend(asguText, height, -this._edgeUnitHeight);

                var tfhrText = prepTimeLegendText(this._maxHour, 'TFHR*');
                var tfhrTop = this.condensed 
                    ? (this._timePoints.length - 1)*this._unitHeight 
                    : (this._maxHour - this._minHour)*this._unitHeight;
                makeTimeLegend(tfhrText, height, tfhrTop);
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
                    short: weekday[i].slice(0, 3).toUpperCase(),
                    leftPerc: TIME_COL_PERC + i*DAY_COL_PERC,
                    topPx: DAY_LEGEND_HEIGHT/2,
                    widthPerc: DAY_COL_PERC,
                };
                dayLegends.push(dayLegend);
            }
            
            return dayLegends;
        };
        
        Calendar4Water.prototype._makeDayLines = function() {
            var self = this;
            var dayLines = [];            
            
            for (var i = 0; i < 7; i++) {
                var dayLine = {
                    leftPerc: TIME_COL_PERC + i*DAY_COL_PERC,
                    topPx: 0,
                    bottomPx: self.calendarHeightPx
                };
                dayLines.push(dayLine);
            }
            
            return dayLines;
        };

        Calendar4Water.prototype._makeShortTermEvent = function(event) {
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
                var fraction = hourFrac - self._timePoints[tlIndex];
                if (tlIndex === 0 || tlIndex === self._timePoints.length - 1) {
                    fraction /= 2;
                }
                else {
                    var otherTlIndex = fraction < 0 ? tlIndex - 1 : tlIndex + 1;
                    fraction /= Math.abs(self._timePoints[tlIndex] - self._timePoints[otherTlIndex]);
                }
                var condensedTop = (tlIndex + fraction)*self._unitHeight;

                return condensedTop;
            };

            var getNormalTop = function(hourFrac) {
                if (hourFrac === START_OF_DAY) return -self._edgeUnitHeight;
                if (hourFrac === END_OF_DAY) return (self._maxHour - self._minHour)*self._unitHeight + self._edgeUnitHeight;

                return (hourFrac - self._minHour)*self._unitHeight;
            };

            var condensedHeight = getCondensedTop(event['end-hour-frac']) - getCondensedTop(event['start-hour-frac']);
            var normalHeight = getNormalTop(event['end-hour-frac']) - getNormalTop(event['start-hour-frac']);
            
            var top = this.condensed ? getCondensedTop(event['start-hour-frac']) : getNormalTop(event['start-hour-frac']);
            var left = (event['start-day'] + (event['concurrent-order'] - 1)/event['concurrent-out-of'])*DAY_COL_PERC;
            var height = this.condensed ? condensedHeight : normalHeight;
            var width = event['concurrent-width']*(DAY_COL_PERC/event['concurrent-out-of']);

            return this._makeEvent(event, top, left, height, width);
        };

        Calendar4Water.prototype._makeShortTermEvents = function() {
            var events = [];

            for (var i = 0; i < this._procEvents.length; i++) {
                var event = this._procEvents[i];
                if (!event['short-term']) continue;

                if (event['start-hour-frac'] > event['end-hour-frac']) {
                    //overnight event - split into two

                    var endHourFrac = event['end-hour-frac'];
                    var startHourFrac = event['start-hour-frac'];

                    event['end-hour-frac'] = END_OF_DAY;
                    events.push(this._makeShortTermEvent(event));
                    event['start-hour-frac'] = START_OF_DAY;
                    event['end-hour-frac'] = endHourFrac;
                    event['start-day']++;
                    events.push(this._makeShortTermEvent(event));
                    event['start-hour-frac'] = startHourFrac;
                    event['start-day']--;
                }
                else {
                    events.push(this._makeShortTermEvent(event));
                }
            }

            return events;
        };
        
        Calendar4Water.prototype._makeEvent = function(event, top, left, height, width) {
            var startDt = new Date(event.start.date);
            var endDt = new Date(event.end.date);
            var dtFormat = startDt.toDateString() !== endDt.toDateString() ? 'EEE h:mma' : 'h:mma';

            return {
                title: event.title,
                startDt: startDt,
                endDt: endDt,
                dtFormat: dtFormat,
                tz: event.start.timezone,
                color: event.color,
                desc: event.desc,
                location: event.location,
                locationLink: 'https://www.google.co.uk/maps/search/' + $filter('escape')(event.location),
                url: event.url,
                outOf: event['concurrent-out-of'],
                order: event['concurrent-order'],
                colWidth: event['concurrent-width'],
                short: event['short-term'] ? true : false,
                
                leftPerc: TIME_COL_PERC + left, 
                topPx: this.topOffset + top + LINE_WIDTH,
                widthPerc: width,
                heightPx: height - LINE_WIDTH
            };
        };
        
        Calendar4Water.prototype._makeLongTermEvent = function(event) {
            var height = this._longTermHeight/event['concurrent-out-of'];
            var top = -this._edgeUnitHeight - this._longTermHeight + event['concurrent-order']*height;
            var left = event['day']*DAY_COL_PERC;
            var width = DAY_COL_PERC;

            return this._makeEvent(event, top, left, height, width);
        };
        
        Calendar4Water.prototype._makeLongTermEvents = function() {  
            var events = [];

            for (var i = 0; i < this._procEvents.length; i++) {
                var event = this._procEvents[i];
                if (event['short-term']) continue;
                events.push(this._makeLongTermEvent(event));
            }

            return events;
        };
        
        return Calendar4Water;
    });
})();