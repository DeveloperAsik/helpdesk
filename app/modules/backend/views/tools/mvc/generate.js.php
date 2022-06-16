<script>
    var numbers = new Bloodhound({
        datumTokenizer: function (d) {
            return Bloodhound.tokenizers.whitespace(d.num);
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        local: [
            {num: 'base_url'},
            {num: 'base_backend_url'},
            {num: 'base_vendor_url'},
            {num: 'app_url'},
            {num: 'static_url'},
            {num: 'global_view_url'}
        ]
    });

    var fnGetTab = function (id) {
        var formdata = {
            id: Base64.encode(id)
        };
        $.ajax({
            url: base_backend_url + 'tools/mvc/get_data/',
            method: "POST", //First change type to method here
            data: formdata,
            success: function (response) {
                var row = JSON.parse(response);
                if (row) {
                    if (id == 1) {
                        $('#controller_layout').html(row.script);
                    } else if (id == 2) {
                        $('#model_layout').html(row.script);
                    } else if (id == 3) {
                        $('#view_html_layout').html(row.view_html);
                        $('#view_js_layout').html(row.view_js);
                    }
                }
            },
            error: function () {
                fnToStr('Error is occured, please contact administrator.', 'error');
            }
        });
    };

    var TableDatatablesAjax = function () {
        return {
            //main function to initiate the module
            init: function () {
                fnToStr('ajax js is ready', 'success');
                var tab = $('ul.nav li.active a').attr('data-id');
                fnGetTab(tab);

                $('div.reset_btn').on('click', function () {
                    App.startPageLoading();
                    var uri = base_backend_url + 'tools/mvc/reset/';
                    var id = $(this).data('id');
                    bootbox.confirm("Are you sure?", function (res) {
                        if (res == false) {
                            $('.modal-backdrop').hide();
                            $('.bootbox ').hide();
                            return false;
                        }
                        if (id) {
                            var formdata = {
                                id: id
                            };
                            $.ajax({
                                url: uri,
                                method: "POST", //First change type to method here
                                data: formdata,
                                success: function (response) {
                                    App.stopPageLoading();
                                    fnToStr('Successfully ', 'success');
                                    fnCloseModal();
                                    $('#res_query').html(response);
                                },
                                error: function (response) {
                                    App.stopPageLoading();
                                    fnToStr('Failed ', 'error');
                                    $('#res_query').html(response);
                                }

                            });
                            return false;
                        }
                    });
                });
                $('ul.nav.nav-tabs li a').on('click', function () {
                    var id = $(this).data('id');
                    var toggle = $(this).attr('data-toggle');
                    if (id && toggle == 'tab') {
                        fnGetTab(id);
                    }
                });
                $('input[name="exist_model"]').on('click', function () {
                    var val = $(this).val();
                    if (val == 1) {
                        $('#nmodel').fadeIn();
                    } else {
                        $('#nmodel').fadeOut();

                    }
                });

                $('#class_base_url').typeahead(null, {
                    displayKey: 'num',
                    hint: (App.isRTL() ? false : true),
                    source: numbers.ttAdapter()
                });

                $("#gen_mvc").submit(function () {
                    App.startPageLoading();
                    var is_active = $("[name='status']").bootstrapSwitch('state');
                    var uri = base_backend_url + 'tools/mvc/insert/';
                    var txt = 'add new class';
                    var model = $('input[name="model_name_ucfirst"]').val();
                    var rd = $('input[name="exist_model"]:checked').val();
                    var formdata = {
                        module: $('#module option:selected').text(),
                        class_name_ucfirst: $('input[name="class_name_ucfirst"]').val(),
                        class_base_url: $('input[name="class_base_url"]').val(),
                        class_path: $('input[name="class_path"]').val(),
                        model_name_ucfirst: model,
                        model_exist: rd,
                        active: is_active
                    };
                    $.ajax({
                        url: uri,
                        method: "POST", //First change type to method here
                        data: formdata,
                        success: function (response) {
                            toastr.success('Successfully ' + txt);
                            $('#result_generate').html(response);
                        },
                        error: function (response) {
                            toastr.error('Failed ' + txt);
                            $('#result_generate').html(response);
                        }

                    });
                    App.stopPageLoading();
                    return false;
                });
                $('select.first_ctg').on('change', function () {
                    App.startPageLoading();
                    var id = $(this).val();
                    var uri = base_url + 'backend/tools/mvc/get_category/';
                    var formdata = {
                        id: Base64.encode(id)
                    };
                    $.ajax({
                        url: uri,
                        type: "post",
                        data: formdata,
                        success: function (response) {
                            App.stopPageLoading();
                            if (response) {
                                $('select.second_ctg').html(response);
                            }
                            return false;
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            App.stopPageLoading();
                            console.log(textStatus, errorThrown);
                            return false;
                        }
                    });
                    return false;
                });
                $('#ticket_batch_request').on('click', function () {
                    App.startPageLoading();
                    var total = $('input[name="total"]').val();
                    var problem_impact = $("#problem_impact").val();
                    var user = $("#user").val();
                    var category = $('#first_ctg').val();
                    var job = $('#second_ctg').val();
                    var issue = $('textarea[name="issue"]').val();
                    var ticket_status = $("#ticket_status").val();
                    var uri = base_backend_url + 'tools/mvc/insert_ticket/';
                    var is_random_date = $('#random_create_date').val();
                    var formdata = {
                        total: total,
                        user: user,
                        is_random_date: is_random_date,
                        category: category,
                        ticket_status: ticket_status,
                        job: job,
                        problem_impact: problem_impact,
                        branch: $('#branch').val(),
                        issue: issue
                    };
                    $.ajax({
                        url: uri,
                        type: "post",
                        data: formdata,
                        success: function (response) {
                            App.stopPageLoading();
                            toastr.success('Successfully create new ticket data ');
                            $('#res_query_ticket').html(response);
                            return false;
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            App.stopPageLoading();
                            toastr.success('Failed add new ticket data ');
                            $('#res_query_ticket').html(textStatus);
                            return false;
                        }
                    });
                    return false;
                });
            }
        };

    }();

    jQuery(document).ready(function () {
        TableDatatablesAjax.init();
    });
</script>