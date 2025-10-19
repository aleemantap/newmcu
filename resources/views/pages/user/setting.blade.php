@extends('layouts.app')
@section('title', $title_page_left)
@section('ribbon')
<ul class="breadcrumbs pull-left">
	<li><a href="/home">Home</a></li>
    <li><span>User Setting</span></li>   
</ul>
@endsection


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

            <div class="custom-well no-padding" style="margin-top: 30px">
                <form action="{{ url('/user/setting') }}" id="login-form" class="" method="post">
                    @csrf
                    <div class="panel panel-default no-border">
                        <header class="panel-heading">
                            <i class="fa fa-gear"></i> @lang('setting.setting')
                        </header>
                        <fieldset class="panel-body">
                            <section class="form-group">
                                <label style="font-size: 13px">@lang('setting.language')</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="language" value="en" {{ session()->get('app-locale') == 'en' ? 'checked':'' }}>
                                        <img height="24" src="{{ asset('img/united-kingdom.png') }}" />
                                        English
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="language" value="id" {{ session()->get('app-locale') == 'id' ? 'checked':'' }}>
                                        <img height="24" src="{{ asset('img/indonesia.png') }}" />
                                        Bahasa Indonesia
                                    </label>
                                </div>
                            </section>
                        </fieldset>
                        <footer class="panel-footer">
                            <button type="submit" class="btn btn-primary btn-block btn-rounded">
                                <i class="fa fa-check-circle"></i> @lang('general.submit')
                            </button>
                        </footer>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('css')
    <style>
        .panel-heading {
            padding: 11px 13px;
            margin: 0;
            border-bottom-style: solid;
            border-bottom-color: rgba(0,0,0,.1);
            background: rgba(248,248,248,.9);
            font-size: 16px;
            color: #232323;
            text-align: center;
            font: 600 16px/29px 'Open Sans',Helvetica,Arial,sans-serif !important;
        }
        .panel-footer {
            background: rgba(248,248,248,.9);
        }
        .panel-footer button {
            height: 31px;
            margin: 8px 0;
            padding: 0 22px;
            font: 300 15px/29px 'Open Sans',Helvetica,Arial,sans-serif;
            cursor: pointer;
        }
    </style>
@endsection


