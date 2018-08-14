<?php
$carts           = $this->request->session()->read('cart');
$pay             = $this->request->session()->read('payment.pay');
$tracking_number = $this->request->session()->read('payment.tracking_number');
$feeship         = $this->request->session()->read('feeship');
$discount        = $this->request->session()->read('payment.discount');

$facebook  = ! empty($settingInfo['site_facebook'])
    ? $settingInfo['site_facebook'] : '';
$today     = date('H:i d-m-Y', time());
$userName  = ! empty($userInfo['full_name']) ? $userInfo['full_name'] : '';
$userMail  = ! empty($userInfo['email']) ? $userInfo['email'] : '';
$userPhone = ! empty($userInfo['phone_number']) ? $userInfo['phone_number']
    : '';
$note      = ! empty($userInfo['note']) ? $userInfo['note'] : '';
?>
<table class="table-content" cellpadding="0"
       cellspacing="0">
    <tr>
        <td>
            <img class="img-responsive"
                 src="<?php echo DOMAIN; ?>img/header.jpg"/>
        </td>
    </tr>

    <tr>
        <td class="content-block order">
            <h3>Mã đơn hàng<br>(Code): <p><?php echo $tracking_number; ?></p>
            </h3>
            <h3>Ngày đặt<br>(Order date): <p><?php echo $today; ?></p></h3>
            <h3>Tổng tiền<br>(Total payment): <p><?php echo number_format($pay,
                        0, '.',
                        ','); ?> VNĐ</p>
            </h3>
            <hr style="width: 100%;border: none;padding: 5px 0;"/>
            <p class="active">Địa chỉ nhận hàng (Shipping address):</p>
            <p>Người nhận(Full name): <?php echo $userName; ?> </p>
            <?php if ( ! empty($userMail)) { ?>
                <p>Email: <?php echo $userMail; ?> </p>
            <?php }
            if ( ! empty($userPhone)) { ?>
                <p><?php if ($userInfo['contact_type'] == WHATSAPP) {
                        echo __(WHATSAPP_TEXT);
                    } elseif ($userInfo['contact_type'] == VIBER) {
                        echo __(VIBER_TEXT);
                    } elseif ($userInfo['contact_type'] == ZALO) {
                        echo __(ZALO_TEXT);
                    } else {
                        echo 'Số điện thoại(Phone):';
                    } ?> : <?php echo $userPhone; ?>
                </p>
            <?php } ?>
            <p>Địa chỉ(Address):
                <?php
                if ($userInfo['address_type'] == HOTEL) {
                    echo $userInfo['address_room_number'] . ' - '
                        . $userInfo['name_hotel'];
                } else {
                    echo $userInfo['ward'] . ' - ' . $userInfo['area_order']
                        . ' - ' . number_format($feeship,
                            0, '.',
                            ',') . ' VNĐ';
                }
                ?>
            </p>
            <p>Hình thức thanh toán (Payment
                Method): <?php echo $userInfo['payment_method']; ?> </p>
            <?php if ( ! empty($note)) { ?>
                <p>Ghi chú (Note): <?php echo $note; ?> </p>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td class="content-block order text-notification">
            Đơn hàng đã được xử lý(The order has been processed)
        </td>
    </tr>

    <?php foreach ($carts as $cart): ?>
        <tr>
            <td class="content-block order list">
                <div class="product">
                    <p class="name"><?php echo $cart['name']; ?></p>
                    <p class="note"><?php echo $cart['promotion']; ?></p>
                    <p class="note"><?php echo $cart['displayOption']; ?></p>
                    <?php if ( ! empty($cart['product_note'])) { ?>
                    <p class="note">(Note: <?php echo $cart['product_note']; ?>)</p>
                    <?php } ?>
                </div>
                <div class="money"><?php echo number_format($cart['price']
                        + $cart['total_options'], 0,
                        '.', ','); ?> VNĐ <p>
                        x<?php echo $cart['quantity']; ?></p></div>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td class="content-block order list">
            <div class="product">
                <p class="name">Phí giao hàng(Shipping cost):</p>
            </div>
            <?php if ( ! empty($feeship)) { ?>
                <div class="money"><?php echo number_format($feeship, 0,
                        '.', ','); ?> VNĐ
                </div>
            <?php } else { ?>
                <div class="money">Liên hệ(Contact)</div>
            <?php } ?>
        </td>
    </tr>
    <?php if ( ! empty($discount)) { ?>
        <tr>
            <td class="content-block order list">
                <div class="product">
                    <p class="name">Giảm giá(Discounts):</p>
                </div>
                <div class="money"><?php echo number_format($discount, 0,
                        '.', ','); ?> VNĐ
                </div>
            </td>
        </tr>
    <?php } ?>
    <tr>
        <td class="content-block order list">
            <div class="product">
                <p class="name">Tổng tiền(Total payment):</p>
            </div>
            <div class="money"><?php echo number_format($pay, 0,
                    '.', ','); ?> VNĐ
            </div>
        </td>
    </tr>
    <tr>
        <td class="content-block order list" style="text-align: center">
            Theo dõi Phu Quoc Delivery để nhận thông tin khuyến mãi
            <p>(Follow Phu Quoc Delivery to receive promotional information)</p>
            <p><a href="<?php echo $facebook; ?>">
                    <img class="img-responsive"
                         src="<?php echo DOMAIN; ?>img/fb.png"/>
                </a></p>
        </td>
    </tr>
    <?php echo $content; ?>
</table>

