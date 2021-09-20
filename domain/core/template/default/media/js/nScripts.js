/*
** @copyright  Nubersoft 2021
** @permission  All rights reserved. Free to use however no permission is given to sell
**     any portion of this script.
** @Third Party All 3rd party vendors (such as jQuery) have their own terms of use and
**     are governed by their terms. Nubersoft takes no ownership of third party
**     libraries but does take ownership of the custom implementation of third
**     party libraries
*/
/*
** @description This sets up some php-like constants
*/
if (typeof SORT_NATURAL === "undefined")
	var SORT_NATURAL = true;
/*
** @description This sets up the dispatcher
*/
if (typeof nDispatch === "undefined")
	var nDispatch = $_SERVER['SCRIPT_URI'] + '/index.php';

var setActiveObjScope;
var sortActiveObjScope;
var doActionScope;
var doAutomationScope;
var default_actionScope;
// Create an automatore
var Automator = new nAutomation($);
// Create global ajax object
var AjaxEngine = new nAjax($);
// When the document is ready
jQuery(function ($) {
	var currClick;
	var doc = $(this);
	var activeObj = {};
	var activeBtn = false;
	var setInstr = false;
	var hasListener = $('.nListener');
	var getCfrsToken = getCsrfToken();
	// Runs any on-load events
	if (!empty(hasListener)) {
		$.each(hasListener, function (k, v) {
			setInstr = $(v).data('instructions');
			setInstr.jwtToken = getCfrsToken;
			AjaxEngine.useDataObj(setInstr);
			doAutomation(activeBtn, sortActiveObj(setInstr, nDispatch), true);
		});
	}
	doc.on('click', '.canceller', function (e) {
		e.preventDefault();
	});
	doc.on('click', '.nScroll', function () {
		var getInstr = $(this).data('instructions');
		getInstr.jwtToken = getCfrsToken;

		if (!isset(getInstr, 'scrollto'))
			return false;

		var nScroller = new nScroll();
		nScroller.clickScroll(getInstr.scrollto);
	});
	// When event happens
	doc.on('click keyup change mouseover mouseout', '.nTrigger,.nDom,.nListener,.nKeyUp,.nChange,.nRollOver,.imModal', function (e) {
		// Create Base Automator
		Automator.go(e, $(this));
		// Fetch current clicker
		if (Automator.getAttr('target_type') == 'click')
			currClick = Automator.getAttr('current_click');
		// Assign the current active button object
		activeBtn = Automator.getActiveButton();
		// Parse instructions from the target
		setInstr = Automator.getInstructions();
		// Do the modal action
		if ($(this).hasClass('nTrigger') && Automator.getAttr('target_type') == 'click') {
			Automator.doModal();
		}
	});

	doc.on('click keyup change', '.nTrigger,.nDom,.nListener,.nKeyUp,.nChange', function (e) {
		// Get the attribute action
		var aTypeSet = e.type;
		// If click and is trigger
		if (aTypeSet == 'click' && activeBtn.hasClass('nTrigger')) {
			// Run the loader
			runLoader(setInstr, $);
			// Create the instruction list
			activeObj = setActiveObj(activeBtn, e, nDispatch);
			// If the button contains a copy mechanism, run that
			if (isset(activeObj.instr, 'copy_text')) {
				// Loop through the container array
				$.each(activeObj.instr.copy_text, function (k, v) {
					// Get the object from the value
					var writeToObj = $(v);
					// If the key value is a number (array), the copy the text to a text 
					if (typeof k === "number")
						writeToObj.text(activeObj.thisObj.text());
					// If the key value is a string (object), then copy the text to a value (form input)
					else
						writeToObj.val(activeObj.thisObj.text());
				});
			}
			else if (isset(activeObj.instr, 'copy_value')) {

			}

			if (!isset(activeObj.instr, 'noauto')) {
				doAutomation(activeBtn, activeObj);
			}
		}

		if (aTypeSet == 'change' && activeBtn.hasClass('nChange')) {
			runLoader(setInstr, $);
			doEventAction(activeBtn, nDispatch);
		}

		if (aTypeSet == 'keyup' && activeBtn.hasClass('nKeyUp')) {
			runLoader(setInstr, $);
			doEventAction(activeBtn, nDispatch);
		}
	});

	doc.on('submit', '.nbr_ajax_form', function (e) {
		e.preventDefault();
		var thisForm = $(this);
		var sAjax = AjaxEngine;
		var getInstr = setActiveObj(thisForm, e, nDispatch);
		// Combine data
		getInstr.packet.deliver = $.extend(getInstr.packet.deliver, {
			formData: thisForm.serialize() + '&click_action=' + ((is_object(currClick)) ? currClick.val() : 'NULL')
		});
		// Save instructions to data
		AjaxEngine.useDataObj(getInstr);
		// Run the automator
		doAutomation(activeBtn, getInstr, false);
	});
	// Create scrolling
	var nScroller = new nScroll();
	// Create instance
	nScroller.init().defAnimation();
	// Create a clickscroller
	nScroller.clickScroller('.scroll-top');

	/*
	 ** Get's tokens for the login form
	 */
	fetchAllTokens($);
	/*
	 ** Allows the component to be draggable
	 */
	$('.dragonit').draggable({
		"cancel": ".nodrag"
	});
	var getDisabled = $('.disabled-submit');
	if (!empty(getDisabled)) {
		$.each(getDisabled, function (k, v) {
			if (!$(v).hasClass('token_button'))
				$(v).attr('disabled', false);
		});
	}
	// Cancel the loadspot modal
	$(this).on("keyup", function (e) {
		// First check is clicked
		if (e.keyCode == 27) {
			// Automatically reverse body
			subFxtor('rOpacity', $('body'));
			// Get the value
			var getModal = $("#loadspot_modal");
			// If it has content overwrite it
			if (!empty(getModal.html())) {
				getModal.fadeOut();
				//getModal.html('');
			}
		}
	});

	$('textarea.tabber').on('click', function () {
		var countRows = ($(this).val()).split("\n");
		$(this).attr('rows', countRows.length);
	});
	/**
	 * @description Expand a div out to borders
	 */
	$(this).on('click', '.expander', function () {
		let thisExpander = $(this).data('acton');
		let thisParent = $(this).parents('.item-container-editor-code');

		if (thisParent.length == 0)
			thisParent = $(this).parents('.item-container-editor-code_cached');

		let thisExpanderParent = thisParent.find(thisExpander);
		$(this).parents('.component-container').find('.expander').replaceWith('');
		$(this).replaceWith('');
		thisParent.find('.component-editor').addClass("expand-out");
		thisExpanderParent.addClass("expand-out").find('textarea').css({ "min-height": "400px" });
		thisExpanderParent.find('.component-wrap').css({
			"max-height": "none",
			"height": "auto",
			"overflow": "auto"
		});
		$('#admin-menubar').hide();
	});

	$(this).on('click', '.close-btn', function () {
		$('.expander').show();
		$('.component-container').removeClass('expand-out');
		$('.component-editor').removeClass("expand-out");
		$('#admin-menubar').show();
	});

	$(this).on('click', '.ajax-save', function (e) {
		e.preventDefault();
		AjaxEngine.formData($(this).parents('.component-editor-form')[0], function (response) {
			default_action($(this), response);
		});
	});

	$(this).on('click', '.admin-menu > img', function () {
		var thisAdminBtn = $(this).next();
		thisAdminBtn.css({ "display": ((thisAdminBtn.is(":visible")) ? "none" : "flex") });
	});

	autoHeightTextArea();
});