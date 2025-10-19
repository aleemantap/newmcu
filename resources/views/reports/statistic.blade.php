@extends('layouts.app')
@section('css')
    @include('layouts.datatableCss')    
@endsection
@section('ribbon')
    <ul class="breadcrumbs pull-left">
        <li><a>Report</a></li>
        <li><a>Pasien</a></li>
        <li><span>Statistika</span></li>
    </ul>
@endsection
@section('title', $title_page_left)

@section('content')
<div class=" mt-3">
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
                                <!-- End login as vendor -->

                                <!-- When login as admin -->
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
                                <div class="col-md-8">
                                    <div class="form-group row">
                                        <label class="col-md-2"></label>
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-xs btn-primary btn-block" id="btn-filter-submit"><i class="fa fa-check-circle"></i> @lang('general.submit')</button>
                                        </div>
                                        <div class="col-md-4">
                                            <!--
                                            <button type="button" class="btn btn-xs btn-default btn-block"><i class="fa fa-download"></i> @lang('general.download')</button>
                                            -->
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
<div class=" mt-1">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <div style="padding: 30px">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="statistic-section-title"><i class="fa fa-th-large"></i> Statistic by Sex</div>
                                <div id="graph-sex" style="height: 300px; width: 100%"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="statistic-section-title"><i class="fa fa-th-large"></i> Statistic by Age</div>
                                <div id="graph-age" style="height: 300px; width: 100%"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="statistic-section-title"><i class="fa fa-th-large"></i> Total Transaction Per Event Registration</div>
                                <div id="graph-event" style="height: 300px; width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="mt-3">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 ">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Packets</h4>
                    <table id="paket-table" class="table table-striped table-borderless" width="100%">
                        <thead>
                            <tr>
                                <th>Paket MCU</th>
                                <th style="width: 200px">Total</th>
                                <th style="width: 100px"><i class="fa fa-ellipsis-v"></i></th>
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

<div class="mt-3">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 ">
           
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Departmens</h4>
                    <table id="bagian-table" class="table table-striped table-borderless" width="100%">
                        <thead>
                            <tr>
                                <th>Department</th>
                                <th style="width: 200px">Total</th>
                                <th style="width: 100px"><i class="fa fa-ellipsis-v"></i></th>
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


<div class="mt-3 mb-3">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 ">
            <div class="card">
                <div class="card-body">
                        <h4 class="header-title">Clients</h4>
                        <table id="client-table" class="table table-striped table-borderless" width="100%">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th style="width: 200px">Total</th>
                            <th style="width: 100px"><i class="fa fa-ellipsis-v"></i></th>
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
    {{-- @include('pages.customer.new-customer') --}}
@endsection

