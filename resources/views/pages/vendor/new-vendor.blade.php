<div class="modal fade bd-example-modal-xl" id="modal-vendor">
    <div class="modal-dialog modal-xl" style="margin-left:10px;">
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
                <h4 class="modal-title">@lang('vendor.new_vendor')</h4>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form class="form-horizontal" id="form-vendor">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <input type="hidden" class="form-control input-xs" id="vendor-id">
                            <label for="name" >@lang('vendor.name')</label>
                            <input type="text" class="form-control" id="name">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="address1">@lang('vendor.address') 1</label>
                            <input type="text" class="form-control" id="address1">
                        </div>
                       <div class="col-md-4 mb-3">
                            <label for="address2">@lang('vendor.address') 2</label>
                            <input type="text" class="form-control input-xs" id="address2">
                        </div>
                    </div>
                    <div class="form-row">
                        
                        <div class="col-md-4 mb-3">
                            <label for="city">@lang('vendor.city')</label>
                            <input type="text" class="form-control" id="city">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="zipcode">@lang('vendor.zip_code')</label>
                            <input type="text" maxlength="5" class="form-control  numeric" id="zipcode">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="phone">@lang('vendor.phone')</label>
                            <input type="text" class="form-control input-xs" id="phone">
                        </div>
                    </div>
                  
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label for="fax">@lang('vendor.fax')</label>
                            <input type="text" class="form-control" id="fax" />
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="email">@lang('vendor.email')</label>
                            <input type="email" class="form-control" id="email" />
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="">@lang('vendor.doctor_name')</label>
                            <input type="text" name="doctor_name" class="form-control" id="doctor_name">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="" >@lang('vendor.doctor_license')</label>
                            <input type="text" name="doctor_license" class="form-control input-xs" id="doctor_license">
                        </div> 
                       
                    </div>
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label for="">@lang('vendor.image')</label>
                            <input type="file" name="image" class="form-control input-xs" id="image-vendor">
                        </div>
                        <div class="col-md-3 mb-3" id="img-view" style="display:none;">
                            <label for=""></label>
                            <img class="vendor-image"  id="img-view-logo" style="width:auto; height:90px;  display: block;  margin: 0 0;"  />
                        </div> 
                        <div class="col-md-3 mb-3">
                            <label for="image-sign">@lang('vendor.sign')</label>
                            <input type="file" name="sign" class="form-control" id="image-sign">
                        </div>
                        <div class="col-md-3 mb-3"  id="img-view2" style="display:none;">
                            <label for=""></label>
                            <img class="vendor-image"  id="img-view-sign" style="width:auto; height:90px;  display: block;  margin: 0 0;"  />
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
