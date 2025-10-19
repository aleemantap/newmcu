<div class="modal fade" id="modal-import-drugscreening">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 40rem !important;">
            <div class="page-loader hidden">
                <div class="sk-circle">
                    <div class="sk-circle1 sk-child"></div>
                    <div class="sk-circle2 sk-child"></div>
                    <div class="sk-circle3 sk-child"></div>
                    <div class="sk-circle4 sk-child"></div>
                    <div class="sk-circle5 sk-child"></div>
                    <div class="sk-circle6 sk-child"></div>
                    <div class="sk-circle7 sk-child"></div>
                    <div class="sk-circle8 sk-child"></div>
                    <div class="sk-circle9 sk-child"></div>
                    <div class="sk-circle10 sk-child"></div>
                    <div class="sk-circle11 sk-child"></div>
                    <div class="sk-circle12 sk-child"></div>
                </div>
            </div>
            <form id="form-import-drugscreening">
                @csrf
                <div class="modal-header bg-dark no-border">
                    <h4 class="modal-title">Import Drug Screening</h4>
                </div>
                <div class="modal-body px-5">
                    <div class="input-form">
                        <div class="form-group row">
                            <div class="alert alert-info"><i class="fa fa-info-circle"></i> Sebelum melakukan import data, pastikan template excel yang digunakan sudah benar. Silakan unduh template di sini. <a href="{{ asset('template/template_drug_screening.xlsx') }}"><strong>Unduh template</strong></a>.</div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="control-label">Upload file</label>
                            <input accept=".xls, .xlsx, .csv" id="file" type="file" name="file" class="form-control input-xs">
                        </div>
                    </div>
                    <div class="input-progress hidden" style="margin: 50px 0">
                        <div class="progress">
                            <div id="upload-progress" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                              <span class="sr-only">0% Complete</span>
                            </div>
                        </div>
                        <div class="progress-text">0% Completed ... Please wait ...</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-import"><i class="fa fa-check-circle"></i> @lang('general.submit')</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('general.close')</button>
                </div>
            </form>
        </div>
    </div>
</div>
