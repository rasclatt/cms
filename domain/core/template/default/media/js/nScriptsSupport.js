// Create instance of the self-event engine
eEngine = new nEventer();

function autoHeightTextArea()
{
	let ta = $('textarea');
	if (ta.length == 0)
		return false;

	$.each(ta, (k, v) => {
		let h = 25 * $(v).val().split('\n').length;
		if (h < 300)
			h = 300;
		$(v).height(h);
	});
}
/*
** PHP-like functions
*/
function Exception(val, code)
{
	var eMessage = (typeof val === "undefined") ? "Unknown error occurred" : val;
	var eCode = (typeof code === "undefined") ? "000" : code;
	this.getMessage = function () {
		return eMessage;
	}
	this.getErrorCode = function () {
		return eCode;
	}
}
/*
** @description Runs a simple loader
*/
function runLoader(getWhileLoad, $) 
{
	if (isset(getWhileLoad, 'load_into')) {
		var loadIntoObj = $(getWhileLoad.load_into);
		var getWhileMessage = (isset(getWhileLoad, 'loader')) ? getWhileLoad.loader : 'LOADING...';

		if (loadIntoObj.length > 1) {
			$.each(loadIntoObj, function (k, v) {

				if (is_array(getWhileMessage))
					$(v).html(getWhileMessage[k]);
				else
					$(v).html(getWhileMessage);
			});
		}
		else
			loadIntoObj.html(getWhileMessage);
	}
}
/*
** @description This will run a custom event based on location event name
*/
function setEventPoint(eventSpace, targetType, obj, doc, $)
{
	eventSpace = (!empty(eventSpace)) ? eventSpace : 'onload_event_before';

	if (!isset(obj, 'nEvents'))
		return false;
	else if (!is_object(obj.nEvents))
		return false;
	else if (empty(eEngine.hasSpace(eventSpace)))
		return false;
	// If there are events in this scope, run them
	$.each(obj.nEvents[eventSpace], function (k, v) {
		eEngine.getEvent({
			'name': eventSpace,
			'use': k
		}, v, targetType, obj, doc);
	});
}
function fetchAllTokens($)
{
	var nProcIdInput = $("input[name=token\\[nProcessor\\]]");
	var nLoginInput = $("input[name=token\\[login\\]]");
	var isActive = {
		"login": (nLoginInput.length > 0),
		"nProcessor": (nProcIdInput.length > 0)
	};

	if (isActive.login || isActive.nProcessor) {
		// Get the current form
		var getFormObj = nLoginInput.parent('form').children('.token-activate');
		if (!empty(getFormObj)) {
			// Disable the submit button
			getFormObj.prop('disabled', true);
		}
		var nProcId;
		// Create Ajax object
		sAjax = new nAjax($);
		sAjax.ajax({
			action: "nbr_get_form_token",
			jwtToken: (typeof csrf !== "undefined") ? csrf : false,
			"data": {
				"nProcessor": nProcIdInput.val(),
				"login": nLoginInput.val()
			}
		},
			(response) => {
				try {
					var tokenFormData = (typeof response === "string") ? JSON.parse(response) : response;
					// Populate the nProcessor token
					if (isActive.nProcessor) {
						// Fill the value
						nProcIdInput.val(tokenFormData.nProcessor);
						// Get the login form button
						var getLoginButton = $('.token_button');
						// See if the token is availble
						var getDataName = getLoginButton.data('token');
						// If it's nProcessor, unlock the form
						if (!empty(getDataName) && getDataName == 'nProcessor') {
							getLoginButton.prop('disabled', false);
						}
					}

					if (isActive.login) {
						nLoginInput.val(tokenFormData.login);
						getFormObj.prop('disabled', false);
						var getLoginButton = $('.token_button');
						var getDataName = getLoginButton.data('token');
						if (!empty(getDataName) && getDataName == 'login') {
							getLoginButton.prop('disabled', false);
						}
					}
				}
				catch (Exception) {
					console.log([
						Exception.message,
						response
					]);
				}
			});
	}
}
/*
** @description Required on an immediate effect. Checks if the event is a click, mouseover, etc
*/
function hasEventList(setInstr, targetType)
{
	// If there is an event and it has values
	if (!is_array(setInstr.events))
		return false;
	// Assign array
	var hasEvents = setInstr.events;
	// See if the target is in the array, if not stop
	if (!in_array(hasEvents, targetType))
		return false;

	return true;
}
function sortActiveObj(Obj, nDispatch)
{
	var Sorted = {};
	Sorted.target = false;
	Sorted.thisObj = false;
	Sorted.instr = (typeof Obj === "object") ? Obj : {};
	Sorted.id = (isset(Obj, 'id')) ? Obj.id : false;
	Sorted.class = (isset(Obj, 'class')) ? Obj.class : false;
	Sorted.packet = {
		action: ((isset(Sorted.instr, 'action')) ? Sorted.instr.action : false),
		sendto: ((isset(Sorted.instr, 'data') && isset(Sorted.instr.data, 'sendto')) ? Sorted.instr.data.sendto : false),
		html: ((isset(Sorted.instr, 'data') && isset(Sorted.instr.data, 'html')) ? Sorted.instr.data.html : false),
		donext: ((isset(Sorted.instr, 'data') && isset(Sorted.instr.data, 'donext')) ? Sorted.instr.data.donext : false),
		deliver: ((isset(Sorted.instr, 'data') && isset(Sorted.instr.data, 'deliver')) ? Sorted.instr.data.deliver : false),
		fx: ((isset(Sorted.instr, 'data') && isset(Sorted.instr.data, 'fx')) ? Sorted.instr.data.fx : false),
		acton: ((isset(Sorted.instr, 'data') && isset(Sorted.instr.data, 'acton')) ? Sorted.instr.data.acton : false),
		ajax_disp: ((isset(Sorted.instr, 'data') && isset(Sorted.instr.data, 'ajax_disp')) ? Sorted.instr.data.ajax_disp : nDispatch),
		ajax_func: ((isset(Sorted.instr, 'data') && isset(Sorted.instr.data, 'ajax_func')) ? Sorted.instr.data.ajax_func : false)
	}
	if (Sorted.instr && Object.keys(Sorted.instr).length > 0) {
		jQuery.each(Sorted.instr, function (k, v) {
			if (k != 'data' && k != 'deliver') {
				if (!isset(Sorted.packet, k)) {
					switch (v) {
						case ('false'):
							Sorted.packet[k] = false;
							break;
						case ('true'):
							Sorted.packet[k] = true;
							break;
						default:
							Sorted.packet[k] = v;
					}
				}
			}
		});
	}
	return Sorted;
}
function setActiveObj(thisBtn, e, nDispatch)
{
	var is_jQuery = (thisBtn instanceof jQuery);
	var Obj = {};
	var useId = (is_jQuery) ? thisBtn.attr('id') : false;
	var useClass = (is_jQuery) ? thisBtn.attr('class') : false;
	Obj.thisObj = thisBtn;
	Obj.target = (typeof e === "undefined") ? false : e.target;
	Obj.instr = (is_jQuery) ? thisBtn.data('instructions') : false;
	Obj.id = (typeof useId !== "undefined") ? useId : false;
	Obj.class = (typeof useClass !== "undefined") ? useClass : false;
	Obj.packet = {
		action: ((isset(Obj.instr, 'action')) ? Obj.instr.action : false),
		sendto: ((isset(Obj.instr, 'data') && isset(Obj.instr.data, 'sendto')) ? Obj.instr.data.sendto : false),
		html: ((isset(Obj.instr, 'data') && isset(Obj.instr.data, 'html')) ? Obj.instr.data.html : false),
		donext: ((isset(Obj.instr, 'data') && isset(Obj.instr.data, 'donext')) ? Obj.instr.data.donext : false),
		deliver: ((isset(Obj.instr, 'data') && isset(Obj.instr.data, 'deliver')) ? Obj.instr.data.deliver : false),
		fx: ((isset(Obj.instr, 'data') && isset(Obj.instr.data, 'fx')) ? Obj.instr.data.fx : false),
		acton: ((isset(Obj.instr, 'data') && isset(Obj.instr.data, 'acton')) ? Obj.instr.data.acton : false),
		ajax_disp: ((isset(Obj.instr, 'data') && isset(Obj.instr.data, 'ajax_disp')) ? Obj.instr.data.ajax_disp : nDispatch),
		ajax_func: ((isset(Obj.instr, 'data') && isset(Obj.instr.data, 'ajax_func')) ? Obj.instr.data.ajax_func : false)
	}

	try {
		if (Obj.instr && Object.keys(Obj.instr).length > 0) {
			jQuery.each(Obj.instr, function (k, v) {
				if (k != 'data' && k != 'deliver') {
					if (!isset(Obj.packet, k)) {
						switch (v) {
							case ('false'):
								Obj.packet[k] = false;
								break;
							case ('true'):
								Obj.packet[k] = true;
								break;
							default:
								Obj.packet[k] = v;
						}
					}
				}
			});
		}
	}
	catch (Exception) {
		console.log([
			Exception.message,
			Obj
		]);
	}

	return Obj;
}

