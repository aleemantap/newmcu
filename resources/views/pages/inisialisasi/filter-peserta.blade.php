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
                    <h4 class="modal-title">Filter</h4>
                </div>
                <div class="modal-body">
					 
					<div class="form-group row">
						<label for="" class="control-label col-md-4">Project ID</label>
						<div class="col-md-8">
							<input type="text"  class="form-control input-xs" id="project-id">
						</div>
					</div>
					<div class="form-group row">
						<label for="" class="control-label col-md-4">@lang('customer.customer')</label>
						<div class="col-md-8">
							<select class="form-control input-xs" id="perusahaan">
								<option value="">&raquo; @lang('general.all') @lang('customer.customer')</option>
								@if(!empty($customers))
								@foreach($customers as $c)
								<option value="{{ $c->id }}">{{ $c->name }}</option>
								@endforeach
								@endif
								
							</select>
						</div>
                    </div>
					<div class="form-group row">
						<label for="" class="control-label col-md-4">@lang('vendor.vendor')</label>
						<div class="col-md-8">
							<select class="form-control input-xs" id="vendor">
								<option value="">&raquo; @lang('general.all') @lang('vendor.vendor')</option>
								@if(!empty($vendors))
									@foreach($vendors as $vendor)
									<option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
									@endforeach
								@endif
							</select>
						</div>
					</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-filter-submit2"><i class="fa fa-check-circle"></i> Filter Data</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('general.close')</button>
                </div>
            </form>
        </div>
    </div>
</div>
