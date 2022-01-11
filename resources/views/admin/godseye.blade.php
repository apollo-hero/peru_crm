@extends('admin.layout.base')

@section('title', 'Dashboard ')

@section('styles')
	<link rel="stylesheet" href="{{asset('main/vendor/jvectormap/jquery-jvectormap-2.0.3.css')}}">
@endsection

@section('content')
<?php $diff = ['-success','-info','-warning','-danger']; ?>

<div class="content-area py-1">
<div class="container-fluid">
		<div class="box box-block bg-white">
				<div class="clearfix mb-1">
					<h5 class="float-xs-left">@lang('admin.heatmap.godseye')</h5>
					<div class="float-xs-right">
					<button class="btn btn-default godseye_menu" data-value="STARTED">En ruta al Origen</button>
					<button class="btn btn-default godseye_menu" data-value="ARRIVED">Llego al Origen</button>
					<button class="btn btn-default godseye_menu" data-value="PICKEDUP">Viaje comenzó</button>
					<button class="btn btn-default godseye_menu" data-value="ACTIVE">Activo</button>
					<button class="btn btn-primary godseye_menu" data-value="ALL">Todos</button>

					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<input type="text" id="filter_users" class="form-control" style="width: 98%;border-radius: 5px;margin: 3px;" placeholder="Search..">
						<h3 class="provider_title btn-primary">Todos</h3>
						<ul class="provider_list"></ul>
					</div>
					<div class="col-md-8">
						<div id="map" style="width:100%;height:500px;background:#ccc"></div>
					</div>
				</div>
			</div>
	</div>
</div>
@endsection

