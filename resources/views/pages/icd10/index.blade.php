@extends('layouts.app')
@section('css')
    @include('layouts.datatableCss')    
@endsection
@section('content-class', 'grid')
@section('ribbon')
<ol class="breadcrumb">
   
</ol>
@endsection

@section('content')
    <div class="row">
		<div class="col-12 mt-5">
			<div class="card">
                <div class="card-body">
					<div class="form-filter">
						<a class="" href="#"><i class="fa fa-chevron-down sign"></i> <span class="filter-title">Show</span><span class="filter-title hidden">Hide</span> Filter <i class="fa fa-filter"></i></a>

						<form action="" class="form-horizontal">
							<div class="row">
								

								<div class="col-md-4">
									<div class="form-group row">
										<label for="" class="control-label col-md-4">Name</label>
										<div class="col-md-8"><input type="text" class="form-control form-control-sm" id="name-search"></div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group row">
										<label for="" class="control-label col-md-4">Code</label>
										<div class="col-md-8"><input type="text" class="form-control form-control-sm" id="code-search"></div>
									</div>
								</div>
								<div class="col-md-8">
									<div class="form-group row">
										<label class="col-md-2"></label>
										<div class="col-md-4">
											<button type="button" class="btn btn-xs btn-primary btn-block btn-flat" id="btn-filter-submit"><i class="fa fa-check-circle"></i> Submit</button>
										</div>
										
									</div>
								</div>
							</div>
						</form>
					</div>

					<hr/>
					<table id="icd10-table" class="table table-striped table-borderless" width="100%">
						<thead>
							<tr>
								<th style="width:20px;">No</th>
								<th>@lang('icd10.code')</th>
								<th>@lang('icd10.name') </th>
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
@endsection

@section('modal')
    @include('pages.icd10.new-icd10')
@endsection

