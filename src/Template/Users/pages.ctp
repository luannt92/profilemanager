<?php
$htmlRules = $htmlNav = $htmlLinkNav = "";
$clsCol    = "col-md-12";

if ( ! empty($menus)) {
    $arrMenus     = [];
    $clsCol       = "col-md-9";
    $activeAction = $this->request->getParam("pass");
    $url          = ["controller" => "Users", "action" => "pages"];
    $imgRules     = $this->Html->image("open.png");
    $htmlLinkNav  = $this->Html->link($imgRules, "#menucate",
        ["class" => "mobi-cate", "escape" => false]);
    $imgRules     .= __("Terms of use");
    $htmlNav
                  = "<div class=\"col-md-3\"><div class=\"toolbar-cate\">
                     <span>{$imgRules}</span></div></div>";
    $htmlRules
                  .= "<div class=\"col-xs-12 col-md-3 left-content\">
                  <div class=\"sidebar-left\" id=\"sidebar-left\"><div class=\"sidebar-left-cate\">";
    $htmlRules    .= $this->Utility->buildMenu($menus, $activeAction, $url,
        "list-pages");
    $htmlRules    .= "</div></div></div>";
}

$htmlNav
    .= "<div class=\"{$clsCol}\"><div class=\"toolbar-list\">{$htmlLinkNav}
            <span>{$page["title"]}</span></div></div>";

?>
<div class="container">
    <div class="row submenunav">
        <div class="subnav-wrapper">
            <?php echo $htmlNav; ?>
        </div>
    </div>
    <div class="row content-restaurants">
        <nav id="menucate"></nav>
        <?php echo $htmlRules; ?>
        <!-- left-content -->
        <div id="main-content"
             class="main-content col-xs-12 col-xs-12 <?php echo $clsCol; ?>">
            <div id="content-list" class="content-list">
                <div class="content-area-view grid">
                    <div class="content-clause">
                        <?php echo $page["content"]; ?>
                    </div>
                </div>
                <!-- content-area-view -->
            </div>
            <!-- content-list -->
        </div>
        <!-- main-content -->
    </div>
</div>
