"use strict";
$(document).ready(function () {

// bootstrap wizard//
 
    $("#runnerform").bootstrapValidator({
        fields: {
            username: {
                validators: {
                    notEmpty: {
                        message: 'The User name is required'
                    }
                },
                required: true,
                minlength: 3
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'The password is required'
                    },
                    different: {
                        field: 'first_name,last_name',
                        message: 'Password should not match user Name'
                    }
                }
            },
            confirm: {
                validators: {
                    notEmpty: {
                        message: 'Confirm Password is required'
                    },
                    identical: {
                        field: 'password'
                    },
                    different: {
                        field: 'first_name,last_name',
                        message: 'Confirm Password should match with password'
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
            firstname: {
                validators: {
                    notEmpty: {
                        message: 'The first name is required '
                    }
                }
            },
            lastname: {
                validators: {
                    notEmpty: {
                        message: 'The last name is required '
                    }
                }
            },
            password3: {
                validators: {
                    notEmpty: {
                        message: 'This field is required and mandatory'
                    }
                },
                required: true,
                minlength: 3
            },
          
            phone: {
                validators: {
                    notEmpty: {
                        message: 'The home number is required'
                    },
                    regexp: {
                        regexp: /^\d{10}$/,
                        message: 'Enter valid phone number'
                    }
                }
            },
            
			city: {
                validators: {
                    notEmpty: {
                        message: 'The city is required '
                    }
                }
            },
            state: {
                validators: {
                    notEmpty: {
                        message: 'The state is required '
                    }
                }
            },
			
			  postalcode: {
                validators: {
                    notEmpty: {
                        message: 'The postalcode is required '
                    },
					 regexp: {
                        regexp: /^\d{6}$/,
                        message: 'Enter valid phone number'
                    }
                }
            }
        }
    });
    
    $('#runnerwizard').bootstrapWizard({
        'tabClass': 'nav nav-pills',
        'onNext': function (tab, navigation, index) {
            var $validator = $('#runnerform').data('bootstrapValidator').validate();
            return $validator.isValid();
        },
        onTabClick: function (tab, navigation, index) {
            return false;
        },
        onTabShow: function (tab, navigation, index) {
            var $total = navigation.find('li').length;
            var $current = index + 1;
            var $percent = ($current / $total) * 100;

            $("#runnerwizard .nav-link.active").closest("li:nth-child("+$current+")").addClass("active");
            var x= $current-1;
            $(".nav-item").closest("li:nth-child("+x+")").removeClass("active");
            $(".nav-item:nth-child("+x+") a").removeClass("active");

            // If it's the last tab then hide the last button and show the finish instead
            var root_wizard = $('#runnerwizard');
            if ($current >= $total) {
                root_wizard.find('.pager .next').hide();
                root_wizard.find('.pager .finish').show();
                root_wizard.find('.pager .finish').removeClass('disabled');
            } else {
                root_wizard.find('.pager .next').show();
                root_wizard.find('.pager .finish').hide();
            }
            root_wizard.find('.finish').click(function () {
				
                var $validator = $('#runnerform').data('bootstrapValidator').validate();
                if ($validator.isValid()) {
					serializeData = $('#runnerform').serializeArray();
					serializeData.push({ name: "role", value: 2 });
                    save();
                    return $validator.isValid();
                   // root_wizard.find("a[href='#tab1']").tab('show');
                }
            });

        }
    });
     

    $('input[type="checkbox"].custom-checkbox, input[type="radio"].custom-radio').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue',
        increaseArea: '20%'
    });

// bootstrap wizard 2


    var navListItems = $('div.setup-card div a'),
        allWells = $('.setup-content'),
        allNextBtn = $('.nextBtn'),
        allPrevBtn = $('.prevBtn');

    allWells.hide();

    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
            $item = $(this);

        if (!$item.hasClass('disabled')) {
            navListItems.removeClass('btn-primary').addClass('btn-default');
            $item.addClass('btn-primary');
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });

    allNextBtn.click(function () {
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-card div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
            curInputs = curStep.find("input[type='text'],input[type='url']"),
            isValid = true;

        $(".form-group").removeClass("has-error");
        for (var i = 0; i < curInputs.length; i++) {
            if (!curInputs[i].validity.valid) {
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
            }
        }

        if (isValid)
            nextStepWizard.removeAttr('disabled').trigger('click');
    });

    allPrevBtn.click(function () {
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            prevStepWizard = $('div.setup-card div a[href="#' + curStepBtn + '"]').parent().prev().children("a");

        $(".form-group").removeClass("has-error");
        prevStepWizard.removeAttr('disabled').trigger('click');
    });

    $('div.setup-card div a.btn-primary').trigger('click');


    $("a[disabled='disabled']").removeAttr("disabled");
});