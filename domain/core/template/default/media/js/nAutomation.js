class nAutomation
{
    constructor()
    {
         this.eventObj =
		 this.AjaxObj =
		 this.lastCloneElem =
		 this.currentRollElem =
		 this.activeClone =
		 this.currClick =
		 this.mouseAction =
		 this.targetType =
		 this.activeBtn =
		 this.setInstr = false;
	     this.activeObj = {};
        // This is a reporting setting. true will show the wrap up message if proper reporting on
         this.wrapReport = true;
    }
    
    getActiveButton()
    {
		return  this.getAttr('active_button');
	}
    
    getActiveObj()
    {
		return  this.getAttr('active_object');
	}

	getInstructions()
    {
		return  this.getAttr('instructions');
	}

	getAttr(obj)
    {
		switch (obj) {
			case ('active_button'):
				return  this.activeBtn;
			case ('active_object'):
				return  this.activeObj;
			case ('instructions'):
				return  this.setInstr;
			case ('event_type'):
				return  this.targetType;
			case ('last_clone_element'):
				return  this.lastCloneElem;
			case ('current_rollover_element'):
				return  this.currentRollElem;
			case ('active_clone'):
				return  this.activeClone;
			case ('current_click'):
				return  this.currClick;
			case ('mouse_action'):
				return  this.mouseAction;
			case ('target_type'):
				return  this.targetType;
		}

		return false;
	}

	go(e, obj)
    {
		this.eventObj = e;
		var doc = $(document);
		// Saves the event type (click,mouseout,mouseover,etc.)
		 this.targetType =  this.eventObj.type;
		// Check if target is annoying type
		 this.mouseAction = ( this.targetType == 'mouseover' ||  this.targetType == 'mouseout');
		if ( this.targetType == 'click')
			 this.currClick = obj;
		// Assign the current active button object
		 this.activeBtn = obj;
		// Clone the current object
		//!!-- SHOULD BE CONSIDERED ON WHEN AND HOW --!!
		if (empty( this.activeClone)) {
			// Clone current element
			 this.activeClone =  this.activeBtn.clone(true);
		}
		// Parse instructions from the target
		 this.setInstr =  this.activeBtn.data('instructions');
		 this.setInstr.jwtToken = getCsrfToken();
		// Create Ajax element
		 this.AjaxObj = new nAjax();
		// Save the current instance to data for Ajax
		 this.AjaxObj.useDataObj( this.setInstr);
		// Create an event action here
		setEventPoint('onload_event_before',  this.targetType,  this.setInstr, doc, $);
		// If there is an FX, run that
		runWorkflow_FX( this.activeBtn,  this.targetType,  this.setInstr, doc, $);
		// If there is a DOM event, run that
		runWorkflow_DOM( this.targetType,  this.setInstr, doc, $);
		// Do an automation
		runWorkflow_HTML( this.activeBtn,  this.targetType,  this.setInstr);
		// If there is a rollover element
		if ( this.activeBtn.hasClass('nRollOver')) {
			// If there are notes
			if (isset( this.setInstr, 'note')) {
				// Clone the current element
				 this.currentRollElem = $( this.activeBtn).clone();
				// If mouse over
				if (e.type == 'mouseover') {
					var hasDivClass = (isset( this.setInstr, 'note_class')) ? ' class="' +  this.setInstr.note_class + '"' : '';
					// Create inner element from item
					 this.cloneRollElem =  this.activeBtn.html() + '<div' + hasDivClass + '>' +  this.setInstr.note + '</div>';
					// Replace
					$( this.activeBtn).html( this.cloneRollElem);
					// Assign old for mouse out
					 this.lastCloneElem =  this.currentRollElem;
				}
				else {
					// Reset the element
					$( this.activeBtn).replaceWith( this.lastCloneElem);
				}
			}
			else {
				if ( this.targetType == 'mouseout') {
					default_action( this.activeBtn, { "instructions":  this.setInstr });
				}

			}

			return self;
		}
		/*
		** @description Create a click event
		*/
		setEventPoint('onload_event_after',  this.targetType,  this.setInstr, doc, $);
	}
    
    doModal(func)
    {
		if (empty( this.setInstr))
			return self;
		if (isset( this.setInstr, 'eventOpts')) {
			if (isset( this.setInstr.eventOpts, 'stop')) {
				if ( this.setInstr.eventOpts.stop === true)
					 this.eventObj.preventDefault();
			}
		}
		if (typeof func === "function") {
			func(self);
		}
		else {
			if (isset( this.setInstr, 'action')) {
				if ( this.setInstr.action == 'nbr_open_modal') {
					var modal = $('#loadspot_modal');
					modal.addClass('visible');
				}
			}
		}
	}
};