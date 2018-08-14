<?php
$this->Form->setTemplates(
    [
        'submitContainer' => '{{content}}',
    ]
);
$menuHeaderHtml = null;
if ( ! empty($menuHeaders)) {
    foreach ($menuHeaders as $menuHeader) {
        $url            = $this->Utility->isValidURL($menuHeader->url)
            ? $menuHeader->url : '/' . $language . $menuHeader->url;
        $active         = ($this->request->here() === $url)
            ? 'active' : '';
        $menuHeaderHtml .= "<li class='{$active}'>";
        $menuHeaderHtml .= $this->Html->link($menuHeader->name,
            $url);
        if ($menuHeader->children) {
            $countChildren  = count($menuHeader->children);
            $classUl        = ($countChildren > 3) ? 'submenu' : '';
            $menuHeaderHtml .= "<ul class=\"$classUl\">";
            foreach ($menuHeader->children as $children) {
                $urlChild       = $this->Utility->isValidURL($children->url)
                    ? $children->url : $language . $children->url;
                $clsIcon        = empty($children->icon) ? '' : $children->icon;
                $menuHeaderHtml .= "<li class=\"service {$clsIcon}\">";
                $menuHeaderHtml .= $this->Html->link("<span>$children->name</span>",
                    $urlChild, ['escape' => false]);
                $menuHeaderHtml .= "</li>";
            }
            $menuHeaderHtml .= "</ul>";
        }
        $menuHeaderHtml .= "</li>";
    }
}

$mail     = ! empty($settingInfo['site_mail'])
    ? $settingInfo['site_mail']
    : '';
$facebook = ! empty($settingInfo['site_facebook'])
    ? $settingInfo['site_facebook']
    : '#';

$time_open = ! empty($settingInfo['time_open'])
    ? date('H:i', strtotime($settingInfo['time_open']))
    : '';

$time_close = ! empty($settingInfo['time_close'])
    ? date('H:i', strtotime($settingInfo['time_close']))
    : '';

$urlLogin         = $this->Url->build([
    'controller' => 'Users',
    'action'     => 'login',
    'language'   => $language,
]);
$userInfo         = $this->request->session()->read('Auth.User');
$languageSelected = ($language == 'en') ? 'English' : 'Vietnamese';
$countrySelected  = ($language == 'en') ? 'locale-lang-en' : 'locale-lang-vn';
$here = $this->request->here();
$currentUrl = !in_array($here, ['/vi', '/en']) ? str_replace(['/vi/', '/en/'], '/', $here) : '';
$eventTopHeader = "";
if ( ! empty($settingInfo['site_sale_off_' . $language])) {
    $link           = empty($settingInfo['site_sale_off_link_' . $language])
        ? 'javascript:void(0);'
        : $settingInfo['site_sale_off_link_' . $language];
    $eventTopHeader = $this->Html->link($settingInfo['site_sale_off_'
    . $language], $link, ['class' => 'text']);
}
?>
<nav id="menu-mobi"></nav>
<div class="header">
    <div class="header-top container">
        <div class="row">
            <div class="col-sm-6 header-top-left">
                    <?php
                    if (!empty($time_open)) { ?>
                    <span><?php echo $this->Html->image('wallclock.png', ['alt' => 'Time', "class" => "open-time"]) . $time_open. ' - ' .$time_close; ?></span>
                    <?php }
                    ?>
                <?php echo $this->Html->link('<i class="fa fa-facebook-f"></i>',
                    $facebook, [
                        'class'  => 'fb-like',
                        'target' => '_blank',
                        'escape' => false,
                    ]); ?>
                <?php echo $eventTopHeader; ?>
            </div>
            <div class="col-sm-6 header-top-right">
                <div class="right-top">
                        <span class="dropdown" id="locale">
                           <a href="javascript:void(0)"
                              class="btn-icon caret-icon <?php echo $countrySelected; ?>"
                              id="change-language">
                              <?php echo $languageSelected; ?><span
                                       class="caret-span"></span></a>
                           <ul class="dropdown-menu language" id="language">
                              <li><a id="lang-vn"
                                     href="/vi<?php echo $currentUrl; ?>"><span
                                              class="lang lang-vn"></span>Vietnamese</a></li>
                              <li><a id="lang-en"
                                     href="/en<?php echo $currentUrl; ?>"><span
                                              class="lang lang-en"></span>English</a></li>
                           </ul>
                        </span>
                    <?php if ( ! empty($userInfo)) { ?>
                        <div class="img-user" id="img-user">
                            <a href="javascript:void(0)">
                                <?php echo $this->Html->image('user.png'); ?>
                                <?php echo __(HELLO); ?></a>
                            <span class="title-hiden"><?php echo $userInfo['full_name']; ?></span>
                            <ul class="profile">
                                <li><?php
                                    echo $this->Html->link(
                                        __(MY_ACCOUNT),
                                        [
                                            'controller' => 'Users',
                                            'action'     => 'account',
                                            'language'   => $language,
                                        ]
                                    ); ?>
                                </li>
                                <li>
                                    <?php
                                    echo $this->Html->link(
                                        __(LOGOUT),
                                        [
                                            'controller' => 'Users',
                                            'action'     => 'logout',
                                            'language'   => $language,
                                        ]
                                    );
                                    ?>
                                </li>
                            </ul>
                        </div>
                    <?php } else { ?>
                        <div class="img-user">
                            <a data-target="#myLogin"
                               href="<?php echo $urlLogin; ?>"
                               data-toggle="modal">
                                <?php echo $this->Html->image('user.png',
                                    ['alt' => __(LOGIN)]); ?><?php echo __(LOGIN); ?>
                            </a>
                        </div>
                    <?php } ?>
                    <?php
                    $action = $this->request->getParam('action');
                    $controller = $this->request->getParam('controller');
                    if (in_array($controller, ['Stores']) || in_array($action, ['checkOut'])) {
                        // do nothing
                    } else {
                        echo $this->element('Front/Order/modalCart');
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="header-menu">
        <div class="container">
            <div class="header-mobi">
                <a href="#menu-mobi" class="display-menu"><i
                            class="fa fa-bars"></i></a>
            </div>
            <nav class="navbar">
                <div class="logo" id="logo">
                    <?php echo $this->Html->image('logo.png', [
                        'alt' => 'Phu Quoc Delivery',
                        'url' => '/' . $language,
                    ]); ?>
                </div>
                <div class="collapse navbar-collapse" id="menu">
                    <ul class="nav navbar-nav navbar-right">
                        <?php echo $menuHeaderHtml; ?>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</div>