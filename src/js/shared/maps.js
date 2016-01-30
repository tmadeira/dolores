"use strict";

var async = require("./async");

var gmapsKey = window.doloresConfig.gmapsKey;

var mapContainer;
var map = null;
var markers = [];
var clickCallback = null;
var contents = {};

window.initMap = function() {
  var infoWindow = new window.google.maps.InfoWindow();
  clickCallback = function() {
    infoWindow.setContent(contents[this.getTitle()]);
    infoWindow.open(map, this);
  };

  map = new window.google.maps.Map(mapContainer, {
    center: {lat: -22.9209878, lng: -43.4785317},
    disableDefaultUI: true,
    scrollwheel: false,
    zoomControl: true,
    zoom: 11
  });
  map.addListener("click", function() {
    infoWindow.close();
  });
  markers.map(window.addMapMarker);
};

window.addMapMarker = function(data) {
  if (map === null) {
    markers.push(data);
  } else {
    var marker = new window.google.maps.Marker(data);
    marker.setMap(map);
    marker.addListener("click", clickCallback);
    contents[data.title] = data.content;
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
