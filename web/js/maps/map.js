
/* Construye el popup a mostrarse al hacer click en una plantación */

(function() {
  var buildPopup;

  buildPopup = function(properties) {
    var list, property, value;
    list = "<div>";
    for (property in properties) {
      value = properties[property];
      list += "<div><strong>" + property + ": </strong>" + value + "</div>";
    }
    return list += "</div>";
  };

  $(document).ready(function() {

    /* Define el objeto map y el div que lo contiene */
    var geoJson, googleSatelital, ignBase, ignSatelital, map, osm, osmMini, exoBase;
    map = L.map('map');

    var argenmapUrl = 'https://wms.ign.gob.ar/geoserver/gwc/service/tms/1.0.0/capabaseargenmap@EPSG%3A3857@png/{z}/{x}/{y}.png'; //Mapa base de IGN
  	var argenmapBase = new L.TileLayer(argenmapUrl, {minZoom: 4, tms: true, attribution: '&copy; <a href="www.ign.gob.ar/">Instituto Geográfico Nacional</a>'});

    /* Capa WMS base de información del IGN */
    eoxBase = L.tileLayer.wms("https://tiles.maps.eox.at/wms", {
      layers: 's2cloudless_3857',
      format: 'image/jpeg',
      attribution: '&copy; <a href="https://s2maps.eu/">Sentinel-2 cloudless</a> by <a href="https://eox.at/">EOX IT Services GmbH</a>',
      transparent: true
    });

    /* Capa base de OpenStreetMap */
    osm = L.tileLayer("http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    });
    osmMini = L.tileLayer("http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png");

    /* Capa de imagen satelital de Google */
    googleSatelital = new L.Google('SATELLITE');
    /* Capa vectorial GeoJSON de las plantaciones */
    geoJson = L.geoJson(plantaciones, {
      style: function(feature) {
        return {
          color: "orange"
        };
      },
      onEachFeature: function(feature, layer) {
        return layer.bindPopup(buildPopup(feature.properties));
      }
    });


    /**
     * Agrega las capas de Google y GeoJson al mapa por defecto
     * El resto de las capas se manejan a través del selector de capas
     */
    map.addLayer(googleSatelital);
    map.addLayer(geoJson);

    /**
     * Define el extent del mapa para que abarque todas las plantaciones
     * Si no hay plantaciones centra el mapa en un punto determinado
     */
    if (plantaciones) {
      map.fitBounds(geoJson.getBounds());
    } else {
      map.setView([-36, -62], 4);
    }

    /* Agrega todas las capas al selector de capas del mapa */
    L.control.layers({
      "OpenStreetMap": osm,
      "Google Satelital": googleSatelital,
      "IGN": argenmapBase,
      "EOX Base": eoxBase,
    }, {
      "Plantaciones": geoJson
    }).addTo(map);

    /* Agrega otros controles al mapa */
    L.control.zoomBox({
      className: "glyphicon glyphicon-zoom-in"
    }).addTo(map);
    new L.Control.MiniMap(osmMini, {
      position: 'bottomleft',
      zoomLevelOffset: -7
    }).addTo(map);
    return L.control.scale({
      imperial: false
    }).addTo(map);
  });

}).call(this);
