<div class="modal fade" id="modal-filter">
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
                <div class="modal-header bg-dark">
                    <h4 class="modal-title">Filter MCU</h4>
                </div>
                <div class="modal-body px-5">

                    <div class="form-group row">
                        <label for="id-pasien">Id Pasien</label>
                        <input type="text" class="form-control form-control-sm" id="id-pasien">
                    </div>
                    <div class="form-group row">
                        <label for="">NIK</label>
                        <input type="text" class="form-control form-control-sm" id="no-nip">
                    </div>
                    <div class="form-group row">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control form-control-sm" id="nama">
                    </div>
                    <div class="form-group row">
                        <label for="bagian">Bagian</label>
                        <select class="form-control select2 form-control-sm" id="bagian">
                            <option value="">&raquo; Semua Bagian</option>
                            @foreach($departments as $d)
                            <option value="{{ $d->bagian }}">{{ $d->bagian }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="control-label">Client</label>
                        <select class="form-control input-lg select2-single form-control-sm"  id="client">
                                <option value="">&raquo; Semua Client</option>
                                @foreach($customers as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                        </select>
				    </div>
                    
                    <div class="form-group row">
                        <input type="hidden" class="form-control" id="rontgen-id">
                        <label for="">Tgl. Input</label>
                       
                        <div class="row">
                            <div class="col-md-5"><input type="text" class="form-control form-control-sm datepicker" id="from-date"></div>
                            <div class="col-md-2 text-center">To</div>
                            <div class="col-md-5"><input type="text" class="form-control form-control-sm datepicker" id="to-date"></div>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary  btn-sm" id="btn-filter-submit"><i class="fa fa-check-circle"></i> @lang('general.submit')</button>
                    <button class="btn btn-default btn-sm" data-dismiss="modal">@lang('general.close')</button>
                </div>
            </form>
        </div>
    </div>
</div>
