@extends('layouts.app')

@section('ribbon')
<ol class="breadcrumb">
    <li>Setting</li>
    <li>Users</li>
    <li>{{ $user->USER_ID }}</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box bg-white">
            
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <form>
                            <div class="form-group row"><label for="">Name</label><input type="text" class="form-control input-xs"></div>
                            <div class="form-group row"><label for="">Email</label><input type="text" class="form-control input-xs"></div>
                            <div class="form-group row"><label for="">Group</label><input type="text" class="form-control input-xs"></div>
                            <div class="form-group row"><label for="">Position</label><input type="text" class="form-control input-xs"></div>
                            <div class="form-group row"><label for="">Status</label><input type="text" class="form-control input-xs"></div>
                        </form>
                    </div>
                </div>

                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item nav-link active" role="tab" data-toggle="tab"><a>Activity</a></li>
                    <li class="nav-item nav-link" role="tab" data-toggle="tab"><a>Access</a></li>
                    <li class="nav-item nav-link" role="tab" data-toggle="tab"><a>Info</a></li>
                    <li class="nav-item nav-link" role="tab" data-toggle="tab"><a>Apalah</a></li>
                </ul>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade in active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="row">
                            <div class="col-md-8">
                                <div id="cnop" style="height: 250px"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="padding-15" style="padding-left: 50px">
                                    <div style="padding-left: 15px"><strong>Delivery Progress</strong><br/><br/></div>
                                    <div id="cnop-pie" class="easy-pie-chart txt-color-red easyPieChart" data-line-width="10" data-percent="93" data-size="130" data-pie-size="30">
                                        <span class="percent percent-sign txt-color-red font-xl semi-bold">93</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="row">
                            <div class="col-md-8">
                                <div id="cnop" style="height: 250px"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="padding-15" style="padding-left: 50px">
                                    <div style="padding-left: 15px"><strong>Delivery Progress</strong><br/><br/></div>
                                    <div id="cnop-pie7" class="easy-pie-chart txt-color-red easyPieChart" data-line-width="10" data-percent="93" data-size="130" data-pie-size="30">
                                        <span class="percent percent-sign txt-color-red font-xl semi-bold">93</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection

@section('script')
<script src="{{ asset('js/libs/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/plugin/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('js/libs/jquery-ui.min.js') }}"></script>
<!--<script src="{{ asset('js/user.js') }}"></script>-->
@endsection


@section('css')
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/bootstrap-datepicker.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/jquery-ui.css') }}">
<style>
    .datepicker{
        z-index:1151;
    }

    .datepicker {
        transform: translate(0, 3.1em);
    }
</style>
@endsection
