var Form = {
    load:function (url, data, callback, type) {
        $.post(
            url,
            data,
            callback,
            type
        ).complete(function () {
            });
    },

    submit:function (url, data, callback, type) {
        Loading.showAll();
        $.post(
            url,
            data,
            callback,
            type
        ).complete(function () {
                Loading.hideAll();
            });
    },

    submitSerialize:function (url, form, callback, type, mValue) {
        var validate = Form.postValidate(form);

        if ($.browser.msie) {
            $(form).find('*[placeholder]').each(function () {
                if ($(this).val() == $(this).attr('placeholder')) {
                    $(this).val('');
                }
            });
        }

        if (validate) {
            Modal.growl('Existem campos de preenchimento obrigatório', 'error');
        } else {
            Loading.showAll();
            var post = $(form).serialize();
            $.post(
                url,
                {
                    form:post,
                    multi:mValue
                },
                callback,
                type
            ).complete(function () {
                    Loading.hideAll();
                });
        }
    },

    inicializeValidate:function (form, response, typeValid, component) {
        if (!typeValid) typeValid = 'form-message';

        switch (typeValid) {
            case 'form-message':
                Form.postMessage(response, component);
                break;
            case 'modal-message':
                Form.modalMessage(response);
                break;
            case 'growl-message':
                Form.growlMessage(response);
                break;
            case 'alert:message':

                break;
        }

    },

    growlMessage:function (response) {
        var message = response.message;
        message = message.split('|');
        if (0 < message.length) {
            var startIndex = message.length - 1;
            for (i = startIndex; i >= 0; i--) {

                var success = response.success;
                var type_success = '';
                if (success) {
                    type_success = 'success';
                } else {
                    type_success = 'error';
                }

                Modal.growl(message[i], type_success);
            }
        }
    },

    modalMessage:function (response) {
        var message = response.message;
        message = message.split('|');
        var result = '<ul>';

        if (0 < message.length) {
            for (i = 0; i < message.length; i++) {
                result += '<li>' + message[i];
            }
        }

        result += '</ul>';

        Modal.alert(result, 'ALERTA', response.success);
    },

    postMessage:function (response, component) {
        if (!component) component = 'alert';

        $('#' + component).removeClass();
        switch (response.success) {
            case true:
                var typeMessage = '<i class="icon-ok-sign"></i> <strong>Sucesso</strong><br>';
                $('#' + component).addClass('alert alert-success fade in');
                break;
            case false:
                var typeMessage = '<i class="icon-question-sign"></i> <strong>Alerta</strong><br>';
                $('#' + component).addClass('alert alert-danger fade in');
                break;
            default:
                var typeMessage = '<i class="icon-info-sign"></i> <strong>Informação</strong><br>';
                $('#' + component).addClass('alert fade in');
        }

        var message = response.message;
        message = message.split('|');
        var result = '<ul>';

        if (0 < message.length) {
            for (i = 0; i < message.length; i++) {
                result += '<li>' + message[i];
            }
        }

        result += '</ul>';

        $('#' + component).html(typeMessage + result);

        $("#" + component).alert();
        $("#" + component).show();

        setTimeout(function () {
            $("#" + component).hide(300);
        }, 5000);
    },

    postValidate:function (form) {
        var validate = false;

        $('form#' + form).find('.required').each(function (i) {

            if (this.type == 'radio') {
                $(this).parent('div').parent('div').addClass('error');
            }

            if ((!this.value)) {
                if (this.disabled != true) {
                    validate = true;
                    $(this).parent('div').parent('div').addClass('error');
                }

            }

        });

        Form.postValidateChange();

        return validate;
    },

    postValidateChange:function () {
        $('.required').change(function () {
            if ((this.value) || (this.value > 0)) {
                $(this).parent('div').parent('div').removeClass('error');
            }

            if ((!this.value) || (this.value == 0)) {
                $(this).parent('div').parent('div').addClass('error');

            }
        });
    },

    getValCheckbox:function (component) {
        var list = [];
        $('input[name=' + component + ']:checked').each(function () {
            list.push($(this).val());
        });

        return list;
    },

    getValArrayInput:function (component) {
        var list = [];

        $(component).each(function () {
            list.push($(this).val());
        });

        return list;
    }
};