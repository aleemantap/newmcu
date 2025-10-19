<table class="table1">
		<tbody>
			<tr>
				<td width="60%">
					
				</td>
				<td style="" width="40%">
					<table class="tb_he">
						<tbody>
							<tr><td width="60%" valign="top">No Paper</td></td></td><td class="td_1" valign="top">{{$data['no_paper']}}</td></tr>
							<tr><td width="60%" valign="top">Medical ID#</td></td></td><td class="td_1" valign="top">{{$data['id']}}</td></tr>
							<tr><td valign="top">Nama</td><td class="td_1" valign="top">{{$data['nama_pasien']}}</td></tr>
							<tr><td width="">Jenis Kelamin</td><td class="td_1">{{$data['jenis_kelamin']}}</td></tr>
							<tr><td>Tanggal Lahir</td><td class="td_1">{{$data['tgl_lahir']}}</td></tr>
							<tr><td>NIP</td><td class="td_1">{{$data['no_nip']}}</td></tr>
							<tr><td>Bagian</td><td class="td_1">{{$data['bagian']}}</td></tr>
							<tr><td valign="top">Perusahaan</td><td class="td_1" valign="top">{{$data->vendorCustomer->vendor->name}}</td></tr>
							
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
</table>
<div class="title_head">
	<span>HASIL PEMERIKSAAN AUDIOMETRI</span>
