<?php
$total_cart = $this->request->session()->read('payment.total');
$pay_cart   = $this->request->session()->read('payment.pay');
$sale_cart  = $this->request->session()->read('payment.discount');
$ship_cart  = $this->request->session()->read('feeship');
?>
<hr>
<div class="col-xs-12 total-cart">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-6">
                <span><?php echo __('Total'); ?>:</span>
            </div>
            <div class="col-xs-6 text-right">
                <span>
                    <?php
                    echo $this->Number->format($total_cart,
                        [
                            'places' => 0,
                            'after'  => ' <u>đ</u>',
                            'escape' => false,
                        ]);
                    ?>
                </span>
            </div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-6">
                <span><?php echo __('Shipping cost'); ?>:</span>
            </div>
            <div id="feeShipping"
                 class="col-xs-6 text-right">
                    <span>
                        <?php
                        if ( ! empty($ship_cart)) {
                            echo $this->Number->format($ship_cart,
                                [
                                    'places' => 0,
                                    'after'  => ' <u>đ</u>',
                                    'escape' => false,
                                ]);
                        } else {
                            echo __('Contact');
                        }
                        ?>
                    </span>
            </div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-6">
                <span><?php echo __('Discounts'); ?>:</span>
            </div>
            <div id="checkout_sale"
                 class="col-xs-6 text-right">
                <span>
                    <?php
                    echo $this->Number->format($sale_cart,
                        [
                            'places' => 0,
                            'after'  => ' <u>đ</u>',
                            'escape' => false,
                        ]);
                    ?>
                </span>
            </div>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-6">
                <span>
                    <strong><?php echo __('Total'); ?>:</strong>
                </span>
            </div>
            <div id="checkout_pay"
                 class="col-xs-6 text-right">
                    <span>
                        <strong>
                            <?php
                            echo $this->Number->format($pay_cart,
                                [
                                    'places' => 0,
                                    'after'  => ' <u>đ</u>',
                                    'escape' => false,
                                ]);
                            ?>
                        </strong>
                    </span>
            </div>
        </div>
    </div>
    <div class="col-xs-12">
        <?php echo $this->Html->link(__(CHECKOUT_BUTTON_CONTINUTE),
            [
                'controller' => 'services',
                'action'     => 'index',
            ], ['class' => 'btn btn-contcart']); ?>
    </div>
</div>