@section('script')
<script src="{{ asset('js/jquery.mask.min.js') }}"></script>
<script>
    $(document).ready(function () {

        // You can use 'alert' for alert message
        // or throw to 'throw' javascript error
        // or none to 'ignore' and hide error
        // or you own function
        // please read https://datatables.net/reference/event/error
        // for more information
        $.fn.dataTable.ext.errMode = 'none';

        /**
         * Datatable initial
         */
        var userDataTable = $('#user-table').DataTable({
            dom: '<"dt-toolbar"<"col-sm-6 col-xs-12 hidden-xs"f><"col-sm-6 col-xs-12 hidden-xs"l>>rt<"dt-toolbar-footer"<"col-sm-6 col-xs-12"i><"col-sm-6 col-xs-12 hidden-xs"p>><"clear">',
            processing: true,
            serverSide: true,
            scrollX: true,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
            pagingType: 'full_numbers',
            ajax: baseUrl + "/users-datatables",
            language: {
                //processing: '<div style="display: none"></div>',
                // info: 'Menampilkan _START_ - _END_ dari _TOTAL_ ',
                search: '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>',
                // zeroRecords: 'Tidak ada data yang cocok dengan kriteria pencarian',
                // emptyTable: 'Data tidak tersedia',
                //paginate: {
                //    first: 'Awal',
                //    last: 'Akhir',
                //    next: 'Selanjutnya',
                //    previous: 'Sebelumnya'
                //},
                //lengthMenu: "Baris per halaman: _MENU_ "
            },
            //rowId: 'TRANSPORT_ID',
            columns: [
                {data: "DT_RowIndex", sortable: false, searchable: false},
                {data: "email", name: "email"},
                {data: "name", name: "name"},
                {data: "gender", name: "gender"},
                {data: "user_group.name", name: "user_group.name"},
                {data: "action", class: "action"}
            ]
        });


        // Open modal
        $('#btn-add').click(function () {
            $('#add-modal').modal('toggle');
            $('#add-modal .modal-title').html('Input Pengguna');
            $('input[type=text], input[type=password], input[type=hidden], select').val('');
        });

        // Setup all ajax requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $('#user-table').on('click', '.btn-setting', function () {
            $('#setting-modal').modal('toggle');

            $.ajax({
                url: baseUrl + "/users/" + $(this).attr('id'),
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (resp) {
                    $('#user-service-id').val(resp.id);
                    $('.service').prop('checked', false);
                    $.each(resp.services, function (i, o) {
                        $('#service-' + o.id).prop('checked', true);
                    });
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $.smallBox({
                        title: textStatus,
                        content: errorThrown,
                        color: "#dc3912",
                        sound_file: "smallbox",
                        timeout: 3000
                    });
                }
            });
        });


        // Edit form
        $('#user-table').on('click', '.btn-edit', function () {
            $('#add-modal').modal('toggle');
            $('#add-modal .modal-title').html('Edit Pengguna');

            $.ajax({
                url: baseUrl + "/users/" + $(this).attr('id'),
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (resp) {
                    $('#user-id').val(resp.id);
                    $('#user-email').val(resp.email);
                    $('#user-name').val(resp.name),
                            (resp.gender === 'L') ? $('#user-male').prop('checked', true) : $('#user-female').prop('checked', true);
                    $('#user-group').val(resp.user_group_id);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $.smallBox({
                        title: textStatus,
                        content: errorThrown,
                        color: "#dc3912",
                        sound_file: "smallbox",
                        timeout: 3000
                    });
                }
            });

        });

        // Delete resource
        $('#user-table').on('click', '.btn-delete', function () {
            if (confirm('Yakin akan menghapus ini?')) {
                $.ajax({
                    url: baseUrl + "/users/" + $(this).attr('id'),
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (resp) {
                        $.smallBox({
                            title: "OK",
                            content: resp.responseMessage,
                            color: "#029509",
                            sound_file: "smallbox",
                            timeout: 3000
                        });
                        userDataTable.ajax.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $.smallBox({
                            title: textStatus,
                            content: errorThrown,
                            color: "#dc3912",
                            sound_file: "smallbox",
                            timeout: 3000
                        });
                    }
                });
            }
        });

        // Submit form
        $('#btn-submit').click(function () {

            if (!$('#user-email').val()) {
                $.smallBox({
                    title: "Kesalahan",
                    content: "Email tidak boleh kosong",
                    color: "#dc3912",
                    sound_file: "smallbox",
                    timeout: 3000
                });

                $('#user-email').focus();
                return false;
            }

            if (!$('#user-id').val()) {
                if (!$('#user-password').val()) {
                    $.smallBox({
                        title: "Kesalahan",
                        content: "Password tidak boleh kosong",
                        color: "#dc3912",
                        sound_file: "smallbox",
                        timeout: 3000
                    });

                    $('#user-password').focus();
                    return false;
                }

                if (!$('#user-retype-password').val()) {
                    $.smallBox({
                        title: "Kesalahan",
                        content: "Ulangi Password",
                        color: "#dc3912",
                        sound_file: "smallbox",
                        timeout: 3000
                    });

                    $('#user-retype-password').focus();
                    return false;
                }
            }

            if ($('#user-password').val() !== $('#user-retype-password').val()) {
                $.smallBox({
                    title: "Kesalahan",
                    content: "Password tidak sama",
                    color: "#dc3912",
                    sound_file: "smallbox",
                    timeout: 3000
                });

                $('#user-retype-password').focus();
                return false;
            }


            if (!$('#user-name').val()) {
                $.smallBox({
                    title: "Kesalahan",
                    content: "Nama lengkap tidak boleh kosong",
                    color: "#dc3912",
                    sound_file: "smallbox",
                    timeout: 3000
                });

                $('#user-name').focus();
                return false;
            }

            if (!$('#user-group').val()) {
                $.smallBox({
                    title: "Kesalahan",
                    content: "Grup tidak boleh kosong",
                    color: "#dc3912",
                    sound_file: "smallbox",
                    timeout: 3000
                });

                $('#user-group').focus();
                return false;
            }

            if (!$('##user-id').val()) {
                var url = baseUrl + "/users";
            } else {
                var url = baseUrl + "/users/" + $('#user-id').val();
            }

            $.ajax({
                url: url,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    userId: $('#user-id').val(),
                    userEmail: $('#user-email').val(),
                    userSecret: $('#user-password').val(),
                    userName: $('#user-name').val(),
                    userGender: $('.gender:checked').val(),
                    userGroup: $('#user-group option:selected').val()
                },
                success: function (resp) {
                    if (resp.responseCode === 200) {
                        $.smallBox({
                            title: "OK",
                            content: resp.responseMessage,
                            color: "#029509",
                            sound_file: "smallbox",
                            timeout: 3000
                        });
                    } else {
                        $.smallBox({
                            title: "Kesalahan",
                            content: resp.responseMessage,
                            color: "#dc3912",
                            sound_file: "smallbox",
                            timeout: 3000
                        });
                    }

                    // Update data
                    userDataTable.ajax.reload();

                    Close transport modal
                    $('#add-modal').modal('toggle');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $.smallBox({
                        title: textStatus,
                        content: errorThrown,
                        color: "#dc3912",
                        sound_file: "smallbox",
                        timeout: 3000
                    });
                }
            });
        });

        // Submit form
        $('#btn-submit-service').click(function () {

            var services = [];
            $('.service:checked').each(function (i, o) {
                services.push($(o).val());
            });

            $.ajax({
                url: baseUrl + "/user-services/" + $('#user-service-id').val(),
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    userId: $('#user-service-id').val(),
                    serviceId: services
                },
                success: function (resp) {
                    if (resp.responseCode === 200) {
                        $.smallBox({
                            title: "OK",
                            content: resp.responseMessage,
                            color: "#029509",
                            sound_file: "smallbox",
                            timeout: 3000
                        });
                    } else {
                        $.smallBox({
                            title: "Kesalahan",
                            content: resp.responseMessage,
                            color: "#dc3912",
                            sound_file: "smallbox",
                            timeout: 3000
                        });
                    }

                    Close transport modal
                    $('#setting-modal').modal('toggle');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $.smallBox({
                        title: textStatus,
                        content: errorThrown,
                        color: "#dc3912",
                        sound_file: "smallbox",
                        timeout: 3000
                    });
                }
            });
        });

    });

</script>
@endsection
