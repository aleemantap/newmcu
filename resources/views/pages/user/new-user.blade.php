<div class="modal fade bd-example-modal-lg" id="modal-user">
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
                <h4 class="modal-title">New User</h4>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form class="form-horizontal" id="form-user">
                
                <div class="modal-body">
                    <div class="form-group row">
                        <input type="hidden" class="form-control input-xs" id="user-id">
                        <label for="" class="control-label col-md-4">@lang('user.email')</label>
                        <div class="col-md-12"><input type="email" class="form-control input-xs" id="email"></div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">@lang('user.name')</label>
                        <div class="col-md-12"><input type="text" class="form-control input-xs" id="name"></div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">@lang('change-password.password')</label>
                        <div class="col-md-12"><input type="password" class="form-control input-xs" id="password"></div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">@lang('change-password.confirm_password')</label>
                        <div class="col-md-12"><input type="password" class="form-control input-xs" id="confirm-password"></div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">@lang('user.group')</label>
                        <div class="col-md-12">
                            <select class="form-control input-xs" id="user-group">
                                <option value="">&raquo; @lang('general.select') @lang('user-group.user_group')</option>
                                @foreach($userGroup as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="u-cs">
                        <label for="" class="control-label col-md-4">@lang('customer.customer')</label>
                        <div class="col-md-12">
                            <select class="form-control input-xs" id="customer">
                                <option value="">&raquo; @lang('user.all') @lang('customer.customer')</option>
                                @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
					<div class="form-group" id="u-vdr">
                        <label for="" class="control-label col-md-4">Partner/@lang('vendor.vendor')</label>
                        <div class="col-md-12">
                            <select class="form-control input-xs" id="vendor">
                                <option value="">&raquo; @lang('user.all') @lang('vendor.vendor')</option>
                                @foreach($vendor as $vendor)
                                <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">@lang('user.active')</label>
                        <div class="col-md-12">
                            
                                <label><input checked="" type="radio" name="active[]" value="Y" id="user-active-yes"> @lang('general.yes')</label>
                               
								<label>&nbsp;&nbsp;&nbsp;<input type="radio" name="active[]" value="N" id="user-active-no"> @lang('general.no')</label>
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="margin-top:-30px;">
                    <button type="button" class="btn btn-primary" id="btn-submit"><i class="fa fa-check-circle"></i> @lang('general.submit')</button>
                    <button class="btn btn-default" data-dismiss="modal">@lang('general.close')</button>
                </div>
            </form>
        </div>
    </div>
</div>
