@extends('layouts.app')
@section('css')
    @include('layouts.datatableCss')    
@endsection
@section('title', $title_page_left)
@section('ribbon')
<ul class="breadcrumbs pull-left">
	<li><a href="/home">Home</a></li>
    <li><a href="/">Sign</a></li>
    <li><span>Dokter Specialis</span></li>   
</ul>
@endsection

@section('content')
<div class="">   
    <div class="row">
        <div class="col-md-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <div class="panel panel-report">
                        <div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Audiometri</strong></div>
                        <div class="panel-body mt-5">
                            <div class="form-horizontal" id="form">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row ">
                                            <label for="" class="control-label col-md-2">@lang('tools.select_file')</label>
                                            <div class="col-md-6">
                                                <input accept="png,jpeg" type="file" id="file_a" class="form-control input-xs">
                                                <span class="help-block">Only .png format</span>
                                            </div>
                                        </div>   
                                        <div class="form-group row">
                                            <label for="" class="control-label col-md-2">Nama Dokter</label>
                                            <div class="col-md-6">
                                                <input  type="text" id="nama_dokter_a" class="form-control input-xs" value="{{$nama_a}}">
                                                <span class="help-block">Isi Nama Lengkap dan gelarnya</span>
                                            </div>
                                        </div>                    
                                    </div>
                                    <div class="col-md-3">
                                        <div class="">
                                            <img id="show-a" height="162" width="311" src="{{$ttd_a}}" alt=""/>
                                        </div>                    
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="panel-footer" style="justify-content:left;">
                            <button type="button" class="btn btn-primary btn-flat btn-sm" id="btn-submit-a"><i class="fa fa-check-circle"></i> Save</button>
                            <span id="load-restore-a"><img width="30" src={{asset('images/loading-loading-forever.gif')}} /></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="">   
    <div class="row">
        <div class="col-md-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <div class="panel panel-report">
                        <div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> Rontgen</strong></div>
                        <div class="panel-body mt-5">
                            <div class="form-horizontal" id="form">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="" class="control-label col-md-2">@lang('tools.select_file')</label>
                                                <div class="col-md-6">
                                                    <input accept="png,jpeg" type="file" id="file_r" class="form-control input-xs">
                                                    <span class="help-block">Only .png format</span>

                                                </div>
                                            </div>   
                                            <div class="form-group row">
                                                <label for="" class="control-label col-md-2">Nama Dokter</label>
                                                <div class="col-md-6">
                                                    <input  type="text" id="nama_dokter_r" class="form-control input-xs" value="{{$nama_r}}">
                                                    <span class="help-block">Isi Nama Lengkap dan gelarnya</span>
                                                </div>
                                            </div>                       
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <img id="show-r" height="162" width="311" src="{{$ttd_r}}" alt=""/>
                                            </div>                    
                                        </div>
                                    </div>
                                
                            </div>
                        </div>
                        <div class="panel-footer" style="justify-content:left;">
                               <button type="button" class="btn btn-primary btn-flat btn-sm" id="btn-submit-r"><i class="fa fa-check-circle"></i> Save</button>
                               <span id="load-restore-r"><img width="30" src={{asset('images/loading-loading-forever.gif')}} /></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="">   
    <div class="row">
        <div class="col-md-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <div class="panel panel-report">
                        <div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> EKG</strong></div>
                        <div class="panel-body mt-5">
                            <div class="form-horizontal" id="form">
                                  
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="" class="control-label col-md-2">@lang('tools.select_file')</label>
                                            <div class="col-md-6">
                                                <input accept="png,jpeg" type="file" id="file_e" class="form-control input-xs">
                                                <span class="help-block">Only .png format</span>

                                            </div>
                                        </div>       
                                        <div class="form-group row">
                                            <label for="" class="control-label col-md-2">Nama Dokter</label>
                                            <div class="col-md-6">
                                                <input type="text" id="nama_dokter_e" class="form-control input-xs"value="{{$nama_e}}" >
                                                <span class="help-block">Isi Nama Lengkap dan gelarnya</span>
                                            </div>
                                        </div>                  
                                    </div>
                                    <div class="col-md-3">
                                        <div class="">
                                            <img src="{{$ttd_e}}" height="162" width="311"  alt=""/>
                                        </div>                    
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="panel-footer" style="justify-content:left;">
                               <button type="button" class="btn btn-primary btn-flat btn-sm" id="btn-submit-e"><i class="fa fa-check-circle"></i> Save</button>
                              <span id="load-restore-e"><img width="30" src={{asset('images/loading-loading-forever.gif')}} /></span>
               
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="mb-5">   
    <div class="row">
        <div class="col-md-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <div class="panel panel-report">
                        <div class="panel-heading bg-primary"><strong><i class="fa fa-th-large"></i> SPIROMETRI</strong></div>
                        <div class="panel-body mt-5">
                            <div class="form-horizontal" id="form">
                                   <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label for="" class="control-label col-md-2">@lang('tools.select_file')</label>
                                                <div class="col-md-6">
                                                    <input accept="png,jpeg" type="file" id="file_sp" class="form-control input-xs">
                                                    <span class="help-block">Only .png format</span>

                                                </div>
                                            </div>       
                                            <div class="form-group row">
                                                <label for="" class="control-label col-md-2">Nama Dokter</label>
                                                <div class="col-md-6">
                                                    <input type="text" id="nama_dokter_sp" class="form-control input-xs"value="{{$nama_sp}}" >
                                                    <span class="help-block">Isi Nama Lengkap dan gelarnya</span>
                                                </div>
                                            </div>                  
                                        </div>
                                        <div class="col-md-3">
                                            <div class="">
                                                <img src="{{$ttd_sp}}" height="162" width="311"  alt=""/>
                                            </div>                    
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="panel-footer" style="justify-content:left;">
                               <button type="button" class="btn btn-primary btn-flat btn-sm" id="btn-submit-sp"><i class="fa fa-check-circle"></i> Save</button>
                               <span id="load-restore-sp"><img width="30" src={{asset('images/loading-loading-forever.gif')}} /></span>
                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function(){
       
		// audiometri
		$('#load-restore-a').hide();
		$('#btn-submit-a').click(function(){
			
			if(!$('#file_a').val()) {
               
                   Lobibox.notify('warning', {
                        sound: true,
                        icon: true,
                        msg : 'Please select image to upload',
                    });

                return;
           }

           if(!$('#nama_dokter_a').val()) {
                    Lobibox.notify('warning', {
                        sound: true,
                        icon: true,
                        msg : 'Nama Dokter Tidak boleh kosong',
                    });
                return;
           }

		
		 // Create form data
        var form = new FormData();
        form.append('file', $('#file_a')[0].files[0]);
        form.append('nama_dokter', $('#nama_dokter_a').val());
      
        // Show loader
        $('.page-loader').removeClass('hidden');
		$('#load-restore-a').show();
        $.ajax({
            url: baseUrl + '/sign-dokter/saveAudio',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData: false, // prevent jQuery from automatically transforming the data into a query string
            contentType: false, // is imperative, since otherwise jQuery will set it incorrectly.
            data: form,
            success: function(resp) {
                if(resp.responseCode === 200) {
				    Lobibox.notify('success', {
                        sound: true,
                        icon: true,
                        msg : resp.responseMessage,
                    });
                    // console.log("RESP",resp.file)
                    // $("#show-a").attr("src",resp.file);
					
                    $('#load-restore-a').hide();
                    location.reload();
					
                } else {
				    Lobibox.notify('error', {
                        sound: true,
                        icon: true,
                        msg : resp.responseMessage,
                    });
                }
                $('.page-loader').addClass('hidden');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                 Lobibox.notify('error', {
                        sound: true,
                        icon: true,
                        msg : xhr.statusText,
                    });
                $('.page-loader').addClass('hidden');
            }
        });
			
		});

        //RONTGEN
        $('#load-restore-r').hide();
		$('#btn-submit-r').click(function(){
			
			if(!$('#file_r').val()) {
               
                Lobibox.notify('warning', {
                        sound: true,
                        icon: true,
                        msg : 'Please select image rontgen to upload',
                    });
                return;
           }

           if(!$('#nama_dokter_r').val()) {
               
                Lobibox.notify('warning', {
                        sound: true,
                        icon: true,
                        msg : 'Nama Dokter Rontgen Tidak boleh kosong',
                    });
                return;

             
           }

		
		 // Create form data
        var form = new FormData();
        form.append('file', $('#file_r')[0].files[0]);
        form.append('nama_dokter', $('#nama_dokter_r').val());
      
        // Show loader
        $('.page-loader').removeClass('hidden');
		$('#load-restore-r').show();
        $.ajax({
            url: baseUrl + '/sign-dokter/saveRontgen',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData: false, // prevent jQuery from automatically transforming the data into a query string
            contentType: false, // is imperative, since otherwise jQuery will set it incorrectly.
            data: form,
            success: function(resp) {
                if(resp.responseCode === 200) {
				      Lobibox.notify('success', {
                        sound: true,
                        icon: true,
                        msg : resp.responseMessage,
                        });
					$('#load-restore-r').hide();
                    location.reload();
					
                } else {
					
                        Lobibox.notify('error', {
                        sound: true,
                        icon: true,
                        msg : resp.responseMessage,
                        });
                }
                $('.page-loader').addClass('hidden');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                    Lobibox.notify('error', {
                    sound: true,
                    icon: true,
                    msg : xhr.statusText,
                    });
				
                $('.page-loader').addClass('hidden');
            }
        });
			
		});

        //EKG
        $('#load-restore-e').hide();
		$('#btn-submit-e').click(function(){
			
			if(!$('#file_e').val()) {
               
                Lobibox.notify('warning', {
                    sound: true,
                    icon: true,
                    msg : 'Please select image EKG to upload',
                });
                return;
           }

           if(!$('#nama_dokter_e').val()) {
               
                 Lobibox.notify('warning', {
                    sound: true,
                    icon: true,
                    msg : 'Nama Dokter EKG Tidak boleh kosong',
                });
                return;
           }

		
		 // Create form data
        var form = new FormData();
        form.append('file', $('#file_e')[0].files[0]);
        form.append('nama_dokter', $('#nama_dokter_e').val());
      
        // Show loader
        $('.page-loader').removeClass('hidden');
		$('#load-restore-e').show();
        $.ajax({
            url: baseUrl + '/sign-dokter/saveEkg',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData: false, // prevent jQuery from automatically transforming the data into a query string
            contentType: false, // is imperative, since otherwise jQuery will set it incorrectly.
            data: form,
            success: function(resp) {
                if(resp.responseCode === 200) {
                    Lobibox.notify('success', {
                        sound: true,
                        icon: true,
                        msg : resp.responseMessage,
                    });
					$('#load-restore-e').hide();
                    location.reload();
					
                } else {
				    Lobibox.notify('error', {
                        sound: true,
                        icon: true,
                        msg : resp.responseMessage,
                    });
                }
                $('.page-loader').addClass('hidden');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                    Lobibox.notify('error', {
                        sound: true,
                        icon: true,
                        msg : xhr.statusText,
                    });
                $('.page-loader').addClass('hidden');
            }
        });
			
		});
        //SPIRO
        $('#load-restore-sp').hide();
		$('#btn-submit-sp').click(function(){
			
			if(!$('#file_sp').val()) {
                  Lobibox.notify('warning', {
                        sound: true,
                        icon: true,
                        msg :'Please select image SPIRO to upload',
                    });

                return;
           }

           if(!$('#nama_dokter_sp').val()) {
                Lobibox.notify('warning', {
                        sound: true,
                        icon: true,
                        msg :'Nama Dokter SPIRO Tidak boleh kosong',
                    });
                return;
           }

		
		 // Create form data
        var form = new FormData();
        form.append('file', $('#file_sp')[0].files[0]);
        form.append('nama_dokter', $('#nama_dokter_sp').val());
      
        // Show loader
        $('.page-loader').removeClass('hidden');
		$('#load-restore-sp').show();
        $.ajax({
            url: baseUrl + '/sign-dokter/saveSpiro',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData: false, // prevent jQuery from automatically transforming the data into a query string
            contentType: false, // is imperative, since otherwise jQuery will set it incorrectly.
            data: form,
            success: function(resp) {
                if(resp.responseCode === 200) {
                        
                        Lobibox.notify('success', {
                            sound: true,
                            icon: true,
                            msg : resp.responseMessage,
                        });
					$('#load-restore-sp').hide();
                    location.reload();
					
                } else {
				                      
                    Lobibox.notify('error', {
                        sound: true,
                        icon: true,
                        msg : resp.responseMessage,
                    });
                }
                $('.page-loader').addClass('hidden');
            },
            error: function(xhr, ajaxOptions, thrownError) {
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
