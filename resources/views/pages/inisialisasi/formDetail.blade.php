@extends('layouts.app')
@section('title', ' Registrasi Data')
@section('ribbon')
<ul class="breadcrumb">
    <li><a>Inisialisasi</a></li>
    <li><a href="{{url('planning/inisialisasi/')}}">Registrasi</a></li>
    <li>Form Registrasi</li>
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
                        <div class="panel-heading bg-primary">Form Registrasi</div>
                        <div class="panel-body">
							<form class="inputer customRadio customCheckbox">
								<input  type="hidden" name="id_ini" id="id_ini" value="{{$id?$id:''}}">
								<div class="col-md-6">
									<div class="form-row">
										<div class="col-md-8  col-sm-8 mb-3">
											<div class="form-group row">
												<label for="">ProjectID : <span class="head-soal">{{$data?$data->project_id:''}}</span></label>
											</div>
										</div>
									</div> 
									<div class="form-row">
										<div class="col-md-8  col-sm-8 mb-3">
											<div class="form-group row">
												<label for="">Vendor : <span class="head-soal">{{$data?$data->vendorCustomer->vendor->name:''}}</span></label>
											</div>
										</div>
									</div> 
									<div class="form-row">
										<div class="col-md-8  col-sm-8 mb-3">
											<div class="form-group row">
												<label for="">Customer : <span class="head-soal">{{$data?$data->vendorCustomer->customer->name:''}}</span></label>
											</div>
										</div>
									</div> 
								</div>
								<?php
									
									$jenis = json_decode($data->inisial_cek);
								?>
								<div class="col-md-6">
									<div class="form-group row">
										<label for="">Rencana Jumlah Peserta</label>
										<input type="text" class="form-control" onkeypress="return isNumber(event)" onpaste="return false;"  id="rencana_jumlah" name="rencana_jumlah"  placeholder="Rencana Jumlah" value="">
									</div>	
									<div class="form-group row">
										<label for="">Tanggal Pemeriksaan</label>
										<input type="text" placeholder="Tanggal Pemeriksaan" class="form-control datepicker input-xs" style="width:100%;" data-provide="datepicker" data-date-format="yyyy-mm-dd" name="tanggal_pemeriksaan" id="tanggal_pemeriksaan" value="">
										<small id="sm-rp"  class="form-text text-muted">Pastikan TGL Pemeriksaan dengan benar</small>
									</div>
									<div class="form-group row">
										<label for="">Catatan A </label>
										<input type="text" placeholder="Catatan" class="form-control input-xs" style="width:100%;" name="catatan" id="catatan" value="">
									</div>
								</div> 
								<div class="col-md-12" style="border-bottom:1px solid #000;margin-bottom:20px;"></div>
								<div class="col-md-12">
									<div class="form-group row">
										<table class="table" id="tbl-form-pem-reg">
										  <thead>
											<tr>
											  <th scope="col">No</th>
											  <th scope="col" >Pemeriksaan</th>
											  <th scope="col">Cek Jika Diperiksa</th>
											  <th scope="col">Jumlah</th>
											 
											</tr>
										  </thead>
										  <tbody>
										  <?php
											$no = 1;
											foreach($jenis as $j)
											{
												$jum = '<input type="text" name="jumlah[]" class="form-control input-lg" style="width:50%;" value="" disabled>';
												$cek = '<span><input type="checkbox" name="cek[]" class="cek" value="true" style="left:auto !important;"/></span>';
												if($j->cek == 'true')
												{
													$cek = '<span><input type="checkbox" name="cek[]" class="cek" value="true" style="left:auto !important;" checked/></span>';
													$jum = '<input type="text" name="jumlah[]" class="form-control input-lg" style="width:50%;" value="">';
												}
												
												echo '<tr>
													  <th scope="row">'.$no.'<span class="id_reg" style="display:none;"></span></th>
													  
													  <td><span class="id_pqc" style="display:none;">'.$j->id_jenisPemeriksaanQc.'</span><span class="p_nama">'.$j->nama.'</span></td>
													  <td >'.$cek.'<span class="idDetIni" style="display:none;">'.$id.'</span></td>
													  <td>'.$jum.'</td> 
													</tr>'; 
												$no++;
											}
										  ?>
										  </tbody>
									    </table>
									</div>
								</div>
								
								<div class="col-md-12">
									<button type="button" class="btn btn-primary" id="btn-submit-inidet"><i class="fa fa-check-circle"></i> Submit</button>
                   
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

