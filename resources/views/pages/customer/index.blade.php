@extends('layouts.app')
@section('css')
    @include('layouts.datatableCss')    
@endsection
@section('ribbon')   
    <ul class="breadcrumbs pull-left">
        <li><a href="/home">Home</a></li>
        <li><span>Customers</span></li>
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
                                    <table  id="customer-table" class="table table-striped table-borderless"  class="text-center">
                                        <thead class="bg-light text-capitalize">
                                             <tr>
                                                <th style="width:20px;">No</th>
                                                <th>@lang('customer.name')</th>
                                                <th>@lang('customer.address') </th>
                                                <th>@lang('customer.city')</th>
                                                <th>@lang('customer.phone')</th>
                                                <th>@lang('customer.email')</th>
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
    </div>
@endsection

@section('modal')
     @include('pages.customer.new-customer')
   
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
    //col-sm-12 col-md-5
    //col-sm-12 col-md-7
    /**
     * Datatable initial
     */
    var customerDataTable = $('#customer-table').DataTable({
        dom: '<"dt-toolbar"<"col-md-3 col-sm-12 hidden-sm float-left"f><"col-md-9 col-sm-12 hidden-sm float-right"<"toolbar">>>rt<"dt-toolbar-footer"<"col-md-5 col-sm-12"i><"col-md-6 col-md-12 hidden-sm"p>><"clear">',
        processing: false,
        serverSide: true,
        scrollX: true,
        pageLength: 15,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        pagingType: 'full_numbers',
        ajax: baseUrl+"/customer-datatables",
        language: {
            //processing: '<div style="display: none"></div>',
            // info: 'Menampilkan _START_ - _END_ dari _TOTAL_ ',
            search: ' <div class="input-group"><div class="input-group-prepend"> <span class="input-group-text"> <span class="ti-search"></span> </span></div>',
            // zeroRecords: 'Tidak ada data yang cocok dengan kriteria pencarian',
            // emptyTable: 'Data tidak tersedia',
            // paginate: {
            //     first: '&laquo;',
            //     last: '&raquo;',
            //     next: '&rsaquo;',
            //     previous: '&lsaquo;'
            // }
            //lengthMenu: "Baris per halaman: _MENU_ "
        },
        //rowId: 'TRANSPORT_ID',
        initComplete: function () {
             $('div.dt-search input').removeClass('form-control-sm');
        },
        columns: [
            {data: "DT_RowIndex", sortable: false, searchable: false},
            {data: "name", name: "name"},
            {data: "address", name: "address"},
            {data: "city", name: "city"},
//            {data: "zip_code", name: "zip_code"},
            {data: "phone", name: "phone"},
//            {data: "fax", name: "fax"},
            {data: "email", name: "email"},
            {data: "action", sortable: false, searchable: false, class: "action"}
        ]
    });

    $("div.toolbar").html(`
        <a href='{{ url("/customer-export") }}' id='btn-filter-customer' class='btn btn-secondary'><i class='fa fa-download'></i></a>&nbsp;
        <button id='btn-add-customer' class='btn btn-primary'><i class='fa fa-plus-circle'></i> @lang('general.add')</button>&nbsp;
    `);

    // Add Customer
    $('body').on('click', '#btn-add-customer', function(){
        $('#modal-customer').modal('show');
        $('#modal-customer .modal-title').html('@lang("customer.new_customer")');
        $('#modal-customer input[type=text],#modal-customer input[type=hidden],#modal-customer input[type=email],#modal-customer input[type=number]').val('');
    });

    // Add New Or Update Program
    $('#btn-submit').click(function(){

        // Update when customer id has value
        var url = baseUrl + '/customer/update';
        var action = "update";
        if(!$('#customer-id').val()) {
            url = baseUrl + '/customer/save';
            action = "save";
        }

        // Has error
        // var hasError = false;
        // Check requirement input
       
        if(!$('#name').val()) {
            Lobibox.notify('warning', {
                    sound: true,
                    icon: true,
                    msg : 'Name can\'t be empty',
            });
            $('#name').focus();
            return;

        }
      
        if(!$('#address1').val()) {
            Lobibox.notify('warning', {
                    sound: true,
                    icon: true,
                    msg : 'Address 1 can\'t be empty',
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
        // if(!$('#phone').val()) {
          
        //     Lobibox.notify('warning', {
        //             sound: true,
        //             icon: true,
        //             msg : 'City can\'t be empty',
        //     });
        //     $('#phone').focus();
        //     return;
        // }
      if(!$('#email').val()) {
            Lobibox.notify('warning', {
                    sound: true,
                    icon: true,
                    msg : 'Email can\'t be empty',
            });
            $('#email').focus();
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
                'id': $('#customer-id').val(),
                'name': $('#name').val(),
                'address1': $('#address1').val(),
                'address2': $('#address2').val(),
                'city': $('#city').val(),
                'zipCode': $('#zipcode').val(),
                'phone': $('#phone').val(),
                'fax': $('#fax').val(),
                'email': $('#email').val()
            },
            success: function(resp) {
                if(resp.responseCode === 200) {
                    // Reload datatable
                    customerDataTable.ajax.reload();
                    // Reset Form
                    $('#modal-customer input[type=text],#modal-customer input[type=email],#modal-customer input[type=number]').val('');
                    // Close modal
                    $('#modal-customer').modal('hide');
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
                            msg : xhr.statusText,
                });
                // Hide loder
                $('.page-loader').addClass('hidden');
            }
        });

    });

    // Edit customer
    $('#customer-table').on('click', '.btn-edit', function() {
        $('#modal-customer').modal('show');
        $('#modal-customer .modal-title').html('@lang("customer.edit_customer")');
        $('#img-view').attr('style', 'display: block');
        // Hide loder
        $('.page-loader').removeClass('hidden');

        // Get data
        // Send data
        $.ajax({
            url: baseUrl + '/customer/' + $(this).data('id'),
            type: 'GET',
            success: function(resp) {
                $('#customer-id').val(resp.id);
                $('#name').val(resp.name);
                $('#address1').val(resp.address1);
                $('#address2').val(resp.address2);
                $('#city').val(resp.city);
                $('#zipcode').val(resp.zip_code);
                $('#phone').val(resp.phone);
                $('#fax').val(resp.fax);
                $('#email').val(resp.email);

                // image = (resp.image==null) ? "customer/sample.jpg" : resp.image;
                // imageUrl = baseUrl + '/storage/customer/'+ image;
                // $('#img-view-logo').attr('src', imageUrl);

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

    // Delete customer
    $('#customer-table').on('click', '.btn-delete', function() {

        if(!confirm('Are you sure want to delete this customer?')) {
            return;
        }

        // Get data
        // Send data
        $.ajax({
            url: baseUrl + '/customer/delete/'+$(this).data('id'),
            type: 'GET',
            success: function(resp) {
                if(resp.responseCode === 200) {
                    // Reload datatable
                    customerDataTable.ajax.reload();
                    Lobibox.notify('success', {
                        sound: true,
                        icon: true,
                        msg :resp.responseMessage,
                    });
                } else {
                   
                     Lobibox.notify('error', {
                        sound: true,
                        icon: true,
                        msg :resp.responseMessage,
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

    // Detail Customer
    $('#customer-table').on('click', '.btn-info', function() {

        $('#info-customer').modal('show');
        $('#img-view').attr('style', 'display: block');
      
        // Hide loder
        $('.page-loader').removeClass('hidden');

        // Get data
        // Send data
        $.ajax({
            url: baseUrl + '/customer/' + $(this).data('id'),
            type: 'GET',
            success: function(resp) {
                $('#info-name').html(resp.name);
                $('#info-address1').html(resp.address1);
                $('#info-address2').html(resp.address2);
                $('#info-city-zip-code').html(resp.city+' '+resp.zip_code);
                $('#info-phone').html(resp.phone);
                $('#info-fax').html(resp.fax);
                $('#info-email').html(resp.email);
                $('#info-doctor-name').html(resp.doctor_name);
                $('#info-doctor-license').html(resp.doctor_license);

                // image = (resp.image==null) ? "vendor/sample.jpg" : resp.image;
                // imageUrl = baseUrl + '/storage/vendor/'+ image;
                // $('#info-image').attr('src', imageUrl);

                // sign = (resp.sign==null) ? "vendor/sample.jpg" : resp.sign;
                // signUrl = baseUrl + '/storage/vendor/'+ sign;
                // $('#info-sign').attr('src', signUrl);

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

    // Set number only
    $(document).on("input", ".numeric", function() {
        this.value = this.value.replace(/\D/g,'');
    });


    
});

</script>
@endsection
