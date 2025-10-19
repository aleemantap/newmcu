@extends('layouts.app')

@section('ribbon')
<ul class="breadcrumb">
    <li><a>Database</a></li>
    <li><a href="{{url('report-sending-wa/')}}">Report Sending WA</a></li>
    <li>Detail WA</li>
</ul>
@endsection

@section('content')
<div class="container">
    <div class="row">        
        <div class="col-12 mt-5">
            @csrf
            <input  type="hidden" id="mcu_id" value="{{$data?$data->id:''}}">
            <div class="card">
                <div class="card-body" id="tab-identitas" role="tabpanel">
                    <div class="panel panel-report" style="margin-top: 15px;">
						<div class="panel-heading bg-primary">
                            <strong><i class="fa fa-th-large"></i> WA</strong>
                        </div>                       
                        <div class="panel-body px-5"> 
                            <div class="form-horizontal row">                                
                                <div class="col-md-6">
									<input type="hidden" value="{{$msg_id}}" id="msg-id"/>
                                    <div class="form-group row mt-3">
                                        <label for="" class="col-md-4"><span>MCU ID</span></label>
                                        <div class="col-md-8 d-flex justify-content-sm-left">
											<span id="id-mcu">{{$data?$data->id:''}}</span>
										</div>
                                    </div>
									<div class="form-group row">
                                        <label for="" class="col-md-4">Nama</label>
                                        <div class="col-md-8 d-flex justify-content-sm-left"><span id="nama-mcu">{{$data?$data->nama_pasien:''}}</span></div>
                                    </div>
									<div class="form-group row">
                                        <label for="" class="col-md-4">No HP</label>
                                        <div class="col-md-4">
											<input type="text" class="form-control form-control-sm" value="{{$data?$data->telepon:''}}" id="no-hp"/>
										</div>
										<div class="col-md-2">
											 <button class="btn btn-primary btn-xs btn-flat" style="float:left;" type="button" id="btn-cek-hp">Check No HP</button>
										</div>
										<div class="col-md-2">
											 <button class="btn btn-primary btn-xs btn-flat" style="float:left;" type="button" id="btn-save-hp">Update No HP</button>
										</div>
                                    </div>									
									<div class="form-group row">									    
										 <div class="col-md-6  d-flex justify-content-sm-left">
											<button class="btn btn-primary btn-xs btn-flat" style="float:right;" type="button" id="btn-resend">Re-Send WA</button>
										 </div>
										 <div class="col-md-6">											
										 </div>
                                    </div>									
									<div class="form-group row">
                                        <label for="" class="col-md-4">Status WA</label>
                                        <div class="col-md-8">
											<span class="text-primary" style="font-size:18px;">{{$sts_wa}}</span>											
											<input type="hidden" value="{{$sts_wa}}" id="sts-wa"/>
										</div>
                                    </div>
									<div class="form-group row">
                                        <label for="" class="col-md-4">Status Delivery</label>
                                        <div class="col-md-5">
											<span class="text-primary" style="font-size:18px;">{{$sts_del}}</span>
										</div>
										<div class="col-md-3">
											 <button class="btn btn-primary btn-xs" style="float:left;" type="button" id="btn-get-new-sts">Get New Status Dalivery</button>
										</div>
                                    </div>
                                 </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a href="/report-sending-wa/" class="btn btn-success"><i class="fa fa-arrow-circle-left"></i> Back</a>
                            <span id="p-wait" style="display:none;color:red; font-weight:700; font-size:20px;margin-left:200px;"> Please Wait ...</span>
                        </div>
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
    $(document).ready(function(){
	$('#btn-cek-hp').click(function(){
		
				  $('.page-loader').removeClass('hidden');
				  $.ajax({
					url: baseUrl + '/report-sending-wa/check-number',
					type: 'POST',
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data: {'hp':$('#no-hp').val()},
					success: function(resp) {
						if(resp.responseCode === 200) {
							//$("#process_id").val(resp.processId);
							//checkProcess(resp.processId);
							alert("No. HP is "+resp.responseMessage);
							
							
						} else {
							//$("#process_id").val("");
							
							Lobibox.notify('success', {
								sound: true,
								icon: true,
								msg :  resp.responseMessage,
							});
						}
						$('.page-loader').addClass('hidden');
					},
					error: function(xhr, ajaxOptions, thrownError) {
						$("#process_id").val("");
						    Lobibox.notify('error', {
								sound: true,
								icon: true,
								msg : xhr.statusText,
							});
						$('.page-loader').addClass('hidden');
					}
				});
		
	});
		
     $('#btn-get-new-sts').click(function(){
		 
		 if($('#msg-id').val()=="")
		 {
			 alert("Can't sending. Status delivery not_exits or failed.\n Please fix and  update No.HP or Re-Send !!");
		 }
		 else if($("#no-hp").val()=="")
		 {
			alert("No Hp kosong");
		 }
		 else
		 {
				  // Show loader
				  $('.page-loader').removeClass('hidden');
				  $.ajax({
					url: baseUrl + '/report-sending-wa/get-new-sts-delivery',
					type: 'POST',
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data: {'hp':$('#no-hp').val(),'mcu_id':$('#mcu_id').val()},
					success: function(resp) {
						if(resp.responseCode === 200) {
							//$("#process_id").val(resp.processId);
							//checkProcess(resp.processId);
							Lobibox.notify('success', {
								sound: true,
								icon: true,
								msg :  resp.responseMessage,
							});
							// alert('Pleas wait ....');
							$("#p-wait").show();
							setTimeout(function(){
								  //location.reload();
								  window.location.replace(baseUrl+"/report-sending-wa/sts-wa/"+$('#mcu_id').val());
							}, 7000);
							
							
						} else {
							//$("#process_id").val("");
						
							Lobibox.notify('error', {
								sound: true,
								icon: true,
								msg :  resp.responseMessage,
							});
						}
						$('.page-loader').addClass('hidden');
					},
					error: function(xhr, ajaxOptions, thrownError) {
						$("#process_id").val("");
						   Lobibox.notify('error', {
								sound: true,
								icon: true,
								msg :  xhr.statusText,
							});
						$('.page-loader').addClass('hidden');
					}
				});
		 }
	 
	 });	
		
	 $('#btn-resend').click(function(){
		
		// Show loader
		if($("#no-hp").val()=="")
		{
			alert("No Hp kosong. Silahkan isi no HP \n dan Klik Tombol (Update No HP), untuk menyimpan perubahan ");
		}
		// else if($('#sts-wa').val()=="not_exists" || $('#sts-wa').val()=="failed" || $('#sts-wa').val()=="")
		// {
		// 	alert("Can't sending. Status WA not_exits or failed.\n Please fix and  update No.HP  !!");
		// }
		else
		{
		 
		  $('.page-loader').removeClass('hidden');
		  $.ajax({ 
            url: baseUrl + '/report-sending-wa/resend-wa',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'hp':$('#no-hp').val(),'mcu_id':$('#mcu_id').val()},
            success: function(resp) {
                if(resp.responseCode === 200) {
					//$("#process_id").val(resp.processId);
                    //checkProcess(resp.processId);
					Lobibox.notify('success', {
								sound: true,
								icon: true,
								msg :  resp.responseMessage,
							});
					//alert('Pleas wait !!');
					$("#p-wait").show();
					setTimeout(function(){
						  //location.reload();
						  window.location.replace(baseUrl+"/report-sending-wa/sts-wa/"+$('#mcu_id').val());
					}, 10000);
					
				}else if(resp.responseCode === 201) {

				
						Lobibox.notify('error', {
							sound: true,
							icon: true,
							msg :  resp.responseMessage,
						});
				
					
                } else {
					//$("#process_id").val("");
                 	Lobibox.notify('error', {
							sound: true,
							icon: true,
							msg :  resp.responseMessage,
						});
				
                }
                $('.page-loader').addClass('hidden');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $("#process_id").val("");
					Lobibox.notify('error', {
						sound: true,
						icon: true,
						msg : xhr.statusText,
					});
				
                $('.page-loader').addClass('hidden');
            }
         });
	   }
		
	});
		
     
    $('#btn-save-hp').click(function(){
		
        if(!$('#no-hp').val()) {
             	    Lobibox.notify('warning', {
						sound: true,
						icon: true,
						msg : xhr.statusText,
					});
            return;
        }
		
		
		
        // Show loader
        $('.page-loader').removeClass('hidden');
        $.ajax({
            url: baseUrl + '/report-sending-wa/update-wa', 
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            //processData: false, // prevent jQuery from automatically transforming the data into a query string
            //contentType: false, // is imperative, since otherwise jQuery will set it incorrectly.
            data: {'hp':$('#no-hp').val(),'mcu_id':$('#mcu_id').val()},
            success: function(resp) {
                if(resp.responseCode === 200) {
					//$("#process_id").val(resp.processId);
                    //checkProcess(resp.processId);
					Lobibox.notify('success', {
						sound: true,
						icon: true,
						msg : resp.responseMessage,
					});
					//alert('Pleas wait !!');
					$("#p-wait").show();
					setTimeout(function(){
						  //location.reload();
						  window.location.replace(baseUrl+"/report-sending-wa/sts-wa/"+$('#mcu_id').val());
					}, 7000);
					
					
                } else {
					//$("#process_id").val("");
                 	Lobibox.notify('error', {
						sound: true,
						icon: true,
						msg : resp.responseMessage,
					});
                }
                $('.page-loader').addClass('hidden');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $("#process_id").val("");
				    Lobibox.notify('error', {
						sound: true,
						icon: true,
						msg :  xhr.statusText,
					});
                $('.page-loader').addClass('hidden');
            }
        });

       
    });

		
		
});      
	
   </script>
@endsection
