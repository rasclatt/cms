<?php
$cart   =   json_decode($this->dec($this->getDataNode('_COOKIE')['cart']), 1);
?>
<section id="checkout">
    <div class="col-count-3 offset">
        <div class="start2 pad-top-3 pad-bottom-3" id="cart-summary-block">

            <div>
                <a href="#" class="float-left clear-cart fx opacity-hover gray pointer fx opacity-hover" data-donext="reload" data-location="<?php echo $this->getPage('full_path') ?>"><span class="trans-cls" data-trans="clear">Clear</span>&nbsp;<i class="fas fa-trash-alt fa-md clear-cart" role="button" aria-label="Clear cart"></i></a>
            </div>
            <div class="pad-half">&nbsp;</div>
            <table cellpadding="0" cellspacing="0" border="0" class="mt-2">
                <tr class="cart-summary-items-hd">
                    <td>
                        <h3 class="uppercase rule-under wide thin left normal trans-cls" data-trans="cartsummary">Cart Summary</h3>
                    </td>
                    <td class="qty align-center">Qty</td>
                    <td class="price align-center">Price</td>
                    <td class="cv align-center">CV</td>
                </tr>
                <tbody class="cart-summary-items pad-bottom-small">

                </tbody>

                <tr class="summary-totals">
                    <td colspan="2"></td>
                    <td class="align-center trans-cls" data-trans="subtotal">Subtotal</td>
                    <td class="subtotal align-center"></td>
                </tr>
            </table>

            <div class="hide-on-empty flexor">
                <?php if(!$this->isLoggedIn()): ?>

                <a href="#" class="button standard outlined purple lrg lg fx opacity-hover login trans-cls nTrigger canceller" data-instructions='{"FX":{"fx":["fadeToggle"],"acton":["#login-modal"]}}' data-trans="continue">CONTINUE</a>

                <?php else: ?>


                <?php endif ?>

            </div>
            <?php if($this->isLoggedIn()): ?>

                <?php if(!empty($cart)): ?>
            <div class="align-middle pad-top-2">
                <a href="#" class="update-link-products button standard outlined purple lrg lg fx opacity-hover login trans-cls" data-trans="tr-checkout">CHECKOUT</a>
            </div>
                <?php else: ?>

                <?php endif ?>

            <?php endif ?>

        </div>
    </div>
</section>