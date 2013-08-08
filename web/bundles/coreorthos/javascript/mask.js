var masks = {
    cpf:'999.999.999-99',
    cnpj:'99.999.999/9999-99',
    fone:'(99)9999-9999',
    date:'99/99/9999',
    cep:'99999-999'
};

var Mask = {
    defineMask:function (mask) {
        switch (mask) {
            case 'cpf':
                return masks.cpf;
                break;
            case 'cnpj':
                return masks.cnpj;
                break;
            case 'fone':
                return masks.fone;
                break;
            case 'date':
                return masks.date;
                break;
            case 'cep':
                return masks.date;
                break;
            default:
                return mask;
        }
    },
    execute:function () {
        $('input').each(function () {
            if ($(this).attr('mask')) {
                var mask = $(this).attr('mask');
                Mask.eventMask(this, mask);
                $(this).mask(Mask.defineMask(mask));
            }
        });
    },
    eventMask:function (component, mask) {
        if (mask == 'date') {
            $(component).datepicker();
        }
    },
    formataCampo:function (campo, Mascara, evento) {
        var er = /[^0-9-.-/]/;
        if (er.test(document.getElementById(campo).value)) {
            document.getElementById(campo).value = document.getElementById(campo).value.slice(0, (document.getElementById(campo).value.length) - 1);
        }
        var boleanoMascara;

        var Digitato = evento.keyCode;
        var exp = /\-|\.|\/|\(|\)| /g
        var campoSoNumeros = document.getElementById(campo).value.toString().replace(exp, "");

        var posicaoCampo = 0;
        var NovoValorCampo = "";
        var TamanhoMascara = campoSoNumeros.length;
        ;

        if (Digitato != 8) { // backspace
            for (i = 0; i <= TamanhoMascara; i++) {
                boleanoMascara = ((Mascara.charAt(i) == "-") || (Mascara.charAt(i) == ".")
                    || (Mascara.charAt(i) == "/"))
                boleanoMascara = boleanoMascara || ((Mascara.charAt(i) == "(")
                    || (Mascara.charAt(i) == ")") || (Mascara.charAt(i) == " "))
                if (boleanoMascara) {
                    NovoValorCampo += Mascara.charAt(i);
                    TamanhoMascara++;
                } else {
                    NovoValorCampo += campoSoNumeros.charAt(posicaoCampo);
                    posicaoCampo++;
                }
            }
            document.getElementById(campo).value = NovoValorCampo;
            return true;
        } else {
            return true;
        }
    }
};

