"use strict";
$(document).ready(function () {

    $('#form-validation').bootstrapValidator({
        fields: {
            username: {
                validators: {
                    notEmpty: {
                        message: 'The user name is required and cannot be empty'
                    }
                }
            },
            firstname: {
                validators: {
                    notEmpty: {
                        message: 'The first name is required and cannot be empty'
                    }
                }
            },
            lastname: {
                validators: {
                    notEmpty: {
                        message: 'The last name is required and cannot be empty'
                    }
                }
            },
            password: {
                validators: {

                    notEmpty: {
                        message: 'Please provide a password'
                    }
                }
            },
            c_password: {
                validators: {
                    notEmpty: {
                        message: 'The confirm password is required and can\'t be empty'
                    },
                    identical: {
                        field: 'password',
                        message: 'Please enter the password same as above'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'The email address is required'
                    },
                    regexp: {
                        regexp: /^\S+@\S{1,}\.\S{1,}$/,
                        message: 'Please enter valid email format'
                    }
                }
            },


            phone: {
                validators: {
                    notEmpty: {
                        message: 'The phone number is required and cannot be empty'
                    },
                    regexp: {
                        regexp: /[2-9]{2}\d{8}/,
                        message: 'The phone number can only consist of numbers'
                    }
                }
            },

            gender: {
                validators: {
                    notEmpty: {
                        message: 'The gender is required'
                    }
                }
            }
        },
        submitHandler: function (validator, form, submitButton) {
            alert();
        }
    }).on('success.form.bv', function (e) {
        // Prevent form submission
        e.preventDefault();
		serializeData = $('#form-validation').serializeArray();
        save();

    });


    $('input[type="checkbox"].custom_icheck, input[type="radio"].custom_radio').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue',
        increaseArea: '20%'
    });
    $('#terms').on('ifChanged', function (event) {
        $('#form-validation').bootstrapValidator('revalidateField', $('#terms'));
    });
    $('.custom_radio').on('ifChanged', function (event) {
        $('#form-validation').bootstrapValidator('revalidateField', $('.custom_radio'));
    });
    $('.reset_btn').on('click', function () {
        var icheckbox = $('.custom_icheck');
        var radiobox = $('.custom_radio');
        icheckbox.prop('defaultChecked') == false ? icheckbox.iCheck('uncheck') : icheckbox.iCheck('check').iCheck('update');

        radiobox.prop('defaultChecked') == false ? radiobox.iCheck('uncheck') : radiobox.iCheck('check').iCheck('update');
    });

    $('#modalterms').on('ifChanged', function (event) {
        $('#form-validation3').bootstrapValidator('revalidateField', $('#modalterms'));
    });
    $(
        'input#defaultconfig'
    ).maxlength();

    $(
        'input#thresholdconfig'
    ).maxlength({
        threshold: 20

    });
    $('input.experment').maxlength({
        alwaysShow: true,
        threshold: 10,
        warningClass: "label label-success",
        limitReachedClass: "label label-danger"
    });


    $('input#alloptions').maxlength({
        alwaysShow: true,
        warningClass: "label label-success",
        limitReachedClass: "label label-danger",
        separator: ' chars out of ',
        preText: 'You typed ',
        postText: ' chars.',
        validate: true
    });


    $('#textarea').maxlength({
        alwaysShow: true,
        appendToParent: true
    });

    $('input.placement')
        .maxlength({
            alwaysShow: true,
            placement: 'top'
        });

});
// password strength init
$('#password1').passtrength({
    minChars: 5,
    passwordToggle: true,
    tooltip: true
});
function Validation() {

    var Name = document.frmOnline.txtName;

    var lastname = document.frmOnline.txtlastname;

    var Email = document.frmOnline.txtEmail;

    var Address1 = document.frmOnline.txtAddress1;
    var Address2 = document.frmOnline.txtAddress2;
    var Phone = document.frmOnline.txtPhone;
    var Conditions = document.frmOnline.e1;
    var chkConditions = document.frmOnline.chkConditions;

    if (Name.value == "") {
        alert("Enter your first name");
        Name.focus();
        return false;

    }

    if (Name.value != "") {
        var ck_name1 = /^[A-Za-z ]{3,50}$/;
        if (!ck_name1.test(Name.value)) {
            alert("You can not enter Numeric values (or) your name should be 3 - 20 characters...");
            Name.focus();
            return false;
        }
    }
    //lastname Validation
    if (lastname.value == "") {
        alert("Enter your last name");
        lastname.focus();
        return false;
    }
    if (lastname.value != "") {
        var ck_name = /^[A-Za-z ]{3,20}$/;
        if (!ck_name.test(lastname.value)) {
            alert("You can not enter Numeric values (or) your name should be 3 - 20 characters...");
            lastname.focus();
            return false;
        }
    }
    //lastname Validation Completed

    //email validation
    if (Email.value == "") {
        alert("Enter your Email_Id");
        txtEmail.focus();
        return false;
    }


    var x = document.forms["frmOnline"]["txtEmail"].value;
    var atpos = x.indexOf("@");
    var dotpos = x.lastIndexOf(".");
    if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= x.length) {
        alert("Not a valid e-mail address");
        txtEmail.focus();
        return false;
    }
    //address validation

    if (Address1.value == "") {
        alert("Enter your address line1");
        txtAddress1.focus();
        return false;
    }
    //address validation

    if (Address2.value == "") {
        alert("Enter your address line2");
        txtAddress2.focus();
        return false;
    }
    if (Conditions.value == "") {

        alert("Please Select State");
        Conditions.focus();
        return false;
    }
    //mobile Validation
    if (Phone.value == "") {
        alert("Please Enter your Phone number");
        txtPhone.focus();
        return false;
    }
    if (Phone.value != "") {
        var reg = /^[987][0-9]{9}$/;
        if (reg.test(Phone.value) == false) {
            alert("Please Enter Correct Phone Number");
            txtPhone.focus();
            return false;
        }
    }
    //Mobile Validation Completed
    //Condtion validtion
    if (chkConditions.checked == false) {
        alert("Please Check the Terms and Conditions");
        chkConditions.focus();
        return false;
    }
    return true;
}

