
/* Construye el popup a mostrarse al hacer click en una plantación */

(function() {

var plantacionesNombres = new Array();
var ids = new Object();

$.each(plantacionesArray, function(index, feature) {
    
    var nombre = feature.properties.Provincia +' '+ feature.properties.Departamento+' '+feature.properties.Titular+'( '+feature.properties.Id+')'
    plantacionesNombres.push(nombre);
    ids[nombre] = feature.properties.Id;
});

var places = $('#places');

$(document).ready(function() {

    var stylelayer = {
        defecto: {
            color: "orange",
        },
        activas: {
            color: "red",
        },
        reset: {
            color: "orange",
        },
        highlight: {
            weight: 5,
            color: '#0D8BE7',
            dashArray: '',
            fillOpacity: 0.7
        },
        selected: {
            color: "blue",
            opacity: 0.3,
            weight: 0.5
        }
    }

    places.bind('typeahead:select', function(ev, suggestion) {
      redraw(suggestion);
    });

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
    var items = new L.FeatureGroup();
    map.addLayer(items);

    var drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);
    
    /* Capa de imagen satelital de Google */
    googleSatelital = new L.Google('SATELLITE');
    /* Capa vectorial GeoJSON de las plantaciones */
    geoJson = L.geoJson(plantacionesArray, {
      style: stylelayer.defecto,
      onEachFeature: function(feature, layer) {
          items.addLayer(layer);
          layer.on({
              mouseover: highlightFeature,
              mouseout: resetHighlight,
              click: zoomToFeature
          });
      }
    });

    plantacionesActivas = L.geoJson(plantacionesActivasArray, {
        style: stylelayer.activas,
        onEachFeature: function(feature, layer) {
            layer.on({
                mouseover: highlightFeature,
                mouseout: resetHighlightActivas,
                click: zoomToFeature
            });
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
    if (plantacionesArray.length > 0) {
        map.fitBounds(geoJson.getBounds());
    } else {
        map.setView([-36, -62], 4);
    }


    if ( plantacionesActivasArray.length > 0){
        map.fitBounds(plantacionesActivas.getBounds());
    }
    

    /* Agrega todas las capas al selector de capas del mapa */
    var capasControl = L.control.layers({
      "OpenStreetMap": osm,
      "Google Satelital": googleSatelital,
      "IGN": argenmapBase,
      "EOX Base": eoxBase,
    },
    {
        "Plantaciones" : plantacionesActivas
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
            $.ajax({
                url: '/aportes/crear',
                type: 'POST',
                dataType: "json",
                data: {
                    geoms:JSON.stringify(feature.geometry)
                },
            }).done(function(data, textStatus, jqXHR){
                feature.id = data.id;
                feature.properties = {"Id" : data.id, "Area": data.area};                       
            })
            layer.on({
                mouseover: highlightFeature,
                mouseout: resetHighlight,
                click: zoomToFeature
                  //dblclick : selectFeature
            });
            items.addLayer(layer);
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

                layer.on({
                    mouseover: highlightFeature,
                    mouseout: resetHighlight,
                    click: zoomToFeature
                });

                idProv = $('#provincia').val();
                idDepto = $('#departamento').val();
                
                $.ajax({
                    url: '/aportes/crear',
                    type: 'POST',
                    dataType: "json",
                    data: {
                        geoms:JSON.stringify(feature.geometry),
                        idProv:idProv,
                        idDepto:idDepto
                    },
                }).done(function(data, textStatus, jqXHR){
                    feature.id = data.id;
                    feature.properties = {"Id" : data.id, "Area": data.properties.Area, "Tipo":data.properties.Tipo};     
                    console.log(data);
                    console.log(feature);
                })
                items.addLayer(layer);

            }
          });

    });
    
    map.on('draw:edited', function (e) {
        var layers = e.layers;
        layers.eachLayer(function (layer) {
            
            L.geoJson(layer.toGeoJSON(), {
                onEachFeature: function(feature, layer) {
                    $.ajax({
                        url: '/aportes/'+feature.properties.Id+'/edit/geom',
                        type: 'POST',
                        dataType: "json",
                        data: {
                            id:feature.properties.Id,
                            geoms:JSON.stringify(feature.geometry),
                            tipo:feature.properties.Tipo
                        },
                    }).done(function(data, textStatus, jqXHR){
                        feature.properties.Area = data.Area;                       
                    })
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
            })
        });
    });


    function selectTypeaheadFeature(layer) {
      var layer = layer;
      var feature = layer.feature;

      if (checkExistsLayers(feature)) {
          removerlayers(feature, setStyleLayer, layer, stylelayer.defecto)

          removeBounds(layer)

      } else {
          addLayers(feature, setStyleLayer, layer, stylelayer.highlight)
          addBounds(layer)
      }
      map.fitBounds(arrayBounds.length != 0 ? arrayBounds : initbounds)
      detailsselected.update(featuresSelected)

  }

    var arrayBounds = [];
    function redraw(b) {
        geoJson.eachLayer(function(layer) {
            console.log(b);
            if (layer.feature.properties.Id == ids[b]) {
                selectTypeaheadFeature(layer)
            }
        })
    }

    function highlightFeature(e) {
        var layer = e.target;
        layer.setStyle(stylelayer.highlight);
        info.update(layer.feature.properties);
    }


    function resetHighlight(e) {
        var layer = e.target;
        var feature = e.target.feature;
        if (checkExistsLayers(feature)) {
            setStyleLayer(layer, stylelayer.highlight)
        } else {
            setStyleLayer(layer, stylelayer.defecto)
        }
    }

    function resetHighlightActivas(e) {
        var layer = e.target;
        var feature = e.target.feature;
        if (checkExistsLayers(feature)) {
            setStyleLayer(layer, stylelayer.highlight)
        } else {
            setStyleLayer(layer, stylelayer.activas)
        }
    }

    var featuresSelected = []
    function zoomToFeature(e) {

        var layer = e.target;
        var feature = e.target.feature;

        if (checkExistsLayers(feature)) {
            removerlayers(feature, setStyleLayer, layer, stylelayer.defecto)
            removeBounds(layer);
            drawnItems.removeLayer(layer);
            items.addLayer(layer);
        } else {
            addLayers(feature, setStyleLayer, layer, stylelayer.highlight)
            addBounds(layer);
            items.removeLayer(layer);
            drawnItems.addLayer(layer);
        }

        map.fitBounds(arrayBounds);
        detailsselected.update(featuresSelected);
        
    }

    function addBounds(layer) {
        arrayBounds.push(layer.getBounds())
    }

    function removeBounds(layer) {      
        arrayBounds = arrayBounds.filter(bounds => bounds != layer.getBounds())        
    }

    function setStyleLayer(layer, styleSelected) {
        layer.setStyle(styleSelected)
    }

    function removerlayers(feature, callback) {
        featuresSelected = featuresSelected.filter(obj => obj.id != feature.properties.Id)
        callback(arguments[2], arguments[3])
    }

    function addLayers(feature, callback) {
        featuresSelected.push({
            id: feature.properties.Id,
            feature: feature
        })
        callback(arguments[2], arguments[3])
    }

    function checkExistsLayers(feature) {
        var result = false
        for (var i = 0; i < featuresSelected.length; i++) {
            if (featuresSelected[i].id == feature.properties.Id) {
                result = true;
                break;
            }
        };
        return result
    }

    var detailshow = function() {
      var result = '';
      var idsAportes = [];
      var idsActivas = [];
      for (var i = 0; i < featuresSelected.length; i++) {

          var properties = featuresSelected[i].feature.properties;
          if (properties.Tipo == 1) {
            idsAportes.push(featuresSelected[i].feature.properties.Id);
          }else{
            idsActivas.push(featuresSelected[i].feature.properties.Id);
          }
          result +=
              `
          Area:${properties.Area}<br>
          Especie:${properties.Genero}<br>
          Id:${properties.Id}`

          if (properties.Tipo == 1) {
            result += `<a class="verAporte" id = ${properties.Id}>Detalle</a>
            <a class="editarAporteUnico" href="#" id ="${properties.Id}">Editar</a>
            <hr>`;
          }else{
            result += `<a class="verActivo" id = ${properties.Id}>Detalle</a>
            <a class="editarActivoUnico" href="#" id ="${properties.Id}">Editar</a>
            <hr>`;
          }
          
      }

      var idsString = idsAportes.join(",");
      if (idsString != '') {
        result +=
          `
        <a class="editarSeleccion" href="#" ids ="${idsString}">Editar Aportes seleccionados</a>
        <hr>`;
      }

      var idsString = idsActivas.join(",");
      if (idsString != '') {
        result +=
          `
        <a class="editarSeleccionP" href="#" ids ="${idsString}">Editar Plantaciones seleccionadas</a>
        <hr>`;
      }
     
      return {
          result: result
      };
    }


    /*show info layers*/
    var info = L.control({
        position: 'bottomleft'
    });

    info.onAdd = function(map) {
        this._div = L.DomUtil.create('div', 'info');
        this.update();
        return this._div;
    };

    info.update = function(properties) {
        this._div.innerHTML =

            '<h4>Propiedades</h4>' + (properties ?
                `
                    Id:${properties.Id}<br>
                    Area:${properties.Area}<br>
                    Especie:${properties.Genero}
                    
                        ` : 'Mueva el cursor sobre un aporte');
    };

    info.addTo(map);   

    /* Agrega otros controles al mapa */
    var detailsselected = L.control();
    detailsselected.onAdd = function(map) {
        this._div = L.DomUtil.create('div', 'info scroler');
        this.update();
        return this._div;
    };

    detailsselected.update = function(arrayselected) {
        var details = detailshow()
        this._div.innerHTML = details.result;
    };

    detailsselected.addTo(map);


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

    var substringMatcher = function(strs) {
      return function findMatches(q, cb) {
        var matches, substringRegex;

        // an array that will be populated with substring matches
        matches = [];

        // regex used to determine if a string contains the substring `q`
        substrRegex = new RegExp(q, 'i');

        // iterate through the pool of strings and for any string that
        // contains the substring `q`, add it to the `matches` array
        $.each(strs, function(i, str) {
          if (substrRegex.test(str)) {
            matches.push(str);
          }
        });

        cb(matches);
      };
    };

    /* area de busqueda */
    $('#places').typeahead(
    {
        hint: true,
        highlight: true,
        minLength: 1
    },
    {
        source: substringMatcher(plantacionesNombres),
    });
    

$(document).on("click", ".verAporte", function(){
    id = $(this).attr('id');
    $.ajax({
        url: '/aportes/'+id+'/detalle',
        type: 'GET',
        dataType: "html"
    }).done(function(data, textStatus, jqXHR){
        $('.modalVerBody').html(data);
        $('#modalVer').modal('show');
    })
});

$(document).on("click", ".verActivo", function(){
    id = $(this).attr('id');
    $.ajax({
        url: '/plantaciones/'+id+'/detalle',
        type: 'GET',
        dataType: "html"
    }).done(function(data, textStatus, jqXHR){
        $('.modalVerBody').html(data);
        $('#modalVer').modal('show');
    })
});

$(document).on("click", ".editarAporteUnico", function(){
    id = $(this).attr('id');
    $.ajax({
        url: '/aportes/'+id+'/editar',
        type: 'GET',
        dataType: "html"
    }).done(function(data, textStatus, jqXHR){
        $('.modalEditarBody').html(data);
        $('#modalEditar').modal({
            backdrop: 'static',
            keyboard: false
        });
        $('#modalEditar').modal('show');
    })
});

$(document).on("click", ".editarActivoUnico", function(){
    id = $(this).attr('id');
    $.ajax({
        url: '/plantaciones/editarActiva',
        type: 'POST',
        dataType: "html",
        data: {plantacion:id}
    }).done(function(data, textStatus, jqXHR){
        $('.modalEditarBody').html(data);
        $('#modalEditar').modal({
            backdrop: 'static',
            keyboard: false
        });
        $('#modalEditar').modal('show');
    })
});

$(document).on("click", ".editarSeleccion", function(){
    ids = $(this).attr('ids');
    $.ajax({
        url: '/aportes/editar/seleccion',
        type: 'POST',
        dataType: "html",
        data: {plantacion:ids}
    }).done(function(data, textStatus, jqXHR){
        
        $('.modalEditarBody').html(data);
        $('#modalEditar').modal({
            backdrop: 'static',
            keyboard: false
        });
        $('#modalEditar').modal('show');      
    })
});

$(document).on("click", ".editarSeleccionP", function(){
    ids = $(this).attr('ids');
    $.ajax({
        url: '/plantaciones/editarActiva',
        type: 'POST',
        dataType: "html",
        data: {plantacion:ids}
    }).done(function(data, textStatus, jqXHR){
        
        $('.modalEditarBody').html(data);
        $('#modalEditar').modal({
            backdrop: 'static',
            keyboard: false
        });
        $('#modalEditar').modal('show');      
    })
});

$(document).on("change", "#provincia", function(){
    id = $(this).val();
    cambiarProv(id);
});

if (depto != '') {
    cambiarProv(prov);
}


function cambiarProv(id) {
    $.ajax({
        url: '/aportes/getPartidos/'+id,
        type: 'GET',
        dataType: "json"
    }).done(function(data, textStatus, jqXHR){
        $('#departamento').html('');
        $.each( data, function( key, value ) {  
            if (value.id == depto) {
                $('#departamento').append('<option value="'+value.id+'" selected>'+value.nombre+'</option>')
            }else{
                $('#departamento').append('<option value="'+value.id+'">'+value.nombre+'</option>')
            }
        });
    })
}

}).call(this);

