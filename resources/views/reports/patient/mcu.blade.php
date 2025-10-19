@extends('layouts.app')
@section('css')
    @include('layouts.datatableCss')    
@endsection
@section('ribbon')
    <ul class="breadcrumbs pull-left">
        <li><a href="#">Pasien</a></li>
        <li><span>Medical Check Up</span></li>
    </ul>
@endsection
@section('title', $title_page_left)
@section('content')
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="form-filter">
                        <a class="hide" href="#"><i class="fa fa-chevron-down sign"></i> <span class="filter-title">Show</span><span class="filter-title hidden">Hide</span> Filter <i class="fa fa-filter"></i></a>
                        <a class="clear" href="#" style="float:right;"><i class="fa fa-stop"></i>&nbsp;Clear Filter</a>
                        
                        <hr/>
                        <form action="" class="form-horizontal" >
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <input type="hidden" class="form-control input-xs" id="rontgen-id">
                                        <label for="" class="control-label col-md-4">@lang('mcu.input_date')</label>
                                        <div class="col-md-8">
                                            <div class="input-group input-daterange">
                                                <input type="text" class="form-control form-control-sm" id="from-date" data-provide="datepicker" style="border-right-width: 1px">
                                                <div class="input-group-addon">&nbsp;-&nbsp;</div>
                                                <input type="text" class="form-control form-control-sm" id="to-date" data-provide="datepicker">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- When login as admin -->
                                @if(empty(session()->get('user.customer_id')) and empty(session()->get('user.vendor_id')))
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('customer.customer')</label>
                                        <div class="col-md-8">
                                            <select class="form-control form-control-sm" id="perusahaan">
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
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('vendor.vendor')</label>
                                        <div class="col-md-8">
                                            <select class="form-control form-control-sm" id="vendor">
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
                                @endif
                                <!-- End login as admin -->

                                <!-- When login as vendor -->
                                @if(!empty(session()->get('user.vendor_id')))
                                    <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">@lang('customer.customer')</label>
                                        <div class="col-md-8">
                                            <select class="form-control form-control-sm" id="perusahaan">
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

                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Client</label>
                                        <div class="col-md-8">
                                            <select class="form-control form-control-sm" id="client">
                                                <option value="">&raquo; Semua Client</option>
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
                                        <label for="" class="control-label col-md-4">Id Pasien</label>
                                        <div class="col-md-8"><input type="text" class="form-control form-control-sm" id="id-pasien"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">No. NIP</label>
                                        <div class="col-md-8"><input type="text" class="form-control form-control-sm" id="no-nip"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Nama</label>
                                        <div class="col-md-8"><input type="text" class="form-control form-control-sm" id="nama"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Tgl. Lahir</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control form-control-sm datepicker" data-provide="datepicker" id="tgl-lahir">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">L/P</label>
                                        <div class="col-md-8">
                                            <select class="form-control input-xs" id="lp">
                                                <option value="">&raquo; Semua L/P</option>
                                                <option value="L">L</option>
                                                <option value="P">P</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Bagian</label>
                                        <div class="col-md-8">
                                            <select class="form-control input-xs" id="bagian">
                                                <option value="">&raquo; Semua Bagian</option>
                                                @if(!empty($departments))
                                                    @foreach($departments as $department)
                                                    <option value="{{ $department->bagian }}">{{ $department->bagian }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="col-md-4"></label>
                                        <div class="col-md-8">
                                            <button type="button" class="btn btn-xs btn-primary btn-block" id="btn-filter-submit"><i class="fa fa-check-circle"></i> Submit</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="col-md-4"></label>
                                        <div class="col-md-8">
                                            <button type="button" id="btn-download-mcu" class="btn btn-xs btn-default btn-block"><i class="fa fa-download"></i> @lang('general.download')</button>
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- compare -->
                    <div class="form-compare">
                        <div class="row">
                            <div class="col-md-12">
                                <form class="form-horizontal" method="POST" action="{{url('report/patient/compare-medical-check-up')}}">
                                    @csrf
                                    <div class="compare-titles">
                                        <button id="btn-compare" type="submit" class="btn btn-xs btn-success pull-right"><i class="fa fa-check-circle"></i> @lang('general.compare')</button>
                                    </div>
                                    <div class="compare-values"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>

            

        </div>
    </div>

    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <table id="datatable" class="table table-striped table-borderless" width="100%">
                        <thead>
                            <tr>
                                <th style="width:20px;">No</th>
                                <th>No. NIP</th>
                                <th>Name</th>
                                <th>Tgl. Lahir </th>
                                <th>L/P</th>
                                <th>Bagian</th>
                                <th>Tgl. MCU</th>
                                <th>Compare</th>
                                <th style="width: 190px">Action</th>
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
@section('script')

    {{-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" /> --}}

<script src="{{ asset('assets/js/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


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

    // $(".datepicker-days").attr("padding", "5px !important");

    // Toggle filter
    $('.form-filter a.hide').click(function() {
      
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
    var dataTable = $('#datatable').DataTable({
        dom: '<"dt-toolbar"<"col-md-3 col-sm-12 hidden-sm float-left"l><"col-md-9 col-sm-12 hidden-sm float-right"<"toolbar">>>rt<"dt-toolbar-footer"<"col-md-5 col-sm-12"i><"col-md-6 col-md-12 hidden-sm"p>><"clear">',
        processing: true,
        serverSide: true,
        scrollX: true,
        pageLength: 15,
        lengthMenu: [[15, 25, 50, 100], [15, 25, 50, 100]],
        pagingType: 'full_numbers',
        ajax: {
            url: baseUrl+"/report/patient/medical-check-up-datatables",
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
            {data: "id", sortable: false, searchable: false, class: "action"}
        ],
        columnDefs:[
			{
                targets: 7,
                render: function(d) {
                    return '<a title="Compare" data-id="'+d+'" class="btn btn-action btn-primary btn-xs btn-add-compare"><i class="fa fa-plus-circle text-light"></i></a> &nbsp;';         
                          
                }
            },
            {
                targets: 8,
                render: function(data, type, row, meta) {
                    var d = row.id;
                    return '<div class="d-flex justify-content-between"><a title="Detail" href="/report/patient/medical-check-up/detail/'+d+'" class="btn btn-action btn-primary btn-xs" data-id="'+d+'"><i class="fa fa-ellipsis-h"></i></a>'+
                            '<a title="Print" target="_blank" href="/report/patient/medical-check-up/print/'+d+'" data-id='+d+' class="btn btn-action btn-outline-dark btn-xs"><i class="fa fa-print"></i></a>'+
                            '<a title="Print2" target="_blank" href="/report/patient/medical-check-up/print2/'+d+'" data-id='+d+' class="btn btn-action btn-outline-dark btn-xs"><i class="fa fa-print" style="color:red;"></i></a>'+
                            '<a title="Download" href="/report/patient/medical-check-up/print-download/'+d+'" data-id='+d+' class="btn btn-action btn-outline-dark btn-xs"><i class="fa fa-file-pdf-o" style="font-size:14px"></i></a>'+
                            '<a title="Download2" href="/report/patient/medical-check-up/print-download2/'+d+'" data-id='+d+' class="btn btn-action btn-outline-dark btn-xs"><i class="fa fa-file-pdf-o" style="font-size:14px;color:red;"></i></a></div>';
                           
                          
                }
            }
        ]
    });

    $('.form-filter a.clear').click(function() {
        $('.form-horizontal')[0].reset();
       
         $('.form-horizontal').find('select.form-control').val(null).trigger("change");
         dataTable.draw(true);
    })


    $('#btn-filter-submit').click(function() {
        dataTable.draw(true);
    });
	
	$('#btn-download-mcu').click(function() {
		
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
            url: baseUrl+"/report/patient/medical-check-up/export",
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

    // Add to compare item
    $('#datatable').on('click', '.btn-add-compare', function(){
        // Show compare form
        $('.form-compare').addClass('show');

        // Define currentn items
        var items = [];
        $('.form-compare .compare-values input').each(function(i, o) {
            items.push($(o).val());
        });

        // Check if item is exits
        if(items.includes($(this).data('id'))) {
            return false;
        }

        // Max item is 3
        if($('.compare-titles .title').length == 3) {
            $.smallBox({
                height: 50,
                title : "Warning",
                content : "Maximal item to compare only 3 items",
                color : "#c79121",
                sound_file: "smallbox",
                timeout: 3000
            });
            return false;
        }

        var id = $(this).data('id');
        $('.form-compare .compare-titles').append(`<div class="title badge badge`+id+`">`+id+`<span class="remove" data-badge="badge`+id+`"><i class="fa fa-close"></i><span></div>`);
        $('.form-compare .compare-values').append(`<input class="badge`+id+`" type="hidden" value="`+id+`" name="id[]">`);

        var count = $('.compare-titles .title').length;
        if(count > 1) {
            $('.compare-titles button').removeClass('hidden');
        } else {
            $('.compare-titles button').addClass('hidden');
        }
    });

    // Remove compare item
    $('.compare-titles').on('click', '.remove', function(){
        var badge = $(this).data('badge');
        $('.'+badge).remove();
        var count = $('.compare-titles .title').length;

        if(count == 0) {
            $('.form-compare').removeClass('show');
        }

        if(count > 1) {
            $('.compare-titles button').removeClass('hidden');
        } else {
            $('.compare-titles button').addClass('hidden');
        }
    });

});


</script>
@endsection
