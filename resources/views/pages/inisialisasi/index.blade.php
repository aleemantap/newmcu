@extends('layouts.app')
@section('title', 'Inisialisasi Data')
@section('content-class', 'grid')

@section('ribbon')
<ol class="breadcrumb">
    <li>Inputer</li>
    <li><a href="{{url('planning/inisialisasi/')}}">Inisialisasi Data</a></li>
</ol>
@endsection

@section('content')

<table id="datatablefr" class="table table-striped table-borderless" width="100%">
    <thead>
        <tr>
            <th style="width:20px;">No</th>
            <th>PROJEC ID</th>
			<th>Partner</th>
            <th>Customer</th>
            <th>Jumlah</th>
            <th style="width: 60px">Action</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
@endsection
 
@section('modal')
	@include('pages.inisialisasi.import-peserta')
    @include('pages.inisialisasi.filter')
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

    $('.input-daterange').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: 'true'
    });

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
    var mcudatatablefr = $('#datatablefr').DataTable({
        dom: '<"dt-toolbar row"<"col-sm-4  col-xs-12 "l><"col-sm-8  col-xs-12  text-right"<"toolbar">>>rt<"dt-toolbar-footer"<"col-sm-6 col-xs-12"i><"col-sm-6 col-xs-12 "p>><"clear">',
        processing: false,
        serverSide: true,
        scrollX: true,
        pageLength: 15,
        lengthMenu: [[15, 25, 50, 100], [15, 25, 50, 100]],
        pagingType: 'full_numbers',
        ajax: {
            url: baseUrl+"/planning/inisialisasi/datatables", 
            type: 'GET',
            data:  function(d){
                
				d.project = $('#project-id').val();
                d.perusahaan = $('#perusahaan').val();
                d.vendor = $('#vendor').val();
                
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
			{data: "project_id", name: "project_id"},
            {data: "vendor_customer.vendor.name", name: "vendor_customer.vendor.name"},
            {data: "vendor_customer.customer.name", name: "vendor_customer.customer.name"},
            {data: "datapeserta", name: "datapeserta"},
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
				targets: 4,
				render: function (d,row,data) {
					//console.log(d);
					return d.length;
				}
			},
           
            {
                targets: 5,
				render: function(d,row,data) {
					var pro = data.project_id;
                    //return '<button type="button" class="btn btn-primary btn-xs btn-upload" title="Upload Peserta" data-id='+d+' data-pro='+pro+'><i class="fa fa-upload"></i>&nbsp; Upload Peserta</button>&nbsp;&nbsp;<button type="button" class="btn btn-default btn-xs btn-peserta-t" title="Detail Peserta" data-id='+d+' data-pro='+pro+'><i class="fa fa-fw fa-lg fa-file"></i>&nbsp;Peserta</button>&nbsp;<button type="button" class="btn btn-success btn-xs btn-detail-table-down" title="Peserta" data-pro='+pro+'><i class="fa fa-arrow-down"></i>&nbsp;List</button>';
                    return '<button type="button" class="btn btn-primary btn-xs btn-upload" title="Upload Peserta" data-id='+d+' data-pro='+pro+'><i class="fa fa-upload"></i>&nbsp; Upload Peserta</button>&nbsp;<button type="button" class="btn btn-success btn-xs btn-detail-table-down" title="Peserta" data-pro='+pro+'><i class="fa fa-arrow-down"></i>&nbsp;List</button>';
                
				
                }
            },
			
			
        ],
		'select': {
			style:    'single'
		},
		
        
		
    });
    $("div.toolbar").html("<button id='btn-filter-clear-mcu2' title='Filter' class='btn btn-default hidden'><i class='fa fa-filter'></i> Remove Filter</button>&nbsp;"+
        "<button id='btn-filter-mcu2' title='Filter' class='btn btn-default'><i class='fa fa-filter'></i></button>&nbsp;"+
		"<button id='btn-add-ini' title='Add' class='btn btn-success'><i class='fa fa-plus'></i>&nbsp;New</button>");
	

	$('#btn-filter-submit').click(function() {
		
        mcudatatablefr.draw(true);
    });
	
    // Filter Mcu
    $('body').on('click', '#btn-filter-mcu2', function(){
        $('#modal-filter2').modal('show');
    });

    // Remove Filter Mcu
    $('body').on('click', '#btn-filter-clear-mcu2', function(){
        $('#modal-filter2 input, #modal-filter2 select').val('').trigger('change');
        mcudatatablefr.draw(true)
        $('#btn-filter-clear-mcu2').addClass('hidden');
    });

    $('#btn-filter-submit2').click(function() {
        //$('#modal-filter2').modal('hide');
        mcudatatablefr.draw(true);
        $('#btn-filter-clear-mcu2').removeClass('hidden');
    });
	
	
    $('#datatablefr').on('click', '.btn-detail-table-down', function(e){

        let tr = e.target.closest('tr');
        let row = mcudatatablefr.row(tr);
     
        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
        }
        else {
                 // Open this row
                //row.child(format(row.data())).show();
                $('.page-loader').removeClass('hidden');
                 // Send data
                var ar = [];
                $.ajax({ 
                    url: baseUrl + "/planning/inisialisasi/data-detail-inisilisasi", 
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id : row.data().id, //d.id //id inisilaisai
                    },
                    success: function(resp) {
                    if(resp.responseCode === 200) {
                          
                        
                             var tb = "<table class='table table-striped tabel-detail-ini' >";
                                tb+="<thead class='thead-dark'>";
                                    tb+="<tr>";
                                        tb+="<th  scope='col'>No</th>";
                                        tb+="<th  scope='col'>Tanggal Pemeriksaan</th>";
                                        //tb+="<th  scope='col'>Catatan</th>";
										tb+="<th  scope='col'>Jumlah Peserta</th>";
										tb+="<th  scope='col'>No Awal</th>";
										tb+="<th  scope='col'>No Akhir</th>";
                                        tb+="<th  scope='col'>Action</th>";
                                    tb+="</tr>";
                                tb+="</thead>";
                                tb+="<tbody>";
                            for(var i =0; i<resp.responseMessage.length; i++)
                            {
                                var no = 1+i;
                                var tg = resp.responseMessage[i].tgl_pemeriksaan;
                                //var nt = resp.responseMessage[i].note;
                                var id = resp.responseMessage[i].id; //id detail ini
                                var id_ini = resp.responseMessage[i].id_inisialisasi;
								var jum = resp.responseMessage[i].jumlah;
                                var no_awal =  resp.responseMessage[i].no_awal;
                                var no_akhir = resp.responseMessage[i].no_akhir; 
                                var det = '<button type="button" class="btn btn-success btn-xs btn-detail-pemeriksaan" title="Pemriksaan" data-idini='+id_ini+' data-id='+id+'>Rencana Pemeriksaan</button>&nbsp;<button type="button" class="btn btn-danger btn-xs btn-detail-absesni" title="Absensi" data-idini='+id_ini+' data-id='+id+' data-reg='+tg+'>Absensi</button>&nbsp;<button type="button" class="btn btn-success btn-xs btn-detail-peserta" title="Lihat Peserta" data-idini='+id_ini+' data-id='+id+' data-reg='+tg+'>Lihat Peserta</button>';
                                tb+="<tr>";
                                        tb+="<td>"+no+"</td>";
                                        tb+="<td>"+tg+"</td>";
                                        //tb+="<td>"+nt+"</td>";
										tb+="<td>"+jum+"</td>";
										tb+="<td>"+no_awal+"</td>";
										tb+="<td>"+no_akhir+"</td>";
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
   

    // create mcu
   $('body').on('click', '#btn-add-ini', function(){
        window.location.href= baseUrl+"/planning/inisialisasi/create"
    });
	
	// Detail
    //$('#datatablefr').on('click', '.btn-detail-reg', function() {
	//	location.href = '/planning/inisialisasi/detail/'+$(this).data('id');
	//});
    $('#datatablefr').on('click', '.btn-upload', function() {
	   //alert($(this).data('pro'));
	    $('#modal-import-mcu').modal('show');
		$('#modal-import-mcu input[type=text],#modal-mcu input[type=hidden],#modal-mcu input[type=password],#modal-mcu input[type=email],#modal-mcu input[type=number]').val('');
	    $('#modal-import-mcu .modal-title').html('Import Peserta MCU Project ID= '+$(this).data('pro'));
		$('#modal-import-mcu #id_project').val($(this).data('pro'));
	});
	
    // Edit 
    $('#datatablefr').on('click', '.btn-edit', function() {
		location.href = '/planning/inisialisasi/edit/'+$(this).data('id');
	});

    // Detail ini
    $('body').on('click', '.btn-detail-pemeriksaan', function() {
        location.href = '/planning/inisialisasi/detail-reg/'+$(this).data('id')+'/'+$(this).data('idini');
    });

	 $('body').on('click', '.btn-detail-absesni', function() {
        location.href = '/planning/absensi/detail/'+$(this).data('idini')+'/'+$(this).data('reg');
    });
	
	 $('body').on('click', '.btn-detail-peserta', function() {
        location.href = '/planning/data-peserta-project-detail/'+$(this).data('idini')+'/'+$(this).data('reg');
    });


     // Peserta 
	$('#datatablefr').on('click', '.btn-peserta-t', function() {
         //location.href = '/planning/inisialisasi/peserta/'+$(this).data('id');
		 location.href = '/planning/data-peserta-project-detail/'+$(this).data('id');
    }) 
	 
    $('#datatablefr').on('click', '.btn-peserta', function() {
        location.href = '/planning/inisialisasi/peserta/'+$(this).data('id');
    });
	
	//tabel-detail-ini
	//
	
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
        form.append('project_id', $('#id_project').val());
        //form.append('ini_id', $('#file')[0].files[0]);

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
					 
					mcudatatablefr.ajax.reload();
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
					//$("#process_id").val("");
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
                $("#process_id").val("");
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

function format(d) {


    $('.page-loader').removeClass('hidden');
    // Send data
    var ar = [];
    $.ajax({ 
        url: baseUrl + "/planning/inisialisasi/data-detail-inisilisasi", 
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            id : d.id //id inisilaisai
        },
        success: function(resp) {
                    if(resp.responseCode === 200) {
                          
                        
                            var tb = '';
                            for(var i =0; i<resp.responseMessage.length; i++)
                            {
                                var no = 1+i;
                                tb+="<tr>";
                                        tb+="<td>"+no+"</td>";
                                        tb+="<td>>f</td>";
                                        tb+="<td>d</td>";
                                        tb+="<td>Detail</td>";
                                tb+="</tr>";
                            }    

                            ar.push(tb);
                          
                          
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
            
    //console.log(ar);
    var tb = "<table class='table table-striped'>";
        tb+="<thead class='thead-dark'>";
            tb+="<tr>";
                tb+="<th  scope='col'>No</th>";
                tb+="<th  scope='col'>Tanggal MCU</th>";
                tb+="<th  scope='col'>Catatan</th>";
                tb+="<th  scope='col'>Action</th>";
            tb+="</tr>";
        tb+="</thead>";
        tb+="<tbody>";
    for(var i=0; i<ar.length; i++)
    {
        var no = 1+i;
        var tg = ar[i].tgl_mcu;
        var note = ar[i].note;
        tb+="<tr>";
                tb+="<td>"+no+"</td>";
                tb+="<td>>f</td>";
                tb+="<td>d</td>";
                tb+="<td>Detail</td>";
        tb+="</tr>";
    }    
    tb+="</tbody>";
    tb+="</table>";
    
    // var tb = "<table class='table table-striped'>";
    //     tb+="<thead class='thead-dark'>";
    //         tb+="<tr>";
    //             tb+="<th  scope='col'>No</th>";
    //             tb+="<th  scope='col'>Tanggal MCU</th>";
    //             tb+="<th  scope='col'>Catatan</th>";
    //             tb+="<th  scope='col'>Action</th>";
    //         tb+="</tr>";
    //     tb+="</thead>";
    //     tb+="<tbody>";
    //         tb+="<tr>";
    //             tb+="<td>1</td>";
    //             tb+="<td>tes</td>";
    //             tb+="<td>tes</td>";
    //             tb+="<td>Detail</td>";
    //         tb+="</tr>";
    //     tb+="</tbody>";
    //     tb+="</table>";
    return tb;
}

</script>
@endsection
