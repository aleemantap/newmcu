@extends('layouts.app')
@section('css')
    @include('layouts.datatableCss')    
@endsection
@section('ribbon')
<ul class="breadcrumbs pull-left">
    <li><a href="">Report</a></li>
    <li><a>Pasien</a></li>
    <li><span>Spirometri</span></li>
</ul>
@endsection
@section('title', $title_page_left)
@section('content')
<div class="">
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
                                        <label for="" class="control-label col-md-4">Tgl. MCU</label>
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
                                        <label for="" class="control-label col-md-4">@lang('vendor.vendor')</label>
                                        <div class="col-md-8">
                                            <select class="form-control input-xs" id="vendor">
                                                <option value="">&raquo; @lang('general.all') @lang('vendor.vendor')</option>
                                                @if(!empty($vendors))
                                                @foreach($vendors as $v)
                                                <option value="{{ $v->id }}">{{ $v->name }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Perusahaan</label>
                                        <div class="col-md-8">
                                            <select class="form-control input-xs" id="perusahaan">
                                                <option value="">&raquo; Semua Perusahaan</option>
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
                                        <label for="" class="control-label col-md-4">Perusahaan</label>
                                        <div class="col-md-8">
                                            <select class="form-control input-xs" id="perusahaan">
                                                <option value="">&raquo; Semua Perusahaan</option>
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

                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">Client</label>
                                        <div class="col-md-8">
                                            <select class="form-control input-xs" id="client">
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
                            </div>
                            <div class="row">
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
                                        <div class="col-md-8"><input type="text" class="form-control form-control-sm datepicker" id="tgl-lahir"></div>
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
                                        <label for="" class="control-label col-md-4">Kesimpulan Spiro</label>
                                        <div class="col-md-8">
                                            <select class="form-control input-xs" id="spiro">
                                                <option value="">&raquo; Semua</option>
                                                @foreach($spiros as $spiro)
                                                <option value="{{ $spiro->spiro }}">{{ $spiro->spiro }}</option>
                                                @endforeach
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
                                            <button type="button" class="btn btn-xs btn-default btn-block" id="btn-top-dwn"><i class="fa fa-download"></i> @lang('general.download')</button>
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
<div class="mt-3">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                     <h3>Graph</h3>
                    <div id="graph" class="graph" style="height: 300px; width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class=" mb-3">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <table id="user-table" class="table table-striped table-borderless" width="100%">
                        <thead>
                            <tr>
                                <th style="width:20px;">No</th>
                                <th>No. NIP</th>
                                <th>Name</th>
                                <th>Tgl. Lahir </th>
                                <th>L/P</th>
                                <th>Bagian</th>
                                <th>Tgl. MCU</th>
                                <th>Kesimpulan Spirometri</th>
                                <th style="width: 100px">Action</th>
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
    @include('pages.customer.new-customer')
@endsection

@section('script')
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
        processing: false,
        serverSide: true,
        scrollX: true,
        pageLength: 15,
        lengthMenu: [[15, 25, 50, 100], [15, 25, 50, 100]],
        pagingType: 'full_numbers',
        ajax: {
            url: baseUrl+"/report/patient/spirometri-datatables",
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
                d.spiro = $('#spiro').val();
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
            {data: "spirometri.kesimpulan_spirometri", name: "spirometri.kesimpulan_spirometri"},
            {data: "id", sortable: false, searchable: false, class: "action"}
        ],
        columnDefs:[
            {
                targets: 8,
                render: function(d) {
                    return `<a href="/report/patient/medical-check-up/detail/`+d+`" class="btn btn-action btn-primary btn-xs" data-id='+d.id+'><i class="fa fa-ellipsis-h"></i></a> &nbsp;
                            <a data-id='+d.id+' target="_blank" href="/report/patient/medical-check-up/print/`+d+`"  class="btn btn-action btn-default btn-xs"><i class="fa fa-print"></i></a>`;
                }
            }
        ]
    });

    $('.form-filter a.clear').click(function() {
        $('.form-horizontal')[0].reset();
       
         $('.form-horizontal').find('select.form-control').val(null).trigger("change");
         dataTable.draw(true);
    })
	
	 $('#btn-top-dwn').click(function() {
        
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
        //data.append('rontgen',$('#rontgen').val());
        //data.append('sex',$('#sex').val());
		d.spiro = $('#spiro').val();
        data.append('startDate',$('#from-date').val());
        data.append('endDate',$('#to-date').val());

       
        $.ajax({
         
            url: baseUrl+"/report/patient/spirometri-export",  
            
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
    


    // Update chart
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
        url: baseUrl + '/report/patient/spirometri-summary',
        type: 'GET',
        data: {
            idPasien: $('#id-pasien').val(),
            nama: $('#nama').val(),
            nip: $('#no-nip').val(),
            tglLahir: $('#tgl-lahir').val(),
            lp: $('#lp').val(),
            bagian: $('#bagian').val(),
            idPerusahaan: $('#perusahaan').val(),
            idVendor: $('#vendor').val(),
            client: $('#client').val(),
            spiro: $('#spiro').val(),
            startDate: $('#from-date').val(),
            endDate: $('#to-date').val()
        },
        success: function(resp) {
            var data = [];
            var categories = [];
            var colors = ['#ff9900', '#f91a10', '#c37602', '#c0120a', '#825613', '#680602', '#109618'];

            $.each(resp, function(i, o) {
                if(o.kesimpulan_spirometri == 'Normal') {
                    index = 6;
                } else {
                    index = i;
                }

                data.push({
                    name: o.kesimpulan_spirometri,
                    color: colors[index],
                    y: o.total
                });
                categories.push(o.result_ekg);
            });

            $('#graph').highcharts({
                chart: {
                    type: 'pie',
                    backgroundColor: 'transparent',
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
                                return '<span style="font-size: 14px; color: #535a6c; font-weight: normal">'+Math.round((this.point.y / this.point.total) * 100) +'%</span><br/><span style="font-size: 10px; color: #333333; font-weight: normal">'+name+'</span><br/><span style="font-size: 10px; font-weight: normal; color: #333333">Total '+this.point.y+'</span>';
                            },
                            style: {
                                fontFamily: 'Roboto',
                                textOutline: false,
                                fontSize: '12px',
                                fontWeight: 'bold'
                            }
                        },
                        showInLegend: false
                    }
                },
                tooltip: {
                    style: {

                    }
                },
                legend: {
                    enable: true,
                    align: 'left',
                    verticalAlign: 'top',
                    layout: 'vertical',
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
                        name: 'Spirometri',
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
