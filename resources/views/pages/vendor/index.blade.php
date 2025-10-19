@extends('layouts.app')
@section('css')
    @include('layouts.datatableCss')
@endsection

@section('ribbon')
<ul class="breadcrumbs  pull-left"> 
    <li><a href="/home">Home</a></li>
    <li><span>Partner</span></li>
</ul>
@endsection

@section('title', $title_page_left)
@section('content')
        <div class="row">
                    <!-- data table start -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title"></h4>
                                <div class="data-tables">
                                    <table  id="vendor-table" class="table table-striped table-borderless">
                                        <thead class="bg-light text-capitalize">
                                                <tr>
                                                    <th >No</th>
                                                    <th>@lang('vendor.name')</th>
                                                    <th>@lang('vendor.address') </th>
                                                    <th>@lang('vendor.city')</th>
                                                    <th>@lang('vendor.phone')</th>
                                                    <th>@lang('vendor.email')</th>
                                                    <th style="width: 150px">@lang('general.action')</th>
                                                </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- data table end -->
                   
</div>           
@endsection

@section('modal')
    @include('pages.vendor.new-vendor')
    @include('pages.vendor.info-vendor')
@endsection

@section('script')
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
    var vendorDataTable = $('#vendor-table').DataTable({
        dom: '<"dt-toolbar"<"col-md-3 col-sm-12 hidden-sm float-left"f><"col-md-9 col-sm-12 hidden-sm float-right"<"toolbar">>>rt<"dt-toolbar-footer"<"col-md-5 col-sm-12"i><"col-md-6 col-md-12 hidden-sm"p>><"clear">',
        processing: false,
        serverSide: true,
        scrollX: true,
        pageLength: 15,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        pagingType: 'full_numbers',
        ajax: baseUrl+"/vendor-datatables",
        language: {
            //processing: '<div style="display: none"></div>',
            // info: 'Menampilkan _START_ - _END_ dari _TOTAL_ ',
            search: ' <div class="input-group"><div class="input-group-prepend"> <span class="input-group-text"> <span class="ti-search"></span> </span></div>',
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
            {data: "name", name: "name"},
            {data: "address", name: "address"},
            {data: "city", name: "city"},
//            {data: "zip_code", name: "zip_code"},
            {data: "phone", name: "phone"},
//            {data: "fax", name: "fax"},
            {data: "email", name: "email"},
            // {data: "logo", name: "logo"},
            // {data: "sign", name: "sign"},
            // {data: "doctor_name", name: "doctor_name"},
            // {data: "doctor_license", name: "doctor_license"},
            {data: "action", sortable: false, searchable: false, class: "action"}
        ],
		columnDefs:[
        //    {
        //         targets: [6],
		// 		render: function (data, type, row, meta) {
		// 			image = row.logo;
		// 			return '<img src="images/'+image+'" class="img-fluid img-thumbnail" />';

        //         }
        //     },
		// 	 {
        //         targets: [7],
		// 		render: function (data, type, row, meta) {
		// 			image = row.logo;
		// 			return '<img src="images/'+image+'" class="img-fluid img-thumbnail" />';

        //         }
        //     },
        ]

    });

    $("div.toolbar").html(`
        <a href='{{ url("/vendor-export") }}' id='btn-filter-vendor' class='btn btn-secondary'><i class='fa fa-download'></i></a>&nbsp;
        <button id='btn-add-vendor' class='btn btn-primary'><i class='fa fa-plus-circle'></i> @lang('general.add')</button>&nbsp;
    `);

    // Add Vendor
    $('body').on('click', '#btn-add-vendor', function(){
        $('#modal-vendor').modal('show');
        $('#modal-vendor .modal-title').html('@lang("vendor.new_vendor")');
        $('#modal-vendor input[type=text],#modal-vendor input[type=hidden],#modal-vendor input[type=email],#modal-vendor input[type=number]').val('');
        $('#img-view').attr('style', 'display: none');
    });

    // Add New Or Update Program
    $('#btn-submit').click(function(){

        // Update when vendor id has value
        var url = baseUrl + '/vendor/update';
        var action = "update";
        if(!$('#vendor-id').val()) {
            url = baseUrl + '/vendor/save';
            action = "save";
        }

        // Has error
        // var hasError = false;
        // Check requirement input
        if(!$('#name').val()) {
           
            Lobibox.notify('warning', {
                            sound: true,
                            icon: true,
                            msg :  'Name can\'t be empty',
            });
            $('#name').focus();
            return;
        }
        if(!$('#address1').val()) {
           
            Lobibox.notify('warning', {
                            sound: true,
                            icon: true,
                            msg :  'Address 1 can\'t be empty',
            });
            $('#address1').focus();
            return;
        }
        if(!$('#city').val()) {
           
            Lobibox.notify('warning', {
                            sound: true,
                            icon: true,
                            msg : 'City can\'t be empty',
            });
            $('#city').focus();
            return;
        }
        if(!$('#phone').val()) {
           
            Lobibox.notify('warning', {
                sound: true,
                icon: true,
                msg : 'Phone can\'t be empty',
            });
            $('#phone').focus();
            return;
        }
        if(!$('#email').val()) {            
            Lobibox.notify('warning', {
                sound: true,
                icon: true,
                msg : 'Email doest\'t match',
            });
            $('#email').focus();
            return;
        }
        // if(!$('#image-vendor').val()) {
        //     $.smallBox({
        //         //height: 50,
        //         title : "Error",
        //         content : 'Please upload logo',
        //         color : "#dc3912",
        //         sound_file: "smallbox",
        //         timeout: 3000
        //         //icon : "fa fa-bell swing animated"
        //     });
        //     $('#image-vendor').focus();
        //     return;
        // }
        // if(!$('#image-sign').val()) {
        //     $.smallBox({
        //         //height: 50,
        //         title : "Error",
        //         content : 'Please upload sign',
        //         color : "#dc3912",
        //         sound_file: "smallbox",
        //         timeout: 3000
        //         //icon : "fa fa-bell swing animated"
        //     });
        //     $('#image-sing').focus();
        //     return;
        // }
        if(!$('#doctor_name').val()) {
           
             Lobibox.notify('warning', {
                sound: true,
                icon: true,
                msg : 'Doctor name can\'t be empty',
            });
            $('#doctor_name').focus();
            return;
        }
        if(!$('#doctor_license').val()) {
            Lobibox.notify('warning', {
                sound: true,
                icon: true,
                msg : 'Doctor license can\'t be empty',
            });
            $('#doctor_license').focus();
            return;
        }

        // Show loder
        $('.page-loader').removeClass('hidden');

		var form = new FormData();
        var image = $('#image-vendor')[0].files[0];
        var sign = $('#image-sign')[0].files[0];

        form.append('id',$('#vendor-id').val());
        form.append('name',$('#name').val());
        form.append('address1',$('#address1').val());
        form.append('address2',$('#address2').val());
        form.append('city',$('#city').val());
        form.append('zipCode',$('#zip-code').val());
        form.append('phone',$('#phone').val());
        form.append('fax',$('#fax').val());
        form.append('email',$('#email').val());
        form.append('image', image);
        form.append('sign', sign);
		form.append('doctor_name',$('#doctor_name').val());
		form.append('doctor_license',$('#doctor_license').val());

        // Send data
        $.ajax({
            url: url,
            type: 'POST',
			contentType: false,
			processData: false,
			cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: form,
            success: function(resp) {
                if(resp.responseCode === 200) {
                    // Reload datatable
                    vendorDataTable.ajax.reload();
                    // Reset Form
                    $('#modal-vendor input[type=text],#modal-vendor input[type=email],#modal-vendor input[type=number]').val('');
                    // Close modal
                    $('#modal-vendor').modal('hide');
                    // Send success message
                    Lobibox.notify('success', {
                        sound: true,
                        icon: true,
                        msg : resp.responseMessage,
                    });
                } else {
                    Lobibox.notify('error', {
                        sound: true,
                        icon: true,
                        msg : resp.responseMessage,
                    });
                }
                // Hide loder
                $('.page-loader').addClass('hidden');
            },
            error: function(xhr, ajaxOptions, thrownError) {
               
                Lobibox.notify('error', {
                    sound: true,
                    icon: true,
                    msg :  xhr.statusText,
                });
                // Hide loder
                $('.page-loader').addClass('hidden');
            }
        });

    });

    // Edit vendor
    $('#vendor-table').on('click', '.btn-edit', function() {

        $('#modal-vendor').modal('show');
        $('#modal-vendor .modal-title').html('@lang("vendor.edit_vendor")');
		$('#img-view').attr('style', 'display: block');
		$('#img-view2').attr('style', 'display: block');
        // Hide loder
        $('.page-loader').removeClass('hidden');

        // Get data
        // Send data
        $.ajax({
            url: baseUrl + '/vendor/' + $(this).data('id'),
            type: 'GET',
            success: function(resp) {
                var resp1 = resp[0];
                var respImg = resp[1];
                var respLg = resp[2];
                
                
                $('#vendor-id').val(resp1.id);
                $('#name').val(resp1.name);
                $('#address1').val(resp1.address1);
                $('#address2').val(resp1.address2);
                $('#city').val(resp1.city);
                $('#zip-code').val(resp1.zip_code);
                $('#phone').val(resp1.phone);
                $('#fax').val(resp1.fax);
                $('#email').val(resp1.email);
                $('#doctor_name').val(resp1.doctor_name);
                $('#doctor_license').val(resp1.doctor_license);

                image = (respImg==null) ? "vendor/sample.jpg" : respImg //.image;
                imageUrl = image; //baseUrl + '/storage/vendor/'+ image;
                $('#img-view-logo').attr('src', imageUrl);

                sign = (respLg==null) ? "vendor/sample.jpg" : respLg ;//.sign;
                signUrl = sign; //baseUrl + '/storage/vendor/'+ sign;
                $('#img-view-sign').attr('src', signUrl);

                // Hide loder
                $('.page-loader').addClass('hidden');
            },
            error: function(xhr, ajaxOptions, thrownError) {
               
                 Lobibox.notify('error', {
                    sound: true,
                    icon: true,
                    msg :  xhr.statusText,
                });
                // Hide loder
                $('.page-loader').addClass('hidden');
            }
        });
    });

    // Delete vendor
    $('#vendor-table').on('click', '.btn-delete', function() {

        if(!confirm('Are you sure want to delete this vendor?')) {
            return;
        }

        // Get data
        // Send data
        $.ajax({
            url: baseUrl + '/vendor/delete/'+$(this).data('id'),
            type: 'GET',
            success: function(resp) {
                if(resp.responseCode === 200) {
                    // Reload datatable
                    vendorDataTable.ajax.reload();
                    Lobibox.notify('success', {
                        sound: true,
                        icon: true,
                        msg :  resp.responseMessage,
                    });
                } else {
                   
                    Lobibox.notify('error', {
                        sound: true,
                        icon: true,
                        msg :  resp.responseMessage,
                    });
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                Lobibox.notify('error', {
                    sound: true,
                    icon: true,
                    msg :  xhr.statusText,
                });
            }
        });
    });

    // Detail vendor
    $('#vendor-table').on('click', '.btn-info', function() {

        $('#info-vendor').modal('show');
        $('#img-view').attr('style', 'display: block');
        $('#img-view2').attr('style', 'display: block');
        // Hide loder
        $('.page-loader').removeClass('hidden');

        // Get data
        // Send data
        $.ajax({
            url: baseUrl + '/vendor/' + $(this).data('id'),
            type: 'GET',
            success: function(resp) {
                 console.log("tesw = ",resp[1]);
                var resp1 = resp[0];
                let respImg = resp[1];
                var respLg = resp[2];
                $('#info-name').html(resp1.name);
                $('#info-address1').html(resp1.address1);
                $('#info-address2').html(resp1.address2);
                $('#info-city-zip-code').html(resp1.city+' '+resp1.zip_code);
                $('#info-phone').html(resp1.phone);
                $('#info-fax').html(resp1.fax);
                $('#info-email').html(resp1.email);
                $('#info-doctor-name').html(resp1.doctor_name);
                $('#info-doctor-license').html(resp1.doctor_license);


                console.log("tes = ",respImg);

                image = (respImg==null) ? "vendor/sample.jpg" : respImg ;//.image;
                imageUrl = image;  //baseUrl + '/storage/vendor/'+ image;
                $('#info-image').attr('src', imageUrl);

                sign = (respLg==null) ? "vendor/sample.jpg" : respLg; //.sign;
                signUrl = sign;//baseUrl + '/storage/vendor/'+ sign;
                $('#info-sign').attr('src', signUrl);

                // Hide loder
                $('.page-loader').addClass('hidden');
            },
            error: function(xhr, ajaxOptions, thrownError) {
               
                Lobibox.notify('error', {
                    sound: true,
                    icon: true,
                    msg : xhr.statusText,
                });
                // Hide loder
                $('.page-loader').addClass('hidden');
            }
        });
    });

    // Set number only
    $(document).on("input", ".numeric", function() {
        this.value = this.value.replace(/\D/g,'');
    });

});

</script>
@endsection
