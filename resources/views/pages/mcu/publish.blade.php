<div class="modal fade" id="modal-publish">
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
            <form class="form-horizontal" id="form-rontgen" action="{{url('/database/rontgen-export')}}" method="post">
                @csrf
                <div class="modal-header bg-dark no-border">
                    <h4 class="modal-title">SEND WA</h4>
                </div>
                <div class="modal-body"> 
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">Semua</label>
                        <div class="col-md-8">
                            <div class="radio radio-inline">
                                <label><input type="radio" id="publish-all" name="publish-type" checked=""> Ya</label>
                            </div>
                            <div class="radio radio-inline">
                                <label><input type="radio" id="publish-some" name="publish-type"> Tidak</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">Client</label>
                        <div class="col-md-8">
                           <select class="form-control input-xs" id="client">
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
                            <select class="form-control input-xs" id="bagian">
                                <option value="">&raquo; Semua Bagian</option>
                                @foreach($departments as $d)
                                <option value="{{ $d->bagian }}">{{ $d->bagian }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <input type="hidden" class="form-control input-xs" id="rontgen-id">
                        <label for="" class="control-label col-md-4">Tgl. Input</label>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-5"><input disabled="" type="text" class="form-control input-xs datepicker" name="startDate" id="from-date"></div>
                                <label class="col-md-2 control-label">To</label>
                                <div class="col-md-5"><input disabled="" type="text" class="form-control input-xs datepicker" name="endDate" id="to-date"></div>
                            </div>
                        </div>
                    </div>
					<div class="form-group row">
                        <input type="hidden" class="form-control input-xs" id="rontgen-id">
                        <label for="" class="control-label col-md-4">MCU ID</label>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6"><input disabled="" type="text" placeholder="From" class="form-control input-xs" name="startId" id="start-id"></div>
                                
                                <div class="col-md-6"><input disabled="" type="text" placeholder="To" class="form-control input-xs" name="toId" id="to-id"></div>
                            </div>
                        </div>
                    </div>
                    <div class="input-progress-wa hidden" style="margin: 50px 0">
                        <div class="progress">
                            <div id="send-progress" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                              <span class="sr-only">0% Complete</span>
                            </div>
                        </div>
                        <div class="progress-text-wa">0% Completed ... Please wait ...</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-publish"><i class="fa fa-check-circle"></i> @lang('general.submit')</button>
                    <button class="btn btn-default" data-dismiss="modal">@lang('general.close')</button>
                </div>
            </form>
        </div>
    </div>
</div>
