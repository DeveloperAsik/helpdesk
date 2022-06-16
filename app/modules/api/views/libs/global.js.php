<script>
	var fnLoadingImg = function (gif){
		return '<img class="page-loading" src="'+static_url + 'images/' + gif +'"></img>';
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
        App.startPageLoading({animate: true});
        setTimeout(function () {
            $(".modal").hide();

            fnResetBtn();

            $("#add_edit")[0].reset();

            var dataTableID = $(".dataTables_wrapper").attr("id");
            if (dataTableID == "datatable_ajax_wrapper") {
                $("#datatable_ajax").DataTable().ajax.reload();
            }
            App.stopPageLoading();
        }, 1100);
    };

    var fnResetBtn = function () {
        $("#opt_delete").attr("disabled", true);
        $("#opt_delete").addClass("disabled");

        $("#opt_remove").attr("disabled", true);
        $("#opt_remove").addClass("disabled");

        $("#opt_add").attr("disabled", false);
        $("#opt_add").removeClass("disabled");

        $("#opt_edit").attr("disabled", true);
        $("#opt_edit").addClass("disabled");

    };
    
    var fnCloseBootbox = function () {
        $(".bootbox").hide();
        $(".modal-backdrop").hide();

        var dataTableID = $(".dataTables_wrapper").attr("id");
        if (dataTableID == "datatable_ajax_wrapper") {
            $("#datatable_ajax").DataTable().ajax.reload();
        }
    };
    
    var fnDatatableCheck = function () {
        $('.table').on('ifUnchecked', 'input[class="group-checkable"]', function () {
            App.startPageLoading({animate: true});
            var checked = $('.group-checkable').prop('checked');
            if (checked == 0) {
                $("#opt_delete").attr("disabled", true);
                $("#opt_delete").addClass("disabled");

                $("#opt_remove").attr("disabled", true);
                $("#opt_remove").addClass("disabled");

                $("#opt_add").attr("disabled", false);
                $("#opt_add").removeClass("disabled");

                $("#opt_edit").attr("disabled", true);
                $("#opt_edit").addClass("disabled");

                $(".checkbox_act").prop("checked", false);
            }
            App.stopPageLoading();
            return false;
        });

        $('.table').on('ifChecked', 'input[class="group-checkable"]', function () {
            App.startPageLoading({animate: true});
            var checked = $('.group-checkable').prop('checked');
            if (checked) {
                $("#opt_remove").attr("disabled", false);
                $("#opt_remove").removeClass("disabled");

                $("#opt_delete").attr("disabled", false);
                $("#opt_delete").removeClass("disabled");

                $("#opt_add").attr("disabled", true);
                $("#opt_add").addClass("disabled");

                $("#opt_edit").attr("disabled", false);
                $("#opt_edit").removeClass("disabled");

                $(".checkbox_act").prop("checked", true);
            }
            App.stopPageLoading();
            return false;
        });

        $('.table').on('ifUnchecked', 'input[class="select_tr"]', function (event) {
            App.startPageLoading({animate: true});
            var id = $('.select_tr').attr('data-id');
            var number = $('.select_tr').filter(':checked').length;
			console.log(number);
            if (number == 1)
            {
                $("#opt_delete").attr("disabled", false);
                $("#opt_delete").removeClass("disabled");

                $("#opt_remove").attr("disabled", false);
                $("#opt_remove").removeClass("disabled");

                $("#opt_add").attr("disabled", true);
                $("#opt_add").addClass("disabled");

                $("#opt_edit").attr("disabled", false);
                $("#opt_edit").removeClass("disabled");
            }else if(number == 0){
				$("#opt_delete").attr("disabled", true);
                $("#opt_delete").addClass("disabled");

                $("#opt_remove").attr("disabled", true);
                $("#opt_remove").addClass("disabled");

                $("#opt_add").attr("disabled", false);
                $("#opt_add").removeClass("disabled");

                $("#opt_edit").attr("disabled", true);
                $("#opt_edit").addClass("disabled");
			}
            App.stopPageLoading();
            return false;
        });

        $('.table').on('ifChecked', 'input[class="select_tr"]', function (event) {
            App.startPageLoading({animate: true});
            var id = $('.select_tr').attr('data-id');
            var number = $('.select_tr').filter(':checked').length;
            if (number == 1)
            {
                $("#opt_delete").attr("disabled", false);
                $("#opt_delete").removeClass("disabled");

                $("#opt_remove").attr("disabled", false);
                $("#opt_remove").removeClass("disabled");

                $("#opt_add").attr("disabled", true);
                $("#opt_add").addClass("disabled");

                $("#opt_edit").attr("disabled", false);
                $("#opt_edit").removeClass("disabled");
            }else if(number > 1){
				$("#opt_delete").attr("disabled", false);
                $("#opt_delete").removeClass("disabled");

                $("#opt_remove").attr("disabled", false);
                $("#opt_remove").removeClass("disabled");

                $("#opt_add").attr("disabled", true);
                $("#opt_add").addClass("disabled");

                $("#opt_edit").attr("disabled", true);
                $("#opt_edit").addClass("disabled");
			}
            App.stopPageLoading();
            return false;
        });
    };
    var GlobalAjax = function () {
        return {
            //main function to initiate the module
            init: function () {

                fnToStr('Global js ready!!!', 'success', 2000);

                fnDatatableCheck();

                $('.btn-close').on('click', function () {
                    fnCloseModal();
                });
				
				$('button[type="button"]').on('click', function(){
					$('#modal_add_edit').hide();
				});				

                $('.btn').on('click', function (e) {
                    e.preventDefault();
                    App.startPageLoading({animate: true});
                    var value = $(this).attr('data-value');
                    var status_ = $(this).hasClass('disabled');
                    switch (value) {
                        case 'add':
                            if (status_ == 0) {
                                $("#modal_add_edit").attr('display', true);
                                $('.modal').show();
                                $('#title_mdl').html('Add New ' + _class);
                            }
                            break;
                        case 'edit':
                            if (status_ == 0) {
                                $("#modal_add_edit").attr('display', true);
                                $('.modal').show();
                                $('#title_mdl').html('Edit ' + _class);
                            }
                            break;
                        case 'refresh':
                            $('.table').DataTable().ajax.reload();
                            fnCloseBootbox();
                            fnCloseModal();
                            break;
                    }
                    App.stopPageLoading();
                    return false;
                });
            }
        };

    }();

    jQuery(document).ready(function () {
        GlobalAjax.init();
    });
</script>
