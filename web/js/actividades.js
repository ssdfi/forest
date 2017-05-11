function ActividadPlantacionAdd() {
    var collectionHolder = $('.actividadesPlantaciones');
    // alert(JSON.stringify(collectionHolder));
    var collectionCount = collectionHolder.children().length;
    var prototipo = collectionHolder.attr('data-prototype');
    prototipo = prototipo.replace(/__name__/g, collectionCount);
    collectionCount++;

    var newLi = jQuery('<tr class="fields"></tr>').html(prototipo);
    newLi.appendTo(collectionHolder);
    // form = prototype.replace(/\$\$name\$\$/g, collectionHolder.children().length);
    // collectionHolder.append(form);
}