</div>
<br/>
<br/>
<div style="margin-left:10px;margin-right:10px;">
		<!--
		<table cellpadding="10" cellspacing="0" style="width:100%;margin-top:2px;margin-left:5px;margin-right:5px;margin-bottom:5px;">
			
			<thead>
				<tr >
					<th  width="30%" align="left">Frekuensi Telinga</th>
					<th  width="30%" align="left">Kiri</th>
					<th  width="30%" align="left">Kanan</th>
				</tr>
			</thead>
			
			<tbody>
				<?php $i=0; ?>
				@foreach($data->audiometriDetail as $a)
					@if( $i % 2 == 0)
						<tr>
							<td>{{ $a->frekuensi }}</td>
							<td>{{ $a->kiri }}</td>
							<td>{{ $a->kanan }}</td>
						</tr>
					@else
						<tr style="">
							<td>{{ $a->frekuensi }}</td>
							<td>{{ $a->kiri }}</td>
							<td>{{ $a->kanan }}</td>
						</tr>
					@endif
				<?php $i++; ?>
				@endforeach
			
			</tbody>	
		</table>
		<br/>
			
		<hr>	
		-->
		
	<style type="text/css">
    .table_gr
    {
        display: table;
		width: 100%;
    }
    .title_gr
    {
        display: table-caption;
        text-align: center;
        font-weight: bold;
        font-size: larger;
    }
    .heading_gr
    {
        display: table-row;
        font-weight: bold;
        text-align: center;
    }
    .row_gr
    {
        display: table-row;
    }
    .cell_gr
    {
        display: table-cell;
        border: solid;
        border-width: thin;
        padding-left: 5px;
        padding-right: 5px;
		width : 11.11%;
		height : 34px;
    }
	.cell_gr{
		text-align : center;
		font-weight : 200;
		
	}
	.cell_gr p{
		
		
	}
	
	.non-border-top {
		Sborder-top:none;
	} 
	.non-border-bottom {
		Sborder-bottom:none;
	}
	
	.non-border-left {
		border-left:none;
	}
	
	
	</style>	
	
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
	  google.charts.setOnLoadCallback(drawChart2);

	  var options = {
          title: 'Grafik Audiometri Telinga Kiri',
		  titleTextStyle : { color: "#000",
							  fontName: "arial",
							  fontSize: "12",
							  bold: true,
							  italic: false },
		  //titlePosition : 'none',
          //curveType: 'function',
          legend: { position: 'bottom', maxLines: 3 },
		  series: {
						
						0: {type: 'line',   color : '#002966',  },
						
						},  
		  pointsVisible: true,
		  pointSize: 8, 
		  pointShape: 'diamond',
		  vAxis : { 
						maxValue : 30, 
						minValue : 0, 
						gridlines : {color : '#acacac' }
				  }  
		  //vAxis.minorGridlines.interval
		  //hAxis : { maxValue : 30 )	 vAxis.gridlines.color
        }; 
		
		 var options2 = {
          title: 'Grafik Audiometri Telinga Kanan',
		  titleTextStyle : { color: "#000",
							  fontName: "arial",
							  fontSize: "12",
							  bold: true,
							  italic: false },
          legend: { position: 'bottom', maxLines: 3 },
		  series: {
						
						0: {type: 'line',   color : '#002966',  },
						
						//2: {targetAxisIndex:1}}
						},  
		  pointsVisible: true,
		  pointSize: 8, 
		  pointShape: 'diamond',
		  vAxis : { maxValue : 30, minValue : 0, gridlines : {color : '#acacac' } }  
		  //vAxis.minorGridlines.interval
		  //hAxis : { maxValue : 30 )	 vAxis.gridlines.color
        }; 


      function drawChart() {
		  
		
		 $.ajax({
				url: baseUrl + "/report/patient/data-audiometri-json",
				type: 'POST',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				dataType: "json",
				data: { 
					'id': $('#id_mcu').val(),
					'side': 'kiri',
				},
				success: function (resp) {
					if(resp.responseCode === 200) {
						
					    da = resp.responseMessage;
						var dataChart = [];
						
						dataChart.push(['x', '11224']);
						for (var i = 0; i < da.length; i++) {
							f = da[i].frekuensi.toString(10)
							dataChart.push([f, da[i].kiri]);
							
					    }
						console.log(dataChart);
					    var data = google.visualization.arrayToDataTable(dataChart);
					  
					 	
						var chart_div = document.getElementById('chart_audio');
						var chart = new google.visualization.ColumnChart(chart_div);
						
						
						
						//google.visualization.events.addListener(chart, 'ready', titleCenter);
						
						google.visualization.events.addListener(chart, 'ready', function () {
							//titleCenter();
							chart_div.innerHTML = '<img src="' + chart.getImageURI() + '">';
						
						});
						chart.draw(data, options); 
					
					}
				}
			});	
    }
    
	function Title_center(){

     var title_chart=$("#chart_audio2 svg g").find('text').html();   

     $("#chart_audio2 svg").find('g:first').html('<text text-anchor="start" x="500" y="141" font-family="Arial" font-size="18" font-weight="bold" stroke="none" stroke-width="0" fill="#000000">'+title_chart+'</text>');
	}
	
	 function titleCenter() {

	 		var $container = $('#chart_audio');
	 		var svgWidth = $container.find('svg').width();
	 		var $titleElem = $container.find("text:contains(" + options.title + ")");
	 		var titleWidth = $titleElem.html().length * ($titleElem.attr('font-size')/2);
	 		var xAxisAlign = (svgWidth - titleWidth)/2;
	 		$titleElem.attr('x', xAxisAlign);
	 		//$titleElem.attr('x', 200);
	 }
	//paintSvgToCanvas(document.getElementById('source'), document.getElementById('tgt'));
    function drawChart2() {
        
		
		 $.ajax({
				url: baseUrl + "/report/patient/data-audiometri-json",
				type: 'POST',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				dataType: "json",
				data: { 
					'id': $('#id_mcu').val(),
					'side': 'kanan',
				},
				success: function (resp) {
					if(resp.responseCode === 200) {
						
					    da = resp.responseMessage;
						var dataChart = [];
						
						dataChart.push(['x', '11224']);
						for (var i = 0; i < da.length; i++) {
							f = da[i].frekuensi.toString(10)
							dataChart.push([f, da[i].kanan]);
							
					    }
						console.log(dataChart);
					    var data = google.visualization.arrayToDataTable(dataChart);
					  
					 	
						var chart_div = document.getElementById('chart_audio2');
						var chart = new google.visualization.ColumnChart(chart_div);
						
						//google.visualization.events.addListener(chart, 'ready', Title_center);
						google.visualization.events.addListener(chart, 'ready', function () {
							chart_div.innerHTML = '<img src="' + chart.getImageURI() + '">';
						
						});
						chart.draw(data, options2); 
						
						
					
					
					}
				}
			});	
			
		
		
		
    }
	
	
	</script>

     <div style="text-align:center;font-weight:bold;"></div>
	 <div id="chart_audio" style="width: 100%; height: 200px"></div>
	 <div style="text-align:center;font-weight:bold;"></div>
	 <div id="chart_audio2" style="width: 100%; height: 200px;"></div>

	<br/>
	<table style="width:100%;margin-top:2px;margin-left:5px;margin-right:5px;margin-bottom:5px;border-collapse: separate;
  				border-spacing: 10px;">
		<tbody> 
			<tr ><td><span style="font-size:14;font-weight:bold;">Hasil Audiometri</span> </td></tr>
			<tr><td style="padding-left:20px;">{{ $data->oae?$data->oae->hasil_oae_ki:'' }} dan {{ $data->oae?$data->oae->hasil_oae_ka:'' }}</td></tr>
			<tr ><td><span style="font-size:14;font-weight:bold;">Kesimpulan Audiometri</span></td></tr>
			<tr><td style="padding-left:20px;">{{ $data->oae?$data->oae->kesimpulan_oae:'' }}</td></tr>
		</tbody>
	</table>
	
</div>