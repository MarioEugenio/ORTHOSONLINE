var Layout = {
    addWest: function (content) {
        content = Layout.prepareComponent('west', content);
        $('div#west').append(content);
    },
    addCenter: function (content) {
        content = Layout.prepareComponent('center', content);
        $('div#center').append(content);
    },
    addEast: function (content) {
        content = Layout.prepareComponent('east', content);
        $('div#east').append(content);
    },
    addSouth: function (content) {
        content = Layout.prepareComponent('south', content);
        $('div#south').append(content);
    },
    addTop: function (content) {
        content = Layout.prepareComponent('top', content);
        $('div#top').append(content);
    },
    addComponentWest: function (url,params) {
        Loading.show('div#west');
        Form.submit(url,
            params,
            function (response) {
                Layout.addWest(response);
                Loading.hide();
            }
        );
    },
    addComponenteEast: function (url,params) {
        Loading.show('div#east');
        Form.submit(url,
            params,
            function (response) {
                Layout.addWest(response);
                Loading.hide();
            }
        );
    },
    addComponenteCenter: function (url,params) {
        Loading.show('div#center');
        Form.submit(url,
            params,
            function (response) {
                Layout.addWest(response);
                Loading.hide();
            }
        );
    },
    addComponentSouth: function (url,params) {
        Loading.show('div#south');
        Form.submit(url,
            params,
            function (response) {
                Layout.addWest(response);
                Loading.hide();
            }
        );
    },
    addComponentTop: function (url,params) {
        Loading.show('div#top');
        Form.submit(url,
            params,
            function (response) {
                Layout.addWest(response);
                Loading.hide();
            }
        );
    },
    renderWest: function (url) {
        Loading.show('div#west');
        Load.execute(
            'div#west',
            url,
            {},
            function() {
                Loading.hide();
            }
        );
    },
    renderEast: function (url) {
        Loading.show('div#east');
        Load.execute(
            'div#east',
            url,
            {},
            function() {
                Loading.hide();
            }
        );
    },
    renderSouth: function (url) {
        Loading.show('div#east');
        Load.execute(
            'div#east',
            url,
            {},
            function() {
                Loading.hide();
            }
        );
    },
    renderTop: function (url) {
        Loading.show('div#top');
        Load.execute(
            'div#top',
            url,
            {},
            function() {
                Loading.hide();
            }
        );
    },
    renderFooter: function (url) {
        Loading.show('div#footer');
        Load.execute(
            'div#footer',
            url,
            {},
            function() {
                Loading.hide();
            }
        );
    },
    collapse: function (container) {
        $(container).hide(300);
    },
    expand: function (container) {
        $(container).show(300);
    },
    prepareComponent: function (layout, content) {
        var id = $('div#'+layout).length;
        return '<div id="comp_'+id+'" name="comp_'+id+'" class="component">'+content+'</div>';
    }
};