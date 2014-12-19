define([
    'jquery',
    'underscore',
    'backbone',
    //'text!templates/form/form_add_admin.html'
    ], function($, _, Backbone,loginTemplate){
        // var $html_loadding = '<div class="caculation-report"><img style="margin-left:170px" src="'+$template_admincp_url+'img/standard/loaders/loading64.gif"/></div>';
        var view = Backbone.View.extend({
            el: $("#wrapper"),
            initialize: function(){
                
            },
            events: {
                "click #updateUserStatistics": "updateUserStatistics"
            },
            
            updateUserStatistics: function(){
                $("#modal-default").modal();
                $('#modal-default').on('shown.bs.modal', function (e) {
                    $(".modal-title").html('Update User Statistics');
                    $(".modal-body").html('<div class="divLoading"></div>');
                    $.ajax({
                        url: base_url + "/admin/data/update-user-statistics",
                        type: 'post',
                        success: function(rs){
                            rs = JSON.parse(rs);
                            $("#modal-default").modal('hide');
                        }
                    });
                })
            },
            
            index: function(){
                // Get the CSV and create the chart
                $.getJSON('admin/data/data-user-statistics?filename=analytics.csv&callback=?', function (csv) {
                    $('#userStatistics').highcharts({
                        data: {
                            csv: csv,
                            // Parse the American date format used by Google
                            parseDate: function (s) {
                                var match = s.match(/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{2})$/);
                                if (match) {
                                    return Date.UTC(+('20' + match[3]), match[1] - 1, +match[2]);
                                }
                            }
                        },

                        title: {
                            text: 'Daily visits at dev.khophim.vn'
                        },

                        subtitle: {
                            text: 'Source: Google Analytics'
                        },

                        xAxis: {
                            type: 'datetime',
                            tickInterval: 7 * 24 * 3600 * 1000, // one week
                            tickWidth: 0,
                            gridLineWidth: 1,
                            labels: {
                                align: 'left',
                                x: 3,
                                y: -3
                            }
                        },

                        yAxis: [{ // left y axis
                            title: {
                                text: null
                            },
                            labels: {
                                align: 'left',
                                x: 3,
                                y: 16,
                                format: '{value:.,0f}'
                            },
                            showFirstLabel: false
                        }, { // right y axis
                            linkedTo: 0,
                            gridLineWidth: 0,
                            opposite: true,
                            title: {
                                text: null
                            },
                            labels: {
                                align: 'right',
                                x: -3,
                                y: 16,
                                format: '{value:.,0f}'
                            },
                            showFirstLabel: false
                        }],

                        legend: {
                            align: 'left',
                            verticalAlign: 'top',
                            y: 20,
                            floating: true,
                            borderWidth: 0
                        },

                        tooltip: {
                            shared: true,
                            crosshairs: true
                        },

                        plotOptions: {
                            series: {
                                cursor: 'pointer',
                                point: {
                                    events: {
                                        click: function (e) {
                                            hs.htmlExpand(null, {
                                                pageOrigin: {
                                                    x: e.pageX,
                                                    y: e.pageY
                                                },
                                                headingText: this.series.name,
                                                maincontentText: Highcharts.dateFormat('%A, %b %e, %Y', this.x) +':<br/> '+
                                                    this.y +' visits',
                                                width: 200
                                            });
                                        }
                                    }
                                },
                                marker: {
                                    lineWidth: 1
                                }
                            }
                        },

                        series: [{
                            name: 'All visits',
                            lineWidth: 4,
                            marker: {
                                radius: 4
                            }
                        }, {
                            name: 'New visitors'
                        }]
                    });
                });
                
                $('#viewStatistics').highcharts({
                    chart: {
                        type: 'column',
                        options3d: {
                            enabled: true,
                            alpha: 15,
                            beta: 15,
                            viewDistance: 25,
                            depth: 40
                        },
                        marginTop: 80,
                        marginRight: 40
                    },

                    title: {
                        text: 'Total view'
                    },

                    xAxis: {
                        // categories: ['January','February','March','April','May','June','July','August','September','October','November','December']
                        categories: ['01','02','03','04','05','06','07','08','09','10','11','12']
                        
                    },

                    yAxis: {
                        allowDecimals: false,
                        min: 0,
                        title: {
                            text: 'Number of view'
                        }
                    },

                    tooltip: {
                        headerFormat: '<b>{point.key}</b><br>',
                        pointFormat: '<span style="color:{series.color}">\u25CF</span> {series.name}: {point.y} / {point.stackTotal}'
                    },

                    plotOptions: {
                        column: {
                            stacking: 'normal',
                            depth: 40
                        }
                    },

                    series: [{
                        name: 'Movie',
                        data: [5, 3, 4, 7, 2, 5, 3, 4, 7, 2, 9, 12]
                    }, {
                        name: 'Drama',
                        data: [3, 4, 4, 2, 5, 3, 4, 4, 2, 5, 8, 13]
                    }]
                });
//                Morris.Area({
//                    element: 'morris-area-chart',
//                    data: [{
//                        period: '2010 Q1',
//                        iphone: 2666,
//                        ipad: null,
//                        itouch: 2647
//                    }, {
//                        period: '2010 Q2',
//                        iphone: 2778,
//                        ipad: 2294,
//                        itouch: 2441
//                    }, {
//                        period: '2010 Q3',
//                        iphone: 4912,
//                        ipad: 1969,
//                        itouch: 2501
//                    }, {
//                        period: '2010 Q4',
//                        iphone: 3767,
//                        ipad: 3597,
//                        itouch: 5689
//                    }, {
//                        period: '2011 Q1',
//                        iphone: 6810,
//                        ipad: 1914,
//                        itouch: 2293
//                    }, {
//                        period: '2011 Q2',
//                        iphone: 5670,
//                        ipad: 4293,
//                        itouch: 1881
//                    }, {
//                        period: '2011 Q3',
//                        iphone: 4820,
//                        ipad: 3795,
//                        itouch: 1588
//                    }, {
//                        period: '2011 Q4',
//                        iphone: 15073,
//                        ipad: 5967,
//                        itouch: 5175
//                    }, {
//                        period: '2012 Q1',
//                        iphone: 10687,
//                        ipad: 4460,
//                        itouch: 2028
//                    }, {
//                        period: '2012 Q2',
//                        iphone: 8432,
//                        ipad: 5713,
//                        itouch: 1791
//                    }],
//                    xkey: 'period',
//                    ykeys: ['iphone', 'ipad', 'itouch'],
//                    labels: ['iPhone', 'iPad', 'iPod Touch'],
//                    pointSize: 2,
//                    hideHover: 'auto',
//                    resize: true
//                });
//
//                Morris.Donut({
//                    element: 'morris-donut-chart',
//                    data: [{
//                        label: "Download Sales",
//                        value: 12
//                    }, {
//                        label: "In-Store Sales",
//                        value: 30
//                    }, {
//                        label: "Mail-Order Sales",
//                        value: 20
//                    }],
//                    resize: true
//                });
//
//                Morris.Bar({
//                    element: 'morris-bar-chart',
//                    data: [{
//                        y: '2006',
//                        a: 100,
//                        b: 90
//                    }, {
//                        y: '2007',
//                        a: 75,
//                        b: 65
//                    }, {
//                        y: '2008',
//                        a: 50,
//                        b: 40
//                    }, {
//                        y: '2009',
//                        a: 75,
//                        b: 65
//                    }, {
//                        y: '2010',
//                        a: 50,
//                        b: 40
//                    }, {
//                        y: '2011',
//                        a: 75,
//                        b: 65
//                    }, {
//                        y: '2012',
//                        a: 100,
//                        b: 90
//                    }],
//                    xkey: 'y',
//                    ykeys: ['a', 'b'],
//                    labels: ['Series A', 'Series B'],
//                    hideHover: 'auto',
//                    resize: true
//                });
            },
            
            render: function(){
                if(typeof this[$app.action] != 'undefined'){
                    new this[$app.action];
                }
                
            }
        });
        return view = new view;
});
