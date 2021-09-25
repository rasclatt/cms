class nEventer
{
    /*
    ** @param	Allow custome events to run
    ** 			Browser Automation JSON:
    ** 			"nEvents":{"onload_event_before":{"butter":["#222"]},"click":{"butt":["#FFF"]}}
    ** 			Browser Add Event:
    **
    **			eEngine.addEvent({
    **				'name':'onload_event_before',
    **				'use':'butter'
    **			},function() {
    **				if(arguments[1] != 'click')
    **					return false;
    **			});
    */
    constructor()
    {
        this.eventObj =
        this.dataObj =	{};
    }
	/*
	** @description Adds anonymous functions to populate the object
	** @param data	This is the name of the event that will be saved
	**				requires {use:whatever,name:whatever}
	** @param func	This is the anonymous function associated with this object
	*/
	addEvent(data, func)
	{
		data.name	=	(!empty(data.name))? data.name : 'onload_event_before';
		// Don't create event if the space and name are empty
		if(empty(data.use))
			return this;
		// Save to load space
		if(typeof this.eventObj[data.name] === "undefined") {
			this.eventObj[data.name]	=	{};
		}

		this.eventObj[data.name][data.use]	=	func;
		return this;
	}
	/*
	** @description	Runs the event if it exists
	** @param	data	This is the name of the event that will be recalled,
	**					requires {space:whatever,name:whatever}
	** @param	vars	This is what will be passed to the function when run
	** @param	state	This will be the $(document) object
	*/
    getEvent(data, vars, type, obj, state)
	{
		vars = (typeof vars === "undefined")? false : vars;

		if(isset(this.eventObj,data.name)) {
			if(isset(this.eventObj[data.name],data.use))
				this.eventObj[data.name][data.use](vars,type,obj,state);
		}
	}

	hasSpace(loadspace)
	{
		if(empty(loadspace))
			return false;

		return (isset(this.eventObj,loadspace));
	}

	getSpace(loadspace)
	{
		if(empty(loadspace))
			return false;
		else if(!isset(this.eventObj,loadspace))
			return false;
		else if(empty(this.eventObj[loadspace]))
			return false;

		return this.eventObj[loadspace];
	}

	getAll()
	{
		return this.eventObj;
	}

	addData(name,data)
	{
		this.dataObj[name]	=	data;
		return this;
	}

	getData(name)
	{
		return (!empty(this.dataObj[name]))? this.dataObj[name] : false;
	}
}