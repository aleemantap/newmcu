<div class="modal fade" id="modal-project">
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
            <div class="modal-header no-border">
                <h4 class="modal-title">@lang('project.new_project')</h4>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form class="form-horizontal" id="form-project">
                <div class="modal-body">

                    <div class="form-row"> 
                         <div class="col-md-12 mb-3">
                            <input type="hidden" class="form-control input-xs" id="project-id">
                            <label for="vendor">@lang('vendor.vendor')</label>
                            <select type="text" class="form-control" id="vendor">
                                <option value="">&raquo; @lang('general.select') @lang('vendor.vendor')</option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                @endforeach
                            </select>                          
                        </div>                      
                    </div>
                    <div class="form-row">
                        <label for="customer">@lang('customer.customer')</label>                        
                        <select type="text" class="form-control" id="customer">
                            <option value="">&raquo; @lang('general.select') @lang('customer.customer')</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-submit"><i class="fa fa-check-circle"></i> @lang('general.submit')</button>
                    <button class="btn btn-default" data-dismiss="modal">@lang('general.close')</button>
                </div>
            </form>
        </div>
    </div>
</div>
