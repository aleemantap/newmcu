@extends('layouts.app')
@section('title', 'Inisialisasi Data')
@section('ribbon')
<ul class="breadcrumb">
    <li><a>Inisialisasi</a></li>
    <li><a href="{{url('planning/inisialisasi/')}}">Inisialisasi Data</a></li>
    <li>Form Inisialisasi</li>
</ul>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        
        <div>
            @csrf
            
            <div class="tab-content">
                <div class="tab-pane fade active in" id="tab-identitas" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading bg-primary">FORM Inisialisasi</div>
                        <div class="panel-body">
                          
							<form class="inputer customRadio customCheckbox">
								<input  type="hidden" name="id_ini" id="id_ini" value="{{$id?$id:''}}">
								<div class="col-md-6">
									<div class="form-row">
										<div class="col-md-8  col-sm-8 mb-3">
											<div class="form-group row">
												<label for="">ProjectID</label>
												<input type="text" class="form-control" onkeypress="return isNumber(event)" onpaste="return false;"  id="project_id" name="project_id"  placeholder="Project ID" value="{{$data?$data->project_id:''}}">
												<small id="sm-rp"  class="form-text text-muted">Pastikan ID Project dengan benar</small>
											</div>
										</div>
									</div> 
								</div>
								
								
								<div class="col-md-12" style="border-top:1px solid #000;margin-top:20px;">&nbsp;</div> 
								
								<div class="col-md-12">
									<div class="form-group row">
										<table class="table" id="tbl-form-pem">
										  <thead>
											<tr>
											  <th scope="col">No</th>
											  <th scope="col" >Pemeriksaan</th>
											  <th scope="col">Cek Jika Diperiksa</th>
											 
											</tr>
										  </thead>
										  <tbody>
										  <?php
											$no = 1;
											foreach($jenis as $j)
											{
												$cek = '<span><input class="cek" type="checkbox" name="cek[]" class="cek" value="" style="left:auto !important;"/></span>';
												
												echo '<tr>
													  <th scope="row">'.$no.'</th>
													  
													  <td><span class="id_j" style="display:none;">'.$j->id.'</span><span class="j_nama">'.$j->nama.'</span></td>
													  <td >'.$cek.'</td>
													  
													</tr>';
												$no++;
											}
										  ?>
										  </tbody>
									    </table>
									</div>
								</div>
								
								
								<div class="col-md-12">
									<button type="button" class="btn btn-primary" id="btn-submit-ini"><i class="fa fa-check-circle"></i> Submit</button>
                   
									<a href="/planning/inisialisasi/" class="btn btn-success"><i class="fa fa-arrow-circle-left"></i> Back</a>
								</div>
							</form> 
						</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
<script src="{{ asset('js/libs/jquery-ui.min.js') }}"></script>

<script type="text/javascript">
	function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if ( (charCode > 31 && charCode < 48) || charCode > 57) {
            return false;
        }
        return true;
    }
    $(document).ready(function(){
		
		 
		
		$('#btn-submit-ini').click(function(){
			
			// Update when user id has value
			var url = baseUrl + '/planning/inisialisasi/update';
			var action = "update";
			if(!$('#id_ini').val()) {
				url = baseUrl + '/planning/inisialisasi/save';
				action = "save";
			}
			
			 if(!$('#project_id').val()) {
					$.smallBox({
						//height: 50,
						title : "Error",
						content : 'Project id can\'t be empty',
						color : "#dc3912",
						sound_file: "smallbox",
						timeout: 3000
						//icon : "fa fa-bell swing animated"
					});
					$('#project_id').focus();
					return;
			 }
			 			 
			
			  var ar = [];
			  $('#tbl-form-pem>tbody>tr').each(function(){
				
				 	 var ob = new Object();
				 	 ob.id_jenisPemeriksaanQc = $(this).find(".id_j").text();
				 	 ob.nama = $(this).find(".j_nama").text();
				 	 ob.cek = ($(this).find(".cek").is(':checked')) ? 'true' : 'false';
				 	 ar.push(ob);
			  });
			 
			 
			 $('.page-loader').removeClass('hidden');
				// Send data
				$.ajax({ 
						url: url,
						type: 'POST',
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						data: {
							id : $('#id_ini').val(),
							inisial_cek : JSON.stringify(ar),
							project_id : $('#project_id').val(),
						},
						success: function(resp) {
								   if(resp.responseCode === 200) {
										// Reload datatable
										$.smallBox({
											height: 50,
											title : "Success",
											content : resp.responseMessage,
											color : "#109618",
											sound_file: "voice_on",
											timeout: 5000
											//icon : "fa fa-bell swing animated"
										});
										
										window.location.href=baseUrl+"/planning/inisialisasi"
										
									} else if(resp.responseCode === 500) {
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
									else if(resp.responseCode === 501)
									{
										alert("Project ID Belum Ada Di Database Project");
									}
									else if(resp.responseCode === 502)
									{
										alert("Project ID Sudah pernah di-Inputkan. Silahkan masukan Project ID Yang Lain !!");
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
		});
			
				
		
});      


</script>
@endsection
