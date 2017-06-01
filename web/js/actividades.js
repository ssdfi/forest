function ActividadPlantacionAdd() {
    var collectionHolder = $('.actividadesPlantaciones');
    var collectionCount = collectionHolder.children().length;
    var prototipo = collectionHolder.attr('data-prototype');
    prototipo = prototipo.replace(/__name__/g, collectionCount);
    collectionCount++;
    var newLi = jQuery('<tr class="fields"></tr>').html(prototipo);
    newLi.appendTo(collectionHolder);
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
            return tr.find('[id$=superficieRegistrada]').val(data['1']);
          }
        }).always(function() {
          input.prop('disabled', false);
          return button.prop('disabled', false);
        });
      }
}
