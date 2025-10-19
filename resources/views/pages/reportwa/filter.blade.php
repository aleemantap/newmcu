<div class="modal fade" id="modal-filter2">
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
                    <h4 class="modal-title">Filter Report WA</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">MCU ID</label>
                        <div class="col-md-8"><input type="text" class="form-control form-control-sm" id="id-pasien2"></div>
                    </div>
					<div class="form-group row">
                        <input type="hidden" class="form-control form-control-sm" id="rontgen-id">
                        <label for="" class="control-label col-md-4">MCU ID Range</label>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6"><input type="text" placeholder="From" class="form-control form-control-sm" name="startIdwa" id="wa-start-id"></div>
                                
                                <div class="col-md-6"><input type="text" placeholder="To" class="form-control form-control-sm" name="toIdwa" id="wa-to-id"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">NIK</label>
                        <div class="col-md-8"><input type="text" class="form-control form-control-sm" id="no-nip2"></div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">Nama</label>
                        <div class="col-md-8"><input type="text" class="form-control form-control-sm" id="nama2"></div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">Bagian</label>
                        <div class="col-md-8">
                            <select class="form-control form-control-sm" id="bagian2">
                                <option value="">&raquo; Semua Bagian</option>
                                @foreach($departments as $d)
                                <option value="{{ $d->bagian }}">{{ $d->bagian }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">Client</label>
                        <div class="col-md-8">
                            <select class="form-control form-control-sm" id="client2">
                                <option value="">&raquo; Semua Client</option>
                                @foreach($customers as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
					    </div>
                    </div>
                    <!--<div class="form-group row">
                        <input type="hidden" class="form-control input-xs" id="rontgen-id">
                        <label for="" class="control-label col-md-4">Time Sending</label>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-5"><input type="text" class="form-control input-xs datepicker" id="from-date2"></div>
                                <label class="col-md-2 control-label">To</label>
                                <div class="col-md-5"><input type="text" class="form-control input-xs datepicker" id="to-date2"></div>
                            </div>
                        </div>
                    </div>-->
					<div class="form-group row">
                        <input type="hidden" class="form-control input-xs" id="send-wa">
                        <label for="" class="control-label col-md-4">Send WA</label>
                        <div class="col-md-8">
                            <select class="form-control form-control-sm" id="sentd-w-opt">
                                <option value="">&raquo; Sent WA</option>                                
                                <option value="Y">YES</option>
                                <option value="N">NO</option>
                            </select>
                        </div>
                    </div>
					<div class="form-group row">
                        <input type="hidden" class="form-control input-xs" id="status-wa">
                        <label for="" class="control-label col-md-4">Status WA Server</label>
                        <div class="col-md-8">
                            <select class="form-control form-control-sm" id="status-wa-opt">
                                <option value="">&raquo; Status WA</option>                                
                                <option value="success">Success</option>
                                <option value="not_exists">Not exists</option>
                            </select>
							
                        </div>
                    </div>
					<div class="form-group row">
                        <input type="hidden" class="form-control input-xs" id="status-delivery">
                        <label for="" class="control-label col-md-4">Status Delivery HP</label>
                        <div class="col-md-8">
                            <select class="form-control form-control-sm" id="status-delivery-opt">
                                <option value="">&raquo; Status Delivery</option>                                
                                <option value="delivery">Delivery</option>
                                <option value="pending">Pending</option>
								<option value="not_exists">Not exists</option>
								<option value="read">Read</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-flat" id="btn-filter-submit2"><i class="fa fa-check-circle"></i> Filter Data</button>
                    <button type="button" class="btn btn-success btn-flat" id="btn-download-r">Download</button>
                    <button type="button" class="btn btn-warning btn-flat" id="btn-new-status-delivery">New Status Delivery</button>
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">@lang('general.close')</button>
                </div>
            </form>
        </div>
    </div>
</div>
