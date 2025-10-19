@extends('layouts.app')
@section('css')
    @include('layouts.datatableCss')    
@endsection
@section('title', $title_page_left)

@section('ribbon')
<ul class="breadcrumbs pull-left">
	<li><a href="/home">Home</a></li>
    <li><a href="">Database</a></li>
    <li><span>MCU</span></li>
   
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
                                    <table  id="datatable" class="table table-striped table-borderless"   width="100%">
                                        <thead class="bg-light text-capitalize">
                                             <tr>
                                                <th style="width:20px;">No</th>
                                                <th>No. NIP</th>
                                                <th>Nama</th>
                                                <th>Tgl. lahir</th>
                                                <th>L/P</th>
                                                <th>Bagian</th>
                                                <th>Client</th>
                                                <th>Tgl. MCU</th>
                                                <th>Blast WA</th>
                                                <!--<th>Status WA</th>-->
                                                <!--<th style="width: 60px"><i class="fa fa-ellipsis-v"></i></th>-->
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
    @include('pages.mcu.filter')
    @include('pages.mcu.import-mcu')
    @include('pages.mcu.export-mcu')
    @include('pages.mcu.bulk-delete')   
    {{-- @include('pages.mcu.publish') --}}
@endsection


@section('css')
{{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
{{-- <script src="{{ asset('assets/css/select2-bootstrap.css') }}"></script> --}}
{{-- <link href="{{ asset("assets/css/select2.min.css") }}" rel="stylesheet"></link> --}}
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker.css') }}" />

@endsection

@section('script')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

{{-- <script scr="{{ asset("assets/js/select2.min.js") }}"></script> --}}
<script src="{{ asset('assets/js/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>

{{-- <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" /> --}}

<script>
$(document).ready(function () {


	// $('select').select2({
    //     width: '100%',
    //     //containerCssClass: 'select-xs'
    //     tags: "true",
    //     placeholder: "Select an option",
    //     allowClear: true,
    //    // theme: 'bootstrap4',
        
    // });

    $('select').select2({
        width: '100%',
        containerCssClass: 'select-xs'
    });

    // $('.datepicker').datepicker({
    //     uiLibrary: 'bootstrap4'
      
    // });

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: 'true'
    });

    $('.input-daterange').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: 'true'
    });

    // Toggle filter
    $('.form-filter a').click(function() {
        $(this).toggleClass('open');
        $('.filter-title').toggleClass('hidden');
        $('.form-filter form').toggleClass('open-filter');
    });
	// $('#btn-cancel-import').hide();
	




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
    var mcuDataTable = $('#datatable').DataTable({
        dom: '<"dt-toolbar"<"col-md-3 col-sm-12 hidden-sm float-left"l><"col-md-9 col-sm-12 hidden-sm float-right"<"toolbar">>>rt<"dt-toolbar-footer"<"col-md-5 col-sm-12"i><"col-md-6 col-md-12 hidden-sm"p>><"clear">',
        processing: false,
        serverSide: true,
        scrollX: true,
        pageLength: 15,
        lengthMenu: [[15, 25, 50, 100], [15, 25, 50, 100]],
        pagingType: 'full_numbers',
        ajax: {
            url: baseUrl+"/database/medical-check-up/datatables",
            type: 'GET',
            data:  function(d){
               
				d.idPasien = $('#id-pasien').val();
                d.nama = $('#nama').val();
                d.nip = $('#no-nip').val();
                d.tglLahir = $('#tgl-lahir').val();
                d.lp = $('#lp').val();
                d.bagian = $('#bagian').val();
                d.idPerusahaan = $('#perusahaan').val();
                d.client = $('#client').val();
                d.startDate = $('#from-date').val();
                d.endDate = $('#to-date').val();
            }
        },
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
            {data: "id", sortable: false, searchable: false},
            {data: "no_nip", name: "no_nip"},
            {data: "nama_pasien", name: "nama_pasien"},
            {data: "tgl_lahir", name: "tgl_lahir"},
            {data: "jenis_kelamin", name: "jenis_kelamin"},
            {data: "bagian", name: "bagian"},
            {data: "vendor_customer.customer.name", name: "vendor_customer.customer.name"},
            {data: "tgl_input", name: "tgl_input"},
            {data: "published", name: "published"},
            //{data: "reportsendwa.status", name: "reportsendwa.status"}
            //{data: "id", sortable: false, searchable: false, class: "action"}
        ],
		
        columnDefs:[
            {
                
                render: function(d) { 
                    return d;
                }
            },
            {
                targets: 8,
                render: function(d) {
                    return (d==='Y')?'<span class="text-success">Yes</span>':'<span class="text-danger">No</span>';
                }
            },
			// {
                // targets: 9,
                // render: function(d,row,data) { 
					// var mcuid = data.id;
					// var ss = (d=='success')?'success':'warning';
                    // return (d!==undefined)?'<a href="/database/medical-check-up/sts-wa/'+mcuid+'"  class="btn bts-warning btn-xs bts-wa-sts"><span  style="font-size:15px;" class="text-'+ss+'">'+d+'</span></a>':'';
                // }
            // },
            //{
              //  targets: 10,
				//<a href="/database/medical-check-up/edit/'+d+'" class="btn btn-warning btn-xs" title="Edit" data-id='+d+'><i class="fa fa-pencil"></i></a>&nbsp;
              //  render: function(d) {
               //     return ' <button type="button" class="btn btn-danger btn-xs btn-delete" title="@lang('general.delete')" data-id='+d+'><i class="fa fa-trash"></i></button>'+
				//		   '&nbsp; ';
					
                //}
            //},
			
			
        ],
		'select': {
			style:    'single'
		},
		
    });
    //<button href="#" id='btn-re-diagnostic' class='btn btn-warning'><i class='fa fa-refresh'></i> @lang("general.re-diagnostic")</button>
    //  <a href="/database/medical-check-up/create" id='btn-add-mcu' class='btn btn-primary'><i class='fa fa-plus-circle'></i> @lang("general.add")</a>
     
	// Create button
    $("div.toolbar").html(`
        <button id='btn-filter-clear-mcu' title='Filter' class='btn btn-default hidden'><i class='fa fa-filter'></i> Remove Filter</button>&nbsp;
        <button id='btn-filter-mcu' title='Filter' class='btn btn-default btn-sm'><i class='fa fa-filter'></i>&nbsp;</button>&nbsp;
        <button id='btn-import-mcu' title='Upload' class='btn btn-default btn-sm'><i class='fa fa-upload'></i>&nbsp;</button>&nbsp;
        <button id='btn-export-mcu' title='@lang('general.download')' class='btn btn-default btn-sm'><i class='fa fa-download'></i>&nbsp;</button>&nbsp;
		<button id='btn-upload-ekg' title='EKG' class='btn btn-default btn-sm'>EKG</button>&nbsp;
		<button id='btn-upload-rng' title='Rontgen' class='btn btn-default btn-sm'>RNG</button>&nbsp;
        <button id='btn-delete-mcu' title='@lang('general.bulk_delete')' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i> @lang("mcu.bulk_delete")</button>&nbsp;
        <button href="#" id='btn-show-diagnostic' class='btn btn-info btn-sm'><i class='fa fa-stethoscope'></i> @lang("general.diagnostic")</button>
	`);

	 $('#btn-filter-submit').click(function() {
        mcuDataTable.draw(true);
    });
	
	// re-diagnostic
	$('#datatable tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    } );
 
	$('body').on('click', '#btn-re-diagnostic', function(){
		 
		 if(mcuDataTable.rows('.selected').data().length)
		 {
			alert( mcuDataTable.rows('.selected').data().length +' row(s) selected' );
		 }
		 
	});		
	// show-diagnostic
	$('body').on('click', '#btn-show-diagnostic', function(){
		 
		 if(mcuDataTable.rows('.selected').data().length)
		 {
			if(parseInt(mcuDataTable.rows('.selected').data().length) > 1)
			{
				alert("Select only one row");
			}
			else
			{
				//alert( mcuDataTable.rows('.selected').data().length +' row(s) selected' );
				//console.log(mcuDataTable.rows('.selected').data());
				//console.log(mcuDataTable.rows('.selected').data()[0].id);
				location.href = '/database/medical-check-up/show-diagnostic/'+mcuDataTable.rows('.selected').data()[0].id;
			}		
			
		 
		 }
		 else
		 {
			 alert("Select one row");
		 }	 
		 
	});	
	// uplaod ekg
	$('body').on('click', '#btn-upload-ekg', function(){
		 
		 if(mcuDataTable.rows('.selected').data().length)
		 {
			if(parseInt(mcuDataTable.rows('.selected').data().length) > 1)
			{
				alert("Select only one row");
			}
			else 
			{
				location.href = '/database/medical-check-up/show-ekg/'+mcuDataTable.rows('.selected').data()[0].id+'/'+mcuDataTable.rows('.selected').data()[0].nama_pasien;
			}		
			
		 
		 }
		 else
		 {
			 alert("Select one row");
		 }	 
		 
	});	
	
	// uplaod RNG
	$('body').on('click', '#btn-upload-rng', function(){
		 
		 if(mcuDataTable.rows('.selected').data().length)
		 {
			if(parseInt(mcuDataTable.rows('.selected').data().length) > 1)
			{
				alert("Select only one row");
			}
			else
			{
				location.href = '/database/medical-check-up/show-rng/'+mcuDataTable.rows('.selected').data()[0].id+'/'+mcuDataTable.rows('.selected').data()[0].nama_pasien;
			}		
			
		 
		 }
		 else
		 {
			 alert("Select one row");
		 }	 
		 
	});	
		 
		 
	
    // Add Mcu
    $('body').on('click', '#btn-add-mcu', function(){
        $('#modal-mcu').modal('show');
        $('#modal-mcu .modal-title').html('New Radiology');
        $('#modal-mcu input[type=text],#modal-mcu input[type=hidden],#modal-mcu input[type=password],#modal-mcu input[type=email],#modal-mcu input[type=number]').val('');
    });

    // Filter Mcu
    $('body').on('click', '#btn-filter-mcu', function(){
        $('#modal-filter').modal('show');
    });

    // Remove Filter Mcu
    $('body').on('click', '#btn-filter-clear-mcu', function(){
        $('#modal-filter input, #modal-filter select').val('').trigger('change');
        mcuDataTable.draw(true)
        $('#btn-filter-clear-mcu').addClass('hidden');
    });

    $('#btn-filter-submit').click(function() {
        $('#modal-filter').modal('hide');
        mcuDataTable.draw(true);
        $('#btn-filter-clear-mcu').removeClass('hidden');
    });

    // // Publish MCU
    // $('body').on('click', '#btn-publish-mcu', function(){
    //     $('#modal-publish').modal('show');
    //     $('#modal-publish input[type=text], #modal-filter select').val('');
    // });

   

    // Download mcu
    $('body').on('click', '#btn-export-mcu', function(){
        $('#modal-export').modal('show');
        $('#modal-export input[type=text], #modal-filter select').val('');
    });

    // Bulk Delete 
    $('body').on('click', '#btn-delete-mcu', function(){
		
        $('#modal-delete-mcu').modal('show');
        $('#modal-delete-mcu input[type=text], #modal-filter select').val('');
    });

    $('#btn-delete').click(function() {
		
        // Show loder
        $('.page-loader').removeClass('hidden');

        // Send data
        $.ajax({
            url: '/database/medical-check-up/bulk-delete',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'idPasien': $('#patient-id-bulk').val(),
                'idPerusahaan': $('#customer-bulk').val(),  //.find(":selected").text();
                'startDate': $('#from-date-bulk').val(),
                'endDate': $('#to-date-bulk').val()
            },
            success: function(resp) {
                if(resp.responseCode === 200) {
                    // Reload datatable
                    mcuDataTable.ajax.reload();
                    // Reset Form
                    $('#modal-delete-mcu input,#modal-delete-mcu select').val('');
                    // Close modal
                    $('#modal-delete-mcu').modal('hide');
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

    // Open Modal Import mcu
    $('body').on('click', '#btn-import-mcu', function(){
        $('#modal-import-mcu').modal('show');
        $('#modal-import-mcu .modal-title').html('Import MCU');
        $('#modal-import-mcu input[type=text],#modal-mcu input[type=hidden],#modal-mcu input[type=password],#modal-mcu input[type=email],#modal-mcu input[type=number]').val('');
    });

    // Add New Or Update Program
    $('#btn-submit').click(function(){

        // Update when user id has value
        var url = baseUrl + '/database/mcu/update';
        var action = "update";
        if(!$('#mcu-id').val()) {
            url = baseUrl + '/database/mcu/save';
            action = "save";
        }

        // Has error
        // var hasError = false;
        // Check requirement input
        if(!$('#patient-id').val()) {
           
            Lobibox.notify('error', {
                    sound: true,
                    icon: true,
                    msg :  'Id pasien can\'t be empty',
            });

            $('#patient-id').focus();
            return;
        }
        if(!$('#foto-type').val()) {
           
            Lobibox.notify('error', {
                    sound: true,
                    icon: true,
                    msg :  'Jenis Foto can\'t be empty',
            });

            $('#foto-type').focus();
            return;
        }
        if(!$('#parameter').val()) {
          
            Lobibox.notify('error', {
                    sound: true,
                    icon: true,
                    msg :   'Parameter can\'t be empty',
            });

            $('#parameter').focus();
            return;
        }

        if(!$('#result').val()) {
           
            Lobibox.notify('error', {
                    sound: true,
                    icon: true,
                    msg :  'Temuan can\'t be empty',
            });
            $('#result').focus();
            return;
        }
        if(!$('#customer').val()) {
           

            Lobibox.notify('error', {
                    sound: true,
                    icon: true,
                    msg :   'Perusahaan can\'t be empty',
            });

            $('#customer').focus();
            return;
        }
        if(!$('#input-date').val()) {
           
            Lobibox.notify('error', {
                    sound: true,
                    icon: true,
                    msg :  'Tgl. input can\'t be empty',
            });
            $('#input-date').focus();
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
                'id': $('#mcu-id').val(),
                'idPasien': $('#patient-id').val(),
                'jenisFoto': $('#foto-type').val(),
                'parameter': $('#parameter').val(),
                'temuan': $('#result').val(),
                'idPerusahaan': $('#customer').val(),
                'tglInput': $('#input-date').val()
            },
            success: function(resp) {
                if(resp.responseCode === 200) {
                    // Reload datatable
                    mcuDataTable.ajax.reload();
                    // Reset Form
                    $('#modal-mcu input[type=text],#modal-mcu input[type=password],#modal-mcu input[type=email],#modal-mcu input[type=number]').val('');
                    // Close modal
                    $('#modal-mcu').modal('hide');
                    // Send success message
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
                // Hide loder
                $('.page-loader').addClass('hidden');
            },
            error: function(xhr, ajaxOptions, thrownError) {
              
                Lobibox.notify('error', {
                    sound: true,
                    icon: true,
                    msg :   xhr.statusText,
                });
                // Hide loder
                $('.page-loader').addClass('hidden');
            }
        });

    });

    // Edit MCU
    $('#datatable').on('click', '.btn-edit', function() {
        $('#modal-mcu').modal('show');
        $('#modal-mcu .modal-title').html('Edit Radiology');

        // Hide loder
        $('.page-loader').removeClass('hidden');

        // Get data
        // Send data
        $.ajax({
            url: baseUrl + '/database/mcu/detail/' + $(this).data('id'),
            type: 'GET',
            success: function(resp) {
                $('#mcu-id').val(resp.id);
                $('#patient-id').val(resp.id_pasien);
                $('#foto-type').val(resp.jenis_foto);
                $('#parameter').val(resp.parameter);
                $('#result').val(resp.temuan);
                $('#customer').val(resp.id_perusahaan);
                $('#input-date').val(resp.input_date);

                // Hide loder
                $('.page-loader').addClass('hidden');
            },
            error: function(xhr, ajaxOptions, thrownError) {
               
                Lobibox.notify('error', {
                    sound: true,
                    icon: true,
                    msg :   xhr.statusText,
                });
                // Hide loder
                $('.page-loader').addClass('hidden');
            }
        });
    });

    // Disabled user
    $('#datatable').on('click', '.btn-delete', function() {

        if(!confirm('Area you sure want to delete this data?')) {
            return;
        }

        // Get data
        // Send data
        $.ajax({
            url: baseUrl + '/database/medical-check-up/delete/'+$(this).data('id'),
            type: 'GET',
            success: function(resp) {
                if(resp.responseCode === 200) {
                    // Reload datatable
                    mcuDataTable.ajax.reload();
                    Lobibox.notify('error', {
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
                        msg :   xhr.statusText,
                    });
            }
        });

    });

    // Disable and undisable form
    $('#publish-all').click(function() {
        if($(this).prop('checked') == true) {
            $('#modal-publish #customer').attr('disabled', 'disabled');
            $('#modal-publish #client').attr('disabled', 'disabled');
            $('#modal-publish #bagian').attr('disabled', 'disabled');
            $('#modal-publish #from-date').attr('disabled', 'disabled');
            $('#modal-publish #to-date').attr('disabled', 'disabled');
			$('#modal-publish #start-id').attr('disabled', 'disabled');
            $('#modal-publish #to-id').attr('disabled', 'disabled');
        }
    });

    $('#publish-some').click(function() {
        if($(this).prop('checked') == true) {
            $('#modal-publish #customer').removeAttr('disabled');
            $('#modal-publish #client').removeAttr('disabled');
            $('#modal-publish #bagian').removeAttr('disabled');
            $('#modal-publish #from-date').removeAttr('disabled');
            $('#modal-publish #to-date').removeAttr('disabled');
			$('#modal-publish #start-id').removeAttr('disabled');
            $('#modal-publish #to-id').removeAttr('disabled');
        }
    });

    

    // cancel import
	
	$('#btn-cancel-import').click(function(){
		
		if($("#process_id").val() != "") {
		var form = new FormData();
        form.append('process_id', $("#process_id").val())
		// Show loader
        $('.page-loader').removeClass('hidden');
        $.ajax({
            url: baseUrl + '/database/medical-check-up/batal-import',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData: false, // prevent jQuery from automatically transforming the data into a query string
            contentType: false, // is imperative, since otherwise jQuery will set it incorrectly.
            data: form,
            success: function(resp) {
                if(resp.responseCode === 200) {
                    //checkProcess(resp.processId);
					//alert("Cancel Uploading Success !");
					$("#process_id").val("");
					//mcuDataTable.draw(true);
					location.reload();
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
                        msg :   xhr.statusText,
                    });
                $('.page-loader').addClass('hidden');
            }
         });
		
			
		}
		else
		{
			alert("Proses cancel tidak bisa dilakukan !");
		}
		
		
	});
	
    // Import mcu
    $('#btn-import').click(function(){

        if(!$('#file').val()) {
           
                    Lobibox.notify('warning', {
                        sound: true,
                        icon: true,
                        msg :   'Please select file to upload',
                    });

            return;
        }

         if($('#file')[0].files[0].name.indexOf('mcu') < 0)
         {
            Lobibox.notify('warning', {
                sound: true,
                icon: true,
                msg :  'Please select file upload template_mcu',
            });

            return;
         }

        


        // Create form data
        var form = new FormData();
        form.append('file', $('#file')[0].files[0]);

        // Show loader
        $('.page-loader').removeClass('hidden');
        $.ajax({
            url: baseUrl + '/database/medical-check-up/import',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData: false, // prevent jQuery from automatically transforming the data into a query string
            contentType: false, // is imperative, since otherwise jQuery will set it incorrectly.
            data: form,
            success: function(resp) {
                if(resp.responseCode === 200) {
					$("#process_id").val(resp.processId);
					if(resp.processId!="" || resp.processId!="0"){
						$('#btn-cancel-import').show();
					}
						
                    checkProcess(resp.processId);
                } else {
					//$("#process_id").val("");
                    Lobibox.notify('error', {
                        sound: true,
                        icon: true,
                        msg :  resp.responseMessage,
                    });
                }
                $('.page-loader').addClass('hidden');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                //$("#process_id").val("");
				
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

                mcuDataTable.ajax.reload();
				var spl = e.data.split(";");
               
				
				if(spl[1]=="STOPPED")
				{
					
					source.close();
					
					alert("Process STOPPED Terjadi Error. \nData akan dikembalikan kesemula. \nSilahkan Hubungi Admin. \nKemungkinan error pada Template Excel atau program");
					
					$('.input-form').removeClass('hidden');
					$('.input-progress').addClass('hidden');
					$('#btn-import').removeAttr('disabled');
					$('#upload-progress').attr('aria-valuenow', 0).attr('style', 'width: 0%');
					
					
					$('#btn-cancel-import').trigger("click");
					$("#process_id").val("");
				}
				else
				{
					
					 if (process !== parseInt(spl[0])) {
						$('#upload-progress').attr('aria-valuenow', spl[0]).attr('style', 'width:'+ spl[0]+'%');
						$('.progress-text').html(spl[0]+'% Completed ... Please wait ...');
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
                            msg : 'Upload file has been finish',
                        });
						
						//alert("Uploading Success !");

						source.close();
						$("#process_id").val("");
					}
					//console.log(spl[0]+"-"+spl[1]);
					
					process = parseInt(spl[0]);
				}	

					
            };
        } else {
            // Sorry! No server-sent events support..
            //toastr.error('No server-sent events support', 'Error');
            console.log('error', 'No server-sent events support');

            $('.input-form').removeClass('hidden');
            $('.input-progress').addClass('hidden');
            $('#btn-import').removeAttr('disabled','disabled');
			$("#process_id").val("");
        }
    }


    

    // Check if current process is running
    @if($process)
        checkProcess({{ $process->id }});
    @endif

    

});


function details(elem){
    window.location.href = '{{ url("/database/medical-check-up/show") }}/' + $(elem).attr('data-id');
}
function editRow(elem){
    window.location.href = '{{ url("/database/medical-check-up/edit") }}/' + $(elem).attr('data-id');
}
</script>
@endsection

<style>
/*     
select.select2 {
    height: auto !important;
    padding: 0.6rem 0.8rem calc(0.6rem + 1px) 0.8rem !important;
} */

</style>
