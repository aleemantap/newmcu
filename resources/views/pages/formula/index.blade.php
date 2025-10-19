@extends('layouts.app')
@section('css')
    @include('layouts.datatableCss')    
@endsection
@section('ribbon')
<ul class="breadcrumbs pull-left">
	<li><a href="/home">Home</a></li>
    <li><a href="">@lang('menu.database')</a></li>
    <li><span>@lang('formula.formula')</span></li>
   
</ul>
@endsection

@section('title', $title_page_left)

@section('content-class', 'grid')
@section('content')
    <div class="row">
		<div class="col-12 mt-5">
			<div class="card">
                <div class="card-body">
					<table id="formula-table" class="table table-striped table-borderless" width="100%">
						<thead>
							<tr>
								<th style="width:20px;">No</th>
								<th>@lang('formula.formula')</th>
								<th>@lang('formula.active')</th>
								<th style="width: 200px">@lang('general.action')</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
                </div>
            </div>
        </div>
    </div>
<style>
</style>
@endsection

@section('modal')
    @include('pages.formula.new-formula')
    @include('pages.formula.add-detail-rumus')
    @include('pages.formula.add-detail-rumus-c')
@endsection

@section('script')
<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script>
$(document).ready(function () {

	$('body').on('click','.edit',function(e){
        //e.preventDefault();
        $(this).parent().parent().find('input[type=text]').prop("readonly",'');
        $(this).parent().parent().find('select').prop("disabled",false);
        $(this).parent().parent().find('.save').prop("disabled",'');

	});
    $('body').on('click','.save',function(e){
        ob = $(this);
        saving(ob,1);
    });

	$('body').on('click','.save2',function(e){
        ob = $(this);
        saving(ob,2);
    });
	$('body').on('click','.save22',function(e){
        ob = $(this);
        saving(ob,3);
    });
	$('body').on('click','.edit2',function(e){
			$(this).parent().parent().find('textarea').prop("readonly",'');
			$(this).parent().parent().find('input[type=text]').prop("readonly",'');
			$(this).parent().parent().find('select').prop("disabled",false);
			$(this).parent().parent().find('.save2').prop("disabled",'');
			$(this).parent().parent().find('.save22').prop("disabled",'');

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
    var formulaDataTable = $('#formula-table').DataTable({
        //dom: '<"dt-toolbar"<"col-sm-6 col-xs-12 hidden-xs"f><"col-sm-6 col-xs-12 hidden-xs text-right"<"toolbar">>>rt<"dt-toolbar-footer"<"col-sm-6 col-xs-12"i><"col-sm-6 col-xs-12 hidden-xs"p>><"clear">',
        dom: '<"dt-toolbar"<"col-md-3 col-sm-12 hidden-sm float-left"l><"col-md-9 col-sm-12 hidden-sm float-right"<"toolbar">>>rt<"dt-toolbar-footer"<"col-md-5 col-sm-12"i><"col-md-6 col-md-12 hidden-sm"p>><"clear">',
        processing: false,
        serverSide: true,
        scrollX: true,
        pageLength: 15,
        lengthMenu: [[15, 25, 50, 100], [15, 25, 50, 100]],
        pagingType: 'full_numbers',
        ajax: baseUrl+"/database/formula/datatables",
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
            {data: "DT_RowIndex", sortable: false, searchable: false},
            {data: "nama", name: "nama"},
            {data: "active", name: "active"},
            {data: "action", sortable: false, searchable: false, class: "action"}
        ],
        columnDefs: [
            {
                targets: 2,
                render: function(d) {
                    if(d === 'active') {
                        return '<span class="text-success">@lang("mcu.yes")</span>';
                    } else {
                        return '<span class="text-danger">@lang("mcu.no")</span>';
                    }
                }
            }
        ]
    });

	ht = "<button id='btn-add-formula' class='btn btn-primary btn-flat'><i class='fa fa-plus-circle'></i> @lang('general.add')</button>&nbsp;";

    $("div.toolbar").html(ht);

    // Add Formula
    $('body').on('click', '#btn-add-formula', function(){
       // $('#modal-formula').modal('show');
       // $('#modal-formula .modal-title').html('New Formula');
       // $('#modal-formula input[type=text],#modal-formula input[type=hidden],#modal-formula input[type=email],#modal-formula input[type=number]').val('');

	  var url = baseUrl + '/database/formula/form-formula';
	  window.location.replace(url);
	});

	//tambah data detail formula
	$('#btn-submit-detail-c').click(function(){
		
		     /* rt = $(this).parent().parent().parent().find('.tb-m');
			 rt.find('.tr-add').remove();
			 rt.find('tr-a').find('input').val('');
			 rt.find('tr-a').find('textarea').val('');
			 rt.parent().parent().find('tr-a').find('select').val(''); */
			 
			 var rv2 = [];
			 //var ob2 = new Object(); 
			 rt = $(this).parent().parent().find('.tb-m>tbody');
			 rt.find('.tr').each(function(index){
				  var rv = [];
				  var ob = new Object(); 
				  ob.recommendation = $(this).find('#recommendation').val();
				  ob.diagnosis = $(this).find('#diagnosis').val();
				  ob.icdx_id = $(this).find('#icdx-id2').val();
				  ob.icdx_name = $(this).find('#icdx-name2').val();
				  ob.name_kondisi = $(this).find('#name-kondisi').val();
				  //rv.push(ob);
				  rv2.push(ob); 
				 
			 }); 
			 //console.log(rv2);
			 /* var formula_id = [];
			 $(this).parent().parent().find('.rv').each(function(index){

				 var o = new Object();
				 o.formula_id = $(this).find('.formula_id').val();
				 o.operator = $(this).find('.operator').val();
				 o.satuan = $(this).find('.satuan').val();
				 o.nilai_kolom = $(this).find('.nilai-kolom').val();
				 formula_id.push(o);

			 }); */
			 
			 // Show loder
			 $('.page-loader').removeClass('hidden');
			 // Send data
			 $.ajax({
				url: baseUrl + '/database/formula/insert-detail-formula-c',
				type: 'POST',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: {
					'rekom': rv2,
					'rumus_id_c': $('#rumus-id-c').val() 
					
				},
				success: function(resp) {
					if(resp.responseCode === 200) {
						// Reload datatable

						// Reset Form
						//$('#modal-formula-add-detail .fd-mod-fm]').html('');
						// Close modal
						$('#modal-formula-add-detail-c').modal('hide');

						formulaDataTable.ajax.reload(null,false);
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
 
			 
			 		
	});
	$('#btn-submit-detail').click(function(){


		 var rv = [];
		 var recom = [];

		 $(this).parent().parent().find('.rv').each(function(index){

			 var o = new Object();
			 o.formula_id = $(this).find('.formula_id').val();
			 o.operator = $(this).find('.operator').val();
			 o.satuan = $(this).find('.satuan').val();
			 o.nilai_kolom = $(this).find('.nilai-kolom').val();
			 rv.push(o);

		 });
		 $(this).parent().parent().find('.recom').each(function(index){
			 var o = new Object();
			 o.recommendation=  $(this).find('#recommendation').val();
			 o.icdx_id = $(this).find('#icdx-id2').val();
			 o.icdx_name2 = $(this).find('#icdx-name2').val();
			 o.diagnosis = $(this).find('.diagnosis').val();
			 o.ya_tidak = $('.ya_tidak_i').val();
			 recom.push(o);
		 });

		 // Show loder
         $('.page-loader').removeClass('hidden');
         // Send data
         $.ajax({
            url: baseUrl + '/database/formula/insert-detail-formula',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'rv': rv,
                'recom': recom,
            },
            success: function(resp) {
                if(resp.responseCode === 200) {
                    // Reload datatable

                    // Reset Form
                    //$('#modal-formula-add-detail .fd-mod-fm]').html('');
                    // Close modal
                    $('#modal-formula-add-detail').modal('hide');

					formulaDataTable.ajax.reload(null,false);
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



	});

    // Add New Or Update Program
    $('#btn-submit').click(function(){

        // Update when formula id has value
        var url = baseUrl + '/database/formula/update';
        var action = "update";
        if(!$('#formula-id').val()) {
            url = baseUrl + '/database/formula/save';
            action = "save";
        }

        // Has error
        // var hasError = false;
        // Check requirement input
        if(!$('#name').val()) {
           
			Lobibox.notify('error', {
					sound: true,
					icon: true,
					msg  : 'Name can\'t be empty',
					});
            $('#name').focus();
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
                'id': $('#formula-id').val(),
                'name': $('#name').val(),
                'status': $('#status').val(),
            },
            success: function(resp) {
                if(resp.responseCode === 200) {
                    // Reload datatable
                    formulaDataTable.ajax.reload(null, false);
					
                    // Reset Form
                    $('#modal-formula input[type=text],#modal-formula input[type=email],#modal-formula input[type=number]').val('');
                    // Close modal
                    $('#modal-formula').modal('hide');
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
						msg  : xhr.statusText,
					});
                // Hide loder
                $('.page-loader').addClass('hidden');
            }
        });

    });

    // Edit formula
    $('#formula-table').on('click', '.btn-edit', function() {
        $('#modal-formula').modal('show');
        $('#modal-formula .modal-title').html('Edit Formula');

        // Hide loder
        $('.page-loader').removeClass('hidden');

        // Get data
        // Send data
        $.ajax({
            url: baseUrl + '/database/formula/' + $(this).data('id'),
            type: 'GET',
            success: function(resp) {
                $('#formula-id').val(resp.id);
                $('#name').val(resp.nama);
                $('#status').val(resp.active);

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
    });
	 var detailRows = [];
	//detail
	$('#formula-table').on('click', '.btn-detail', function() {


			var tr = $(this).closest('tr');
			var tr2 = $(this);
			var row = formulaDataTable.row( tr );
			var idx = $.inArray( tr.attr('id'), detailRows );

			if ( row.child.isShown() ) {
				tr.removeClass( 'details' );
				row.child.hide();
				// Remove from the 'open' array
				detailRows.splice( idx, 1 );
			}
			else {
				tr.addClass( 'details' );
				row.child( format( row.data(), tr2 ) ).show();
				// Add to the 'open' array
				if ( idx === -1 ) {
					detailRows.push( tr.attr('id') );
				}
			}
			tr.next().find('fieldset').find('input').prop("readonly","true");
			tr.next().find('fieldset').find('textarea').prop('readonly', true);
			tr.next().find('fieldset').find('select').prop('disabled', true);
			tr.next().find('fieldset').find('#empty_rekom').prop('disabled', true);
			tr.next().find('fieldset').find('.save').prop('disabled', true);
			tr.next().find('fieldset').find('.save2').prop('disabled', true);


	});
	
	//add detail form
	$('#formula-table').on('click', '.btn-add', function() {

		var tr = $(this).closest('tr');
		var row = formulaDataTable.row( tr );
	    ht = modaladddetail( row.data() );
		ht = '<div class="form-single"  style="display:block;">'+ht+'</div>';
		//ht_c = modaladddetail2( row.data() );
		//ht = ht.concat(ht_c);
	    $('#modal-formula-add-detail .modal-title').html("Add detail : "+row.data().nama);
	    $('#modal-formula-add-detail .fd-mod-fm').html(ht);
		$('#modal-formula-add-detail').modal('show');
    });
	
	$('#formula-table').on('click', '.btn-add-c', function() {

		var tr = $(this).closest('tr');
		var row = formulaDataTable.row( tr );
	    ht_c = modaladddetail2( row.data() );
		//ht = '<div class="form-single"  style="display:block;">'+ht+'</div>';
		$('#modal-formula-add-detail-c .modal-title').html("Add detail : "+row.data().nama);
	    $('#modal-formula-add-detail-c .fd-mod-fm-c').html(ht_c);
		$('#modal-formula-add-detail-c').modal('show');
    });
	
	
	//formulaDataTable.on( 'draw', function () {
    //    $.each( detailRows, function ( i, id ) {
    //        $('#'+id+' td.details-control').trigger( 'click' );
    //    } );
    //});
	//delete rekomendasi
	 $('body').on('click', '.delete_r', function() {

		id_rekom = $(this).parent().parent().find('#recommendation_id').val();
		id_rumus = $(this).attr('value');
		ud = "#btn-detail"+id_rumus;
		cli = $(this).parents('.table').find('tr').find(ud)

		//if(!confirm('Anda akan menghapus ICD X, Work Diagnosis  dan Recommendation, anda yakin?')) {
           delr(id_rekom,cli);
		   //recommendation_id
        //}


	 });

	// Delete formula
    $('body').on('click', '#remove_f', function() {
		if(!confirm('Are you sure want to delete this formula?')) {
            return;
        }
		 id_det = $(this).prev().text();

		 id_rumus = $(this).attr('value');

		 ud = "#btn-detail"+id_rumus;
		 cli = $(this).parents('.table').find('tr').find(ud)
		 //console.log(id);
		 //console.log(id2);
		 $.ajax({

			url: baseUrl + "/database/formula/delete-detail-rumus/"+id_det+"/"+id_rumus,
            type: 'GET',
            success: function(resp) {
                if(resp.responseCode === 200) {
                    // Reload datatable
                    //formulaDataTable.ajax.reload();

				Lobibox.notify('success', {
						sound: true,
						icon: true,
						msg  : resp.responseMessage,
					});

				cli.click();


                } else {
                  
					Lobibox.notify('error', {
						sound: true,
						icon: true,
						msg  : resp.responseMessage,
					});
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

	/* $('body').on('click', '#remove_f2', function() {
		if(!confirm('Are you sure want to delete this formula?')) {
            return;
        }
		 id_det = $(this).prev().text();

		 id_rumus = $(this).attr('value');

		 ud = "#btn-detail"+id_rumus;
		 cli = $(this).parents('.table').find('tr').find(ud)
		 $.ajax({

			url: baseUrl + "/database/formula/delete-detail-rumus2/"+id_det+"/"+id_rumus,
            type: 'GET',
            success: function(resp) {
                if(resp.responseCode === 200) {
                    // Reload datatable
                    //formulaDataTable.ajax.reload();

				$.smallBox({
                        height: 50,
                        title : "Success",
                        content : resp.responseMessage,
                        color : "#109618",
                        sound_file: "voice_on",
                        timeout: 3000
                        //icon : "fa fa-bell swing animated"
                    });

				cli.click();


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
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $.smallBox({
                    title : "Error",
                    content : xhr.statusText,
                    color : "#dc3912",
                    timeout: 3000
                    //icon : "fa fa-bell swing animated"
                });
            }
        });


	}); */

    // Delete formula
    /* $('#formula-table').on('click', '.btn-delete', function() {

        if(!confirm('Are you sure want to delete this formula?')) {
            return;
        }

        // Get data
        // Send data
        $.ajax({
            url: baseUrl + '/formula/delete/'+$(this).data('id'),
            type: 'GET',
            success: function(resp) {
                if(resp.responseCode === 200) {
                    // Reload datatable
                    formulaDataTable.ajax.reload();
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
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $.smallBox({
                    title : "Error",
                    content : xhr.statusText,
                    color : "#dc3912",
                    timeout: 3000
                    //icon : "fa fa-bell swing animated"
                });
            }
        });
    }); */
	
	
	
	$('body').on('click','.ya_b',function(){
		//$(".recom_h").show();
		//$(".recom").show();
		//$('.ya_tidak_i').val('1');
	});
	$('body').on('click','.t_b',function(){
		//$(".recom_h").hide();
		//$(".recom").hide();
		//$('.ya_tidak_i').val('0');
	});

	$('body').on('click','#icdx-name2',function(){
			
			$(this).autocomplete({
				source: function(request, response) {
				$.ajax({
					url: baseUrl + "/database/formula/icdx-search",
					type: 'GET',
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data: {
					   diagnosis: request.term
					},
					success: function(data) {
					   response(data);
					}
				});
			},
			minLength: 3,
			select: function(event, ui) {
				//$("#icdx-id").val(ui.item.id);
				$(this).next().val(ui.item.id);
				//alert(ui.item.id);
				//$("#icdx-name").val(ui.item.name);
				$(this).val(ui.item.name);
				return false;
			},
			change: function(event, ui) {
				if(!ui.item) { $(this).val(''); }
			}
			}).autocomplete("instance")._renderItem = function(ul, item) {

				return $("<li>")
					.append("<div>" + item.name + "</div>" )
					.appendTo(ul);
			};


	});
	
	
	
// $('body #form-detail').on('change','#sel-option',function(){
	// if( $(this).val() == 'single')
	// {
		// $('.form-single').css({ display: 'block' });
		// $('.form-contain').css({ display: 'none' });
		// var op = $(this).parent().parent().parent().find('.mod-detail-tab');
		// op.find('.nilai-kolom').val('');
		// op.find('.satuan').val('');
		// op.find('.icdx-name2').val('');
		// op.find('.icdx-id2').val('');
		// op.find('#recommendation').val('');
		
	// }	
	// else if($(this).val() == 'contain'){
		
		// $('.form-single').css({ display: 'none' });
		// $('.form-contain').css({ display: 'block' });
		// rt = $(this).parent().parent().parent().find('.tb-m');
		// rt.find('.tr-add').remove();
		// rt.find('tr-a').find('input').val('');
		// rt.find('tr-a').find('textarea').val('');
		// rt.parent().parent().find('tr-a').find('select').val('');
		
	// }
// });
	
	
	$('body').on('click','.add2',function(e){
		e.preventDefault();
		
		var gh = '<tr class="tr-add tr" >'+
										
							'<td valign="top">'+
								'<input type="text" class="form-control input-xs" value="" id="name-kondisi" />'+
							'</td>'+
							'<td valign="top">'+
							   '<input type="text" id="icdx-name2" value="" class="form-control input-xs icdx-name2">'+
							   '<input type="hidden" value="" id="icdx-id2" readonly="">'+
							'</td>'+
							'<td valign="top" >'+
							   workHealths(null) +
							'</td>'+
							'<td valign="top">'+
								
								 '<textarea class="form-control input-xs recommendation" cols="20" rows="2" id="recommendation" >'+
								 '</textarea>'+
								
							'</td>'+
							'<td valign="top">'+
								'<button class="edit2 btn btn-xs btn-default"><i class="fa fa-pencil"></i> @lang("general.edit")</button> <button class="save2 btn btn-default btn-xs"><i class="fa fa-save"></i> @lang("general.save")</button> <button type="button" value=""  class="btn btn-default btn-xs del2"><i class="fa fa-trash"></i> Del</button>'+
							'</td>'+ 
						'</tr>';
		$(this).parent().parent().parent().append(gh);
		icdx_name_auto();
			
	});	
	
	
	$('body').on('click','.add22c',function(e){
		e.preventDefault();
		
		var t = '<tr class="tr-a tr" style="">'+
			
			'<td valign="top">'+
				'<input type="text" class="form-control input-xs" value="" id="name-kondisi" />'+
			'</td>'+
			'<td valign="top">'+
			   '<input type="text" id="icdx-name2" value="" class="form-control input-xs icdx-name2">'+
			   '<input type="hidden" value="" id="icdx-id2" readonly="">'+
			'</td>'+
			'<td valign="top" >'+
			   workHealths(null) +
			'</td>'+
			'<td valign="top">'+
				 '<textarea class="form-control input-xs recommendation" cols="20" rows="2" id="recommendation" >'+
				 '</textarea>'+
			'</td>'+
			'<td valign="top">'+
				'<button class="edit2 btn btn-xs btn-default"><i class="fa fa-pencil"></i> @lang("general.edit")</button> <button class="save2 btn btn-default btn-xs"><i class="fa fa-save"></i> @lang("general.save")</button>  <button class="del2 btn btn-default btn-xs"><i class="fa fa-trash"></i> Del</button>  '+
			'</td>' 
		'</tr>';
		$(this).parent().parent().parent().append(t);
		icdx_name_auto();
	
	});
	$('body').on('click','.add22',function(e){
		e.preventDefault();
		
		id = $(this).parent().parent().parent().find('.tr-add').find('#detail_formula_id').val();
		var gh = '<tr class="tr" >'+
					'<td valign="top">'+
						'<input type="hidden" class="form-control input-xs" value="'+id+'" id="detail_formula_id" />'+
					'</td>'+
					'<td valign="top">'+
						'<input type="text" class="form-control input-xs" value="" id="note" />'+
					'</td>'+
					'<td valign="top">'+
					   '<input type="text" id="icdx-name2" value="" class="form-control input-xs icdx-name2">'+
					  
					   '<input type="hidden" value="" id="icdx-id2" readonly="">'+
					'</td>'+
					'<td valign="top" >'+
						workHealths(null) +
					'</td>'+
					'<td valign="top">'+
						 '<input type="hidden" class="form-control input-xs" value="" id="recommendation_id" />'+
						 '<textarea class="form-control input-xs recommendation" cols="20" rows="2" id="recommendation" >'+
						 '</textarea>'+
					'</td>'+
					'<td valign="top">'+
						'<button class="edit2 btn btn-xs btn-default"><i class="fa fa-pencil"></i> @lang("general.edit")</button> <button class="save22 btn btn-default btn-xs"><i class="fa fa-save"></i> @lang("general.save")</button> <button type="button" value=""  class="btn btn-default btn-xs del2"><i class="fa fa-trash"></i> Del</button>'+
					'</td>'+ 
				'</tr>';
		
		$(this).parent().parent().parent().append(gh);
		icdx_name_auto();
			
	});	
	
	$('body').on('click','.del2',function(e){
			$(this).parent().parent().remove();
	});
	$('body').on('click','.del22',function(e){
		
		obj = $(this);
		if($(this).parent().parent().find('.detail_formula_id').val() === "")
		{
			$(this).parent().parent().remove();
		}	
		else
		{
			
			var p = new Object(); 
			p.recommendation_id = obj.parent().parent().find('#recommendation_id').val();
			url =   baseUrl + '/database/formula/del22';
			$.ajax({
				type:'POST',
				data: p,
				dataType: "json",
				cache : false,
				headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
				url: url,
				success:function(data) {

					if(data.responseCode === 200) {

						Lobibox.notify('success', {
							sound: true,
							icon: true,
							msg  :   data.responseMessage,
						});

						obj.parent().parent().remove();


					}
					else
					{
						Lobibox.notify('error', {
							sound: true,
							icon: true,
							msg  :   data.responseMessage,
						});
					}


				}
			  });
		}	
		
			
	});


});
function icdx_name_auto()
{
	$(this).autocomplete({
				source: function(request, response) {
				$.ajax({
					url: baseUrl + "/database/formula/icdx-search",
					type: 'GET',
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data: {
					   diagnosis: request.term
					},
					success: function(data) {
					   response(data);
					}
				});
			},
			minLength: 3,
			select: function(event, ui) {
				//$("#icdx-id").val(ui.item.id);
				$(this).next().val(ui.item.id);
				//alert(ui.item.id);
				//$("#icdx-name").val(ui.item.name);
				$(this).val(ui.item.name);
				return false;
			},
			change: function(event, ui) {
				if(!ui.item) { $(this).val(''); }
			}
			}).autocomplete("instance")._renderItem = function(ul, item) {

				return $("<li>")
					.append("<div>" + item.name + "</div>" )
					.appendTo(ul);
			};

}
function modaladddetail2(d)
{
	return '<div class="form-contain" style="">'+
							'<input type="hidden" id="rumus-id-c" value="'+d.id+'">'+
							'<table class="table tb-m" width="100%">'+
								'<tr class="" style="">'+
									'<td valign="top"><b>&nbsp;Kondisi</b></td>'+
									'<td valign="top"><b>&nbsp;ICD X &nbsp;&nbsp;</b></td>'+
									'<td valign="top"><b>&nbsp;Work Diagnosis&nbsp;&nbsp;</b></td>'+
									'<td valign="top"><b>Recommendation</b></td>'+
									'<td valign="top"><b>Action</b></td>'+
								'</tr>'+
								'<tbody>'+
									'<tr class="tr-a tr" style="">'+
										
										'<td valign="top">'+
											'<input type="text" class="form-control input-xs" value="" id="name-kondisi" />'+
										'</td>'+
										'<td valign="top">'+
										   '<input type="text" id="icdx-name2" value="" class="form-control input-xs icdx-name2">'+
										   '<input type="hidden" value="" id="icdx-id2" readonly="">'+
										'</td>'+
										'<td valign="top" >'+
										   workHealths(null) +
										'</td>'+
										'<td valign="top">'+
											 '<textarea class="form-control input-xs recommendation" cols="20" rows="2" id="recommendation" >'+
											 '</textarea>'+
										'</td>'+
										'<td valign="top">'+
											'<button class="edit2 btn btn-xs btn-default"><i class="fa fa-pencil"></i> @lang("general.edit")</button> <button class="save2 btn btn-default btn-xs"><i class="fa fa-save"></i> @lang("general.save")</button>  <button class="add22c btn btn-default btn-xs"><i class="fa fa-plus"></i> Add</button>  '+
										'</td>' 
									'</tr>'+
								'</tbody>'+
							'</table>'+
						'</div>';
}

function modaladddetail(d)
{

	var tables = new Array();
    $.ajax({
            url: baseUrl + '/database/formula/detail-add-modal/'+d.id,
            type: 'GET',
			async: false,
			//cache: false,
			success: function(resp) {
				tables.push(resp);
			},

        });

	var dd = Object.values(tables['0'])
	var tb = "";

	var tr_j ="";
	var dx = 0;

	var tr_="<table class='mod-detail-tab' ><tr>"+
		"<td></td>"+
		"<td width='20%'><b>Nama Kondisi</b></td>"+
		"<td><b>&nbsp;Nilai Kondisi</b></td>"+
		"<td><b>&nbsp;Satuan Jika ada</b></td>"+
		"<td><b>&nbsp;Operator</b></td>"+
	"</tr>";

	for(var i=1; i<=dd.length; i++)
	{
		    dt = dd[dx]['nama_kolom'];
			var dt2 = dt.toLowerCase();
			var dt3 = '';
			var fo = dd[dx]['formula_id'];


			//var ar_d = Object.values(dd[dx]);
			//console.log();
			if(dt2=="jenis kelamin")
			{
					ar = ["LAKI-LAKI","PEREMPUAN"];
					var  dt3 = "<select class='nilai-kolom form-control input-xs' id='nilai-kolom"+i+"' >";
					for(var i=0; i < ar.length; i++)
					{
						if(nk==ar[i])
						{
							dt3 +="<option value='"+ar[i]+"' selected> "+ar[i]+" </option>";
						}
						else
						{
							dt3 +="<option value='"+ar[i]+"' > "+ar[i]+" </option>";
						}
					}

					dt3 += "</select>";

			}
			else
			{
				sx = (dt=='kesimpulan') ? 'abnormal' : ''; //default

				dt3 = '<input class="nilai-kolom form-control input-xs" id="nilai-kolom"'+i+'" type="text" value="'+sx+'"  />';

			}

			st ="";
			st2 ="";
			if(dt=="kesimpulan")
			{
			    st=	"<input style='' class='form-control input-xs satuan' id='satuan"+i+"' type='hidden' >";
			    st2= "<input style='' class='form-control input-xs operator' type='hidden' value='hasil' >";
			}
            else
            {
				st= "<input style='' class='form-control input-xs satuan' id='satuan"+i+"' type='text' >";
				st2 = operator(null,null);
			}
			tr_s ="<tr class='rv'>"+
					"<td><input type='hidden' class='formula_id' value='"+fo+"'/> </td>"+
					"<td><input type='hidden' class='form-control input-xs nama-kolom'  id='nama-kolom"+i+"' value='"+dt+"' type='text'  >&nbsp;" + dt + "</td>"+
					"<td>"+dt3+"</td>"+
					"<td>"+st+"</td>"+
					"<td>" + st2 + "</td>"+
				"</tr>";

			var tr_j = tr_j.concat(tr_s);
			dx++;


	}

	 tr_ = tr_.concat(tr_j);

	 rek='<tr class="">'+
					'<td valign="top">&nbsp;</td>'+
					'<td valign="top" ></td>'+
					'<td valign="top" align="left" colspan="2">&nbsp;</td>'+
					'<td></td>'+
		   '</tr>'+
		   '<tr class="">'+
					'<td valign="top">&nbsp;</td>'+
					'<td valign="top" ><input type="hidden" class="ya_tidak_i" value="0" /></td>'+
					//'<td valign="top" align="left" colspan="3">Perlu rekomendasi ? &nbsp; <button type="button" class="input-xs btn btn-primary  ya_b">Ya</button><button type="button" class="input-xs btn btn-primary t_b">Tidak</button></td>'+
					'<td valign="top" align="left" colspan="3"></td>'+
		   '</tr>'+
		   '<tr class="">'+
					'<td valign="top">&nbsp;</td>'+
					'<td valign="top" ></td>'+
					'<td valign="top" align="left" colspan="2">&nbsp;</td>'+
					'<td></td>'+
		   '</tr>'+

		   '<tr class="recom_h" style="display:;">'+
				'<td valign="top"></td>'+
				'<td valign="top"></td>'+
				'<td valign="top"><b>&nbsp;ICD X &nbsp;&nbsp;</b></td>'+
				'<td valign="top"><b>&nbsp;Work Diagnosis&nbsp;&nbsp;</b></td>'+
				'<td valign="top"><b>Recommendation</b></td>'+
		   '</tr>'+
			'<tr class="recom" style="display:;">'+
					'<td>'+

					'</td>'+
					'<td></td>'+
					'<td valign="top">'+
					   '<input type="text" id="icdx-name2" value="" class="form-control input-xs icdx-name2">'+
					   '<input type="hidden" value="" id="icdx-id2" readonly="">'+
					'</td>'+
					'<td valign="top">'+
					  workHealths(null) +
					'</td>'+
					'<td valign="top">'+

					  '<textarea class="form-control input-xs" cols="20" rows="3" id="recommendation" >'+
					  '</textarea>'+
					'</td>'+
				'</tr></table>';
		 		//'<input type="hidden" id="recommendation_id">'+
	    tr_ = tr_.concat(rek);
	return tr_;

}

function format ( d, obj ) {

   var tables = new Array();
   
   var id_rumus = d.id;

   $.ajax({
            url: baseUrl + '/database/formula/detail/'+d.id,
            type: 'GET',
			async: false,
			//cache: false,
			dataType: "json",
			success: function(resp) {
				tables.push(resp);
			},

        });
	
	//console.log("ts",tables)
	var dd = Object.values(tables['0'])
	var tb = "";
	
	tr_j = "";
	k ="";
	
	var dx =0;
	for(var d=1; d <= dd.length; d++)
	{
		
		oper = dd[d-1].oper;
		kel = dd[d-1].kel;
		tr_rekom='';
		
		
		//console.log(ar_d.length,'-',j)
	
		if(kel == 2 )
		{
			var ar_d = Object.values(dd[d-1].data);			
			var j = Object.values(dd[d-1]).length-1;
		}
		else
		{
			var ar_d = Object.values(dd[d-1].data);			
			var j = Object.values(dd[d-1].data).length-1;
		}

		
		tr='';
		legend = "<div class='panel-heading bg-white no-border'><span>@lang('formula.condition') "+d+"</span></div>";
        var tr_j='';
        var tr2='';
		var dx =0;
		//
		var ksm = "";
		
		for(var i=1; i<=j; i++)
		{

			ket_or_satuan = (ar_d[dx]['ket_or_satuan']==null) ? "" : ar_d[dx]['ket_or_satuan'];
			ope = ar_d[dx]['jenis_kolom_atau_operator'];
			
			dfid = ar_d[dx]['formula_detail_id'];
			nk = ar_d[dx]['nilai_kolom'];
			dt = ar_d[dx]['nama_kolom'];
			//console.log(dt);
			ksm = dt;
			var dt2 = dt.toLowerCase();
			var dt3 = '';
			if(dt2=="jenis kelamin")
			{

				ar = ["LAKI-LAKI","PEREMPUAN"];
				var  dt3 = "<select class='nilai-kolom form-control input-xs' id='nilai-kolom"+i+"' >";
				for(var i=0; i < ar.length; i++)
				{
					if(nk==ar[i])
					{
						dt3 +="<option value='"+ar[i]+"' selected> "+ar[i]+" </option>";
					}
					else
					{
						dt3 +="<option value='"+ar[i]+"' > "+ar[i]+" </option>";
					}
				}

				dt3 += "</select>";

			}
			else
			{
				
					dt3 = '<input title="'+nk+'" class="nilai-kolom form-control input-xs" id="nilai-kolom"'+i+'" type="text" value="'+nk+'" >';
				
			}
			
			tr_s ='';
			
			if(dt !== 'kesimpulan')
			{	
				tr_s =  "<tr>"+
						"<td><input type='hidden' class='form-control input-xs detail_formula_id' id='detail-formula_id"+i+"' value='"+dfid+"' /></td>"+
						"<td><input type='hidden' class='form-control input-xs nama-kolom'  id='nama-kolom"+i+"' value='"+dt+"' type='text'  >&nbsp;" + dt + "</td>"+
						"<td>"+dt3+"</td>"+
						"<td><input style='' class='form-control input-xs satuan' id='satuan"+i+"' type='text' value='"+ket_or_satuan+"'  ></td>"+
						"<td>" + operator(i,ope) + "</td>"+
						"<td><button class='edit btn btn-xs btn-default'><i class='fa fa-pencil'></i> @lang('general.edit')</button> <button class='save btn btn-xs btn-default'><i class='fa fa-save'></i> @lang('general.save')</button> </td>"+
					"</tr>";
					
			}
			
			var tr_j = tr_j.concat(tr_s);
			dx++;
		} 
		
		
		//if(ope !== 'contain')
		//{	

				btn_r3	="";
				
				if(kel == 2 )
				{
					j = j-1;
					dfid = ar_d[j]['formula_detail_id'];
					valu_ab = ar_d[j]['nilai_kolom'];
					formula_detail_id = ar_d[j]['formula_detail_id'];
					recom_id = ar_d[j]['recommendation_id'];
					recom = (ar_d[j]['recommendation']) ? ar_d[j]['recommendation'] : "";
					work_health_id = ar_d[j]['work_health_id'];
					icdx_id = ar_d[j]['icd10_id'];
					icdx_code = ar_d[j]['icd_code'];
					icdx_name = (ar_d[j]['icd_name']) ? ar_d[j]['icd_name'] : ""; 
					
				}
				else
				{
					
					
					j = j;
					dfid = ar_d[j]['formula_detail_id'];
					valu_ab = ar_d[j]['nilai_kolom'];
					formula_detail_id = ar_d[j]['formula_detail_id'];
					recom_id = ar_d[j]['recommendation_id'];
					recom = (ar_d[j]['recommendation']) ? ar_d[j]['recommendation'] : "";
					work_health_id = ar_d[j]['work_health_id'];
					icdx_id = ar_d[j]['icd10_id'];
					icdx_code = ar_d[j]['icd_code'];
					icdx_name = (ar_d[j]['icd_name']) ? ar_d[j]['icd_name'] : ""; 
				}				 
			 
			 
			 
			
						//ket_or_satuan = (ar_d[j-1]['ket_or_satuan']==null) ? "" : ar_d[j-1]['ket_or_satuan'];
						ket_or_satuan ='';
						
							tr_rekom = "<tr>"+
										"<td><input type='hidden' class='detail_formula_id' id='detail-formula_id"+j+"' value='"+dfid+"'  /></td>"+
										"<td><input type='hidden' class='nama-kolom' id='nama-kolom"+j+"' class='form-control input-xs'  readonly value='kesimpulan'>&nbsp;Kesimpulan</td>"+
										"<td><input type='text'   class='nilai-kolom form-control input-xs' id='nilai-kolom"+j+"'  value='"+valu_ab+"' ></td>"+
										"<td><input type='hidden' class='satuan' id='satuan"+j+"'  value='"+ket_or_satuan+"'  class='form-control input-xs'>"+btn_r3+"</td>"+
										"<td><input type='hidden'  class='operator' id='operator"+j+"' value='hasil'></td>"+
										"<td><button class='edit btn btn-default btn-xs'><i class='fa fa-pencil'></i> @lang('general.edit')</button> <button class='save btn btn-xs btn-default'><i class='fa fa-save'></i> @lang('general.save')</button> </td>"+
									"</tr>";
						
						
						tr = tr.concat(tr_j,tr_rekom);

						tr = tr.concat('<tr class="recom">'+
											'<td valign="top">&nbsp;</td>'+
											'<td valign="top"></td>'+
											'<td valign="top" align="right"></td>'+
											'<td colspan="2"></td>'+
											"<td></td>"+
										'</tr>'
										);

							tr = tr.concat('<tr class="recom">'+
											'<td valign="top">&nbsp;</td>'+
											'<td valign="top"></td>'+
											'<td valign="top" align="right"></td>'+
											'<td colspan="3"></td>'+
										'</tr>'
										);

							tr = tr.concat('<tr class="recom">'+
											'<td valign="top"></td>'+
											'<td valign="top"></td>'+
											'<td valign="top">&nbsp;ICD X &nbsp;&nbsp;</td>'+
											'<td valign="top">&nbsp;Work Diagnosis&nbsp;&nbsp;</td>'+
											'<td valign="top">Recommendation</td>'+
											"<td> </td>"+
										'</tr>'
									);

							tr = tr.concat('<tr>'+
												'<td><input type="hidden" value="'+dfid+'" class="detail_formula_id" id="detail_formula_id"></td>'+
												'<td valign="top"></td>'+
												'<td valign="top"><input type="text"  id="icdx-name2" value="'+icdx_name+'"  class="form-control input-xs icdx-name2"><input type="hidden" value="'+icdx_id+'" id="icdx-id2"></td>'+
												'<td valign="top">' + workHealths(work_health_id) + '</td>'+
												'<td valign="top"><input type="hidden" value="'+recom_id+'" id="recommendation_id"> <textarea class="form-control input-xs" cols="20" id="recommendation">'+recom+'</textarea></td>'+
												'<td valign="top"><button class="edit2 btn btn-xs btn-default"><i class="fa fa-pencil"></i> @lang("general.edit")</button> <button class="save2 btn btn-default btn-xs"><i class="fa fa-save"></i> @lang("general.save")</button>  </td>'+
											'</tr>');
							 
	    //}
		
		del = 	"<button type='button' style='float:right;' id='remove_f'  value='"+id_rumus+"'  class='input-xs btn btn-primary'><i class='fa fa-minus'></i></button>";
 
		
		k += "<fieldset class='panel panel-default'>"+
			""+legend+""+
			"<div class='panel-body'>"+
			"<div style=''><span style='display:none;'>"+dfid+"</span>"+
			del
			+"</div>"+
					"<table width='' style='' cellpadding='2'  cellspacing='2'>"+
					"<tr>"+
						"<td></td>"+
						"<td><b>&nbsp;Nama Kondisi</b></td>"+
						"<td><b>&nbsp;Nilai Kondisi</b></td>"+
						"<td><b>&nbsp;Satuan Jika ada</b></td>"+
						"<td><b>&nbsp;Operator</b></td>"+
						"<td><b>&nbsp;Action</b></td>"+
					"</tr>"+
					""+ tr +
					"</table>"+
					"</div>"+
				"</fieldset>";
		
		
			
	}
	return k;

}

function saving(obj,k)
{
	   var p = new Object();
	   var url = "";
	   if(k==1)
	   {

		   p.nilaikolom = obj.parent().parent().find('.nilai-kolom').val();
		   p.operator = obj.parent().parent().find('.operator').val();
		   p.satuan = obj.parent().parent().find('.satuan').val();
		   //p.formula_id = obj.parent().parent().find('.formula_id').val();
		   p.id = obj.parent().parent().find('.detail_formula_id').val();
		   url =   baseUrl + '/database/formula/update-detailformula';

	   }
	   else if(k==2)
       {
	       p.wh = obj.parent().parent().find('#diagnosis').val();
		   p.recommendation_id = obj.parent().parent().find('#recommendation_id').val();
		   p.recommendation = obj.parent().parent().find('#recommendation').val();
		   p.icdx_id2 = obj.parent().parent().find('#icdx-id2').val();
		   //alii 
		   p.icdx_name2 = obj.parent().parent().find('#icdx-name2').val();
		   p.detail_formula_id = obj.parent().parent().find('.detail_formula_id').val();
		   url =   baseUrl + '/database/formula/update-detailformula2';
	   }
	   else if(k==3)
	   {
			p.wh = obj.parent().parent().find('#diagnosis').val();
			p.recommendation_id = obj.parent().parent().find('#recommendation_id').val();
			p.recommendation = obj.parent().parent().find('#recommendation').val();
			p.icdx_id2 = obj.parent().parent().find('#icdx-id2').val();
			p.icdx_name2 = obj.parent().parent().find('#icdx-name2').val();
			p.detail_formula_id = obj.parent().parent().find('#detail_formula_id').val();
			p.note = obj.parent().parent().find('#note').val();
		    url =   baseUrl + '/database/formula/update-detailformula3';
	   }

	  $.ajax({
		type:'POST',
		data: p,
		dataType: "json",
		cache : false,
		headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
		url: url,
		success:function(data) {

			if(data.responseCode === 200) {

				Lobibox.notify('success', {
							sound: true,
							icon: true,
							msg  :   data.responseMessage,
						});
				

				obj.parent().parent().find('input[type=text]').prop("readonly",'true');
			    obj.parent().parent().find('select').prop("disabled",true);
			    obj.parent().parent().find('textarea').prop("readonly",'true');
			    obj.parent().parent().find('.save').prop("disabled",true);
			    obj.parent().parent().find('.save2').prop("disabled",true);
               


			}
            else
            {
				Lobibox.notify('error', {
							sound: true,
							icon: true,
							msg  :   data.responseMessage,
						});
				

			}


		}
	  });

}

function workHealths(rid)
{

	 var ar_s2 = [];
	 $.ajax({
				url : baseUrl +"/database/formula/workHealths-json",
				method : "GET",
				async: false,
				dataType : 'json',
				success: function(data){
					var i;
					for(i=0; i<data.length; i++){
						var a = new Object();
						a.id = data[i].id;
						a.name = data[i].name;
					    ar_s2.push(a);
					}

				}
	 });
	 r = '<select name="diagnosis" id="diagnosis" style="width:100%;"  class="diagnosis form-control input-xs">';
	 r += '<option value="">--Pilih--</option>';
	 for(i=0; i<ar_s2.length; i++){

		if(rid == ar_s2[i].id)
        {
			r += '<option value='+ar_s2[i].id+' selected>'+ar_s2[i].name+'</option>';
		}
        else
        {
			
			r += '<option value='+ar_s2[i].id+'>'+ar_s2[i].name+'</option>';
			
		}

	 }

	 r += '</select>';

	 return r;

}
function operator(i,value)
{
	ar = ["==","<=",">=","<>","<",">","range","not range","enum","not enum","include", "not include","contain2", "intext", "not intext","between", "not between"];
	var  s = "<select class='operator form-control input-xs' id='operator"+i+"' >";
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

function delr(id_rekom,cli)
{
	var result = confirm("Anda akan menghapus ICD X, Work Diagnosis  dan Recommendation, anda yakin?");
	if (result) {

			$.ajax({
            url: baseUrl + "/database/formula/delete-rekomendasi-icdx-workdiagnosis/"+id_rekom,
            type: 'GET',
            success: function(resp) {
                if(resp.responseCode === 200) {

					// Reload datatable
                    //formulaDataTable.ajax.reload();
				    //cli = $(this).parents('.table').find('tr').find(ud);
					    cli.click();
						Lobibox.notify('success', {
							sound: true,
							icon: true,
							msg  :   data.responseMessage,
						});
                } else {
                   
					Lobibox.notify('error', {
							sound: true,
							icon: true,
							msg  :   data.responseMessage,
						});
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

	}
}

</script>
@endsection
