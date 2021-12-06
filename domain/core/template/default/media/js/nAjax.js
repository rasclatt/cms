/*
** @description This is the main ajax engine
*/
class nAjax {
	constructor() {
		this.useUrl = '/index.php';
		this.type = 'post';
		this.doBeforeAttr;
		this.func;
		this.dataObj;
	}
	/*
	** @description Allows for passing of data to this object 
	*/
	useDataObj() {
		var getArgs = arguments;
		this.dataObj = getArgs[0];
		return this;
	}
	/*
	** @description Allows a toggle to switch on error reporting
	*/
	useErrors(val) {
		error_reporting = (!empty(val)) ? val : false;
	}
	/*
	** @description Allows for sending via $_POST or $_GET
	*/
	useMethod(val) {
		this.type = val;
		return this;
	}
	/*
	** @description Allows the dispatch url to be diverted to a new one
	*/
	setUrl(URL) {
		this.useUrl = URL;
		return this;
	}
	/*
	** @description Adds a beforesend anonymouse function that fires on commencment of ajax
	*/
	doBefore(func) {
		this.doBeforeAttr = func;
		return this;
	}
	/*
	** @description Runs the ajax
	** @param data [object] This is the data that will be sent to the dispatch
	** @param func [func] This is the anonymous function that will run on the return
	*/
	ajax(data, func, isFormData) {
		// Create a data object
		var ajaxDataObj = {};
		// Create dispatch url
		ajaxDataObj.url = this.useUrl;
		// Save type
		ajaxDataObj.type = this.type;
		// Assign data
		ajaxDataObj.data = data;
		// Fetch a token
		if (typeof ajaxDataObj.data.jwtToken === "undefined")
			ajaxDataObj.data.jwtToken = getCsrfToken();
		// Add a doBefore if set
		if (!empty(this.doBeforeAttr)) {
			ajaxDataObj.beforeSend = this.doBeforeAttr;//this.doBefore();
		}
		// If this is set as a formData Obj, create prefs
		if (isFormData) {
			ajaxDataObj.processData = false;
			ajaxDataObj.contentType = false;
		}
		// Create the success function
		ajaxDataObj.success = function (response) {
			// See if the object is set
			if (!empty(this.dataObj)) {
				// Pass on the response data
				eEngine.addData('ajax_response_before', response);
				// Run the event point
				setEventPoint('ajax_response_before', false, this.dataObj, false, $);
			}
			// Run the default function after response
			func(response);
		};
		// Set error function
		ajaxDataObj.error = function (response) {
			if (!empty(this.dataObj)) {
				// Pass on the response data
				eEngine.addData('ajax_response_error', response);
				// Run the event point
				setEventPoint('ajax_response_error', false, this.dataObj, false, $);
			}
		};
		// Run the ajax
		$.ajax(ajaxDataObj);

		return this;
	}

	formData(obj, func) {
		try {
			// Save form to formdata
			var formData = new FormData(obj);
			// Save form to jQuery obj
			var findForm = $(obj);
			// Get the form instructions
			var thisInstr = findForm.data('instructions');
			// Find the file input
			var FileInput = findForm.find("input[type=file]");
			// Assign the loader dropzone
			var thisLoader = $("#nbr_loader");
			// Get the url from the form
			var ajaxURL = this.useUrl;//(isset(thisInstr,'action'))? thisInstr.action : 'nbr_general_form_data';
			// Get the message(s) if there are any
			var msgObj = findForm.find('input[name=nbr_msg]').val();
			// Parse the messages
			var msgVal = (!empty(msgObj)) ? JSON.parse(msgObj) : { success: "Success", fail: "Failed" };
			var uSuccess = msgVal.success;
			var uFail = msgVal.fail;
			// Set default message
			var defMsg = {
				invalid: uFail,
				empty: 'File cannot be empty'
			};
			// Assign default response
			var response = {};
			var sendBack;
			this.setResp = sendBack;
			var thisDisp = this;

			this.doBefore(function () {
				if (!empty(thisLoader)) {
					thisLoader.html(thisDisp.doBefore(''));
				}
				// Overwrite itself
				FileInput.replaceWith(FileInput.clone(true));
			});
			this.ajax(formData, func, true);
		}
		catch (Exception) {
			console.log(Exception.message);
		}
		return this;
	}
}