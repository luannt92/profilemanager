<?php
$menuFooterHtml = null;
$linkFooterHtml = null;
if ($menuFooters) {
    foreach ($menuFooters as $menuFooter) {
        $url            = $this->Utility->isValidURL($menuFooter->url)
            ? $menuFooter->url : $language . $menuFooter->url;
        $menuFooterHtml .= "<li>";
        $menuFooterHtml .= $this->Html->link($menuFooter->name, $url);
        $menuFooterHtml .= "</li>";
    }
}

if ($menuLinks) {
    $linkFooterHtml     = $this->Link->buildLink($menuLinks, 16);
    $linkFooterMoreHtml = $this->Link->buildLink($menuLinks);
}

$mail = ! empty($settingInfo['site_mail'])
    ? $settingInfo['site_mail']
    : '';

$address = ! empty($settingInfo['site_address_' . $language])
    ? $settingInfo['site_address_' . $language]
    : '';

$facebook = ! empty($settingInfo['site_facebook'])
    ? $settingInfo['site_facebook']
    : '';

$android = ! empty($settingInfo['download_android'])
    ? $settingInfo['download_android']
    : '';

$ios    = ! empty($settingInfo['download_ios'])
    ? $settingInfo['download_ios']
    : '';
$column = ( ! empty($android) || ! empty($ios)) ? 'col-sm-3' : 'col-sm-4';
?>
<a href="javascript:void(0)" class="back-top">
    <?php echo $this->Html->image('arr-up.png', ['alt' => 'Top']); ?>
</a>
<div class="footer">
    <div class="container">
        <div class="row blocks-footer">
            <div class="block-footer block-address <?php echo $column; ?> col-xs-6">
                <h3><?php echo __(EMAIL); ?></h3>
                <?php if ( ! empty($address)) { ?>
                    <p>
                        <i class="fa fa-map-marker"></i>
                        <?php echo $address; ?>
                    </p>
                <?php } ?>
                <?php if ( ! empty($mail)) { ?>
                    <p>
                        <a href="mailto:<?php echo $mail; ?>">
                            <i class="fa fa-envelope"></i>
                            <?php echo $mail; ?>
                        </a>
                    </p>
                <?php } ?>
                <?php
                if ( ! empty($settingInfo['site_logo_footer'])) {
                    echo $this->Html->image($settingInfo['site_logo_footer'],
                        ['alt' => 'Register']);
                } ?>
            </div>
            <div class="block-footer block-cate col-sm-3 col-xs-6">
                <h3><?php echo __(CATEGORY); ?></h3>
                <ul>
                    <?php echo $menuFooterHtml; ?>
                </ul>
            </div>
            <?php if ( ! empty($android) || ! empty($ios)) { ?>
                <div class="block-footer block-app col-sm-3 col-xs-6">
                    <h3><?php echo __(DOWNLOAD_APP); ?></h3>
                    <span>
                    <?php
                    if ( ! empty($android)) {
                        echo $this->Html->link($this->Html->image('android.png',
                                ['alt' => __(DOWNLOAD) . ' Android'])
                            . $this->Html->tag('',
                                __(DOWNLOAD) . ' Android'),
                            $android,
                            ['target' => '_blank', 'escape' => false]);
                    } ?>
                </span>
                    <span>
                    <?php
                    if ( ! empty($ios)) {
                        echo $this->Html->link($this->Html->image('apple.png',
                                ['alt' => __(DOWNLOAD) . ' IOS'])
                            . $this->Html->tag('',
                                __(DOWNLOAD) . ' IOS'),
                            $ios,
                            ['target' => '_blank', 'escape' => false]);
                    } ?>
                </span>
                </div>
            <?php } ?>
            <div class="block-footer block-link col-sm-3 col-xs-6">
                <h3><?php echo __(LINK); ?></h3>
                <?php echo $linkFooterHtml;
                if (count($menuLinks) > 16) {
                    echo "<a class=\"more more-show\" href=\"\">"
                        . __("View more") . " >></a>";
                }
                ?>
            </div>
            <?php if (count($menuLinks) > 16) { ?>
                <div class="more-partners col-sm-4 col-xs-12">
                    <a class="close-more"></a>
                    <h3><?php echo __(LINK); ?></h3>
                    <?php echo $linkFooterMoreHtml; ?>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="footer-copyright text-center">
        <span>Copyright © <?php echo date('Y'); ?> Phu Quoc Delivery </span>
    </div>
</div>
<!-- footer -->
<div id="fb-root"></div>
<div id="cfacebook" class="messagebox">
    <a href="javascript:void(0);" class="chat_fb" onclick="return:false;"><i
                class="fa fa-comments-o"></i><?php echo __(SUPPORT_ONLINE); ?>
    </a>
    <div class="fchat">
        <div style="width:250px;" class="fb-page"
             data-href="<?php echo $facebook; ?>"
             data-tabs="messages"
             data-width="260"
             data-height="280"
             data-hide-cover="true"
             data-small-header="true">
            <div class="fb-xfbml-parse-ignore">
                <blockquote></blockquote>
            </div>
        </div>
    </div>
</div>