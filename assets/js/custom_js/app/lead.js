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


    

});
  

var serializeData = [];
// Own script started  
function save() { 
}

sateList();

function sateList(activeId='') {
    var AjaxParams = {
        "q":"all",
        "country": "in"
    };
    var params = $.extend({}, doAjax_params_default);
    params = {
        url: BASE_URL+"/lead/state/",
        data: AjaxParams,
        "requestType": "GET",
        "successCallbackFunction": getResponseData
    };
    doAjax(params);
    function getResponseData(data) {
		var result = JSON.parse(data);
        var formattedData = [];
        $.each(result, function(i, j) {
            formattedData.push({
                "id": j['state'],
                "value": j['state']
            });
        });
        dropdownBox('#state', formattedData, activeId);
    }
}
 

 

function resetInput(){
    $.each($('form'),function() { 
         $(this)[0].reset();
         $(this).closest('.row').hide();
    });
}

