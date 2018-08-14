<?php
$carts      = $this->request->getSession()->read('cart');
$countCarts = 0;
if ( ! empty($carts)) {
    foreach ($carts as $cart) {
        $countCarts += $cart['quantity'];
    }
}
$total_cart = $this->request->getSession()->read('payment.total');
?>
    <a class="cart-idx" href="#myCart" data-toggle="modal">
        <span id="num-product"><?php echo $countCarts; ?></span>
    </a>
    <div class="modal fade" id="myCart" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?php echo __(CART); ?></h4>
                </div>
                <div class="modal-body">
                    <div id="cart-content" class="cart-content row">
                        <?php if ($carts) {
                            echo $this->element('Front/Order/cart',
                                ['carts' => $carts]);
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
                                if ( ! empty($carts)
                                    && $total_cart >= MIN_CHECKOUT
                                ) {
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
                                    echo $this->Html->link(__(CART_CHECKOUT),
                                        '#',
                                        ['class' => 'btn btn-sendcart btn-disable']);
                                    echo '<p style="text-align: center">'
                                        . __("Sorry, you can't order yet. Phu Quoc Delivery has set a minimum order amount of {0}.",
                                            $minCheckout) . '</p>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php echo $this->Html->scriptStart(['block' => true]); ?>
<!--    <script>-->
        $(document).ready(function () {
            $('.cart-content').on('click', 'button.btn-add', function (e) {
                e.preventDefault();
                var data = $(this).attr('data-attr');
                var note = $('#add-notes' + data + ' textarea').val();
                if (note == "") {
                    return;
                }
                var key = 'noteCart';
                $.ajax({
                    url: '<?php echo $this->Url->build([
                        'controller' => 'users',
                        'action'     => 'updateCheckOut',
                    ]); ?>',
                    data: {id: data, note: note, key: key},
                    type: 'POST',
                    error: function () {
                        alertMsgFrm('Wrong information', false);
                    },
                    success: function (data) {
                        $('#cart-content').html(data.render);
                        alertMsgFrm(appConfig.updateMsg, true);
                    },
                });
            });

            $('#cart-content').on('click', 'a.updateCart', function (e) {
                e.preventDefault();
                var data = $(this).attr('data-attr');
                var type = $(this).attr('data-type');
                var key = 'updateCart';
                $.ajax({
                    url: '<?php echo $this->Url->build([
                        'controller' => 'users',
                        'action'     => 'updateCheckOut',
                    ]); ?>',
                    data: {id: data, type: type, key: key},
                    type: 'POST',
                    error: function () {
                        alertMsgFrm('Wrong information', false);
                    },
                    success: function (data) {
                        var total = data.total.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.") + ' ₫';
                        $('#cart-content').html(data.render);
                        $('#price').text(total);
                        $('#num-product').text(data.countProduct);
                    },
                });
            });

            $('#cart-content').on('click', 'a.removeCart', function (e) {
                e.preventDefault();
                var data = $(this).attr('data-attr');
                var key = 'removeCart';

                $.ajax({
                    url: '<?php echo $this->Url->build([
                        'controller' => 'users',
                        'action'     => 'updateCheckOut',
                    ]); ?>',
                    data: {id: data, key: key},
                    type: 'POST',
                    error: function () {
                        alertMsgFrm('Wrong information', false);
                    },
                    success: function (data) {
                        var total = data.total.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.") + ' ₫';
                        $('#cart-content').html(data.render);
                        $('#price').text(total);
                        $('#num-product').text(data.countProduct);
                    },
                });
            });
        });
<?php echo $this->Html->scriptEnd(); ?>