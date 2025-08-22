$(document).ready(function () {
    $('.modulo-link').on('click', function (e) {
        e.preventDefault();
        const url = $(this).data('url');

        $('#contenido-principal').html('<p>Cargando módulo...</p>');

        $.get(url, function (data) {
            $('#contenido-principal').html(data);
        }).fail(function () {
            $('#contenido-principal').html('<p>Error al cargar el módulo.</p>');
        });
    });
});
