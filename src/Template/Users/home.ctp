<?php
$servicesHtml    = null;
$ourServicesHtml = null;

if ( ! empty($services)) {
    foreach ($services as $service) {
        $storeSlug = !empty($service['stores']['0']['slug']) ? $service['stores']['0']['slug'] : '';
        $servicesHtml .= "<div class=\"col-md-3 col-xs-6\"><div class=\"blockmenu\">";
        $servicesHtml .= $this->Html->link($this->Html->image($service['icon'],
                ['alt' => $service['name']]) . $this->Html->tag('span',
                $service['name']),
            [
                'controller' => $service['layout_type'] == LAYOUT_SERVICE ? 'services' : 'stores',
                'action'     => 'view',
                $slug = $service['layout_type'] == LAYOUT_SERVICE ? $service['slug'] : $storeSlug,
            ],
            ['escape' => false]);
        $servicesHtml .= "</div></div>";
    }
}

if ( ! empty($ourServices)) {
    foreach ($ourServices as $ourService) {
        $ourServicesHtml .= "<div class=\"col-md-4 col-xs-6 block-col\"><div class=\"block-item\">";
        $ourServicesHtml .= "<div>";
        $ourServicesHtml .= $this->Html->image($ourService['icon'],
            ['alt' => $ourService['title']]);
        $ourServicesHtml .= "</div>";
        $ourServicesHtml .= "<h3>" . $ourService['title'] . "</h3>";
        $ourServicesHtml .= "<p>";
        $ourServicesHtml .= $ourService['description'];
        if ( ! empty($ourService['url'])) {
            $ourServicesHtml .= "<br>" . $this->Html->link(__('View detail'),
                    $ourService['url']);
        }
        $ourServicesHtml .= "</p>";
        $ourServicesHtml .= "</div></div>";
    }
}

if ( ! empty($settingInfo['site_banner_popup'])) {
    $banner   = $settingInfo['site_banner_popup'];
    $link     = ! empty($settingInfo['site_banner_popup_link'])
        ? $settingInfo['site_banner_popup_link'] : "";
    $tracking = ! empty($settingInfo['site_tracking_popup'])
        ? $settingInfo['site_tracking_popup'] : "";
    echo $this->element('Front/popup', compact('banner', 'link', 'tracking'));
}
?>
<div class="blockmenu-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <?php echo $servicesHtml; ?>
            </div>
        </div>
    </div>
</div>
<!-- blockmenu-content -->
<div class="block-content">
    <div class="container">
        <div class="row text-center">
            <h2 class="block-title"><?php echo __(HOW_TO_USE_SERVICE); ?></h2>
        </div>
        <div class="row">
            <?php echo $ourServicesHtml; ?>
        </div>
    </div>
</div>