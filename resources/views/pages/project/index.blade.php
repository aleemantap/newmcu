@extends('layouts.app')
@section('css')
    @include('layouts.datatableCss')
@endsection

@section('title', $title_page_left)

@section('ribbon')
<ul class="breadcrumbs pull-left">
	<li><a href="/home">Home</a></li>
    <li><span>Project</span></li>   
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
                            <table  id="project-table" class="table table-striped table-borderless" width="100%">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th style="width:20px;">No</th>
                                        <th>@lang('project.project_id')</th>
                                        <th>@lang('vendor.vendor')</th>
                                        <th>@lang('customer.customer')</th>
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
    @include('pages.project.new-project')
@endsection

@section('script')
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
    var projectDataTable = $('#project-table').DataTable({
        dom: '<"dt-toolbar"<"col-md-3 col-sm-12 hidden-sm float-left"f><"col-md-9 col-sm-12 hidden-sm float-right"<"toolbar">>>rt<"dt-toolbar-footer"<"col-md-5 col-sm-12"i><"col-md-6 col-md-12 hidden-sm"p>><"clear">',
        processing: false,
        serverSide: true,
        scrollX: true,
        pageLength: 15,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        pagingType: 'full_numbers',
        ajax: baseUrl+"/project-datatables",
        language: {
            //processing: '<div style="display: none"></div>',
            // info: 'Menampilkan _START_ - _END_ dari _TOTAL_ ',
            search: ' <div class="input-group"><div class="input-group-prepend"> <span class="input-group-text"> <span class="ti-search"></span> </span></div>',
            // zeroRecords: 'Tidak ada data yang cocok dengan kriteria pencarian',
            // emptyTable: 'Data tidak tersedia',
            paginate: {
                first: '&laquo;',
                last: '&raquo;',
                next: '&rsaquo;',
                previous: '&lsaquo;'
            }
            //lengthMenu: "Baris per halaman: _MENU_ "
        },
        //rowId: 'TRANSPORT_ID',
        columns: [
            {data: "DT_RowIndex", sortable: false, searchable: false},
            {data: "id", name: "id"},
            {data: "vendor.name", name: "vendor.name"},
            {data: "customer.name", name: "customer.name"},
            {data: "action", sortable: false, searchable: false, class: "action"}
        ]
    });
	
	@if (session()->get('user.user_group_id')==1)
	    $("div.toolbar").html(`
			<a href='{{ url("/project-export") }}' id='btn-filter-project' class='btn btn-secondary'><i class='fa fa-download'></i></a>&nbsp;
			<button id='btn-add-project' class='btn btn-primary'><i class='fa fa-plus-circle'></i> @lang('general.add')</button>&nbsp;
		`);
	@endif

    

    // Add Project
    $('body').on('click', '#btn-add-project', function(){
        
        $('#modal-project').modal('toggle');
        $('#modal-project .modal-title').html('@lang("project.new_project")');
        $('#modal-project input[type=text],#modal-project input[type=hidden],#modal-project input[type=email],#modal-project input[type=number]').val('');
    });

    // Add New Or Update Program
    $('#btn-submit').click(function(){

        // Update when project id has value
        var url = baseUrl + '/project/update';
        var action = "update";
        if(!$('#project-id').val()) {
            url = baseUrl + '/project/save';
            action = "save";
        }

        // Has error
        // var hasError = false;
        // Check requirement input
        if(!$('#vendor').val()) {

            Lobibox.notify('warning', {
                            sound: true,
                            icon: true,
                            msg : 'Vendor can\'t be empty',
            });
            
            $('#vendor').focus();
            return;
        }
        if(!$('#customer').val()) {
            Lobibox.notify('warning', {
                            sound: true,
                            icon: true,
                            msg : 'Customer can\'t be empty',
            });
            $('#customer').focus();
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
                'id': $('#project-id').val(),
                'vendor_id': $('#vendor').val(),
                'customer_id': $('#customer').val()
            },
            success: function(resp) {
                if(resp.responseCode === 200) {
                    // Reload datatable
                    projectDataTable.ajax.reload();
                    // Reset Form
                    $('#modal-project input[type=text],#modal-project input[type=email],#modal-project input[type=number]').val('');
                    // Close modal
                    $('#modal-project').modal('hide');
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
                    msg : xhr.statusText,
                });
                // Hide loder
                $('.page-loader').addClass('hidden');
            }
        });

    });

    // Edit project
    $('#project-table').on('click', '.btn-edit', function() {
        $('#modal-project').modal('show');
        $('#modal-project .modal-title').html('@lang("project.edit_project")');

        // Hide loder
        $('.page-loader').removeClass('hidden');

        // Get data
        // Send data
        $.ajax({
            url: baseUrl + '/project/' + $(this).data('id'),
            type: 'GET',
            success: function(resp) {
                $('#project-id').val(resp.id);
                $('#vendor').val(resp.vendor_id);
                $('#customer').val(resp.customer_id);

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

    // Delete project
    $('#project-table').on('click', '.btn-delete', function() {

        if(!confirm('Are you sure want to delete this project?')) {
            return;
        }

        // Get data
        // Send data
        $.ajax({
            url: baseUrl + '/project/delete/'+$(this).data('id'),
            type: 'GET',
            success: function(resp) {
                if(resp.responseCode === 200) {
                    // Reload datatable
                    projectDataTable.ajax.reload();
                   
                    Lobibox.notify('success', {
                        sound: true,
                        icon: true,
                        msg :  resp.responseMessage,
                    });
                } else {
                    
                    Lobibox.notify('error', {
                        sound: true,
                        icon: true,
                        msg :  resp.responseMessage,
                    });
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                Lobibox.notify('error', {
                    sound: true,
                    icon: true,
                    msg : xhr.statusText,
                });
        }
        });
    });

});

</script>
@endsection
