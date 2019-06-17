$(function () {
    Highcharts.chart('containerTest', {
        chart: {
            zoomType: 'xy'
        },
        title: {
            text: 'Average Monthly Temperature and Rainfall in Tokyo'
        },
        subtitle: {
            text: 'Source: WorldClimate.com'
        },
        xAxis: [{
            type: 'category',
            crosshair: true
        }],
        yAxis: [{ // Primary yAxis
            labels: {
                format: '{value} H',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            },
            title: {
                text: 'Outage Hour',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            }
        }, { // Secondary yAxis
            title: {
                text: 'Outage count',
                style: {
                    color: Highcharts.getOptions().colors[0]
                }
            },
            labels: {
                format: '{value}',
                style: {
                    color: Highcharts.getOptions().colors[0]
                }
            },
            opposite: true
        }],
        tooltip: {
            shared: true
        },
        legend: {
            layout: 'vertical',
            align: 'left',
            x: 120,
            verticalAlign: 'top',
            y: 100,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
        },
        series: [{
            name: 'Districts',
            type: 'column',
            yAxis: 1,
            data: [{
                name: top_5_district_site_arr_keys[0],
                y: top_5_district_site_arr[top_5_district_site_arr_keys[0]]
            }, {
                name: top_5_district_site_arr_keys[1],
                y: top_5_district_site_arr[top_5_district_site_arr_keys[1]]
            }, {
                name: top_5_district_site_arr_keys[2],
                y: top_5_district_site_arr[top_5_district_site_arr_keys[2]]
            }, {
                name: top_5_district_site_arr_keys[3],
                y: top_5_district_site_arr[top_5_district_site_arr_keys[3]]
            }, {
                name: top_5_district_site_arr_keys[4],
                y: top_5_district_site_arr[top_5_district_site_arr_keys[4]]
            }],
            tooltip: {
                valueSuffix: ' h'
            }

        }, {
            name: 'Outage Count',
            type: 'spline',
            data: [{
                name: top_5_district_site_arr_keys[0],
                y: top_5_district_site_count_arr[top_5_district_site_arr_keys[0]]
            }, {
                name: top_5_district_site_arr_keys[1],
                y: top_5_district_site_count_arr[top_5_district_site_arr_keys[1]]
            }, {
                name: top_5_district_site_arr_keys[2],
                y: top_5_district_site_count_arr[top_5_district_site_arr_keys[2]]
            }, {
                name: top_5_district_site_arr_keys[3],
                y: top_5_district_site_count_arr[top_5_district_site_arr_keys[3]]
            }, {
                name: top_5_district_site_arr_keys[4],
                y: top_5_district_site_count_arr[top_5_district_site_arr_keys[4]]
            }],
            tooltip: {
                valueSuffix: ''
            }
        }]
    });
});