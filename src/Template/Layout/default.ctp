<?php
$titleSeo    = ! empty($settingInfo['meta_title_' . $language]) ? $settingInfo['meta_title_' . $language]
    : '';
$title       = isset($meta_title) ? $meta_title : $titleSeo;
$descriptionSeo = ! empty($settingInfo['meta_description_' . $language])
    ? $settingInfo['meta_description_' . $language] : '';
$description = isset($meta_description) ? $meta_description : $descriptionSeo;
$keywordSeo     = ! empty($settingInfo['meta_keyword_' . $language])
    ? $settingInfo['meta_keyword_' . $language] : '';
$keyword     = isset($meta_keyword) ? $meta_keyword : $keywordSeo;
$url         = $this->Url->build($this->request->here(), true);
$creator     = $this->Url->build('/', true);
$orgImage    = $url . 'img/logo.png';
$googleAnalytics = ! empty($settingInfo['site_tag']) ? $settingInfo['site_tag'] : '';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php echo $title; ?></title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <meta name="robots" content="index, follow"/>
    <meta name="dc.creator" content="<?php echo $creator; ?>"/>
    <meta name="dc.title" content="<?php echo $title; ?>"/>
    <meta property="og:type" content="website"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <link rel="canonical" href="<?php echo $url; ?>"/>
    <meta name="description" content="<?php echo $description; ?>"/>
    <meta name="keywords" content="<?php echo $keyword; ?>">
    <link rel="alternate" href="<?php echo $url; ?>"/>
    <meta property="og:url" content="<?php echo $url; ?>"/>
    <meta property="og:image" content="<?php echo $orgImage; ?>"/>
    <meta property="og:title" content="<?php echo $title; ?>"/>
    <meta property="og:description" content="<?php echo $description; ?>"/>
    <?php echo $this->Html->css(
        [
            'bootstrap.min.css',
            'bootstrapValidator.min.css',
            'font-awesome.min.css',
            'mmenu-all.css',
            'toastr/toastr.min.css',
            'intlTellnInput.css',
            'select2.min.css',
            'style.css',
            'media-style.css',
            'jquery.fancybox.min.css'
        ],
        ['block' => true]
    );
    echo $this->fetch('meta');
    echo $this->fetch('css');
    ?>
    <style type="text/css">
        .error-message {
            color: #e22c26;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <?php echo $this->element('Front/header', [], [
//        "cache"     => "long_view",
//        "callbacks" => true,
    ]); ?>
    <div class="clearfix"></div>
    <?php echo $this->element('Front/slider', [], [
//            "cache"     => "long_view",
//            "callbacks" => true,
    ]); ?>
    <?php echo $this->fetch('content'); ?>
    <!-- block-content -->
    <!-- content -->
    <div class="clearfix"></div>
    <?php echo $this->element('Front/footer', [], [
//        "cache"     => "long_view",
//        "callbacks" => true,
    ]); ?>
</div>
<?php echo $this->Flash->render(); ?>
<!-- wrapper -->
<?php
echo $this->element('Front/loading', [], [
        "cache"     => "long_view",
        "callbacks" => true,
]);
echo $this->element('Front/modal', [], [
    "cache"     => "long_view",
    "callbacks" => true,
]);
?>

<script>
    var appConfig = {
        baseUrl: "<?php echo $this->Url->build('/', true); ?>",
        language: "<?php echo $language; ?>",
        code: "<?php echo $languageText; ?>",
        titleMsg: "<?php echo __(MESSAGE); ?>",
        updateMsg: "<?php echo __('Save success'); ?>",
        msg: {
            display: "<?php echo __('Display'); ?>",
            less: "<?php echo __('See less'); ?>",
            more: "<?php echo __('See more'); ?>",
        },
    };

</script>
<?php
echo $this->Html->script(
    [
        'jquery.min.js',
        'bootstrap.min.js',
        'lazyload.min.js',
        'validator.min.js',
        'mmenu.min.all.js',
        'toastr/toastr.min.js',
        'intlTelInput.js',
        'app.js',
        'select2.min.js',
        'jquery.fancybox.min.js'
    ]
);
echo $googleAnalytics;
echo $this->fetch('scriptBottom');
echo $this->fetch('script');
?>
<script>
    function alertMsgFrm(message, success) {
        setTimeout(function () {
            toastr.options = {
                closeButton: true,
                preventDuplicates: true,
                progressBar: true,
                showMethod: 'slideDown',
                timeOut: 2000
            };
            if (success) {
                toastr.success(message, appConfig.titleMsg);
            } else {
                toastr.error(message, appConfig.titleMsg);
            }
        }, 500);
    }
</script>
</body>
</html>
