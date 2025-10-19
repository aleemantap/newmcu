<div class="modal fade bd-example-modal-lg" id="modal-customer">
    <div class="modal-dialog modal-lg">
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
            <div class="modal-header  no-border">
                <h4 class="modal-title">New Customer</h4>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form class="form-horizontal" id="form-customer">
                <div class="modal-body">
                    <div class="form-row"> 
                         <div class="col-md-6 mb-3">
                            <input type="hidden" class="form-control input-xs" id="customer-id">
                            <label for="name">@lang('customer.name')</label>
                            <input type="text" class="form-control" id="name"/>                            
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="address1">@lang('customer.address') 1</label>
                            <input type="text" class="form-control" id="address1"/>
                        </div>
                    </div>
                    <div class="form-row"> 
                        <div class="col-md-6 mb-3">
                            <label for="address2">@lang('customer.address') 2</label>
                            <input type="text" class="form-control" id="address2"/>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="city">@lang('customer.city')</label>
                            <input type="text" class="form-control" id="city"/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="zipcode">@lang('customer.zip_code')</label>
                            <input type="text" maxlength="5" class="form-control numeric" id="zipcode"/>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone">@lang('customer.phone')</label>
                            <input type="text" class="form-control" id="phone"/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="fax">@lang('customer.fax')</label>
                            <input type="text" class="form-control" id="fax" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email">@lang('customer.email')</label>
                            <input type="email" class="form-control input-xs" id="email" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <label class="pull-left">(<span style="color: red">*</span>) @lang('general.required_field')</label>
                    <button type="button" class="btn btn-primary" id="btn-submit"><i class="fa fa-check-circle"></i> @lang('general.submit')</button>
                    <button class="btn btn-default" data-dismiss="modal">@lang('general.close')</button>
                </div>
            </form>
        </div>
    </div>
</div>
