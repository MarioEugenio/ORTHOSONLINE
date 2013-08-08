var Select = {
    load: function (url,id,val,values)
    {
        $("#"+id+" select").val('Carregando...');
        idComponent = id;
        $.ajax({
        type: "POST",
        url: url,
        data: {
            query : val
        },
        success: function(data){
             if (data!='[NULL]' || data != 'NULL') {
                  var j = $.parseJSON(data);
                  var options = '<option value="0">Selecione...</option>';
                  $.each(j, function(i, value) {
                     if (value) {
                         for (var i = 0; i < value.length; i++) {
                            options += '<option value="' + value[i].value + '">' + value[i].display + '</option>';
                         }
                     }
                  });

                  $("#"+id+" select").html(options);
                  $("#"+id+" select").val(values);
                  $("#"+id+" input").val($("#"+id+" option[value="+values+"]").html());
                }
            }
        });
    }
}