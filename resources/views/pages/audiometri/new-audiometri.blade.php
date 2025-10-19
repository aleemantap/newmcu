<div class="modal fade" id="modal-audiometri">
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
            <form class="form-horizontal" id="form-audiometri">
                <div class="modal-header bg-dark no-border">
                    <h4 class="modal-title">New Audiometri</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-8"><input type="hidden" class="form-control input-xs" id="audiometri-id"></div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">@lang('audiometri.patient_id')</label>
                        <div class="col-md-8"><input type="text" class="form-control form-control-sm" id="id-pasien"></div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">Project</label>
                        <div class="col-md-8">
                            <select class="form-control input-xs" id="perusahaan">
                                <option>&raquo; All Project</option>
                                @foreach($project as $c)
                                <option value="{{ $c->id }}">{{ $c->vendor->name }} - {{ $c->customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">@lang('audiometri.input_date')</label>
                        <div class="col-md-8"><input type="text" class="form-control form-control-sm datepicker" id="tgl-input"></div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">@lang('audiometri.frequency')</label>
                        <div class="col-md-8"><input type="number" class="form-control form-control-sm" id="frekuensi"></div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">@lang('audiometri.left')</label>
                        <div class="col-md-8"><input type="number" class="form-control form-control-sm" id="kiri"></div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">@lang('audiometri.right')</label>
                        <div class="col-md-8"><input type="number" class="form-control form-control-sm" id="kanan"></div>
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
