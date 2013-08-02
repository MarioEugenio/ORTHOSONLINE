var Modal = {
    close:function (component) {
        if (component) {
            $('#' + component).modal('hide');
        } else {
            $('.modal').modal('hide');
        }

    },
    simple:function (text, title) {
        $('#myModalSimple').remove();

        if (!title) {
            title = 'Atenção';
        }
        var html = '<div class="modal hide fade" id="myModalSimple">';
        html += '<div class="modal-header">';
        html += '   <a href="#" onclick="Modal.close(\'myModalSimple\')" class="close">&times;</a>';
        html += '   <h3>' + title + '</h3>';
        html += '</div>';
        html += '<div id="modal-body" class="modal-body">';
        html += '   <p>' + text + '</p>';
        html += '</div>';
        html += '</div>';

        $('body').append(html);

        $('#myModalSimple').modal('show');
    },
    alert:function (text, title, typeAlert) {
        $('#myModalAlert').remove();

        var htmlTitle = '<h3><span class="ico_information">' + title + '</span></h3>';

        if (typeAlert == true) {
            htmlTitle = '<h3><span class="ico_success">' + title + '</span></h3>';
        }

        if (typeAlert == false) {
            htmlTitle = '<h3><span class="ico_warning">' + title + '</span></h3>';
        }

        var html = '<div class="modal hide fade" id="myModalAlert">';
        html += '<div class="modal-header">';
        html += '   <button class="close" onclick="Modal.close(\'myModalAlert\')" data-dismiss="modal">×</button>';
        html += htmlTitle;
        html += '</div>';
        html += '<div id="modal-body" class="modal-body">';
        html += '   <p>' + text + '</p>';
        html += '</div>';
        html += '<div class="modal-footer">';
        html += '<a href="#" class="btn btn-primary"  data-dismiss="modal" onclick="Modal.close(\'myModalAlert\');">OK</a>';
        html += '</div>';
        html += '</div>';

        $('body').append(html);

        $('#myModalAlert').modal('show');
    },
    confirm:function (text, type, callback, callbackCancel) {
        var n = noty({
            text:text,
            type:type,
            dismissQueue:true,
            buttons:true,
            modal:true,
            layout:'center',
            theme:'default',
            buttons:[
                {addClass:'btn btn-primary', text:'Ok', onClick:callback
                },
                {addClass:'btn', text:'Cancelar', onClick:function ($noty) {
                    if(typeof callbackCancel != 'undefined'){
                        callbackCancel();
                    }
                    $noty.close();
                }
                }
            ]
        });
    },
    growl:function (text, type) {
       if (type == 'error') {
           $.sticky('<li class="icon-exclamation-sign"></li></span> <b>'+ text + '</b>');
       }

        if (type == 'success') {
            $.sticky('<li class="icon-ok-circle"></li></span> <b>'+ text + '</b>');
        }
    },
    load:function (url, title, callback, width, height) {
        $('#myModal').remove();

        if (width) var htmlWidth = "style='width:" + width + "px;'";
        if (height) var htmlHeight = "style='height:" + height + "px;'";

        var html = '<div ' + htmlWidth + htmlHeight + ' class="modal scroll-none" id="myModal">';
        html += '<div class="modal-header">';
        html += '   <button class="close" onclick="Modal.close(\'myModal\')" data-dismiss="modal">×</button>';
        html += '   <h3>' + title + '</h3>';
        html += '</div>';
        html += '<div id="modal-body" class="modal-body">';
        html += '   <p>Processando…</p>';
        html += '</div>';
        html += '</div>';

        $('body').append(html);

        Load.execute('#myModal .modal-body', url, null, callback);

        $('#myModal').modal('show');
    },
    closeEscapeLoad:function (url, title, callback, width, height) {
        $('#myModal').remove();

        if (width) var htmlWidth = "style='width:" + width + "px;'";
        if (height) var htmlHeight = "style='height:" + height + "px;'";

        var html = '<div ' + htmlWidth + htmlHeight + ' class="modal" id="myModal">';
        html += '<div class="modal-header">';
        //html += '   <button class="close" onclick="Modal.close(\'myModal\')" data-dismiss="modal">×</button>';
        html += '   <h3>' + title + '</h3>';
        html += '</div>';
        html += '<div id="modal-body" class="modal-body">';
        html += '   <p>Processando…</p>';
        html += '</div>';
        html += '</div>';

        $('body').append(html);

        Load.execute('#myModal .modal-body', url, null, callback);

        $('#myModal').modal({'show':true, 'keyboard':false,'backdrop': 'static'});

        return '#myModal';
    },
    closeEscape:function () {

    },
    information:function () {

    }
};