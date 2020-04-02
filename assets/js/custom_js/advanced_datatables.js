"use strict";

$(document).ready(function () {
    //table tools example
    var table = $('#table1').DataTable({
        // dom: 'Bflrtip',

        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "dom": "<'m-t-10'B><'row'<'col-md-5 col-12 float-left'l><'col-md-7 col-12'f>r><'table-responsive't><'row'<'col-md-5 col-12'i><'col-md-7 col-12'p>>", // datatable layout without  horizobtal scroll

    });

    //re-order columns
    var table2 = $('#table2').dataTable({
        "dom": "<'row'<'col-md-5 col-12 float-left'l><'col-md-7 col-12'f>r><'table-responsive't><'row'<'col-md-5 col-12'i><'col-md-7 col-12'p>>", // datatable layout without  horizobtal scroll
    });

    new $.fn.dataTable.ColReorder(table2);


    // add row, delete row example
    var table3 = $('#table3').DataTable({
        "order": [
            [0, "desc"]
        ],
        "dom": "<'row'<'col-md-5 col-12 float-left'l><'col-md-7 col-12'f>r><'table-responsive't><'row'<'col-md-5 col-12'i><'col-md-7 col-12'p>>", // datatable layout without  horizobtal scroll
    });
    //total number of existing rows
    var counter = 41;


    //row addition code
    $('#addButton').on('click', function () {
        table3.row.add([
            counter,
            counter + ' new',
            counter + ' user',
            counter + '_unique_user',
            counter + '_unique_user@domain.com'
        ]).draw();

        counter++;
    });

    //row deletion code

    $('#table3').find('tbody').on('click', 'tr', function () {
        if ($(this).hasClass('danger')) {
            $(this).removeClass('danger');
        } else {
            table3.$('tr.danger').removeClass('danger');
            $(this).addClass('danger');
        }
    });

    $('#delButton').on('click', function () {
        if (!$("#table3").find('tr').hasClass('danger')) {
            alert('please select a row first');
            //exit;
        }
        table3.row('.danger').remove().draw(false);
    });

});