function doDOM(obj, targetType)
{
	var getDomInstr = obj;

	if (isset(getDomInstr.DOM, 'sendto')) {

		if (isset(getDomInstr.DOM, 'html')) {
			if (isset(getDomInstr.DOM, 'event')) {
				if (in_array(getDomInstr.DOM['event'], targetType)) {
					writeToPage(getDomInstr.DOM);
				}
			}
		}
		else {
			var getPreg = getDomInstr.DOM.sendto;
			var sInstr = explode('/', getPreg);
			var buildIt = activeBtn;
			if (sInstr.length > 1) {
				$.each(sInstr, function (k, v) {
					var getSubAct = explode('::', v);
					var useV = [];
					if (getSubAct.length > 1) {
						useV = getSubAct;
					}
					else
						useV = useV.push(v);

					switch (useV[0]) {
						case ('parents'):
							buildIt = buildIt.parents(useV[1]);
							break;
						case ('find'):
							buildIt = buildIt.find(useV[1]);
							break;
					}
				});

				if (!empty(buildIt)) {
					if (!isset(getDomInstr.DOM))
						return false;

					var bCont = (isset(getDomInstr.DOM, 'element')) ? getDomInstr.DOM.element : 'value';
					switch (getDomInstr.DOM.action) {
						case ('copyvalue'):
							(bCont == 'value') ? buildIt.val(activeBtn.val()) : buildIt.val(activeBtn.html());
							break;
						case ('copyhtml'):
							(bCont == 'value') ? buildIt.val(activeBtn.html()) : buildIt.val(activeBtn.html());
							break;
					}
				}
			}
		}
	}
}
function runAjaxObj(activeBtn, obj)
{
	var nextDisp = (isset(obj, 'ajax_disp')) ? obj.ajax_disp : nDispatch;
	var nextFunc = (isset(obj, 'ajax_func')) ? obj.ajax_func : 'default_ajax';
	var nextDoBefore = (isset(obj, 'nextDoBefore')) ? obj.nextDoBefore : false;

	doAjaxAction(activeBtn, obj, nextFunc, nextDoBefore, nextDisp);
}

