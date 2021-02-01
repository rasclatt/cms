
if(typeof itemList !== "undefined") {
    // Create cart
    var CartEngine    =   new CartSentinel(
        new Cart(),
        new Translator(),
        itemList
    );
}