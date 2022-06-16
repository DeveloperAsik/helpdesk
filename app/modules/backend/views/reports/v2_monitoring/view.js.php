<script>
    var table = $('#ticket_dttable').DataTable({
        "lengthMenu": [[10, 25, 50], [10, 25, 50]],
        "sPaginationType": "bootstrap",
        "paging": true,
        "pagingType": "full_numbers",
        "ordering": false,
        "processing": true,
        "language": {
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
        },
        "serverSide": true,
        "ajax": {
            url: base_backend_url + 'tickets/master/get_list/',
            type: 'POST'
        },
        "columns": [
            {"data": "num"},
            {"data": "code"},
            {"data": "content"},
            {"data": "category_name"},
            {"data": "priority_name"},
            {"data": "job_category_name"},
            {"data": "branch_name"},
            {"data": "create"},
            {"data": "status"},
            {"data": "close_message"}
        ],
        "drawCallback": function (master) {
            $('.make-switch').bootstrapSwitch();
        }
    });

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

    var fnAmChartKanim = function (data) {
        var chart = AmCharts.makeChart("total_ticket_per_kanim", {
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
                    "balloonText": "<span style='font-size:13px;'>[[title]] di  [[name]] : <b>[[value]]</b> [[additional]]</span>",
                    "dashLengthField": 5,
                    "fillAlphas": 1,
                    "title": "Total",
                    "type": "column",
                    "valueField": "total"
                }, {
                    "balloonText": "<span style='font-size:13px;'>[[title]] di [[name]] : <b>[[value]]</b> [[additional]]</span>",
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
            "categoryField": "code",
            "categoryAxis": {
                "gridPosition": "start",
                "axisAlpha": 0,
                "tickLength": 0
            }
        });
        $('#total_ticket_per_kanim').closest('.portlet').find('.fullscreen').click(function () {
            chart.invalidateSize();
        });
    };

    var fnPieChart = function (data) {
        var chart = AmCharts.makeChart("total_ticket_per_month_by_status", {
            "type": "pie",
            "theme": "light",
            "fontFamily": 'Open Sans',
            "color": '#888',
            "dataProvider": data,
            "valueField": "total",
            "titleField": "status",
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

    var fnPieChart2 = function (data) {
        var chart = AmCharts.makeChart("total_ticket_per_month_by_user", {
            "type": "pie",
            "theme": "light",
            "fontFamily": 'Open Sans',
            "color": '#888',
            "dataProvider": data,
            "valueField": "total",
            "titleField": "status",
            "exportConfig": {
                menuItems: [{
                        icon: static_url + "metronics/theme/amcharts/amcharts/images/export.png",
                        format: 'png'
                    }]
            }
        });

        $('#total_ticket_per_month_by_user').closest('.portlet').find('.fullscreen').click(function () {
            chart.invalidateSize();
        });
    };

    var fnTotalTicketPerMonth = function () {
        var uri = base_backend_url + "reports/v2_monitoring/get_total_ticket_per_month";
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

    var fnTotalTicketPerKanim = function () {
        var uri = base_backend_url + "reports/v2_monitoring/get_total_ticket_per_kanim";
        $.ajax({
            url: uri,
            type: "post",
            success: function (response) {
                var row = JSON.parse(response);
                fnAmChartKanim(row);
                return false;
            },
            error: function (jqXHR, textStatus, errorThrown) {
                toastr.success('Failed');
                return false;
            }
        });
    };

    var fnTotalTicketPerMonthByStatus = function () {
        var uri = base_backend_url + "reports/v2_monitoring/get_total_ticket_per_month_by_status";
        $.ajax({
            url: uri,
            type: "post",
            success: function (response) {
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

    var fnTotalTicketPerMonthByUser = function () {
        var uri = base_backend_url + "reports/v2_monitoring/get_total_ticket_progress_per_month";
        $.ajax({
            url: uri,
            type: "post",
            success: function (response) {
                var row = JSON.parse(response);
                fnPieChart2(row);
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
                fnTotalTicketPerKanim();
                fnTotalTicketPerMonthByStatus();
                fnTotalTicketPerMonthByUser();
            }
        };

    }();

    jQuery(document).ready(function () {
        Ajax.init();
    });

</script>
