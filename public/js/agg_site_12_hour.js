  $(function () {
    Highcharts.chart('containerAggSitePie', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Agg and Pre-agg Site Availability of Last 12 hours'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Site Availability',
            colorByPoint: true,
            data: [{
                name: 'Up Time',
                y: parseInt(agg_up_time)
            },{
                name: 'Down Time',
                y: parseInt(agg_down_time)
            }]
        }]
    });
});