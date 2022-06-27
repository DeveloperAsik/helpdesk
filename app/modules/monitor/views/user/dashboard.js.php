<script>
    var fnAmChart = function (data, el, key) {
        console.log(el);
        var chart = AmCharts.makeChart(el, {
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
        $('#' + el).closest('.portlet').find('.fullscreen').click(function () {
            chart.invalidateSize();
        });
    };

    var fnPieChart = function (data, el, key) {
        var chart = AmCharts.makeChart(el, {
            "type": "pie",
            "theme": "light",
            "fontFamily": 'Open Sans',
            "color": '#888',
            "dataProvider": data,
            "valueField": key.l,
            "titleField": key.b,
            "exportConfig": {
                menuItems: [{
                    icon: static_url + "metronics/theme/amcharts/amcharts/images/export.png",
                    format: 'png'
                }]
            }
        });
        $('#'+el).closest('.portlet').find('.fullscreen').click(function () {
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
                fnAmChart(row,'total_ticket_per_month','');
                return false;
            },
            error: function (jqXHR, textStatus, errorThrown) {
                toastr.success('Failed');
                return false;
            }
        });
    };

    var fnTotalTicketPerMonthByStatus = function () {
        var uri = base_url + "monitor/user/get_total_ticket_per_month_by_status";
        $.ajax({
            url: uri,
            type: "post",
            success: function (response) {
                var row = JSON.parse(response);
                //fnPieChart(row.data, 'total_ticket_per_month_by_status', row.key);
                fnAmChart(row,'total_ticket_per_month_by_status','');
                return false;
            },
            error: function (jqXHR, textStatus, errorThrown) {
                toastr.success('Failed');
                return false;
            }
        });
    };

    var fnTotalTicketPerMonthByStatusProgress = function () {
        var uri = base_url + "monitor/user/get_total_ticket_per_month_by_status_progress";
        $.ajax({
            url: uri,
            type: "post",
            success: function (response) {
                var row = JSON.parse(response);
                //fnPieChart(row.data, 'total_ticket_per_month_progress', row.key);
                fnAmChart(row,'total_ticket_per_month_progress','');
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
                fnTotalTicketPerMonthByStatusProgress();
            }
        };

    }();

    jQuery(document).ready(function () {
        Ajax.init();
    });

</script>
