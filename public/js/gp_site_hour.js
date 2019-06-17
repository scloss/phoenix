
$(function () {
    Highcharts.chart('containerGPSitePie', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'GP Site Avialability of Last 12 hours'
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
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            name: 'GP Site Availability',
            colorByPoint: true,
            data: [{
                name: '0-99.90',
                y: parseInt(gp_site_availability_count_arr[0]),
                color: '#EB7B3E5'
            },{
                name: '99.90-99.95',
                y: parseInt(gp_site_availability_count_arr[1]),
                color: '#C46BD2'
            },{
                name: '99.95-100',
                y: parseInt(12),
                color: '#1CAE58'
            }]
        }]
    });
});