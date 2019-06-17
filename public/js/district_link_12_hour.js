$(function () {
    Highcharts.chart('containerDistrictLinkBar', {
        chart: {
            zoomType: 'xy',
            height: 600
        },
        title: {
            text: 'District Wise 12 Hour Link Outage'
        },
        xAxis: [{
            type: 'category',
            crosshair: true
        }],
        yAxis: [{ // Primary yAxis
            labels: {
                format: '{value}',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            },
            title: {
                text: 'Outage Count',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            }
        }, { // Secondary yAxis
            title: {
                text: 'Outage Hour',
                style: {
                    color: Highcharts.getOptions().colors[0],

                }
            },
            labels: {
                format: '{value} h',
                style: {
                    color: Highcharts.getOptions().colors[0]
                }
            },
            opposite: true
        }],
        tooltip: {
            shared: true
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            spline: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{y}',
                    style:{
                        fontSize:12
                    },
                    allowOverlap:true,
                    verticalAlign:'top'
                }
            },
            column: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{y} h',
                    style:{
                        fontSize:12
                    },
                    allowOverlap:true,
                    verticalAlign:'bottom'
                }
            }
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
                name: top_5_district_link_arr_keys[0],
                y: top_5_district_link_arr[top_5_district_link_arr_keys[0]]
            }, {
                name: top_5_district_link_arr_keys[1],
                y: top_5_district_link_arr[top_5_district_link_arr_keys[1]]
            }, {
                name: top_5_district_link_arr_keys[2],
                y: top_5_district_link_arr[top_5_district_link_arr_keys[2]]
            }, {
                name: top_5_district_link_arr_keys[3],
                y: top_5_district_link_arr[top_5_district_link_arr_keys[3]]
            }, {
                name: top_5_district_link_arr_keys[4],
                y: top_5_district_link_arr[top_5_district_link_arr_keys[4]]
            }],
            tooltip: {
                valueSuffix: ' h'
            }

        }, {
            name: 'Outage Count',
            type: 'spline',
            data: [{
                name: top_5_district_link_arr_keys[0],
                y: top_5_district_link_count_arr[top_5_district_link_arr_keys[0]]
            }, {
                name: top_5_district_link_arr_keys[1],
                y: top_5_district_link_count_arr[top_5_district_link_arr_keys[1]]
            }, {
                name: top_5_district_link_arr_keys[2],
                y: top_5_district_link_count_arr[top_5_district_link_arr_keys[2]]
            }, {
                name: top_5_district_link_arr_keys[3],
                y: top_5_district_link_count_arr[top_5_district_link_arr_keys[3]]
            }, {
                name: top_5_district_link_arr_keys[4],
                y: top_5_district_link_count_arr[top_5_district_link_arr_keys[4]]
            }],
            tooltip: {
                valueSuffix: ''
            }
        }]
    });
});

