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

<table id="datatable_pes" class="table table-striped table-borderless" width="100%">
    <thead>
        <tr>
            <th style="width:20px;">No</th>
            <th>PROJEC ID</th>
			<th>Partner</th>
            <th>Customer</th>
            <th>Jumlah Peserta</th>
            <th style="width: 60px">Action</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
@endsection
 
@section('modal')
    
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
    var mcudatatable_pes = $('#datatable_pes').DataTable({
        dom: '<"dt-toolbar row"<"col-sm-4  col-xs-12 "l><"col-sm-8  col-xs-12  text-right"<"toolbar">>>rt<"dt-toolbar-footer"<"col-sm-6 col-xs-12"i><"col-sm-6 col-xs-12 "p>><"clear">',
        processing: false,
        serverSide: true,
        scrollX: true,
        pageLength: 15,
        lengthMenu: [[15, 25, 50, 100], [15, 25, 50, 100]],
        pagingType: 'full_numbers',
        ajax: {
            url: baseUrl+"/planning/data-peserta/datatables", 
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
            {data: "data_peserta", name: "data_peserta"},
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
				render: function(d,data,row) {
					let ds = row.data_peserta.length;
                    return '<span>'+ds+'</span>'
				
                }
            },
			
           
            {
                targets: 5,
				render: function(d,data,row) {
                  	//console.log(row);
                    var pro = row.project_id;
                    let form = `<select  class="select2 link-inputer" id="x_da" data-id=`+d+` data-pro=`+pro+`>
                                        <option value="">Select Form Inputer</option>
                                        <option value="inputer/form-return">Form Return</option>
                                        <option value="inputer/sampling">Form Sampling</option>
                                        <option value="inputer/urin">Form Urin</option>
                                        <option value="inputer/audiometri">Form Audiometri</option>
                                        <option value="inputer/rontgen">Form Rontgen</option>
                                        <option value="inputer/spiro">Form Spirometri</option>
                                        <option value="inputer/ekg">Form EKG</option>
                                    </select>
                                `;
                    return '<button type="button" class="btn btn-primary btn-xs btn-detail" title="Detail Tabel" data-id='+d+'><i class="fa fa-fw fa-lg fa-file"></i>&nbsp;Peserta</button>';
				
                                //return form+'&nbsp;';
                
				
                }
            },
			
			
        ],
		'select': {
			style:    'single'
		},
		
        
		
    });
    $("div.toolbar").html("<button id='btn-filter-clear-mcu2' title='Filter' class='btn btn-default hidden'><i class='fa fa-filter'></i> Remove Filter</button>&nbsp;"+
        "<button id='btn-filter-mcu2' title='Filter' class='btn btn-default'><i class='fa fa-filter'></i></button>&nbsp;");
		//"<button id='btn-add-ini' title='Add' class='btn btn-success'><i class='fa fa-plus'></i>&nbsp;New</button>
	

	$('#btn-filter-submit').click(function() {
		
        mcudatatable_pes.draw(true);
    });
	
    // Filter Mcu
    $('body').on('click', '#btn-filter-mcu2', function(){
        $('#modal-filter2').modal('show');
    });

    // Remove Filter Mcu
    $('body').on('click', '#btn-filter-clear-mcu2', function(){
        $('#modal-filter2 input, #modal-filter2 select').val('').trigger('change');
        mcudatatable_pes.draw(true)
        $('#btn-filter-clear-mcu2').addClass('hidden');
    });

    $('#btn-filter-submit2').click(function() {
        //$('#modal-filter2').modal('hide');
        mcudatatable_pes.draw(true);
        $('#btn-filter-clear-mcu2').removeClass('hidden');
    });


    
    $('#datatable_pes').on('click', '.btn-detail', function(e){

        location.href = '/planning/data-peserta-project-detail/'+$(this).data('id');
        
    });
   

    // create mcu
    //$('body').on('click', '#btn-add-ini', function(){
    //    window.location.href= baseUrl+"/planning/inisialisasi/create"
    //});
	
	// Detail
    //$('#datatable_pes').on('click', '.btn-detail-reg', function() {
	//	location.href = '/planning/inisialisasi/detail/'+$(this).data('id');
	//});
    
    // Edit 
    //$('#datatable_pes').on('click', '.btn-edit', function() {
	//	location.href = '/planning/inisialisasi/edit/'+$(this).data('id');
	//});

    // Detail ini
    //$('body').on('click', '.btn-detail-ini-detail', function() {
    //    location.href = '/planning/inisialisasi/detail-reg/'+$(this).data('id')+'/'+$(this).data('idini');
    //});

     // Peserta 
    //$('#datatable_pes').on('click', '.btn-peserta', function() {
    //    location.href = '/planning/inisialisasi/peserta/'+$(this).data('id');
    //});
	
	//tabel-detail-ini
	//
	
	
    $('#datatable_pes').on('change', '.link-inputer', function(e){
        var dt = $(this).val();
        var id_ini = $(this).data('id');
        var id_pro = $(this).data('pro');
        
        if(dt!=='')
        {
            //location.href = dt;
            var link = baseUrl +"/"+dt+'/'+id_ini+'/'+id_pro;
            window.open(link, '_blank');

        }
        

    })
   
    

//     $("").change(function(){
//         var data = this.value;
//         alert(data);
//         //if(status=="1")
//         //$("#icon_class, #background_class").hide();// hide multiple sections
//    });


    

});


</script>
@endsection
