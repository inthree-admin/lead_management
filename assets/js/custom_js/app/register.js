"use strict";
$(document).ready(function () {
    //=================Preloader===========//
    $(window).on('load', function () {
        $('.preloader img').fadeOut();
        $('.preloader').fadeOut();
    });
    //=================end of Preloader===========// 
 
    $('#form_sinup').bootstrapValidator({
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
                        message: 'The Email is not available',
                        url: BASE_URL+'/account/verify/'
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
                message: 'The username is not valid',
                validators: { 
                    remote: {
                        message: 'The username is not available',
                        url: BASE_URL+'/account/verify/'
                    },
                    notEmpty: {
                        message: 'The username is required'
                    },
                }
            }
        }
    }).on('success.form.bv', function (e) {
            e.preventDefault();
            var form = $('#form_sinup')[0];  
            var data = new FormData(form); 
            addUser(data);  
    });
 
    
     
    //password validation
    $('#password').on('keyup', function () {
        var pswd = $("#password input[name='password']").val();
        var pswd_cnf = $("#confirm-password input[name='password_confirm']").val();
        if (pswd != '') {
            $('#form_sinup').bootstrapValidator('revalidateField', $('#password'));
        }
        if (pswd_cnf != '') {
            $('#form_sinup').bootstrapValidator('revalidateField', $('#confirm-password'));
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