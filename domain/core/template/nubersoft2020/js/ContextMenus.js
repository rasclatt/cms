class ContextMenus
{
    constructor()
    {
        this.modalCont  =   '#loadspot-modal';
        this.buttons    =   {};
        this.events =   {};
        this.divider    =   '<div class="hr"></div>';
    }
	/**
	 *	@description	
	 */
	setModalContainer(name)
	{
        this.modalCont  =   name;
        return this;
	}
	/**
	 *	@description	
	 */
	getModalContainer()
	{
        return this.modalCont;
	}
	/**
	 *	@description	
	 */
	getDivider()
	{
        return this.divider;
	}
    addElem(name, value, elem)
    {
        switch(elem) {
            case('event'):
                this.events[name]   =   value;
                break;
            case('button'):
                this.buttons[name]  =   value;
                break;
        }
        return this;
    }
    
    addEvent(name, func)
    {
        return this.addElem(name, func, 'event');
    }
    
    addButton(name, func)
    {
        return this.addElem(name, func, 'button');
    }
    
    addElements(obj)
    {
        var self    =   this;
        $.each(obj, function(k, v){
            self.addElem(k, v[0], v[1]);
        });
        return this;
    }
    
    assemble(type, join, skip)
    {
        if(typeof join === "undefined" || join == "default")
            join    =   this.divider;
        
        let use =   (type != 'event')? this.buttons : this.events;
        let arr =   [];
        $.each(use, function(k, v){
            var write   =   false;
            
            if(typeof skip !== "undefined") {
                if(!skip.includes(k))
                    write   =   true;
            }
            else
                write   =   true;
            
            if(write)
                arr.push((typeof v === "function")? v() : v);
        });
        return arr.join(join);
    }
    
    static getMousePosition(e)
    {
        var posx = 0;
        var posy = 0;

        if (!e)
            var e = window.event;

        if (e.pageX || e.pageY) {
            posx = e.pageX;
            posy = e.pageY;
        } else if (e.clientX || e.clientY) {
            posx = e.clientX + document.body.scrollLeft + 
                               document.documentElement.scrollLeft;
            posy = e.clientY + document.body.scrollTop + 
                               document.documentElement.scrollTop;
        }

        return {
            x: posx,
            y: posy
        }
    }
    
    sentinel(e)
    {
        var exit    =   false;
        var stop    =   false;
        var self    =   this;
        $.each(this.events, function(k, v) {
            stop    =   v(e, self);
            cfrsToken();
            if(stop)
                exit    =   true;
        });
        
        return exit;
    }
    
    static toMenu(btns, style)
    {
        var self    =   new ContextMenus();
        if(!btns)
            btns    =   '';
        if(!style)
            style    =   '';
        
        if(typeof btns !== "string") {
            btns    =   btns.filter(val => val != '').join(self.getDivider());
        }
        return `<div style="${style}" class="contextual-menu align-center draggable">
            <div class="nTrigger last-col white pointer load-spinner close-x nodrag" data-instructions='{"DOM":{"event":["click"],"html":[" "],"sendto":["${self.getModalContainer()}"]}}'><i class="fas fa-times-circle float-right pointer close-contextual"></i></div>
            <div class="nodrag">
                ${btns}
            </div>

        </div>`;
    }
}