function default_action(activeBtn, response, skipParse)
{
	// If the response is already an object, skip parsing
	skipParse = is_object(response);
	// If the not skipping, check if an json string is present
	if (!skipParse) {
		if (empty(preg_match("^\{|\}$", response)))
			return false;
	}
	// If there is a possible parsable string or the element is already object, continue
	try {

		var json = (skipParse) ? response : JSON.parse(response);

		if (isset(json, 'alert')) {
			alert(json['alert']);
			// Remove alert
			json['alert'] = null;
		}

		// Run page FX
		// Accepts the parent FX or children fx/acton
		if ((isset(json, 'fx') && isset(json, 'acton')) || isset(json, 'FX')) {
			// Assign the FX array
			var getParentFx = (isset(json, 'FX')) ? json.FX : json;
			// Check if there are any speed settings
			var hasSpeed = (isset(getParentFx, 'fxspeed')) ? getParentFx.fxspeed : false;
			// Run the fx engine
			doFx(getParentFx.acton, getParentFx.fx, activeBtn, hasSpeed);
		}

		if (isset(json, 'html')) {
			if (doHtmlAppend(json.html, activeBtn)) {
				writeToPage(json);
				// Run textarea resizer
				autoHeightTextArea();
			}
		}

		// Write blocks
		if (isset(json, 'htmlBlock')) {
			$.each(json.htmlBlock, function (k, v) {
				$(v.sendto).html(v.html);
			});
		}

		if (isset(json, 'input')) {
			writeToInput(json);
		}
		// Allows for multi sets of actions to take place
		if (isset(json, 'workflow')) {
			// Loop through array of workflows
			$.each(json.workflow, function (k, v) {
				// Do automation on each workflow
				doAutomation(activeBtn, sortActiveObj(v.instructions, nDispatch));
			});
		}
		// If there is a single workflow, just run here
		if (isset(json, 'instructions')) {
			var doNowPost = sortActiveObj(json.instructions, nDispatch);
			doAutomation(activeBtn, doNowPost, true);
		}

		if (typeof cfrsToken === "function")
			cfrsToken();
	}
	catch (Exception) {
		console.log([
			Exception.message,
			response
		]);
	}
}
function subFxtor(subfX, thisObj, thisSpeed)
{
	thisSpeed = (typeof thisSpeed == "undefined") ? 'slow' : thisSpeed;
	// This will try and get any acton subfx for the object 
	var thisSubFx = thisObj.data('subfx');
	var subFxData = false;

	switch (subfX) {
		case ('fadeIn'):
			thisObj.fadeIn(thisSpeed);
			return true;
		case ('fadeOut'):
			thisObj.fadeOut(thisSpeed);
			return true;
		case ('slideDown'):
			thisObj.slideDown(thisSpeed);
			return true;
		case ('slideUp'):
			thisObj.slideUp(thisSpeed);
			return true;
		case ('sideSlide'):
			/*
			** Requires acton object to supply data for it's effect:
			** <div id="whatever" data-subfx='{"sideSlide":{"speed":"1000","data":{"width":"toggle"}}}'>
			*/
			if (isset(thisSubFx, 'sideSlide')) {
				if (isset(thisSubFx.sideSlide, 'speed'))
					thisSpeed = thisSubFx.sideSlide.speed;

				if (isset(thisSubFx.sideSlide, 'data'))
					subFxData = thisSubFx.sideSlide.data;
			}
			if (!is_object(subFxData))
				return false;
			thisSpeed = (!is_numeric(thisSpeed)) ? 1000 : thisSpeed;
			thisObj.animate(subFxData, thisSpeed);
			return true;
		case ('workflow'):
			// Check if there is a matching workflow to run
			if (!isset(thisSubFx, 'workflow'))
				return false;
			// Run any CSS events
			if (isset(thisSubFx.workflow, 'css')) {
				// See if there are settings for the css method
				if (!isset(thisSubFx.workflow.css, 'data'))
					return false;
				// Use jQuery css
				thisObj.css(thisSubFx.workflow.css.data);
			}
			return true;
		case ('css'):
			// Check if there is a matching workflow to run
			if (!isset(thisSubFx, 'css'))
				return false;
			// See if there are settings for the css method
			if (!isset(thisSubFx.css, 'data'))
				return false;
			// Use jQuery css
			thisObj.css(thisSubFx.css.data);
			return true;
		case ('slideToggle'):
			thisObj.slideToggle(thisSpeed);
			return true;
		case ('addClass'):
			if (!isset(thisSubFx, 'addClass'))
				return false;

			$.each(thisSubFx.addClass, function (k, v) {
				if (!thisObj.hasClass(v))
					thisObj.addClass(v);
			});
			return true;
		case ('removeClass'):
			if (!isset(thisSubFx, 'removeClass'))
				return false;

			$.each(thisSubFx.removeClass, function (k, v) {
				if (thisObj.hasClass(v))
					thisObj.removeClass(v);
			});
			return true;
		case ('toggleClass'):
			if (!isset(thisSubFx, 'toggleClass'))
				return false;

			$.each(thisSubFx.toggleClass.data, function (k, v) {
				thisObj.toggleClass(v);
			});
			return true;
		case ('accordian'):
			if (thisObj.is(":visible"))
				thisObj.slideUp(thisSpeed);
			else
				thisObj.slideDown(thisSpeed);

			return true;
		case ('toggle'):
			if (thisObj.is(":visible"))
				thisObj.hide();
			else
				thisObj.show();
			return true;
		case ('fadeToggle'):
			thisObj.fadeToggle(thisSpeed);
			return true;
		case ('hide'):
			thisObj.hide();
			return true;
		case ('show'):
			thisObj.show();
			return true;
		case ('opacity'):
			$('html').css({ "cursor": "progress" });
			thisObj.css({ "opacity": "0.5" });
			return true;
		case ('rOpacity'):
			$('html').css({ "cursor": "default" });
			thisObj.css({ "opacity": "1.0" });
			return true;
		case ('disableToggle'):
			var getDisabledProp = (thisObj.prop("disabled")) ? false : true;
			thisObj.prop("disabled", getDisabledProp);
			return true;
		default:
			return false;
	}
}
function doFx(actOn, fx, currObj, speed)
{
	speed = (typeof speed !== "undefined") ? speed : false;
	currObj = (typeof currObj === "undefined") ? false : currObj;
	var getObjInstr = $(currObj).data('instructions');
	var hasCancel = (isset(getObjInstr, 'FX') && isset(getObjInstr.FX, 'cancel')) ? getObjInstr.FX.cancel : false;
	var eventType = ((typeof event !== "undefined") && isset(event, 'type')) ? event.type : false;

	if (!Array.isArray(actOn))
		return false;

	$.each(actOn, (k, v) => {
		// Check if there is an fx speed associated with matched array
		var setFxSpeed = (isset(speed, k)) ? speed[k] : false;
		// See if there is a cancel event key
		if (isset(hasCancel, k) && (hasCancel[k] == eventType))
			return;

		if (isset(fx, k)) {
			try {
				var runObj = fx[k];
				// Try running default fx
				var runFx = subFxtor(runObj, $(v), setFxSpeed);
			}
			catch (Exception) {
				var runFx = false;
			}
			// If no match to instruction
			if (!runFx) {
				// Try splitting
				// To create this fx use
				// {"data":{"fx":["slide"],"acton":["next::slideToggle"]}}
				var getFxInstr = explode('::', v);
				// If split is good
				if (isset(getFxInstr, 0) && isset(getFxInstr, 1)) {
					// If there is no object (false)
					if (!currObj)
						return;
					// If there is an object but not instance of jQuery
					else if (!(currObj instanceof jQuery))
						return;
					// Set the object container
					var getObj;
					// loop through what to select
					switch (getFxInstr[0]) {
						case ('next'):
							getObj = currObj.next();
							if (getObj.length == 0)
								return;
							// Try and make fx happen
							subFxtor(getFxInstr[1], getObj, setFxSpeed);
						case ('find'):
							getObj = currObj.parents('.nParent').find(getFxInstr[1]);
							if (getObj.length == 0)
								return;
							// Try and make fx happen
							subFxtor(getFxInstr[2], getObj, setFxSpeed);
						default:
							getObj = $(getFxInstr[1]);
							if (getObj.length == 0)
								return;
							// Try and make fx happen
							subFxtor(getFxInstr[2], getObj, setFxSpeed);
					}
				}
			}
		}
	});
}
function writeToPage(obj)
{
	var useHtml = (isset(obj, 'html')) ? obj.html : false;
	var useSendTo = (isset(obj, 'sendto')) ? obj.sendto : false;

	if (!useSendTo || !useHtml)
		return false;

	if (Array.isArray(useSendTo)) {
		$.each(useSendTo, function (k, v) {
			if (!Array.isArray(useHtml))
				return false;

			if (isset(useHtml, k)) {
				var getVelem = $(v);
				var getVhtml = useHtml[k];
				getVelem.html(getVhtml);
			}
		});
	}
	else {
		if (!Array.isArray(useHtml))
			$(useSendTo).html(useHtml);
	}

}
function writeToInput(obj)
{
	var useHtml = (isset(obj, 'input')) ? obj.input : false;
	var useSendTo = (isset(obj, 'sendto')) ? obj.sendto : false;

	if (!useSendTo || !useHtml)
		return false;

	if (Array.isArray(useSendTo)) {
		$.each(useSendTo, function (k, v) {
			if (!Array.isArray(useHtml))
				return false;

			if (isset(useHtml, k)) {
				var getVelem = $(v);
				var getVhtml = useHtml[k];
				getVelem.val(getVhtml);
			}
		});
	}
	else {
		if (!Array.isArray(useHtml))
			$(useSendTo).html(useHtml);
	}

}
function doAjaxAction(activeBtn, obj, ajaxFunc, doBefore, dispatcher)
{
	let AjaxEngine = new nAjax($);

	if (!empty(dispatcher) || !empty(eEngine.getData('ajax_disp'))) {
		if (!empty(eEngine.getData('ajax_disp')))
			AjaxEngine.setUrl(eEngine.getData('ajax_disp'));
		else
			AjaxEngine.setUrl(dispatcher);
	}

	if (typeof doBefore !== "undefined") {
		AjaxEngine.doBefore(doBefore);
	}

	if (typeof ajaxFunc !== "object") {
		switch (ajaxFunc) {
			default:
				AjaxEngine.ajax(obj, response => {
					default_action(activeBtn, response);
				});
		}
	}
	else {
		AjaxEngine.ajax(obj, ajaxFunc);
	}
}

