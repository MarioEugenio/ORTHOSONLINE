var Image = {
    pathImage: function () {
        var baseUrl = $("meta[name=baseUrl]").attr("content");
        baseUrl = baseUrl.replace("app_dev.php", "");
        return baseUrl;
    },
    Resize: function (img) {
        Modal.close('myModal');

        $('#profilePhoto').attr('src', '//'+location.host+Image.pathImage() + img);
        
        Image.saveImageProfile(img);
    },
    
    saveImageProfile: function (img) {
        return $.post(
            Routing.generate('user_save_imageprofile'),
            {'img':img},
            null,
            'JSON'
        );
    }
};