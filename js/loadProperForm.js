
function loadContent(file) {
    $(function () {
        $('#container').fadeOut(400, function () {
            $('#container').load(file, function () {
                $('#container').fadeIn(400);
            });
        });
        return false;
    });
}