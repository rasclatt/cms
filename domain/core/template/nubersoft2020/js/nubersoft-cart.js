if(typeof cartSettings === "undefined") {
    var cartSettings    =   {
        shopPage: function(){
            return '#';
        }
    };
}

$(function(){
    if(typeof CartEngine === "undefined")
        return false;
    // Hide stuff when cart is empty
    CartEngine.wipeOnEmpty(['.hide-on-empty']);
    // When cart is emptied
    CartEngine.addToEventOn(['afterempty','onload'], function(action, CartEngine){
        if(CartEngine.Cart.getItemCount() == 0) {
            let cartSummArea    =   $('#cart-summary-block');
            if(cartSummArea.length > 0) {
                cartSummArea.html(`<div class="align-middle pad-1"><a href="${cartSettings.shopPage(action, CartEngine)}" class="button standard outlined purple lrg lg trans-cls" data-trans="shopnow">SHOP NOW</a></div>`);
                
                translatePage();
            }
        }
    });
    // Fill all subtotals
    CartEngine.addToEventOn(['onload','createsummary'], function(action, CartEngine){
        CartEngine.setSummaryTotals();
        $('.subtotal').html(CartEngine.summary.subtotal);
    });
    // Create an event when page loads or when the cart summary updates
    CartEngine.addToEventOn(['createsummary','onload'], function(action, CartEngine) {
        
        var urlLinks    =   $('.update-link-products');
        var summary =   $('.cart-summary-items');
        summary.html('');
        if(CartEngine.Cart.getItemCount() == 0) {
            return false;
        }
        var data    =   CartEngine.Cart.get();
        var layout  =   [];
        var prodCarrat  =   [];
        $.each(data, function(sku, qty){
            
            try {
                layout.push(`<tr class="cart-item-summary">
                    <td class="cart-combo gapped col-c1-md">
                        <div class="cart-image align-middle">
                            <img src="${CartEngine.getImg(sku, 'www')}" alt="Product">
                        </div>

                        <div class="cart-item-description tiny pad-half pad-05">
                            <h3 class="uppercase heavy trans-cls align-center" data-trans="product-title-${sku}"></h3>
                            <!--p class=" trans-cls" data-trans="product-desc-${sku}"></p-->
                        </div>
                    </td>
                    <td class="cart-item-qty align-center">
                        ${qty}
                    </td>
                    <td class="cart-item-cv align-center">
                        ${CartEngine.Cart.toCurrency(CartEngine.itemList[sku].price)}
                    </td>
                    <td class="cart-item-price align-center">
                        ${CartEngine.itemList[sku].cv}CV
                    </td>
                </tr>`);
            }
            catch (Exception) {
                console.log(Exception.message);
            }
        });
        
        if(urlLinks.length > 0) {
            $.each(urlLinks, function(k, v){
                let parseUrl =   $(v).attr('href').split('?');
                if(parseUrl.length == 2) {
                    let parse   =   DomHelper.parse(parseUrl[1]);
                    if(typeof parse.reset === "undefined")
                        parse.resetcart =   true;
                    
                    parseUrl[0] +=  '?';
                    var arr =   [];
                    $.each(parse, function(key, val){
                        arr.push(`${key}=${val}`);
                    });
                    
                    $(v).attr('href', parseUrl[0] + arr.join('&'));
                }
            });
        }
        
        summary.html(layout.join(''));
        
    });
    /**
     *  @description    Start the cart loader with load event and run the cart counter
     */
    CartEngine
        // Start any onload events
        .onLoad()
        // Update the items-in-cart counter
        .toCounter();
    /**
     *  @description    Updates the pricing ribbon on the product blocks
     *  @event  On change select[name="sku"]
     */
    $('select[name="sku"]').on('change', function(){
        // Get the current value of selection
        let thisVal =   $(this).val();
        // Loop through options
        $.each($(this).children(), function(k, v){
            // If the selected sku equals the the value of the option
            if($(v).attr('value') == thisVal) {
                // Update the pricing on the retail/subscription strip
                $('.retail-price-placeholder').text(CartEngine.Cart.toCurrency($(v).data('retail')));
                $('.wholesale-price-placeholder').text(CartEngine.Cart.toCurrency($(v).data('wholesale')));
            }
        });
    });
    /**
     *  @description    Clear the cart when clicked
     */
    $(this).on('click', '.clear-cart', function(e){
        // Stop action if button
        e.preventDefault();
        // Clear the cart cookie object
        CartEngine.Cart.clear();
        // Update the counter
        CartEngine.toCounter();
        // Build the summary (in this case it will clear)
        CartEngine.createSummary();
    });
    /**
     *  @description    This add to cart based on form submission
     */
    $(this).on('submit', '.cart-add',  function(e){
        // Stop the translator from running (on time delay)
        stopTranslator();
        // Restart it
        runTranslator();
        // Update the cart
        CartEngine.addToCart($(this), e);
    });
    /**
     *  @description    Listen for all main actions of the cart
     */
    $(this).on('click', '.addtocart,.clearitem,.removefromcart,.cart-activator', function(e){
        // Stop the translation
        stopTranslator();
        // Do an action
        if($(this).hasClass('addtocart'))
            CartEngine.addToCart($(this), e);
        else if($(this).hasClass('clearitem'))
            CartEngine.removeFromCart($(this).data('itemcode'));
        else if($(this).hasClass('removefromcart'))
            CartEngine.removeFromCart($(this).data('itemcode'), 1);
        else if($(this).hasClass('cart-activator')) {
            e.preventDefault();
            CartEngine.slideOutSummary();
        }
        // Restart the translator
        runTranslator();
    });
    
    if($('.cart-item-details-data').length != 0) {
        console.log([
            itemList,
            $('section.cart-item-details-data').data()
        ]);
        
        if(typeof itemList[$('section.cart-item-details-data').data('itemcode')] === "undefined") {
            $('.quantity-area').replaceWith(`<div class="margin-top-2 alert alert-danger trans-cls" data-trans="itemunavailableincountry" role="alert">This product is unavailable in this country</div>`);
        }
    }
});