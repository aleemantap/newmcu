<div class="modal fade" id="modal-formula">
    <div class="modal-dialog modal-sm">
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
            <form class="" id="form-customer">
                <div class="modal-header bg-dark no-border">
                    <h4 class="modal-title">Edit Rumus</h4>
                </div>
                <div class="modal-body px-5">
                    <div class="form-group row">
                        <input type="hidden" class="form-control input-xs" id="formula-id">
                        <label class="">Nama Rumus</label>
                        <input type="text" class="form-control form-control-sm" id="name">
                    </div>
					<div class="form-group row">
                        <label class="">Status</label>
                        <select name="status" id="status" class="form-control form-control-sm">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-xs btn-flat" id="btn-submit"><i class="fa fa-check-circle"></i> @lang('general.submit')</button>
                    <button class="btn btn-default btn-xs btn-flat" data-dismiss="modal">@lang('general.close')</button>
                </div>
            </form>
        </div>
    </div>
</div>
