@extends('layouts.app')
@section('ribbon')
<ol class="breadcrumb">
    <li>Pages</li>
    <li>Parameter</li>

</ol>
@endsection

@section('content-class', 'grid')
@section('content')
<table id="datatable" class="table table-striped table-borderless" width="100%">
    <thead>
        <tr>
            <th style="width:20px;">No</th>
            <th>Name</th>
            <th>Field</th>
            <th>Index Excel</th>
            <th>Kategori</th>
            <th style="width: 100px">Action</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
@endsection

@section('modal')
    @include('pages.paramter.parameter_form')
@endsection

@section('script')


<script src="{{ asset('js/plugin/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
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
    var dataTable = $('#datatable').DataTable({
        //dom: '<"dt-toolbar"<"col-sm-6 col-xs-12 hidden-xs"l><"col-sm-6 col-xs-12 hidden-xs text-right"<"toolbar">>>rt<"dt-toolbar-footer"<"col-sm-6 col-xs-12"i><"col-sm-6 col-xs-12 hidden-xs"p>><"clear">',
        dom: '<"dt-toolbar"<"col-sm-6 col-xs-12 hidden-xs"f><"col-sm-6 col-xs-12 hidden-xs text-right"<"toolbar">>>rt<"dt-toolbar-footer"<"col-sm-6 col-xs-12"i><"col-sm-6 col-xs-12 hidden-xs"p>><"clear">',

		processing: false,
        serverSide: true,
        scrollX: true,
        pageLength: 15,
        lengthMenu: [[15, 25, 50, 100], [15, 25, 50, 100]],
        pagingType: 'full_numbers',
        ajax: {
            url: baseUrl+"/database/parameter-data",
            type: 'GET',
            data:  function(d){
                // d.idPasien = $('#id-pasien').val();
                // d.nama = $('#nama').val();
                // d.nip = $('#no-nip').val();
                // d.tglLahir = $('#tgl-lahir').val();
                // d.lp = $('#lp').val();
                // d.bagian = $('#bagian').val();
                // d.idPerusahaan = $('#perusahaan').val();
                // d.client = $('#client').val();
                // d.startDate = $('#from-date').val();
                // d.endDate = $('#to-date').val();
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
            {data: "name", name: "name"},
            {data: "field", name: "field"},
            {data: "index_of_colom_excel", name: "index_of_colom_excel"},
            {data: "kategori", name: "kategori"},
            //{data: "bagian", name: "bagian"},
            //{data: "tgl_input", name: "tgl_input"},
            {data: "id", sortable: false, searchable: false, class: "action"}
        ],
        columnDefs:[

			{
                targets: 5,
                render: function(d) {
                    return '<a href="#" class="btn btn-warning btn-xs btn-edit-parameter" title="Edit" data-id='+d+'><i class="fa fa-pencil"></i></a>&nbsp; <button type="button" class="btn btn-danger btn-xs btn-delete-parameter" title="@lang('general.delete')" data-id='+d+'><i class="fa fa-trash"></i></button>';
                }
            }

        ]
    });

	// Create button
    $("div.toolbar").html('<a href="#" id="btn-add-prm" class="btn btn-primary"><i class="fa fa-plus-circle"></i> @lang("general.add")</a>');

	// Add parameter
    $('body').on('click', '#btn-add-prm', function(){
        $('#modal-parameter').modal('show');
        $('#modal-parameter .modal-title').html('New Parameter');
        $('#modal-parameter #c_kategori').html(kategori(null));


        $('#modal-parameter input[type=text],#modal-parameter input[type=hidden],#modal-parameter input[type=password],#modal-parameter input[type=email],#modal-parameter input[type=number]').val('');
    });


    // $('#btn-filter-submit').click(function() {
    //     dataTable.draw(true);
    //});



	$('body').on('click','.btn-edit-parameter',function(){
		 var dd = $(this).attr('data-id');
		 $.ajax({
            url: baseUrl + '/database/parameter/edit',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'id': dd

            },
            success: function(resp) {
                if(resp.responseCode === 200) {

					 $('#modal-parameter').modal('show');
					 $('#modal-parameter .modal-title').html('Edit Parameter');
					 //$('#modal-parameter #nama_parameter').val()
					 $('#field').val(resp.responseMessage.field);
					 $('#excelindex').val(resp.responseMessage.index_of_colom_excel);
					 $('#nama_parameter').val(resp.responseMessage.name);
					 //$('#kategori_pr').val(resp.responseMessage.kategori);
					  $('#modal-parameter #c_kategori').html(kategori(resp.responseMessage.kategori));
					 $('#parameter-id').val(resp.responseMessage.id);

				}

            },
            error: function(xhr, ajaxOptions, thrownError) {
              
                Lobibox.notify('error', {
                        sound: true,
                        icon: true,
                        msg  :  xhr.statusText,
                        });

            }
        });


	});


	 // Add New Or Update
	$('body').on('click','#btn-submit-parameter',function(){

        // Update when user id has value
        var url = baseUrl + '/database/parameter/update';
        //var action = "update";
        if(!$('#parameter-id').val()) {
            url = baseUrl + '/database/parameter/save';
        //action = "save";
        }

        // Has error
        // var hasError = false;
        // Check requirement input
        if(!$('#nama_parameter').val()) {
           
            Lobibox.notify('error', {
                        sound: true,
                        icon: true,
                        msg  : 'Parameter name can\'t be empty',
                        });
            $('#nama_parameter').focus();
            return;
        }
        if(!$('#field').val()) {
            Lobibox.notify('error', {
                        sound: true,
                        icon: true,
                        msg  :'field can\'t be empty',
                        });
            $('#field').focus();
            return;
        }
        if(!$('#excelindex').val()) {
            Lobibox.notify('error', {
                        sound: true,
                        icon: true,
                        msg  :  'Excel index can\'t be empty',
                        });
            $('#excelindex').focus();
            return;
        }


        // Show loder
        $('.page-loader').removeClass('hidden');

        // Send data
        $.ajax({
            url: url,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'id': $('#parameter-id').val(),
                'nama_parameter': $('#nama_parameter').val(),
                'field': $('#field').val(),
                'excelindex': $('#excelindex').val(),
                'kategori_pr': $('#kategori_pr').val(),

            },
            success: function(resp) {
                if(resp.responseCode === 200) {
                    // Reload datatable
                    dataTable.ajax.reload();
                    // Reset Form
                    $('#modal-parameter input[type=text],#modal-parameter input[type=password],#modal-parameter input[type=email],#modal-parameter input[type=number]').val('');
                    // Close modal
                    $('#modal-parameter').modal('hide');
                    // Send success message
                   
                    Lobibox.notify('success', {
                        sound: true,
                        icon: true,
                        msg  :resp.responseMessage,
                        });
                } else {
                  
                    Lobibox.notify('error', {
                        sound: true,
                        icon: true,
                        msg  :resp.responseMessage,
                        });
                }
                // Hide loder
                $('.page-loader').addClass('hidden');
            },
            error: function(xhr, ajaxOptions, thrownError) {
               
                Lobibox.notify('error', {
                        sound: true,
                        icon: true,
                        msg  : xhr.statusText,
                        });
                // Hide loder
                $('.page-loader').addClass('hidden');
            }
        });

    });

	$('body').on('click','.btn-delete-parameter',function(){
			//console.log(this.data('id'));
			//console.log($(this).attr('data-id'));
			var dd = $(this).attr('data-id');
			result = confirm("Want to delete");
			if(result)
			{
				// Send data
				$.ajax({
					url:  baseUrl + '/database/parameter/delete',
					type: 'POST',
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data: {
						'id': dd,
					},
					success: function(resp) {
						if(resp.responseCode === 200) {
							// Reload datatable
							dataTable.ajax.reload();
							// Send success message
							
                            Lobibox.notify('success', {
                                    sound: true,
                                    icon: true,
                                    msg  : resp.responseMessage,
                                    });
						} else {
							
                            Lobibox.notify('error', {
                                    sound: true,
                                    icon: true,
                                    msg  : resp.responseMessage,
                                    });
						}
						// Hide loder
						$('.page-loader').addClass('hidden');
					},
					error: function(xhr, ajaxOptions, thrownError) {
					
                        Lobibox.notify('error', {
                                    sound: true,
                                    icon: true,
                                    msg  :  xhr.statusText,
                                    });
						// Hide loder
						$('.page-loader').addClass('hidden');
					}
				});
			}

	   });

});

function kategori(value)
{
	ar = ["Pemeriksaan Fisik",
         "Kimia Klinik",
         "Serologi",
         "Hematologi",
         "Urin",
         "Antrovisus",
         "Umum",
         "Rontgen",
         "Drug Screening",
         "EKG",
         "Audiometri",
         "Spirometri",
         "Feses",
         "Treadmill",
         "Rectal Swab",
         "OAE",
         "Widal"
        ];
	var  s = "<select class='operator form-control input-xs' id='kategori_pr' name='kategori_pr' >";
	s +="<option value='' selected> &raquo; Kategori</option>";
	for(var i=0; i < ar.length; i++)
	{
		if(value==ar[i])
		{
			s +="<option value='"+ar[i]+"' selected> "+ar[i]+" </option>";
		}
		else
        {
			s +="<option value='"+ar[i]+"' > "+ar[i]+" </option>";
		}
	}

	s += "</select>";

	return s;
}


</script>
@endsection
