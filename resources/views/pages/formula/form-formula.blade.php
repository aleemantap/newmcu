@extends('layouts.app')

@section('ribbon')
<ol class="breadcrumb">
    <li>@lang('menu.database')</li>
    <li>@lang('formula.formula')</li>
    <li>@lang('general.create')</li>
</ol>
@endsection

@section('content')
<div class="container">
 	<div class="row">
		<div class="col-md-12 mt-4">
			<div class="card">				
				<div class="card-body">
					<div class="panel panel-report">
					    <div class="panel-heading bg-primary">
                            <strong><i class="fa fa-th-large"></i> Form Formula</strong>
                        </div>
						<div class="panel-body px-5">   
							<div class="form-horizontal mt-4" id="form-formula">
								<div class="form-group row">
									<label for="" class="control-label col-md-2">@lang('formula.formula_name')</label>
									<div class="col-md-4">
										<input type="text" id="formula-name" class="form-control  form-control-sm">
									</div>
								</div>
								<!--
								<div class="form-group row">
									<label for="" class="control-label col-md-2">Pilih Jenis Inputan</label>
									<div class="col-md-4">
										<select name="inputan" id="pilih-jenis-inputan" class="form-control input-xs">
											<option value="bukancontain">Bukan Contain</option>
											<option value="contain">Contain</option>
										</select>
									</div>
								</div>-->
							
								<div class="form-group row" id="open-2">
									<label class="control-label col-md-2">@lang('formula.parameter')</label>
									<div class="col-md-4">
										<select name="" id="parameter" class="form-control  form-control-sm select2-multiple" multiple>
											@foreach($parameters as $param)
											<option value="{{ $param->id }}"  {{ $param->id == $parameter_id ? 'selected' : '' }} >{{ $param->name }}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="form-group row">
									<label class="control-label col-md-2">Logika Antar Parameter</label>
									<div class="col-md-4">
									   <select name="" id="logika" class="form-control  formula-name-sm" >
											
											<option value="and">And</option>
											<option value="or">Or</option>
											
										</select>
									</div>
								</div>
								<div class="form-group row">
									<label class="control-label col-md-2"></label>
									<div class="col-md-4">
										<button type="button" id="btn-add-condition" class="input-xs btn btn-xs btn-flat btn-success"><i class="fa fa-plus-circle"></i> @lang('formula.create_condition')</button>
									</div>
								</div>
								
								<div class="form-group row">
									<div class="col-md-12">
										<div id="condition-container"></div>
									</div>
								</div>
								<div id="c_formgenerate">
								</div>
						</div>
					
				        </div>
				    </div>
				</div>
				<div class="card-body">
					<button  class="btn btn-xs btn-flat btn-default {{ $parameter_id == '' ? 'visible' : 'invisible' }}">Reset</button>
					<a href="javascript:history.back()" class="btn btn-success btn-xs btn-flat">@lang('general.back')</a>
					<button type="button" class="btn btn-primary btn-xs btn-flat" id="btn-submit"><i class="fa fa-check-circle"></i> @lang('general.submit')</button>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection


@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker.css') }}" />
@endsection


