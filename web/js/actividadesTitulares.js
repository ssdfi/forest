  $(document).ready(function () {
    /**
     * Ejecuta la llamada AJAX para hacer la búsqueda de titulares y lista los resultados
     * con un radio button (La Actividad sólo puede tener un titular)
     */

    $("#titulares-modal form").submit(function() {
      $.ajax({
        type: $(this).attr('method'),
        url: $(this).attr('action'),
        data: $(this).serialize()
      })
      .done(function(data){
          var titular, _i, _len, _ref, _ref1, _ref2, _results;
          $("#titulares-list tbody").empty();
          _ref = $(data);
          _results = [];
          for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            titular = _ref[_i];
            _results.push($("#titulares-list tbody").append($('<tr></tr>').append(
              $("<td><input type='radio'  name=titulares-radios' value='" + titular.id + "' id='titular-" + titular.id + "'></td>"))
              .append($('<td>' + titular.nombre + '</td>')).append($('<td>' + ((_ref2 = titular.dni) != null ? _ref2 : '')+ '</td>'))
              .append($('<td>' + ((_ref1 = titular.cuit) != null ? _ref1 : '') + '</td>'))));
          }
          return _results;
    });
      return false;
    });


    /**
     * Al hacer click en el botón de seleccionar titular en la ventanda modal, se define como
     * titular de la plantación el seleccionado mediante el radio button
     */
    $("#titulares-modal-select").click(function() {
      var titular, _i, _len, _ref;
      _ref = $("#titulares-list input:checked");
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        titular = _ref[_i];
        $("#appbundle_actividadestitulares_plantacion_titular_id").val(titular.value);
        $("#appbundle_actividadestitulares_titular").val($($(titular).parent().siblings()[0]).text());
      }
      return $("#titulares-modal").modal('hide');
    });

    /* Elimina el titular seleccionado */
    $("#remove-titular").click(function() {
      $("#appbundle_actividadestitulares_titular").val('');
      return $("#appbundle_actividadestitulares_titular").val('');
    });


    /**
     * Ejecuta la llamada AJAX para hacer la búsqueda de especies y lista los resultados
     * con un checkbox
     */
    $("#especies-modal form").submit(function(){
      $.ajax({
        type: $(this).attr('method'),
        url: $(this).attr('action'),
        data: $(this).serialize()
      })
      .done(function(data){
        var especie, _i, _len, _ref, _results;
        $("#especies-list tbody").empty();
        _ref = $(data);
        _results = [];
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
          especie = _ref[_i];
          _results.push($("#especies-list tbody").append($('<tr></tr>').append($("<td><input type='radio' value='" + especie.id + "' id='especie-" + especie.id + "'></td>")).append($('<td>' + especie.codigoSp
          + '</td>')).append($('<td>' + especie.nombreCientifico + '</td>')).append($('<td>' + especie.nombreComun
          + '</td>'))));
        }
        return _results;
      });
      return false;
    });

    /**
     * Al hacer click en el botón de seleccionar especie en la ventanda modal, se define como
     * titular de la plantación el seleccionado mediante el radio button
     */
    $("#especies-modal-add").click(function() {
      var titular, _i, _len, _ref;
      _ref = $("#especies-list input:checked");
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        titular = _ref[_i];
        $("#appbundle_actividadestitulares_especie_id").val(titular.value);
        $("#appbundle_actividadestitulares_especie").val($($(titular).parent().siblings()[0]).text() + '-' + $($(titular).parent().siblings()[1]).text());
      }
      return $("#especies-modal").modal('hide');
    });
});
