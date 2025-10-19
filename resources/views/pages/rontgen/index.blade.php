@extends('layouts.app')
@section('css')
    @include('layouts.datatableCss')    
@endsection

@section('title', $title_page_left)

@section('ribbon')
<ul class="breadcrumbs pull-left">
	<li><a href="/home">Home</a></li>
    <li><a href="/">Database</a></li>
    <li><span>Rontgen</span></li>   
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
                            <table  id="datatable" class="table table-striped table-borderless" width="100%">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th style="width:20px;">No</th>
                                        <th>Id Pasien</th>
                                        <th>Jenis Foto</th>
                                        <th>Parameter</th>
                                        <th>Temuan</th>
                                        <th>Tgl. Input</th>
                                        <th style="width: 150px"><i class="fa fa-ellipsis-v"></i></th>
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
    @include('pages.rontgen.new-rontgen')
    @include('pages.rontgen.import-rontgen')
    @include('pages.rontgen.export-rontgen')
    @include('pages.rontgen.filter')
    @include('pages.rontgen.bulk-delete')
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker.css') }}" />
@endsection

@section('script')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('assets/js/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script>
$(document).ready(function () {

     $('select').select2({
        width: '100%',
        containerCssClass : "select-xs"
     });

     $('.datepicker').datepicker({
         autoclose: true,
         format: 'yyyy-mm-dd'
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
    var rontgenDataTable = $('#datatable').DataTable({
        dom: '<"dt-toolbar"<"col-md-3 col-sm-12 hidden-sm float-left"l><"col-md-9 col-sm-12 hidden-sm float-right"<"toolbar">>>rt<"dt-toolbar-footer"<"col-md-5 col-sm-12"i><"col-md-6 col-md-12 hidden-sm"p>><"clear">',
        processing: false,
        serverSide: true,
        scrollX: true,
        pageLength: 15,
        lengthMenu: [[15, 25, 50, 100], [15, 25, 50, 100]],
        pagingType: 'full_numbers',
        ajax: {
            url: baseUrl+"/database/rontgen-datatables",
            type: 'GET',
            data:  function(d){
                d.idPasien = $('#modal-filter #patient-id').val();
                d.idPerusahaan = $('#modal-filter #customer').val();
                d.startDate = $('#modal-filter #from-date').val();
                d.endDate = $('#modal-filter #to-date').val();
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
            {data: "DT_RowIndex", sortable: false, searchable: false},
            {data: "id_pasien", name: "mcu.id_pasien"},
            {data: "jenis_foto", name: "jenis_foto"},
            {data: "parameter", name: "parameter"},
            {data: "temuan", name: "temuan"},
            {data: "tgl_input", name: "tgl_input"},
            {data: "action", sortable: false, searchable: false, class: "action"}
        ]
    });

    // Create button
    $("div.toolbar").html(`
        <button id='btn-filter-clear-rontgen' title='Filter' class='btn btn-default hidden btn-sm btn-flat'><i class='fa fa-filter'></i> Remove Filter</button>&nbsp;
        <button id='btn-filter-rontgen' title='Filter' class='btn btn-default btn-sm btn-flat'><i class='fa fa-filter'></i></button>&nbsp;
        <button id='btn-import-rontgen' title='Upload' class='btn btn-default btn-sm btn-flat'><i class='fa fa-upload'></i></button>&nbsp;
        <button id='btn-export-rontgen' title='@lang('general.download')' class='btn btn-default btn-sm btn-flat'><i class='fa fa-download'></i></button>&nbsp;
        <button id='btn-delete-rontgen' title='@lang('general.bulk_delete')' class='btn btn-danger btn-sm btn-flat'><i class='fa fa-trash'></i> @lang('general.bulk_delete')</button>&nbsp;
        <button id='btn-add-rontgen' class='btn btn-primary btn-sm btn-flat'><i class='fa fa-plus-circle'></i> @lang('general.add')</button>
    `);

    // Add Radiology
    $('body').on('click', '#btn-add-rontgen', function(){
        $('#modal-rontgen').modal('show');
        $('#modal-rontgen .modal-title').html('New Radiology');
        $('#modal-rontgen input[type=text],#modal-rontgen input[type=hidden],#modal-rontgen input[type=password],#modal-rontgen input[type=email],#modal-rontgen input[type=number]').val('');
    });

    // Filter Radiology
    $('body').on('click', '#btn-filter-rontgen', function(){
        $('#modal-filter').modal('show');
    });

    // Remove Filter
    $('body').on('click', '#btn-filter-clear-rontgen', function(){
        $('#modal-filter input, #modal-filter select').val('').trigger('change');
        rontgenDataTable.draw(true)
        $('#btn-filter-clear-rontgen').addClass('hidden');
    });

    $('#btn-filter').click(function() {
        $('#modal-filter').modal('hide');
        rontgenDataTable.draw(true);
        $('#btn-filter-clear-rontgen').removeClass('hidden');
    });

    // Download Radiology
    $('body').on('click', '#btn-export-rontgen', function(){
        $('#modal-export').modal('show');
        $('#modal-export input[type=text], #modal-filter select').val('');
    });

    // Bulk Delete Radiology
    $('body').on('click', '#btn-delete-rontgen', function(){
        $('#modal-delete-rontgen').modal('show');
        $('#modal-delete-rontgen input[type=text], #modal-filter select').val('');
    });

    $('#btn-delete').click(function() {
        // Show loder
        $('.page-loader').removeClass('hidden');

        // Send data
        $.ajax({
            url: '/database/rontgen-bulk-delete',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'idPasien': $('#modal-delete-rontgen #patient-id').val(),
                'idPerusahaan': $('#modal-delete-rontgen #customer').val(),
                'startDate': $('#modal-delete-rontgen #from-date').val(),
                'endDate': $('#modal-delete-rontgen #to-date').val()
            },
            success: function(resp) {
                if(resp.responseCode === 200) {
                    // Reload datatable
                    rontgenDataTable.ajax.reload();
                    // Reset Form
                    $('#modal-delete-rontgen input,#modal-delete-rontgen select').val('');
                    // Close modal
                    $('#modal-delete-rontgen').modal('hide');
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
                        msg :  xhr.statusText,
                    });
                // Hide loder
                $('.page-loader').addClass('hidden');
            }
        });
    });

    // Open Modal Import Radiology
    $('body').on('click', '#btn-import-rontgen', function(){
        $('#modal-import-rontgen').modal('show');
        $('#modal-import-rontgen .modal-title').html('Import Rontgen');
        $('#modal-import-rontgen input[type=text],#modal-rontgen input[type=hidden],#modal-rontgen input[type=password],#modal-rontgen input[type=email],#modal-rontgen input[type=number]').val('');
    });

    // Add New Or Update Program
    $('#btn-submit').click(function(){

        // Update when user id has value
        var url = baseUrl + '/database/rontgen/update';
        var action = "update";
        if(!$('#rontgen-id').val()) {
            url = baseUrl + '/database/rontgen/save';
            action = "save";
        }

        // Has error
        // var hasError = false;
        // Check requirement input
        if(!$('#patient-id').val()) {
           
            Lobibox.notify('error', {
                        sound: true,
                        icon: true,
                        msg : 'Id pasien can\'t be empty',
                    });
            $('#patient-id').focus();
            return;
        }
        if(!$('#foto-type').val()) {
            Lobibox.notify('error', {
                        sound: true,
                        icon: true,
                        msg :'Jenis Foto can\'t be empty',
                    });
            $('#foto-type').focus();
            return;
        }
        if(!$('#parameter').val()) {
            Lobibox.notify('error', {
                        sound: true,
                        icon: true,
                        msg :'Parameter can\'t be empty',
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
                        msg : 'Perusahaan can\'t be empty',
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
                'id': $('#rontgen-id').val(),
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
                    rontgenDataTable.ajax.reload();
                    // Reset Form
                    $('#modal-rontgen input[type=text],#modal-rontgen input[type=password],#modal-rontgen input[type=email],#modal-rontgen input[type=number]').val('');
                    // Close modal
                    $('#modal-rontgen').modal('hide');
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

    // Edit user
    $('#datatable').on('click', '.btn-edit', function() {
        $('#modal-rontgen').modal('show');
        $('#modal-rontgen .modal-title').html('Edit Radiology');

        // Hide loder
        $('.page-loader').removeClass('hidden');

        // Get data
        // Send data
        $.ajax({
            url: baseUrl + '/database/rontgen/detail/' + $(this).data('id'),
            type: 'GET',
            success: function(resp) {
                $('#rontgen-id').val(resp.id);
                $('#patient-id').val(resp.id_pasien);
                $('#foto-type').val(resp.jenis_foto).trigger('change');
                $('#parameter').val(resp.parameter).trigger('change');
                $('#result').val(resp.temuan).trigger('change');
                $('#customer').val(resp.id_perusahaan).trigger('change');
                $('#input-date').val(resp.input_date);

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

    // Disabled user
    $('#datatable').on('click', '.btn-delete', function() {

        if(!confirm('Area you sure want to delete this data?')) {
            return;
        }

        // Get data
        // Send data
        $.ajax({
            url: baseUrl + '/database/rontgen/delete/'+$(this).data('id'),
            type: 'GET',
            success: function(resp) {
                if(resp.responseCode === 200) {
                    // Reload datatable
                    rontgenDataTable.ajax.reload();
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
                        msg :  xhr.statusText,
                    });
            }
        });

    });

    // Import Radiology
    $('#btn-import').click(function(){

        if(!$('#file').val()) {
            Lobibox.notify('warning', {
                sound: true,
                icon: true,
                msg : 'Please select file to upload',
            });

            return;
        }

        if($('#file')[0].files[0].name.indexOf('rontgen') < 0)
        {
           
            Lobibox.notify('warning', {
                sound: true,
                icon: true,
                msg : 'Please select file name template_rontgen to upload',
            });

            return;

        }
        // Create form data
        var form = new FormData();
        form.append('file', $('#file')[0].files[0]);

        // Show loader
        $('.page-loader').removeClass('hidden');
        $.ajax({
            url: baseUrl + '/database/rontgen-import',
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
                        msg : resp.responseMessage,
                    });
                }
                $('.page-loader').addClass('hidden');
            },
            error: function(xhr, ajaxOptions, thrownError) {
               
                Lobibox.notify('error', {
                        sound: true,
                        icon: true,
                        msg :xhr.statusText,
                    });
                $('.page-loader').addClass('hidden');
            }
        });
    });

    
    /*
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
                rontgenDataTable.ajax.reload();
                //mcuDataTable.ajax.reload();
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

						$.smallBox({
							title : "Success",
							content : 'Upload file has been finish',
							color : "#109618",
							sound_file: "voice_on",
							timeout: 3000
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
    */

    

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
            var url = "{{ url('update-process3') }}/"+id;
            var source = new EventSource(url);
            source.onmessage = function (e) {

                rontgenDataTable.ajax.reload();

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
                        msg : 'Upload file has been finish',
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
