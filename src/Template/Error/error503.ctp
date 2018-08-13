<?php
$this->layout = 'error';
?>
<div class="error5">
    <div class="text-center">
        <div class="err5img">
            <?php echo $this->Html->image('err500.png',
                ['alt' => '503 : Service Unavailable.']); ?>
        </div>
        <div class="err5text">
            <h2>Xin lỗi bạn, đây là lỗi của chúng tôi!</h2>
            <p>Máy chủ của LUCKY STAR TRAVEL đang gặp sự cố. <br>
                Phiền bạn khởi động lại trang nhé!!!
            </p>
        </div>
    </div>
</div>