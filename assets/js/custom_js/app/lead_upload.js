var fl_upld_dialog = '';

$(document).ready(function () {

    // Bulk Upload - added by divya
    $('input[type="file"]').ajaxfileupload({
        action: SITE_URL + 'lead_upload/bulk_upload_items_request',
        valid_extensions: ['xls', 'xlsx'],
        onComplete: function (response) {

            $('input[type="file"]').val('');

            $('.bootbox').css('display', 'none');
            $('.modal-backdrop').css('display', 'none');

            var jsonObj = response

            if (jsonObj.result == 'success') {

                var xlsItems = jsonObj.data;

                if (jsonObj.invalid > 0) {

                    var res_html = "<p>- Data validation failed. " + jsonObj.invalid + " errors found in the uploaded file.<br>- Please correct the following errors and retry.</b></p>";

                    res_html += "<table width='500px' class='table table-striped table-bordered'><tr>" +
                        "<thead style='background-color:#e9e9e9'><tr><td><b>Row No</b></td><td><b>Error</b></td><td><b>Cust Name</b></td><td><b>Phone</b></td><td><b>Address</b></td><td><b>City</b></td><td><b>Pincode</b></td><td><b>Product Name</b></td><td><b>Qty</b></td><td><b>LMP</b></td><td><b>Branch</b></td><td><b>BB Order ID</b></td></thead>";

                    $.each(xlsItems, function (b) {
                        if (xlsItems[b]['status'] == 1) {
                            res_html += '<tr><td>' + xlsItems[b]['row_no'] + '</td><td><span style="color:red;">' + xlsItems[b]['message'] + '</span></td><td>' + xlsItems[b]['customer_name'] + '</td><td>' + xlsItems[b]['customer_phone'] + '</td><td>' + xlsItems[b]['customer_address'] + '</td><td>' + xlsItems[b]['customer_city'] + '</td><td>' + xlsItems[b]['customer_pincode'] + '</td><td>' + xlsItems[b]['product_name'] + '</td><td>' + xlsItems[b]['qty'] + '</td><td>' + xlsItems[b]['lmp'] + '</td><td>' + xlsItems[b]['branch'] + '</td><td>' + xlsItems[b]['bb_order_id'] + '</td></tr>';
                        }
                    });

                    res_html += "</tbody></table>";

                    showDialog('File Upload Error !', res_html);

                    $('.modal-content').css('width', '1280px');
                    $('.modal').css('left', '-50%');
                    $('.bootbox-body').css('overflow', 'auto');

                } else {

                    saveDialog('Success !', jsonObj.valid + ' leads generated successfully.');
                    $('.modal-header').css('flex-direction', 'none');

                }

            } else {

                showDialog('File Upload Error !', 'Invalid File');

            }
        },
        onStart: function () {
            fl_upld_dialog = bootbox.dialog({
                message: '<p class="text-center">Please wait while we processing the file data...</p>',
                closeButton: false
            });
        },
        onCancel: function () {
            console.log('no file selected');
        }
    });
    /*End of divya code*/


});


function showDialog(title, message) {
    bootbox.dialog({
        message: message,
        title: title,
        buttons: {
            success: {
                label: "Ok",
            }
        }
    });
}

function saveDialog(title, message) {
    bootbox.dialog({
        message: message,
        title: title,
        buttons: {
            success: {
                label: "Ok",
                callback: function () {
                    location.reload();
                }
            }
        }

    });

}




