var Ico = {
    save: '/save.png',
    edit: '/edit.png',
    remove: '/remove.png',
    search: '/search.png',
    tree: '/tree.png',
    detail: '/detail.png'
};

var IcoBootstrap = {
    save: '',
    edit: 'icon-edit',
    remove: 'icon-remove',
    search: '',
    tree: '',
    detail: ''
};

var Icons = {
    pathIcons: function ()
    {
        return 'web/bundles/corelayouts/default/images/icons/';
    },
    render: function (ico, scope, click, arg) {
        switch (ico) {
            case 'remove':
                return '<button title="Remover registro" class="btn" onclick="Grid.action(\''+scope+'\',\''+click+'\', \''+arg+'\')" type="button"><li class="icon-remove-circle"></li></button>&nbsp;';
                break;
            case 'edit':
                return '<button title="Alterar registro" class="btn" onclick="Grid.action(\''+scope+'\',\''+click+'\', \''+arg+'\')" type="button"><li class="icon-edit"></li></button>&nbsp;';
                break;
            case 'pagamento':
                return '<button title="Pagamento" class="btn" onclick="Grid.action(\''+scope+'\',\''+click+'\', \''+arg+'\')" type="button"><li class="icon-check"></li></button>&nbsp;';
                break;
            case 'boleto':
                return '<button title="Boleto" class="btn" onclick="Grid.action(\''+scope+'\',\''+click+'\', \''+arg+'\')" type="button"><li class="icon-barcode"></li></button>&nbsp;';
                break;
            case 'cheque':
                return '<button title="Cheque Devolvido" class="btn" onclick="Grid.action(\''+scope+'\',\''+click+'\', \''+arg+'\')" type="button"><li class="icon-circle-arrow-down"></li></button>&nbsp;';
                break;
        }
    },
    bootstrap: function (ico, click, alt)
    {
//        var span = $('<spam></spam>').attr(
//            {
//                'class': ico,
//                'onclick': click,
//                'alt': alt
//            }
//        );

        var span = '<span class="'+ico+'" onClick="'+click+'"></span>';
        return span;
    }
}
