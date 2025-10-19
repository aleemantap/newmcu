@extends('layouts.app')
@section('css')
    @include('layouts.datatableCss')    
@endsection

@section('ribbon')
<ul class="breadcrumb">
    <li><a>Database</a></li>
    <li><a href="{{url('database/medical-check-up/')}}">Medical Check Up</a></li>
    <li>Show Foto Rontgen</li>
</ul>
@endsection
@section('title', $title_page_left)
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-5">        
            <div class="card">
                @csrf
                <input readonly type="hidden" name="mcu_id" value="">
                <div class="card-body">
                    <div class="panel panel-report" id="tab-identitas" role="tabpanel">
                        <div class="panel-heading bg-primary">
                            <strong><i class="fa fa-th-large"></i> Rontgen</strong>
                        </div>
                        <div class="panel-body px-5">                           
                                <div class="form-horizontal row p-4">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="" class="control-label col-md-4">MCU ID</label>
                                            <div class="col-md-8"><input readOnly type="text" class="form-control form-control-sm" value="{{$mcu_id}}" id="id-mcu"/></div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="control-label col-md-4">Nama</label>
                                            <div class="col-md-8"><input readOnly type="text" class="form-control form-control-sm" value="{{$nama}}" id="nama-mcu"/></div>
                                        </div>
                                        <div class="form-group row" id="hide-gambar" style="">
                                            <label for="" class="control-label col-md-4">Foto</label>
                                            <div class="col-md-8 text-center">
                                                    <div id="show-gambar">
                                                        <img src="{{$foto}}" width="200" height="200" />
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                                <label for="" class="control-label col-md-4">Upload Foto</label>
                                                <div class="col-md-8">
                                                    <input accept="image/*" id="file" type="file" name="file" class="form-control form-control-sm">
                                                </div>
                                        </div>
                                        <div class="form-group row  mt-4">
                                            <div class="col-md-12 text-right">
                                                <button class="btn btn-primary btn-sm btn-flat" type="button" id="btn-save-rng">Save</button>

                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="panel-footer mt-5">
                                    <a class="btn btn-success btn-sm btn-flat text-light"  onclick="history.back()"><i class="fa fa-arrow-circle-left text-light"></i> Back</a>
                                
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
<script src="{{ asset('js/libs/jquery-ui.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
		
		
     // Import mcu
    $('#btn-save-rng').click(function(){
		
        if(!$('#file').val()) {
            $.smallBox({
                height: 50,
                title : "Warning",
                content : 'Please select file to upload',
                color : "#c79121",
                sound_file: "smallbox",
                timeout: 3000
            });

            return;
        }
		 // Show loader
         $('.page-loader').removeClass('hidden');
		 // Create form data
        var form = new FormData();
        form.append('file', $('#file')[0].files[0]);
        form.append('id', $('#id-mcu').val());

       
        $.ajax({
            url: baseUrl + '/database/medical-check-up/import-rng',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData: false, // prevent jQuery from automatically transforming the data into a query string
            contentType: false, // is imperative, since otherwise jQuery will set it incorrectly.
            data: form,
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
