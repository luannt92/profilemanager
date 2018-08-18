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

<header>
    <div class="profile-page sidebar-collapse">
        <nav class="navbar navbar-expand-lg fixed-top navbar-transparent bg-primary"
             color-on-scroll="400">
            <div class="container">
                <div class="navbar-translate"><a class="navbar-brand" href="#"
                                                 rel="tooltip">Creative CV</a>
                    <button class="navbar-toggler navbar-toggler" type="button"
                            data-toggle="collapse" data-target="#navigation"
                            aria-controls="navigation" aria-expanded="false"
                            aria-label="Toggle navigation"><span
                                class="navbar-toggler-bar bar1"></span><span
                                class="navbar-toggler-bar bar2"></span><span
                                class="navbar-toggler-bar bar3"></span></button>
                </div>
                <div class="collapse navbar-collapse justify-content-end"
                     id="navigation">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link smooth-scroll"
                                                href="#about">About</a></li>
                        <li class="nav-item"><a class="nav-link smooth-scroll"
                                                href="#skill">Skills</a></li>
                        <li class="nav-item"><a class="nav-link smooth-scroll"
                                                href="#portfolio">Portfolio</a>
                        </li>
                        <li class="nav-item"><a class="nav-link smooth-scroll"
                                                href="#experience">Experience</a>
                        </li>
                        <li class="nav-item"><a class="nav-link smooth-scroll"
                                                href="#contact">Contact</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>