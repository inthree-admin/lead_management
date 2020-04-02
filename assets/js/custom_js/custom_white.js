'use strict';
$(document).ready(function () {
    $("body").addClass('light_layout');
    if($("body").hasClass('light_layout')){
        $(".navbar .logo img").attr('src','img/logo.png')
    }else{
        $(".navbar .logo img").attr('src','img/logo_white.png')
    }
});