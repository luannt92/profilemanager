<?php
$carts      = $this->request->session()->read('cart');
$total_cart = $this->request->session()->read('payment.total');
?>
<?php if ($carts) {
    foreach ($carts as $k => $cart) :
        $flag = ! empty($cart['product_note']) ? true : false; ?>
        <div class="col-xs-12 box-product">
            <div class="row box-cart">
                <div class="col-sm-1 multi">
                    <span>x<?php echo $cart['quantity']; ?></span>
                </div>
                <div class="col-xs-4 dish">
                    <span><?php echo $cart['name']; ?></span>
                </div>
                <div class="col-xs-3 edit-pro">
                    <?php
                    echo $this->Html->link($this->Html->image('edit3.png',
                        ['alt' => 'Sub']), '', [
                        'escape'    => false,
                        'data-attr' => $cart['id'] . $cart['name_option'],
                        'data-type' => '-1',
                        'class'     => 'subcart updateCart',
                    ]);

                    echo $this->Html->link($this->Html->image('edit2.png',
                        ['alt' => 'Plus']), '', [
                        'escape'    => false,
                        'data-attr' => $cart['id'] . $cart['name_option'],
                        'data-type' => '1',
                        'class'     => 'addcart updateCart',
                    ]);
                    echo $this->Html->link($this->Html->image('edit1.png',
                        ['alt' => 'Notes']), '#add-notes' . $k,
                        ['escape' => false, 'data-toggle' => 'collapse']);
                    ?>
                </div>
                <div class="col-xs-2 price">
                    <span>
                    <?php echo $this->Number->format(($cart['price']
                            + $cart['total_options'])
                        * $cart['quantity'],
                        [
                            'places' => 0,
                            'after'  => '<u>đ</u>',
                            'escape' => false,
                        ]); ?>
                    </span>
                </div>
                <div class="col-xs-2 delete">
                    <?php echo $this->Html->link($this->Html->image('del.png',
                        ['alt' => __('Delete')]), '', [
                        'data-attr' => $cart['id'] . $cart['name_option'],
                        'escape'    => false,
                        'class'     => "removeCart",
                    ]); ?>
                </div>
                <div class="col-xs-11 col-xs-offset-1 notes">
                    <span>
                        <?php echo $cart['displayOption']; ?>
                        <p><?php echo $cart['promotion']; ?></p>
                    </span>
                </div>

            </div>
            <!-- box-cart -->
            <div class="row collapse row-notes"
                 id="add-notes<?php echo $k; ?>">
                <div class="col-xs-12 add-note">
                    <fieldset>
                        <legend><?php echo $flag ? __(UPDATE_NOTE_CART)
                                : __(ADD_NOTE_CART); ?></legend>
                        <textarea class="form-control"
                                  rows="3"
                                  placeholder='<?php echo __(CONTENT_NOTE_CART); ?>'><?php echo $cart['product_note']; ?></textarea>
                    </fieldset>
                    <div class="addorno">
                        <button type="button" class="btn btn-sm btn-cancel">
                            <?php echo __(CART_CANCEL); ?>
                        </button>
                        <button class="btn btn-sm btn-add"
                                data-attr="<?php echo $k; ?>">
                            <?php echo $flag ? __('Save') : __(CART_ADD); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach;
} ?>

<hr>
<div class="col-xs-12 total-cart">
    <div class="col-xs-12">
        <div class="row total">
            <div class="col-xs-6">
                <span><?php echo __('Total'); ?>:</span>
            </div>
            <div class="col-xs-6 text-right">
                <span>
                    <?php echo $this->Number->format($total_cart,
                        [
                            'places' => 0,
                            'after'  => ' <u>đ</u>',
                            'escape' => false,
                        ]); ?>
                </span>
            </div>
        </div>
    </div>
    <div class="col-xs-12">
        <?php
        if ( ! empty($carts) && $total_cart >= MIN_CHECKOUT) {
            echo $this->Html->link(__(CART_CHECKOUT), [
                'controller' => 'orders',
                'action'     => 'checkOut',
            ], ['class' => 'btn btn-sendcart']);
        } else {
            $minCheckout
                = $this->Number->format(MIN_CHECKOUT, [
                'places' => 0,
                'after'  => ' <u>đ</u>',
                'escape' => false,
            ]);
            echo $this->Html->link(__(CART_CHECKOUT), '#',
                ['class' => 'btn btn-sendcart btn-disable']);
            echo '<p style="text-align: center">'
                . __("Sorry, you can't order yet. Phu Quoc Delivery has set a minimum order amount of {0}.",
                    $minCheckout) . '</p>';
        }
        ?>
    </div>
</div>