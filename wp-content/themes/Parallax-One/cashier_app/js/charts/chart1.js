// Chart 1 - Timeline

$(function() {
    
    // Custom colors for this graph
    Highcharts.setOptions({
        colors: ['#3bb479', '#4a99e3']
    });
    
    var table = document.getElementById('datatable_for_chart1');
    $('#chart1').highcharts({
        data: {
            table: table
        },
        chart: {
            type: 'column'
        },
        title: {
            text: table.caption.innerHTML
        },
        xAxis: {
            //categories: ['2012', '2013']
        },
        yAxis: {
            title: {
                text: 'CZK'
            },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                },
                formatter: function () {
                    
                    //if we want to shorten the tooltip number
                    //return Highcharts.numberFormat(this.total / 1000000,'0') + ' mil €';
   
                    return Highcharts.numberFormat(this.total,'0') + ' CZK';
                }
            },
            labels: {
                formatter: function () {
                    return this.value;
                }
            }
        },
        tooltip: { 
            formatter: function() {
                if (this.series.name == 'Students') {
                    return '<b>'+ this.x +'</b><br/>'+
                    'Students: '+ Highcharts.numberFormat(this.y,'2f') + ' CZK<br/>' +
                    '<b>All: '+ Highcharts.numberFormat(this.point.stackTotal,'2f') + ' CZK</b>';
                } else {
                    return '<b>'+ this.x +'</b><br/>'+
                    '<b>' + this.series.name + ': '+ Highcharts.numberFormat(this.y,'2f') + ' CZK</b>';
                }

            }
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                    style: {
                        textShadow: '0 0 3px black, 0 0 3px black'
                    },
                    formatter: function () {
                        //if we want to shorten the tooltip number
                        //return Highcharts.numberFormat(this.point.y / 1000000,'0') + ' mil €';
                        
                        return Highcharts.numberFormat(this.point.y,'0') + ' CZK';
                    }
                }
            }
        },
        series: [{
                pointWidth: 100
            }, {
                pointWidth: 100
            }]
    });
});