function doHtmlAppend(packet, jQObj)
{
	try {
		var useInstr = {};
		if (isset(packet, 'append'))
			useInstr.append = packet.append;
		else if (isset(packet, 'prepend'))
			useInstr.prepend = packet.prepend;
		else if (isset(packet, 'insertAfter'))
			useInstr.insertAfter = packet.insertAfter;

		if (empty(useInstr.length)) {
			if (isset(jQObj, 'packet')) {
				if (isset(jQObj.packet, 'sendto') && isset(jQObj.packet, 'sendto')) {
					$.each(jQObj.packet.sendto, function (k, v) {
						$(v).html(jQObj.packet.html[k]);
					});
				}
			}

			return true;
		}

		$.each(useInstr, function (k, v) {
			if (!isset(packet, 'html'))
				return false;
			switch (k) {
				case ('append'):
					(v == 'self') ? jQObj.append(packet.html) : $(v).append(packet.html);
					break;
				case ('prepend'):
					(v == 'self') ? jQObj.prepend(packet.html) : $(v).prepend(packet.html);
					break;
				case ('insertAfter'):
					var UseElem = (v == 'self') ? jQObj : $(v);
					if (isset(packet, 'remove')) {
						if (packet.remove)
							UseElem.next().remove();
					}
					$(packet.html).insertAfter(UseElem);
					break;
			}
		});

		return true;
	}
	catch (Exception) {
		console.log([
			Exception.message,
			packet,
			jQObj
		]);
	}

	return false;
}

