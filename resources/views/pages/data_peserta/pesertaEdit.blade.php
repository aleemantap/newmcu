@extends('layouts.app')
@section('title', 'Absensi Data')
@section('content-class', 'grid')

@section('ribbon')
<ol class="breadcrumb">
    <li>Planning</a></li>
    <li><a href="{{url('planning/data-peserta/')}}">Peserta Project</a></li>
    <li><a href="{{url('planning/data-peserta-project-detail')}}/{{$data->id_inisialisasi}}">Peserta Per Project</a></li>
    <li>Edit Peserta Project ID {{$data->project_id}}</li>  
</ol>
@endsection

@section('content')
<input type="hidden" id="id_data_peserta" value="{{$id}}">
<input type="hidden" id="id_ini" value="{{$data->id_inisialisasi}}">
<input type="hidden" id="project_id" value="{{$data->project_id}}">
<div class="row">
	<div class="panel panel-report">
				
				<div class="col-md-12">
				
					<form style="margin-top:10px;">
						<div class="form-row col-md-12">
							<div class="form-group col-md-3">
									<label for="partner">Partner</label>
									<div  class="form-control" id="partner" style="background-color: #fff000;"   >{{$vendor->vendor->name}}</div>
							</div>
							<div class="form-group col-md-3">
									<label for="perusahaan">Perusahaan/Client</label>
									<div  class="form-control" id="perusahaan" style="background-color: #fff000;"   >{{$vendor->customer->name}}</div>
							</div>	
							<div class="form-group col-md-3">
									<label for="partner">Pasien ID</label>
									<div  class="form-control" id="id_pasien" style="background-color: #fff000;"   >{{$data->id_pasien}}</div>
							</div>							
						</div>
						<div class="form-row col-md-12">
							
							<div class="form-group col-md-3">
									<label for="nama_pasien">Nama Pasien</label>
									<input type="text" class="form-control" id="nama_pasien" style="background-color: #fff;" value="{{$data->nama_pasien}}">
							</div>		
							<div class="form-group col-md-3">
									<label for="no_nip">No NIP</label>
									<input type="text" class="form-control" id="no_nip" style="background-color: #fff;"   value="{{$data->no_nip}}">
							</div>	
							<div class="form-group col-md-3">
									<label for="no_paper">No Paper</label>
									<input type="text" class="form-control" id="no_paper" style="background-color: #fff;"   value="{{$data->no_paper}}">
							</div>	
							<div class="form-group col-md-3">
									<label for="tgl_lahir">Tanggal Lahir</label>
									<input type="text" class="form-control" id="tgl_lahir" data-provide="datepicker" data-date-format="yyyy-mm-dd" style="background-color: #fff;" value="{{$data->tgl_lahir}}"  >
									
							</div>	
						</div>
						<div class="form-row col-md-12">
							<div class="form-group col-md-3">
									<label for="jenis_kelamin">Jenis Kelamin</label>
									<select class="form-control" id="jenis_kelamin">
										<option value="">&raquo; -- Jenis Kelamin --</option>
										<option value="L">Laki-laki</option>
										<option value="P">Perempuan</option>
									</select>
									
							</div>		
							<div class="form-group col-md-3">
									<label for="bagian">Bagian</label>
									<input type="text" class="form-control" id="bagian" style="background-color: #fff;"   value="{{$data->bagian}}">
							</div>	
							<div class="form-group col-md-3">
									<label for="client">Client</label>
									<input  class="form-control" id="client" style="background-color: #fff;"   value="{{$data->client}}">
							</div>	
							<div class="form-group col-md-3">
									<label for="paket_mcu">Paket MCU</label>
									<input  class="form-control" id="paket_mcu" style="background-color: #fff;" value="{{$data->paket_mcu}}"  >
							</div>	
						</div>
						<div class="form-row col-md-12">
							<div class="form-group col-md-3">
									<label for="email">Email</label>
									<input type="text" class="form-control" id="email" style="background-color: #fff;" value="{{$data->email}}">
							</div>		
							<div class="form-group col-md-3">
									<label for="telepon">Telepon</label>
									<input type="text" class="form-control" id="telepon" style="background-color: #fff;"   value="{{$data->telepon}}">
							</div>	
								
						</div>
						<div class="form-row col-md-12">
							 <div class="panel-footer">
								 <a href="javascript:history.back()" class="btn btn-success"><i class="fa fa-arrow-circle-left"></i> Back</a>
								 <button type="button" class="btn btn-primary" id="btn-save-edit-peserta"><i class="fa fa-save"></i> Submit</button>
								
							 </div>
								
						</div>
						
					<form>
					
				</div>
				
	 </div>
	

</div>
@endsection
 

@section('css')
<link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.css') }}" />
<link rel="stylesheet" type="text/css" media="screen" href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css">

 
@endsection

