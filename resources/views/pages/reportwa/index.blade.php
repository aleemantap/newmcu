@extends('layouts.app')
@section('css')
    @include('layouts.datatableCss')    
@endsection

@section('title', $title_page_left)

@section('ribbon')
<ul class="breadcrumbs pull-left">
	<li><a href="/home">Home</a></li>
    <li><span>Report Sending WA</span></li>   
</ul>
@endsection
@section('content')
    <div class="row">
            <!-- data table start -->
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title"></h4>
                        <div class="data-tables">
                            <table  id="datatable2" class="table table-striped table-borderless" width="100%">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th style="width:20px;">No</th>
                                        <th>No. NIP</th>
                                        <th>Nama</th>
                                        <th>Bagian</th>
                                        <th>Client</th>
                                        <th>Blast WA</th>
                                        <th>Time Sending</th>
                                        <th>Status WA</th>
                                        <th>Status Delivery</th>
                                        <th style="width: 60px">Action</th>
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
    @include('pages.reportwa.export-mcu')
    @include('pages.reportwa.filter')
    @include('pages.reportwa.publish')
    
@endsection

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('script')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('assets/js/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>

<script>
$(document).ready(function () {

    
	 $('select').select2({
        width: '100%',
        // containerCssClass: 'input-xs'
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
    var mcuDataTable2 = $('#datatable2').DataTable({
        dom: '<"dt-toolbar"<"col-md-3 col-sm-12 hidden-sm float-left"l><"col-md-9 col-sm-12 hidden-sm float-right"<"toolbar">>>rt<"dt-toolbar-footer"<"col-md-5 col-sm-12"i><"col-md-6 col-md-12 hidden-sm"p>><"clear">',
       
        processing: false,
        serverSide: true,
        scrollX: true,
        pageLength: 15,
        lengthMenu: [[15, 25, 50, 100], [15, 25, 50, 100]],
        pagingType: 'full_numbers',
        ajax: {
            url: baseUrl+"/report-sending-wa/datatables",
            type: 'GET',
            data:  function(d){
                
				d.idPasien = $('#id-pasien2').val();
                d.nama = $('#nama2').val();
                d.nip = $('#no-nip2').val();
                d.bagian = $('#bagian2').val();
                d.client = $('#client2').val();
                d.startDate = $('#from-date2').val();
                d.endDate = $('#to-date2').val();
                //d.toDate = $('#to-date2').val();
                d.sendwa = $('#sentd-w-opt').val();
                d.statuswa = $('#status-wa-opt').val();
                d.statusdelivery = $('#status-delivery-opt').val();
				d.fromId = $('#wa-start-id').val();
				d.toId = $('#wa-to-id').val();


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
            {data: "no_nip", name: "no_nip"},
            {data: "nama_pasien", name: "nama_pasien"},
            {data: "bagian", name: "bagian"},
            {data: "vendor_customer.customer.name", name: "vendor_customer.customer.name"},
            {data: "published", name: "published"},
            {data: "published_at", name: "published_at"},
            {data: "reportsendwa.status", name: "reportsendwa.status"},
            {data: "reportsendwa.delivery", name: "reportsendwa.delivery"},
            {data: "id", sortable: false, searchable: false, class: "action"}
        ],
		columnDefs:[
            {
                
                render: function(d) { 
                    return d;
                }
            },
            {
                targets: 5,
                render: function(d) {
                    return (d==='Y')?'<span class="text-success">&nbsp;&nbsp;Yes</span>':'<span class="text-danger">&nbsp;&nbsp;No</span>';
                }
            },
			{
                targets: 7,
                render: function(d,row,data) { 
				
					if(d!==undefined)
					{
					    return (d==='success')?'<span class="text-success">&nbsp;&nbsp;'+d+'</span>':'<span class="text-danger">&nbsp;&nbsp;'+d+'</span>';
				    }	
					else
					{
						return '';
					}
				}
            }, 
			{ 
                targets: 8,
                render: function(d,row,data) { 
					
					/*if(testJSON(d)) 
					{
						var k2 = JSON.parse(d).message.status;
						return (k2==='delivery')?'<span class="text-success">&nbsp;&nbsp;'+k2+'</span>':'<span class="text-danger">&nbsp;&nbsp;'+k2+'</span>';

					}
					else
					{
						return '<span class="text-danger">&nbsp;&nbsp;'+d+'</span>';
					}*/
					if(d!==undefined)
					{
						return (d==='delivery')?'<span class="text-success">&nbsp;&nbsp;'+d+'</span>':'<span class="text-danger">&nbsp;&nbsp;'+d+'</span>';
				    }	
					else
					{
						return '';
					}
				}
            },
            {
                targets: 9,
				render: function(d) {
                    return ' <button type="button" class="btn btn-success btn-xs btn-flat btn-detail" title="Detail" data-id='+d+'>Detail WA</button>';
				
					
                }
            },
			
			
        ],
		'select': {
			style:    'single'
		},
		
        
		
    });
   // Create button <button id='btn-export-mcu' title='@lang('general.download')' class='btn btn-default'><i class='fa fa-download'></i></button>&nbsp;
    $("div.toolbar").html(`
        <button id='btn-filter-clear-mcu2' title='Filter' class='btn btn-default hidden btn-flat'><i class='fa fa-filter'></i> Remove Filter</button>&nbsp;
        <button id='btn-filter-mcu2' title='Filter' class='btn btn-default btn-flat'><i class='fa fa-filter'></i></button>&nbsp;
        <button id='btn-publish-mcu' title='Publish' class='btn btn-success btn-flat'><i class="fa fa-whatsapp" style="font-size:13px;color:white"></i>  Blast WA</button>&nbsp;

        
	`);

	

    //default 
   
    $('#publish-all').click(function() {
        if($(this).prop('checked') == true) {
            $('#modal-publish #customer').attr('disabled', 'disabled');
            $('#modal-publish #client').attr('disabled', 'disabled');
            $('#modal-publish #bagian').attr('disabled', 'disabled');
            $('#modal-publish #from-date').attr('disabled', 'disabled');
            $('#modal-publish #to-date').attr('disabled', 'disabled');
			$('#modal-publish #start-id').attr('disabled', 'disabled');
            $('#modal-publish #to-id').attr('disabled', 'disabled');
        }
    });

    $('#publish-some').click(function() {
        if($(this).prop('checked') == true) {
            $('#modal-publish #customer').removeAttr('disabled');
            $('#modal-publish #client').removeAttr('disabled');
            $('#modal-publish #bagian').removeAttr('disabled');
            $('#modal-publish #from-date').removeAttr('disabled');
            $('#modal-publish #to-date').removeAttr('disabled');
			$('#modal-publish #start-id').removeAttr('disabled');
            $('#modal-publish #to-id').removeAttr('disabled');
        }
    });
	
	
   
    // Filter Mcu
    $('body').on('click', '#btn-filter-mcu2', function(){
        $('#modal-filter2').modal('show');
    });

    // Remove Filter Mcu
    $('body').on('click', '#btn-filter-clear-mcu2', function(){
        $('#modal-filter2 input, #modal-filter2 select').val('').trigger('change');
        mcuDataTable2.draw(true)
        $('#btn-filter-clear-mcu2').addClass('hidden');
    });

    $('#btn-filter-submit2').click(function() {
        //$('#modal-filter2').modal('hide');
        mcuDataTable2.draw(true);
        $('#btn-filter-clear-mcu2').removeClass('hidden');
    });

    // Publish MCU
    $('body').on('click', '#btn-publish-mcu', function(){
        $('#modal-publish').modal('show');
        $('#modal-publish input[type=text], #modal-filter select').val('');
    });


    // Download mcu
   // $('body').on('click', '#btn-export-mcu', function(){
     //   $('#modal-export').modal('show');
       // $('#modal-export input[type=text], #modal-filter2 select').val('');
    //});

    
    // Detail WA
    $('#datatable2').on('click', '.btn-detail', function() {
		
		location.href = '/report-sending-wa/sts-wa/'+$(this).data('id');
		
    });
	
	
	$('#btn-new-status-delivery').click(function(){

        // Show loder
        $('.page-loader').removeClass('hidden');

        // Send data
        $.ajax({
            url: baseUrl + '/report-sending-wa/get-new-status-filter',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
               
				'idPasien' : $('#id-pasien2').val(),
                'nama' : $('#nama2').val(),
                'nip' : $('#no-nip2').val(),
                'bagian' : $('#bagian2').val(),
                'client' : $('#client2').val(),
                'startDate' : $('#from-date2').val(),
                'endDate' : $('#to-date2').val(),
                'sendwa' : $('#sentd-w-opt').val(),
                'statuswa' : $('#status-wa-opt').val(),
                'statusdelivery' : $('#status-delivery-opt').val(),
				'fromId': $('#wa-start-id').val(),
				'toId': $('#wa-to-id').val(),
				
				
            },
            success: function(resp) {
                if(resp.responseCode === 200) {
                    // Reload datatable
                     mcuDataTable2.ajax.reload();
                    // Reset Form
                    $('#modal-filter2 input, #modal-filter2 select').val('');
                    // Close modal
                    $('#modal-filter2').modal('hide');
                    // Send success message
                  
                    Lobibox.notify('success', {
                            sound: true,
                            icon: true,
                            msg : resp.responseMessage,
                        });
						
					alert("Silahkan refresh browser beberapa saat !!");
					//setTimeout(function() {
					 
					  //location.reload(); 
					//}, 10000);
					
                } else {
                    Lobibox.notify('error', {
                            sound: true,
                            icon: true,
                            msg : resp.responseMessage,
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
	
	
	
	$('#btn-download-r').click(function() {
		
		var data = new FormData();
		
		data.append('idPasien',$('#id-pasien2').val());
		data.append('nama',$('#nama2').val());
		data.append('nip',$('#no-nip2').val());
		data.append('bagian',$('#bagian2').val());
		data.append('client',$('#client2').val());
		//data.append('startDate',$('#from-date2').val());
		//data.append('endDate',$('#to-date2').val());
		data.append('sendwa',$('#sentd-w-opt').val());
		data.append('statuswa',$('#status-wa-opt').val());
		data.append('statusdelivery',$('#status-delivery-opt').val());
		//alert($('#status-delivery-opt').val());

		$.ajax({
            url: baseUrl+"/report-sending-wa/export",
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
                
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {

            },

        });
        
    });

    // Publish MCU
    $('#btn-publish').click(function(){

    // Show loder
    $('.page-loader').removeClass('hidden');

        // Send data
        $.ajax({
            url: baseUrl + '/database/medical-check-up/publish',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'idPerusahaan': $('#publish-all').prop('checked') === true ? '':$('#modal-publish #customer').val(),
                'client': $('#publish-all').prop('checked') === true ? '':$('#modal-publish #client').val(),
                'bagian': $('#publish-all').prop('checked') === true ? '':$('#modal-publish #bagian').val(),
                'startDate': $('#publish-all').prop('checked') === true ? '':$('#modal-publish #from-date').val(),
                'endDate': $('#publish-all').prop('checked') === true ? '':$('#modal-publish #to-date').val(),
                'fromId': $('#publish-all').prop('checked') === true ? '':$('#modal-publish #start-id').val(),
                'toId': $('#publish-all').prop('checked') === true ? '':$('#modal-publish #to-id').val(),
            },
        
            success: function(resp) {
                if(resp.responseCode === 200) {
                    checkProcess(resp.processId);
                    /*
                    // Reload datatable
                    mcuDataTable.ajax.reload();
                    // Reset Form
                    $('#modal-publish input, #modal-publish select').val('');
                    // Close modal
                    $('#modal-publish').modal('hide');
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
                    */
                    //setTimeout(function() {
                    
                    //location.reload(); 
                    //}, 10000);
                    
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
                    msg :   xhr.statusText,
                });
                // Hide loder
                $('.page-loader').addClass('hidden');
            }
        });

    });
	
	
	function testJSON(text){
		if (typeof text!=="string"){
			return false;
		}
		try{
			var json = JSON.parse(text);
			return (typeof json === 'object');
		}
		catch (error){
			return false;
		}
	}

   
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
            var url = "{{ url('update-process-wa') }}/"+id;
            var source = new EventSource(url);
            source.onmessage = function (e) {

                mcuDataTable2.ajax.reload();

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
                        msg :  'Upload file has been finish',
                    });
					
					//alert("Uploading Success !");

                    source.close();
					$("#process_id").val("");
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
			$("#process_id").val("");
        }
    }


    // Check if current process is running
    @if($process)
        checkProcess({{ $process->id }});
    @endif

});

</script>
@endsection
