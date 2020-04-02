"use strict";
$(document).ready(function () {
    $("textarea.editor-cls").wysihtml5();
    $("#summernote").summernote({
        height:200
    });
    $('.note-link-url').on('keyup', function() {
        if($('.note-link-text').val() != '') {
            $('.note-link-btn').attr('disabled', false).removeClass('disabled');
        }
    });
    $("textarea#split_editor").trumbowyg();
    jQuery.trumbowyg.langs.fr = {
        _dir: "ltr", // This line is optionnal, but usefull to override the `dir` option

        bold: "Gras",
        close: "Fermer"
    };

    if ($(window).width() < 700) {
        $("<br>").insertAfter(".summer_noted .dropdown-menu li .btn-group");
    }

});

$(document).ready(function(){
    $(".wysihtml5-toolbar li:nth-child(3) a.btn-default span").removeClass("glyphicon-quote").addClass("fa fa-quote-left");
    $(".wysihtml5-toolbar li:nth-child(4) a.btn-default:nth-child(1) span").removeClass("glyphicon-list").addClass("fa fa-list-ul");
    $(".wysihtml5-toolbar li:nth-child(4) a.btn-default:nth-child(2) span").removeClass("glyphicon-th-list").addClass("fa fa-list");
    $(".wysihtml5-toolbar li:nth-child(4) a.btn-default:nth-child(3) span").removeClass("glyphicon glyphicon-indent-right").addClass("fa fa-indent");
    $(".wysihtml5-toolbar li:nth-child(4) a.btn-default:nth-child(4) span").removeClass("glyphicon glyphicon-indent-left").addClass("fa fa-align-right");
})