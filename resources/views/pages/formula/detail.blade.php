@extends('layouts.app')

@section('ribbon')
<ol class="breadcrumb">
    <li>Database</li>
    <li>Formula Group</li>
    <li>{{ $formula->name }}</li>
</ol>
@endsection

@section('content-class', 'grid')
@section('content')
<table id="formula-table" class="table table-striped table-borderless">
    <thead>
        <tr>
            <th style="width:20px;">No</th>
            <th>Parameter Type</th>
            <th>Parameter</th>
            <th>Sex</th>
            <th>Operator</th>
            <th>Value Type</th>
            <th>Value 1</th>
            <th>Value 2</th>
            <th>ICD 10</th>
            <th>Diagnosis</th>
            <th>Recommendation</th>
            <th style="width: 150px">Action</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>
@endsection

@section('modal')
    @include('pages.formula.new-formula-detail')
@endsection

@section('script')
<script src="{{ asset('js/libs/jquery-ui.min.js') }}"></script>
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
    var formulaDataTable = $('#formula-table').DataTable({
        dom: '<"dt-toolbar"<"col-sm-6 col-xs-12 hidden-xs"f><"col-sm-6 col-xs-12 hidden-xs text-right"<"toolbar">>>rt<"dt-toolbar-footer"<"col-sm-6 col-xs-12"i><"col-sm-6 col-xs-12 hidden-xs"p>><"clear">',
        processing: false,
        serverSide: true,
        scrollX: true,
        pageLength: 15,
        lengthMenu: [[15, 25, 50, 100], [15, 25, 50, 100]],
        pagingType: 'full_numbers',
        ajax: baseUrl+"/database/formula/detail/datatables/{{ $formula->id }}",
        language: {
            //processing: '<div style="display: none"></div>',
            // info: 'Menampilkan _START_ - _END_ dari _TOTAL_ ',
            search: '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>',
            // zeroRecords: 'Tidak ada data yang cocok dengan kriteria pencarian',
            // emptyTable: 'Data tidak tersedia',
            paginate: {
                first: '&laquo;',
                last: '&raquo;',
                next: '&rsaquo;',
                previous: '&lsaquo;'
            }
            //lengthMenu: "Baris per halaman: _MENU_ "
        },
        //rowId: 'TRANSPORT_ID',
        columns: [
            {data: "DT_RowIndex", sortable: false, searchable: false},
            {data: "parameterType", name: "parameterType"},
            {data: "parameter.name", name: "parameter.name"},
            {data: "gender", name: "gender"},
            {data: "operator", name: "operator"},
            {data: "valueType", name: "valueType"},
            {data: "value_bottom", name: "value_bottom"},
            {data: "value_top", name: "value_top"},
            {data: "icd10.name", name: "icd10.name"},
            {data: "work_health.name", name: "workHealth.name"},
            {data: "recommendation", name: "recommendation"},
            {data: "action", sortable: false, searchable: false, class: "action"}
        ]
    });

    $("div.toolbar").html(`
        <button id='btn-add-formula' class='btn btn-primary'><i class='fa fa-plus-circle'></i> @lang('general.add')</button>&nbsp;
    `);

    // Add Formula
    $('body').on('click', '#btn-add-formula', function(){
        $('#modal-formula').modal('show');
        $('#modal-formula .modal-title').html('New Formula');
        $('#modal-formula input[type=text],#modal-formula input[type=email],#modal-formula input[type=number]').val('');
    });

    // Check value type
    $('#value-type-fixed').click(function() {
        $('#value-bottom').attr('type','text');
        $('#value-top').val('').attr('readonly','readonly');
    });

    // Check value type
    $('#value-type-range').click(function() {
        $('#value-bottom').attr('type','number');
        $('#value-top').val('').removeAttr('readonly');
    });

    // Add New Or Update Program
    $('#btn-submit').click(function(){

        // Update when formula id has value
        var url = baseUrl + '/database/formula/detail/update';
        var action = "update";
        if(!$('#formula-id').val()) {
            url = baseUrl + '/database/formula/detail/save';
            action = "save";
        }

        // Has error
        // var hasError = false;
        // Check requirement input


        if(!$('#parameter').val()) {
            $.smallBox({
                //height: 50,
                title : "Error",
                content : 'Please select parameter',
                color : "#dc3912",
                sound_file: "smallbox",
                timeout: 3000
                //icon : "fa fa-bell swing animated"
            });
            $('#parameter').focus();
            return;
        }

        // Show loder
        $('.page-loader').removeClass('hidden');

        // Send data
        $.ajax({
            url: url,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'id': $('#formula-id').val(),
                'formulaId': $('#formula-group-id').val(),
                'parameter': $('#parameter').val(),
                'sex': $('#sex').val(),
                'operator': $('#operator').val(),
                'valueType': !$('#value-type-fixed').val()?2:1,
                'valueBottom': $('#value-bottom').val(),
                'valueTop': $('#value-top').val(),
                'icd': $('#icd-id').val(),
                'diagnosis': $('#diagnosis').val(),
                'recommendation': $('#recommendation').val()
            },
            success: function(resp) {
                if(resp.responseCode === 200) {
                    // Reload datatable
                    formulaDataTable.ajax.reload();
                    // Reset Form
                    $('#modal-formula input[type=text],#modal-formula input[type=email],#modal-formula input[type=number]').val('');
                    // Close modal
                    $('#modal-formula').modal('hide');
                    // Send success message
                    $.smallBox({
                        height: 50,
                        title : "Success",
                        content : resp.responseMessage,
                        color : "#109618",
                        sound_file: "voice_on",
                        timeout: 3000
                        //icon : "fa fa-bell swing animated"
                    });
                } else {
                    $.smallBox({
                        height: 50,
                        title : "Error",
                        content : resp.responseMessage,
                        color : "#dc3912",
                        sound_file: "smallbox",
                        timeout: 3000
                        //icon : "fa fa-bell swing animated"
                    });
                }
                // Hide loder
                $('.page-loader').addClass('hidden');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $.smallBox({
                    title : "Error",
                    content : xhr.statusText,
                    color : "#dc3912",
                    timeout: 3000
                    //icon : "fa fa-bell swing animated"
                });
                // Hide loder
                $('.page-loader').addClass('hidden');
            }
        });

    });

    // Edit formula
    $('#formula-table').on('click', '.btn-edit', function() {
        $('#modal-formula').modal('show');
        $('#modal-formula .modal-title').html('Edit Formula');

        // Hide loder
        $('.page-loader').removeClass('hidden');

        // Get data
        // Send data
        $.ajax({
            url: baseUrl + '/database/formula/' + $(this).data('id'),
            type: 'GET',
            success: function(resp) {
                $('#formula-id').val(resp.id);
                $('#name').val(resp.name);

                // Hide loder
                $('.page-loader').addClass('hidden');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $.smallBox({
                    title : "Error",
                    content : xhr.statusText,
                    color : "#dc3912",
                    timeout: 3000
                    //icon : "fa fa-bell swing animated"
                });
                // Hide loder
                $('.page-loader').addClass('hidden');
            }
        });
    });

    // Delete formula
    $('#formula-table').on('click', '.btn-delete', function() {

        if(!confirm('Are you sure want to delete this formula?')) {
            return;
        }

        // Get data
        // Send data
        $.ajax({
            url: baseUrl + '/formula/delete/'+$(this).data('id'),
            type: 'GET',
            success: function(resp) {
                if(resp.responseCode === 200) {
                    // Reload datatable
                    formulaDataTable.ajax.reload();
                    $.smallBox({
                        height: 50,
                        title : "Success",
                        content : resp.responseMessage,
                        color : "#109618",
                        sound_file: "voice_on",
                        timeout: 3000
                        //icon : "fa fa-bell swing animated"
                    });
                } else {
                    $.smallBox({
                        height: 50,
                        title : "Error",
                        content : resp.responseMessage,
                        color : "#dc3912",
                        sound_file: "smallbox",
                        timeout: 3000
                        //icon : "fa fa-bell swing animated"
                    });
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $.smallBox({
                    title : "Error",
                    content : xhr.statusText,
                    color : "#dc3912",
                    timeout: 3000
                    //icon : "fa fa-bell swing animated"
                });
            }
        });
    });

    // Search diagnosis
    $( "#icd-name" ).autocomplete({
        source: function(request, response) {
            $.ajax({
                url: baseUrl + "/database/formula/icdx-search",
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                   diagnosis: request.term
                },
                success: function(data) {
                   response(data);
                }
            });
        },
        minLength: 3,
        select: function(event, ui) {
            $("#icd-id").val(ui.item.id);
            $("#icd-name").val(ui.item.name);
            return false;
        },
        change: function(event, ui) {
            if(!ui.item) { $(this).val(''); }
        }
    }).autocomplete("instance")._renderItem = function(ul, item) {

        return $("<li>")
            .append("<div>" + item.name + "</div>" )
            .appendTo(ul);
    };

});

</script>
@endsection
