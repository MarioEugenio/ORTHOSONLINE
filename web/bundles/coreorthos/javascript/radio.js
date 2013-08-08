var Radio = {
    create: function (url,name,component,val) {
        $.ajax({
        type: "POST",
        url: url,
        data: {
            query : val
        },
        success: function(data){
             if (data!='[NULL]' || data != 'NULL') {
                  var j = $.parseJSON(data);
                   $.each(j, function(i, value) {
                     if (value) {
                         for (var i = 0; i < value.length; i++) {

                            if (i==1) {
                                var radio = $('<input />').attr({
                                    type: 'radio', name: name, checked:true, value: value[i].value
                                });
                            } else {
                                var radio = $('<input />').attr({
                                    type: 'radio', name: name, value: value[i].value
                                });
                            }
                            $(component).after(value[i].display+'<br><br>').after(radio);
                        }
                     }
                  });
             }
          }
      });
    }
};