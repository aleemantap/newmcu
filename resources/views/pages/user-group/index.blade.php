@extends('layouts.app')
@section('css')
    @include('layouts.datatableCss')    
@endsection

@section('ribbon')
<ul class="breadcrumbs  pull-left">
    <li><a href="/home">Home</a></li>
    <li><span>Users Group</span></li>
</ul>
@endsection

@section('title', $title_page_left)
@section('content')
        <div class="row">
                    <!-- data table start -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title"></h4>
                                <div class="data-tables">
                                    <table id="user-group-table" class="table table-striped table-borderless" width="100%">
                                        <thead>
                                            <tr>
                                                <th style="width:20px;">No</th>
                                                <th>Id</th>
                                                <th>@lang('user-group.group_name')</th>
                                                <th>@lang('user-group.description')</th>
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
    @include('pages.user-group.new-user-group')
    @include('pages.user-group.privileges')
@endsection

@section('script')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('assets/js/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>


{{-- <script src="{{ asset('js/libs/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/plugin/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('js/plugin/jquery-validate/jquery.validate.min.js') }}"></script> --}}
<!--<script src="{{ asset('js/user.js') }}"></script>-->
<script>
    $(document).ready(function () {

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
    var userDataTable = $('#user-group-table').DataTable({
        dom: '<"dt-toolbar"<"col-md-3 col-sm-12 hidden-sm float-left"l><"col-md-9 col-sm-12 hidden-sm float-right"<"toolbar">>>rt<"dt-toolbar-footer"<"col-md-5 col-sm-12"i><"col-md-6 col-md-12 hidden-sm"p>><"clear">',
        processing: true,
        serverSide: true,
        scrollX: true,
        pageLength: 15,
        lengthMenu: [[15, 25, 50, 100], [15, 25, 50, 100]],
        pagingType: 'full_numbers',
        ajax: baseUrl+"/user-group-datatables",
        language: {
            processing: `<div class="table-loader">
                <div class="sk-circle">
                    <div class="sk-circle1 sk-child"></div>
                    <div class="sk-circle2 sk-child"></div>
                    <div class="sk-circle3 sk-child"></div>
                    <div class="sk-circle4 sk-child"></div>
                    <div class="sk-circle5 sk-child"></div>
                    <div class="sk-circle6 sk-child"></div>
                    <div class="sk-circle7 sk-child"></div>
                    <div class="sk-circle8 sk-child"></div>
                    <div class="sk-circle9 sk-child"></div>
                    <div class="sk-circle10 sk-child"></div>
                    <div class="sk-circle11 sk-child"></div>
                    <div class="sk-circle12 sk-child"></div>
                </div>
            </div>`,
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
            {data: "id", name: "id"},
            {data: "name", name: "name"},
            {data: "description", name: "description"},
            {data: "action", sortable: false, searchable: false, class: "action"}
        ]
    });

    $("div.toolbar").html("<button id='btn-add-user' class='btn btn-primary pull-right'><i class='fa fa-plus-circle'></i> @lang('user-group.new_user_group')</button>");

    // Add User Group
    $('body').on('click', '#btn-add-user', function(){
        $('#modal-user').modal('show');
        $('#modal-user .modal-title').html('@lang("user-group.new_user_group")');
        $('#modal-user input').val('');
    });

    // Add New Or Update Program
    $('#btn-submit').click(function(){
        // Has error
        // var hasError = false;
        // Check requirement input
        if(!$('#group-name').val()) {
            $('#group-name').focus();
           
            Lobibox.notify('warning', {
                    sound: true,
                    icon: true,
                    msg : 'Group name can\'t be empty',
            });
            return;
        }

        // Show loder
        $('.page-loader').removeClass('hidden');

        // Set URL
        var url = '/user-group/save';
        if($('#group-id').val()) {
            url = '/user-group/update';
        }

        // Send data
        $.ajax({
            url: baseUrl + url,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'groupId': $('#group-id').val(),
                'groupName': $('#group-name').val(),
                'groupDescription': $('#group-description').val()
            },
            success: function(resp) {
                if(resp.responseCode === 200) {
                    // Reload datatable
                    userDataTable.ajax.reload();
                    // Reset Form
                    $('#modal-user input').val('');
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
                            msg : resp.responseMessage,
                    });
                }
                // Hide loder
                $('.page-loader').addClass('hidden');
            },
            error: function(xhr, ajaxOptions, thrownError) {
               
                Lobibox.notify('error', {
                            sound: true,
                            icon: true,
                            msg :xhr.statusText,
                });
                // Hide loder
                $('.page-loader').addClass('hidden');
            }
        });

    });

    // Edit user
    $('#user-group-table').on('click', '.btn-edit', function() {
        $('#modal-user').modal('show');
        $('#modal-user .modal-title').html('@lang("user-group.edit_user_group")');

        // Hide loder
        $('.page-loader').removeClass('hidden');

        // Get data
        // Send data
        $.ajax({
            url: baseUrl + '/user-group/detail/' + $(this).data('id'),
            type: 'GET',
            success: function(resp) {
                $('#group-id').val(resp.id);
                $('#group-name').val(resp.name);
                $('#group-description').val(resp.description);

                // Hide loder
                $('.page-loader').addClass('hidden');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                
                Lobibox.notify('error', {
                            sound: true,
                            icon: true,
                            msg :xhr.statusText,
                });
                // Hide loder
                $('.page-loader').addClass('hidden');
            }
        });
    });

    // Set privileges user group
    $('#user-group-table').on('click', '.btn-privileges', function() {
        $('#modal-privileges').modal('show');

        // Hide loder
        $('.page-loader').removeClass('hidden');

        $('#priv-group-id').val($(this).data('id'));
        // Get data
        $.ajax({
            url: baseUrl + '/user-group/privileges/' + $(this).data('id'),
            type: 'GET',
            success: function(resp) {

                // Reset form
                $('input[type=checkbox]').prop('checked', false);

                // Check privileges menus
                $.each(resp.result, function(i, o) {
                    $('#checkbox-'+o.id).prop('checked', true);
                });

                // Hide loder
                $('.page-loader').addClass('hidden');
            },
            error: function(xhr, ajaxOptions, thrownError) {
             
                 Lobibox.notify('error', {
                            sound: true,
                            icon: true,
                            msg :xhr.statusText,
                });
                // Hide loder
                $('.page-loader').addClass('hidden');
            }
        });
    });

    // Set privileges
    $('#btn-submit-privileges').click(function(){
        // Show loder
        $('.page-loader').removeClass('hidden');

        var actions = $('input[name="action[]"]:checked').map(function(){
            return this.value;
        }).get();

        // Send data
        $.ajax({
            url: baseUrl + '/user-group/privileges',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'userGroupId': $('#priv-group-id').val(),
                'menuActions': actions
            },
            success: function(resp) {
                if(resp.responseCode === 200) {
                    // Close modal
                    $('#modal-privileges').modal('hide');
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
                            msg : resp.responseMessage,
                    });
                }
                // Hide loder
                $('.page-loader').addClass('hidden');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                Lobibox.notify('error', {
                            sound: true,
                            icon: true,
                            msg : resp.responseMessage,
                    });
                // Hide loder
                $('.page-loader').addClass('hidden');
            }
        });
    });

    // Disabled user group
    $('#user-group-table').on('click', '.btn-disable', function() {

        if(!confirm('Area you sure want to disable this user group')) {
            return;
        }

        // Get data
        // Send data
        $.ajax({
            url: baseUrl + '/user-group/disable/'+$(this).data('id'),
            type: 'GET',
            success: function(resp) {
                if(resp.responseCode === 200) {
                    // Reload datatable
                    userDataTable.ajax.reload();
                  
                     Lobibox.notify('success', {
                            sound: true,
                            icon: true,
                            msg : resp.responseMessage,
                    });
                } else {
                     Lobibox.notify('error', {
                            sound: true,
                            icon: true,
                            msg : resp.responseMessage,
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

    // Activate user group
    $('#user-group-table').on('click', '.btn-active', function() {

        if(!confirm('Area you sure want to activate this user group')) {
            return;
        }

        // Get data
        // Send data
        $.ajax({
            url: baseUrl + '/user-group/activate/'+$(this).data('id'),
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

});
</script>
@endsection
