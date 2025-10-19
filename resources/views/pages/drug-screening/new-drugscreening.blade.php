<div class="modal fade" id="modal-drugscreening">
    <div class="modal-dialog">
        <div class="modal-content" style="width:34rem !important;">
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
            <form class="form-horizontal" id="form-drugscreening">
                <div class="modal-header bg-dark no-border">
                    <h4 class="modal-title">New drugscreening</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-8"><input type="hidden" class="form-control input-xs" id="drugscreening-id"></div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">Id Pasien</label>
                        <div class="col-md-8"><input type="text" class="form-control form-control-sm" id="id-pasien"></div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">Project (Vendor-Client)</label>
                        <div class="col-md-8">
                            <select class="form-control form-control-sm" id="perusahaan">
                                <option value="">&raquo; Semua Project</option>
                                @foreach($project as $c)
                                <option value="{{ $c->id }}">{{ $c->vendor->name }} - {{ $c->customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">Tgl. Input</label>
                        <div class="col-md-8"><input type="text" class="form-control form-control-sm datepicker" id="tgl-input"></div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">Tgl. Pemeriksaan</label>
                        <div class="col-md-8"><input type="text" class="form-control form-control-sm datepicker" id="tgl-pemeriksaan"></div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">Status Pemeriksaan</label>
                        <div class="col-md-8"><input type="text" class="form-control form-control-sm" id="status-pemeriksaan"></div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">Parameter</label>
                        <div class="col-md-8"><input type="text" class="form-control form-control-sm" id="parameter"></div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">Hasil</label>
                        <div class="col-md-8"><input type="text" class="form-control form-control-sm" id="hasil"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-flat btn-sm" id="btn-submit"><i class="fa fa-check-circle"></i> @lang('general.submit')</button>
                    <button class="btn btn-default btn-flat btn-sm" data-dismiss="modal">@lang('general.close')</button>
                </div>
            </form>
        </div>
    </div>
</div>
