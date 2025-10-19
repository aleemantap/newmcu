<div class="modal fade" id="modal-user">
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
            <div class="modal-header  no-border">
                    <h4 class="modal-title">New User Group</h4>
            </div>
            <form class="form-horizontal" action="#" id="form-user">
                
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">@lang('user.name')</label>
                        <div class="col-md-12">
                            <input type="hidden" class="form-control input-xs" id="group-id">
                            <input type="text" class="form-control input-xs" id="group-name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">@lang('user-group.description')</label>
                        <div class="col-md-12"><textarea class="form-control input-xs" id="group-description"></textarea></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-submit"><i class="fa fa-check-circle"></i> @lang('general.submit')</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('general.close')</button>
                </div>
            </form>
        </div>
    </div>
</div>
