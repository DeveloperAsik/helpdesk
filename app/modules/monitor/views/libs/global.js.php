<script>
    //stable ajax function start here
    var fnLoadingImg = function (gif) { return '<img class="page-loading" src="' + static_url + 'images/' + gif + '"></img>'; };
    var getDate = function (element) { var date; try { date = $.datepicker.parseDate(dateFormat, element.value); } catch (error) { date = null; } return date; };
    var fnToStr = function (value, key, to) { if (dev_status) { switch (key) { case 'success': toastr.success(value, key, {timeOut: to}); break; case 'warning': toastr.warning(value, key, {timeOut: to}); break; case 'info': toastr.info(value, key, {timeOut: to}); break; case 'error': toastr.error(value, key, {timeOut: to});  break; } } };
    var fnCloseModal = function(){ $(".modal").hide(); $('.modal').modal('hide'); };
    var fnCloseBootbox = function () { App.startPageLoading(); $(".bootbox").hide(); $(".modal-backdrop").hide(); App.stopPageLoading(); };
    var fnResetBtn = function () { App.startPageLoading(); $("#opt_delete").hide(); $("#opt_remove").hide(); $("#opt_add").show(); $("#opt_edit").hide(); App.stopPageLoading(); };
    var fnRefreshDataTable = function () { 
        var tbl = $(".table-scrollable table")[0].id;
        if (tbl){ $("#tbl").DataTable().ajax.reload(); }
    };
    var fnAjaxPost = function (url_post, formdata, options) {$.ajax({ url: url_post, method: "POST", data: formdata, success: function (response) { if (options) { fnToStr(options + ' is successfully!', 'success'); } else { fnToStr('successfully!', 'success'); } if ($(".table")[0]) { fnRefreshDataTable(); } }, error: function () { if (options) { fnToStr(options + ' is failed, please try again or call superuser to help!', 'error'); } else { fnToStr('failed, please try again or call superuser to help!', 'error'); } if ($(".table")[0]) { fnRefreshDataTable(); } } });};
    var fnActionId = function (url_post, id, options) { $.ajax({ url: url_post + id, method: "POST", success: function (response) { fnToStr(options + ' is successfully!', 'success'); if ($(".table")[0]){ fnRefreshDataTable(); } }, error: function () { fnToStr(options + ' is failed, please try again or call superuser to help!', 'error'); if ($(".table")[0]){ fnRefreshDataTable(); } } }); return false; };
    var fnResetCheckbox = function(){ $('.select_all').prop('checked', false); $('.select_tr').prop('checked', false); };
    //stable ajax function end here 

    

    var GlobalAjax = function () {
        return {
            //main function to initiate the module
            init: function () {
                fnToStr('Global js ready!!!', 'success', 1100);
            }
        };
    }();

    jQuery(document).ready(function () {
        GlobalAjax.init();
    });
</script>
