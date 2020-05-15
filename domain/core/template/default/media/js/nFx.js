// JavaScript Document
var	AnimatorFX	=	function()
{
	var	self   =	this;
    var listen  =   $('body');
    var win =   $(window);
    
    self.inc =   1000;    
    self.count  =   0;
	
	self.setAttr	=	function(attr, value)
	{
		self[attr]	=	value;
		return self;
	};
	
	self.isScrolledIntoView	=	function(elem)
	{
        if($(elem).length == 0)
            return false;
        
		var docViewTop = win.scrollTop();
		var docViewBottom = docViewTop + win.height();
        var elemTop = $(elem).offset().top;
		var elemBottom = elemTop + $(elem).height();

		var	useHighest	=	(elemBottom <= elemTop+30)? elemBottom : elemTop+30;

		if((useHighest <= docViewBottom) && (elemTop >= docViewTop)) {
			return true;
		}
		else if(elemBottom <= docViewBottom) {
			return true;
		}
		else if(elemTop <= docViewTop) {
			return true;
		}
		return false;
	};

	self.loopReveals	=	function(sections, use_class)
	{
        if(sections.length == 0)
            return sections;
        
        $.each(sections, function(k, v){
			if(self.isScrolledIntoView($(v))) {
				if(!$(v).hasClass(use_class)) {
					self.count	+=	self.inc;
					setTimeout(function(){
						$(v).addClass(use_class);
					}, self.count*2);
				}
			}
		});
	};

	self.applynFx	=	function(count)
	{
        self.sections	=	$('.revealer:not(.show-revealer)');
        self.poppers	=	$('.reveal-pop:not(.popped)');
        self.nfx		=	$('.nFx');
        
        if(self.poppers.length != 0)
            self.loopReveals(self.poppers, 'popped');

		if(self.sections.length != 0)
			self.loopReveals(self.sections, 'show-revealer');

		if(self.nfx.length != 0)
			self.loopReveals(self.nfx, self.nfx.data('nfx'));
		
		return (self.poppers.length + self.sections.length + self.nfx.length) > 0;
	};
    
	self.sentinel	=	function()
	{
        var resetTime;
        
        function resetCounter()
        {
            resetTime   =   setTimeout(function(){
                self.count  =   0;
            }, 250);
        }
        self.a  =   0;
        resetCounter();
        
        win.off('resize.nFx');
        listen.off('resize.nFx');
        
		self.applynFx();
		
		win.on('resize.nFx', function(){
            self.applynFx()
		});
        listen.on('scroll.nFx', function(){
            if(resetTime)
                clearTimeout(resetTime);
            
            self.applynFx();
            resetCounter();
        });
	};
}