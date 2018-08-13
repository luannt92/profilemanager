<?php
$titleSeo    = ! empty($settingInfo['seo_title']) ? $settingInfo['seo_title']
    : '';
$title       = isset($title) ? $title : $titleSeo;
$description = ! empty($settingInfo['seo_description'])
    ? $settingInfo['seo_description'] : '';
$keyword     = ! empty($settingInfo['seo_keyword'])
    ? $settingInfo['seo_keyword'] : '';
$url         = $this->Url->build('/', true);
$creator     = trim($url, 'http://');
$orgImage    = $url . 'img/know.png';
$tag         = ! empty($settingInfo['site_tag']) ? $settingInfo['site_tag']
    : '';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Travel</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <?php echo $this->Html->css(['main.min.css',], ['block' => true]);
    echo $this->fetch('meta');
    echo $this->fetch('css');
    ?>
</head>
<body>
<?php echo $this->element('Front/header'); ?>
<?php echo $this->element('Front/slider'); ?>
<div id="wrapper">
    <?php echo $this->Flash->render(); ?>
    <?php echo $this->fetch('content'); ?>
    <!--    --><?php //echo $this->element('Front/supportPartner'); ?>
</div>
<?php echo $this->element('Front/footer'); ?>
<?php
echo $this->Html->script(
    [
        'main.min.js',
    ]
);
echo $this->fetch('scriptBottom');
echo $this->fetch('script');
?>
</body>
</html>
