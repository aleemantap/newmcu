@extends('layouts.app')
@section('css')
    @include('layouts.datatableCss')    
@endsection
@section('ribbon')
    <ul class="breadcrumbs pull-left">
        <li><a>Report</a></li>
        <li><a href="#">Pasien</a></li>
        <li><span>Top Ten </span></li>
    </ul>
@endsection
@section('title', $title_page_left)


@section('content')
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

            <!-- When login as venodr -->
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

            <div class="col-md-4">
                <div class="form-group row">
                    <label for="" class="control-label col-md-4">@lang('mcu.gender')</label>
                    <div class="col-md-8">
                        <select class="form-control input-xs" id="sex">
                            <option value="">&raquo; @lang('general.all') @lang('mcu.gender')</option>
                            <option value="L">@lang('mcu.male')</option>
                            <option value="P">@lang('mcu.female')</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="form-group row">
                    <label class="col-md-2"></label>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-xs btn-primary btn-block" id="btn-filter-submit"><i class="fa fa-check-circle"></i> @lang('general.submit')</button>
                    </div>
                    <div class="col-md-4">
                        <button type="button"  id="btn-top-dwn" class="btn btn-xs btn-default btn-block"><i class="fa fa-download"></i> @lang('general.download')</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>

<div id="graph" style="height: 300px; width: 100%; display:none;"></div>
<div class="mb-3">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <table id="datatable" class="table table-striped table-borderless" width="100%">
                        <thead>
                            <tr>
                                <th style="width:20px;">No</th>
                                <th>Diagnosis</th>
                                <th>Prevalensi</th>
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

@section('script')
{{-- <script src="{{ asset('js/plugin/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script> --}}
<script src="{{ asset('assets/js/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('assets/js/highcharts/highcharts.js') }}"></script>
<script src="{{ asset('assets/js/highcharts/highcharts-3d.js') }}"></script>
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
    $('.form-filter a.hide').click(function() {
        $(this).toggleClass('open');
        $('.filter-title').toggleClass('hidden');
        $('.form-filter form').toggleClass('open-filter');
    });

	$('#btn-top-dwn').click(function() {

		var data = new FormData();
		//data.append('idPasien',$('#id-pasien').val());
		//data.append('nama',$('#nama').val());
		//data.append('nip',$('#no-nip').val());
		//data.append('tglLahir',$('#tgl-lahir').val());
		//data.append('lp',$('#lp').val());
		data.append('bagian',$('#bagian').val());
		data.append('idPerusahaan',$('#perusahaan').val());
		data.append('idVendor',$('#vendor').val());
		data.append('client',$('#client').val());
		data.append('sex',$('#sex').val());
		data.append('startDate',$('#from-date').val());
		data.append('endDate',$('#to-date').val());

		$.ajax({
            url: baseUrl+"/report/top-ten/export",
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
    var dataTable = $('#datatable').DataTable({
        dom: '<"dt-toolbar"<"col-md-3 col-sm-12 hidden-sm float-left"l><"col-md-9 col-sm-12 hidden-sm float-right"<"toolbar">>>rt<"dt-toolbar-footer"<"col-md-5 col-sm-12"i><"col-md-6 col-md-12 hidden-sm"p>><"clear">',
        processing: true,
        serverSide: true,
        scrollX: true,
        paging: false,
        order: [[ 2, "desc" ]],
        ajax: {
            url: baseUrl+"/report/top-ten-diseases-datatables",
            type: 'GET',
            data:  function(d){
                d.idPerusahaan = $('#perusahaan').val();
                d.idVendor = $('#vendor').val();
                d.client = $('#client').val();
                d.sex = $('#sex').val();
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
            {data: "code", name: "code", sortable: false},
            {data: "name", name: "name", sortable: false},
            {data: "total", name: "total", sortable: true},
            {data: "code", sortable: false, searchable: false, class: "action"}
        ],
        columnDefs:[
            {
                //targets: 3,
                //render: function(d, type, row) {
				//	return `<a href="/report/diseases-detail/`+d+`/`+row.total+`/Top 10 Diseases" class="btn btn-action btn-primary btn-xs" data-id='+d.id+'><i class="fa fa-ellipsis-h"></i></a>
				//			<a data-id='+d.id+' href="#" class="btn btn-action btn-default btn-xs"><i class="fa fa-print"></i></a>`;


                //}
				
				targets: 3,
                render: function(d, type, row) {
					var idPerusahaan = $('#perusahaan').val();
					var idVendor = $('#vendor').val();
					var client = $('#client').val();
					var sex = $('#sex').val();
					var startDate = $('#from-date').val();
					var endDate = $('#to-date').val();
					var filter = "{'perusahaan': '"+idPerusahaan+"', 'vendor': '"+idVendor+"', 'client': '"+client+"', 'sex': '"+sex+"', 'startDate': '"+startDate+"', 'endDate': '"+endDate+"'}";
					return '<a href="/report/diseases-detail/'+d+'/'+row.total+'/Top 10 Diseases/'+filter+'" class="btn btn-action btn-primary btn-xs" data-id="'+d.id+'"><i class="fa fa-ellipsis-h"></i></a>&nbsp;';
				
                }
				
				
            }
        ]
    });

    $('.form-filter a.clear').click(function() {
        $('.form-horizontal')[0].reset();
       
         $('.form-horizontal').find('select.form-control').val(null).trigger("change");
         dataTable.draw(true);
    })

    // Show chart
    updateChart();

    $('#btn-filter-submit').click(function() {
        dataTable.draw(true);
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
        url: baseUrl + '/report/top-ten-diseases-data',
        type: 'GET',
        data: {
            idPerusahaan: $('#perusahaan').val(),
            idVendor: $('#vendor').val(),
            sex: $('#sex').val(),
            client: $('#client').val(),
            startDate: $('#from-date').val(),
            endDate: $('#to-date').val()
        },
        success: function(resp) {
            var data = [];
            var categories = [];
            //var colors = ['#878686','#908F8F','#9A9999','#A4A3A3','#AEADAD','#B8B7B7','#C2C1C1','#CCCBCB','#D6D5D5','#E0DFDF'];
            var colors = ['#109618','#22A128','#34AD38','#46B948','#58C458','#6AD068','#7CDC78','#8EE788','#A0F398','#B3FFA8'];
            //var colors = ['#878686','#908F8F','#9A9999','#A4A3A3','#AEADAD','#B8B7B7','#C2C1C1','#CCCBCB','#D6D5D5','#E0DFDF'];
            //var colors = ['#878686','#908F8F','#9A9999','#A4A3A3','#AEADAD','#B8B7B7','#C2C1C1','#CCCBCB','#D6D5D5','#E0DFDF'];

            $.each(resp, function(i, o) {
                data.push({
                    name: o.code +" - "+o.name,
                    color: colors[i],
                    y: o.total
                });
                categories.push(o.code);
            });

            if(categories.length > 0){
                 $('#graph').css({'display':'block'});
            }

            $('#graph').highcharts({
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
                        startAngle: -175,
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            distance: 15,
                            formatter: function() {
                                var arrName = (this.point.name).split("-");
                                return '<span style="font-size: 14px; color: #535a6c; font-weight: normal">  '+Math.round((this.point.y / this.point.total) * 100) +'%</span><br/><span style="font-size: 10px; color: #333333; font-weight: normal">'+arrName[1]+'</span><br/><span style="font-size: 10px; font-weight: normal; color: #333333"> Total '+this.point.y+'</span>';
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
                    tickWidth: 0
                },
                title: null,
                credits: false,
                series: [
                    {
                        slicedOffset: 30,
                        name: 'ICD X',
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
