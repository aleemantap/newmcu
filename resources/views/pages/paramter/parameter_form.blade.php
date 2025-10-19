<div class="modal fade" id="modal-parameter">
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
            <form class="form-horizontal" id="form-rontgen" action="{{url('/database/rontgen-export')}}" method="post">
                @csrf
                <div class="modal-header bg-dark no-border">
                    <h4 class="modal-title">Publish MCU</h4>
                </div>
                <div class="modal-body">

					<div class="form-group row">
                        <label for="" class="control-label col-md-4">Name</label>
                        <div class="col-md-8">
                            <input  type="hidden" class="form-control form-control-sm input-xs" name="parameter_id" id="parameter-id">
                            <input  type="text" class="form-control form-control-sm input-xs" name="nama_parameter" id="nama_parameter">
                        </div>
                    </div>
					<div class="form-group row">
                        <label for="" class="control-label col-md-4">Field</label>
                        <div class="col-md-8">
                            <input  type="text" class="form-control form-control-sm " name="field" id="field">
                        </div>
                    </div>
					<div class="form-group row">
                        <label for="" class="control-label col-md-4">Index Excel</label>
                        <div class="col-md-8">
                            <input  type="text" class="form-control form-control-sm" name="excelindex" id="excelindex">
                        </div>
                    </div>
				    <div class="form-group row">
                        <label for="" class="control-label col-md-4">Kategori</label>
                        <div class="col-md-8">
                            <div id="c_kategori"></div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-flat btn-sm" id="btn-submit-parameter"><i class="fa fa-check-circle"></i> @lang('general.submit')</button>
                    <button class="btn btn-default btn-flat btn-sm" data-dismiss="modal">@lang('general.close')</button>
                </div>
            </form>
        </div>
    </div>
</div>
