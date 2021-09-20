$(() => {
    if(typeof cartSettings === "undefined") {
        var cartSettings    =   {
            shopPage: function(){
                return '#';
            }
        };
    }
    if(typeof cartAttributes == "undefined") {
        var cartAttributes = [
            '.addtocart',
            '.clearitem',
            '.removefromcart',
            '.cart-activator'
        ];
    }
    // Combine attributes that need hiding
    let cartViewItems = cartAttributes.join(',');
    // Cart interfaces
    $(cartViewItems).hide();
    // Start the cart by fetching products
    (new Promise((success, error) => {
        AjaxEngine.ajax({
            action: 'cart',
            subaction: 'getProducts',
            jwtToken: csrf
        }, r => {
            success(r);
        });
    })).then(r => {
        // See if there are products
        if(Object.keys(r).length == 0)
            return false;
        // Create the cart
        CartEngine = new CartSentinel(new Cart(), new Translator(), r);
        // Show all the cart peices
        $(cartViewItems).fadeIn('fast');
        // Start all the listeners and such
        initCart(CartEngine, cartSettings);
    });
});