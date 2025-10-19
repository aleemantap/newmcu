@extends('layouts.app')
@section('css')
    @include('layouts.datatableCss')    
@endsection
@section('ribbon')
    <ul class="breadcrumbs pull-left">
        <li><a>Report</a></li>
        <li><a>Pasien</a></li>
        <li><span>Audiometri</span></li>
    </ul>
@endsection
@section('title', $title_page_left)

@section('content')
<div class="form-filter" id="form-filter-audio">
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
            <!-- End login as vendor -->

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
            <div class="col-md-4">
                <div class="form-group row">
                    <label for="" class="control-label col-md-4">@lang('mcu.roentgen_result')</label>
                    <div class="col-md-8">
                        <select class="form-control input-xs" id="category">
                            <option value="">&raquo; @lang('general.all')</option>
                            <option value="normal">Normal</option>
                            <option value="ringan">Ringan</option>
                            <option value="sedang">Sedang</option>
                            <option value="sedang berat">Sedang Berat</option>
                            <option value="berat">Berat</option>
                            <option value="sangant">Sangat Berat</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                    <label class="col-md-2"></label>
                    <div class="col-md-5">
                        <button type="button" class="btn btn-xs btn-primary btn-block" id="btn-filter-submit"><i class="fa fa-check-circle"></i> Submit</button>
                    </div>
                    <div class="col-md-5">
                        <button type="button" id="btn-top-dwn" class="btn btn-xs btn-default btn-block"><i class="fa fa-download"></i> @lang('general.download')</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