@section('script')
<script>
    $(document).ready(function () {
		
		
	// Toggle filter
    $('.form-filter a').click(function() {
        $(this).toggleClass('open');
        $('.filter-title').toggleClass('hidden');
        $('.form-filter form').toggleClass('open-filter');
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
    var icd10DataTable = $('#icd10-table').DataTable({
        //dom: '<"dt-toolbar"<"col-sm-6 col-xs-12 hidden-xs"f><"col-sm-6 col-xs-12 hidden-xs text-right"<"toolbar">>>rt<"dt-toolbar-footer"<"col-sm-6 col-xs-12"i><"col-sm-6 col-xs-12 hidden-xs"p>><"clear">',
        dom: '<"dt-toolbar"<"col-md-3 col-sm-12 hidden-sm float-left"l><"col-md-9 col-sm-12 hidden-sm float-right"<"toolbar">>>rt<"dt-toolbar-footer"<"col-md-5 col-sm-12"i><"col-md-6 col-md-12 hidden-sm"p>><"clear">',
        processing: false,
        serverSide: true,
        scrollX: true,
        pageLength: 15,
        lengthMenu: [[15, 25, 50, 100], [15, 25, 50, 100]],
        pagingType: 'full_numbers',
        
		/*ajax: baseUrl+"/database/formula/icdx-datatables",*/
        language: {
            //processing: '<div style="display: none"></div>',
            // info: 'Menampilkan _START_ - _END_ dari _TOTAL_ ',
            //search: '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>',
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
		ajax: {
            url: baseUrl+"/database/formula/icdx-datatables",
            type: 'GET',
            data:  function(d){
                d.code= $('#code-search').val();
                d.name = $('#name-search').val();
               
            }
        },
        //rowId: 'TRANSPORT_ID',
        columns: [
            //{data: "DT_RowIndex", sortable: false, searchable: false},
			{data: "id", sortable: false, searchable: false},
            {data: "code", name: "code"},
            {data: "name", name: "name"},
            //{data: "action", sortable: false, searchable: false, class: "action"}
			{data: "id", sortable: false, searchable: false, class: "action"}
        ],
		columnDefs:[
            {
                targets: 3,
                render: function(d) {
                    return '<a href="#"  type="button" class="btn btn-warning btn-xs btn-flat btn-edit" title="Edit" data-id='+d+'><i class="fa fa-pencil"></i></a>&nbsp; <button type="button" class="btn btn-danger btn-flat btn-xs btn-delete-icd" title="Delete" data-id='+d+'><i class="fa fa-trash"></i></button>';
                }
            }
        ]
    });
	// <a href='{{ url("/icd10-export") }}' id='btn-export-icd10' class='btn btn-default'><i class='fa fa-download'></i></a>&nbsp;
    $("div.toolbar").html(`
	    <a href='{{ url("/icd10-export") }}' id='btn-export-icd10' class='btn btn-info btn-flat btn-sm'><i class='fa fa-download'></i></a>&nbsp;
        <button id='btn-add-icd10' class='btn btn-primary btn-flat btn-sm'><i class='fa fa-plus-circle'></i> @lang('general.add')</button>&nbsp;
    `);
	
	
	 $('#btn-filter-submit').click(function() {
        icd10DataTable.draw(true);
    });

    // Add Customer
    $('body').on('click', '#btn-add-icd10', function(){
        $('#modal-icd10').modal('show');
        $('#modal-icd10 .modal-title').html('@lang("icd10.new_icd10")');
        $('#modal-icd10 input[type=text],#modal-icd10 input[type=hidden],#modal-icd10 input[type=email],#modal-icd10 input[type=number]').val('');
    });

    // Add New Or Update Program
    $('#btn-submit').click(function(){

        // Update when icd10 id has value
        var url = baseUrl + '/icd10/update';
        var action = "update";
        if(!$('#icd10-id').val()) {
            url = baseUrl + '/icd10/save';
            action = "save";
        }

        // Has error
        // var hasError = false;
        // Check requirement input
        if(!$('#name').val()) {
          
            Lobibox.notify('error', {
                                sound: true,
                                icon: true,
                                msg : 'Name can\'t be empty',
                            });
            $('#name').focus();
            return;
        }
        if(!$('#code').val()) {
          
            Lobibox.notify('error', {
                                sound: true,
                                icon: true,
                                msg : 'Code can\'t be empty',
                            });
            $('#address1').focus();
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
                'id': $('#icd10-id').val(),
                'name': $('#name').val(),
                'code': $('#code').val()
            },
            success: function(resp) {
                if(resp.responseCode === 200) {
                    // Reload datatable
                    icd10DataTable.ajax.reload();
                    // Reset Form
                    $('#modal-icd10 input[type=text],#modal-icd10 input[type=email],#modal-icd10 input[type=number]').val('');
                    // Close modal
                    $('#modal-icd10').modal('hide');
                    // Send success message
                  
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

    // Edit icd10
    $('#icd10-table').on('click', '.btn-edit', function() {
        $('#modal-icd10').modal('show');
        $('#modal-icd10 .modal-title').html('@lang("icd10.edit_icd10")');

        // Hide loder
        $('.page-loader').removeClass('hidden');

        // Get data
        // Send data
        $.ajax({
            url: baseUrl + '/icd10/' + $(this).data('id'),
            type: 'GET',
            success: function(resp) {
				
                $('#icd10-id').val(resp.responseMessage.id);
                $('#name').val(resp.responseMessage.name);
                $('#code').val(resp.responseMessage.code);
                

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

    // Delete icd10
    $('#icd10-table').on('click', '.btn-delete-icd', function() {
		alert("tes");
        if(!confirm('Are you sure want to delete this icd10?')) {
            return;
        }

        // Get data
        // Send data
        $.ajax({
            url: baseUrl + '/icd10/delete/'+$(this).data('id'),
            type: 'GET',
            success: function(resp) {
                if(resp.responseCode === 200) {
                    // Reload datatable
                    icd10DataTable.ajax.reload();
                    Lobibox.notify('success', {
                        sound: true,
                        icon: true,
                        msg :resp.responseMessage,
                        });
                } else {
                    
                    Lobibox.notify('error', {
                        sound: true,
                        icon: true,
                        msg :resp.responseMessage,
                        });
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                Lobibox.notify('error', {
                        sound: true,
                        icon: true,
                        msg  :  xhr.statusText,
                        });
            }
        });
    });

});

</script>
@endsection
