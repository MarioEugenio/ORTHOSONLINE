var Utils = {
   nl2br: function (stringHtml) {
       stringHtml = stringHtml.replace(/(\r\n|\r|\n)/g,"<br/>");
       return stringHtml;
   },

    mapBy: function (key, items) {
        var result = {};
        angular.forEach(items, function (item) {
            result[item[key]] = item;
        });
        return result;
    },

    getChecked: function (classe) {
        var val = [];
        $('.' + classe + ':checked').each(function (i) {
            val[i] = $(this).val();
        });

        return val.join(",");
    },

    validateEmail: function (value) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if( !emailReg.test( value ) ) {
            return false;
        } else {
            return true;
        }
    },

    parseDate2: function (objDate) {
        if (!objDate) return '-';
        if ((objDate == undefined) || (objDate == 'undefined')) return '-';
        if (objDate == null) return '-';

        var date = objDate.toString().split(' ');
        return date[0];
    },

    parseDate: function (objDate) {
        if (!objDate) return '-';
        if ((objDate == undefined) || (objDate == 'undefined')) return '-';
        if (objDate == null) return '-';

        var date = objDate.toString().split(' ');
        date = date[0].split('-');

        return date[2] + '/' + date['1'] + '/' + date[0];
    },

    getDate: function () {
        var dat = new Date();
        return Utils.formateNumberDate(dat.getDate()) + '/' + Utils.formateNumberDate(dat.getMonth() + 1) + '/' + dat.getFullYear();
    },

    getTime: function () {
        var dat = new Date();
        return dat.getHours()+':'+dat.getMinutes();
    },

    formateNumberDate: function (number) {
        var nu = number.toString();
        if (nu.length == 1) {
            return '0'+nu;
        }

        return nu;
    },

    formateMoney: function (value) {
        if (!value) return 0;

        var val = value.toString();
        val = val.replace('.', '');
        var len = val.length;

        return val.substr(0,(len-2)) + '.' + val.substr(-2);
    },

    addMonth: function (date, month) {
        var date2 = new String(date);
        date2 = date2.split("/");

        dateTime = new Date(date2[1]+"/"+date2[0]+"/"+date2[2]);
        dateTime.setMonth(dateTime.getMonth() + month);

        return Utils.formateNumberDate(dateTime.getDate())  + '/' + Utils.formateNumberDate(dateTime.getMonth() + 1) + '/' + dateTime.getFullYear();
    },

    DiffDateNow: function (Dt_Face) {
        var dias = 0;
        var date2 = new String(Dt_Face);

        date2 = date2.split("/");
        var sDate = new Date();
        sDate.setHours(0,0,0);

        var eDate = new Date(date2[1]+"/"+date2[0]+"/"+date2[2]);
        dias = Math.round((sDate-eDate)/86400000);

        if (dias <= 0) {
            return 0;
        }

        return dias;
    },

    DiffDate: function (Dt_Face, Dt_Boleto) {
        var dias = 0;
        var date2 = new String(Dt_Face);
        var date1 = new String(Dt_Boleto);
        date1 = date1.split("/");
        date2 = date2.split("/");
        var sDate = new Date(date1[1]+"/"+date1[0]+"/"+date1[2]);
        var eDate = new Date(date2[1]+"/"+date2[0]+"/"+date2[2]);
        dias = Math.round((sDate-eDate)/86400000);
        return dias;
    },

    parseMoney: function (valor) {
        return valor.toString().replace(',','');
    },

    validaCPF: function (value) {
        if (!value) {
            return true
        }

        var strCPF = value.replace(".","");
        strCPF = strCPF.replace("-","");
        strCPF = strCPF.replace(" ","");
        strCPF = strCPF.replace(".","");
        var Soma;
        var Resto;
        Soma = 0;
        if (strCPF == "00000000000") {
            return false;
        }

        for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
        Resto = (Soma * 10) % 11;

        if ((Resto == 10) || (Resto == 11))  Resto = 0;
        if (Resto != parseInt(strCPF.substring(9, 10)) ) {
            return false;
        }

        Soma = 0;
        for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
        Resto = (Soma * 10) % 11;

        if ((Resto == 10) || (Resto == 11))  Resto = 0;
        if (Resto != parseInt(strCPF.substring(10, 11) ) ) {
            return false;
        }

        return true;
    }
};