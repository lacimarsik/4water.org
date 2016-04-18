/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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

function CalendarDiv(selector, procEvents, timePoints) {
    this.procEvents = procEvents;
    this.timePoints = timePoints;
    this.hasOvernight = this.hasOvernightEvent();
    
    this.minHour = this.timePoints[0];
    this.maxHour = this.timePoints[this.timePoints.length - 1];
    
    this.calendarDiv = $(selector);
}

CalendarDiv.prototype.getNonCondensedUnitHeight = function() {
    var result = NON_CONDENSED_CALENDAR_HEIGHT / (this.maxHour - this.minHour);
    result = Math.round(result);
    
    //should be withing limits
    result = Math.max(MIN_UNIT_HEIGHT, result);
    result = Math.min(MAX_UNIT_HEIGHT, result);
    
    //should be even number
    if (result % 2 === 1) result++;
    
    return result;
};

CalendarDiv.prototype.populate = function(condensed) {    
    this.condensed = condensed;
    this.unitHeight = condensed 
        ? CONDENSED_UNIT_HEIGHT
        : this.getNonCondensedUnitHeight();
    this.edgeUnitHeight = Math.max(this.unitHeight*EDGE_UNIT_HEIGHT_RATIO, MIN_UNIT_HEIGHT);
        
    this.clear();
    this.setCalendarHeight();
    this.makeTimeLines();
    this.makeTimeLegends();
    this.makeDayLegends();
    this.makeEvents();
}

CalendarDiv.prototype.hasOvernightEvent = function() {
    for (var i = 0; i < this.procEvents.length; i++) {
        if (this.procEvents[i]['start-hour-frac'] > this.procEvents[i]['end-hour-frac']) {
            return true;
        }
    }
    
    return false;
};

CalendarDiv.prototype.clear = function() {
    this.calendarDiv.empty();
};

CalendarDiv.prototype.setCalendarHeight = function() {
    this.topOffset = DAY_LEGEND_HEIGHT;
    this.bottomOffset = 0;
    if (this.hasOvernight) {
        this.topOffset += this.edgeUnitHeight;
        this.bottomOffset += this.edgeUnitHeight;
    }
    
    if (this.condensed) {
        this.calendarHeight = this.topOffset + (this.timePoints.length - 1)*this.unitHeight + this.bottomOffset;
    }
    else {
        this.calendarHeight = this.topOffset + (this.maxHour - this.minHour)*this.unitHeight + this.bottomOffset;
    }
    this.calendarDiv.css({ height: this.calendarHeight + 'px' });
};

CalendarDiv.prototype.makeTimeLines = function() {
    var self = this;
    
    var makeTimeLine = function(top) {
        var hr = $('<hr>');
        hr.addClass('calendar-sep');
                
        hr.css({ top: self.topOffset + top + 'px' });
        self.calendarDiv.append(hr);
    };
    
    if (this.hasOvernight) {
        makeTimeLine(-this.edgeUnitHeight);
    }
    
    for (var i = 0; i < this.timePoints.length; i++) {
        var top = this.condensed 
            ? i*this.unitHeight
            : (this.timePoints[i] - this.minHour)*this.unitHeight;
        makeTimeLine(top);
    }
};

CalendarDiv.prototype.makeTimeLegends = function() {   
    var self = this;
    
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
        var timeLegend = $('<div>' + timeLegendText + '</div>');
        timeLegend.addClass('time-legend');
        timeLegend.css({ top: self.topOffset + top + height/2 + 'px', height: height });
        self.calendarDiv.append(timeLegend);
    };
    
    if (this.hasOvernight) {
        var height = this.edgeUnitHeight;
        
        var asguText = prepTimeLegendText('ASGU*', this.minHour);
        makeTimeLegend(asguText, height, -this.edgeUnitHeight);
        
        var thftText = prepTimeLegendText(this.maxHour, 'THFR*');
        var thfrTop = this.condensed 
            ? (this.timePoints.length - 1)*this.unitHeight 
            : (this.maxHour - this.minHour)*this.unitHeight;
        makeTimeLegend(thftText, height, thfrTop);
    }
    
    for (var i = 0; i < this.timePoints.length - 1; i++) {
        var timeLegendText = prepTimeLegendText(this.timePoints[i], this.timePoints[i + 1]);
        var height = this.condensed 
            ? this.unitHeight
            : (this.timePoints[i + 1] - this.timePoints[i])*this.unitHeight;
        var top = this.condensed 
            ? i*this.unitHeight 
            : (this.timePoints[i] - this.minHour)*this.unitHeight;
        makeTimeLegend(timeLegendText, height, top);
    }
};

