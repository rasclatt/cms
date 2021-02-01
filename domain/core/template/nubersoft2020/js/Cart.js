// JavaScript Document
class Cart
{
    constructor(defaultName)
    {
        // Allows for multiple carts
        this.defaultName    =   (typeof defaultName !== "undefined")? defaultName : "cart";
        // Start the cart
        if(this.get() === false)
            this.toCart();
    }
	/**
	 *	@description	
	 */
	toCart(cartArray, name)
	{
        // Set default cart name
        if(typeof name === "undefined")
            name    =   this.defaultName;
        // Leave blank to reset the cart
        if(typeof cartArray !== "object")
            cartArray   =   {};
        // Set the cart
        CookieJar.set(name, JSON.stringify(cartArray));
        // Allow chaining
        return this;
	}
    
    addToCart(sku, qty)
    {
        // Fetch the current cart
        var cartArray   =   JSON.parse(CookieJar.get(this.defaultName));
        // If not already created, add
        if(typeof cartArray[sku] === "undefined")
            cartArray[sku]  =   parseInt(qty);
        else
            // Update if already added
            cartArray[sku]  =   [cartArray[sku], parseInt(qty)].reduce((sum, value) => parseInt(sum) + parseInt(value));
        // Save back to cookie
        this.toCart(cartArray);
        // Allow chain
        return this;
    }
	/**
	 *	@description	
	 */
	clear()
	{
        // Reset cart to blank object
        this.toCart({});
	}
	/**
	 *	@description	
	 */
	remove(sku, qty)
	{
        // Fetch contents
        var cartArray   =   this.get();
        // Create storage
        var newArr  =   {};
        
        $.each(cartArray, function(k, v){
            // Remove all or some qty
            if(k == sku) {
                if(typeof qty !== "undefined") {
                    cartArray[sku] -= qty;

                    if(cartArray[sku] > 0)
                        newArr[sku] =   cartArray[sku];
                }
            }
            else {
                newArr[k]  =   v;
            }
        });
        
        
        this.toCart(newArr);
        
        return this;
	}
	/**
	 *	@description	
	 */
	get(sku, name)
	{
        if(typeof name === "undefined")
            name    =   this.defaultName;
        try {
            var cartArray   =   JSON.parse(CookieJar.get(name));
            return (typeof sku === "string")? cartArray[sku] : cartArray;
        }
        catch (Exception) {
            return false;
        }
	}
	/**
	 *	@description	
	 */
	parseForm(obj, remove)
	{
        remove  =   (typeof remove === "boolean")? remove : false;
        var arr =   {};
        let data    =   obj.serializeArray();
        var self    =   this;
        $.each(data, function(k, v){
            if(v.name == "clear" && remove) {
                v.value.split('|').map(function(v){
                    self.remove(v, self.get(v));
                });
            }
            else {
                arr[v.name]  =   v.value;
            }
        });
            
        return arr;
	}
	/**
	 *	@description	
	 */
	getItemCount()
	{
        var count   =   [];
        var cart    =   this.get();
        $.each(cart, function(){
            count.push(1);
        });
        
        return count.length;
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
}