@section('script')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('assets/js/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>

<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script>
    // Get work health data
    let workHealth = [];
    $.getJSON(baseUrl + '/database/formula/workHealths-json', function(resp) {
        $.each(resp, function(i, obj) {
            workHealth.push({
                id: obj.id,
                name: obj.name
            });
        });
    });
    // End of work health data

    $(document).ready(function () {
       
        $('#parameter').select2({
            width: '100%',
            containerCssClass: 'select-xs'
        });
		
		
		// var p = $('#pilih-jenis-inputan').val();
		
		// if(p=="bukancontain")
		// {
			
			// $('#open-2').css({"display" : ""});
		// }
		// else
		// {
			// $('#open-2').css({"display" : "none"});
		// }
       

		
		
		//
		// open-2
		 // $('#pilih-jenis-inputan').change(function() {
            // var select = $(this).val();
			// if(select=="bukancontain")
			// {
				
				// $('#open-2').css({"display" : ""});
			// }
			// else
			// {
				// $('#open-2').css({"display" : "none"});
			// }
        // });

        // Create new condition
        $('#btn-add-condition').click(function() {
           
			//if( $('#pilih-jenis-inputan').val()=="bukancontain")
			//{
				//createForm();
			//}
			//else
			//{
			//	createFormContain();
				
			//}
			
			createForm();
            
        });

        // Create new condition from added element
        $('#condition-container').on('click','.btn-add', function() {
            createForm();
        });

        // Remove condition
        $('#condition-container').on('click','.btn-remove', function() {
            var el = $(this);
            removeForm(el);
        });

        // Search ICDX
        $('#condition-container').on('focus','.icdx-name', function() {
            $(this).autocomplete({
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
                $(this).next().val(ui.item.id);
                $(this).val(ui.item.name);
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
        // End search ICDX

        // Hide and show recommendation
        $('#condition-container').on('click', '.show-diagnosis', function(){
            //console.log("tes");
            //alert("ss");
            $(this).toggleClass('on');
            $(this).parents('.form-horizontal').find('.group-diagnosis').toggleClass('hidden');
            $(this).hasClass('on') ? $(this).next().val(1) : $(this).next().val(0);
        });

        // Submit or create new formula
		/*$('#btn-submit').click(function() {
				// Validate data
				if(!$('#formula-name').val()) {
					$.smallBox({
						height: 50,
						title : "Warning",
						content : "Nama formula harus diisi dulu",
						color : "#c79121",
						sound_file: "smallbox",
						timeout: 3000
					});
					return false;
				}
				
				
				var p = $('#pilih-jenis-inputan').val();
				
				if(p=="bukancontain")
				{
					
					if($('#parameter').val().length == 0) {
						$.smallBox({
							height: 50,
							title : "Warning",
							content : "Parameter harus diisi dulu",
							color : "#c79121",
							sound_file: "smallbox",
							timeout: 3000
						});
						return false;
					}
				}
				
			
			// Initial data
            var arrParam = [];
           
            // Create parameter data
            var params = $('#parameter').select2('data');
            for(var i=0; i<params.length; i++) {
                var param = {
                    urutan: i+1,
                    nmkolom: params[i].text,
                    parameter_id: params[i].id
                };
                arrParam.push(param);
            }
          
					
				
			$.ajax({
                url: baseUrl + "/database/formula/insert-formformula",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                cache : false,
                data: {
                    nama_rumus :  $('#formula-name').val(),
                    data_parameter :  arrParam,
                    jenis_inputan : $('#pilih-jenis-inputan').val(),
                    parameter : $('#parameter').val(),
                    
                },
                success: function(resp) {
                    if(resp.responseCode === 200) {
                        // Redirect to database/formula
                        loc = baseUrl +"/database/formula";
                        window.location.replace(loc);

                        // Send success message
                        $.smallBox({
                            height: 50,
                            title : "Success",
                            content : resp.responseMessage,
                            color : "#109618",
                            sound_file: "voice_on",
                            timeout: 3000
                        });
                    } else if(resp.responseCode === 201) {
                        $.smallBox({
                            height: 50,
                            title : "Error",
                            content : resp.responseMessage,
                            color : "#dc3912",
                            sound_file: "smallbox",
                            timeout: 3000
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
			
       
			
		});*/
		
		
        $('#btn-submit').click(function() {
            // Validate data
            if(!$('#formula-name').val()) {
               
				Lobibox.notify('warning', {
					sound: true,
					icon: true,
					msg : "Nama formula harus diisi dulu",
				});
                return false;
            }

            if(!$('#parameter').val()) {
                    Lobibox.notify('warning', {
                        sound: true,
                        icon: true,
                        msg : "Parameter harus diisi dulu",
                    });
                return false;
            }

            // Validate condition
            if($('#condition-container').html() === '') {
              
                Lobibox.notify('warning', {
                        sound: true,
                        icon: true,
                        msg : "Harap tambahkan paling sedikit satu kondisi",
                    });
                return false;
            }

            var conditionFormCompleted = true;
            $('.parameter').each(function(i, o) {
                if(!$(o).val()) {
                    conditionFormCompleted = false;
                }
            });

            if(conditionFormCompleted === false) {
              
                Lobibox.notify('warning', {
                        sound: true,
                        icon: true,
                        msg : 'Harap lengkapi form kondisi!',
                    });
                return false;
            }

            // Initial data
            var arrColumn = [];
            var arrParam = [];
            var arrCondition = [];

            // Create parameter data
            var params = $('#parameter').select2('data');
            for(var i=0; i<params.length; i++) {
                var param = {
                    urutan: i+1,
                    nmkolom: params[i].text,
                    parameter_id: params[i].id
                };
                arrParam.push(param);
                arrColumn.push(params[i].text);
            }
            arrColumn.push('kesimpulan');

            // Create condition data
            $('#condition-container>.panel').each(function(i, o) {
                var arrColumnValue = [];
                var arrUnit = [];
                var arrOperator = [];

                // Create arrColumnValue
                $(o).find('.parameter').each(function(paramIndex, parameter) {
                    arrColumnValue.push($(parameter).val());
                });

                // Create arrUnit
                $(o).find('.unit').each(function(unitIndex, unit) {
                    arrUnit.push($(unit).val());
                });

                // Create arrOperator
                $(o).find('.operator').each(function(operatorIndex, operator) {
                    arrOperator.push($(operator).val());
                });

                var condition = {
                    nilai_kolom: arrColumnValue,
                    satuan: arrUnit,
                    operator: arrOperator,
                    yt_r: $(o).find('.diagnosis-value').val(),
                    icdx: $(o).find('.icdx-id').val(),
                    diagnosis: $(o).find('.work-diagnosis').val(),
                    recommendation: $(o).find('.recommendation').val()
                };

                arrCondition.push(condition);
            });

            $.ajax({
                url: baseUrl + "/database/formula/insert-formformula",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                cache : false,
                data: {
                    nama_rumus :  $('#formula-name').val(),
                    data_parameter :  arrParam,
                    parameter : $('#parameter').val(),
                    data_form : arrCondition,
                    arr_kolom : arrColumn,
                    logika : $('#logika').val()
                },
                success: function(resp) {
                    if(resp.responseCode === 200) {
                        // Redirect to database/formula
                        loc = baseUrl +"/database/formula";
                        window.location.replace(loc);

                        // Send success message
                        Lobibox.notify('success', {
                            sound: true,
                            icon: true,
                            msg :  resp.responseMessage,
                        });
                    } else if(resp.responseCode === 201) {
                        Lobibox.notify('error', {
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

    // Generate operator option
	function createOperator()
	{
        return `<select class="form-control form-control-sm operator">
					<option value="=="> = </option>`+
					`<option value="<>"> <> </option>`+
					`<option value="<="> <= </option>`+
					`<option value=">="> >= </option>`+
					`<option value="<"> < </option>`+
					`<option value=">"> > </option>`+
					`<option value="range"> RANGE </option>`+
					`<option value="not range"> NOT RANGE </option>`+
					`<option value="enum"> Enum </option>`+
					`<option value="not enum"> NOT Enum</option>`+
					`<option value="contain2">Contain2</option>`+
					`<option value="intext">InText</option>`+
					`<option value="not intext">NOT InText</option>`+
					`<option value="include">Include</option>`+
					`<option value="not include">Not Include</option>`+
                `</select>`;
    }

    // Generate workhealth
    function createWorkHealth()
    {
        let options = ``;
        if(workHealth.length > 0) {
            $.each(workHealth, function(i, o) {
                options += `<option value="`+o.id+`">`+o.name+`</option>`;
            });
        }

        return `<select class="form-control form-control-sm work-diagnosis input-xs">`+options+`</select>`;
    }
	// Generate condition form Contain
    function createFormContain()
    {
		cn ='<div class="form-contain">'+
							'<input type="hidden" id="rumus-id-c" value="">'+
							'<table class="table tb-m" width="100%">'+
								'<tr class="" style="">'+
									'<td valign="top"><b>&nbsp;Kondisi</b></td>'+
									'<td valign="top"><b>&nbsp;ICD X &nbsp;&nbsp;</b></td>'+
									'<td valign="top"><b>&nbsp;Work Diagnosis&nbsp;&nbsp;</b></td>'+
									'<td valign="top"><b>Recommendation</b></td>'+
									'<td valign="top"><b>Action</b></td>'+
								'</tr>'+
								'<tbody>'+
									'<tr class="tr-a tr" style="">'+
										
										'<td valign="top">'+
											'<input type="text" class="form-control input-xs" value="" id="name-kondisi" />'+
										'</td>'+
										'<td valign="top">'+
										   '<input type="text" id="icdx-name2" value="" class="form-control input-xs icdx-name2">'+
										   '<input type="hidden" value="" id="icdx-id2" readonly="">'+
										'</td>'+
										'<td valign="top" >'+
										  
										'</td>'+
										'<td valign="top">'+
											 '<textarea class="form-control input-xs recommendation" cols="20" rows="2" id="recommendation" >'+
											 '</textarea>'+
										'</td>'+
										'<td valign="top">'+
											'<button class="edit2 btn btn-xs btn-default"><i class="fa fa-pencil"></i> @lang("general.edit")</button> <button class="save2 btn btn-default btn-xs"><i class="fa fa-save"></i> @lang("general.save")</button>  <button class="add22c btn btn-default btn-xs"><i class="fa fa-plus"></i> Add</button>  '+
										'</td>' 
									'</tr>'+
								'</tbody>'+
							'</table>'+
			'</div>';
							
						
		 $('#condition-container').append(cn);

	}

    // Generate condition form
    function createForm()
    {
        // Check if parameter empty
        if(!$('#parameter').val()) {
           
			Lobibox.notify('warning', {
				sound: true,
				icon: true,
				msg : "Parameter harus diisi dulu",
			});
            return false;
        }

        // Get parameter value
        var params = $('#parameter').val();
        var labels = $('#parameter option:selected').text();

        // Form structure
        var paramsForm = "";

        $('#parameter option:selected').each(function(i, o) {
            var paramValue = $(o).attr('value');
            var paramLabel = $(o).html();

            // Check if parameter jenis kelamin
            if(paramLabel.toLowerCase() == 'jenis kelamin') {
                // Parameter is `jenis kelamin`
                paramsForm += `
                <div class="form-group row">
                    <label for="" class="control-label col-md-2">`+paramLabel+`</label>
                    <div class="col-md-2">
                        <input type="hidden" class="operator" value="==">
                        <input type="hidden" class="unit">
                        <select class="form-control input-xs parameter">
                            <option value="LAKI-LAKI">LAKI-LAKI</option>
                            <option value="PEREMPUAN">PEREMPUAN</option>
                        </select>
                    </div>
                </div>`;
            } else {
                paramsForm += `
                <div class="form-group row">
                    <label for="" class="control-label col-md-2">`+paramLabel+`</label>
                    <div class="col-md-2">
                        `+createOperator(i)+`
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control form-control-sm parameter">
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control form-control-sm unit" placeholder="@lang('formula.unit_available')">
                    </div>
                </div>`;
            }
        });

        var content = `
        <div class="panel panel-default panel-condition" style="border: 1px solid #ccc;">
            <div class="panel-heading bg-white no-border">
                <span class="text-default">Kondisi 1</span>
                <div class="pull-right">
                    <button class="btn btn-danger btn-sm btn-remove"><i class="fa fa-close"></i></button>
                    <button class="btn btn-success btn-sm btn-add"><i class="fa fa-plus"></i></button>
                </div>
            </div>
             <div class="panel-body">
                <div class="form-horizontal row">
                    <div class="form-condition-container" style="width:100%;">`+paramsForm+`</div>
                    <div class="form-group row" style="margin-bottom: 0; margin-top: -15px">
                        <div class="col-md-12">
                            <div style="border-bottom: 1px dashed #ccc; margin-top: 15px; margin-bottom: 15px"></div>
                        </div>
                    </div>
                    <div class="form-condition-container" style="width:100%;">
                        <div class="form-group row">
                            <label for="" class="control-label col-md-2">@lang('formula.conclusion')</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control form-control-sm parameter" value="Abnormal">
                                <input type="hidden" class="operator" value="hasil">
                                <input type="hidden" class="unit">
                            </div>
                        </div>
                    </div>
                    <div class="form-condition-container" style="width:100%;">
                        <div class="form-group row">
                            <label for="" class="control-label col-md-2">@lang('formula.add_diagnosis')</label>
                            <div class="col-md-10">
                                <div class="switch show-diagnosis">
                                    <div class="switch-inner"></div>
                                </div>
                                <input type="hidden" class="diagnosis-value" value="0" />
                            </div>
                        </div>
                    </div>
                    <div class="form-condition-container" style="width:100%;">
                        <div class="form-group row group-diagnosis hidden">
                            <label for="" class="control-label col-md-2">ICD X</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control form-control-sm icdx-name">
                                <input type="hidden" class="icdx-id" />
                            </div>
                            <label for="" class="control-label col-md-2">@lang('formula.work_diagnosis')</label>
                            <div class="col-md-3">`+createWorkHealth()+`</div>
                        </div>
                    </div>
                     <div class="form-condition-container" style="width:100%;">
                         <div class="form-group row group-diagnosis hidden">
                            <label for="" class="control-label col-md-2">@lang('formula.recommendation')</label>
                            <div class="col-md-8">
                                <textarea name="" id="" rows="2" class="form-control form-control-sm recommendation"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
             </div>
        </div>`;

        // Add to container 
        $('#condition-container').append(content);
        //$('#condition-container').append(paramsForm);

        // Set condition title
        $('#condition-container > .panel').each(function(i, o) {
            $(o).children('.panel-heading').children('span').html('@lang("formula.condition") ' + parseInt(i + 1));
            $(o).children('.panel-body').find('.diagnosis_yes').attr('name', 'diagnosis' + parseInt(i + 1));
            $(o).children('.panel-body').find('.diagnosis_no').attr('name',  'diagnosis' + parseInt(i + 1));
        });
    }

    // Remove condition form
    function removeForm(el)
    {
        el.parents('.panel-condition').remove();

        // Set condition title
        $('#condition-container > .panel').each(function(i, o) {
            $(o).children('.panel-heading').children('span').html('@lang("formula.condition") ' + parseInt(i + 1));
            $(o).children('.panel-body').find('.diagnosis_yes').attr('name', 'diagnosis' + parseInt(i + 1));
            $(o).children('.panel-body').find('.diagnosis_no').attr('name',  'diagnosis' + parseInt(i + 1));
        });
    }
</script>
@endsection