CalendarDiv.prototype.makeDayLegends = function() {
    var weekday = new Array(7);
    weekday[0] = "Monday";
    weekday[1] = "Tuesday";
    weekday[2] = "Wednesday";
    weekday[3] = "Thursday";
    weekday[4] = "Friday";
    weekday[5] = "Saturday";
    weekday[6]=  "Sunday";

    for (var i = 0; i < 7; i++) {
        var dayLegendText = weekday[i];
        var dayLegend = $('<div>' + dayLegendText + '</div>');
        dayLegend.addClass('day-legend');
        dayLegend.css({ left: TIME_COL_PERC + i*DAY_COL_PERC + '%', top: DAY_LEGEND_HEIGHT/2 + 'px' });
        this.calendarDiv.append(dayLegend);
    }
};

CalendarDiv.prototype.makeEvent = function(event) {
    var self = this;
    
    var getTimePointIndex = function(hourFrac) {
        var rounded = Math.round(hourFrac);
        
        if (rounded < self.timePoints[0]) return -1;
        
        for (var j = 0; j < self.timePoints.length; j++) {
            if (rounded === self.timePoints[j]) return j;
        }
        
        return self.timePoints.length;
    };
    
    var getCondensedTop = function(hourFrac) {
        if (hourFrac === START_OF_DAY) return -self.edgeUnitHeight;
        if (hourFrac === END_OF_DAY) return (self.timePoints.length - 1)*self.unitHeight + self.edgeUnitHeight;
        
        var tlIndex = getTimePointIndex(hourFrac);
        var condensedTop = tlIndex*self.unitHeight;
        
        if (hourFrac - self.timePoints[tlIndex] > 0.084) { //more than 5 minutes
            //todo
        }
               
        return condensedTop;
    };
    
    var getNormalTop = function(hourFrac) {
        if (hourFrac === START_OF_DAY) return -self.edgeUnitHeight;
        if (hourFrac === END_OF_DAY) return (self.maxHour - self.minHour)*self.unitHeight + self.edgeUnitHeight;
        
        return (hourFrac - self.minHour)*self.unitHeight;
    };
       
    eventHtml = event.title;
    var calEvent = $('<div>' + eventHtml + '</div>');
    calEvent.addClass('calendar-event');

    var condensedHeight = getCondensedTop(event['end-hour-frac']) - getCondensedTop(event['start-hour-frac']);
    var normalHeight = getNormalTop(event['end-hour-frac']) - getNormalTop(event['start-hour-frac']);
    var height = this.condensed ? condensedHeight : normalHeight;
    
    var top = this.condensed ? getCondensedTop(event['start-hour-frac']) : getNormalTop(event['start-hour-frac']);
        
    var left = (event['start-day'] + event['concurrent-order']/event['concurrent-out-of'])*DAY_COL_PERC;
    
    var width = DAY_COL_PERC/event['concurrent-out-of'];

    calEvent.css({ 
        left: TIME_COL_PERC + left + '%', 
        top: this.topOffset + top + LINE_WIDTH + 'px',
        width: width + '%',
        height: height - LINE_WIDTH
    });
    this.calendarDiv.append(calEvent);
};

CalendarDiv.prototype.makeEvents = function() {   
    for (var i = 0; i < this.procEvents.length; i++) {
        var event = this.procEvents[i];
        if (!event['display']) continue;
        
        //overnight event - split into two
        if (event['start-hour-frac'] > event['end-hour-frac']) {
            var endHourFrac = event['end-hour-frac'];
            var startHourFrac = event['start-hour-frac'];
            
            event['end-hour-frac'] = END_OF_DAY;
            this.makeEvent(event);
            event['start-hour-frac'] = START_OF_DAY;
            event['end-hour-frac'] = endHourFrac;
            event['start-day']++;
            this.makeEvent(event);
            event['start-hour-frac'] = startHourFrac;
            event['start-day']--;
        }
        else {
            this.makeEvent(event);
        }
    }
};