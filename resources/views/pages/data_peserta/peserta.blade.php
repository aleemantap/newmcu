@extends('layouts.app')
@section('title', 'Data Peserta')
@section('content-class', 'grid')

@section('ribbon')
<ol class="breadcrumb">
    <li><a href="{{url('planning/data-peserta/')}}">Planning</a></li>
    <li><a href="{{url('planning/data-peserta/')}}">Peserta</a></li>
    <li>Project ID ({{$project_id}})</li>
    
</ol>
@endsection

@section('content')
<input type="hidden" id="ini" value="{{$id_ini}}">
<input type="hidden" id="project_id" value="{{$project_id}}">
<div class="form-filter">
    <a class="" href="#"><i class="fa fa-chevron-down sign"></i> <span class="filter-title">Show</span><span class="filter-title hidden">Hide</span> Filter <i class="fa fa-filter"></i></a>

    <form action="" class="form-horizontal">
        <div class="row">
            <div class="col-md-4">
                @if($tgl_reg)
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">Tgl Reg</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <div class="form-control input-xs" id="tgl_reg">{{($tgl_reg)?$tgl_reg:null}}</div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">Tgl Reg</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="text" class="form-control input-xs datepicker" id="tgl_reg2" data-provide="datepicker">
                            </div>
                        </div>
                    </div>

                @endif
                
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                    <label for="" class="control-label col-md-4">Nama</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control input-xs" id="nama_pasien">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                    <label for="" class="control-label col-md-4">ID Pasien</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control input-xs" id="id_pasien">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                    <label for="" class="control-label col-md-4">No Nip</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control input-xs" id="no_nip">
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
                        <button type="button" class="btn btn-xs btn-primary btn-block" id="btn-filter-submit"><i class="fa fa-check-circle"></i> Cari</button>
                    </div>
                    <!--<div class="col-md-4">
                        <button type="button" id="btn-dwn" class="btn btn-xs btn-default btn-block"><i class="fa fa-download"></i> @lang('general.download')</button>
                    </div> -->
                </div>
            </div>
        </div>
    </form>
</div>


<table id="datatable_p" class="table table-striped table-borderless" width="100%">
    <thead>
        <tr>
            <th style="width:20px;">No</th>
            <th>ID Pasien</th>
            <th>No. NIP</th>
            <th>Nama</th>
            <th>Tgl. lahir</th>
            <th>L/P</th>
            <th>Bagian</th>
            <th>Tgl.Pemeriksaan/Tgl.Reg</th>
           
            <th>Action</th>
           
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
@endsection

@section('modal')
    @include('pages.data_peserta.import-peserta')
    
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.css') }}" />
<link rel="stylesheet" type="text/css" media="screen" href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css">
      
@endsection

