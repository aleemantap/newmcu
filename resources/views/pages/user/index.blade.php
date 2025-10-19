@extends('layouts.app')
@section('css')
    @include('layouts.datatableCss')    
@endsection
@section('title', $title_page_left)
@section('ribbon')
<ul class="breadcrumbs pull-left">
	<li><a href="/home">Home</a></li>
    <li><span>User</span></li>   
</ul>
@endsection


@section('content')
        <div class="row">
                    <!-- data table start -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title"></h4>
                                <div class="data-tables">
                                    <table  id="user-table" class="table table-striped table-borderless"  class="text-center">
                                        <thead class="bg-light text-capitalize">
                                             <tr>
												<th style="width:20px;">No</th>
												<th>@lang('user.name')</th>
												<th>@lang('user.email')</th>
												<th>@lang('user.group')</th>
												<th>@lang('customer.customer')</th>
												<th>Partner/Vendor</th>
												<th>@lang('user.active')</th>
												<th style="width: 150px">@lang('general.action')</th>
											</tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
    </div>

@endsection

@section('modal')
    @include('pages.user.new-user')
    @include('pages.user.import-user')
@endsection

@section('script')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('assets/js/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>

<script>
$(document).ready(function () {

    $('select').select2({
        width: '100%',
        containerCssClass: 'select-xs'
    });
	
	$('#u-cs').css("display","none");
	$('#u-vdr').css("display","none");
	
	//$('#user-group').select("display","none");
	
	$( "#user-group" ).on( "change", function() {
	    if($(this).val() == 2 ) //vendor
		{
			$('#u-vdr').css("display","");
			$('#u-cs').css("display","none");
		}
		else if($(this).val() == 3 ) // cs
		{
			$('#u-vdr').css("display","none");
			$('#u-cs').css("display","");
		}
		else if($(this).val() == 1) //admin
		{
			$('#u-cs').css("display","none");
			$('#u-vdr').css("display","none");
		}
		else
		{
			$('#u-cs').css("display","none");
			$('#u-vdr').css("display","none");
		}
	});
	
	

    // You can use 'alert' for alert message
    // or throw to 'throw' javascript error
    // or none to 'ignore' and hide error
    // or you own function
    // please read https://datatables.net/reference/event/error
    // for more information
    $.fn.dataTable.ext.errMode = 'none';

    /**
     * Datatable initial
     */
    var userDataTable = $('#user-table').DataTable({
        //dom: '<"dt-toolbar"<"col-sm-6 col-xs-12 hidden-xs"f><"col-sm-6 col-xs-12 hidden-xs text-right"<"toolbar">>>rt<"dt-toolbar-footer"<"col-sm-6 col-xs-12"i><"col-sm-6 col-xs-12 hidden-xs"p>><"clear">',
         dom: '<"dt-toolbar"<"col-md-3 col-sm-12 hidden-sm float-left"l><"col-md-9 col-sm-12 hidden-sm float-right"<"toolbar">>>rt<"dt-toolbar-footer"<"col-md-5 col-sm-12"i><"col-md-6 col-md-12 hidden-sm"p>><"clear">',
       
		processing: false,
        serverSide: true,
        scrollX: true,
        pageLength: 15,
        lengthMenu: [[15, 25, 50, 100], [15, 25, 50, 100]],
        pagingType: 'full_numbers',
        ajax: baseUrl+"/user-datatables",
        language: {
            //processing: '<div style="display: none"></div>',
            // info: 'Menampilkan _START_ - _END_ dari _TOTAL_ ',
            search: '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>',
            // zeroRecords: 'Tidak ada data yang cocok dengan kriteria pencarian',
            // emptyTable: 'Data tidak tersedia',
            paginate: {
                first: '&laquo;',
                last: '&raquo;',
                next: '&rsaquo;',
                previous: '&lsaquo;'
            },
            //lengthMenu: "Baris per halaman: _MENU_ "
        },
        //rowId: 'TRANSPORT_ID',
        columns: [
            {data: "DT_RowIndex", sortable: false, searchable: false},
            {data: "name", name: "name"},
            {data: "email", name: "email"},
            {data: "user_group.name", name: "userGroup.name"},
            {data: "customer.name", name: "customer.name"},
            {data: "vendor.name", name: "vendor.name"},
            {data: "active", name: "active"},
            {data: "action", sortable: false, searchable: false, class: "action"}
        ],'select': {
			style:    'single'
		},
    });

    $("div.toolbar").html(`
        <button id='btn-add-user' class='btn btn-primary'><i class='fa fa-plus-circle'></i> @lang('user.new_user')</button>&nbsp;
    `);

    // Add User
    $('body').on('click', '#btn-add-user', function(){
        $('#modal-user').modal('show');
        $('#modal-user .modal-title').html('@lang("user.new_user")');
        $('#modal-user input[type=text],#modal-user input[type=hidden],#modal-user input[type=password],#modal-user input[type=email],#modal-user input[type=number]').val('').removeAttr('readonly');
    });

    // Open Modal Import User
    $('body').on('click', '#btn-import-user', function(){
        $('#modal-import-user').modal('show');
        $('#modal-import-user .modal-title').html('Import User');
        $('#modal-import-user input[type=text],#modal-user input[type=hidden],#modal-user input[type=password],#modal-user input[type=email],#modal-user input[type=number]').val('');
    });

    // Add New Or Update Program
    $('#btn-submit').click(function(){

        // Update when user id has value
        var url = baseUrl + '/user/update';
        var action = "update";
        if(!$('#user-id').val()) {
            url = baseUrl + '/user/save';
            action = "save";
        }

        // Has error
        // var hasError = false;
        // Check requirement input
       
		if(!$('#email').val()) {
            Lobibox.notify('warning', {
                    sound: true,
                    icon: true,
                    msg : 'Email can\'t be empty',
            });
            $('#email').focus();
            return;

        }
		
		
		 if(!$('#name').val()) {
            Lobibox.notify('warning', {
                    sound: true,
                    icon: true,
                    msg : 'Name can\'t be empty',
            });
            $('#name').focus();
            return;

        }
		
		
       
        if(!$('#password').val() && action === "save") {
           
			Lobibox.notify('warning', {
                    sound: true,
                    icon: true,
                    msg : 'Password can\'t be empty',
            });
            $('#password').focus();
            return;
        }
        if(!$('#confirm-password').val() && action === 'save') {
			Lobibox.notify('warning', {
                    sound: true,
                    icon: true,
                    msg : 'Please confirm password',
            });
           
            $('#confirm-password').focus();
            return;
        }
        if($('#password').val() !== $('#confirm-password').val()) {
          
			Lobibox.notify('warning', {
                    sound: true,
                    icon: true,
                    msg : 'Password doest\'t match',
            });
            $('#confirm-password').focus();
            return;
        }
        if(!$('#user-group').val()) {
			Lobibox.notify('warning', {
                    sound: true,
                    icon: true,
                    msg : 'User group can\'t be empty',
            });
            
            $('#user-group').focus();
            return;
        }

        // Show loder
        $('.page-loader').removeClass('hidden');

        // Send data
        $.ajax({
            url: url,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'id': $('#user-id').val(),
                'email': $('#email').val(),
                'name': $('#name').val(),
                'password': $('#password').val(),
                'group': $('#user-group').val(),
                'customer': $('#customer').val(),
                'vendor': $('#vendor').val(),
                'active': $('input[name="active[]"]:checked').val()
            },
            success: function(resp) {
                if(resp.responseCode === 200) {
                    // Reload datatable
                    userDataTable.ajax.reload();
                    // Reset Form
                    $('#modal-user input[type=text],#modal-user input[type=password],#modal-user input[type=email],#modal-user input[type=number]').val('');
                    $('#modal-user select').val('').trigger('change');
                    // Close modal
                    $('#modal-user').modal('hide');
                    // Send success message
                   
					Lobibox.notify('success', {
							sound: true,
							icon: true,
							msg : resp.responseMessage,
					});
            
                } else {
                   
					Lobibox.notify('error', {
							sound: true,
							icon: true,
							msg :  resp.responseMessage,
					});
            
                }
                // Hide loder
                $('.page-loader').addClass('hidden');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                Lobibox.notify('error', {
                            sound: true,
                            icon: true,
                            msg : xhr.statusText,
                });
                // Hide loder
                $('.page-loader').addClass('hidden');
            }
        });

    });

    // Edit user
    $('#user-table').on('click', '.btn-edit', function() {
        $('#modal-user').modal('show');
        $('#modal-user .modal-title').html('@lang("user.edit_user")');
        $('#email').attr('readonly','readonly');

        // Hide loder
        $('.page-loader').removeClass('hidden');

        // Get data
        // Send data
        $.ajax({
            url: baseUrl + '/user/' + $(this).data('id'),
            type: 'GET',
            success: function(resp) {
                $('#user-id').val(resp.id);
                $('#name').val(resp.name);
                $('#email').val(resp.email);
                $('#user-group').val(resp.user_group_id).trigger('change');
                $('#customer').val(resp.customer_id).trigger('change');
                $('#vendor').val(resp.vendor_id).trigger('change');

                if(resp.active === 'Y') {
                    $('#user-active-yes').prop('checked', true);
                    $('#user-active-no').prop('checked', false);
                } else {
                    $('#user-active-yes').prop('checked', false);
                    $('#user-active-no').prop('checked', true);
                }

                // Hide loder
                $('.page-loader').addClass('hidden');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $.smallBox({
                    title : "Error",
                    content : xhr.statusText,
                    color : "#dc3912",
                    timeout: 3000
                    //icon : "fa fa-bell swing animated"
                });
                // Hide loder
                $('.page-loader').addClass('hidden');
            }
        });
    });


    // Disabled user
    $('#user-table').on('click', '.btn-active', function() {

        if(!confirm('Area you sure want to activate this user?')) {
            return;
        }

        // Get data
        // Send data
        $.ajax({
            url: baseUrl + '/user/activate/'+$(this).data('id'),
            type: 'GET',
            success: function(resp) {
                if(resp.responseCode === 200) {
                    // Reload datatable
                    userDataTable.ajax.reload();
                   
					Lobibox.notify('success', {
							sound: true,
							icon: true,
							msg :  resp.responseMessage,
					});
                } else {
                  
					Lobibox.notify('error', {
							sound: true,
							icon: true,
							msg :   resp.responseMessage,
					});
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
               Lobibox.notify('success', {
							sound: true,
							icon: true,
							msg : xhr.statusText,
					});
            }
        });

    });

    // Activate user
    $('#user-table').on('click', '.btn-inactive', function() {

        if(!confirm('Area you sure want to inactivate this user?')) {
            return;
        }

        // Get data
        // Send data
        $.ajax({
            url: baseUrl + '/user/inactivate/'+$(this).data('id'),
            type: 'GET',
            success: function(resp) {
                if(resp.responseCode === 200) {
                    // Reload datatable
                    userDataTable.ajax.reload();
                   
					Lobibox.notify('success', {
							sound: true,
							icon: true,
							msg :   resp.responseMessage,
					});
                } else {
                   
					Lobibox.notify('error', {
							sound: true,
							icon: true,
							msg :   resp.responseMessage,
					});
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
               
				Lobibox.notify('error', {
							sound: true,
							icon: true,
							msg :  xhr.statusText,
					});
            }
        });
    });

    // Import User
    $('#btn-import').click(function(){

        if(!$('#file').val()) {
           
			
			Lobibox.notify('warning', {
							sound: true,
							icon: true,
							msg :  'Please select file to upload',
					});

            return;
        }

        // Create form data
        var form = new FormData();
        form.append('file', $('#file')[0].files[0]);

        // Show loader
        $('.page-loader').removeClass('hidden');
        $.ajax({
            url: baseUrl + '/user-import',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData: false, // prevent jQuery from automatically transforming the data into a query string
            contentType: false, // is imperative, since otherwise jQuery will set it incorrectly.
            data: form,
            success: function(resp) {
                if(resp.responseCode === 200) {
                    checkProcess(resp.processId);
                } else {
                   
					Lobibox.notify('error', {
							sound: true,
							icon: true,
							msg :  resp.responseMessage,
					});
                }
                $('.page-loader').addClass('hidden');
            },
            error: function(xhr, ajaxOptions, thrownError) {
               
				Lobibox.notify('error', {
							sound: true,
							icon: true,
							msg :  xhr.statusText,
					});
                $('.page-loader').addClass('hidden');
            }
        });
    });

    // Check process
    function checkProcess(id)
    {
        // Hide all
        $('.input-form').addClass('hidden');
        $('.input-progress').removeClass('hidden');
        $('#btn-import').attr('disabled','disabled');

        // Check browser support Server-Send Event
        if (typeof (EventSource) !== "undefined") {
            // Yes! Server-sent events support!
            var process = 0;
            var url = "{{ url('update-process') }}/"+id;
            var source = new EventSource(url);
            source.onmessage = function (e) {

                userDataTable.ajax.reload();

                if (process !== parseInt(e.data)) {
                    $('#upload-progress').attr('aria-valuenow', e.data).attr('style', 'width:'+ e.data+'%');
                    $('.progress-text').html(e.data+'% Completed ... Please wait ...');
                }

                if(parseInt(process) === 0) {
                    $('.progress-text').html('Calculate rows... Please wait ...');
                }

                if(parseInt(process) === 100) {

                    $('.input-form').removeClass('hidden');
                    $('.input-progress').addClass('hidden');
                    $('#btn-import').removeAttr('disabled');
                    $('#upload-progress').attr('aria-valuenow', 0).attr('style', 'width: 0%');

                   
					
					Lobibox.notify('success', {
							sound: true,
							icon: true,
							msg :  'Upload file has been finish',
					});

                    source.close();
                }

                process = parseInt(e.data);
            };
        } else {
            // Sorry! No server-sent events support..
            //toastr.error('No server-sent events support', 'Error');
            console.log('error', 'No server-sent events support');

            $('.input-form').removeClass('hidden');
            $('.input-progress').addClass('hidden');
            $('#btn-import').removeAttr('disabled','disabled');
        }
    }


    // Check if current process is running
    @if($process)
        checkProcess({{ $process->id }});
    @endif

});

</script>
@endsection
