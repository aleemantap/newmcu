@extends('layouts.app')
@section('css')
    @include('layouts.datatableCss')    
@endsection
@section('ribbon')   
    <ul class="breadcrumbs pull-left">
        <li><a href="/home">Home</a></li>
        <li><span>Audiometri</span></li>
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
                            <table  id="audiometri-table" class="table table-striped table-borderless" width="100%">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th style="width:20px;">No</th>
                                        <th>@lang('audiometri.patient')</th>
                                        <th>@lang('audiometri.frequency')</th>
                                        <th>@lang('audiometri.left')</th>
                                        <th>@lang('audiometri.right')</th>
                                        <th>@lang('audiometri.input_date')</th>
                                        <th class="action">@lang('general.action')</th>
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
    @include('pages.audiometri.new-audiometri')
    @include('pages.audiometri.import-audiometri')
    @include('pages.audiometri.export-audiometri')
    @include('pages.audiometri.filter')
    @include('pages.audiometri.bulk-delete')
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
    var audiometriDataTable = $('#audiometri-table').DataTable({
        dom: '<"dt-toolbar"<"col-md-3 col-sm-12 hidden-sm float-left"l><"col-md-9 col-sm-12 hidden-sm float-right"<"toolbar">>>rt<"dt-toolbar-footer"<"col-md-5 col-sm-12"i><"col-md-6 col-md-12 hidden-sm"p>><"clear">',
        processing: false,
        serverSide: true,
        scrollX: true,
        pageLength: 15,
        lengthMenu: [[15, 25, 50, 100], [15, 25, 50, 100]],
        pagingType: 'full_numbers',
        ajax: {
            url: baseUrl+"/database/audiometri-datatables",
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
            {data: "id_pasien", name: "id_pasien"},
            {data: "frekuensi", name: "frekuensi"},
            {data: "kiri", name: "kiri"},
            {data: "kanan", name: "kanan"},
            {data: "tgl_input", name: "tgl_input"},
            {data: "action", sortable: false, searchable: false, class: "action"}
        ]
    });

    $("div.toolbar").html(`
        <button id='btn-filter-clear-audiometri' title='Filter' class='btn btn-default btn-sm btn-flat hidden'><i class='fa fa-filter'></i> Remove Filter</button>&nbsp;
        <button id='btn-filter-audiometri' title='Filter' class='btn btn-default btn-sm btn-flat'><i class='fa fa-filter'></i></button>&nbsp;
        <button id='btn-import-audiometri' title='Upload' class='btn btn-default btn-sm btn-flat'><i class='fa fa-upload'></i></button>&nbsp;
        <button id='btn-export-audiometri' title='@lang('general.download')' class='btn btn-sm btn-default btn-flat'><i class='fa fa-download'></i></button>&nbsp;
        <button id='btn-delete-audiometri' title='@lang('general.bulk_delete')' class='btn btn-sm btn-danger btn-flat'><i class='fa fa-trash'></i> @lang('general.bulk_delete')</button>&nbsp;
        <button id='btn-add-audiometri' class='btn btn-primary btn-sm btn-flat'><i class='fa fa-plus-circle'></i> @lang('general.add')</button>
    `);

    // Add Audiometri
    $('body').on('click', '#btn-add-audiometri', function(){
        $('#modal-audiometri').modal('show');
        $('#modal-audiometri .modal-title').html('@lang("audiometri.new_audiometri")');
        $('#modal-audiometri input[type=text],#modal-audiometri input[type=hidden],#modal-audiometri input[type=password],#modal-audiometri input[type=email],#modal-audiometri input[type=number]').val('');
    });

     // Filter Audiometri
    $('body').on('click', '#btn-filter-audiometri', function(){
        $('#modal-filter').modal('show');
    });

    // Remove Filter
    $('body').on('click', '#btn-filter-clear-audiometri', function(){
        $('#modal-filter input, #modal-filter select').val('').trigger('change');
        audiometriDataTable.draw(true)
        $('#btn-filter-clear-audiometri').addClass('hidden');
    });

    $('#btn-filter').click(function() {
        $('#modal-filter').modal('hide');
        audiometriDataTable.draw(true);
        $('#btn-filter-clear-audiometri').removeClass('hidden');
    });

    // Download Audiometri
    $('body').on('click', '#btn-export-audiometri', function(){
        $('#modal-export').modal('show');
        $('#modal-export input[type=text], #modal-filter select').val('');
    });

    // Bulk Delete Audiometri
    $('body').on('click', '#btn-delete-audiometri', function(){
        $('#modal-delete-audiometri').modal('show');
        $('#modal-delete-audiometri input[type=text], #modal-filter select').val('');
    });

    $('#btn-delete').click(function() {
        // Show loder
        $('.page-loader').removeClass('hidden');

        // Send data
        $.ajax({
            url: '/database/audiometri-bulk-delete',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'idPasien': $('#modal-delete-audiometri #patient-id').val(),
                'idPerusahaan': $('#modal-delete-audiometri #customer').val(),
                'startDate': $('#modal-delete-audiometri #from-date').val(),
                'endDate': $('#modal-delete-audiometri #to-date').val()
            },
            success: function(resp) {
                if(resp.responseCode === 200) {
                    // Reload datatable
                    audiometriDataTable.ajax.reload();
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
						msg :  xhr.statusText
					});
                // Hide loder
                $('.page-loader').addClass('hidden');
            }
        });
    });

    // Open Modal Import Audiometri
    $('body').on('click', '#btn-import-audiometri', function(){
        $('#modal-import-audiometri').modal('show');
        $('#modal-import-audiometri .modal-title').html('@lang("general.import") @lang("audiometri.audiometri")');
        $('#modal-import-audiometri input[type=text],#modal-audiometri input[type=hidden],#modal-audiometri input[type=password],#modal-audiometri input[type=email],#modal-audiometri input[type=number]').val('');
    });

    // Add New Or Update Program
    $('#btn-submit').click(function(){

        // Update when audiometri id has value
        var url = baseUrl + '/database/audiometri/update';
        var action = "POST";
        if(!$('#audiometri-id').val()) {
            url = baseUrl + '/database/audiometri/save';
            action = "POST";
        }

        // Has error
        // var hasError = false;
        // Check requirement input
        if(!$('#id-pasien').val()) {
                    Lobibox.notify('error', {
						sound: true,
						icon: true,
						msg :  'ID Pasien can\'t be empty',
					});
            $('#id-pasien').focus();
            return;
        }
        if(!$('#perusahaan').val()) {
                    Lobibox.notify('error', {
						sound: true,
						icon: true,
						msg :  'Perusahaan can\'t be empty',
					});
            $('#perusahaan').focus();
            return;
        }
        if(!$('#tgl-input').val()) {
                Lobibox.notify('error', {
						sound: true,
						icon: true,
						msg :   'Tanggal Input can\'t be empty',
					});
            $('#tgl-input').focus();
            return;
        }
        if(!$('#frekuensi').val()) {
          
            Lobibox.notify('error', {
						sound: true,
						icon: true,
						msg :  'Frekuensi can\'t be empty',
					});
            $('#frekuensi').focus();
            return;
        }
        if(!$('#kanan').val()) {
          
            Lobibox.notify('error', {
						sound: true,
						icon: true,
						msg :  'Kanan can\'t be empty',
					});
            $('#kanan').focus();
            return;
        }
        if(!$('#kiri').val()) {
            Lobibox.notify('error', {
						sound: true,
						icon: true,
						msg : 'Kiri can\'t be empty',
					});
            $('#kiri').focus();
            return;
        }

        // Show loder
        $('.page-loader').removeClass('hidden');

        // Send data
        $.ajax({
            url: url,
            type: action,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'id': $('#audiometri-id').val(),
                'idPasien': $('#id-pasien').val(),
                //'idPerusahaan': $('#perusahaan').val(),
                'tglInput': $('#tgl-input').val(),
                'frekuensi': $('#frekuensi').val(),
                'kiri': $('#kiri').val(),
                'kanan': $('#kanan').val()
            },
            success: function(resp) {
                if(resp.responseCode === 200) {
                    // Reload datatable
                    audiometriDataTable.ajax.reload();
                    // Reset Form
                    $('#modal-audiometri input[type=text],#modal-audiometri input[type=password],#modal-audiometri input[type=email],#modal-audiometri input[type=number]').val('');
                    // Close modal
                    $('#modal-audiometri').modal('hide');
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

    // Edit audiometri
    $('#audiometri-table').on('click', '.btn-edit', function() {
        $('#modal-audiometri').modal('show');
        $('#modal-audiometri .modal-title').html('@lang("audiometri.edit_audiometri")');

        // Hide loder
        $('.page-loader').removeClass('hidden');

        // Get data
        // Send data
        $.ajax({
            url: baseUrl + '/database/audiometri/detail/' + $(this).data('id'),
            type: 'GET',
            success: function(resp) {
                $('#audiometri-id').val(resp.id);
                $('#id-pasien').val(resp.id_pasien);
                $('#perusahaan').val(resp.id_perusahaan).trigger('change');
                $('#tgl-input').val(resp.input_date);
                $('#frekuensi').val(resp.frekuensi);
                $('#kanan').val(resp.kanan);
                $('#kiri').val(resp.kiri);

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

    // Delete audiometri
    $('#audiometri-table').on('click', '.btn-delete', function() {

        if(!confirm('Area you sure want to delete this data?')) {
            return;
        }

        // Send data
        $.ajax({
            url: baseUrl + '/database/audiometri/delete/' + $(this).data('id'),
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp) {

                // Reload datatable
                audiometriDataTable.ajax.reload();
                Lobibox.notify('success', {
						sound: true,
						icon: true,
						msg :resp.responseMessage,
					});
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


    // Import Audiometri
    $('#btn-import').click(function(){

        if(!$('#file').val()) {
            Lobibox.notify('warning', {
						sound: true,
						icon: true,
						msg :  'Please select file to upload',
					});
            return;
        }

        if($('#file')[0].files[0].name.indexOf('audiom') < 0)
        {
            Lobibox.notify('warning', {
                sound: true,
                icon: true,
                msg : 'Please select file name template_audiometri to upload',
            });
            return;

        }

        // Create form data
        var form = new FormData();
        form.append('file', $('#file')[0].files[0]);

        // Show loader
        $('.page-loader').removeClass('hidden');
        $.ajax({
            url: baseUrl + '/database/audiometri-import',
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
                        msg :  xhr.statusText,
                    });
                $('.page-loader').addClass('hidden');
            }
        });
    });

    // Check process
    /*function checkProcess(id)
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

                audiometriDataTable.ajax.reload();

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
