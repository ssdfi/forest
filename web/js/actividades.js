$(document).ready(function () {
  $('#add-plantacion').click(function (e) {
    e.preventDefault();
    ActividadPlantacionAdd();
    return;
  });
  $(document).on( "click",'.remove-plantacion',function (e) {
    e.preventDefault();
    ActividadPlantacionRemove(this);
    return;
  });
  $(document).on('click','.hectareas', function (e) {
    e.preventDefault();
    getHectarea(this);
    return;
  });

  function ActividadPlantacionAdd() {
      var collectionHolder = $('.actividadesPlantaciones');
      var collectionCount = collectionHolder.children().length;
      var prototipo = collectionHolder.attr('data-prototype');
      prototipo = prototipo.replace(/__name__/g, collectionCount);
      collectionCount++;
      var newLi = jQuery('<tr class="fields"></tr>').html(prototipo);
      newLi.appendTo(collectionHolder).trigger('create');
      return;
  }

  function ActividadPlantacionRemove(btn) {
    var row = $(btn).closest('.fields');
    row.remove();
    return false;
  }

  function getHectarea(btn){
    var button, input, plantacion_id, tr;
    button = $(btn);
    tr = button.closest('tr');
    input = tr.find('[superficie_registrada]');
    plantacion_id = tr.find('[id$=plantacion]').val();
    if (plantacion_id) {
          input.prop('disabled', true);
          button.prop('disabled', true);
          return $.ajax({
            url: "/plantaciones/json/" + plantacion_id
          }).done(function(data) {
            if (data) {
              tr.find('[id$=plantacion]').parent().removeClass('has-error');
              return tr.find('[id$=superficieRegistrada]').val(data['1']);
            }
          }).fail(function(){
            return tr.find('[id$=plantacion]').parent().addClass('has-error');
          }).always(function() {
            input.prop('disabled', false);
            return button.prop('disabled', false);
          });
        }
  }

  $('#plantaciones-modal-add').click(function() {
        var plantacion_id, tr, _i, _len, _ref;
        _ref = $('#plantaciones-ids').val().split('\n');
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
          plantacion_id = _ref[_i];
          if ($.isNumeric($.trim(plantacion_id))) {
            $("#add-plantacion").click();
            tr = $('#plantaciones').find('tr').last();
            tr.find('[id$=plantacion]').val($.trim(plantacion_id));
            tr.find('[id$=fecha]').val($('#fecha').val());
            tr.find('[id$=numeroPlantas]').val($('#numero_plantas').val());
            if ($('#superficie_registrada').val()) {
              tr.find('[id$=superficieRegistrada]').val($('#superficie_registrada').val());
            } else {
              tr.find('.hectareas').click();
            }
            tr.find('[id$=estadoAprobacion]').val($('#_estado_aprobacion_id').val());
            tr.find('[id$=observaciones]').val($('#observaciones').val());
          }
        }
        $('#plantaciones-ids').val('');
        return $("#plantaciones-modal").modal('hide');
      });
});