<div class="">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
                <div id="graph" style="height: 300px; width: 100%;"></div>
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
                            <th>Tgl. MCU</th>
                            <th>Audiometri Telinga Kiri</th>
                            <th>Audiometri Telinga Kanan</th>
                            <th style="width: 100px">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
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
    var userDataTable = $('#user-table').DataTable({
        dom: '<"dt-toolbar"<"col-md-3 col-sm-12 hidden-sm float-left"l><"col-md-9 col-sm-12 hidden-sm float-right"<"toolbar">>>rt<"dt-toolbar-footer"<"col-md-5 col-sm-12"i><"col-md-6 col-md-12 hidden-sm"p>><"clear">',
        processing: false,
        serverSide: true,
        scrollX: true,
        pageLength: 15,
        lengthMenu: [[15, 25, 50, 100], [15, 25, 50, 100]],
        //pagingType: 'full_numbers',
        //ajax: baseUrl+"/report/patient/audiometri-datatables",
        pagingType: 'full_numbers',
        ajax: {
            url: baseUrl+"/report/patient/audiometri-datatables",
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
                d.category = $('#category').val();
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
            //{data: "id", sortable: false, searchable: false, 'visible': false, },
            {data: "mcu_id", name: "mcu_id", sortable: false, searchable: false},
            {data: "mcu.no_nip", name: "no_nip"},
            {data: "mcu.nama_pasien", name: "nama_pasien"},
            {data: "mcu.tgl_lahir", name: "tgl_lahir"},
            {data: "mcu.jenis_kelamin", name: "jenis_kelamin"},
            {data: "mcu.tgl_input", name: "tgl_input"},
            //{data: "audiometri.hasil_telinga_kiri", name: "audiometri.hasil_telinga_kiri"},
            {data: "hasil_telinga_kiri", name: "audiometri.hasil_telinga_kiri"},
            //{data: "audiometri.hasil_telinga_kanan", name: "audiometri.hasil_telinga_kanan"},
            {data: "hasil_telinga_kanan", name: "audiometri.hasil_telinga_kanan"},
            {data: "mcu.id", sortable: false, searchable: false, class: "action"}
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


  


    //$("div.toolbar").html(`
      //  <button id='btn-filter-audiometri' class='btn btn-default'><i class='fa fa-filter'></i></button>&nbsp;
        //<button id='btn-download-audiometri' class='btn btn-default'><i class='fa fa-download'></i></a>&nbsp;
    //`);

     $('a.clear').click(function() {
       
         $('.form-horizontal')[0].reset();       
         $('.form-horizontal').find('select.form-control').val(null).trigger("change");
         userDataTable.draw(true);
    })


    // Update chart
     updateChart();
    $('#btn-filter-submit').click(function() {
         userDataTable.draw(true);
         updateChart();
    });

     // Toggle filter
    $('.form-filter a.hide').click(function() {
        $(this).toggleClass('open');
        $('.filter-title').toggleClass('hidden');
        $('.form-filter form').toggleClass('open-filter');
    });
    
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
        data.append('category',$('#category').val());
        //data.append('sex',$('#sex').val());
        data.append('startDate',$('#from-date').val());
        data.append('endDate',$('#to-date').val());

       
        $.ajax({
         
            url: baseUrl+"/report/patient/audiometri-export",
            
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
    


    /*
    // Update chart
    $.getJSON(baseUrl + '/report/patient/audiometri-summary', function(resp) {
        var l = [];
        var r = [];
        var categories = [];
        //var colors = ['#878686','#908F8F','#9A9999','#A4A3A3','#AEADAD','#B8B7B7','#C2C1C1','#CCCBCB','#D6D5D5','#E0DFDF'];
        var colors = ['#da251d','#006db7'];
        //var colors = ['#878686','#908F8F','#9A9999','#A4A3A3','#AEADAD','#B8B7B7','#C2C1C1','#CCCBCB','#D6D5D5','#E0DFDF'];
        //var colors = ['#878686','#908F8F','#9A9999','#A4A3A3','#AEADAD','#B8B7B7','#C2C1C1','#CCCBCB','#D6D5D5','#E0DFDF'];

        $.each(resp.l, function(i, o) {
            l.push({
                name: o.hasil_telinga_kiri,
                color: colors[0],
                y: o.kiri
            });
            categories.push(o.hasil_telinga_kiri);
        });
        
        $.each(resp.r, function(i, o) {
            r.push({
                name: o.hasil_telinga_kanan,
                color: colors[1],
                y: o.kanan
            });
            categories.push(o.hasil_telinga_kanan);
        });

        $('#graph').highcharts({
            chart: {
                type: 'column',
                backgroundColor: '#edecec',                
                colors: colors,
                options3d: {
                    enabled: true,
                    alpha: 30,
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
                            return '<span style="font-size: 14px; color: #535a6c; font-weight: normal">  '+Math.round((this.point.y / this.point.total) * 100) +'%</span><br/><span style="font-size: 10px; color: #333333; font-weight: normal">'+name+'</span><br/><span style="font-size: 10px; font-weight: normal; color: #333333"> Total '+this.point.y+'</span>';
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
//                    slicedOffset: 30,
                    name: 'Kiri',
                    borderColor: 'transparent',
                    color: colors[0],
                    data: l
                },
                {
//                    slicedOffset: 30,
                    name: 'Kanan',
                    borderColor: 'transparent',
                    color: colors[1],
                    data: r
                }
            ]
        });
    }); */
    
});

function updateChart() {
    $.ajax({ 
        url: baseUrl + '/report/patient/audiometri-summary',
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
            rontgen: $('#rontgen').val(),
            startDate: $('#from-date').val(),
            endDate: $('#to-date').val()
        },
        success: function(resp) {
           //alert('ok');
           var l = [];
            var r = [];
            var categories = [];
            //var colors = ['#878686','#908F8F','#9A9999','#A4A3A3','#AEADAD','#B8B7B7','#C2C1C1','#CCCBCB','#D6D5D5','#E0DFDF'];
            var colors = ['#da251d','#006db7'];
            //var colors = ['#878686','#908F8F','#9A9999','#A4A3A3','#AEADAD','#B8B7B7','#C2C1C1','#CCCBCB','#D6D5D5','#E0DFDF'];
            //var colors = ['#878686','#908F8F','#9A9999','#A4A3A3','#AEADAD','#B8B7B7','#C2C1C1','#CCCBCB','#D6D5D5','#E0DFDF'];

            $.each(resp.l, function(i, o) {
                l.push({
                    name: o.hasil_telinga_kiri,
                    color: colors[0],
                    y: o.kiri
                });
                categories.push(o.hasil_telinga_kiri);
            });
            
            $.each(resp.r, function(i, o) {
                r.push({
                    name: o.hasil_telinga_kanan,
                    color: colors[1],
                    y: o.kanan
                });
                categories.push(o.hasil_telinga_kanan);
            });

            $('#graph').highcharts({
            chart: {
                type: 'column',
                backgroundColor: '#edecec',                
                colors: colors,
                options3d: {
                    enabled: true,
                    alpha: 30,
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
                            return '<span style="font-size: 14px; color: #535a6c; font-weight: normal">  '+Math.round((this.point.y / this.point.total) * 100) +'%</span><br/><span style="font-size: 10px; color: #333333; font-weight: normal">'+name+'</span><br/><span style="font-size: 10px; font-weight: normal; color: #333333"> Total '+this.point.y+'</span>';
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
    //                    slicedOffset: 30,
                        name: 'Kiri',
                        borderColor: 'transparent',
                        color: colors[0],
                        data: l
                    },
                    {
    //                    slicedOffset: 30,
                        name: 'Kanan',
                        borderColor: 'transparent',
                        color: colors[1],
                        data: r
                    }
                ]
            });

        }
    });
}


</script>
@endsection