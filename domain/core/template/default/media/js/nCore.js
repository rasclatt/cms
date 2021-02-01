// JavaScript Document
const show_path   =   true;


class CartEngine
{
    constructor()
    {
        this.data   =   {};
    }
    
    addAttr(k, v)
    {
        this.data[k]    =   v;
        return this;
    }
    
    get(sku)
    {
        let data    =   JSON.parse(CookieJar.get('cart'));
        
        if(show_path)
            console.log(CookieJar.get('cart'));
        
        if(typeof sku !== "undefined")
            return (isset(data, sku))? data[sku] : false;
        
        return (data == "")? {} : data;
    }
    
    add(sku, qty)
    {
        if(show_path)
            console.log({"Cart":"add","sku": sku, "qty": qty});
        let curr    =   this.get();
        curr[sku]   =   qty;
        //console.log({"Cart":"Add","sku":sku,"qty":qty});
        this.clear();
        CookieJar.set('cart', this.toString(curr));
        return this;
    }
    
    remove(sku)
    {
        let thisObj =   this;
        var rest    =   {};
        if(this.get(sku)) {
            let all =   thisObj.get();
            $.each(all, function(k, v){
                if(k != sku)
                    rest[k] = v;
            });
        }
        
        CookieJar.set('cart', this.toString(rest));
    }
    
    getCartFromUrl()
    {
        return (typeof this.parse().sku === "object")? this.parse().sku : {};
    }
    
    auto()
    {
        let cartitems   =   this.getCartFromUrl();
        if(this.itemCount(cartitems))
            CookieJar.set('cart', this.toString(this.getCartFromUrl()));
        return this;
    }
    
    toString(obj)
    {
        if(typeof obj === "object")
            return JSON.stringify(obj);
        
        return obj;
    }
    
    toCurrency(val, locale, currency)
    {
        if(typeof locale === "undefined" || locale == "")
            locale  =   'en-US';
        
        if(typeof currency === "undefined" || currency == "")
            currency    =   'USD';
        
        return (new Intl.NumberFormat(locale, {
          style: 'currency',
          currency: currency,
        })).format(val);
    }
    
    clear()
    {
        CookieJar.destroy('cart');
        return this;
    }
    
    parse()
    {
        let base    =   DomainHelper.parseStr(window.location.search);
        
        if(base.length == 0)
            return {};
        
        return base;
    }
    
    itemCount(array)
    {
        if(typeof array == "undefined")
            array   =   this.get();
        
        return Object.keys(array).length;
    }
    
    static getVal(value, def)
    {
        if(typeof value === "undefined" || value == 0 || value == '')
            return def;
        
        return value;
    }
}

class CartHelper
{
    constructor(Cart)
    {
        this.cartObj    =   Cart;
    }
    
    appendUrl(path)
    {
        let items    =   this.cartObj.get();
        // If there are items, apply to query string
        if(items) {
           $.each(items, function(k, v){
               path += "&sku[" + k + "]=" + v;
           });
        }
        // Clear the cart
        this.cartObj.clear();
        // Go to the destination
        return path + '#summary-container';
    }
}