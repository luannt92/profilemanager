<?php if ( ! empty($sliders)) {
    $htmlIndicators = null;
    $htmlInners     = null;
    $i              = 0;

    foreach ($sliders as $slider) {
        $active         = ($i == 0) ? "active" : "";
        $htmlIndicators .= "<li data-target=\"#myCarousel\" data-slide-to=\"$i\" class=\"$active\"></li>";

        $htmlInners .= "<div class=\"item $active\">";
        $image      = $this->Html->image($slider['image'],
            ['alt' => $slider['title'], 'escape' => false, 'class' => 'slider-img']);
        $fancybox   = ($slider['type'] == SLIDER_VIDEO) ? "data-fancybox" : "";
        $spanPlay = ($slider['type'] == SLIDER_VIDEO) ? "<span class='icon-play'><i class=\"fa fa-play\"></i></span>" : "";
        $image      = empty($slider['url']) ? $image
            : $this->Html->link($spanPlay.$image, $slider['url'],
                ['escape' => false, $fancybox]);
        $htmlInners .= $image;
        $htmlInners .= "</div>";
        $i++;
    }

    ?>
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php echo $htmlIndicators; ?>
        </ol>
        <div class="carousel-inner">
            <?php echo $htmlInners; ?>
        </div>
        <a class="carousel-control left" href="#myCarousel" data-slide="prev">
            <span class="icon-prev fa fa-chevron-left"></span>
        </a>
        <a class="carousel-control right" href="#myCarousel" data-slide="next">
            <span class="icon-next fa fa-chevron-right"></span>
        </a>
    </div>
<?php } ?>