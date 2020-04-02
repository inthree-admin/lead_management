'use strict';
$(document).ready(function () {
    $('#table').DataTable({
        "dom": "<'row'<'col-md-5 col-12 float-left'l><'col-md-7 col-12'f>r><'table-responsive't><'row'<'col-md-5 col-12'i><'col-md-7 col-12'p>>", // datatable layout without  horizobtal scroll
        "responsive": true
    });
});