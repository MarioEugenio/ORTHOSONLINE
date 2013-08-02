var Datepicker = {
    createIco: function (component, format) {
        $('.datepicker').datepicker();

        if (!format) format = 'dd-mm-yyyy';
        var i = 1;
        if ($('.date').length > 0) i = ( $('.date').length + 1 );

        var id = 'input' + $('#' + component).attr('id');

        var html = '<div class="input-append date" id="dt'+i+'" data-date="12-02-2012" data-date-format="'+format+'">';
        html += '<input id="'+id+'" name="'+id+'" class="span2" size="16" type="text">';
        html += '<span class="add-on"><i class="icon-th"></i></span>';
        html += '</div>';

        $('#' + component).html(html);
    },
    getMonth: function (mymonth) {
        if(mymonth == 1)
            month = "Janeiro";

        else if(mymonth ==2)
            month = "Fevereiro";

        else if(mymonth ==3)
            month = "Março";

        else if(mymonth ==4)
            month = "Abril";

        else if(mymonth ==5)
            month = "Maio";

        else if(mymonth ==6)
            month = "Junho";

        else if(mymonth ==7)
            month = "Julho";

        else if(mymonth ==8)
            month = "Agosto";

        else if(mymonth ==9)
            month = "Setembro";

        else if(mymonth ==10)
            month = "Outubro";

        else if(mymonth ==11)
            month = "Novembro";

        else if(mymonth ==12)
            month = "Dezembro";

        return month;
    }
};