@section('script')
<script src="{{ asset('assets/js/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
{{-- <script src="{{ asset('js/plugin/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script> --}}
{{-- <script src="{{ asset('js/plugin/highcharts/highcharts.js') }}"></script> --}}
{{-- <script src="{{ asset('js/plugin/highcharts/highcharts-3d.js') }}"></script> --}}
<script>
$(document).ready(function () {
	//$('#teangan1').val('');
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

    updateChart();

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
    var paketDataTable = $('#paket-table').DataTable({
        // dom: '<"dt-toolbar"<"col-md-6 col-xs-12 hidden-xs"f><"col-md-6 col-xs-12 hidden-xs text-right"<"paket-toolbar">>>rt<"dt-toolbar-footer"<"col-sm-6 col-xs-12"i><"col-sm-6  col-xs-12 hidden-xs"p>><"clear">',
        //dom: '<"dt-toolbar"<"col-sm-6 col-xs-12 hidden-xs"f><"col-sm-6 col-xs-12 hidden-xs text-right"<"paket-toolbar">>>rt<"dt-toolbar-footer"<"col-sm-6 col-xs-12"i><"col-sm-6 col-xs-12 hidden-xs"p>><"clear">',
        //dom: '<"dt-toolbar"<"col-md-3 col-sm-12 hidden-sm float-left"l><"col-md-9 col-sm-12 hidden-sm float-right"<"paket-toolbar">>>rt<"dt-toolbar-footer"<"col-md-5 col-sm-12"i><"col-md-6 col-md-12 hidden-sm"p>><"clear">',
       // dom: '<"dt-toolbar"<"col-sm-6 col-xs-12 hidden-xs"f><"col-sm-6 col-xs-12 hidden-xs text-right"<"paket-toolbar">>>rt<"dt-toolbar-footer"<"col-sm-6 col-xs-12"i><"col-sm-6 col-xs-12 hidden-xs"p>><"clear">',
         dom: '<"dt-toolbar"<"col-md-3 col-sm-12 hidden-sm float-left"f><"col-md-9 col-sm-12 hidden-sm float-right"<"paket-toolbar">>>rt<"dt-toolbar-footer"<"col-md-5 col-sm-12"i><"col-md-6 col-md-12 hidden-sm"p>><"clear">',
       
        processing: true,
        serverSide: true,
        scrollX: true,
        order: [[1, "desc"]],
         pageLength: 15,
        lengthMenu: [[15, 25, 50, 100], [15, 25, 50, 100]],
        // "bPaginate": false,
        pagingType: 'full_numbers',
        ajax: {
            url: baseUrl+"/report/statistik-paket-datatables",
            type: 'GET',
            data:  function(d){
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
        // initComplete: function () {
        //      $('div.dt-search input').removeClass('form-control-sm');
        // },
        columns: [
            {data: "paket_mcu", name: "paket_mcu"},
            {data: "total", name: "total", searchable: false},
            {data: "paket_mcu", sortable: false, searchable: false, class: "action"}
        ],
        columnDefs:[
            {
                targets: 2,
                render: function(d, type, row) {
					
					var idPerusahaan = $('#perusahaan').val();
					var idVendor = $('#vendor').val();
					var client = $('#client').val();
					var startDate = $('#from-date').val();
					var endDate = $('#to-date').val();
					var filter = "{'perusahaan': '"+idPerusahaan+"', 'vendor': '"+idVendor+"', 'client': '"+client+"', 'startDate': '"+startDate+"', 'endDate': '"+endDate+"'}";
					return '<a href="/report/statistik-detail/paket/'+d+'/'+row.total+'/Statistika Umum/'+filter+'" class="btn btn-action btn-primary btn-xs" data-id="'+d.id+'"><i class="fa fa-ellipsis-h"></i></a>&nbsp;';
				  }
            }
        ]
    });
	
	$('.form-filter a.clear').click(function() {
        $('.form-horizontal')[0].reset();
       
         $('.form-horizontal').find('select.form-control').val(null).trigger("change");
         paketDataTable.draw(true);
         bagianDataTable.draw(true);
         clientDataTable.draw(true);
    })

	$("div.paket-toolbar").html("<a href='#' id='btn-filter-export-paket' class='btn btn-secondary export-paket'><i class='fa fa-download'></i></a>&nbsp;");


	$('body').on('click','#btn-filter-export-paket',function(){
		var orderPaket = paketDataTable.order();
		var idPerusahaan = $('#perusahaan').val();
		var idVendor = $('#vendor').val();
		var client = $('#client').val();
		var startDate = $('#from-date').val();
		var endDate = $('#to-date').val();
		
		//var cari =  $('input[type="search"]').val();//$('#teangan1').val();
		var cari = $('#paket-table_filter').find('input').val();
		var filterPaket = "perusahaan="+idPerusahaan+"&vendor="+idVendor+"&client="+client+"&startDate="+startDate+"&endDate="+endDate+"&search="+cari;
		var urlexportpaket = baseUrl+"/statistik-umum-paket-export/"+orderPaket+"/"+filterPaket;					
		window.location.href = urlexportpaket;
		//$('#teangan1').val('');
	});
	
    /**
     * Datatable initial
     */
    var bagianDataTable = $('#bagian-table').DataTable({
       // dom: '<"dt-toolbar"<"col-md-3 col-sm-12 hidden-sm float-left"l><"col-md-9 col-sm-12 hidden-sm float-right"<"bagian-toolbar">>>rt<"dt-toolbar-footer"<"col-md-5 col-sm-12"i><"col-md-6 col-md-12 hidden-sm"p>><"clear">',
         dom: '<"dt-toolbar"<"col-md-3 col-sm-12 hidden-sm float-left"f><"col-md-9 col-sm-12 hidden-sm float-right"<"bagian-toolbar">>>rt<"dt-toolbar-footer"<"col-md-5 col-sm-12"i><"col-md-6 col-md-12 hidden-sm"p>><"clear">',
       
        processing: false,
        serverSide: true,
        scrollX: true,
        order: [[1, "desc"]],
        pageLength: 15,
        lengthMenu: [[15, 25, 50, 100], [15, 25, 50, 100]],
        pagingType: 'full_numbers',
        ajax: {
            url:baseUrl+"/report/statistik-bagian-datatables",
            type: 'GET',
            data:  function(d){
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
            {data: "bagian", name: "bagian"},
            {data: "total", name: "total", searchable: false},
            {data: "bagian", sortable: false, searchable: false, class: "action"}
        ],
        columnDefs:[
            {
                targets: 2,
                render: function(d, type, row) {
					
					var idPerusahaan = $('#perusahaan').val();
					var idVendor = $('#vendor').val();
					var client = $('#client').val();
					var startDate = $('#from-date').val();
					var endDate = $('#to-date').val();
					var filter = "{'perusahaan': '"+idPerusahaan+"', 'vendor': '"+idVendor+"', 'client': '"+client+"', 'startDate': '"+startDate+"', 'endDate': '"+endDate+"'}";
					return '<a href="/report/statistik-detail/bagian/'+d+'/'+row.total+'/Statistika Umum/'+filter+'" class="btn btn-action btn-primary btn-xs" data-id="'+d.id+'"><i class="fa fa-ellipsis-h"></i></a>&nbsp;';
				 }
            }
        ]
    });

    $("div.bagian-toolbar").html('<a href="#" id="btn-export-bagian" class="btn btn-secondary"><i class="fa fa-download"></i></a>&nbsp;');
	
	$('body').on('click','#btn-export-bagian',function(){
       
		var orderPaket = bagianDataTable.order();
		var idPerusahaan = $('#perusahaan').val();
		var idVendor = $('#vendor').val();
		var client = $('#client').val();
		var startDate = $('#from-date').val();
		var endDate = $('#to-date').val();
		
		//var cari =  $('#bagian-table>input[type="search"]').val();//$('#teangan1').val();
		var cari = $('#bagian-table_filter').find('input').val();
		var filterPaket = "perusahaan="+idPerusahaan+"&vendor="+idVendor+"&client="+client+"&startDate="+startDate+"&endDate="+endDate+"&search="+cari;
		var ur = baseUrl+"/statistik-umum-bagian-export/"+orderPaket+"/"+filterPaket;					
		window.location.href = ur;
		
	});
	
    /**
     * Datatable initial
     */
    var clientDataTable = $('#client-table').DataTable({
        dom: '<"dt-toolbar"<"col-md-3 col-sm-12 hidden-sm float-left"f><"col-md-9 col-sm-12 hidden-sm float-right"<"client-toolbar">>>rt<"dt-toolbar-footer"<"col-md-5 col-sm-12"i><"col-md-6 col-md-12 hidden-sm"p>><"clear">',
        processing: false,
        serverSide: true,
        scrollX: true,
        order: [[1, "desc"]],
         pageLength: 15,
        lengthMenu: [[15, 25, 50, 100], [15, 25, 50, 100]],
        pagingType: 'full_numbers',
        ajax: {
            url: baseUrl+"/report/statistik-client-datatables",
            type: 'GET',
            data:  function(d){
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
            //search: '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>',
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
            {data: "client", name: "client"},
            {data: "total", name: "total", searchable: false},
            {data: "client", sortable: false, searchable: false, class: "action"}
        ],
        columnDefs:[
            {
                targets: 2,
                render: function(d, type, row) {
					
					var idPerusahaan = $('#perusahaan').val();
					var idVendor = $('#vendor').val();
					var client = $('#client').val();
					var startDate = $('#from-date').val();
					var endDate = $('#to-date').val();
					var filter = "{'perusahaan': '"+idPerusahaan+"', 'vendor': '"+idVendor+"', 'client': '"+client+"', 'startDate': '"+startDate+"', 'endDate': '"+endDate+"'}";
					return '<a href="/report/statistik-detail/client/'+d+'/'+row.total+'/Statistika Umum/'+filter+'" class="btn btn-action btn-primary btn-xs" data-id="'+d.id+'"><i class="fa fa-ellipsis-h"></i></a>&nbsp;';
	
					
                }
            }
        ]
    });

    $("div.client-toolbar").html("<a href='#' id='btn-export-client' class='btn btn-secondary'><i class='fa fa-download'></i></a>&nbsp;");
	$('body').on('click','#btn-export-client',function(){
		var orderPaket = bagianDataTable.order();
		var idPerusahaan = $('#perusahaan').val();
		var idVendor = $('#vendor').val();
		var client = $('#client').val();
		var startDate = $('#from-date').val();
		var endDate = $('#to-date').val();
		
		//var cari =  $('input[type="search"]').val();//$('#teangan1').val();
		var cari = $('#client-table_filter').find('input').val();
		var filterPaket = "perusahaan="+idPerusahaan+"&vendor="+idVendor+"&client="+client+"&startDate="+startDate+"&endDate="+endDate+"&search="+cari;
		var ur = baseUrl+"/statistik-umum-client-export/"+orderPaket+"/"+filterPaket;					
		window.location.href = ur;
		
	});

    $('#btn-filter-submit').click(function() {
        paketDataTable.draw(true);
        bagianDataTable.draw(true);
        clientDataTable.draw(true);
        updateChart();
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

function updateChart() {
    // Update chart
    $.ajax({
        url: baseUrl + '/report/statistik-sex',
        type: 'GET',
        data: {
            idPerusahaan: $('#perusahaan').val(),
            idVendor: $('#vendor').val(),
            client: $('#client').val(),
            startDate: $('#from-date').val(),
            endDate: $('#to-date').val()
        },
        success: function(resp) {
            var data = [];
            var categories = [];
            //var colors = ['#878686','#908F8F','#9A9999','#A4A3A3','#AEADAD','#B8B7B7','#C2C1C1','#CCCBCB','#D6D5D5','#E0DFDF'];
            var colors = ['#da251d','#006db7'];
            //var colors = ['#878686','#908F8F','#9A9999','#A4A3A3','#AEADAD','#B8B7B7','#C2C1C1','#CCCBCB','#D6D5D5','#E0DFDF'];
            //var colors = ['#878686','#908F8F','#9A9999','#A4A3A3','#AEADAD','#B8B7B7','#C2C1C1','#CCCBCB','#D6D5D5','#E0DFDF'];

            $.each(resp, function(i, o) {
                data.push({
                    name: o.jenis_kelamin,
                    color: colors[i],
                    y: o.total
                });
                categories.push(o.jenis_kelamin);
            });

            $('#graph-sex').highcharts({
                chart: {
                    type: 'pie',
                    backgroundColor: '#edecec',
                    colors: colors,
                    options3d: {
                        enabled: true,
                        alpha: 60,
                        beta: 0
                    }
                },
                plotOptions: {
                    pie: {
                        depth: 25,
                        innerSize: 80,
    //                    startAngle: -175,
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            distance: 15,
                            formatter: function() {
                                var name = (this.point.name);
                                return '<span style="font-size: 14px; color: #535a6c; font-weight: normal">  '+Math.round((this.point.y / this.point.total) * 100) +'%</span><br/><span style="font-size: 10px; color: #333333; font-weight: normal">'+name+'</span><br/><span style="font-size: 10px; font-weight: normal; color: #333333">Total '+(this.point.y).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+'</span>';
                            },
                            style: {
                                fontFamily: 'Roboto',
                                textOutline: false,
                                fontSize: '12px',
                                fontWeight: 'bold'
                            }
                        }
                    }
                },
                tooltip: {
                    style: {

                    }
                },
                legend: {
                    enable: true,
                    align: 'center'
                },
                xAxis: {
                    categories: categories,
                    lineColor: '#333333',
                    lineWidth: 1,
                    tickAmount: 15,
                    tickInterval: 1,
                    gridLineColor: '#f5f5f5',
                    tickWidth: 0,
    //                title: {
    //                    text: '<span style="font-family: Roboto, sans-serif; color: #333333; font-size: 12px">Tanggal</span>'
    //                },
    //                useHTML: true,
    //                labels: {
    //                    rotation: -90,
    //                    style: {
    //                        fontSize: '10px',
    //                        color: '#333333'
    //                    }
    //                }
                },
                title: null,
                credits: false,
                series: [
                    {
                        slicedOffset: 30,
                        name: 'Sex',
                        borderColor: 'transparent',
                        data: data
                    }
                ]
            });
        }
    });

    // Update chart
    $.ajax({
        url: baseUrl + '/report/statistik-age',
        type: 'GET',
        data: {
            idPerusahaan: $('#perusahaan').val(),
            idVendor: $('#vendor').val(),
            client: $('#client').val(),
            startDate: $('#from-date').val(),
            endDate: $('#to-date').val()
        },
        success: function(resp) {
            var data = [];
            var categories = [];
            //var colors = ['#878686','#908F8F','#9A9999','#A4A3A3','#AEADAD','#B8B7B7','#C2C1C1','#CCCBCB','#D6D5D5','#E0DFDF'];
            var colors = ['#109618', '#da251d','#ff9900'];
            //var colors = ['#878686','#908F8F','#9A9999','#A4A3A3','#AEADAD','#B8B7B7','#C2C1C1','#CCCBCB','#D6D5D5','#E0DFDF'];
            //var colors = ['#878686','#908F8F','#9A9999','#A4A3A3','#AEADAD','#B8B7B7','#C2C1C1','#CCCBCB','#D6D5D5','#E0DFDF'];

            $.each(resp, function(i, o) {
                data.push({
                    name: o.age_range,
                    color: colors[i],
                    y: o.total
                });
                categories.push(o.age_range);
            });

            $('#graph-age').highcharts({
                chart: {
                    type: 'pie',
                    backgroundColor: '#edecec',
                    colors: colors,
                    options3d: {
                        enabled: true,
                        alpha: 60,
                        beta: 0
                    }
                },
                plotOptions: {
                    pie: {
                        depth: 25,
                        innerSize: 80,
    //                    startAngle: -175,
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            distance: 15,
                            formatter: function() {
                                var name = (this.point.name);
                                return '<span style="font-size: 14px; color: #535a6c; font-weight: normal">  '+Math.round((this.point.y / this.point.total) * 100) +'%</span><br/><span style="font-size: 10px; color: #333333; font-weight: normal">'+name+'</span><br/><span style="font-size: 10px; font-weight: normal; color: #333333">Total '+(this.point.y).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+'</span>';
                            },
                            style: {
                                fontFamily: 'Roboto',
                                textOutline: false,
                                fontSize: '12px',
                                fontWeight: 'bold'
                            }
                        }
                    }
                },
                tooltip: {
                    style: {

                    }
                },
                legend: {
                    enable: true,
                    align: 'center'
                },
                xAxis: {
                    categories: categories,
                    lineColor: '#333333',
                    lineWidth: 1,
                    tickAmount: 15,
                    tickInterval: 1,
                    gridLineColor: '#f5f5f5',
                    tickWidth: 0,
    //                title: {
    //                    text: '<span style="font-family: Roboto, sans-serif; color: #333333; font-size: 12px">Tanggal</span>'
    //                },
    //                useHTML: true,
    //                labels: {
    //                    rotation: -90,
    //                    style: {
    //                        fontSize: '10px',
    //                        color: '#333333'
    //                    }
    //                }
                },
                title: null,
                credits: false,
                series: [
                    {
                        slicedOffset: 30,
                        name: 'Sex',
                        borderColor: 'transparent',
                        data: data
                    }
                ]
            });
        }
    });

    $.ajax({
        url: baseUrl + '/report/statistik-event',
        type: 'GET',
        data: {
            idPerusahaan: $('#perusahaan').val(),
            idVendor: $('#vendor').val(),
            client: $('#client').val(),
            startDate: $('#from-date').val(),
            endDate: $('#to-date').val()
        },
        success: function(resp) {
            var data = [];
            var categories = [];
            var totalData = resp.length;
            console.log(totalData);
            //var colors = ['#878686','#908F8F','#9A9999','#A4A3A3','#AEADAD','#B8B7B7','#C2C1C1','#CCCBCB','#D6D5D5','#E0DFDF'];
            var colors = ['#109618'];
            //var colors = ['#878686','#908F8F','#9A9999','#A4A3A3','#AEADAD','#B8B7B7','#C2C1C1','#CCCBCB','#D6D5D5','#E0DFDF'];
            //var colors = ['#878686','#908F8F','#9A9999','#A4A3A3','#AEADAD','#B8B7B7','#C2C1C1','#CCCBCB','#D6D5D5','#E0DFDF'];

            $.each(resp, function(i, o) {
                data.push({
                    name: o.tgl_input,
                    color: colors[i],
                    y: o.total
                });
                categories.push(o.tgl_input);
            });

            $('#graph-event').highcharts({
                chart: {
                    type: 'area',
                    backgroundColor: '#edecec',
                    colors: colors,
                    options3d: {
                        enabled: false,
                        alpha: 10,
                        beta: 0
                    }
                },
                plotOptions: {

                },
                tooltip: {
                    style: {

                    }
                },
                legend: {
                    enable: true,
                    align: 'center'
                },
                xAxis: {
                    categories: categories,
                    lineColor: '#333333',
                    lineWidth: 1,
                    tickAmount: 15,
                    tickInterval: 1,
                    gridLineColor: '#f5f5f5',
                    tickWidth: 0,
                    title: {
                        text: '<span style="font-family: Roboto, sans-serif; color: #333333; font-size: 12px">Date</span>'
                    },
                    useHTML: true,
                    labels: {
                        rotation: -90,
                        style: {
                            fontSize: '10px',
                            color: '#333333'
                        }
                    }
                },
                title: null,
                credits: false,
                series: [
                    {
                        slicedOffset: 30,
                        name: 'Medical Check Up Event',
                        color: '#109618',
                        borderColor: 'transparent',
                        data: data
                    }
                ]
            });
        }
    });
}



</script>
@endsection
