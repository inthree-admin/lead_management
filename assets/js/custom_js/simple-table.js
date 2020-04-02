"use strict";
$(document).ready(function () {
    var my_table = $("#mytable");
    my_table.find("#checkall").click(function () {
        if (my_table.find("#checkall").is(':checked')) {
            my_table.find("input[type=checkbox]").each(function () {
                $(this).prop("checked", true);
            });
        } else {
            my_table.find("input[type=checkbox]").each(function () {
                $(this).prop("checked", false);
            });
        }
    });
    //removing/hiding card1
    $('.removecard1').on('click', function () {
        $('.hidecard1').hide();
    });
    //removing/hiding card2
    $('.removecard2').on('click', function () {
        $('.hidecard2').hide();
    });
    //removing/hiding card3
    $('.removecard3').on('click', function () {
        $('.hidecard3').hide();
    });
    //removing/hiding card3
    $('.removecard4').on('click', function () {
        $('.hidecard4').hide();
    });
    //removing/hiding card3
    $('.removecard5').on('click', function () {
        $('.hidecard5').hide();
    });
    //starts hiding three card contents
    $('.showhide').attr('title', 'Hide card content');

    $(document).on('click', '.card-header span.clickable', function (e) {
        var $this = $(this);
        if (!$this.hasClass('card-collapsed')) {
            $this.parents('.card').find('.card-body').slideUp();
            $this.addClass('card-collapsed');
            $this.find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
            $('.showhide').attr('title', 'Show card content');
        } else {
            $this.parents('.card').find('.card-body').slideDown();
            $this.removeClass('card-collapsed');
            $this.find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
            $('.showhide').attr('title', 'Hide card content');
        }
    });
    //Ends Hiding Three card Contents

});