@section('css')
<link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.css') }}" />
<link rel="stylesheet" type="text/css" media="screen" href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css">
      
@endsection

@section('script')
<script src="{{ asset('js/libs/jquery-ui.min.js') }}"></script>

<script src="{{ asset('js/plugin/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
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
		
		 $('#tanggal_pemeriksaan').datepicker({
			format: 'yyyy-mm-dd',
			autoclose: 'true'
		 });
		
		
		
		$('#tbl-form-pem-reg').on('change','.cek',function(){
			if (this.checked) {
				
		     	$(this).parent().parent().parent().find('.input-lg').removeAttr('disabled');
		    }
		    else
		    {
		    	$(this).parent().parent().parent().find('.input-lg').attr('disabled',true);
		    	$(this).parent().parent().parent().find('.input-lg').val('');
		    }

		}); 
		
		
		$('#btn-submit-inidet').click(function(){
			
			
			 var url = baseUrl + '/planning/inisialisasi/detail-save';
			 if(!$('#catatan').val()) {
					$.smallBox({
						//height: 50,
						title : "Error",
						content : 'Catatan can\'t be empty',
						color : "#dc3912",
						sound_file: "smallbox",
						timeout: 3000
						//icon : "fa fa-bell swing animated"
					});
					$('#catatan').focus();
					return;
			 }
			 
			 if(!$('#tanggal_pemeriksaan').val()) {
					$.smallBox({
						//height: 50,
						title : "Error",
						content : 'Tanggal Periksa can\'t be empty',
						color : "#dc3912",
						sound_file: "smallbox",
						timeout: 3000
						//icon : "fa fa-bell swing animated"
					});
					$('#tanggal_pemeriksaan').focus();
					return;
			}

			var arlist = [];
			var r = 1;
			var jumlahUtama = parseInt($('#rencana_jumlah').text());
			$('#tbl-form-pem-reg>tbody>tr').each(function(){

				var ob = new Object();
				var ck = ($(this).find('input[name="cek[]"]').is(':checked')) ? "yes" : "no";
				var j = parseInt($(this).find('input[name="jumlah[]"]').val());
				var nm =  $(this).find('.p_nama').text(); 
				if(ck=="yes" && j=='')
				{
					r = 0;
					$.smallBox({
						//height: 50,
						title : "Error",
						content : nm+'  can\'t be empty',
						color : "#dc3912",
						sound_file: "smallbox",
						timeout: 6000
						//icon : "fa fa-bell swing animated"
					});
					$('#tbl-form-pem').focus();
					return;
					
				}
				else if(ck=="yes" && j > jumlahUtama)
				{
					r = 0;
					$.smallBox({
						//height: 50,
						title : "Error",
						content : nm+' jumlaha melebihi Rencana Jumlah Peserta',
						color : "#dc3912",
						sound_file: "smallbox",
						timeout: 6000
						//icon : "fa fa-bell swing animated"
					});
					$('#tbl-form-pem-reg').focus();

					return;
				}
				else
				{
					ob.id_p = $(this).find('.id_pqc').text();
					ob.jumlah =  $(this).find('input[name="jumlah[]"]').val();
					ob.cek =    ck;
					arlist.push(ob);

				}	
				

			}); 
			
			
			if(r==1)
			{
				$('.page-loader').removeClass('hidden');
				// Send data
				$.ajax({ 
						url: url,
						type: 'POST',
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						data: {
							id : $('#id_ini').val(), //id inisilaisai
							registrasi : JSON.stringify(arlist),
							rencana_jumlah : $('#rencana_jumlah').val(),
							tanggal_pemeriksaan : $('#tanggal_pemeriksaan').val(),
							catatan : $('#catatan').val(),
							
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
});      

</script>
@endsection
