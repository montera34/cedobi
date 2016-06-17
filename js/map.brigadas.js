jQuery(document).ready(function($){

	var espana = new google.maps.LatLng(39.1079026,-1.7847492);
var opciones = {
	zoom : 10,
	center: espana,
	mapTypeId: google.maps.MapTypeId.ROADMAP
};
var div = document.getElementById('mapa');              
var map = new google.maps.Map(div, opciones);

//Array de Tipos Visibles en el mapa
var marcadores = [],
visibles = [];

//Array de iconos para cada tipo de punto        
var vIconos =  ["icono0.png","icono1.png"];

//Globo de informacion en cada punto
var infowindow = new google.maps.InfoWindow();
google.maps.event.addListener(map, 'click', function() {
	infowindow.close();
});

//Insertar puntos en mapa
var insertar_marcador = function (data){
	$.each(data, function(i, obj){
		var marcador = new google.maps.Marker({
			title: obj.name,
			position : new google.maps.LatLng(obj.coords.lat,obj.coords.lng),
			map : map,
			tipo : obj.type,
			icon : '/images/' + vIconos[obj.type]
		});
		marcadores.push(marcador);

		//Se muestra el marcador si el tipo esta marcado en visibles
		if(visibles.indexOf( obj.type) ==  -1){
			// $("buscartipo" +obj.type ).prop("checked","false");
		}
		//marcadores[i].setVisible(visibles.indexOf(marcadores[i].tipo) !== -1);

		//Globo de informacion para cada punto

		google.maps.event.addListener(marcador, 'click', (function(marcador, i) {return function() {
			return function() {
				infowindow.setContent(obj.content);
				infowindow.open(map, marcador);
			}
		}})(marcador, i)
		);
	});
};

var ocultar_marcadores = function(){
for (var i = 0, length = marcadores.length; i < length; i++){
marcadores[i].setVisible(visibles.indexOf(marcadores[i].tipo) !== -1);
}
};
$.getJSON('/elementos.json',insertar_marcador);

$('input.control').each(function(){
var $this = $(this), valor = $this.val();
if ($this.is(':checked')){
// Si está marcado tendremos que añadirla a nuestra lista de visibles
visibles.push(valor);
}
else {
// Nos tocará borrarlo

visibles.splice(visibles.indexOf(valor), 1);
}
ocultar_marcadores();

});                

$('input.control').on('change',function(e){
var $this = $(this), valor = $this.val();

if ($this.is(':checked')){
// Si está marcado tendremos que añadirla a nuestra lista de visibles

visibles.push(valor);
}
else {
// Nos tocará borrarlo
visibles.splice(visibles.indexOf(valor), 1);
}
ocultar_marcadores();
});



function buscarMunicipio(valor){
switch (valor){
case "1":
map.setCenter(new google.maps.LatLng(39.1079026,-1.7847492) );
map.setZoom(9);
break;
case "2":
map.setCenter(new google.maps.LatLng(38.995395,-1.859661) );
map.setZoom(14);
break;
case "3":
map.setCenter(new google.maps.LatLng(38.8430262,-1.2515282) );
map.setZoom(14);
break;
case "4":
map.setCenter(new google.maps.LatLng(39.0378271,-2.2666284) );
map.setZoom(14);
break;
case "5":
map.setCenter(new google.maps.LatLng(39.286761,-1.476649) );
map.setZoom(14);
break;
case "6":
map.setCenter(new google.maps.LatLng(38.9203559,-1.7290426) );
map.setZoom(14);
break;
case "7":
map.setCenter(new google.maps.LatLng(39.2682611,-1.5544661) );
map.setZoom(14);
break;
case "8":
map.setCenter(new google.maps.LatLng(39.2060328,-2.1658165) );
map.setZoom(14);
break;
case "9":
map.setCenter(new google.maps.LatLng(39.2374102,-1.8097795) );
map.setZoom(14);
break;
case "10":
map.setCenter(new google.maps.LatLng(39.2119201,-1.7294122) );
map.setZoom(14);
break;
case "11":
map.setCenter(new google.maps.LatLng(38.994710, -1.774082) );
map.setZoom(14);
break;
case "12":
map.setCenter(new google.maps.LatLng(39.2632734,-1.917008) );
map.setZoom(14);
break;
case "13":
map.setCenter(new google.maps.LatLng(39.1127574,-1.746832) );
map.setZoom(14);
break;
case "14":
map.setCenter(new google.maps.LatLng(39.3422187,-1.9345367) );
map.setZoom(14);
break;
case "15":
map.setCenter(new google.maps.LatLng(39.4400283,-1.964072) );
map.setZoom(14);
break;    
}
}

});
