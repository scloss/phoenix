$(function () {
    Highcharts.chart('containerRobiLinkPie', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Robi Link Availability of Last 12 hours'
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
            name: 'Robi Link Availability',
            colorByPoint: true,
            data: [{
                name: '0-99.90',
                y: parseInt(robi_link_availability_count_arr[0])
            },{
                name: '99.90-99.95',
                y: parseInt(robi_link_availability_count_arr[1])
            },{
                name: '99.95-100',
                y: parseInt(1200)
            }]
        }]
    });
});