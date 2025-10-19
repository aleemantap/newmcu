@extends('layouts.app')

@section('ribbon')
<ul class="breadcrumb">
    <li><a>Database</a></li>
    <li><a href="{{url('database/medical-check-up/')}}">Medical Check Up</a></li>
    <li>WA</li>
</ul>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        
        <div>
            @csrf
            <input  type="hidden" id="mcu_id" value="{{$data?$data->id:''}}">
            <div class="tab-content">
                <div class="tab-pane fade active in" id="tab-identitas" role="tabpanel">
                    <div class="panel" style="margin-top: 15px;">
                        <div class="panel-heading bg-primary">WA</div>
                        <div class="panel-body">
                            <div class="form-horizontal row">
                                
                                <div class="col-md-6">
								
                                    <div class="form-group row">
                                        <label for="" class="control-label col-md-4">MCU ID</label>
                                        <div class="col-md-8">
											<span id="id-mcu">{{$data?$data->id:''}}</span>
										</div>
                                    </div>
									<div class="form-group row">
                                        <label for="" class="control-label col-md-4">Nama</label>
                                        <div class="col-md-8"><span id="nama-mcu">{{$data?$data->nama_pasien:''}}</span></div>
                                    </div>
									<div class="form-group row">
                                        <label for="" class="control-label col-md-4">No HP</label>
                                        <div class="col-md-5">
											<input type="text" value="{{$data?$data->telepon:''}}" id="no-hp"/>
										</div>
										<div class="col-md-3">
											 <button class="btn btn-success btn-xs" style="float:left;" type="button" id="btn-save-hp">Update No HP</button>
										</div>
                                    </div>
									<div class="form-group row">
                                        <label for="" class="control-label col-md-4">Status WA</label>
                                        <div class="col-md-8">
											<span class="text-success" style="font-size:18px;">{{$data->reportsendwa->status}}</span>
										</div>
                                    </div>
                                   
									<div class="form-group row">
                                         <button class="btn btn-primary btn-xs" style="float:right;" type="button" id="btn-resend">Re-Send WA</button>
                                    </div>
                                 </div>
								 
                            </div>
							
                        </div>
                        <div class="panel-footer">
                            <a href="/database/medical-check-up" class="btn btn-success"><i class="fa fa-arrow-circle-left"></i> Back</a>
                           
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
		
		
	$('#btn-resend').click(function(){
		
		 // Show loader
         $('.page-loader').removeClass('hidden');
		  $.ajax({
            url: baseUrl + '/database/medical-check-up/resend-wa',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'hp':$('#no-hp').val(),'mcu_id':$('#mcu_id').val()},
            success: function(resp) {
                if(resp.responseCode === 200) {
					//$("#process_id").val(resp.processId);
                    //checkProcess(resp.processId);
					$.smallBox({
                        height: 50,
                        title : "Success",
                        content : resp.responseMessage,
                        color : "#109618",
                        sound_file: "voice_on",
                        timeout: 3000
                        //icon : "fa fa-bell swing animated"
                    });
					
					setTimeout(function(){
						  location.reload();
					}, 7000);
					
					
                } else {
					//$("#process_id").val("");
                    $.smallBox({
                        height: 50,
                        title : "Error",
                        content : resp.responseMessage,
                        color : "#dc3912",
                        sound_file: "smallbox",
                        timeout: 3000
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
		
     
    $('#btn-save-hp').click(function(){
		
        if(!$('#no-hp').val()) {
            $.smallBox({
                height: 50,
                title : "Warning",
                content : 'Empty No HP',
                color : "#c79121",
                sound_file: "smallbox",
                timeout: 3000
            });

            return;
        }
		
		
		
        // Show loader
        $('.page-loader').removeClass('hidden');
        $.ajax({
            url: baseUrl + '/database/medical-check-up/update-wa',
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
					$.smallBox({
                        height: 50,
                        title : "Success",
                        content : resp.responseMessage,
                        color : "#109618",
                        sound_file: "voice_on",
                        timeout: 3000
                        //icon : "fa fa-bell swing animated"
                    });
					
					setTimeout(function(){
						  location.reload();
					}, 500);
					
					
                } else {
					//$("#process_id").val("");
                    $.smallBox({
                        height: 50,
                        title : "Error",
                        content : resp.responseMessage,
                        color : "#dc3912",
                        sound_file: "smallbox",
                        timeout: 3000
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
	
   </script>
@endsection
