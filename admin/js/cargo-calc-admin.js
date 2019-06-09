jQuery(document).ready(function ($) {
    $('[data-toggle="datepicker"]').datepicker({
        language: 'ru-RU',
        format: 'dd.mm.yyyy',
        autoHide: true,
        autoPick: true
    });

    var form = $("#form-export");
    var spinner = $('#spinner');
    var note = $('#form-note');

    form.validate();

    $('#btn-submit').click(function (event) {
        event.preventDefault();

        if (form.valid()) {
            var data = {
                action: 'export_csv',
                info: form.serialize()
            };
            var jqxhr = $.post(ajaxurl, data);
            spinner.show();

            jqxhr.done(function (response) {
                // console.log(response);
                if (response.success) {
                    var filename = response.data.split('/').pop();
                    note.html('<br/><div>Файл успешно сформирован: <a href="' + response.data + '" download>' + filename + '</a></div>');
                } else {
                    var text_error = 'Ошибка: ';
                    response.data.forEach((element) => {
                        text_error += element + '<br />';
                    });
                    note.html('<br/><div class="error_note">' + text_error + '</div>');
                }
            });

            jqxhr.fail(function (error) {
                console.log(error.statusText);
            });

            jqxhr.always(function () {
                spinner.hide();
            });

        }
    });
});
