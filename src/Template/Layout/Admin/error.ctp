<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $this->fetch('title'); ?></title>
    <?php echo $this->Html->css(
        [
            'admin/bootstrap.min.css',
            'admin/font-awesome.css',
            'admin/animate.css',
            'admin/style.css'
        ],
        ['block' => true]
    );
    echo $this->fetch('meta');
    echo $this->fetch('css');
    ?>
</head>
<body class="gray-bg">
<div class="middle-box text-center animated fadeInDown">
    <?php echo $this->Flash->render(); ?>

    <?php echo $this->fetch('content'); ?>
</div>
<?php
echo $this->Html->script(
    [
        'admin/jquery-3.1.1.min.js',
        'admin/bootstrap.min.js',
    ]
);
?>
</body>
</html>