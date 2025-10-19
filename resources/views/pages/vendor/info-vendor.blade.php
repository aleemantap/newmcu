<div class="modal fade fade bd-example-modal-lg" id="info-vendor">
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
            <form class="form-horizontal" id="form-vendor">
                <div class="modal-header no-border">
                    <h4 class="modal-title">@lang('vendor.info_vendor')</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">@lang('vendor.name')</label>
                        <div class="col-md-8"><span id="info-name" class="form-control no-border"></span></div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">@lang('vendor.address')</label>
                        <div class="col-md-8">
                            <span id="info-address1" class="form-control no-border"></span>
                            <span id="info-address2" class="form-control no-border"></span>
                            <span id="info-city-zip-code" class="form-control no-border"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">@lang('vendor.phone')</label>
                        <div class="col-md-8"><span type="text" class="form-control input-xs no-border" id="info-phone"></span></div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">@lang('vendor.fax')</label>
                        <div class="col-md-8"><span type="text" class="form-control input-xs no-border" id="info-fax"></span></div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">@lang('vendor.email')</label>
                        <div class="col-md-8">
                            <span type="email" class="form-control input-xs no-border" id="info-email"></span>
                        </div>
                    </div>
					<div class="form-group row">
                        <label for="" class="control-label col-md-4" id="label-gambar">@lang('vendor.image')</label>
                        <div class="col-md-8">
                           <img id="info-image" width="auto" height="75" class="rounded-circle" />
                        </div>
                    </div>
					<div class="form-group row">
                        <label for="" class="control-label col-md-4" id="label-gambar">@lang('vendor.sign')</label>
                        <div class="col-md-8">
                            <img id="info-sign" width="auto" height="75" class="rounded-circle" />
                        </div>
                    </div>
					<div class="form-group row">
                        <label for="" class="control-label col-md-4" id="label-gambar">@lang('vendor.doctor_name')</label>
                        <div class="col-md-8">
                           <span type="text" name="doctor_name" class="form-control input-xs no-border" id="info-doctor-name"></span>
                        </div>
                    </div>
					<div class="form-group row">
                        <label for="" class="control-label col-md-4" id="label-gambar">@lang('vendor.doctor_license')</label>
                        <div class="col-md-8">
                           <span type="text" name="doctor_license" class="form-control input-xs no-border" id="info-doctor-license"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">@lang('general.close')</button>
                </div>
            </form>
        </div>
    </div>
</div>
