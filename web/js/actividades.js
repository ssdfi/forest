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
  var row = $(btn).closest('tr');
  row.remove();
  return false;
}
