@extends('layouts.app')
@section('css')
    @include('layouts.datatableCss')    
@endsection
@section('ribbon')
<ul class="breadcrumb">
    <li><a>Database</a></li>
    <li>Medical Check Up</li>
    <li>Show Diagnostic</li>
</ul>
@endsection
@section('title', $title_page_left)

@section('content')
<div class="container">
	<div class="row">
		<div class="col-12 mt-5">
            <div class="card">
				<div class="card-body">
					<h4 class="header-title"></h4>
					   
						@csrf
						        <input  type="hidden" name="mcu_id" value="{{ $mcu->id }}">
							   
								<div class="panel panel-report">
									<div class="panel-heading bg-primary">
										<strong><i class="fa fa-th-large"></i> Diagnostic</strong>
								    </div>
								    <div class="panel-body px-5">
										<div class="form-horizontal row mt-5">											<div class="col-md-6">
												<div class="form-group row">
													<label for="" class="control-label col-md-4">No. ID</label>
													<div class="col-md-8"><input readonly type="text" id="id_mcu" class="form-control input-xs" name="id_mcu" value="{{ $id }}"></div>
												</div>
												<div class="form-group row">
													<label for="" class="control-label col-md-4">No. Paper</label>
													<div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="mcu_no_paper" value="{{ $mcu->no_paper}}"></div>
												</div>
												<div class="form-group row">
													<label for="" class="control-label col-md-4">Nama pasien</label>
													<div class="col-md-8"><input readonly type="text" class="form-control input-xs" name="mcu_nama_pasien" value="{{ $mcu->nama_pasien }}" required></div>
												</div>
											  
												
											</div>
											<div class="col-md-6">
												<div class="form-group row">
														<label for="" class="control-label col-md-4">Tgl. lahir</label>
														<div class="col-md-8"><input readonly type="date" class="form-control input-xs" name="mcu_tgl_lahir" value="{{ $mcu->tgl_lahir }}"></div>
												</div>
												<div class="form-group row">
													<label for="" class="control-label col-md-4">Jenis kelamin</label>
													<div class="col-md-8"><input readonly type="text" class="form-control input-xs radio" name="mcu_jenis_kelamin" value="{{ $mcu->jenis_kelamin }}"></div>
												</div>
												   <div class="form-group row">
													<label for="" class="control-label col-md-4">Published</label>
													<div class="col-md-8"><input readonly type="text" class="form-control input-xs radio" name="mcu_client" value="{{ $mcu->published }}"></div>
												</div>
											</div>
											<div class="col-md-12">
												<table class="table">
												  <thead>
													<tr>
													  <th scope="col">No</th>
													  <th scope="col" width="30%">Icd10</th>
													  <th scope="col">WorkHealth</th>
													  <th scope="col">Recomedation</th>
													  <th scope="col">Action</th>
													</tr>
												  </thead>
												  <tbody>
													
													@if($mcu->diagnosis->count() > 0)
														<?php $s=1; ?>
														@foreach($mcu->diagnosis->where('deleted',0) as $d)
														<tr>
															<td>{{ $s }}</td>
															<td>
																<input type="text" style="width:100%;"  class="icdx-name2" value="{{ isset($d->recommendation->icd10->name) ? $d->recommendation->icd10->name : '-' }}" class="form-control input-xs icdx-name2">
																<input type="hidden" value="{{ isset($d->recommendation->icd10->id) ? $d->recommendation->icd10->id : '' }}" class="icdx-id2">
																<input type="hidden" value="{{ $d->id }}" class="id_diagnosis">
															</td>
															<td> 
																<span style="display:none;" class="di-wh">{{ isset($d->recommendation->workHealth->id) ? $d->recommendation->workHealth->id : '-' }}</span>
																<div class="sel-wh"></div>
															</td>
															<td>
																<textarea rows="4" cols="35" class="t_rec">
																	{{ $d->recommendation['recommendation']}}
																</textarea>
																<input type="hidden" value="{{ isset($d->recommendation->id) ? $d->recommendation->id : '' }}" class="tx_id">
															</td>
															<td><button class="btn btn-dark edit-dg" {{ ($mcu->published=="Y") ? "disabled" : "" }}>Edit</button>&nbsp;<button disabled class="save-dg btn btn-dark">Save</button></td>
														</tr>
														<?php $s++; ?>
														@endforeach
													@else
														<tr>
															<td>#</td>
															<td>Normal Condition</td>
															<td>Normal Condition</td>
															<td>
																<textarea rows="4" cols="35">Pertahankan pola hidup sehat, jaga pola makan dengan diet seimbang, olah raga teratur dan istirahat yang cukup karena saat ini anda dalam kondisi sehat</textarea>
															</td>
															<td><button disabled>Edit</button>&nbsp;<button disabled>Save</button></td>
														</tr>
													@endif
												   </tbody>
												</table>  
											</div>
											
										</div>
										<div class="form-horizontal row mt-2">
											<div class="col-md-12">
												<a class="btn btn-success btn-sm btn-flat text-light" data-toggle="tab" onclick="history.back()"><i class="fa fa-arrow-circle-left text-light" ></i> Back</a>
										    </div>
										</div>
									</div>
									
								</div>
					    
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
		
		$("textarea").prop('disabled', true);
		$(".icdx-name2").prop('disabled', true);
		$('body').on('click', '.edit-dg', function(){
			alert("tes");
			var w = $(this).parent().parent();
			w.find('.save-dg').attr('disabled',false);
			w.find('textarea').prop('disabled',false);
			w.find('.icdx-name2').prop('disabled',false);
			w.find('.diagnosis').prop('disabled',false);
		});
		$('body').on('click', '.save-dg', function(){
			var result = confirm("Want to Save?");
			if (result) {
				// Show loder
				$('.page-loader').removeClass('hidden');
				// Send data
				var w = $(this).parent().parent();
			    var tx = w.find('textarea').val(); 
			    var tx_id = w.find('.tx_id').val(); 
			    var icd = w.find('.icdx-id2').val();
			    var dg  = w.find('.diagnosis').val();
			    var id_diagnosis  = w.find('.id_diagnosis').val();
				$.ajax({
					url: '/database/medical-check-up/diagnostic',
					type: 'POST',
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data: {
						'mcu_id': $('#id_mcu').val(),
						'wh_id': dg,
						'cd_id': icd,
						'rekom': tx,
						'rekom_id': tx_id,
						'id_diagnosis': id_diagnosis
					},
					success: function(resp) {
						if(resp.responseCode === 200) {
							
							// Send success message
							location.reload();
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
			
			}
			
			
		});
		$.each($(".table tbody>tr"), function(){
			var d = $(this);
			var i = parseInt(d.find('.di-wh').text());
			s = workHealths(i)
			//console.log(d.find('td')[2]);
			d.find('.sel-wh').html(s);
		});	
		
       
		$('body').on('click','.icdx-name2',function(){
				
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
		
    });
	
	function workHealths(rid)
	{

		 var ar_s2 = [];
		 $.ajax({
					url : baseUrl +"/database/formula/workHealths-json",
					method : "GET",
					//data : {id: id},
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
		 r = '<select disabled name="diagnosis" id="diagnosis" style="width:60%;"  class="diagnosis form-control input-xs">';
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
   </script>
@endsection
