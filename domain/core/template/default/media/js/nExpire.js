class nExpire
{
    constructor()
    {
        this.start = 3500;
    }

	setStart(val)
	{
		var is_numeric	=	(!isNaN(parseFloat(val)) && isFinite(val));
		this.start =	(is_numeric)? val : this.start;
		return this;
	}

	execute(dataObj)
	{
		if(dataObj === undefined)
			dataObj	=	{};

		var	cLink		=	(!empty(dataObj.on_click))? dataObj.on_click : '/';
		var	rLink		=	(!empty(dataObj.on_reload))? dataObj.on_reload : '/';
		var	wTime		=	(!empty(dataObj.warn_at))? dataObj.warn_at : 120;
		var	prepenTo	=	(!empty(dataObj.append))? dataObj.append : 'body';
		var	nMessage	=	(!empty(dataObj.message))? dataObj.message : '<div class="nbr_expire_bar">SESSION WILL EXPIRE SOON.</div>';
		var	cNotifier	=	(!empty(dataObj.class))? dataObj.class : '.nbr_expire_bar';

		$("body").on('click', cNotifier, function() {
			window.location	=	cLink;
		});

		obj	=	setInterval(function() {

			if(this.start <= 0) {
				window.location	=	rLink;
			}
			else if(this.start == wTime) {
				$("body").prepend(nMessage);
				$(cNotifier).hide().slideDown();
				$(cNotifier).css({"cursor":"pointer"});
			}
			else {
				var strNum	=	this.start.toString();
			}

			this.start--;
		},1000);
    }
};