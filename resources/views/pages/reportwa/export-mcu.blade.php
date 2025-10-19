<div class="modal fade" id="modal-export">
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
            <form class="form-horizontal" id="form-rontgen" action="{{url('/database/medical-check-up/export')}}" method="post">
                @csrf
                <div class="modal-header bg-dark no-border">
                    <h4 class="modal-title">Export MCU</h4>
                </div>
                <div class="modal-body">

                    <div class="alert alert-danger">
                        <i class="fa fa-warning"></i> Export may fail when filter range or data too big!. Please less your filter range.
                    </div>

                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">Perusahaan</label>
                        <div class="col-md-8">
                            <select class="form-control input-xs" id="customer" name="idPerusahaan">
                                <option value="">&raquo; Semua Perusahaan</option>
                                @foreach($customers as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">Client</label>
                        <div class="col-md-8">
                            <select class="form-control input-xs" id="customer" name="idPerusahaan">
                                <option value="">&raquo; Semua Client</option>
                                @foreach($customers as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">Bagian</label>
                        <div class="col-md-8">
                            <select class="form-control input-xs" id="customer" name="idPerusahaan">
                                <option value="">&raquo; Semua Bagian</option>
                                @foreach($customers as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <input type="hidden" class="form-control input-xs" id="rontgen-id">
                        <label for="" class="control-label col-md-4">Tgl. Input</label>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-5"><input type="text" class="form-control input-xs datepicker" name="startDate" id="from-date"></div>
                                <label class="col-md-2 control-label">To</label>
                                <div class="col-md-5"><input type="text" class="form-control input-xs datepicker" name="endDate" id="to-date"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btn-export"><i class="fa fa-check-circle"></i> @lang('general.submit')</button>
                    <button class="btn btn-default" data-dismiss="modal">@lang('general.close')</button>
                </div>
            </form>
        </div>
    </div>
</div>