@section('script')
<script src="{{ asset('js/plugin/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
<script>
$(document).ready(function () {


    $('.datepicker').datepicker({
         autoclose: true,
         format: 'yyyy-mm-dd',
    });

	 $('select').select2({
        width: '100%',
        //containerCssClass: 'select-xs'
    });
	 var selected = "<?php echo $data->jenis_kelamin;?>";
	
	 $("#jenis_kelamin").select2().val(selected).trigger("change");
	 $('body').on('click', '#btn-save-edit-peserta', function() {
		
		 if(!$('#nama_pasien').val()) {
            $.smallBox({
                //height: 50,
                title : "Error",
                content : 'Nama Pasien name can\'t be empty',
                color : "#dc3912",
                sound_file: "smallbox",
                timeout: 3000
                //icon : "fa fa-bell swing animated"
            });
            $('#nama_pasien').focus();
            return;
        }
        if(!$('#no_nip').val()) {
            $.smallBox({
                //height: 50,
                title : "Error",
                content : 'No Nip can\'t be empty',
                color : "#dc3912",
                sound_file: "smallbox",
                timeout: 3000
                //icon : "fa fa-bell swing animated"
            });
            $('#no_nip').focus();
            return;
        }
		
		 if(!$('#no_paper').val()) {
            $.smallBox({
                //height: 50,
                title : "Error",
                content : 'No Paper can\'t be empty',
                color : "#dc3912",
                sound_file: "smallbox",
                timeout: 3000
                //icon : "fa fa-bell swing animated"
            });
            $('#no_paper').focus();
            return;
        }
		
		 if(!$('#tgl_lahir').val()) {
            $.smallBox({
                //height: 50,
                title : "Error",
                content : 'Tgl lahir can\'t be empty',
                color : "#dc3912",
                sound_file: "smallbox",
                timeout: 3000
                //icon : "fa fa-bell swing animated"
            });
            $('#tgl_lahir').focus();
            return;
        }
		
		if(!$('#jenis_kelamin').val()) {
            $.smallBox({
                //height: 50,
                title : "Error",
                content : 'Jenis kelamin can\'t be empty',
                color : "#dc3912",
                sound_file: "smallbox",
                timeout: 3000
                //icon : "fa fa-bell swing animated"
            });
            $('#jenis_kelamin').focus();
            return;
        }
		if(!$('#bagian').val()) {
            $.smallBox({
                //height: 50,
                title : "Error",
                content : 'Bagian can\'t be empty',
                color : "#dc3912",
                sound_file: "smallbox",
                timeout: 3000
                //icon : "fa fa-bell swing animated"
            });
            $('#bagian').focus();
            return;
        }
		if(!$('#client').val()) {
            $.smallBox({
                //height: 50,
                title : "Error",
                content : 'Client can\'t be empty',
                color : "#dc3912",
                sound_file: "smallbox",
                timeout: 3000
                //icon : "fa fa-bell swing animated"
            });
            $('#client').focus();
            return;
        }
		if(!$('#paket_mcu').val()) {
            $.smallBox({
                //height: 50,
                title : "Error",
                content : 'Paket mcu can\'t be empty',
                color : "#dc3912",
                sound_file: "smallbox",
                timeout: 3000
                //icon : "fa fa-bell swing animated"
            });
            $('#paket_mcu').focus();
            return;
        }
		
		if(!$('#telepon').val()) {
            $.smallBox({
                //height: 50,
                title : "Error",
                content : 'Telepon can\'t be empty',
                color : "#dc3912",
                sound_file: "smallbox",
                timeout: 3000
                //icon : "fa fa-bell swing animated"
            });
            $('#telepon').focus();
            return;
        }
			    
		  $('.page-loader').removeClass('hidden');
          // Send data
          var ar = [];
          $.ajax({ 
			url: baseUrl + "/planning/data-peserta-project-detail-update", 
			type: 'POST',
			headers: { 
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				id : $("#id_data_peserta").val(),
				nama_pasien: $("#nama_pasien").val(),
				no_nip : $("#no_nip").val(),
				no_paper : $("#no_paper").val(),
				tgl_lahir : $("#tgl_lahir").val(),
				jenis_kelamin : $("#jenis_kelamin").val(),
				bagian : $("#bagian").val(),
				client : $("#client").val(),
				paket_mcu :  $("#paket_mcu").val(),
				email :  $("#email").val(),
				telepon : $("#telepon").val(),
			},
			success: function(resp) {
                    if(resp.responseCode === 200) {
						
							$.smallBox({
                                height: 50,
                                title : "Success",
                                content : resp.responseMessage,
                                color : "#3d8b40", 
                                sound_file: "smallbox",
                                timeout: 6000
                                //icon : "fa fa-bell swing animated"
                            });
							window.location.href= baseUrl + "/planning/data-peserta-project-detail/"+$('#id_ini').val(); 
                          
                        } else {
                            $.smallBox({
                                height: 50,
                                title : "Error",
                                content : resp.responseMessage,
                                color : "#dc3912",
                                sound_file: "smallbox",
                                timeout: 6000
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
                            timeout: 6000
                            //icon : "fa fa-bell swing animated"
                        });
                        // Hide loder
                        $('.page-loader').addClass('hidden');
                    }
                
            });
		
	 });
	 
});

</script>
@endsection