@section('scripts')
	<script src="https://maps.googleapis.com/maps/api/js?key={{Config::get('constants.map_key')}}&libraries=places&language=en"></script>

	<script src="https://www.gstatic.com/firebasejs/7.2.2/firebase-app.js"></script>
	<script src="https://www.gstatic.com/firebasejs/7.2.2/firebase-database.js"></script>

	<script>
		var map, info;
		var markers = [];
		var status = "ALL";
		var filter_text = null;
		var queue_of_list = {};
		var left_providers = null;
		var left_markers = [];

		function set_click_events() {
			for(var idx in queue_of_list) {
				var obj = document.getElementById(idx);
				if(obj == null || left_providers[idx] == null) continue;
				left_marker(queue_of_list[idx], idx);
				delete queue_of_list[idx];
			}
		}

		$(document).ready(function() {
			setInterval(set_click_events, 900);
		});

		$('#filter_users').keyup(function() {
			filter_text = $(this).val();
			getProviders();
		});
		
		function getProviders() {
			$.get("{{ route('admin.godseye_list') }}/?status="+status, {"filter_text":filter_text}, function(data) {
				var locations = data.locations;
				var providers = data.providers;
				left_providers = {};
				$('.provider_list').empty();
				console.log(providers);
				for (i = 0; i < locations.length; i++) {
					if(providers[i].id==246){
						//console.log(providers[i]+': LAT: '+locations[i].lat+ '-'+' LONG: '+locations[i].lng);
						console.log(providers[i].trips[providers[i].trips.length -1].status);
					}
					left_providers[providers[i].id] = providers[i];
					var image = "{{ asset('/asset/img/grey.png') }}";

					if(providers[i].service.status == 'active') {
						image = "{{ asset('/asset/img/green.png') }}";
					}
					else{
						if(providers[i].trips[providers[i].trips.length -1]==null){
								// este chofer no tiene carreras
						}
						else{
							if(providers[i].service.status == 'riding' && providers[i].trips[providers[i].trips.length -1].status == 'STARTED') {
							//	console.log('icono 1');
								image = "{{ asset('/asset/img/red.png') }}";
							} else if(providers[i].service.status == 'riding' &&  providers[i].trips[providers[i].trips.length -1].status =='ARRIVED') {
								//console.log('icono 2');
								image = "{{ asset('/asset/img/yellow.png') }}";
							} else if(providers[i].service.status == 'riding' && providers[i].trips[providers[i].trips.length -1].status == 'PICKEDUP') {
								//console.log('icono 3');
								image = "{{ asset('/asset/img/blue.png') }}";
							} else {
								//console.log('icono 4');
								image = "{{ asset('/asset/img/grey.png') }}";
							}
						}
					}
					
					

					var avatar = (providers[i].avatar == null || providers[i].avatar == "") ? "{{asset('main/avatar.jpg')}}" : "{{asset('/storage/')}}"+"/"+providers[i].avatar ;
			        var li = $(`<li id="`+providers[i].id+`">
						<label class="image">
							<label class="image">
								<img src="`+avatar+`">
							</label>
							<img src="`+image+`">
						</label>
						<p>`+providers[i].first_name+` `+providers[i].last_name+` 
						<b>`+providers[i].mobile+`</b></p>
					</li>`).on('click', function() {
						var key = $(this).attr('id');
						if(left_markers[key]) {
							selectProvider(left_markers[key]);
						}
					});

					$('.provider_list').append(li);
				}
			});
		}
		$(document).ready(function($) {
			initMap();
			getProviders();
		});
			/*var firebaseConfig = {
				apiKey: "AIzaSyAdV1wE7mQ7P8oWyUKT_IR_U_6QwYf9n3I",
    authDomain: "miappdetaxicapital.firebaseapp.com",
    databaseURL: "https://miappdetaxicapital.firebaseio.com",
    projectId: "miappdetaxicapital",
    storageBucket: "miappdetaxicapital.appspot.com",
    messagingSenderId: "776928680024",
    appId: "1:776928680024:web:b05a8a9295aab524f5922d",
    measurementId: "G-7ES0BBH0H3"
  };*/
  /*var firebaseConfig = {
    apiKey: "AIzaSyABp-U5Rs7SJYOqGI7ARJYoN_ex1dMfDYQ",
    authDomain: "taxiimperialprovider.firebaseapp.com",
    databaseURL: "https://taxiimperialprovider.firebaseio.com",
    projectId: "taxiimperialprovider",
    storageBucket: "taxiimperialprovider.appspot.com",
    messagingSenderId: "228971760900",
    appId: "1:228971760900:web:8903c293f91f6186639451"
  };*/

 /* var firebaseConfig = {
    apiKey: "AIzaSyDhHTNlCDQTHkbr2fHF52ZEuappKhddBcU",
    authDomain: "pidelotaxi-f8733.firebaseapp.com",
    databaseURL: "https://pidelotaxi-f8733.firebaseio.com",
    projectId: "pidelotaxi-f8733",
    storageBucket: "pidelotaxi-f8733.appspot.com",
    messagingSenderId: "205951731548",
    appId: "1:205951731548:web:a8d564a564ea2f665b2399"
  }*/
  var firebaseConfig = {
	apiKey: "AIzaSyD5zOEg7CIiAGqNVLZQSQN0zS2AvPhYlRM",
    authDomain: "miappdetaxiscom.firebaseapp.com",
    databaseURL: "https://miappdetaxiscom.firebaseio.com",
    projectId: "miappdetaxiscom",
    storageBucket: "miappdetaxiscom.appspot.com",
    messagingSenderId: "73051765153",
    appId: "1:73051765153:web:aa64ed54066669f1e733e0",
    measurementId: "G-QT2BS1P5KZ"
  }

		firebase.initializeApp(firebaseConfig);

		var cars_count = 0;
		function initMap() {
			map = new google.maps.Map(document.getElementById('map'), {
				zoom: 16,
				center: new google.maps.LatLng(-11.108524, -77.6103295),
				mapTypeId: 'terrain'
			});
		}

		function clone(obj) {
			if (null == obj || "object" != typeof obj) return obj;
			var copy = obj.constructor();
			for (var attr in obj) {
				if (obj.hasOwnProperty(attr)) copy[attr] = obj[attr];
			}
			return copy;
		}

		function left_marker(data, idx) {
			var marker = new google.maps.Marker({
				map: map,
				position: new google.maps.LatLng(data.lat, data.lng)
			});
			marker.provider = left_providers[idx];
			marker.addListener('click', function(e) {
				selectProvider(this);
				scrollList(this);
			});
			if(left_markers[idx]) left_markers[idx].setMap(null);
			left_markers[idx] = marker;
			$('#'+idx).click = null;
			$('#'+idx).click(function() {
				selectProvider(marker);
			});
		}

		function AddCar(data, idx) {
			var infowindow = new google.maps.InfoWindow();
			var icon = { // car icon
				path: 'M29.395,0H17.636c-3.117,0-5.643,3.467-5.643,6.584v34.804c0,3.116,2.526,5.644,5.643,5.644h11.759   c3.116,0,5.644-2.527,5.644-5.644V6.584C35.037,3.467,32.511,0,29.395,0z M34.05,14.188v11.665l-2.729,0.351v-4.806L34.05,14.188z    M32.618,10.773c-1.016,3.9-2.219,8.51-2.219,8.51H16.631l-2.222-8.51C14.41,10.773,23.293,7.755,32.618,10.773z M15.741,21.713   v4.492l-2.73-0.349V14.502L15.741,21.713z M13.011,37.938V27.579l2.73,0.343v8.196L13.011,37.938z M14.568,40.882l2.218-3.336   h13.771l2.219,3.336H14.568z M31.321,35.805v-7.872l2.729-0.355v10.048L31.321,35.805',
				scale: 0.4,
				fillColor: "#427af4", //<-- Car Color, you can change it 
				fillOpacity: 1,
				strokeWeight: 1,
				anchor: new google.maps.Point(0, 5),
				rotation: data.val().bearing //<-- Car angle
			};
			var uluru = { lat: data.val().lat, lng: data.val().lng };
			var marker = new google.maps.Marker({
				position: uluru,
				icon: icon,
				map: map,
				title: data.val().nombreChofer
			});
			markers[data.key] = marker;
			marker.addListener('click', (function(data_in) {
				return function(e) {
					infowindow.setContent(data_in.nombreChofer+" - última conexión:"+" "+data_in.fechayhora+" "+ data_in.versionAndroid);
					infowindow.open(map, this);
					selectProvider(this);
				}
			}(data.val())));
			queue_of_list[idx] = clone(data.val());
		}
		var cars_Ref = firebase.database().ref();

		cars_Ref.on('child_added', function(para, idx) {
			var key = para.key;
			AddCar(para, key.substring(6));
		});

		cars_Ref.on('child_changed', function (data, idx) {
			var key = data.key;
			markers[key].setMap(null);
			AddCar(data, key.substring(6));
		});
		cars_Ref.on('child_removed', function (data) {
			markers[data.key].setMap(null);
		});

		function selectProvider(marker) {
			return showinfoWindow(marker);
		}

		function scrollList(marker){
			var item = $('.provider_list').find('li[id='+marker.provider.id+']');
			if(item) {
				var position = $(".provider_list").scrollTop() - $(".provider_list").offset().top + item.offset().top;
				$(".provider_list").animate({scrollTop : position}, 500); 
			}
		}

		function removeMarkers() {
		    for (var i in markers) {
		        if(typeof markers[i] !== 'undefined') markers[i].setMap(null);
		    }
		}

		function showinfoWindow(marker) {
			hideinfoWindow();
			var live_tarack = ((marker.provider.trips).length > 0) ? (marker.provider.trips[0].status == 'PICKEDUP') ? `<tr><td></td><td><a href="{{url('/track')}}/`+marker.provider.trips[0].id+`" target="_blank"><b>Live tracking</b></a></td></tr>` : `` : ``;
			var avatar = (marker.provider.avatar == null || marker.provider.avatar == "") ? "{{asset('main/avatar.jpg')}}" : "{{asset('/storage/')}}"+"/"+marker.provider.avatar ;
			var html = `<table>
				<tbody>
					<tr><td rowspan="5"><img src="`+avatar+`" width="auto" height="70"></td></tr>
					<tr><td>&nbsp;&nbsp;Name: </td><td><b>`+marker.provider.first_name+ ` ` +marker.provider.last_name+`</b></td></tr>
					<tr><td>&nbsp;&nbsp;Email: </td><td><b>`+marker.provider.email+`</b></td></tr>
					<tr><td>&nbsp;&nbsp;Mobile: </td><td><b>`+marker.provider.mobile+`</b></td></tr>` +live_tarack +
				`</tbody>
			</table>`;
			info = new google.maps.InfoWindow({
				content: html,
				maxWidth: 350
			});
			info.open(map, marker);
		}
		
		function hideinfoWindow() {
			if(typeof info != 'undefined' && info != null){
				info.close();
			}
		}
	</script>
@endsection