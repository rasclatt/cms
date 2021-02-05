class Translator
{
    constructor(locale)
    {
    	this.transFile;
        this.locale_lang =   (typeof locale === "string")? locale : 'en';
    }
    
    setTransFile(array)
    {
    	this.transFile	=	array;
    	return this;
    }
    
    sentinel(selector, type)
    {
        var self = this;
        $.each($(selector), function(k, v) {
            (type == "self") ? self.replaceTextToSelf(v) : self.replaceText(v, type);
        });

        return this;
    }

    replaceText(v, type)
    {
        if(typeof trans === "undefined")
            var trans   =   {};
    	var transdoc	=	(typeof this.transFile === "object")? this.transFile : trans;
        // Fetch the id from the id attribute
        let id = $(v).attr('id');
        // Make sure to set default language translation to english
        if (!isset(transdoc, this.locale_lang))
            this.locale_lang = 'en';
        // Stop if doesn't exist
        if(typeof id === "undefined")
            return this;
        // Replace text
        let txt = (typeof transdoc[this.locale_lang][id] !== "undefined") ? transdoc[this.locale_lang][id] : transdoc['en'][id];
        // Replace text
        (typeof type === "undefined") ? $('#' + id).html(txt) : $('#' + id).attr(type, txt);
        // Method chain
        return this;
    }

    listen(v)
    {
        var self = this;
        $.each($(v), function(k, v) {
            let data = $(v).data('instructions');
            var obj = {};

            data.split('&').map(function(v) {
                let exp = v.split('=');
                obj[exp[0]] = (typeof exp[1] !== "undefined") ? exp[1] : false;
            });

            let pool = (typeof obj.pool !== "undefined") ? obj.pool : false;
            let def = self.getTrans(obj.off, pool);

            if (typeof obj.observe !== "undefined") {
                $(obj.observe).on(obj.event, function() {
                    setTimeout(function() {
                        let target = (typeof obj.sendto !== false) ? obj.sendto : obj.observe;

                        if (typeof obj.toggleclass !== false) {
                            $(target).toggleClass(obj.toggleclass);
                        }

                        let on = self.getTrans(obj.on, pool);
                        if ($(obj.observe).is(obj.trigger))
                            $(target).text(on);
                        else
                            $(target).text(def);

                    }, 250);
                });
            }

            $(obj.sendto).text(def);

        });
    }

    getTrans(id, use_class, defaultValue)
    {
    	if(typeof defaultValue === "undefined")
	    	defaultValue	=	"";
	    
        if (typeof use_class === "undefined")
            use_class = false;
        
        if(typeof trans === "undefined")
            var trans   =   {};
        
    	var transdoc	=	(typeof this.transFile === "object")? this.transFile : trans;
    	
        try {
            if (use_class) {
                if(typeof transdoc[this.locale_lang]['trans-cls'][id] !== "undefined")
                	return transdoc[this.locale_lang]['trans-cls'][id];
                else if(transdoc['en']['trans-cls'][id] !== "undefined")
                	return transdoc['en']['trans-cls'][id];
                else
                	return defaultValue;
            }

            if(typeof transdoc[this.locale_lang][id] !== "undefined")
            	return transdoc[this.locale_lang][id];
            else if(typeof transdoc['en'][id] !== "undefined")
	            return transdoc['en'][id];
	        else
	        	return defaultValue;
        }
        catch (Exception) {
            console.log([
                this.locale_lang,
                id
            ]);
            return defaultValue;
        }
    }

    replaceTextToSelf(v)
    {
	let defaultValue  =  $(v).html();
        let type = $(v).data('type');

        if (type == '' || typeof type === "undefined")
            type = "txt";

        let id = $(v).data('trans');
    	var transdoc	=	(typeof this.transFile === "object")? this.transFile : trans;
        let txt = '';
        try {
	    if(typeof transdoc[this.locale_lang] !== "undefined") {
            	// Replace text
            	if(typeof transdoc[this.locale_lang]['trans-cls'][id] !== "undefined")
			txt = transdoc[this.locale_lang]['trans-cls'][id];
		else if(typeof transdoc['en']['trans-cls'][id] !== "undefined")
			txt = transdoc['en']['trans-cls'][id];
	    }

	    if(txt == '')
		txt = defaultValue;
        }
        catch (Exception) {
	    $(v).html(defaultValue);
            console.log([
                this.locale_lang,
                id,
                Exception.message
            ]);
            
            return this;
        }
        //txt =   decodeEntities(txt);

        switch (type) {
        case ("val"):
            $(v).val(txt);
            break;
        case ("html"):
            $(v).html(txt);
            break;
        default:
            (type != "txt") ? $(v).prop(type, txt) : $(v).text(txt);
        }
        return this;
    }
}
class TranslatorObserver
{
    constructor(Model)
    {
        this.Model   =   Model;
    }
    
    sentinel()
    {
        this.Model
        .sentinel('.trans-placeholder', 'placeholder')
        .sentinel('.trans')
        .sentinel('.trans-cls', 'self')
        .listen('.trans-toggle');
    }
}