@section('script')
<script src="{{ asset('js/plugin/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
<script>
$(document).ready(function () {

    //$('select').select2({
    //    width: '100%',
    //    containerCssClass : "select-xs"
    //});

    //$('.datepicker').datepicker({
    //    autoclose: true,
    //    format: 'yyyy-mm-dd'
    //});

	 $('select').select2({
        width: '100%',
        containerCssClass: 'select-xs'
    });

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: 'true'
    });

    // $('.input-daterange').datepicker({
    //     format: 'yyyy-mm-dd',
    //     autoclose: 'true'
    // });

    // Toggle filter
    $('.form-filter a').click(function() {
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
    var mcuDataTable = $('#datatable_p').DataTable({
        dom: '<"dt-toolbar row"<"col-sm-4  col-xs-12 "l><"col-sm-8  col-xs-12  text-right"<"toolbar">>>rt<"dt-toolbar-footer"<"col-sm-6 col-xs-12"i><"col-sm-6 col-xs-12 "p>><"clear">',
		processing: false,
        serverSide: true,
        scrollX: true,
        pageLength: 15,
        lengthMenu: [[15, 25, 50, 100], [15, 25, 50, 100]],
        pagingType: 'full_numbers',
        ajax: {
            url: baseUrl+"/planning/data-peserta-project-detail-data/datatables",
            type: 'GET',
            data:  function(d){
              
				d.idPasien = $('#id_pasien').val();
                d.nama = $('#nama_pasien').val();
                d.nip = $('#no_nip').val();
                // d.tglLahir = $('#tgl-lahir').val();
                d.lp = $('#sex').val();
                // d.bagian = $('#bagian').val();
                // d.idPerusahaan = $('#perusahaan').val();
                // d.client = $('#client').val();
                // d.startDate = $('#from-date').val();
                d.tgl_reg = $('#tgl_reg').text(); 
                d.tgl_reg2 = $('#tgl_reg2').val();
                d.id_ini = $('#ini').val(); 


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
            {data: "id_pasien", name: "id_pasien"},
            {data: "no_nip", name: "no_nip"},
            {data: "nama_pasien", name: "nama_pasien"},
            {data: "tgl_lahir", name: "tgl_lahir"},
            {data: "jenis_kelamin", name: "jenis_kelamin"},
            {data: "bagian", name: "bagian"},
            //{data: "vendor_customer.customer.name", name: "vendor_customer.customer.name"},
            {data: "reg_date", name: "reg_date"},
            //{data: "tgl_input", name: "tgl_input"},
            {data: "id", sortable: false, searchable: false, class: "action"}
        ],
		
        columnDefs:[
            {
				targets: 0,
				render: function (data, type, row, meta) {
					return meta.row + meta.settings._iDisplayStart + 1;
				}
			},
            {
                targets: 8,
				render: function(d,row,data) { 
					
					return '<button type="button" class="btn btn-success btn-xs btn-edit" title="Edit" data-id='+d+'><i class="fa fa-edit"></i> Edit</button>';
				}
				
            },
			
			
        ],
		'select': {
			style:    'single'
		},
		
    });
     
	// Create button
    $("div.toolbar").html(
        '<button id="btn-import-mcu" title="Upload" class="btn btn-default"><i class="fa fa-upload"></i></button>&nbsp;');

	$('#btn-filter-submit').click(function() {
        mcuDataTable.draw(true);
    });
	
	// re-diagnostic
	$('#datatable_p tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    } );
 
	$('#datatable_p').on('click', '.btn-edit', function(e){
		
		let url = baseUrl + "/planning/data-peserta-project-detail-edit/"+$(this).data('id')+"/"+$('#project_id').val();
		window.location.href = url;
		
	});
 
	$('#datatable_p').on('click', '.btn-periksa', function(e){
		let tr = e.target.closest('tr');
        let row = mcuDataTable.row(tr);
     
        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
        }
		else
		{
			 
			   $('.page-loader').removeClass('hidden');
                 // Send data
                var ar = [];
                $.ajax({ 
                    url: baseUrl + "/planning/data-peserta/peserta-pemeriksaan-cek", 
                    type: 'POST',
                    headers: { 
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id : row.data().id, 
                        id_inisialisasi: row.data().id_inisialisasi,
                        id_pasien : row.data().id_pasien, 
                    },
                    success: function(resp) {
                    if(resp.responseCode === 200) {
                          
                        
                             var tb = "<table class='table table-striped tabel-detail-xx' >";
                                tb+="<thead class='thead-dark'>";
                                    tb+="<tr>";
                                        tb+="<th  scope='col'>No</th>";
                                        tb+="<th  scope='col'>Pemeriksaan</th>";
                                        tb+="<th  scope='col'>Sudah Diperiksa</th>";
                                        tb+="<th  scope='col'>Action</th>";
                                    tb+="</tr>";
                                tb+="</thead>";
                                tb+="<tbody>";
                            for(var i =0; i<resp.responseMessage.length; i++)
                            {
                                var no = 1+i;
                                var jensi = resp.responseMessage[i].nama;
                                var nt = (resp.responseMessage[i].sudah_diperiksa=="Y") ? "Sudah" : "Belum";
                                var id = '';//resp.responseMessage[i].id; //id detail ini
                                var id_ini = '';//resp.responseMessage[i].id_inisialisasi;
                                var id_pas = row.data().id_pasien; 
                                var id_pro = $('#project_id').val(); 
                                var url = resp.responseMessage[i].url;
                                var det = '<button type="button" class="btn btn-success btn-xs btn-form" title="Form" data-url='+url+' data-pas='+id_pas+' data-pro='+id_pro+'>FORM</button>';
                                tb+="<tr>";
                                        tb+="<td>"+no+"</td>";
                                        tb+="<td>"+jensi+"</td>";
                                        tb+="<td>"+nt+"</td>";
                                        tb+="<td>"+det+"</td>";
                                tb+="</tr>";
                            }    
                             tb+="</tbody>";
                             tb+="</table>";

                            //ar.push(tb);
                            row.child(tb).show();
                          
                          
                        } else {
                            $.smallBox({
                                height: 50,
                                title : "Error",
                                content : resp.responseMessage,
                                color : "#dc3912",
                                sound_file: "smallbox",
                                timeout: 3000
                                //icon : "fa fa-bell swing animated"
                            });
                        }
                        // Hide loder
                        $('.page-loader').addClass('hidden');
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        $.smallBox({
                            title : "Error",
                            content : xhr.statusText,
                            color : "#dc3912",
                            timeout: 3000
                            //icon : "fa fa-bell swing animated"
                        });
                        // Hide loder
                        $('.page-loader').addClass('hidden');
                    }
                
            });
		}	
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
	
	
	$('body').on('click', '.btn-form', function(){
        //window.location.href = baseUrl + "/"
		let url = baseUrl + "/"+$(this).data('url')+"/"+$(this).data('pro')+"/"+$(this).data('pas')
		window.open(url, '_blank');
    });
   //btn-edit

    // Download 
    /*
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
                    $.smallBox({
                        height: 50,
                        title : "Success",
                        content : resp.responseMessage,
                        color : "#109618",
                        sound_file: "voice_on",
                        timeout: 3000
                        //icon : "fa fa-bell swing animated"
                    });
                } else {
                    $.smallBox({
                        height: 50,
                        title : "Error",
                        content : resp.responseMessage,
                        color : "#dc3912",
                        sound_file: "smallbox",
                        timeout: 3000
                        //icon : "fa fa-bell swing animated"
                    });
                }
                // Hide loder
                $('.page-loader').addClass('hidden');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $.smallBox({
                    title : "Error",
                    content : xhr.statusText,
                    color : "#dc3912",
                    timeout: 3000
                    //icon : "fa fa-bell swing animated"
                });
                // Hide loder
                $('.page-loader').addClass('hidden');
            }
        });
    });*/

    // Open Modal Import mcu
    $('body').on('click', '#btn-import-mcu', function(){
        $('#modal-import-mcu').modal('show');
        $('#modal-import-mcu .modal-title').html('Import Excel Peserta');
        $('#modal-import-mcu input[type=text],#modal-mcu input[type=hidden],#modal-mcu input[type=password],#modal-mcu input[type=email],#modal-mcu input[type=number]').val('');
    });

    

    
	
    // Import mcu
    $('#btn-import').click(function(){
	 
        if(!$('#file').val()) {
            $.smallBox({
                height: 50,
                title : "Warning",
                content : 'Please select file to upload',
                color : "#c79121",
                sound_file: "smallbox",
                timeout: 3000
            });

            return;
        }

        // Create form data
        var form = new FormData();
        form.append('file', $('#file')[0].files[0]);
		form.append('project_id', $('#project_id').val());

        // Show loader
        $('.page-loader').removeClass('hidden');
        $.ajax({
             url: baseUrl + '/planning/inisialisasi/peserta-import',  
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData: false, // prevent jQuery from automatically transforming the data into a query string
            contentType: false, // is imperative, since otherwise jQuery will set it incorrectly.
            data: form,
            success: function(resp) {
                if(resp.responseCode === 200) {
					//$("#process_id").val(resp.processId);
                    //checkProcess(resp.processId);
					
					mcuDataTable.ajax.reload();
                    // Reset Form 
                    $('#modal-import-mcu input,#modal-import-mcu select').val('');
                    // Close modal
                    $('#modal-import-mcu').modal('hide');
					
					 $.smallBox({
                        height: 50,
                        title : "Success",
                        content : "Upload Data Berhasil",
                        color : "#109618",
                        sound_file: "smallbox",
                        timeout: 4000
                    });
					
                } else {
					
                    $.smallBox({
                        height: 50,
                        title : "Error",
                        content : resp.responseMessage,
                        color : "#dc3912",
                        sound_file: "smallbox",
                        timeout: 6000
                    });
                }
                $('.page-loader').addClass('hidden');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                //$("#process_id").val("");
				$.smallBox({
                    title : "Error",
                    content : xhr.statusText,
                    color : "#dc3912",
                    sound_file: "smallbox",
                    timeout: 3000
                });
                $('.page-loader').addClass('hidden');
            }
        });
    });

    

});


</script>
@endsection
