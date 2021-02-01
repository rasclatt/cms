class FxEngine
{
    constructor(obj)
    {
        this.threshold  =   20;
        this.actors =   obj;
        this.stored =   {};
        var self    =   this;
        
        $.each(this.actors, function(k, v){
            let place   =   self.calc($(v));
            if(typeof self.stored[place] === "undefined")
                self.stored[place]  =   [];
            
            self.stored[place].push(v);
        });
        
        this.stored =   Object.keys(self.stored).sort().reduce((obj, key) => {
            obj[key] = self.stored[key]; 
            return obj;
        },{
            
        });
    }

    calc(obj)
    {
        let top =   obj.offset().top;
        let t   =   (typeof obj.data('fxthreshold') === "undefined")? this.threshold : parseFloat(obj.data('fxthreshold'));
        let m   =   +(top * (t / 100)) + +top;
        return Math.round(m);
    }
    
    sentinel()
    {
        var self    =   this;
        var inView  =   +$(document).scrollTop() + +$(window).height();
        this.runStored(inView);
        $(window).on('scroll resize', function(){
            if(typeof Object.keys(self.stored)[0] === "undefined")
                return false;
            inView  =   +$(document).scrollTop() + +$(window).height();
            self.runFilter(Object.keys(self.stored)[0], inView);
        });
    }

    runFilter(key, inView)
    {
        var self    =   this;
        if(key <= inView) {
            $.each(self.stored[key], function(k, v){
                if($(v).data('fxadd')) {
                    $(v).addClass($(v).data('fxadd'));
                }
                if($(v).data('fxremove')) {
                    $(v).removeClass($(v).data('fxremove'));
                }
            });
                
            delete self.stored[key];
        }
    }
    
    runStored(inView)
    {
        var self    =   this;
        $.each(self.stored, function(position, fxGroups){
            self.runFilter(position, inView);
        });
        return this;
    }
}