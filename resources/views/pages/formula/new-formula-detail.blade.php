<div class="modal fade" id="modal-formula">
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
            <form class="form-horizontal" id="form-customer">
                <div class="modal-header bg-dark no-border">
                    <h4 class="modal-title">New Formula</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <input type="hidden" class="form-control input-xs" id="formula-id">
                        <input type="hidden" class="form-control input-xs" id="formula-group-id" value="{{ $formula->id }}">
                        <label class="col-md-4 control-label">Parameter Type</label>
                        <div class="col-md-8">
                            <select name="" id="parameter-type" class="form-control input-xs">
                                <option value="1">Single</option>
                                <option value="2">Multiple</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 control-label">Parameter</label>
                        <div class="col-md-8">
                            <select name="" id="parameter" class="form-control input-xs">
                                <option value="">&raquo; Select Parameter</option>
                                @foreach($parameters as $param)
                                <option value="{{ $param->id }}">{{ $param->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 control-label">Sex</label>
                        <div class="col-md-8">
                            <select name="" id="sex" class="form-control input-xs">
                                <option value="0">Unisex</option>
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 control-label">Operator</label>
                        <div class="col-md-8">
                            <select name="" id="operator" class="form-control input-xs">
                                <option value="=">=</option>
                                <option value="<"><</option>
                                <option value=">">></option>
                                <option value="<="><=</option>
                                <option value=">=">>=</option>
                                <option value="<>"><></option>
                                <option value="CONTAIN">CONTAIN</option>
                                <option value="NOT CONTAIN">NOT CONTAIN</option>
                            </select>
                            <small class="help-block">Operator apply on fixed value only</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 control-label">Value Type</label>
                        <div class="col-md-8">
                            <div class="radio radio-inline">
                                <label><input type="radio" name="value-type" value="1" id="value-type-fixed" checked=""> Fixed</label>
                            </div>
                            <div class="radio radio-inline">
                                <label><input type="radio" name="value-type" value="2" id="value-type-range"> Range</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 control-label">Value</label>
                        <div class="col-md-4">
                            <input id="value-bottom" type="text" class="form-control input-xs" step="0.01">
                            <small class="help-block">Type comma as dot (.)</small>
                        </div>
                        <div class="col-md-4">
                            <input id="value-top" type="number" step="0.01" class="form-control input-xs" readonly="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 control-label">ICD X</label>
                        <div class="col-md-8">
                            <input type="text" id="icd-name" class="form-control input-xs">
                            <input type="hidden" id="icd-id">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 control-label">Work Diagnosis</label>
                        <div class="col-md-8">
                            <select name="" id="diagnosis" class="form-control input-xs">
                                <option value="">&raquo; Select work diagnosis</option>
                                @foreach($workHealths as $wh)
                                <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4 control-label">Recommendation</label>
                        <div class="col-md-8">
                            <textarea class="form-control input-xs" id="recommendation"></textarea>
                        </div>
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
