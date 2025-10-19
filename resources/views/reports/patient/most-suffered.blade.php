@extends('layouts.app')
@section('css')
    @include('layouts.datatableCss')    
@endsection
@section('ribbon')
<ul class="breadcrumbs pull-left">
    <li><a href="#">Report</a></li>
    <li><a href="#">Pasien</a></li>
    <li><span>Diagosa Terbanyak</span></li>
</ul>
@endsection
@section('title', $title_page_left)
@section('content')
<div class="mt-5">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <div class="form-filter">
                        <a class="hide" href="#"><i class="fa fa-chevron-down sign"></i> <span class="filter-title">Show</span><span class="filter-title hidden">Hide</span> Filter <i class="fa fa-filter"></i></a>
                        <a class="clear" href="#" style="float:right;"><i class="fa fa-stop"></i>&nbsp;Clear Filter</a>
                        <hr/>
                        <form action="" class="form-horizontal">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.input_date')</label>
                                        <div class="col-md-8">
                                            <div class="input-group input-daterange">
                                                <input type="text" class="form-control form-control-sm input-xs" id="from-date" data-provide="datepicker" style="border-right-width: 1px">
                                                <div class="input-group-addon">&nbsp;-&nbsp;</div>
                                                <input type="text" class="form-control form-control-sm input-xs" id="to-date" data-provide="datepicker">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- When login as admi -->
                                @if(empty(session()->get('user.customer_id')) and empty(session()->get('user.vendor_id')))
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('vendor.vendor')</label>
                                        <div class="col-md-8">
                                            <select class="form-control input-xs" id="vendor">
                                                <option value="">&raquo; @lang('general.all') @lang('vendor.vendor')</option>
                                                @if(!empty($vendors))
                                                    @foreach($vendors as $vendor)
                                                    <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('customer.customer')</label>
                                        <div class="col-md-8">
                                            <select class="form-control input-xs" id="perusahaan">
                                            <option value="">&raquo; @lang('general.all') @lang('customer.customer')</option>
                                                @if(!empty($customers))
                                                @foreach($customers as $c)
                                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- When login as vendor -->
                                @if(!empty(session()->get('user.vendor_id')))
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('customer.customer')</label>
                                        <div class="col-md-8">
                                            <select class="form-control input-xs" id="perusahaan">
                                                    <option value="">&raquo; @lang('general.all') @lang('customer.customer')</option>
                                                    @if(!empty($customers))
                                                        @foreach($customers as $c)
                                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                                        @endforeach
                                                    @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <!-- End login as customer -->

                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.client')</label>
                                        <div class="col-md-8">
                                            <select class="form-control input-xs" id="client">
                                                <option value="">&raquo; @lang('general.all') @lang('mcu.client')</option>
                                                @if(!empty($clients))
                                                    @foreach($clients as $client)
                                                    <option value="{{ $client->client }}">{{ $client->client }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.medical_id')</label>
                                        <div class="col-md-8"><input type="text" class="form-control form-control-sm" id="id-pasien"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.employee_id')</label>
                                        <div class="col-md-8"><input type="text" class="form-control form-control-sm" id="no-nip"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.patient_name')</label>
                                        <div class="col-md-8"><input type="text" class="form-control form-control-sm" id="nama"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.dob')</label>
                                        <div class="col-md-8"><input type="text" class="form-control form-control-sm datepicker" id="tgl-lahir"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.gender')</label>
                                        <div class="col-md-8">
                                            <select class="form-control input-xs" id="lp">
                                                <option value="">&raquo; @lang('general.all') @lang('mcu.gender')</option>
                                                <option value="L">@lang('mcu.male')</option>
                                                <option value="P">@lang('mcu.female')</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('mcu.department')</label>
                                        <div class="col-md-8">
                                            <select class="form-control input-xs" id="bagian">
                                                <option value="">&raquo; @lang('general.all') @lang('mcu.department')</option>
                                                @if(!empty($departments))
                                                    @foreach($departments as $department)
                                                    <option value="{{ $department->bagian }}">{{ $department->bagian }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group row">
                                        <label class="col-md-2"></label>
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-xs btn-primary btn-block" id="btn-filter-submit"><i class="fa fa-check-circle"></i> Submit</button>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" id="btn-su-submit" class="btn btn-xs btn-default btn-block"><i class="fa fa-download"></i> @lang('general.download')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="mb-3">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <table id="user-table" class="table table-striped table-borderless" width="100%">
                        <thead>
                            <tr>
                                <th style="width:20px;">No</th>
                                
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

@section('script')

<script src="{{ asset('assets/js/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

{{-- <script src="{{ asset('js/plugin/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script> --}}
<script>
$(document).ready(function () {

    $('select').select2({
        width: '100%',
        containerCssClass: 'select-xs'
    });

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: 'true'
    });

    $('.input-daterange').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: 'true'
    });

    // Toggle filter
    // Toggle filter
    $('.form-filter a.hide').click(function() {
      
        $(this).toggleClass('open');
        $('.filter-title').toggleClass('hidden');
        $('.form-filter form').toggleClass('open-filter');
    });

	
	$('#btn-su-submit').click(function() {
		
		var data = new FormData();
		data.append('idPasien',$('#id-pasien').val());
		data.append('nama',$('#nama').val());
		data.append('nip',$('#no-nip').val());
		data.append('tglLahir',$('#tgl-lahir').val());
		data.append('lp',$('#lp').val());
		data.append('bagian',$('#bagian').val());
		data.append('idPerusahaan',$('#perusahaan').val());
		data.append('idVendor',$('#vendor').val());
		data.append('client',$('#client').val());
		data.append('startDate',$('#from-date').val());
		data.append('endDate',$('#to-date').val());
		
		$.ajax({
            url: baseUrl+"/report/patient/most-suffered/export",
            type: 'POST',
			contentType: false,
			processData: false,
			cache: false,
			xhrFields: {
                responseType: 'blob'
            },
			headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
			data: data,
			success: function (data, textStatus, xhr) {
                // check for a filename
                var filename = "";
                var disposition = xhr.getResponseHeader('Content-Disposition');
                if (disposition && disposition.indexOf('attachment') !== -1) {
                    var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                    var matches = filenameRegex.exec(disposition);
                    if (matches != null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                    var a = document.createElement('a');
                    var url = window.URL.createObjectURL(data);
                    a.href = url;
                    a.download = filename;
                    document.body.append(a);
                    a.click();
                    a.remove();
                    window.URL.revokeObjectURL(url);
                }
                else {
                    alert("Error");
                }
                //i = i + 1;
                //if (i < max) {
                //    DownloadFile(list);
                //}
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {

            },
			
        });
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
    var dataTable = $('#user-table').DataTable({
        dom: '<"dt-toolbar"<"col-md-3 col-sm-12 hidden-sm float-left"l><"col-md-9 col-sm-12 hidden-sm float-right"<"toolbar">>>rt<"dt-toolbar-footer"<"col-md-5 col-sm-12"i><"col-md-6 col-md-12 hidden-sm"p>><"clear">',
        processing: true,
        serverSide: true,
        scrollX: true,
        order: [[7, "desc"]],
        pageLength: 15,
        lengthMenu: [[15, 25, 50, 100], [15, 25, 50, 100]],
        pagingType: 'full_numbers',
        ajax: {
            url: baseUrl+"/report/patient/most-suffered-datatables",
            type: 'GET',
            data:  function(d){
                d.idPasien = $('#id-pasien').val();
                d.nama = $('#nama').val();
                d.nip = $('#no-nip').val();
                d.tglLahir = $('#tgl-lahir').val();
                d.lp = $('#lp').val();
                d.bagian = $('#bagian').val();
                d.idPerusahaan = $('#perusahaan').val();
                d.idVendor = $('#vendor').val();
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
            }
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
            {data: "tgl_input", name: "tgl_input"},
            {data: "diagnosis_count", name: "diagnosis_count"},
            {data: "id", sortable: false, searchable: false, class: "action"}
        ],
        columnDefs:[
            {
                targets: 8,
                render: function(d) {
					
                    return `<a href="/report/patient/medical-check-up/detail/`+d+`" class="btn btn-action btn-primary btn-xs" data-id='+d.id+'><i class="fa fa-ellipsis-h"></i></a> &nbsp;
                            <a data-id='+d.id+' target="_blank" href="/report/patient/medical-check-up/print/`+d+`" class="btn btn-action btn-default btn-xs"><i class="fa fa-print"></i></a>`;
                }
            }
        ]
    });

    $('.form-filter a.clear').click(function() {
        $('.form-horizontal')[0].reset();
       
         $('.form-horizontal').find('select.form-control').val(null).trigger("change");
         dataTable.draw(true);
    })

    $('body').on('click', '#btn-filter', function() {
        $('#modal-filter').modal('show');
    });

    // Remove Filter Mcu
    $('body').on('click', '#btn-filter-clear', function(){
        $('#modal-filter input, #modal-filter select').val('').trigger('change');
        dataTable.draw(true);
        $('#btn-filter-clear').addClass('hidden');
    });

    $('#btn-filter-submit').click(function() {
        $('#modal-filter').modal('hide');
        dataTable.draw(true);
        $('#btn-filter-clear').removeClass('hidden');
    });

    $('#perusahaan').on('change', function() {
        // Get departments
        $.getJSON(baseUrl+'/department/'+$(this).val(), function(resp) {
            $('#bagian').html('<option value="">&raquo; Semua Bagian</option>').trigger('change');
            $.each(resp, function(i, o) {
                $('#bagian').append('<option value="'+o.bagian+'">'+o.bagian+'</option>');
            });
        });

        // Get clients
        $.getJSON(baseUrl+'/client/'+$(this).val(), function(resp) {
            $('#client').html('<option value="">&raquo; Semua Client</option>').trigger('change');
            $.each(resp, function(i, o) {
                $('#client').append('<option value="'+o.client+'">'+o.client+'</option>');
            });
        });
    });

});

</script>
@endsection
