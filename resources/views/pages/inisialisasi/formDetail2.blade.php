@extends('layouts.app')
@section('title', ' Rencana Pemeriksaan ')
@section('ribbon')
<ul class="breadcrumb">
    <li><a href="{{url('planning/inisialisasi/')}}">Inisialisasi</a></li>
    <li>Form Rencana Pemeriksaan</li>
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
                        <div class="panel-heading bg-primary">FORM Rencana Pemeriksaan TGL-PEMERIKSAAN : <span id="tmcuh">{{$detail?$detail->tgl_pemeriksaan:''}}</span></div>
                        <div class="panel-body">
							<form class="inputer customRadio customCheckbox">
								<input  type="hidden" name="id_inideta" id="id_inideta" value="{{$id?$id:''}}">
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
								<div class="col-md-6">
									
									<div class="form-group row">
												<label for="">Tanggal Pemeriksaan</label>
												<div  class="" style="width:100%;">{{$detail?$detail->tgl_pemeriksaan:''}}</div>
												<input type="hidden" placeholder="Tanggal Pemeriksaan" readOnly class="form-control datepicker input-xs" style="width:100%;" data-provide="datepicker" data-date-format="yyyy-mm-dd" name="tgl_pemeriksaan" id="tgl_pemeriksaan" value="{{$detail?$detail->tgl_pemeriksaan:''}}">
												
									</div>
									
									<div class="form-group row">
												<label for="">Jumlah Peserta</label>
												<div  class="" style="width:100%;">{{$detail?$detail->jumlah:''}}</div>
												<input type="hidden" placeholder="Jumlah Peserta" readOnly class="form-control datepicker input-xs" style="width:100%;"  name="jumlah_peserta" id="jumlah_peserta" value="{{$detail?$detail->jumlah:''}}">
												
									</div>
									
								</div> 
								<div class="col-md-12" style="border-bottom:1px solid #000;margin-bottom:20px;"></div>
								
								<div class="col-md-12">
									<div class="form-group row">
										<table class="table" id="tbl-form-pem">
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
												
												if($j->diperiksa == 'yes')
												{
													$cek = '<span><input type="checkbox" name="cek[]" class="cek" value="true" style="left:auto !important;" checked/></span>';
													$jum = '<input type="text" name="jumlah[]" class="form-control input-lg" style="width:50%;" value="'.$j->jumlah.'">';
												}
												
												echo '<tr>
													  <th scope="row">'.$no.'<span class="id_reg" style="display:none;">'.$j->idReg.'</span></th>
													  
													  <td><span class="id_p" style="display:none;">'.$j->id_jenis_pemeriksaan_qc.'</span><span class="p_nama">'.$j->nama.'</span></td>
													  <td >'.$cek.'<span class="idDetIni" style="display:none;">'.$j->idDetIni.'</span></td>
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
		
		 $('#tanggal_mcu').datepicker({
			format: 'yyyy-mm-dd',
			autoclose: 'true'
		 });
		
		 //  $("#rencana_jumlah").keyup(function(){
			// //console.log($(this).val());
			// let n = parseInt($(this).val());
			// $('#id_awal').val('1');
			// $('#id_akhir').val(n);
		 //  });
		
		$('#tbl-form-pem').on('change','.cek',function(){
			if (this.checked) {
				//alert('ok');
		     	$(this).parent().parent().parent().find('.input-lg').removeAttr('disabled');
		    }
		    else
		    {
		    	$(this).parent().parent().parent().find('.input-lg').attr('disabled',true);
		    	$(this).parent().parent().parent().find('.input-lg').val('');
		    }

		});
		
		
		$('#btn-submit-inidet').click(function(){
			
			// Update when user id has value
			var url = baseUrl + '/planning/inisialisasi/detail-update';
			
			
			
		
			 if(!$('#tgl_pemeriksaan').val()) {
					$.smallBox({
						//height: 50,
						title : "Error",
						content : 'Tanggal mcu can\'t be empty',
						color : "#dc3912",
						sound_file: "smallbox",
						timeout: 3000
						//icon : "fa fa-bell swing animated"
					});
					$('#tgl_pemeriksaan').focus();
					return;
			}

			var arlist = [];
			var r = 1;
			var jumlahUtama = parseInt($('#jumlah_utama').text());
			$('#tbl-form-pem>tbody>tr').each(function(){

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
						timeout: 3000
						//icon : "fa fa-bell swing animated"
					});
					$('#tanggal_mcu').focus();
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
						timeout: 3000
						//icon : "fa fa-bell swing animated"
					});
					$('#tbl-form-pem').focus();

					return;
				}
				else
				{
					ob.id_p = $(this).find('.id_p').text();
					ob.id_reg = $(this).find('.id_reg').text();
					ob.idDetIni = $(this).find('.idDetIni').text();
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
							id : $('#id_inideta').val(), //id inisilaisai
							registrasi : JSON.stringify(arlist),
							tgl_pemeriksaan : $('#tgl_pemeriksaan').val(),
							//rencana_jumlah : $('#rencana_jumlah').val(),
							//catatan : $('#catatan').val(),
							
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
