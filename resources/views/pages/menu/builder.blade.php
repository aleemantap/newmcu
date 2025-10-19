@extends('layouts.app')
@section('title', $title_page_left)

@section('ribbon')
<ul class="breadcrumbs pull-left">
	<li><a href="/home">Home</a></li>
    <li><a href="">Menu</a></li>
    <li><span>Builder</span></li>
   
</ul>
@endsection

@section('content')
        <div class="row">
                    <!-- data table start -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title"></h4>
                                <div class="data-tables">          
                                    <div class="box bg-none no-border">
                                        <div class="box-header no-border text-right">
                                            <button class="btn btn-primary" id="btn-add"><i class="fa fa-plus-circle"></i> @lang('menu.add_new_menu')</button> &nbsp;
                                            <button class="btn btn-default" id="btn-submit"><i class="fa fa-check-circle"></i> @lang('general.update')</button>
                                        </div>

                                        <!-- Menu list update -->
                                        <input id="menu-list" type="hidden">

                                        <div class="box-body mt-2">
                                            <div class="dd" id="nestable">
                                                <ol class="dd-list">
                                                    @each('pages.menu.menu', $menus, 'menu')
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
         </div>
 

@endsection

@section('modal')
    @include('pages.menu.new-item');
@endsection

@section('script')
<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-nestable/jquery.nestable.min.js') }}"></script>
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/smartadmin-production.min.css') }}">
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/theme-material.css') }}">
<script>
    $(document).ready(function () {

        // Activate Nestable
        $('#nestable').nestable({
            group : 1,
            maxDepth: 100,
            noDragClass:'btn-container'
        }).on('change', function() {
            $('#menu-list').val(JSON.stringify($('#nestable').nestable('serialize')));
        });


        // Add new item
        $('#btn-add').click(function(){
            $('#modal-menu-item').modal('show');
            $('#modal-menu-item .modal-title').html('@lang("menu.new_menu_item")');
            $('#modal-menu-item input[type=text]').val('');
            $('#menu-item-id').val('');
        });

        // Edit menu item
        $('#nestable').on('click', '.btn-edit', function() {
            $('#modal-menu-item').modal('show');
            $('#modal-menu-item .modal-title').html('@lang("menu.edit_menu_item")');

            // Hide loder
            $('.page-loader').removeClass('hidden');

            // Get data
            // Send data
            $.ajax({
                url: baseUrl + '/menu/detail/' + $(this).data('id'),
                type: 'GET',
                success: function(resp) {
                    $('#menu-item-id').val(resp.id);
                    $('#menu-name').val(resp.name);
                    $('#tooltip').val(resp.tooltip);
                    $('#description').val(resp.description);
                    $('#icon').val(resp.icon);
                    $('#url').val(resp.action_url);
                    $('#squence').val(resp.sequence);

                    $('.checkbox label input').prop('checked', false);

                    $.each(resp.actions, function(i, o) {
                        $('#action-'+(o.action_type).toLowerCase()).prop('checked', true);
                    });

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

        // Delete menu item
        $('#nestable').on('click', '.btn-delete', function() {

            var id = $(this).data('id');

            if(!confirm('Are you sure want to delete this menu?')) {
                return;
            }

            // Get data
            // Send data
            $.ajax({
                url: baseUrl + '/menu/delete/' + $(this).data('id'),
                type: 'GET',
                success: function(resp) {
                    if(resp.responseCode === 200) {
                        // Remove from menu
                        $('#nestable .dd-item[data-id="'+id+'"]').remove();
                        // Send success message
                        Lobibox.notify('success', {
                            sound: true,
                            icon: true,
                            msg :  resp.responseMessage,
                        });
                    } else {
                       
                        Lobibox.notify('error', {
                            sound: true,
                            icon: true,
                            msg :  xhr.statusText,
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

        // Submit menu item
        $('#btn-submit-item').click(function(){

            // Update when menu item id has value
            var url = baseUrl + '/menu/update';
            var squence = $('#squence').val();
            var action = "update";
            if(!$('#menu-item-id').val()) {
                url = baseUrl + '/menu/save';
                squence = $('#total-child').html();
                action = "save";
            }

            // Check requirement input
            if(!$('#menu-name').val()) {
               

                  Lobibox.notify('error', {
                            sound: true,
                            icon: true,
                            msg : 'Name can\'t be empty',
                        });
                return;
            }

            if(!$('#url').val()) {
              
                  Lobibox.notify('error', {
                            sound: true,
                            icon: true,
                            msg :  'URL can\'t be empty',
                        });
                return;
            }

            // Show loder
            $('.page-loader').removeClass('hidden');

            var actions = [];
            $('.checkbox label input:checked').each(function(i,o) {
                actions.push($(o).val());
            });

            // Send data
            $.ajax({
                url: url,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'menuId': $('#menu-item-id').val(),
                    'menuName': $('#menu-name').val(),
                    'tooltip': $('#tooltip').val(),
                    'description': $('#description').val(),
                    'icon': $('#icon').val(),
                    'url': $('#url').val(),
                    'squence': squence,
                    'actions': actions
                },
                success: function(resp) {
                    if(resp.responseCode === 200) {
                        // Check menu icon
                        var icon = (resp.result.icon === null)?'':resp.result.icon;

                        // IF save added new item
                        if(action == "save") {
                            // Reload item
                            var item = `<li class="dd-item" data-id="`+resp.result.id+`">
                                            <div class="dd-handle">
                                                `+icon+` `+resp.result.name+`

                                                <!-- Button -->
                                                <div class="btn-container">
                                                    <button class="btn btn-warning btn-xs btn-edit" data-id="`+resp.result.id+`"><i class="fa fa-fw fa-pencil"></i> Edit</button>
                                                    <button class="btn btn-danger btn-xs btn-delete" data-id="`+resp.result.id+`"><i class="fa fa-fw fa-trash"></i> @lang('general.delete')</button>
                                                </div>
                                                <!-- /Button -->
                                            </div>
                                        </li>`;
                            // Append new item
                            $('ol.dd-list').append(item);


                            // Update total child
                            $('#total-child').html(parseInt($('#total-child').html()) + 1);
                        } else {
                            // Update item instead of add item
                            var updateItem = `<div class="dd-handle">
                                                `+icon+` `+resp.result.name+`

                                                <!-- Button -->
                                                <div class="btn-container">
                                                    <button class="btn btn-warning btn-xs btn-edit" data-id="`+resp.result.id+`"><i class="fa fa-fw fa-pencil"></i> Edit</button>
                                                    <button class="btn btn-danger btn-xs btn-delete" data-id="`+resp.result.id+`"><i class="fa fa-fw fa-trash"></i> @lang('general.delete')</button>
                                                </div>
                                                <!-- /Button -->
                                            </div>`;
                            $('#nestable .dd-item[data-id="'+resp.result.id+'"]').html(updateItem);
                        }

                        // Reset Form
                        $('#modal-menu-item input[type=text]').val('');
                        // Close modal
                        $('#modal-menu-item').modal('hide');
                        // Send success message
                     
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

        // Submit menu structure
        $('#btn-submit').click(function(){

            if(!$('#menu-list').val()) {
               

                 Lobibox.notify('error', {
                            sound: true,
                            icon: true,
                            msg :  'You don\'t change menu structure',
                        });
                return;
            }

            // Show loder
            $('.page-loader').removeClass('hidden');

            // Send data
            $.ajax({
                url: baseUrl + '/menu/build',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'menuList': $('#menu-list').val()
                },
                success: function(resp) {
                    if(resp.responseCode === 200) {

                        $('#menu-list').val('');

                        // Send success message
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
                    // Hide loder
                    $('.page-loader').addClass('hidden');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                  
                     Lobibox.notify('error', {
                            sound: true,
                            icon: true,
                            msg :   xhr.statusText,
                        });
                    // Hide loder
                    $('.page-loader').addClass('hidden');
                }
            });
        });

    });
</script>
@endsection


@section('css')
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/bootstrap-datepicker.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/jquery-ui.css') }}">
<style>
    .dd {
        margin-bottom: 15px;
    }
    .builder-menu,
    .builder-footer {
        position: relative;
        overflow: auto;
        margin-left: -15px;
        margin-right: -15px;
    }
    .builder-menu {
        border-bottom: 1px solid #ddd;
        padding: 0 15px;
        margin-bottom: 10px;
    }
    .builder-footer {
        border-top: 1px solid #ddd;
        padding: 15px;
        margin-top: 10px;
    }
    .builder-menu .title {
        font-size: 13px;
        font-weight: 700;
    }
    .builder-menu >button {
        position: absolute;
        display: inline;
        top: 0;
        right: 15px;
    }
</style>
@endsection
