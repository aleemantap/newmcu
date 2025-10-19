@extends('layouts.app')
@section('css')
    @include('layouts.datatableCss')    
@endsection
@section('ribbon')   
    <ul class="breadcrumbs pull-left">
        <li><a href="/home">Home</a></li>
        <li><span>{{  $title_page_left }}</span></li>
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
                            <table  id="drug-screening-table" class="table table-striped table-borderless" width="100%">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th style="width:20px;">No</th>
                                        <th>Id Pasien</th>
                                        <th>Tanggal Pemeriksaan</th>
                                        <th>Parameter</th>
                                        <th>Status Pemeriksaan</th>
                                        <th>Hasil</th>
                                        <th>Tanggal Input</th>
                                        <th class="action"><i class="fa fa-ellipsis-v"></i></th>
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
    @include('pages.drug-screening.new-drugscreening')
    @include('pages.drug-screening.import-drugscreening')
    @include('pages.drug-screening.export-drugscreening')
    @include('pages.drug-screening.filter')
    @include('pages.drug-screening.bulk-delete')
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
    var drugScreeningDataTable = $('#drug-screening-table').DataTable({
        dom: '<"dt-toolbar"<"col-md-3 col-sm-12 hidden-sm float-left"l><"col-md-9 col-sm-12 hidden-sm float-right"<"toolbar">>>rt<"dt-toolbar-footer"<"col-md-5 col-sm-12"i><"col-md-6 col-md-12 hidden-sm"p>><"clear">',
        processing: false,
        serverSide: true,
        scrollX: true,
        pageLength: 15,
        lengthMenu: [[15, 25, 50, 100], [15, 25, 50, 100]],
        pagingType: 'full_numbers',
        ajax: {
            url: baseUrl+"/database/drug-screening-datatables",
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
        'columnDefs': [
            {
                'targets': 0,
                'searchable':false,
                'orderable':false,
                'checkboxes': {
                    'selectRow': true
                }
            },
            {
                'target': 1,
                'searchable':false,
                'orderable':false,
                'visible': false
            }
        ],
        'select': {
            'style': 'multi'
        },
        //rowId: 'TRANSPORT_ID',
        columns: [
            {data: "DT_RowIndex", sortable: false, searchable: false},
            {data: "id_pasien", name: "id_pasien"},
            {data: "tgl_pemeriksaan", name: "Ttgl_pemeriksaan"},
            {data: "parameter_drug_screening", name: "parameter"},
            {data: "status_pemeriksaan", name: "status_pemeriksaan"},
            {data: "hasil_drug_screening", name: "Hasil"},
            {data: "tgl_input", name: "tgl_input"},
            {data: "action", sortable: false, searchable: false, class: "action"}
        ]
    });

    $("div.toolbar").html(`
        <button id='btn-filter-clear-drugscreening' title='Filter' class='btn btn-default hidden btn-flat'><i class='fa fa-filter'></i> Remove Filter</button>&nbsp;
        <button id='btn-filter-drugscreening' title='Filter' class='btn btn-default btn-flat'><i class='fa fa-filter'></i></button>&nbsp;
        <button id='btn-import-drugscreening' title='Upload' class='btn btn-default btn-flat'><i class='fa fa-upload'></i></button>&nbsp;
        <button id='btn-export-drugscreening' title='@lang('general.download')' class='btn btn-default btn-flat'><i class='fa fa-download'></i></button>&nbsp;
        <button id='btn-delete-drugscreening' title='@lang('general.bulk_delete')' class='btn btn-danger btn-flat'><i class='fa fa-trash'></i> @lang('general.bulk_delete')</button>&nbsp;
        <button id='btn-add-drugscreening' class='btn btn-primary btn-flat'><i class='fa fa-plus-circle'></i> @lang('general.add')</button>&nbsp;
    `);

    // Add drugscreening
    $('body').on('click', '#btn-add-drugscreening', function(){
        $('#modal-drugscreening').modal('show');
        $('#modal-drugscreening .modal-title').html('New Drug Screening');
        $('#modal-drugscreening input[type=text],#modal-drugscreening input[type=hidden],#modal-drugscreening input[type=password],#modal-drugscreening input[type=email],#modal-drugscreening input[type=number]').val('');
    });

    // Filter drugscreening
    $('body').on('click', '#btn-filter-drugscreening', function(){
        $('#modal-filter').modal('show');
    });

    // Remove Filter
    $('body').on('click', '#btn-filter-clear-drugscreening', function(){
        $('#modal-filter input, #modal-filter select').val('').trigger('change');
        drugScreeningDataTable.draw(true)
        $('#btn-filter-clear-drugscreening').addClass('hidden');
    });

    $('#btn-filter').click(function() {
        $('#modal-filter').modal('hide');
        drugScreeningDataTable.draw(true);
        $('#btn-filter-clear-drugscreening').removeClass('hidden');
    });

     // Download Drug Screening
     $('body').on('click', '#btn-export-drugscreening', function(){
        $('#modal-export').modal('show');
        $('#modal-export input[type=text], #modal-filter select').val('');
    });

    // Bulk Delete Radiology
    $('body').on('click', '#btn-delete-drugscreening', function(){
        $('#modal-delete-drugscreening').modal('show');
        $('#modal-delete-drugscreening input[type=text], #modal-filter select').val('');
    });

    $('#btn-delete').click(function() {
        // Show loder
        $('.page-loader').removeClass('hidden');

        // Send data
        $.ajax({
            url: '/database/drug-screening-bulk-delete',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'idPasien': $('#modal-delete-drugscreening #patient-id').val(),
                'idPerusahaan': $('#modal-delete-drugscreening #customer').val(),
                'startDate': $('#modal-delete-drugscreening #from-date').val(),
                'endDate': $('#modal-delete-drugscreening #to-date').val()
            },
            success: function(resp) {
                if(resp.responseCode === 200) {
                    // Reload datatable
                    drugScreeningDataTable.ajax.reload();
                    // Reset Form
                    $('#modal-delete-drugscreening input,#modal-delete-drugscreening select').val('');
                    // Close modal
                    $('#modal-delete-drugscreening').modal('hide');
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
                        msg :  xhr.statusText,
                    });
                // Hide loder
                $('.page-loader').addClass('hidden');
            }
        });
    });

    // Open Modal Import drugscreening
    $('body').on('click', '#btn-import-drugscreening', function(){
        $('#modal-import-drugscreening').modal('show');
        $('#modal-import-drugscreening .modal-title').html('Import Drug Screening');
        $('#modal-import-drugscreening input[type=text],#modal-drugscreening input[type=hidden],#modal-drugscreening input[type=password],#modal-drugscreening input[type=email],#modal-drugscreening input[type=number]').val('');
    });

    // Add New Or Update Program
    $('#btn-submit').click(function(){

        // Update when drugscreening id has value
        var url = baseUrl + '/database/drug-screening/update';
        var action = "update";
        if(!$('#drugscreening-id').val()) {
            url = baseUrl + '/database/drug-screening/save';
            action = "save";
        }

        // Has error
        // var hasError = false;
        // Check requirement input
        if(!$('#id-pasien').val()) {
           
            Lobibox.notify('error', {
                        sound: true,
                        icon: true,
                        msg :  'ID Pelanggan can\'t be empty',
                    });
            $('#id-pasien').focus();
            return;
        }
        if(!$('#perusahaan').val()) {
           
            Lobibox.notify('error', {
                        sound: true,
                        icon: true,
                        msg : 'Perusahaan can\'t be empty',
                    });
            $('#perusahaan').focus();
            return;
        }
        if(!$('#tgl-input').val()) {
            Lobibox.notify('error', {
                        sound: true,
                        icon: true,
                        msg : 'Tanggal input can\'t be empty',
                    });
            $('#tgl-input').focus();
            return;
        }
        if(!$('#tgl-pemeriksaan').val()) {
            Lobibox.notify('error', {
                        sound: true,
                        icon: true,
                        msg : 'Tanggal Pemeriksaan can\'t be empty',
                    });
            $('#tgl-pemeriksaan').focus();
            return;
        }
        if(!$('#status-pemeriksaan').val()) {
            Lobibox.notify('error', {
                        sound: true,
                        icon: true,
                        msg :  'Status Pemeriksaan can\'t be empty',
                    });
            $('#status-pemeriksaan').focus();
            return;
        }
        if(!$('#parameter').val()) {
            Lobibox.notify('error', {
                        sound: true,
                        icon: true,
                        msg :  'Parameter can\'t be empty',
                    });
            $('#parameter').focus();
            return;
        }
        if(!$('#hasil').val()) {
            Lobibox.notify('error', {
                        sound: true,
                        icon: true,
                        msg :  'Hasil can\'t be empty',
                    });
            $('#hasil').focus();
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
                'id': $('#drugscreening-id').val(),
                'idPasien': $('#id-pasien').val(),
                'idPerusahaan': $('#perusahaan').val(),
                'tglInput': $('#tgl-input').val(),
                'tglPemeriksaan': $('#tgl-pemeriksaan').val(),
                'statusPemeriksaan': $('#status-pemeriksaan').val(),
                'parameter': $('#parameter').val(),
                'hasil': $('#hasil').val(),
            },
            success: function(resp) {
                if(resp.responseCode === 200) {
                    // Reload datatable
                    drugScreeningDataTable.ajax.reload();
                    // Reset Form
                    $('#modal-drugscreening input[type=text],#modal-drugscreening input[type=password],#modal-drugscreening input[type=email],#modal-drugscreening input[type=number]').val('');
                    // Close modal
                    $('#modal-drugscreening').modal('hide');
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
                        msg :resp.responseMessage,
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

    // Edit drugscreening
    $('#drug-screening-table').on('click', '.btn-edit', function() {
        $('#modal-drugscreening').modal('show');
        $('#modal-drugscreening .modal-title').html('Edit Drug Screening');

        // Hide loder
        $('.page-loader').removeClass('hidden');

        // Get data
        // Send data
        $.ajax({
            url: baseUrl + '/database/drug-screening/detail/' + $(this).data('id'),
            type: 'GET',
            success: function(resp) {
                $('#drugscreening-id').val(resp.id);
                $('#id-pasien').val(resp.id_pasien);
                $('#tgl-input').val(resp.input_date);
                $('#perusahaan').val(resp.id_perusahaan).trigger('change');
                $('#tgl-pemeriksaan').val(resp.tgl_pemeriksaan);
                $('#status-pemeriksaan').val(resp.status_pemeriksaan);
                $('#parameter').val(resp.parameter_drug_screening);
                $('#hasil').val(resp.hasil_drug_screening);

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

    // Delete Drug Screening
    $('#drug-screening-table').on('click', '.btn-delete', function() {

        if(!confirm('Area you sure want to delete this data?')) {
            return;
        }

        // Send data
        $.ajax({
            url: baseUrl + '/database/drug-screening/delete/' + $(this).data('id'),
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(resp) {

                // Reload datatable
                drugScreeningDataTable.ajax.reload();
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


    // Import drugscreening
    $('#btn-import').click(function(){
        if(!$('#file').val()) {
            Lobibox.notify('error', {
                        sound: true,
                        icon: true,
                        msg : 'Please select file to upload',
                    });

            return;
        }

        if($('#file')[0].files[0].name.indexOf('drug') < 0)
        {
            Lobibox.notify('error', {
                        sound: true,
                        icon: true,
                        msg : 'Please select file name template_drug_screening to upload',
                    });

            return;

        }

        // Create form data
        var form = new FormData();
        form.append('file', $('#file')[0].files[0]);

        // Show loader
        $('.page-loader').removeClass('hidden');
        $.ajax({
            url: baseUrl + '/database/drug-screening-import',
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

                drugScreeningDataTable.ajax.reload();

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
    
    /*
    function checkProcessx(id)
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
    }*/

    // Check if current process is running
    @if($process)
        checkProcess({{ $process->id }});
    @endif

});

</script>
@endsection


@section('css')
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/bootstrap-datepicker.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/jquery-ui.css') }}">
<style>
    .datepicker{
        z-index:1151;
    }

    .datepicker {
        transform: translate(0, 3.1em);
    }
</style>
@endsection
