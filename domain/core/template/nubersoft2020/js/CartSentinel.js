class CartSentinel
{
    constructor(Cart, Trans, itemList)
    {
        var self    =   this;
        this.transStatus   =   (typeof transEngineStatus !== "undefined")? transEngineStatus : false;
        this.itemList  =   (typeof itemList === "function")? itemList() : itemList;
        this.Trans  =   Trans;
        this.Cart   =   Cart;
        this.eventList  =   {};
        this.wipeList   =   [];
        this.summary    =   {};
        this.setSummaryTotals();
        this.imageUrl =   '/client/media/images/storefront/{{sku}}.png';
        this.htmlSummary    =   function(self, doTranslation, k, v) {
            return `<div class="summary-row" data-itemcode="${k}">
                <div><img src="${self.getImg(k, 'www')}" /></div>
                <div class="trans-cls white tiny align-center" data-trans="product-title-${k}">${doTranslation}</div>
                <div><i class="fas fa-plus addtocart fa-xs pointer" data-itemcode="${k}" data-quantity="1"></i></div>
                <div class="boxed">${v}</div>
                <div><i class="fas fa-minus removefromcart fa-xs pointer" data-itemcode="${k}" data-quantity="1"></i></div>
                <div><i class="far fa-trash-alt clearitem fa-xs pointer" data-itemcode="${k}"></i></div>
            </div>`
        };
        this.addPrice   =   'price';
    }
	/**
	 *	@description	
	 */
	setTranslationMode(mode)
	{
        this.transStatus   =   (mode == 'on' || mode === true);
        return this;
	}
	/**
	 *	@description	
	 */
	setImgUrl(url)
	{
        this.imageUrl   =   url;
        return this;
	}
	/**
	 *	@description	
	 */
	getImg(sku, distid)
	{
        if(typeof distid === "undefined")
            distid  =   'cdn';
        
        return this.imageUrl.replace('{{sku}}', sku).replace('{{distid}}', distid);
	}
	/**
	 *	@description	
	 */
	wipeOnEmpty(acton)
	{
        var self =  this;
        acton.map(function(v){
            self.wipeList.push(v);
        });
        return this;
	}
	/**
	 *	@param  action  The name of the event to run at
     *  @param  func    Anonymous function to run when called
	 */
	addToEventOn(action, func)
	{
        if(typeof action === "string")
            action  =   [action];
        var self = this;
        action.map(function(actionName){
            if(typeof self.eventList[actionName] === "undefined")
                self.eventList[actionName]  =   [];
            self.eventList[actionName].push(func);
        });
        
        return this;
	}
	/**
	 *	@description	
	 */
	doAddedEvent(action)
	{
        var self    =   this;
        // Loop through delegated events for add to cart
        if(typeof this.eventList[action] !== "undefined") {
            $.each(this.eventList[action], function(k, func){
                func(action, self);
            });
        }
	}
	/**
	 *	@description	
	 */
	doWipedEvent()
	{
        if(this.Cart.getItemCount() == 0 && this.wipeList.length > 0) {
            $(this.wipeList.join(',')).html('');
        }
	}
    addToCart(obj, e)
    {
        e.preventDefault();
        var self    =   this;
        var data    =   {};
        if(obj.hasClass('cart-add')) {
            data    =   this.Cart.parseForm(obj, true);
        }
        else {
            data.sku    =   obj.data('itemcode');
            data.quantity    =   obj.data('quantity');
        }
        
        this.doAddedEvent('addtocart');
        
        if(!this.isActive(data.sku)) 
            return this;
        
        this.Cart.addToCart(data.sku, data.quantity);
        
        if(!this.sideBarVisible())
            this.slideOutSummary();
        else
            this.createSummary();
        
        this.toCounter();
        
        return this;
    }
    getCartEngine()
    {
        return this.Cart;
    }
	/**
	 *	@description	
	 */
	onLoad()
	{
        this.doAddedEvent('onload');
        this.doWipedEvent();
        return this;
	}
	/**
	 *	@description	
	 */
	setSummaryTotals()
	{
        var self    =   this;
        this.summary.subtotal   =   0;
        $.each(this.Cart.get(), function(k, v){
            if(self.isActive(k)) {
                self.summary.subtotal   +=  self.tally(k, v);
            }
        });
        
        this.summary.subtotal   =   this.Cart.toCurrency(this.summary.subtotal);
        return this;
	}
	/**
	 *	@description	
	 */
	setSummaryHtml(html)
	{
        this.htmlSummary    =   html;
        return this;
	}
    
    createSummary()
    {
        let name    =  (typeof arguments[0] === "string")? arguments[0] : '.cart-summary';
        var hasFunc    =   (typeof arguments[1] === "function");
        var rows    =   [];
        var subtotal    =   0;
        var self    =   this;
        this.doAddedEvent('createsummary');
        this.doWipedEvent();
        $.each(this.Cart.get(), function(k, v){
            if(self.isActive(k)) {
                let shortDesc   =   (typeof self.itemList[k].title !== "undefined")? self.itemList[k].title : false;
                let doTranslation = (this.transStatus)? `<i class="fas fa-spinner spinner"></i>`: (shortDesc != false)? shortDesc : self.itemList[k].description;
                // Update subtoal
                subtotal    +=  self.tally(k, v);
                // Do any on-the-fly functions
                if(hasFunc) {
                    rows.push(arguments[1](k, v, this));
                }
                else {
                    rows.push(self.htmlSummary(self, doTranslation, k, v));
                }
            }
        });
        
        if(rows.length > 0) {
            rows.push(`<hr class="wht margin-bottom-1 margin-top-1" /><div class="align-center col-count-2 gapped"><div class="white trans-cls" data-trans="subtotal">Subtotal</div><div class="text-right">${this.Cart.toCurrency(subtotal)}</div></div>`);
            rows.push('<div class="margin-top-2 align-center"><a href="/checkout/" class="button standard outlined wht wb trans-cls" data-trans="checkout">CHECKOUT</a></div>');
            rows.push('<div class="margin-top-1 align-center"><a href="#" class="clear-cart button standard outlined wht wb trans-cls" data-trans="clearcart">CLEAR</a></div>');
        }
        else {
            this.doAddedEvent('afterempty');
        }
        
        $(name).html(rows.join(''));
    }
	/**
	 *	@description	
	 */
	setPriceKey(name)
	{
        this.addPrice   =   name;
        return this;
	}
	/**
	 *	@description	
	 */
	tally(sku, qty)
	{
        return this.itemList[sku][this.addPrice] * qty;
	}
	/**
	 *	@description	
	 */
	isActive(sku)
	{
        try {
            return this.itemList[sku][this.addPrice];
        }
        catch (e) {
            return false;
        }
        return true;
	}
    
    toCounter()
    {
        let name    =  (typeof arguments[0] === "string")? arguments[0] : '.cart-qty';
        $(name).text(this.Cart.getItemCount());
    }
    
    removeFromCart(sku, qty)
    {
        if(typeof qty === "undefined")
            this.Cart.remove(sku);
        else
            this.Cart.remove(sku, qty);
        
        this.createSummary();
        this.toCounter();
    }

    sideBarVisible()
    {
        return ($('body').hasClass('side-bar-active'));
    }
    
    slideOutSummary()
    {
        let visible =   this.sideBarVisible();
        if(visible) {
            $('.sidebar-container').animate({"width": "0px"}, 250, function(){
                $('#loadspot-modal').html('').removeClass('fixed-auto right-0 top-0 bottom-0');
                $('body').removeClass('side-bar-active');
            });
        }
        else {
            $('body').addClass('side-bar-active');
            $('#loadspot-modal').addClass('fixed-auto right-0 top-0 bottom-0').html(
                `<div class="sidebar-container">
                    <div class="cart-content-mini">
                        <div>
                            <a href="#" class="float-right white mr-4"><i class="fas fa-times cart-activator pointer"></i></a>
                            <h3 class="uppercase white"><span class="trans-cls" data-trans="itemsincart">Items in Cart</span> (<span class="cart-qty">0</span>)</h3>
                        </div>
                        <div class="mt-4 mr-4 cart-summary"></div>
                    </div>
                </div>`
            ).css({"z-index": "100000"});
            this.toCounter();
            this.createSummary();
            $('.sidebar-container').animate({"width": '375px'}, 250);
        }
    }
}
