@extends('layouts.app')

@section('ribbon')
<ol class="breadcrumb">
    <li>@lang('tools.tools')</li>
    <li>@lang('tools.backup_database')</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <strong><i class="fa fa-th-large"></i> @lang('tools.backup_database')</strong>
            </div>
            <div class="panel-body">
                <div class="form-horizontal" id="form-backup">
                    <div class="form-group row">
                        <label for="" class="control-label col-md-2">@lang('tools.filename')</label>
                        <div class="col-md-4">
                            <input type="text" id="formula-name" class="form-control input-xs" value="emcu_backup_{{ date('YmdHis') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-2">@lang('tools.backup_type')</label>
                        <div class="col-md-4">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="backup_type" class="backup-type" value="1" checked>
                                    @lang('tools.backup_all')
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="backup_type" class="backup-type" value="2">
                                    @lang('tools.backup_selected')
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group hidden" id="table-container">
                        <label class="control-label col-md-2"></label>
                        <div class="col-md-10">
                            <hr>
                            @lang('tools.select_backup_table')
                            <br>
                            <div class="row">
                                @foreach ($tables as $table)
                                    @foreach ($table as $key => $value)
                                        <div class="checkbox col-md-3">
                                            <label>
                                                <input type="checkbox" name="table" value="{{ $value }}">
                                                {{ $value }}
                                            </label>
                                        </div>
                                        {{-- <div class="badge bg-primary">{{ $value }}</div> --}}
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <button type="button" class="btn btn-primary" id="btn-submit-bc"><i class="fa fa-check-circle"></i> @lang('general.submit')</button>
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
		$('#btn-submit-bc').click(function(){
			window.location.href = baseUrl+"/tools/backup-database-command/"+$("#formula-name").val();
		});
		
    });
</script>
@endsection