function doAutomation(activeBtn, activeObj, burn)
{
	burn = (typeof burn === "undefined") ? false : burn;
	try {
		// Assign actions to do now via Ajax
		var nPacket = activeObj.packet;
		var nowAction = nPacket.action;
		var nowDispatch = nPacket.ajax_disp;

		try {

			if (isset(nPacket, 'htmlBlock')) {
				$.each(nPacket.htmlBlock, function (k, v) {
					$(v.sendto).html(v.html);
				});
			}

			if (isset(nPacket, 'input')) {
				writeToInput(nPacket);
			}

			if (isset(nPacket, 'html')) {
				if (typeof nPacket.html !== "function") {
					if (nPacket.html) {
						writeToPage(nPacket);
						if (burn) {
							nPacket.html = false;
							nPacket.sendto = false;
						}
					}
				}
				else {
					doHtmlAppend(nPacket.html, activeObj);
				}
			}
		}
		catch (Exception) {
			console.log(Exception.message);
		}

		try {
			if (nowAction) {
				// Run the AJAX event
				doAjaxAction(activeBtn, nPacket, 'default_action',
					function () {
						if (isset(nPacket, 'fx')) {
							if (!empty(nPacket.fx)) {
								var nPSpeed = (isset(nPacket, 'fxspeed')) ? nPacket.fxspeed : false;
								doFx(nPacket.acton, nPacket.fx, false, nPSpeed);
							}
						}
					}, nowDispatch);
			}
		}
		catch (Exception) {
			console.log(Exception.message);
		}

		if (nPacket.donext) {
			var doNext = nPacket.donext;
			if (isset(doNext, 'action')) {
				runAjaxObj(activeBtn, doNext);
			}
		}

		try {
			if (isset(nPacket, 'fx')) {
				if (!empty(nPacket.fx)) {
					var doDefaultFx = true;
					if (isset(activeObj, 'thisObj')) {
						if (!empty(activeObj.thisObj)) {
							nPSpeed = (isset(nPacket, 'fxspeed')) ? nPacket.fxspeed : false;
							doDefaultFx = false;
							doFx(nPacket.acton, nPacket.fx, activeObj.thisObj, nPSpeed);
						}
					}
					if (doDefaultFx) {
						doFx(nPacket.acton, nPacket.fx, false);
					}
				}
			}
		}
		catch (Exception) {
			console.log(Exception.message);
		}
	}
	catch (Exception) {
		console.log(Exception.message);
	}
}
function doEventAction(activeBtn, nDispatch)
{
	// Searches for the parent wrapper that contains instructions
	var thisParent = activeBtn.parents('.nKeyUpActOn');

	if (empty(thisParent)) {
		thisParent = activeBtn.parents('.nForm');
	}
	// Get the instructions
	var thisData = thisParent.data('instructions');
	// Process the instructions
	var thisPacket = sortActiveObj(thisData, nDispatch);

	runLoader(thisData, jQuery);

	if (get_dom_type(thisParent) == 'FORM') {
		var serializedData = thisParent.serialize();
		// !****** DUPLICATE OF SUBMIT **********! //
		// Combine data
		// Create a delivery package of the typing values
		thisPacket.packet.deliver = {
			form: serializedData
		};
		// Set the target as the current acting object
		thisPacket.target = activeBtn;
		// Run the automation
		doAutomation(activeBtn, thisPacket, false);
	}
	else {
		// Create a delivery package of the typing values
		thisPacket.packet.deliver = {
			keyvalue: activeBtn.val(),
			keyfield: activeBtn.attr('name')
		};
		// Set the target as the current acting object
		thisPacket.target = activeBtn;
		// Run the automation
		doAutomation(activeBtn, thisPacket, false);
	}
}
function runWorkflow_FX(activeBtn, targetType, setInstr, doc, $)
{
	if (isset(setInstr, 'FX')) {
		// Checks if the item has an event
		if (isset(setInstr, 'events')) {
			if (!hasEventList(setInstr, targetType))
				return false;
		}
		else if ((targetType == 'mouseout' || targetType == 'mouseover') && !activeBtn.hasClass('nRollOver'))
			return false;
		// Run event here
		setEventPoint('onload_fx_before', targetType, setInstr, doc, $);
		// Run the fx if there is an acton array
		if (isset(setInstr.FX, 'acton') && isset(setInstr.FX, 'fx')) {
			var thisFxData = setInstr.FX;
			var thisFxSpeed = (isset(thisFxData, 'fxspeed')) ? thisFxData.fxspeed : false;
			doFx(thisFxData.acton, thisFxData.fx, activeBtn, thisFxSpeed);
			// Run success fx event
			setEventPoint('onload_fx_success', targetType, setInstr, doc, $);
		}
		// Run after fx event
		setEventPoint('onload_fx_after', targetType, setInstr, doc, $);
	}
}
function runWorkflow_DOM(targetType, setInstr, doc, $)
{
	if (isset(setInstr, 'DOM')) {
		// Run a before event
		setEventPoint('onload_dom_before', targetType, setInstr, doc, $);
		doDOM(setInstr, targetType);
		// Run an after event
		setEventPoint('onload_dom_after', targetType, setInstr, doc, $);
	}
}
function runWorkflow_HTML(activeBtn, targetType, setInstr, skip)
{
	//skip = (empty(skip))? false : true;
	if (isset(setInstr, 'html')) {
		if (!hasEventList(setInstr, targetType))
			return false;
		default_action(activeBtn, setInstr);
	}
}
function runWorkflow_DEFAULT(activeBtn, setInstr, skip)
{
	skip = (empty(skip)) ? false : true;
	default_action(activeBtn, setInstr, skip);
}
function getCsrfToken()
{
	return (typeof csrf !== "undefined") ? csrf : false;
}