let _token = ($("input[name=_token]").val()) ?  $("input[name=_token]").val() : '';


/*			@@ Common push notification  @@		*/
function notify(type='info',title='Info',msg=''){
 new PNotify({
    title: title,
    text: msg,
    type: type, 
    hide: true,
    buttons: {
            closer: true,
            sticker: false
        },
    });
}

/*			@@ Common Ajax Call function @@		*/
var doAjax_params_default = {
    'url': null,
    'requestType': "GET",
    'contentType': 'application/x-www-form-urlencoded; charset=UTF-8',
    'dataType': 'json',
    'data': {},
    'beforeSendCallbackFunction': null,
    'successCallbackFunction': null,
    'completeCallbackFunction': null,
    'errorCallBackFunction': null,
};
function doAjax(doAjax_params) {

    var url = doAjax_params['url'];
    var requestType = doAjax_params['requestType'];
    var contentType = doAjax_params['contentType'];
    var dataType = doAjax_params['dataType'];
    var data = doAjax_params['data'];
    var beforeSendCallbackFunction = doAjax_params['beforeSendCallbackFunction'];
    var successCallbackFunction = doAjax_params['successCallbackFunction'];
    var completeCallbackFunction = doAjax_params['completeCallbackFunction'];
    var errorCallBackFunction = doAjax_params['errorCallBackFunction'];

    //make sure that url ends with '/'
    /*if(!url.endsWith("/")){
     url = url + "/";
    }*/

    $.ajax({
        url: url,
        crossDomain: true,
        type: requestType,
        contentType: contentType,
        dataType: dataType,
        data: data,
        beforeSend: function(jqXHR, settings) {
            if (typeof beforeSendCallbackFunction === "function") {
                beforeSendCallbackFunction();
            }
        },
        success: function(data, textStatus, jqXHR) {    
            if (typeof successCallbackFunction === "function") {
                successCallbackFunction(data, textStatus, jqXHR);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            if (typeof errorCallBackFunction === "function") {
                errorCallBackFunction(jqXHR, textStatus, errorThrown);
            }

        },
        complete: function(jqXHR, textStatus) {
            if (typeof completeCallbackFunction === "function") {
                completeCallbackFunction();
            }
        }
    });
}

/*			@@ Drop down box generation @@		*/	
function dropdownBox(selector='',data=[],activeId=''){  
	var opt = '<option value="">-Select-</option>';
	$.each(data,function(i,j){
		var selected = (j['id'] == activeId) ? 'selected' : '';
		opt += '<option value="'+j['id']+'" '+selected+'>'+j['value']+'</option>';
	});
	$(selector).html(opt);
} 