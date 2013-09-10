$( document ).ready( function() {
	if( $.fn.flipClock ) {
		$( '.countdown' ).flipClock({
			until: new Date(2013, 4, 17)
		});
	}
	if ($('#map').length) {
		var osmUrl='http://otile1.mqcdn.com/tiles/1.0.0/osm/{z}/{x}/{y}.png';
		var osmAttrib='Map data &copy; <a href="http://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Tiles Courtesy of <a href="http://www.mapquest.com/" target="_blank">MapQuest</a> <img src="http://developer.mapquest.com/content/osm/mq_logo.png">';
		var osm = new L.TileLayer(osmUrl, {minZoom: 1, maxZoom: 18, attribution: osmAttrib});
	
		var url = document.URL + '?json';
		if(document.URL.indexOf('?') !== -1) {
			url = document.URL + '&json';
		}
		$.ajax({
			url: url,
			success: function(data) {
				data = $.parseJSON(data);
				var map = new L.Map('map');

				map.setView(new L.LatLng(data['cen_lat'], data['cen_lon']), 10);
				map.addLayer(osm);
				if(data['min_lat'] && data['min_lat'] != data['max_lat']) {
					var southWest = new L.LatLng(data['min_lat'],data['min_lon']);
					var northEast = new L.LatLng(data['max_lat'],data['max_lon']);
					var bounds = new L.LatLngBounds(southWest, northEast);
					map.fitBounds(bounds);
				}
				var icons = new Array();
				icons['0'] = L.icon({iconUrl: '/css/img/icons/map/pin_orange.png',		iconSize: [14, 25], iconAnchor: [6, 25], popupAnchor: [-2, -30]});
				icons['1'] = L.icon({iconUrl: '/css/img/icons/map/pin_light_blue.png',	iconSize: [14, 25], iconAnchor: [6, 25], popupAnchor: [-2, -30]});
				icons['2'] = L.icon({iconUrl: '/css/img/icons/map/pin_green.png',		iconSize: [14, 25], iconAnchor: [6, 25], popupAnchor: [-2, -30]});
				icons['3'] = L.icon({iconUrl: '/css/img/icons/map/pin_blue.png',		iconSize: [14, 25], iconAnchor: [6, 25], popupAnchor: [-2, -30]});
				icons['4'] = L.icon({iconUrl: '/css/img/icons/map/pin_red.png',			iconSize: [14, 25], iconAnchor: [6, 25], popupAnchor: [-2, -30]});
				$.each(data['markers'], function(key, val){
					var marker = new L.Marker(new L.LatLng(val.lat,val.lon), {icon: icons[val.level]});
					marker.bindPopup(val.name);
					map.addLayer(marker);
				});
				var legend = L.Control.extend({
					options	: { position: 'topright' },
					onAdd	: function(map) {
						var container = L.DomUtil.create('div', 'map-legend');
						container.innerHTML += data['legend'];
						return container;
					}
				});
				map.addControl(new legend());
				if(data['polygon']){
					var geojson = L.geoJson(data['polygon'], { style : polyline_style } ).addTo(map);
				}
			}
		});
	}
	if( $.fn.layerSlider ) {
		$( '.layerslider' ).each(function() {
			$( this ).layerSlider( $.extend( true, {
				responsive: true, 
				skin: 'youxi', 
				skinsPath: 'plugins/layerslider/skins/', 
				responsiveUnder: 1024, 
				sublayerContainer: 1024
			}, $( this ).data() ) );
		});
	}
});


$( document ).ready(function() {
	(function() {
		var guide = $( '<li class="nav-guide"></li>' );
		var active = $( '.navigation > ul' ).find( ' > li.active' ).first();
		function posGuide( el ) {
			if( el.length ) {
				var pos = el.position();
				guide.css({
					'left': pos.left, 
					'top': pos.top + $( el ).outerHeight() - 1, 
					'width': $( el ).outerWidth()
				});
			}
		}
		$( '.navigation > ul' ).prepend( guide ).on( 'mouseenter.snaky', ' > li', function( ) {
			posGuide( $( this ) );
		}).on( 'mouseleave.snaky', function() {
			posGuide( active );
		});
		$( '.navigation > ul' ).on( 'mouseover.snaky', function( e ) {
			guide.addClass( 'animate' );
			$( this ).off( 'mouseover.snaky' );
		});
		posGuide( active );
		$( window ).on( 'resize.snaky', function() {
			posGuide( active );
		});
	})();
});

function polyline_style(feature) {
	return {
		weight: 2,
		opacity: 1,
		color: get_random_color(),
		dashArray: '5',
		fillOpacity: 0.1
	};
}

function get_random_color() {
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.round(Math.random() * 15)];
    }
    return color;
}

if($('#google_graph').length) {
	google.load("visualization", "1", {'packages':["corechart"]});
	google.setOnLoadCallback(draw_chart_js);
}

function draw_chart_js() {
	var raw_data = jQuery.parseJSON($('#google_graph_data').val());
	var my_data = [];
	my_data.push(['Grade', 'Students']);
	$.each(raw_data, function(key, val){
		my_data.push([key,parseInt(val)]);
	});
	var data = google.visualization.arrayToDataTable(my_data);
	var options = {
		chartArea:{left:50,top:20,width:700,height:"75%"},
		title: 'Number of Students by Grade'
	};
	var chart = new google.visualization.PieChart(document.getElementById('google_graph'));
	chart.draw(data, options);
}