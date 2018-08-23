<?php
$this->Form->setTemplates(
    [
        'submitContainer' => '{{content}}',
    ]
);
$menuHeaderHtml = null;
if ( ! empty($menuHeaders)) {
    foreach ($menuHeaders as $menuHeader) {
//        $url            = $this->Utility->isValidURL($menuHeader->url)
//            ? $menuHeader->url : '/' . $language . $menuHeader->url;
        $url            = $menuHeader->url;
        $menuHeaderHtml .= "<li class='nav-item'>";
        $menuHeaderHtml .= $this->Html->link($menuHeader->name,
            $url, ['class' => 'nav-link smooth-scroll']);
        $menuHeaderHtml .= "</li>";
    }
}
$userInfo = $this->request->getSession()->read('Auth.User');
?>

<header>
    <div class="profile-page sidebar-collapse">
        <nav class="navbar navbar-expand-lg fixed-top navbar-transparent bg-primary"
             color-on-scroll="400">
            <div class="container">
                <div class="navbar-translate"><a class="navbar-brand" href="#"
                                                 rel="tooltip"><?php echo $settingInfo['site_name']; ?></a>
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
                        <?php echo $menuHeaderHtml; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>