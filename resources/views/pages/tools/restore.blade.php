@extends('layouts.app')

@section('ribbon')
<ol class="breadcrumb">
    <li>@lang('tools.tools')</li>
    <li>@lang('tools.restore_database')</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <strong><i class="fa fa-th-large"></i> @lang('tools.restore_database')</strong>
            </div>
            <div class="panel-body">
                <div class="form-horizontal" id="form-backup">
                    <div class="form-group row">
                        <label for="" class="control-label col-md-2">@lang('tools.select_file')</label>
                        <div class="col-md-4">
                            <input accept=".sql" type="file" id="file" class="form-control input-xs">
                            <span class="help-block">@lang('tools.file_info')</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer" style="justify-content:left;">
                <button type="button" class="btn btn-primary" id="btn-submit-r"><i class="fa fa-check-circle"></i> @lang('general.submit')</button>
				<span id="load-restore"><img width="30" src={{asset('images/loading-loading-forever.gif')}} /></span>
			</div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function(){
        $('.backup-type').click(function(){
            if($(this).val() == 2) {
                $('#table-container').removeClass('hidden');
            } else {
                $('#table-container').addClass('hidden');
            }
        })
		
		$('#load-restore').hide();
		$('#btn-submit-r').click(function(){
			
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
		
		 // Create form data
        var form = new FormData();
        form.append('file', $('#file')[0].files[0]);
       

        // Show loader
        $('.page-loader').removeClass('hidden');
		$('#load-restore').show();
        $.ajax({
            url: baseUrl + '/tools/restore-database-command',
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
					$('#load-restore').hide();
					setTimeout(function(){
						  //location.reload();
						  $('#log-out-c').trigger('click');
					}, 1000);
					
				
					
					
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
