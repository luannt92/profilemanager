<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'PhuQuoc Delivery'; ?></title>
    <?php echo $this->Html->css(
        [
            'admin/bootstrap.min.css',
            'admin/font-awesome.css',
            'admin/plugins/toastr/toastr.min.css',
            'admin/animate.css',
            'admin/style.css',
        ],
        ['block' => true]
    );
    echo $this->fetch('meta');
    echo $this->fetch('css');
    ?>
</head>
<body class="gray-bg">
<div class="loginColumns animated fadeInDown">
    <div class="row">
        <?php echo $this->element(
            'Admin/Login/welcome', [], [
                "cache"     => "long_view",
                "callbacks" => true,
            ]
        ); ?>
        <div class="col-md-6">
            <div class="ibox-content">
                <?php echo $this->fetch('content'); ?>
                <p class="m-t error-message">
                    <?php echo $this->Flash->render(); ?>
                </p>
            </div>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6 text-right">
            <small>PhuQuocDelivery © <?php echo date('Y'); ?></small>
        </div>
    </div>
</div>
<!-- Mainly scripts -->
<?php
echo $this->Html->script(
    [
        'admin/jquery-3.1.1.min.js',
        'admin/plugins/toastr/toastr.min.js',
    ]
);
echo $this->fetch('script');
?>
</body>
</html>
