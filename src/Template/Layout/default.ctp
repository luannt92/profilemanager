<?php
$titleSeo        = ! empty($settingInfo['meta_title_' . $language])
    ? $settingInfo['meta_title_' . $language]
    : '';
$title           = isset($meta_title) ? $meta_title : $titleSeo;
$descriptionSeo  = ! empty($settingInfo['meta_description_' . $language])
    ? $settingInfo['meta_description_' . $language] : '';
$description     = isset($meta_description) ? $meta_description
    : $descriptionSeo;
$keywordSeo      = ! empty($settingInfo['meta_keyword_' . $language])
    ? $settingInfo['meta_keyword_' . $language] : '';
$keyword         = isset($meta_keyword) ? $meta_keyword : $keywordSeo;
$url             = $this->Url->build($this->request->getRequestTarget(), true);
$creator         = $this->Url->build('/', true);
$orgImage        = $url . 'img/logo.png';
$googleAnalytics = ! empty($settingInfo['site_tag']) ? $settingInfo['site_tag']
    : '';
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

    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200"
          rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css"
          rel="stylesheet">
    <?php echo $this->Html->css(
        [
            'aos.css',
            'bootstrap.min.css',
            'main.css',
        ],
        ['block' => true]
    );
    echo $this->fetch('meta');
    echo $this->fetch('css');
    ?>
</head>
<body id="top">
<?php echo $this->element('Front/header', [], [
//        "cache"     => "long_view",
//        "callbacks" => true,
]); ?>
<?php echo $this->fetch('content'); ?>
<?php echo $this->element('Front/footer', [], [
//        "cache"     => "long_view",
//        "callbacks" => true,
]); ?>
<?php
echo $this->Html->script(
    [
        'core/jquery.3.2.1.min.js',
        'core/popper.min.js',
        'core/bootstrap.min.js',
        'now-ui-kit.js?v=1.1.0',
        'aos.js',
        'main.js',
    ]
);
echo $googleAnalytics;
echo $this->fetch('scriptBottom');
echo $this->fetch('script');
?>
</body>
</html>
