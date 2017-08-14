(function() {
  $(document).ready(function() {
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
        $("#plantaciones_plantacion_titular_id").val(titular.value);
        $("#plantaciones_titular").val($($(titular).parent().siblings()[0]).text());
      }
      return $("#titulares-modal").modal('hide');
    });

    /* Elimina el titular seleccionado */
    $("#remove-titular").click(function() {
      $("#plantaciones_titular").val('');
      return $("#plantaciones_titular").val('');
    });

    /* Define el destino del formulario dependiendo del botón apretado: Buscar o Editar */
    $('#new_plantacion').children('input[data-url]').on('click', function() {
      return $(this).parent().prop('action', this.dataset.url);
    });

    /**
     * Ejecuta la llamada AJAX para hacer la búsqueda de titulares y lista los resultados
     * con un radio button (La plantación sólo puede tener un titular)
     */
    $("#titulares-modal form").on("ajax:success", function(e, data, status, xhr) {
      var titular, _i, _len, _ref, _ref1, _ref2, _results;
      $("#titulares-list tbody").empty();
      _ref = $(data);
      _results = [];
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        titular = _ref[_i];
        _results.push($("#titulares-list tbody").append($('<tr></tr>').append($("<td><input type='radio' name=titulares-radios' value='" + titular.id + "' id='titular-" + titular.id + "'></td>")).append($
('<td>' + titular.nombre + '</td>')).append($('<td>' + ((_ref2 = titular.dni) != null ? _ref2 : '')
+ '</td>')).append($('<td>' + ((_ref1 = titular.cuit) != null ? _ref1 : '') + '</td>'))));
      }
      return _results;
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
        $("#plantacion_titular_id").val(titular.value);
        $("#plantacion_titular").val($($(titular).parent().siblings()[0]).text());
      }
      return $("#titulares-modal").modal('hide');
    });

    /* Elimina el titular seleccionado */
    $("#remove-titular").click(function() {
      $("#plantacion_titular_id").val('');
      return $("#plantacion_titular").val('');
    });

    /* Elimina las especies seleccionadas */
    $("#remove-especie").click(function() {
      var especie, _i, _len, _ref, _results;
      _ref = $("#plantaciones_especie option:selected");
      _results = [];
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        especie = _ref[_i];
        _results.push(especie.remove());
      }
      return _results;
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
          _results.push($("#especies-list tbody").append($('<tr></tr>').append($("<td><input type='checkbox' value='" + especie.id + "' id='especie-" + especie.id + "'></td>")).append($('<td>' + especie.codigoSp
          + '</td>')).append($('<td>' + especie.nombreCientifico + '</td>')).append($('<td>' + especie.nombreComun
          + '</td>'))));
        }
        return _results;
      });
      return false;
    });

    /**
     * Al hacer click en el botón de agregar especies en la ventanda modal, se agregan al listado
     * todos las especies que han sido seleccionados mediante el checkbox
     */
    $("#especies-modal-add").click(function() {
      var especie, _i, _len, _ref;
      _ref = $("#especies-list input:checked");
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        especie = _ref[_i];
        $("#plantaciones_especie").append($("<option value='" + especie.value + "'>" + $($(especie
).parent().siblings()[1]).text() + "</option>"));
      }
      return $("#especies-modal").modal('hide');
    });

    /* Busca y carga los departamentos pertenecientes a la provincia seleccionada */
    $("#plantaciones_provincia").change(function() {
      $("#plantaciones_departamento").prop('disabled', true);
      $("#plantaciones_departamento").empty();
      $("#plantaciones_departamento").append($("<option />"));
      if ($("#plantaciones_provincia").val()) {
        return $.ajax({
          url: "/provincias/" + $("#plantaciones_provincia").val() + "/departamentos.json"
        }).done(function(data) {
          var departamento, _i, _len, _ref;
          _ref = $(data);
          for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            departamento = _ref[_i];
            $("#plantaciones_departamento").append($("<option />").val(departamento.id).text(departamento
.nombre));
          }
          return $("#plantaciones_departamento").prop('disabled', false);
        });
      } else {
        return $("#plantaciones_departamento").prop('disabled', false);
      }
    });

    /* Selecciona todos las especies del listado antes ejectuar el submit del formulario */

    /* Convertir el listado de IDs del textarea de plantaciones en un array antes de ejectuar el submit
 del formulario */
    $("form").submit(function(e) {
      $("#plantaciones_especie option").prop('selected', true);
      return $("#plantaciones_historico option").prop('selected', true);
    });

    /* Activa/Descativa el campo asociado al label */
    $('.form-group[data-disabler] label').css('cursor', 'pointer');
    $('.form-group[data-disabler] label').css('text-decoration', 'underline');
    $('.form-group[data-disabler] label').click(function(event) {
      $("#" + ($(this).prop('for'))).bootstrapSwitch('toggleDisabled');
      $("#" + ($(this).prop('for'))).prop('disabled', function(i, value) {
        return !value;
      });
      return event.stopPropagation();
    });

    /**
     * Al hacer click en el botón de agregar plantaciones en la ventanda modal, se agregan al listado

     * todos las plantaciones cuyos IDs han sido colocados en el campo de texto
     */
    $("#plantaciones-modal-add").click(function() {
      $.each($('#plantaciones_nuevas_ids').val().split('\n'), function(key, value) {
        if (value !== '') {
          return $('#plantaciones_historico').append("<option value='" + value + "'>" + value
 + "</option>");
        }
      });
      return $("#nuevas-plantaciones-modal").modal('hide');
    });

    /* Elimina las plantaciones seleccionadas */
    $("#remove-nueva-plantacion").click(function() {
      var nuevaPlantacion, _i, _len, _ref, _results;
      _ref = $("#plantaciones_historico option:selected");
      _results = [];
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        nuevaPlantacion = _ref[_i];
        _results.push(nuevaPlantacion.remove());
      }
      return _results;
    });

    /* Hacer foco en el textarea cuando se abre el modal */
    return $('#nuevas-plantaciones-modal').on('shown.bs.modal', function() {
      return $('#plantaciones_nuevas_ids').focus();
    });
  });
  /* Selecciona todos los titulares del listado antes ejectuar el submit del formulario */
  return $("form").submit(function() {
    return $("#plantaciones_historico option").prop('selected', true);
  });
}).call(this);
