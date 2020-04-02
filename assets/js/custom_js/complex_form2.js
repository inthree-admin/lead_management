"use strict";
$(document).ready(function() {

//complex forms
    $("#complex-form2").find('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });

    $("#country").select2({
        theme: "bootstrap"
    });
    $('#dob_appl1').datetimepicker({
        format: 'DD/MM/YYYY',
        useCurrent: false,
        maxDate: 'now',
        icons: {
            time: 'fa fa-clock-o',
            date: 'fa fa-calendar',
            up: 'fa fa-chevron-up',
            down: 'fa fa-chevron-down',
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'glyphicon glyphicon-screenshot',
            clear: 'fa fa-trash',
            close: 'fa fa-times'
        },
    });
    $('#dob_appl2').datetimepicker({
        format: 'DD/MM/YYYY',
        useCurrent: false,
        maxDate: 'now',
        icons: {
            time: 'fa fa-clock-o',
            date: 'fa fa-calendar',
            up: 'fa fa-chevron-up',
            down: 'fa fa-chevron-down',
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'glyphicon glyphicon-screenshot',
            clear: 'fa fa-trash',
            close: 'fa fa-times'
        },
    });
    $('#dob_appl3').datetimepicker({
        format: 'DD/MM/YYYY',
        useCurrent: false,
        maxDate: 'now',
        icons: {
            time: 'fa fa-clock-o',
            date: 'fa fa-calendar',
            up: 'fa fa-chevron-up',
            down: 'fa fa-chevron-down',
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'glyphicon glyphicon-screenshot',
            clear: 'fa fa-trash',
            close: 'fa fa-times'
        },
    });
    $('#dateofaccount').datetimepicker({
        format: 'DD/MM/YYYY',
        useCurrent: false,
        maxDate: 'now',
        icons: {
            time: 'fa fa-clock-o',
            date: 'fa fa-calendar',
            up: 'fa fa-chevron-up',
            down: 'fa fa-chevron-down',
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'glyphicon glyphicon-screenshot',
            clear: 'fa fa-trash',
            close: 'fa fa-times'
        },
    });
    $('#dateofincorp').datetimepicker({
        format: 'DD/MM/YYYY',
        useCurrent: false,
        maxDate: 'now',
        icons: {
            time: 'fa fa-clock-o',
            date: 'fa fa-calendar',
            up: 'fa fa-chevron-up',
            down: 'fa fa-chevron-down',
            previous: 'fa fa-chevron-left',
            next: 'fa fa-chevron-right',
            today: 'glyphicon glyphicon-screenshot',
            clear: 'fa fa-trash',
            close: 'fa fa-times'
        },
    });

    $(function () {
        $('#dated').datetimepicker({
            format: 'DD/MM/YYYY'
        }).on("dp.change", function (e) {
            $('#drawn').data("DateTimePicker").minDate(e.date);
        });

        $('#drawn').datetimepicker({
            format: 'DD/MM/YYYY',
            icons: {
                time: 'fa fa-clock-o',
                date: 'fa fa-calendar',
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down',
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'glyphicon glyphicon-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-times'
            },
            useCurrent: false
        }).on("dp.change", function (e) {
            $('#dated').data("DateTimePicker").maxDate(e.date);
        });
    });

    $("#select_country").select2({
        theme: "bootstrap"
    });
});
