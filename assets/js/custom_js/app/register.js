"use strict";
$(document).ready(function () {
    //=================Preloader===========//
    $(window).on('load', function () {
        $('.preloader img').fadeOut();
        $('.preloader').fadeOut();
    });
    //=================end of Preloader===========// 
 
    $('#authentication').bootstrapValidator({
        fields: {
            first_name: {
                validators: {
                    notEmpty: {
                        message: 'The first name is required and cannot be empty'
                    }
                }
            },
            last_name: {
                validators: {
                    notEmpty: {
                        message: 'The last name is required'
                    }
                }
            },
            password: {
                validators: {

                    notEmpty: {
                        message: 'Please provide a password'
                    },
                    stringLength: {
                    min: 8,
                    message: 'The number must be between 8 and above'
                 },
                }
            },
            password_confirm: {
                validators: {
                    notEmpty: {
                        message: 'The confirm password is required'
                    },
                    identical: {
                        field: 'password',
                        message: 'Please enter the same password'
                    }
                }
            },
            email: {
                 validators: {
                    remote: {
                        message: 'Email is not available',
                        url: 'verify',
                        data: {
                            email: $('#email').val().trim(),
                        },
                        type: 'GET'
                    }, 
                    notEmpty: {
                        message: 'The email address is required'
                    },
                    regexp: {
                        regexp: /^\S+@\S{1,}\.\S{1,}$/,
                        message: 'The input is not a valid email address'
                    }
                }
            },
          
            phone: {
                validators: {
                    notEmpty: {
                        message: 'The phone number is required and cannot be empty'
                    },
                    regexp: {
                        regexp: /^\d{10}$/,
                        message: 'The phone number should contain only 10 numbers'
                    }
                }
            },
            username: {
                validators: {
                    notEmpty: {
                        message: 'The username is required and cannot be empty'
                    },
                    remote: {
                        message: 'Username is not available',
                        url: 'verify',
                        data: {
                            username: $('#username').val().trim(),
                        },
                        type: 'GET'
                    }, 
                   stringLength: {
                    min: 5,
                    max: 20,
                    message: 'The number must be between 8 and above'
                 },
                }
            }
        },

    }).on('submit', function (e) {
         if(e.isDefaultPrevented() == true){
            var form = $('#authentication')[0];  
            var data = new FormData(form); 
            addUser(data);
         }
          
    }).on('success.form.bv', function (e) {
        

    });
 
    
    $("[type='reset']").on("click", function () {
        $('.signup_validator').bootstrapValidator("resetForm");
    });
    //password validation
    $('#password').on('keyup', function () {
        var pswd = $("#password input[name='password']").val();
        var pswd_cnf = $("#confirm-password input[name='password_confirm']").val();
        if (pswd != '') {
            $('.signup_validator').bootstrapValidator('revalidateField', $('#password'));
        }
        if (pswd_cnf != '') {
            $('.signup_validator').bootstrapValidator('revalidateField', $('#confirm-password'));
        }
    })


});

function addUser(data){
    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: BASE_URL+"account/register",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 800000,
        success: function (data) { 
            var result = JSON.parse(data);
            if(result['success']){
                    swal({
                    title: "Welcome! "+ '<p style="color:#509DE0;margin-top:25px;">'+$('#username').val()+'</p>',
                    text: result['msg'],
                    type: "success",
                    confirmButtonColor: "#66cc99"
                }).then(function() {
                    location.href = BASE_URL+'/auth/login';
                });
            }
        },
        error: function (e) { 

        }
    });
}