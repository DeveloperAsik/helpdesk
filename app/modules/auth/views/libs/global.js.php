<script>
    var fnLoadingImg = function (gif) {
        return '<img class="page-loading" src="' + static_url + 'images/' + gif + '"></img>';
    };

    var fnToStr = function (value, key, to) {
        if (dev_status) {
            switch (key) {
                case 'success':
                    toastr.success(value, key, {timeOut: to});
                    break;
                case 'warning':
                    toastr.warning(value, key, {timeOut: to});
                    break;
                case 'info':
                    toastr.info(value, key, {timeOut: to});
                    break;
                case 'error':
                    toastr.error(value, key, {timeOut: to});
                    break;
            }
        }
    };

    var fnCloseModal = function () {
        App.startPageLoading();
        $(".modal").hide();
        $('.modal').modal('hide');
        fnResetBtn();
        $("#add_edit")[0].reset();
        //fnRefreshDataTable();
        App.stopPageLoading();
    };
    var fnResetBtn = function () {
        App.startPageLoading();
        $("#opt_delete").hide();
        $("#opt_remove").hide();
        $("#opt_add").show();
        $("#opt_edit").hide();
        App.stopPageLoading();
    };

    var fnActionId = function (url_post, id, options) {
        var formdata = {
            id: id
        };
        $.ajax({
            url: url_post,
            method: "POST", //First change type to method here
            data: formdata,
            success: function (response) {
                fnToStr(options + ' is successfully!', 'success');
                fnRefreshDataTable();
            },
            error: function () {
                fnToStr(options + ' is failed, please try again or call superuser to help!', 'error');
                fnRefreshDataTable();
            }
        });
        return false;
    };

    var fnGetRunningText = function () {
        var url_post = base_url + 'auth/user/get_running_text';
        $.ajax({
            url: url_post,
            method: "POST",
            success: function (response) {
                $('.running_text').html(response);
            }
        });
        return false;
    };

    var GlobalAjax = function () {
        return {
            //main function to initiate the module
            init: function () {
                fnGetRunningText();
                $('.running_text').on('click', 'a.btn', function (e) {
                    e.preventDefault();
                    console.log('iyey');
                    //return false;
                    var id = $(this).attr('data-id');
                    var url_post = base_url + 'auth/user/get_detail_running_text';
                    var formdata = {
                        id: id
                    };
                    $.ajax({
                        url: url_post,
                        method: "POST",
                        data: formdata,
                        success: function (response) {
                            var row = JSON.parse(response);
                            $('.header_rt').html(row.name);
                            $('.lead').html(row.content_summary);
                            $('.content_rt').html(row.content_full);
                            $('#modal_hot_news').modal('show');
                            return false;
                        }
                    });
                });
                $('button[type="button"]').on('click', function () {
                    var dismiss = $(this).attr('data-dismiss');
                    var id = $(this).attr('data-id');
                    App.startPageLoading();
                    console.log(dismiss);//return false;

                    switch (dismiss) {
                        case 'modal':
                            if (id == 'modal_hot_news') {
                                $('#modal_hot_news').modal('hide');
                            }
                            break;
                    }
                    App.stopPageLoading();
                });
            }
        };
    }();

    jQuery(document).ready(function () {
        GlobalAjax.init();
    });
</script>
