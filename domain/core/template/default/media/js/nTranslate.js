class Translator
{
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
        // Fetch the id from the id attribute
        let id = $(v).attr('id');
        // Make sure to set default language translation to english
        if (!isset(trans, locale_lang))
            locale_lang = 'en';
        // Replace text
        let txt = (typeof trans[locale_lang][id] !== "undefined") ? trans[locale_lang][id] : trans['en'][id];
        // Replace text
        (typeof type === "undefined") ? $('#' + id).html(txt) : $('#' + id).attr(type, txt);
        // Method chain
        return this;
    }
    
    replaceTextToSelf(v)
    {
        let type = $(v).data('type');

        if (type == '' || typeof type === "undefined")
            type = "txt";

        let id = $(v).data('trans');
        // Replace text
        let txt = (typeof trans[locale_lang]['trans-cls'][id] !== "undefined") ? trans[locale_lang]['trans-cls'][id] : trans['en']['trans-cls'][id];

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