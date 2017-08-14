(function() {
  $(document).ready(function() {

    /* Define el destino del formulario dependiendo del botón apretado: Buscar o Exportar */
    $('#new_expediente').children('input[data-url]').on('click', function() {
      return $(this).parent().prop('action', this.dataset.url);
    });

    /* Muestra un cartel de confirmación si se van a exportar más de 1000 registros */
    $('#exportar').on('click', function() {
      if (this.dataset.count >= 1000) {
        if (!confirm("Se van a exportar " + this.dataset.count + " registros. ¿Desea continuar?")) {
          return false;
        }
      }
    });

    /* Elimina los titulares seleccionados */
    $("#remove-titular").click(function() {
      var titular, _i, _len, _ref, _results;
      _ref = $("#expedientes_titulares option:selected");
      _results = [];
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        titular = _ref[_i];
        _results.push(titular.remove());
      }
      return _results;
    });

    /* Ejecuta la peticion ajax */
    $("#titulares-modal form").submit(function() {
      //return $("#expediente_titular_ids option").prop('selected', true);
      $.ajax({
        type: $(this).attr('method'),
        url: $(this).attr('action'),
        data: $(this).serialize()
      })
      .done(function(data){
        //$("#titulares-modal form").on("ajax:success", function(e, data, status, xhr) {
          var titular, _i, _len, _ref, _ref1, _ref2, _results;
          $("#titulares-list tbody").empty();
          _ref = $(data);
          _results = [];
          for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            titular = _ref[_i];
            _results.push($("#titulares-list tbody").append($('<tr></tr>').append($("<td><input type='checkbox' value='" + titular.id + "' id='titular-" + titular.id + "'></td>")).append($('<td>' + titular.nombre + '</td>')).append($('<td>' + ((_ref2 = titular.dni) != null ? _ref2 : '') + '</td>')).append($('<td>' + ((_ref1 = titular.cuit) != null ? _ref1 : '') + '</td>'))));
          }
          return _results;
      //  });
    });
      return false;
    });

    /**
     * Al hacer click en el botón de agregar titulares en la ventanda modal, se agregan al listado
     * todos los titulares que han sido seleccionados mediante el checkbox
     */
    $("#titulares-modal-add").click(function() {
      var titular, _i, _len, _ref;
      _ref = $("#titulares-list input:checked");
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        titular = _ref[_i];
        $("#expedientes_titulares").append((function() {
          debugger;
        })(), $("<option value='" + titular.value + "'>" + $($(titular).parent().siblings()[0]).text() + "</option>"));
      }
      return $("#titulares-modal").modal('hide');
    });

    /* Selecciona todos los titulares del listado antes ejectuar el submit del formulario */
    return $("form").submit(function() {
      $("#expedientes_titulares option").prop('selected', true);
      return $("#expedientes_titulares option").prop('selected', true);
    });
  });
}).call(this);
