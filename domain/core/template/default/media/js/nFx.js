// JavaScript Document
var	AnimatorFX	=	function()
{
	var	self		=	this;
	var	a			=	0;
	self.sections	=	$('.revealer');
	self.poppers	=	$('.reveal-pop');
	self.nfx		=	$('.nFx');
	self.queueObj	=	[];
	
	self.setAttr	=	function(attr, value)
	{
		self[attr]	=	value;
		return self;
	};
	
	self.isScrolledIntoView	=	function(elem)
	{
		var docViewTop = $(window).scrollTop();
		var docViewBottom = docViewTop + $(window).height();

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
		$.each(sections, function(k, v){
			if(self.isScrolledIntoView(v)) {// && !self.isQueued(k)
				//self.queued(k);
				if(!$(v).hasClass(use_class)) {
					setTimeout(function(){
						$(v).addClass(use_class);
					}, a);
					a	+=	50;

				}
			}
		});
		
		//if(self.queueObj) {
		//	self.runQueue();
		//}
		
		return self;
	};

	self.queued	=	function(key)
	{
		self.queueObj.push(key);
		
		return self;
	}
	
	self.isQueued	=	function(k)
	{
		return (in_array(self.queueObj, k));
	}
	
	self.runQueue	=	function()
	{
		var	a	=	500;
		$.each(self.queueObj, function(k, v){
			setTimeout(function(){
				var newObj	=	v[0];
				var newVal	=	v[1];
				newObj.addClass(newVal);
				self.queueObj[k]	=	null;
			}, a);
			a++;
		});
		
		return self;
	}
	
	self.create	=	function()
	{
		self.loopReveals(self.sections, 'show-revealer');
		self.loopReveals(self.poppers, 'popped');
		setTimeout(function(){
			self.loopReveals(self.nfx, self.nfx.data('nfx'));
		}, 500);
		
		return self;
	};

	self.applynFx	=	function()
	{
		if(self.poppers.length != 0)
			self.loopReveals(self.poppers, 'popped');

		if(self.sections.length != 0)
			self.loopReveals(self.sections, 'show-revealer');

		if(self.nfx.length != 0)
			self.loopReveals(self.nfx, self.nfx.data('nfx'));
		
		return self;
	};
	
	self.sentinel	=	function()
	{
		$(document).on('scroll', function(){
			a	=	500;
		});
		
		var	FxAnimator	=	self;
		
		FxAnimator.applynFx();
		
		$(window).on('resize', function(){
			FxAnimator.applynFx();
		});

		$(window).scroll(function () {
			FxAnimator.applynFx();
		});
		
		return self;
	}
}
$(function(){
	(new AnimatorFX()).sentinel();
});