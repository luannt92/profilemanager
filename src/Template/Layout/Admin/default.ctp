<?php
use Cake\Routing\Router;
?>
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
            'admin/plugins/toastr/toastr.min.css',
            'admin/bootstrap-datepicker3.min.css',
            'admin/plugins/footable/footable.core.css',
            'admin/plugins/validate/bootstrapValidator.min.css',
            'admin/plugins/select2/select2.min.css',
            'admin/jquery.fancybox.min.css',
            'admin/plugins/iCheck/custom.css',
            'admin/animate.css',
            'admin/style.css',
        ],
        ['block' => true]
    );
    echo $this->fetch('meta');
    echo $this->fetch('css');
    ?>
</head>
<?php
$class = null;
if($this->request->getParam('controller') === 'MailTemplates' && $this->request->getParam('action') === 'index') {
    $class = 'fixed-sidebar no-skin-config full-height-layout';
}
?>
<body class="<?php echo $class; ?>">
<div id="wrapper">
    <?php echo $this->Flash->render(); ?>
    <?php echo $this->element('Admin/sideMenu'); ?>
    <div id="page-wrapper" class="gray-bg">
        <?php echo $this->element(
            'Admin/header', [], [
//            "cache"     => "long_view",
//            "callbacks" => true
            ]
        ); ?>
        <?php echo $this->fetch('content'); ?>
        <?php echo $this->element(
            'Admin/footer', [], [
//            "cache"     => "long_view",
//            "callbacks" => true
            ]
        ); ?>
    </div>
</div>
<!-- Mainly scripts -->
<script>
    var appConfig = {
        baseUrl: "<?php echo Router::url('/', true); ?>",
        template:[],
        sec: "<?php echo FILE_ACCESS_KEY; ?>"
    };
</script>
<?php
echo $this->element('Admin/loading', [], [
//    "cache"     => "long_view",
//    "callbacks" => true,
]);
echo $this->Html->script(
    [
        'admin/jquery-3.1.1.min.js',
        'admin/bootstrap.min.js',
        'admin/moment.js',
        'admin/bootstrap-datepicker.min.js',
        'admin/plugins/metisMenu/jquery.metisMenu.js',
        'admin/plugins/slimscroll/jquery.slimscroll.min.js',
        'admin/plugins/footable/footable.all.min.js',
        'admin/plugins/validate/bootstrapValidator.min.js',
        'admin/plugins/select2/select2.full.min.js',
        'admin/jquery.fancybox.min.js',
    ]
);
echo $this->fetch('scriptBottom');
echo $this->Html->script(
    [
        'admin/inspinia.js',
        'admin/plugins/pace/pace.min.js',
        'admin/plugins/toastr/toastr.min.js'
    ]
);
echo $this->fetch('script');
?>
</body>
</html>
