<div class="modal fade" id="modal-rontgen">
    <div class="modal-dialog">
        <div class="modal-content">
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
            <form class="form-horizontal" id="form-rontgen">
                <div class="modal-header bg-dark no-border">
                    <h4 class="modal-title">New Radiologi</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <input type="hidden" class="form-control input-xs" id="rontgen-id">
                        <label for="" class="control-label col-md-4">Id Pasien</label>
                        <div class="col-md-8"><input type="text" class="form-control form-control-sm" id="patient-id"></div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">Jenis Foto</label>
                        <div class="col-md-8">
                            <select class="form-control form-control-sm" id="foto-type">
                                <option value="">&raquo; Pilih Jenis Foto</option>
                                @foreach($fotoTypes as $ft)
                                <option value="{{ $ft->jenis_foto }}">{{ $ft->jenis_foto }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">Parameter</label>
                        <div class="col-md-8">
                            <select class="form-control form-control-sm" id="parameter">
                                <option value="">&raquo; Pilih Parameter</option>
                                @foreach($parameters as $prm)
                                <option value="{{ $prm->parameter }}">{{ $prm->parameter }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">Temuan</label>
                        <div class="col-md-8">
                            <select class="form-control input-xs" id="result">
                                <option value="">&raquo; Pilih Temuan</option>
                                @foreach($temuan as $t)
                                <option value="{{ $t->temuan }}">{{ $t->temuan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">Project</label>
                        <div class="col-md-8">
                            <select class="form-control form-control-sm" id="customer">
                                <option value="">&raquo; Semua Project</option>
                                @foreach($project as $c)
                                <option value="{{ $c->id }}">{{ $c->vendor->name }} - {{ $c->customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <input type="hidden" class="form-control input-xs" id="rontgen-id">
                        <label for="" class="control-label col-md-4">Tgl. Input</label>
                        <div class="col-md-8"><input type="text" class="form-control form-control-sm datepicker" id="input-date"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm btn-flat" id="btn-submit"><i class="fa fa-check-circle"></i> @lang('general.submit')</button>
                    <button class="btn btn-default btn-sm btn-flat" data-dismiss="modal">@lang('general.close')</button>
                </div>
            </form>
        </div>
    </div>
</div>
