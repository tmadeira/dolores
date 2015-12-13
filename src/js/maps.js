"use strict";

var async = require("./async");
var gmapsKey = require("./config").gmapsKey;

var mapContainer;
var map = null;
var markers = [];

window.initMap = function() {
  map = new window.google.maps.Map(mapContainer, {
    center: {lat: -22.9209878, lng: -43.4785317},
    disableDefaultUI: true,
    scrollwheel: false,
    zoomControl: true,
    zoom: 11
  });

  markers.map(window.addMapMarker);
};

window.addMapMarker = function(data) {
  if (map === null) {
    markers.push(data);
  } else {
    var marker = new window.google.maps.Marker(data);
    var infowindow = new window.google.maps.InfoWindow({
      content: data.content
    });
    marker.setMap(map);
    marker.addListener("click", function() {
      infowindow.open(map, marker);
    });
  }
};

var setup = function() {
  var params = "region=br&language=pt-BR&key=" + gmapsKey + "&callback=initMap";
  mapContainer = document.getElementById("locaisMap");
  if (mapContainer !== null) {
    async.include(
      "google-maps",
      "https://maps.googleapis.com/maps/api/js?" + params
    );
  }
};

module.exports = {
  setup: setup
};
