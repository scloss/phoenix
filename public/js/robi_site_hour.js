$(function () {
    Highcharts.chart('containerRobiSitePie', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Robi Site Availability of Last 12 hours'
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
            name: 'Robi Site Availability',
            colorByPoint: true,
            data: [{
                name: '0-99.90',
                y: parseInt(99),
                color: '#EB7B3E5'
            },{
                name: '99.90-99.95',
                y: parseInt(99.92),
                color: '#C46BD2'
            },{
                name: '99.95-100',
                y: parseInt(100),
                color: '#1CAE58'
            }]
        }]
    });
});