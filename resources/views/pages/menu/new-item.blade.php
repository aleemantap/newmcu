<div class="modal fade" id="modal-menu-item">
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
                    <h4 class="modal-title">@lang('menu.new_menu_item')</h4>
            </div>
            <form class="form-horizontal" id="form-menu">
                
                <div class="modal-body" style="max-height:400px; overflow:scroll;">
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">@lang('menu.name')</label>
                        <input type="hidden" id="menu-item-id">
                        <input type="hidden" id="squence">
                        <div class="col-md-12"><input type="text" class="form-control" id="menu-name"></div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">@lang('menu.tooltip')</label>
                        <div class="col-md-12"><input type="text" class="form-control" id="tooltip"></div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">@lang('menu.description')</label>
                        <div class="col-md-12"><input type="text" class="form-control" id="description"></div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">@lang('menu.icon') (HTML)</label>
                        <div class="col-md-12"><input type="text" class="form-control" id="icon"></div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-4">@lang('menu.url')</label>
                        <div class="col-md-12"><input type="text" class="form-control" id="url"></div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="control-label col-md-2" style="margin-left:17px;">@lang('general.action')</label>
                        <div class="col-md-3">
                            <div class="checkbox"><label for="action-view"><input id="action-read" type="checkbox" value="READ" style="margin-right:10px;">@lang('general.view')</label></div>
                            </div>
                        <div class="col-md-3">
                            <div class="checkbox"><label for="action-add"><input id="action-create" type="checkbox" value="CREATE" style="margin-right:10px;">@lang('general.add')</label></div>
                            <div class="checkbox"><label for="action-edit"><input id="action-update" type="checkbox" value="UPDATE" style="margin-right:10px;">@lang('general.edit')</label></div>
                            <div class="checkbox"><label for="action-delete"><input id="action-delete" type="checkbox" value="DELETE" style="margin-right:10px;">@lang('general.delete')</label></div>
                        </div>
                        <div class="col-md-3">
                            <div class="checkbox"><label for="action-import"><input id="action-import" type="checkbox" value="IMPORT" style="margin-right:10px;">@lang('general.import')</label></div>
                            <div class="checkbox"><label for="action-export"><input id="action-export" type="checkbox" value="EXPORT" style="margin-right:10px;">@lang('general.export')</label></div>
                            <div class="checkbox"><label for="action-print"><input id="action-print" type="checkbox" value="PRINT" style="margin-right:10px;">@lang('general.print')</label></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-submit-item"><i class="fa fa-check-circle"></i> @lang('general.submit')</button>
                    <button class="btn btn-default" data-dismiss="modal">@lang('general.close')</button>
                </div>
            </form>
        </div>
    </div>
</div>
