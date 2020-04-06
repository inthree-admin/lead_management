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
            // alter_mobile: {
            //     validators: { 
            //         regexp: {
            //             regexp: /[2-9]{2}\d{8}/,
            //             message: 'The alternate number can only consist of numbers'
            //         },
            //          stringLength: {
	        //             min: 10,
	        //             max: 10,
	        //             message: 'The number must be between 10 digit'
	        //         }
            //     }
            // },
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
 			// billing_contact_no: {
            //     validators: {
            //         notEmpty: {
            //             message: 'Please enter the contact no'
            //         },
            //         regexp: {
            //             regexp: /[2-9]{2}\d{8}/,
            //             message: 'Please enter number only'
            //         },
            //          stringLength: {
	        //             min: 10,
	        //             max: 10,
	        //             message: 'The number must be between 10 digit'
	        //         }
            //     }
            // },
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
 			// shipping_contact_no: {
            //     validators: {
            //         notEmpty: {
            //             message: 'Please enter the contact no'
            //         },
            //         regexp: {
            //             regexp: /[2-9]{2}\d{8}/,
            //             message: 'Please enter number only'
            //         },
            //          stringLength: {
	        //             min: 10,
	        //             max: 10,
	        //             message: 'The number must be between 10 digit'
	        //         }
            //     }
            // },
            order_type: {
                validators: {
                    notEmpty: {
                        message: 'Please select order type'
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
    	if($('.plist_error').length > 0) {
    		 $("#btn_submit").attr("disabled", false);
    		return false;	
    	}
        // Prevent form submission
        var cust_name = $('#cust_name').val().trim(); 
         swal({
            title: 'Hi '+cust_name,
            text: 'Are you sure Want to place your order?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: "#66cc99",
            cancelButtonColor: '#ff6666',
            confirmButtonText: 'Yes',
            cancelButtonText: 'cancel',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger'
        }).then(function (conrifm) {
        	if(conrifm['value'] == true){
        		e.preventDefault();  
        		var form = $('#form-validation')[0];  
		        var data = new FormData(form); 
		        save(data);
        	}else{
        		 location.reload();
        	}        	 
           
        });

		

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
$('.bill').on('change',function(){ 
    copy_billing_address(); 
});
function resetInput(){
    $.each($('form'),function() { 
         $(this)[0].reset();
         
    });
}

 

 function loadProductList(){
	var data = $.ajax({
	  url: BASE_URL+"/lead/load_products",
	  type: "POST",
	  data: {},
	  async: false,
	  success: function(data){
	      var outputData = JSON.parse(data);  
	  }
	}).responseText;
	return JSON.parse(data);;
 }
 //loading scrit on page start
 var productList = loadProductList();
 $('.delrow').hide();
var default_tr ='';
generateProductDropdown();

//----------End -----------------//
function generateProductDropdown(){
	var jsonData = productList;
	var optionElement = '<option value="">-Select-</option>';
	if(jsonData != ''){
		$.each(jsonData,function(i,j){
			optionElement += '<option data-price="'+j['prod_price']+'" value="'+j['prod_id']+'">'+j['prod_name']+'</option>';
		});
	}  
	$('#inp_product').html(optionElement);
	default_tr = '<tr>'+$('#plist').find( "tr:eq(1)" ).html()+'</tr>';
}

function appendRow() {
	var trlength = $('#plist').find('tr').length; 
	if($('#plist').find("tr:eq("+(trlength - 1)+")" ).find('select').val() != '') $('#plist tbody').append(default_tr); 
	totalCalc();
	row_number(); 
	if($('#plist').find('tr').length == 2) $('.delrow').hide();
	else $('.delrow').show(); 
	validatePlistinput();
}

function deleteRow(e) {
	var trlength = $('#plist').find('tr').length; 
	if(trlength > 2) $(e).closest('tr').remove();
	if(trlength == 2) appendRow(); 
	if($('#plist').find('tr').length == 2) $('.delrow').hide();
	else $('.delrow').show();
	validatePlistinput();
    totalCalc();
    row_number(); 
}

function row_number(){
	$.each($('#plist tbody').find('tr'),function(i,j){
		$(j).find('td:eq(0)').text(i+1);
	}); 
}

let price = 0;
let quantity = 0;
let subtotal = 0;
let total_amount = 0;

function totalCalc(){ 
	total_amount = 0;
	$.each($('#plist tbody').find('tr'),function(i,j){
		if($(j).find('td:eq(1)').find('select').val()!=''){
			price = $(j).find('td:eq(1)').find('select  option:selected').attr('data-price');
			quantity = $(j).find('td:eq(2)').find('input').val();  
			subtotal = (price * quantity).toFixed(2);
			$(j).find('td:eq(3)').text(subtotal); 
			total_amount = parseFloat(total_amount) +  parseFloat(subtotal);
			
		} 
	}); 
    $('#total_amount').text(total_amount.toFixed(2));
	validatePlistinput();
}

function validatePlistinput(){
	var trlength = $('#plist tbody').find('tr').length;
	$.each($('#plist tbody').find('tr'),function(i,j){
		if(trlength != (i+1) ){
			if($(j).find('td:eq(1)').find('select').val()==''){
			 	$(j).find('td:eq(1)').find('select').attr('class','form-control plist_error'); 
			}else{
				$(j).find('td:eq(1)').find('select').attr('class','form-control'); 
			}
			if($(j).find('td').find('input').val()==0){
				 	$(j).find('td').find('input').attr('class','form-control plist_error'); 
			}else{
				$(j).find('td').find('input').attr('class','form-control'); 
			} 
		}
		
		
	}); 
}