@extends('layouts.app')

@section('ribbon')
<ol class="breadcrumb pull-left">
    <li>Setting</li>
    <li>Users</li>
    <li>{{ session()->get('user.name') }}</li>
</ol>
@endsection
@section('title', $title_page_left)
@section('content')
<section id="widget-grid" class="">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-md-offset-4 col-sm-offset-0 col-xs-offset-0">

            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <div class="custom-well no-padding">
                <form align="center" enctype="multipart/form-data" action="{{ url('/user/update-profile') }}" id="login-form" class="smart-form client-form" method="post">
                    @csrf

                    <header>
                        <i class="fa fa-user"></i> @lang('update-profile.update_profile')
                    </header>
                    <fieldset>
                        <section>
                            <div>
                                @if(session()->get('user.avatar') !== null)
                                <img height="100" class="img-circle" src="{{ asset('storage/user') . '/' . session()->get('user.avatar') }}" data-toggle="dropdown">
                                @else
                                <img height="100" class="img-circle" src="{{ asset('img/avatar2.jpg') }}" data-toggle="dropdown">
                                @endif
                            </div>
                        </section>
                        <section>
                            <label class="label">@lang('update-profile.upload_photo')</label>
                            <label class="input">
                                <i class="icon-append fa fa-pencil"></i>
                                <input accept=".jpg,.gif,.jpeg,.png" id="file" type="file" class="form-control input-xs" name="file" value="{{ session()->get('user.name') }}" autofocus>
                            </label>
                        </section>
                        <section>
                            <label class="label">@lang('update-profile.name')</label>
                            <label class="input">
                                <i class="icon-append fa fa-pencil"></i>
                                <input id="name" type="text" class="form-control input-xs" name="name" value="{{ session()->get('user.name') }}" required autofocus>
                            </label>
                        </section>
                        <section>
                            <label class="label">@lang('update-profile.email')</label>
                            <label class="input">
                                <i class="icon-append fa fa-pencil"></i>
                                <input id="email" type="email" class="form-control input-xs" name="email" value="{{ session()->get('user.email') }}" required>
                            </label>
                        </section>
                    </fieldset>
                    <footer>
                        <button type="submit" class="btn btn-primary btn-block btn-rounded">
                            <i class="fa fa-check-circle"></i> @lang('general.submit')
                        </button>
                    </footer>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
