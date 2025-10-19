<div class="modal fade" id="modal-privileges">
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
            <div class="modal-header no-border">
                    <h4 class="modal-title">Set Privileges</h4>
            </div>
            <form class="" action="#" id="form-user">
                
                <div class="modal-body" style="max-height:300px; overflow:scroll;">
                    <input type="hidden" id="priv-group-id">
                    @each('pages.user-group.privileges-menu-item', $menus, 'menu')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-submit-privileges"><i class="fa fa-check-circle"></i> @lang('general.submit')</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">@lang('general.close')</button>
                </div>
            </form>
        </div>
    </div>
</div>
