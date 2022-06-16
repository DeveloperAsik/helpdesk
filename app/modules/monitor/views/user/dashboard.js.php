<script>
    var fnAmChart = function (data) {
        var chart = AmCharts.makeChart("total_ticket_per_month", {
            "type": "serial",
            "theme": "light",
            "pathToImages": static_url + "metronics/theme/amcharts/amcharts/images/",
            "autoMargins": false,
            "marginLeft": 30,
            "marginRight": 8,
            "marginTop": 10,
            "marginBottom": 26,
            "fontFamily": 'Open Sans',
            "color": '#888',
            "dataProvider": data,
            "valueAxes": [{
                    "axisAlpha": 0,
                    "position": "left"
                }],
            "startDuration": 1,
            "graphs": [{
                    "alphaField": 0.2,
                    "balloonText": "<span style='font-size:13px;'>[[title]] in  [[category]] : <b>[[value]]</b> [[additional]]</span>",
                    "dashLengthField": 5,
                    "fillAlphas": 1,
                    "title": "Total",
                    "type": "column",
                    "valueField": "total"
                }, {
                    "balloonText": "<span style='font-size:13px;'>[[title]] in [[category]] : <b>[[value]]</b> [[additional]]</span>",
                    "bullet": "round",
                    "dashLengthField": 5,
                    "lineThickness": 3,
                    "bulletSize": 7,
                    "bulletBorderAlpha": 1,
                    "bulletColor": "#FFFFFF",
                    "useLineColorForBulletBorder": true,
                    "bulletBorderThickness": 3,
                    "fillAlphas": 0,
                    "lineAlpha": 1,
                    "title": "Total",
                    "valueField": "total"
                }],
            "categoryField": "month",
            "categoryAxis": {
                "gridPosition": "start",
                "axisAlpha": 0,
                "tickLength": 0
            }
        });
        $('#total_ticket_per_month').closest('.portlet').find('.fullscreen').click(function () {
            chart.invalidateSize();
        });
    };

    var fnPieChart = function () {
        var chart = AmCharts.makeChart("total_ticket_per_month_by_status", {
            "type": "pie",
            "theme": "light",
            "fontFamily": 'Open Sans',
            "color": '#888',
            "dataProvider": [{
                    "country": "Lithuania",
                    "litres": 501.9
                }, {
                    "country": "Czech Republic",
                    "litres": 301.9
                }, {
                    "country": "Ireland",
                    "litres": 201.1
                }, {
                    "country": "Germany",
                    "litres": 165.8
                }, {
                    "country": "Australia",
                    "litres": 139.9
                }, {
                    "country": "Austria",
                    "litres": 128.3
                }, {
                    "country": "UK",
                    "litres": 99
                }, {
                    "country": "Belgium",
                    "litres": 60
                }, {
                    "country": "The Netherlands",
                    "litres": 50
                }],
            "valueField": "litres",
            "titleField": "country",
            "exportConfig": {
                menuItems: [{
                        icon: static_url + "metronics/theme/amcharts/amcharts/images/export.png",
                        format: 'png'
                    }]
            }
        });

        $('#total_ticket_per_month_by_status').closest('.portlet').find('.fullscreen').click(function () {
            chart.invalidateSize();
        });
    };

    var fnTotalTicketPerMonth = function () {
        var uri = base_url + "monitor/user/get_total_ticket_per_month";
        $.ajax({
            url: uri,
            type: "post",
            success: function (response) {
                var row = JSON.parse(response);
                fnAmChart(row);
                return false;
            },
            error: function (jqXHR, textStatus, errorThrown) {
                toastr.success('Failed');
                return false;
            }
        });
    };
    
    var fnTotalTicketPerMonthByStatus = function(){
        var uri = base_url + "monitor/user/get_total_ticket_per_month_by_status";
        $.ajax({
            url: uri,
            type: "post",
            success: function (response) {
                console.log(response);
                var row = JSON.parse(response);
                fnPieChart(row);
                return false;
            },
            error: function (jqXHR, textStatus, errorThrown) {
                toastr.success('Failed');
                return false;
            }
        });
    };

    var Ajax = function () {
        return {
            //main function to initiate the module
            init: function () {
                fnToStr('Dashboard js ready!!!', 'success');
                fnTotalTicketPerMonth();
                fnTotalTicketPerMonthByStatus();
            }
        };

    }();

    jQuery(document).ready(function () {
        Ajax.init();
    });

</script>
