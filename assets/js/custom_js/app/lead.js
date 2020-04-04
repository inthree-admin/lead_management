"use strict";
$(document).ready(function () {

    $('#form-validation').bootstrapValidator({
        fields: {
            cust_name: {
                validators: {
                    notEmpty: {
                        message: 'Please enter ther customer name'
                    }
                }
            },  
            email: {
                validators: {
                    notEmpty: {
                        message: 'Please enter the Email'
                    },
                    regexp: {
                        regexp: /^\S+@\S{1,}\.\S{1,}$/,
                        message: 'Please enter valid email format'
                    }
                }
            }, 
            mobile: {
                validators: {
                    notEmpty: {
                        message: 'Please enter the contact no'
                    },
                    regexp: {
                        regexp: /[2-9]{2}\d{8}/,
                        message: 'Please enter number only'
                    },
                     stringLength: {
	                    min: 10,
	                    max: 10,
	                    message: 'The number must be between 10 digit'
	                }
                }
            },
            alter_mobile: {
                validators: { 
                    regexp: {
                        regexp: /[2-9]{2}\d{8}/,
                        message: 'The alternate number can only consist of numbers'
                    },
                     stringLength: {
	                    min: 10,
	                    max: 10,
	                    message: 'The number must be between 10 digit'
	                }
                }
            },
             billing_address: {
                validators: {
                    notEmpty: {
                        message: 'Please enter the customer address'
                    }
                }
            },
             billing_city: {
                validators: {
                    notEmpty: {
                        message: 'Please enter the city'
                    }
                }
            },  
            billing_pincode: {
                notEmpty: {
                       message: 'Please enter the pincode',
                    },
	            validators: {
	                stringLength: {
	                    min: 6,
	                    max: 6,
	                    message: 'The number must be between 6 digit'
	                }
	            }
            },    
 			billing_contact_no: {
                validators: {
                    notEmpty: {
                        message: 'Please enter the contact no'
                    },
                    regexp: {
                        regexp: /[2-9]{2}\d{8}/,
                        message: 'Please enter number only'
                    },
                     stringLength: {
	                    min: 10,
	                    max: 10,
	                    message: 'The number must be between 10 digit'
	                }
                }
            },
            shipping_address: {
                validators: {
                    notEmpty: {
                        message: 'Please enter the billing address'
                    }
                }
            },
             shipping_city: {
                validators: {
                    notEmpty: {
                        message: 'Please enter the city'
                    }
                }
            },  
            shipping_pincode: { 
	            validators: {
	            	notEmpty: {
                       message: 'Please enter the pincode',
                    },
	                stringLength: {
	                    min: 6,
	                    max: 6,
	                    message: 'The number must be between 6 digit'
	                }
	            }
            },    
 			shipping_contact_no: {
                validators: {
                    notEmpty: {
                        message: 'Please enter the contact no'
                    },
                    regexp: {
                        regexp: /[2-9]{2}\d{8}/,
                        message: 'Please enter number only'
                    },
                     stringLength: {
	                    min: 10,
	                    max: 10,
	                    message: 'The number must be between 10 digit'
	                }
                }
            },
           product: { 
	            validators: {
	            	notEmpty: {
                       message: 'Please select product',
                    } 
	            }
            }, 
            quantity: { 
	             validators: {
                    notEmpty: {
                        message: 'Please enter the quantity'
                    },
                    regexp: {
                        regexp: /[1-9]/,
                        message: 'Please enter number only'
                    } 
                }
            }, 
            
        },
        submitHandler: function (validator, form, submitButton) {
             $("#btn_submit").attr("disabled", true);
        }
    }).on('success.form.bv', function (e) {
        // Prevent form submission
        e.preventDefault(); 
		var form = $('#form-validation')[0];  
        var data = new FormData(form); 
        save(data);

    });


    

});
  

var serializeData = [];
// Own script started  
function save(data) { 
	 $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: BASE_URL+"/lead/save_lead",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            success: function (data) { 
            	var result = JSON.parse(data);
            	if(result['success']){
	            		swal({
			            title: "Success",
			            text: result['msg'],
			            type: "success",
			            confirmButtonColor: "#66cc99"
			        }).then(function() {
			            location.href = BASE_URL+'/lead/list';
			        });
            	}
            },
            error: function (e) { 
 
            }
        });
}

function is_check(e){
	if($(e).prop('checked')) copy_billing_address();
	else clear_shipping_input();
}
 function clear_shipping_input(){
	$('#shipping_address').val('');
	$('#shipping_city').val('');
	$('#shipping_pincode').val('');
	$('#shipping_contact_no').val('');
 }
function copy_billing_address(){
	var chk_status = $('#chk_copy_address').prop('checked');
	if(chk_status == true){ 
		$('#shipping_address').val($('#billing_address').val().trim());
		$('#shipping_city').val($('#billing_city').val().trim());
		$('#shipping_pincode').val($('#billing_pincode').val().trim());
		$('#shipping_contact_no').val($('#billing_contact_no').val().trim());
	}

}
$('.bill').on('keydown',function(){ 
	copy_billing_address(); 
});
function resetInput(){
    $.each($('form'),function() { 
         $(this)[0].reset();
         $(this).closest('.row').hide();
    });
}

