
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
    var geoJson,geoJsonAporte, googleSatelital, ignBase, ignSatelital, map, osm, osmMini, exoBase;
    map = L.map('map');

    var argenmapUrl = 'https://wms.ign.gob.ar/geoserver/gwc/service/tms/1.0.0/capabaseargenmap@EPSG%3A3857@png/{z}/{x}/{y}.png'; //Mapa base de IGN
  	var argenmapBase = new L.TileLayer(argenmapUrl, {minZoom: 4, tms: true});

    /* Capa WMS base de información del IGN */
    eoxBase = L.tileLayer.wms("https://tiles.maps.eox.at/wms", {
      layers: 's2cloudless_3857',
      format: 'image/jpeg',
      attribution: 'EOX',
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

    geoJsonAporte = L.geoJson(plantaciones_aporte, {
      style: function(feature) {
        return {
          color: "blue"
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
    map.addLayer(geoJsonAporte);

    /**
     * Define el extent del mapa para que abarque todas las plantaciones
     * Si no hay plantaciones centra el mapa en un punto determinado
     */
    if (plantaciones) {
      map.fitBounds([geoJson.getBounds(),geoJsonAporte.getBounds()]);
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
      "Plantaciones": geoJson,
      "Plantaciones Aporte": geoJsonAporte
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
