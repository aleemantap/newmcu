<div class="modal fade" id="modal-delete-audiometri">
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
                    <h4 class="modal-title">@lang('general.bulk_delete') Audiometri</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">Id Pasien</label>
                        <div class="col-md-8"><input type="text" class="form-control form-control-sm" id="patient-id"></div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">Project (Vendor-Client)</label>
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
                        <input type="hidden" class="form-control form-control-sm" id="rontgen-id">
                        <label for="" class="control-label col-md-4">Tgl. Input</label>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-5"><input type="text" class="form-control form-control-sm datepicker" id="from-date"></div>
                                <label class="col-md-2 control-label">To</label>
                                <div class="col-md-5"><input type="text" class="form-control form-control-sm datepicker" id="to-date"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm btn-flat" id="btn-delete"><i class="fa fa-check-circle"></i> @lang('general.submit')</button>
                    <button class="btn btn-default  btn-sm btn-flat" data-dismiss="modal">@lang('general.close')</button>
                </div>
            </form>
        </div>
    </div>
</div>
