var Autocomplete = {
    execute: function (component, url, minChars, params, callback) {
        if (!minChars) minChars = 3;
        var a = $(component).autocomplete({
            serviceUrl:url,
            minChars:minChars,
            delimiter: /(,|;)\s*/,
            maxHeight:400,
            width:300,
            zIndex: 9999,
            deferRequestBy: 0,
            params: params,
            noCache: false,
            onSelect: function(value, data){ callback(data); }

        });

        return a;
    }
};