$(document).ready(function () {
    $('#table').DataTable({
        "dom": "<'row'<'col-md-5 col-12 float-left'l><'col-md-7 col-12'f>r><'table-responsive't><'row'<'col-md-5 col-12'i><'col-md-7 col-12'p>>", // datatable layout without  horizobtal scroll
        "responsive": true
    });
});

var serializeData = [];
// Own script started  
function save() {
   
    var AjaxParams = {
        "_token": _token,
        "data": serializeData
    };
    var params = $.extend({}, doAjax_params_default);
    params = {
        url: "/user/new",
        data: AjaxParams,
        "requestType": "POST",
        "successCallbackFunction": getResponseData,
        "errorCallBackFunction": showErrorMsg
    };
    doAjax(params);
    function getResponseData(xhr, status, data) {
        var msg = xhr.message;
        swal({
            title: "Success",
            text: msg,
            type: "success",
            confirmButtonColor: "#66cc99"
        }).then(function() {
            location.reload();
        });
    }

    function showErrorMsg(xhr, status, error) {
        var errorMessage = JSON.parse(xhr.responseText);
        var msg = '';
        $.each(errorMessage.message, function(i, j) {
            msg += j[0] + '<br>';
        });
        notify('error', 'Sorry!', msg);
    }
}

roleList(1);

function roleList(activeId = '') {
    var AjaxParams = {
        "_token": _token,
        "id": ""
    };
    var params = $.extend({}, doAjax_params_default);
    params = {
        url: "/role/",
        data: AjaxParams,
        "requestType": "GET",
        "successCallbackFunction": getResponseData
    };
    doAjax(params);
    function getResponseData(data) {
        var formattedData = [];
        $.each(data, function(i, j) {
            formattedData.push({
                "id": j['lmr_id'],
                "value": j['lmr_name']
            });
        });
        dropdownBox('#user_role', formattedData, activeId);
    }
}
 

 resetInput();
 $('#form-validation').closest('.row').show();
function showPortal(role){ 
        resetInput();  
        if(role == 1) $('#form-validation').closest('.row').show();
        if(role == 2) $('#commentForm').closest('.row').show();
        if(role == 3) $('#runnerform').closest('.row').show();
    
}

function resetInput(){
    $.each($('form'),function() { 
         $(this)[0].reset();
         $(this).closest('.row').hide();
    });
}

