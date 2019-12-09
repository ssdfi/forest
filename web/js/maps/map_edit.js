
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

    // FeatureGroup is to store editable layers
    var drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);

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
          drawnItems.addLayer(layer);
        return layer.bindPopup(buildPopup(feature.properties));
      }
    });


    /**
     * Agrega las capas de Google y GeoJson al mapa por defecto
     * El resto de las capas se manejan a través del selector de capas
     */
    map.addLayer(googleSatelital);

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

    /* Agrega el control para importar archivos */
    L.Control.FileLayerLoad.LABEL = '<span class="glyphicon glyphicon-folder-open"></span>';
    var control = L.Control.fileLayerLoad({
        // Allows you to use a customized version of L.geoJson.
        // For example if you are using the Proj4Leaflet leaflet plugin,
        // you can pass L.Proj.geoJson and load the files into the
        // L.Proj.GeoJson instead of the L.geoJson.
        layer: L.geoJson,
        // See http://leafletjs.com/reference.html#geojson-options
        layerOptions: {style: {color:'orange'},
        onEachFeature: function(feature, layer) {
            drawnItems.addLayer(layer);
        }},
        // Add to map after loading (default: true) ?
        addToMap: false,
        // File size limit in kb (default: 1024) ?
        fileSizeLimit: 1024,
        // Restrict accepted file formats (default: .geojson, .kml, and .gpx) ?
        formats: [
            '.geojson',
            '.kml'
        ]
    });
    control.addTo(map);

    /* Agrega controles de dibujo */
     var drawControl = new L.Control.Draw({
        draw: {
             circle: false,
             marker: false,
         },
        edit: {
             featureGroup: drawnItems
         }
     });
     map.addControl(drawControl);

     map.on(L.Draw.Event.CREATED, function (event) {
        var layer = event.layer;
        nuevo = layer.toGeoJSON();
        L.geoJson(nuevo, {
            style: function(feature) {
              return {
                color: "orange"
              };
            },
            onEachFeature: function(feature, layer) {
                layer.properties = {"id": 'Nuevo'};
                drawnItems.addLayer(layer);

            }
          });

    });

    map.on('draw:edited', function (e) {
        var layers = e.layers;
        layers.eachLayer(function (layer) {
            nuevo = layer.toGeoJSON();
            L.geoJson(nuevo, {
                style: function(feature) {
                  return {
                    color: "orange"
                  };
                },
                onEachFeature: function(feature, layer) {
                    drawnItems.addLayer(layer);
                }
            });
        });
    });

    map.on('draw:deleted', function (e) {
        var layers = e.layers;
        layers.eachLayer(function (layer) {
            $.ajax({
               url: '/aportes/'+layer.feature.properties.Id+'/eliminar',
               type: 'POST',
               dataType: "json",
               data: {
                   id:layer.feature.properties.Id,
               },
            }).done(function(data, textStatus, jqXHR) {
                if(data[0] == true){
                    alert("El polígono se ha eliminado correctamente");
                    window.location.href = "/aportes";
                }else{
                    alert("No tiene permisos para eliminar el poligono");
                }
            })
       });
   });

    $("#guardarCapa").on('click', function(){
        var geoms = '';
        $.each(drawnItems.getLayers(), function(index, val) {
            geoms = val.feature.geometry;
       });
       $.ajax({
            url: '/aportes/'+id+'/edit/geom',
            type: 'POST',
            dataType: "json",
            data: {
                id:id,
                geoms:JSON.stringify(geoms),
                tipo:1
            },
        }).done(function(data, textStatus, jqXHR) {
            if(data[0] == false){
                alert("No tiene permisos para editar el poligono");
            }else{
                alert("El polígono se ha guardado correctamente");
            }
          
        }).fail(function() {
          alert("Hubo un error al guardar el polígono");
        });
    });

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
